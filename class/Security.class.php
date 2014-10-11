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
}