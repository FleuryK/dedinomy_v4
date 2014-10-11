<?php
class Session
{
    public static function init()
    {
        session_start();
    }
    public static function exist($tab)
    {
        if(isset($_SESSION['dedinomy'][$tab])) return true; else return false;
    }
    public static function set($tab,$data)
    {
        $_SESSION['dedinomy'][$tab]=$data;
        return true;
    }
    public static function get($tab)
    {
        if(isset($_SESSION['dedinomy'][$tab]))
        {
            return $_SESSION['dedinomy'][$tab];
        }
        else return false;
    }
    public static function delete($tab)
    {
        unset($_SESSION['dedinomy'][$tab]);
        return true;
    }
    public static function destroy()
    {
        unset($_SESSION['dedinomy']);
        session_unset();
        session_destroy();
        return true;
    }
}