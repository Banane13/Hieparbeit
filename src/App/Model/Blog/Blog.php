<?php
namespace App\Model\Blog;

use App\Model\Database\DbBasis;

class Blog extends DbBasis
{
    public function loadData()
    {
        $dbqObject = $this->getDbqObject();

        $data = [];
        $sql = "SELECT id, uuid, author, date, title, intro, text FROM blog ";
        $dbqObject->query($sql);
        $i = 0;
        while ($row = $dbqObject->nextRow()) {
            $data[] = $row;
            $i++;
        }

        return $data;
    }

    public function loadSpecificEntry($id)
    {
        $dbqObject = $this->getDbqObject();

        $data = ['id' => $id];

        $sql = "SELECT id, uuid, author, date, title, intro, text FROM blog WHERE id = :id LIMIT 1 ";
        $dbqObject->query($sql, $data);
        return $dbqObject->nextRow();
    }

    public function saveData($data)
    {

        $dbqObject = $this->getDbqObject();

        $entry = $this->loadSpecificEntry($data['id']);
        if ($entry == false || count($entry) <= 0) {
            $sql = "INSERT INTO blog (id,  uuid,author,date,title,intro, text)
                              VALUES (:id, :uuid, :author, :date, :title, :intro, :text)";
        } else {
            $sql = "UPDATE blog  SET 'uuid' = :uuid, 'author' = :author, 'date' = :date, 'title' = :title,
                    'intro' = :intro, 'text' = :text WHERE id = :id ";
        }

        $dataSql = [];
        $dataSql['id'] = intval($data['id'], 10);
        $dataSql['uuid'] = $data['uuid'];
        $dataSql['author'] = $data['author'];
        $dataSql['date'] = $data['date'];
        $dataSql['title'] = $data['title'];
        $dataSql['intro'] = $data['intro'];
        $dataSql['text'] = $data['text'];
        $dbqObject->query($sql, $dataSql);
    }
}