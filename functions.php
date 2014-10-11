<?php
header('Content-Type: text/html; charset=utf-8');
if (is_dir('Setup'))
{
	exit('<b><center><font color=red>Le Dossier d\'installation n\'a pas été supprimé !<br>Par sécurité, le script est inutilisable à ce stade.</font></center></b>');
}
if(file_exists('./Conf.d/dbconf.php'))
{
	require('./Conf.d/dbconf.php');
}
else
{
	die("<p style='color:#F00; font-weight:bold; font-size:16px'>Fichier de configuration introuvable ! Veuillez exécuter l'installation !</a></p>");
}
if(file_exists('./Conf.d/core_config.ini'))
{
	$ini_array = parse_ini_file("./Conf.d/core_config.ini", true);
	if ($ini_array['System']['debug'])
	{
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
		define('Debug',true);
	}
	else
	{
		ini_set('display_errors', 0);
		error_reporting(0);
		define('Debug',false);
	}
}
require('constantes.php');
function autoloader($class)
{
    require('class/' . $class . '.class.php');
}
spl_autoload_register('autoloader');
if(!$settings=Sql::get("SELECT * FROM ".cfg." WHERE id='1'")) die(Sql::$_message);
System::is_ban();
Session::init();
if($settings->mnt)
{
	exit($settings->msg_mnt);
}
require('Core/Templating/libs/gaga.class.php');
$tpl = new gagatemplate();
$tpl->root='';
$tpl->tplDir='themes/'.$settings->theme.'/';
$tpl->compileDir='Core/Templating/compile/';
$tpl->cacheTime = 0;
$tpl->cacheDir = 'Core/Templating/cache/';
$tpl->forceCompile=true;
$tpl->cache=false;
$tpl->display=true;
$tpl->assign(array(
	'assets_css' => $settings->adr_dedi.'/themes/'.$settings->theme.'/css/',
	'assets_js' => $settings->adr_dedi.'/themes/'.$settings->theme.'/js/',
	'assets_img' => $settings->adr_dedi.'/themes/'.$settings->theme.'/img/',
	'site_name'=>$settings->site.' - DediNomy',
	)
);
