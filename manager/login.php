<?php
header ('X-UA-Compatible: IE = Edge');
header('Content-Type: text/html; charset=utf-8');
require('functions.php');
if (isset($_POST['connexion']))
{
	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass'])))
	{
		$login = Sql::count("SELECT * FROM ".auth." WHERE login='". Security::sanitize($_POST['login'])."' AND pass_md5='". Security::sanitize(md5($_POST['pass']))."'");
		if ($login)
		{
			Session::set('login',Security::sanitize($_POST['login']));
			Tools::redirect('index.php');
		}
		elseif (!$login)
		{
			$error = '<div style="width:650px;" class="error message">
			<h3 style="color:white">Erreur</h3>
			<p>Vérifiez votre mot de passe, ou votre nom d\'utilisateur car nous n\'avons pas réussi à vous authentifier.</p></div>';
		}
	}
	else
	{
		$error = '<div style="width:650px;" class="error message">
         <h3 style="color:white">Erreur</h3>
         <p>Un élément du formulaire est vide.</p></div>';
	}
}
if (isset($_GET['logout']))
{
	Session::destroy();
	Tools::redirect('login.php');
}
if (Beta) $beta=" Beta"; else $beta="";
echo'
<!DOCTYPE html>
<html lang="fr">
<head>
<title>'.$settings->site.' - DediNomy '.$beta.'</title>
<meta charset="utf-8">
<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" href="../assets/css/base.css">
<link rel="stylesheet" href="../assets/css/skeleton.css">
<link rel="stylesheet" href="../assets/css/layout.css">
<link rel="stylesheet" href="../assets/css/docs.css">
<link rel="stylesheet" href="../assets/css/notif.css">
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/tabs.js"></script>
<script src="../assets/js/notifs.js"></script>
</head>
<body>
<div class="container">
';
if(isset($error)) echo $error;
if (isset($message)) echo '<div style="width:650px;" class="error message">
         <h3 style="color:white">Erreur</h3>
         <p>'.$message.'</p></div>'; 
    echo '
 <div class="six columns">
    <h1>Dédinomy '.ver.'</h1>
    <h3 style="margin-top:-20px;">Administration <font color="orange"><em>'.$beta.'</em></font></h3>
 </div>
 <div class="six columns"><form action="#" method="post">
  <label>Login / Pseudo :</label>
    <input type="text" name="login" value="'; if (isset($_POST['login'])) echo Security::sanitize($_POST['login']); echo'" required=required>
  <label>Mot de passe :</label>
  <input type="password" name="pass" value="" required=required/>
  <input type="hidden" name="connexion" value="Connexion" />
  <input type="submit" name="connexion" class="button" value="Connexion"/>
</p>
</form>
 </div>
</div>
</body>
</html>';
?>
