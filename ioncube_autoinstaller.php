<?php
if ((isset($_GET['p'])) && ($_GET['p']=="install")){
    if (strpos($_SERVER['DBENTRY'],'kunden')<1)
    {
        $error_msg= "Ce système ne peut fonctionner que sur un hébergement 1&amp;1 !";
    }
    else
    {
        define('PATH',realpath('.'));
        if (!defined('PHP_VERSION_ID'))
        {
            $version = explode('.',PHP_VERSION);
            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
            define('PHP_MAJOR_VERSION',   $version[0]);
            define('PHP_MINOR_VERSION',   $version[1]);
            define('PHP_RELEASE_VERSION', $version[2]);
        }
        // Curl: On recupere ioncube sur mon site perso correspondant a la version en cours de PHP //
        $file = 'ioncube/ioncube_loader_lin_'.PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.so';
        $url='http://fleuryk.kappatau.eu/ioncube/ioncube_loader_lin_'.PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.so';
        if(!is_dir('ioncube')){mkdir('ioncube',0777);}
        if(is_dir('ioncube')){
            if (file_exists($file))
            {
                $error_msg= 'Ioncube est déja installé ! <br />L\'installation ne peut continuer.';
            }
            else
            {
                $fp = fopen($file, 'w');
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_FILE, $fp);
                $data = curl_exec($ch);
                $curl_errno = curl_errno($ch);
                $curl_error = curl_error($ch);
                curl_close($ch);
                fclose($fp);
                if ($curl_errno > 0)
                {
                    $error_msg= "Erreur Fatale => ($curl_errno): $curl_error\n";
                }
                else
                {
                    $success_msg= "Installation terminée avec succès !<br />Vous pouvez à présent procéder à l'installation de Dédinomy en cliquant sur ce lien <a href='./Setup/index.php'>Installation</a>.";
                    $php_ini='zend_extension = '.PATH.'/'.$file;
                    $htaccess_file='deny from all';
                    $php_file="php.ini";
                    $fp_php=fopen($php_file, 'w');
                    fwrite($fp_php,$php_ini);
                    fclose($fp_php);
                    $fp_htaccess=fopen('ioncube/.htaccess','w');
                    fwrite($fp_htaccess,$htaccess_file);
                    fclose($fp_htaccess);
                    copy($php_file, 'Setup/'.$php_file);
                    copy($php_file, 'manager/'.$php_file);
                    copy($php_file, 'manager/inc/'.$php_file);
                    copy($php_file, 'manager/class/'.$php_file);
                    copy($php_file, 'manager/inc/'.$php_file);
                    copy($php_file, '.'.$php_file);
                    copy($php_file, 'class/'.$php_file);
                    copy($php_file, 'Core/Templating/libs/'.$php_file);
                    copy($php_file, 'lib/'.$php_file);
                    //unlink('ioncube_autoinstaller.php');
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
	<html lang='fr'>
    <head>
	<meta charset="utf-8" />
	<title>NuBOX NetInstall</title>
	<link rel="stylesheet" type="text/css" media="screen" href="http://static.nubox.fr/netinstall/loader.css" />
	</head>
	<body>
	<div id="theHeader"></div>
        <div id="content">
	<h2>NuBOX NetInstall</h2>
        <fieldset><legend>Installation de Ioncube</legend>
       <?php if (isset($success_msg)):?>
       <br /><br />
       <div class="msg success">
            <h3>Succès !</h3>
            <p><?php echo $success_msg;?></p>
        </div>
       <?php else:?>
        <?php if(isset($error_msg)):?><div class="msg warning">
            <h3>Erreur !</h3>
            <p><?php echo $error_msg;?></p>
        </div>
        <?php else:?>
        Bienvenue sur l'autoinstaller de ioncube pour 1&amp;1 Hébergement.<br />
        Pour installer ioncube sur votre hébergement, Veuillez cliquer sur le bouton ci-dessous.
        <form action="ioncube_autoinstaller.php" method="get">
            <input type="hidden" value="install" name="p"/>
	<p class="button">
	<input type="submit" value="Installer Ioncube"/>
	</p>
        </form>
        <?php endif; endif;?>
        </fieldset>
	<div style="text-align:center">
          Pour tout support, veuillez vous rendre sur le forum à cette adresse : <a href="http://forum.nubox.fr" target="_blank">http://forum.nubox.fr</a><br />
          Powered By NuBOX&copy; 2008-<?php echo date('Y')?>. Tout droits réservés.
        </div>
        </div>
	</body>
	</html>