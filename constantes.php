<?php
DEFINE("Beta",false);
DEFINE("ver","5.0.1");
DEFINE("auth",Prefix."_auth");
DEFINE("text",Prefix."_text");
DEFINE("cfg",Prefix."_cfg");
DEFINE("bans",Prefix."_bans");
define('SCR_NAME','dedinomy5');
function get_ip()
{
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$iptrace=get_ip();
$domainName = $_SERVER['HTTP_HOST'];
$copy='<div style="text-align: center;"><span style="font-family:\'Comic Sans MS\',cursive;font-size:8px;color:#FFF;"><a href="http://manager.nubox.fr/" onclick="window.open(this.href); return false;">&copy; 2008 - '.date('Y').'. DédiNomy by NuBOX</a></span></div>';
$copyAdm='&copy; 2008 - '.date('Y').'. DédiNomy by <a href="http://manager.nubox.fr/" onclick="window.open(this.href); return false;">NuBOX</a> | Reproduction interdite même partielle sans autorisation de son auteur.';
$RecaptchaPubKey="6Lf6SccSAAAAADWTnuki_z54pLgcwwDdgNoz5ccv";
$RecaptchaPrivKey="6Lf6SccSAAAAAF3Bf761ePBZHgXcCJiOPViJcfYn";