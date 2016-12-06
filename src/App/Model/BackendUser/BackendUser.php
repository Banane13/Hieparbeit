<?php

namespace App\Model\BackendUser;

use App\Helper\Session;
use App\Model\Database\DbBasis;

class BackendUser extends DbBasis
{
    private static $sessionName = 'userid';

    public function getUserByName($username)
    {
        $sql = 'SELECT * FROM backendUser WHERE username = :username LIMIT 1';
        $dbq_object = $this->getDbqObject();
        $dbq_object->query($sql, ['username' => $username]);
        $user = $dbq_object->nextRow();
        return $user;
    }

    public function getUserById($buId)
    {
        $sql = 'SELECT * FROM backendUser WHERE BUId = :BUId LIMIT 1';
        $dbq_object = $this->getDbqObject();
        $dbq_object->query($sql, ['BUId' => $buId]);
        $user = $dbq_object->nextRow();
        return $user;
    }

    public static function getSessionName()
    {
        return self::$sessionName;
    }


    public function checkErrors($formData)
    {
        $formError = [];
        $user = $this->getUserByName($formData['username']);

        if ($user !== false && password_verify($formData['password'], $user['password'])) {
            Session::setSession(self::getSessionName(), $user['BUId']);
        } else {
            $formError['usernamePassword'] = 'Der Username oder das Passwort ist ungültg.';
        }

        return $formError;
    }

    public static function generateHashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }


    public function saveData($data)
    {
        $dbqObject = $this->getDbqObject();
        $currentDate = new \DateTime();
        $createDate = $currentDate->format('Y-m-d H:i:s');

        $sqlData = [
            'username' => $data['username'],
            'password' => BackendUser::generateHashPassword($data['password']),
            'createDate' => $createDate,
            'changeDate' => null,
            'loginDate' => null,
            'privilege' => $data['privilege']
        ];
        $insert = "INSERT INTO backendUser ( 'username', 'password','createDate','changeDate','loginDate','privilege') 
                   VALUES (:username, :password, :createDate, :changeDate, :loginDate, :privilege)";
        $dbqObject->query($insert, $sqlData);
    }
}