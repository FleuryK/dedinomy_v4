<?php
class Callbacks extends Callbacks_Core
{
	function install($params = array())
	{
		$dbconf = array(
			'db_host' => $_SESSION['params']['db_hostname'],
			'db_user' => $_SESSION['params']['db_username'],
			'db_pass' => $_SESSION['params']['db_password'],
			'db_name' => $_SESSION['params']['db_name'],
			'db_prefix' => $_SESSION['params']['db_prefix'],
			'db_encoding' => 'utf8',
		);
		if ( !$this->db_init($dbconf) ) {
			return false;
		}
		$replace = array(
			'{:db_prefix}' => addslashes($_SESSION['params']['db_prefix']),
			'{:db_engine}' => 'MyISAM',
			'{:db_charset}' => $this->db_version >= '4.1' ? 'DEFAULT CHARSET=utf8' : '',
			'{:website}' => $_SESSION['params']['virtual_path'],
			'{:api_key}' => sha1(base64_encode(rand()))
		);
		if ( !$this->db_import_file(BASE_PATH.'sql/data.sql', $replace) ) {
			return false;
		}
		$this->db_close();
		$config_file = '<?php'."\n";
		$config_file .= 'DEFINE("Server","'.addslashes($_SESSION['params']['db_hostname']).'");'."\n";
		$config_file .= 'DEFINE("Port","3306");'."\n";
		$config_file .= 'DEFINE("User","'.addslashes($_SESSION['params']['db_username']).'");'."\n";
		$config_file .= 'DEFINE("Password","'.addslashes($_SESSION['params']['db_password']).'");'."\n";
		$config_file .= 'DEFINE("Base","'.addslashes($_SESSION['params']['db_name']).'");'."\n";
		$config_file .= 'DEFINE("Prefix","'.addslashes($_SESSION['params']['db_prefix']).'");'."\n";
		file_put_contents(rtrim($_SESSION['params']['system_path'], '/').'/Conf.d/dbconf.php', $config_file);
		return true;
	}
	function reset_session($params=array())
	{
		$_SESSION = array();
		session_unset();
		session_destroy();
	}
	function configuration($params=array())
	{
		include('../Conf.d/dbconf.php');
		$connexion = new PDO("mysql:host=".Server.";dbname=".Base, User, Password);
		$user=$_SESSION['params']['adm_username'];
		$pass=md5($_SESSION['params']['adm_password']);
		$email=$_SESSION['params']['adm_mail'];
		$sitename=$_SESSION['params']['adm_sitename'];
		$siteurl=$_SESSION['params']['adm_siteurl'];
		$connexion->query("INSERT INTO ".$_SESSION['params']['db_prefix']."_auth SET pass_md5='".$pass."', login='".$user."', niveau='1'");
		$connexion->query("UPDATE ".$_SESSION['params']['db_prefix']."_cfg SET site='".$sitename."', mail='".$email."', adr_dedi='".$siteurl."'");
		return true;
	}
}