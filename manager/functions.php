<?php
header('Content-Type: text/html; charset=utf-8');
if (is_dir('../Setup'))
{
	exit('<b><center><font color=red>Le Dossier d\'installation n\'a pas été supprimé !<br>Par sécurité, le script est inutilisable à ce stade.</font></center></b>');
}
if(file_exists('../Conf.d/dbconf.php'))
{
	require('../Conf.d/dbconf.php');
}
else
{
	die("<p style='color:#F00; font-weight:bold; font-size:16px'>Fichier de configuration introuvable ! Veuillez exécuter l'installation !</a></p>");
}
if(file_exists('../Conf.d/core_config.ini'))
{
	$ini_array = parse_ini_file('../Conf.d/core_config.ini', true);
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
require('../constantes.php');
function autoloader($class)
{
    require('class/' . $class . '.class.php');
}
spl_autoload_register('autoloader');
if(!$settings=Sql::get("SELECT * FROM ".cfg." WHERE id='1'")) die(Sql::$_message);
System::is_ban();
Session::init();
if (Session::exist('login'))
{
	$userdata=Sql::get("SELECT * FROM ".auth." WHERE login='".Session::get('login')."'");
}
