<?php
namespace App\Helper;

class Session
{
    public static function startSession()
    {
        session_start();
    }

    public static function getSessionByKey($key)
    {
        if (!isset($_SESSION[$key])) {
            return false;
        }
        return $_SESSION[$key];
    }

    public static function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function removeSession()
    {
        session_destroy();
    }

}