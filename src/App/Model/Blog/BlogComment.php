<?php

namespace App\Model\Blog;

use App\Model\Database\DbBasis;

class BlogComment extends DbBasis
{

    public $blogId = null;


    public function __construct($config, $blogId)
    {
        parent::__construct($config);
        $this->blogId = intval($blogId, 10);
    }

    public function getComment()
    {
        $dbqObject = $this->getDbqObject();

        $data = [];
        $sqlData = ['BId' => $this->blogId];
        $query = "SELECT text, title, BId, name,createDate, changeDate FROM blogComment WHERE BId=:BId ";

        $dbqObject->query($query, $sqlData);

        $i = 0;
        while ($row = $dbqObject->nextRow()) {
            $data[] = $row;
            $data[$i]['createDate'] = date('d.m.Y H:i', strtotime($row['createDate']));
            $i++;
        }

        return $data;
    }


    public function saveData($data)
    {
        $dbqObject = $this->getDbqObject();
        $currentDate = new \DateTime();
        $createDate = $currentDate->format('Y-m-d H:i:s');
        $sqlData = [
            'BId' => $data['BId'],
            'title' => $data['title'],
            'text' => $data['text'],
            'name' => $data['name'],
            'createDate' => $createDate,
            'changeDate' => $createDate
        ];

        $insert = "INSERT INTO blogComment ( 'title', 'text','BId','name','createDate','changeDate') 
                   VALUES (:title, :text, :BId, :name, :createDate, :changeDate)";
        $dbqObject->query($insert, $sqlData);
    }

    public function checkErrors($formData)
    {
        $formError = [];

        if ($formData['name'] != '') {
            $formError['name'] = 'Name ist falsch.';
        }
        if ($formData['title'] != '') {
            $formError['title'] = 'Titel ist falsch.';
        }
        if ($formData['text'] != '') {
            $formError['text'] = 'Text ist falsch.';
        }
        return $formError;
    }
}