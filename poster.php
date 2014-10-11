<?php
header('Content-Type: text/html; charset=utf-8');
require('functions.php');
if($settings->captcha)
{
	require('lib/recaptchalib.php');
	$publickey = $RecaptchaPubKey;
	$privatekey = $RecaptchaPrivKey;
	$resp = null;
	$error = null;
}
$text='';$err_code='';
if(isset($_POST['pseudo']) AND isset($_POST['message']))
{
	if(isset($_SESSION['dedinomy']['token']) && isset($_SESSION['dedinomy']['token_time']) && isset($_POST['token']))
	{
		if($_SESSION['dedinomy']['token'] == Security::sanitize($_POST['token']))
		{
			$timestamp_ancien = time() - (15*60);
			if($_SESSION['dedinomy']['token_time'] >= $timestamp_ancien)
			{
				if($settings->captcha)
				{
					$resp = recaptcha_check_answer($privatekey,
						$iptrace,
						$_POST["recaptcha_challenge_field"],
						$_POST["recaptcha_response_field"]
						);
					if ($resp->is_valid)
					{
						$next=true;
					}
					else
					{
						$next=false;
						$error = $resp->error;
						$err_code = 'Le code Anti-Spam Entré est incorrect, merci de recommencer !<br /><a href="javascript:history.go(-1)">Retour</a>';
					}
				}
				else $next=true;
				if($next)
				{
					if ($_POST['pseudo'] && $_POST['message'])
					{
						$stop=false;
						$verif = explode(' ', Security::sanitize($_POST['message']));
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
								$text = $settings->msg_poster_val;
								$validation="En attente de validation";
							}
							else
							{
								$text = $settings->msg_poster;
								$validation="Publiée";
							}
							$message = Security::sanitize($_POST['message']);
							$pseudo = Security::sanitize($_POST['pseudo']);
							Sql::insert('INSERT INTO '.text.' VALUES("", "'.$pseudo.'", "'.$message.'", "'.time().'", "'.$settings->val_dedi.'", "'.$iptrace.'")');
							$subject = 'Nouvelle Dédicace Sur Votre Site !';
							$headers = 'From: "'.$settings->site.'" <'.$settings->mail.'>'."\n";
							$headers .= 'Mime-Version: 1.0'."\n";
							$headers .= 'Content-type: text/html; charset=utf-8'."\n";
							$msg = '<b>Bonjour,</b><br /><br />Une nouvelle dédicace viens d\'étre envoyée sur votre site :<br /><br />Pseudo : <strong>'.$pseudo.'</strong><br />Dédicace :<strong> '.$message.'</strong><br />IP :<strong> '.$iptrace.'</strong><br />Statut :<strong> '.$validation.'</strong><br /><br />Pour valider, modifier, ou supprimer cette dédicace, rendez-vous dans votre console d\'adminisration.<br /><a href="'.$settings->adr_dedi.'/manager/index.php" target="_blank">Administration</a></font>';
							mail($settings->mail, $subject, $msg, $headers);
						}
						else
						{
							$err_code='Un des mots de votre Dédicace est interdit - Merci de bien vouloir vérifier votre Dédicace !<br /><a href="javascript:history.go(-1)">Retour</a>';
						}
					}
					else
					{
						$err_code='Tous les champs sont obligatoires !';
					}
				}
			}
			else
			{
				$err_code='Vous avez attendu trop longtemps pour valider le formulaire !<br /><a href="javascript:history.go(-1)">Retour</a>';
			}
		}
		else
		{
			$err_code='Impossible de continuer, les jetons de sécurité sont invalides !';
		}
	}
	else
	{
		$err_code='Impossible de continuer, les jetons de sécurité sont introuvables !';
	}
}
$token=uniqid(rand(), true);
if (!isset($_POST['pseudo']) AND !isset($_POST['message']))
{
	Session::set('token',$token);
	Session::set('token_time',time());
}
$tpl->assign(array(
	'display_form'=>(!isset($_POST['pseudo']) AND !isset($_POST['message'])),
	'error_msg'=>$err_code,
	'message'=>$text,
	'caracteres_max'=>$settings->ca_post,
	'captcha_on'=>$settings->captcha,
	'captcha_code'=>($settings->captcha)?recaptcha_get_html($publickey,$error):'',
	'token'=>$token,
	'captcha_theme'=>$settings->recaptcha_theme
	)
);
$tpl->parse('poster.tpl');
echo $copy;
