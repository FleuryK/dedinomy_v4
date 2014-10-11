<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
define('ROOT_UPD','../');
//--------------------------//
// Fonctions
// -------------------------//
function make_dir($dir)
{
    is_dir($dir)? '':mkdir($dir);
}
function remove_dir($current_dir)
{
    $current_dir = rtrim($current_dir, '/') . '/';
    $items = glob($current_dir . '*');
    foreach($items as $item)
    {
        is_dir($item) ? remove_dir($item) : unlink($item);
    }
    is_dir($current_dir)?rmdir($current_dir):'';
}
function remove_file($file)
{
    is_file($file)? unlink($file):'';
}
function recursiveChmod($path, $filePerm=0644, $dirPerm=0755)
{
    if (!file_exists($path))
    {
        return(false);
    }
    if (is_file($path))
    {
        chmod($path, $filePerm);
    }
    elseif(is_dir($path))
    {
        $foldersAndFiles = scandir($path);
        $entries = array_slice($foldersAndFiles, 2);
        foreach ($entries as $entry)
        {
            recursiveChmod($path."/".$entry, $filePerm, $dirPerm);
        }
        chmod($path, $dirPerm);
    }
    return(true);
}
//--------------------------//
// On gere les fichiers/dossiers
//--------------------------//

/*
make_dir(ROOT_UPD.'Conf.d');
make_dir(ROOT_UPD.'Core');
make_dir(ROOT_UPD.'Core/Templating');
make_dir(ROOT_UPD.'Core/Templating/libs');
make_dir(ROOT_UPD.'Core/Templating/cache');
make_dir(ROOT_UPD.'Core/Templating/compile');
copy(ROOT_UPD.'cfgdb.php',ROOT_UPD.'Conf.d/dbconf.php');
copy(ROOT_UPD.'core_config.ini',ROOT_UPD.'Conf.d/core_config.ini');
// On delete les fichiers/dossiers inutiles

//$html.='<tr class="alt"><td class="tbladmin-td"><strong>Suppression des anciens Fichiers & Répertoires</strong></td>';
remove_dir(ROOT_UPD."constructor");
remove_file('fonctions_manager.php');
remove_file('interdit.php');
remove_file(ROOT_UPD.'cfgdb.php');
remove_file(ROOT_UPD.'core_config.ini');
remove_file(ROOT_UPD.'assets/css/dedi.css');
remove_file(ROOT_UPD.'assets/css/poster.css');
remove_file(ROOT_UPD.'assets/img/apostrophe1.gif');
remove_file(ROOT_UPD.'assets/img/apostrophe2.gif');
remove_file(ROOT_UPD.'assets/img/designer.png');
remove_file(ROOT_UPD.'assets/img/developer_tools.png');
remove_file(ROOT_UPD.'assets/img/error.png');
remove_file(ROOT_UPD.'assets/img/good.png');
remove_file(ROOT_UPD.'assets/img/retour.png');
remove_file(ROOT_UPD.'assets/img/save.png');
remove_file(ROOT_UPD.'assets/img/star.gif');
remove_file(ROOT_UPD.'assets/js/marquee.js');
remove_file(ROOT_UPD.'recaptchalib.php');
//Reglage des chmod

//$html.='<tr class="alt"><td class="tbladmin-td"><strong>Mise a jour des droits d\'accès aux Fichiers & Répertoires (Chmod)</strong></td>';
recursiveChmod(ROOT_UPD,0644,0755);
recursiveChmod(ROOT_UPD.'Core/Templating/cache',0777,0777);
recursiveChmod(ROOT_UPD.'Core/Templating/compile',0777,0777);
*/
//--------------------------//
// On gere la partie BDD
//--------------------------//
$db_upd = new PDO('mysql:host='.Server.';dbname='.Base, User, Password, array(
    PDO::ATTR_PERSISTENT => true
));

