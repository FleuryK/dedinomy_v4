<?php
class Tools
{
    public static function redirect($url)
    {
        header('Location: '.$url);exit();
    }
}