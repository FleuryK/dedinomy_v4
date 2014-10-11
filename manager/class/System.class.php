<?php
class System
{
    public static function is_ban()
    {
        global $iptrace;
        $query = Sql::count("SELECT * FROM ".bans." WHERE ip='".$iptrace."'");
        if ($query > 0)
        {
            Tools::redirect('../banni.html');
        }
    }
}