<?php
header('X-UA-Compatible: IE = Edge');
header('Content-Type: text/html; charset=utf-8');
require('functions.php');
if (!Session::exist('login'))
{
	Tools::redirect('login.php');
}
if (isset($_GET['mnt']))
{
	Sql::update("UPDATE ".cfg." SET mnt='".Security::sanitize($_GET['mnt'])."' WHERE id=1");
	Tools::redirect('?pcat=home');
}
?>
<!DOCTYPE html>
<html>
<head>
	<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<title><?php echo $settings->site; ?> - Dédinomy <?php if(Beta) echo'Beta';?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../assets/css/base.css">
	<link rel="stylesheet" href="../assets/css/paginate.css">
	<link rel="stylesheet" href="../assets/css/skeleton.css">
	<link rel="stylesheet" href="../assets/css/layout.css">
	<link rel="stylesheet" href="../assets/css/docs.css">
	<link rel="stylesheet" href="../assets/css/notif.css">
	<link rel="stylesheet" href="../assets/css/joyride.css">
	<link rel="shortcut icon" href="../assets/img/logo.ico" />
	<script src="../assets/js/jquery.js"></script>
	<script src="../assets/js/tabs.js"></script>
	<script src="../assets/js/notifs.js"></script>
	<script src="../assets/js/joyride.js"></script>
	<script src="../assets/js/ckeditor/ckeditor.js"></script>
	<script src="../assets/js/ckeditor/config.js"></script>
</head>
<body>
	<div class="container">
		<div class="three columns sidebar">
			<nav>
				<a style="text-decoration: none; " href="index.php"><img id="logo" style="margin-bottom:20px;border-radius:90px;" src="../assets/img/logo.png"></a>
				<ul>
					<li id="numero3"><a href="?pcat=dedi">Dédicaces <?php echo Tools::notification();?></a></li>
					<?php if($userdata->niveau=='1') echo '<li><a href="?pcat=users#simple">Utilisateurs</a></li>';else echo '<li><a href="?pcat=users">Mon profil</a></li>'; ?>
					<?php if($userdata->niveau=='1') echo '<li id="numero4"><a href="?pcat=themes">Thèmes</a></li>'; ?>
					<?php if($userdata->niveau=='1') echo '<li><a href="?pcat=ban">IP bannies</a></li>';?>
					<?php if($userdata->niveau=='1') echo '<li id="numero5"><a href="?pcat=settings">Paramètres</a></li>'; ?>
					<li><a <?php if ($settings->mnt) echo 'style="color:red"'; ?> href="?mnt=<?php if ($settings->mnt) echo'0'; else echo '1'; ?>"><?php if ($settings->mnt) echo'Désactiver maintenance'; else echo 'Activer maintenance'; ?></a></li>
					<li><a href="login.php?logout">Déconnexion</a></li>
					<br />
					<?php 
					if (Update::check() && $userdata->niveau=='1')
					{
						echo '<div style="line-height:20px;text-align:center;font-size:13px;color:white;border-radius:5px;background:#F46427;padding-top:10px;padding-bottom:10px;padding-left:5px;width:100%;"><a style="line-height:18px;color:white;text-decoration:none;" href="?pcat=update">Une nouvelle mise à jour de Dédinomy est disponible</a></div>';
					}
					?>
				</ul>
			</nav>&nbsp;
		</div>
		<div class="twelve columns offset-by-one content">    
			<?php
			$page_defaut = 'inc/home';
			if(isset($_GET["pcat"]))
			{
				$page=$_GET["pcat"];
			}
			else
			{
				$page=$page_defaut;   
			}
			$page=htmlentities($page, ENT_QUOTES);
			$repProteger=array('lib','constructor','themes');
			$temp=preg_split('//',$page);
			if(in_array($temp[0],$repProteger))
			{
				$page=$page_defaut;
			}
			if(preg_match("#(:/)|(./)#",$page))
			{
				$page=$page_defaut;
			}
			if(file_exists('inc/'.$page.'.inc.php'))
			{
				include('inc/'.$page.'.inc.php');
			}
			elseif(file_exists($page_defaut.'.inc.php'))
			{
				include($page_defaut.'.inc.php');
			}
			else
			{
				exit("Erreur : La page demandée n'existe pas.");
			}
			?>
		</div>
	</div>
</body>
</html>
