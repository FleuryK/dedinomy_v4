<?php
class Tools
{
    public static function notification()
    {
        $datavalid=Sql::getAll("SELECT * FROM ".text);
        $nbvalid = 0;
        foreach($datavalid as $data)
        {
            if ( $data->val == "0")
            {
                $nbvalid++;
            }
        }
        if ($nbvalid > '0')
        {
            return '<strong>('.$nbvalid.')</strong>';
        } else return false;
    }
    public static function redirect($url)
    {
        header('Location: '.$url);exit();
    }
}