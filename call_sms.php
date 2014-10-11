<?php
header('Content-Type: text/html; charset=utf-8');
if(!require('functions.php'))
{
	exit('NON');
}
if ($_REQUEST['sms'])
{
	$message=explode(' ',$_REQUEST['sms']);
	$i=0;
	$dedi='';
	foreach($message as $a=>$b)
	{
		if($i>0)
		{
			$dedi.=' '.$b;
		}
		$i++;
	}
	$stop=false;
	$verif = explode(' ', $dedi);
	$inter = explode(',',$settings->moderation);
	foreach ($verif as $k)
	{
		if(in_array($k,$inter) && $settings->moderation)
		{
			$stop=true;	
		}
	}
	if(!$stop)
	{
		if (!$settings->val_dedi)
		{
			$validation="En attente de validation";
		}
		else
		{
			$validation="Publiée";
		}
		Sql::insert("INSERT INTO ".text." VALUES('', 'SMS', '".$dedi."', '".time()."', '".$settings->val_dedi."', '')");
		$subject = 'Nouvelle Dedicace SMS Sur Votre Site !';
		$headers = 'From: "'.$settings->site.'" <'.$settings->mail.'>'."\n";
		$headers .= 'Mime-Version: 1.0'."\n";
		$headers .= 'Content-type: text/html; charset=utf-8'."\n";
		$msg = '<b>Bonjour,</b><br /><br />Une nouvelle dédicace viens d\'étre envoyée sur votre site par SMS :<br /><br />Message : <strong> '.$dedi.'</strong><br />Statut :<strong> '.$validation.'</strong><br /><br />Pour valider, modifier, ou supprimer cette dédicace, rendez-vous dans votre console d\'adminisration.<br /><a href="'.$settings->adr_dedi.'/manager/index.php" target="_blank">Administration</a></font>';
		mail($settings->mail, $subject, $msg, $headers);
		exit('OUI');
	}
	else
	{
		exit('NON');
	}
}