/*
$db_upd->exec('SET NAMES UTF8');
// On converti les tables/champs en utf8
//$html.='<tr class="alt"><td class="tbladmin-td"><strong>Conversion des tables MySQL en UTF8</strong></td>';
$db_upd->exec('ALTER TABLE '.Prefix.'_auth CHARACTER SET UTF8');
$db_upd->exec('ALTER TABLE '.Prefix.'_auth CONVERT TO CHARACTER SET UTF8');
$db_upd->exec('ALTER TABLE '.Prefix.'_bans CHARACTER SET UTF8');
$db_upd->exec('ALTER TABLE '.Prefix.'_bans CONVERT TO CHARACTER SET UTF8');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg CHARACTER SET UTF8');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg CONVERT TO CHARACTER SET UTF8');
$db_upd->exec('ALTER TABLE '.Prefix.'_text CHARACTER SET UTF8');
$db_upd->exec('ALTER TABLE '.Prefix.'_text CONVERT TO CHARACTER SET UTF8');
// Modification des tables
//$html.='<tr class="alt"><td class="tbladmin-td"><strong>Mise a jour des tables MySQL</strong></td>';
$db_upd->exec('ALTER TABLE '.Prefix.'_auth MODIFY niveau TINYINT(2)');
$db_upd->exec('ALTER TABLE '.Prefix.'_bans MODIFY id INT(11)');
$db_upd->exec('ALTER TABLE '.Prefix.'_bans MODIFY ip TEXT');
$db_upd->exec('ALTER TABLE '.Prefix.'_text MODIFY id INT(11)');
$db_upd->exec('ALTER TABLE '.Prefix.'_text MODIFY timestamp TEXT');
$db_upd->exec('ALTER TABLE '.Prefix.'_text MODIFY val TINYINT(1) NOT NULL DEFAULT \'0\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_text MODIFY iptrace TEXT');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg DROP inc_dedi');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg DROP inc_poster');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg DROP mail2');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg DROP defil_dedi');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg DROP larg_dedi');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg DROP adm_nb_dedi');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY id INT(11)');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY site TEXT');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY nb_aff INT(11) NOT NULL DEFAULT \'10\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY erreur_mod TEXT');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY mail TEXT');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY adr_dedi TEXT');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY val_dedi INT(11) NOT NULL DEFAULT \'0\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY ca_post INT(11) NOT NULL DEFAULT \'24\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY captcha TINYINT(1) NOT NULL DEFAULT \'1\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY recaptcha_theme TEXT NOT NULL DEFAULT \'clean\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY mnt TINYINT(1) NOT NULL DEFAULT \'0\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY cle TEXT NOT NULL DEFAULT \'0\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY msg_mnt TEXT');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY msg_poster_val TEXT');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY msg_poster TEXT');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY liserv TINYINT(1) NOT NULL DEFAULT \'0\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY theme TEXT NOT NULL DEFAULT \'dedinomy_classi\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY api_list_dedi TINYINT(1) NOT NULL DEFAULT \'0\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY api_publish_dedi TINYINT(1) NOT NULL DEFAULT \'0\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY api_delete_dedi TINYINT(1) NOT NULL DEFAULT \'0\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY moderation TEXT');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY ch TEXT NOT NULL');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg MODIFY date_onoff TINYINT(1) NOT NULL DEFAULT \'0\'');
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg ADD adm_nb_page INT(11) NOT NULL DEFAULT \'10\'');
$api_key = sha1(base64_encode(rand()));
$db_upd->exec('ALTER TABLE '.Prefix.'_cfg ADD api_key varchar(11) NOT NULL DEFAULT \''.$api_key.'\'');
$db_upd->exec('UPDATE '.Prefix.'_cfg SET api_key=\''.$api_key.'\',api_list_dedi=\'1\',api_publish_dedi=\'1\',api_delete_dedi=\'1\' WHERE id=\'1\'');
*/
//===== Update 5.0.1 =====//
$html.='<tr class="alt"><td class="tbladmin-td"><strong>Installation des correction MySQL</strong></td>';
$db_upd->exec('ALTER TABLE '.Prefix.'_text CHANGE id id INT(11) NOT NULL AUTO_INCREMENT;');
$db_upd->exec('ALTER TABLE '.Prefix.'_text AUTO_INCREMENT = 250;');
$api_key=sha1(base64_encode(rand()));
$db_upd->exec("ALTER TABLE ".Prefix."_text MODIFY api_key VARCHAR(255) NOT NULL DEFAULT '".$api_key."';");
$db_upd->exec("UPDATE ".Prefix."_cfg SET api_key='".$api_key."' WHERE id='1'");