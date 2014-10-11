<?php
header("Cache-Control: no-cache, must-revalidate" );
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header('Content-Type: text/html; charset=utf-8');
/* Debug Control */
if(file_exists('../Conf.d/core_config.ini'))
{
	$ini_array = parse_ini_file("../Conf.d/core_config.ini", true);
	if ($ini_array['System']['debug'])
	{
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
	}
	else
	{
		ini_set('display_errors', 0);
		error_reporting(0);
	}
}
/*****************/
$base_path = str_replace('\\', '/', realpath(dirname(__FILE__))).'/';
$virtual_path = str_replace('\\', '/', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'])).'/';
define('BASE_PATH', $base_path);
define('VIRTUAL_PATH', $virtual_path);
include BASE_PATH . 'includes/core/wizard.php';
include BASE_PATH . 'includes/wizard.php';
$wizard = new Setup();
$wizard->run();