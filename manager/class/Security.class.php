<?php
class Security
{
    public static function sanitize($string)
    {
        if(ctype_digit($string))
        {
            $string = intval($string);
        }
        else
        {
            //$string = mysql_real_escape_string($string); //Deprecated !!
            $string = addcslashes($string, '%_');
            $string = htmlentities($string);
        }
        return $string;
    }
    public static function is_admin()
    {
        global $userdata,$settings;
        if($userdata->niveau==1) return true; else exit(utf8_encode($settings->erreur_mod));
    }
}