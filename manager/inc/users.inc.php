<?php if (!defined('SCR_NAME')) exit('No direct script access allowed');
if($userdata->niveau=='1'): ?>
<header>
	<h1>Gestion des utilisateurs</h1>
</header>
<ul class="tabs">
	<li><a class="moderation" href="#simple">Tous les utilisateurs</a></li>
	<li><a class="enligne" href="#enligne">Ajouter un nouvel utilisateur</a></li>
</ul>
<?php 
if(isset($_GET['sup']))
{
	$_GET['sup'] = $_GET['sup'];
	Sql::delete("DELETE FROM ".auth." WHERE id='".$_GET["sup"]."'");
	echo '
	<div style="width:650px;" class="success message">
		<h3 style="color:white">L\'utilisateur a bien été supprimé</h3>
	</div>
	';
}
if(isset($_POST['NewUser']))
{
	if((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass'])) && (isset($_POST['pass_confirm']) && !empty($_POST['pass_confirm'])) && (isset($_POST['grade']) && !empty($_POST['grade'])))
	{
		if($_POST['pass'] != $_POST['pass_confirm'])
		{
			$error = 'Les 2 mots de passes sont différents.';
		}
		else
		{
			$req = Sql::count("SELECT * FROM ".auth." WHERE login='". $_POST['login']."'");
			if ($req == 0)
			{
				Sql::insert("INSERT INTO ".auth." VALUES('', '". $_POST['login']."', '". md5($_POST['pass'])."','". $_POST['grade']."' )");
				echo '<div style="width:650px;" class="success message">
				<h3 style="color:white">L\'utilisateur a bien été ajouté</h3>
				<p>Le nouvel utilisateur a bien été ajouté à la base de données des utilisateurs.</p>
				</div>';
			}
			else
			{
				echo $error = '<div style="width:650px;" class="error message">
				<h3 style="color:white">OhOhOh - Erreur</h3>
				<p>Ce nom d\'utilisateur est déjà utilisé, merci de bien vouloir le changer.</p>
				</div>';
			}
		}
	}
	else
	{
		echo  $error = '<div style="width:650px;" class="error message"><h3 style="color:white">OhOhOh - Erreur</h3>
		<p>Tous les champs sont obligatoires.</p>
		</div>';
	}
}
?>
<ul class="tabs-content">
	<li class="moderation" id="simple">
		<table class="striped" cellspacing="0" cellpadding="0">
			<thead><tr class="alt first last">
				<th><h6>Nom d'utilisateur</h6></th>
				<th><h6>Rôle</h6></th>
				<th><h6>Action</h6></th>
			</tr></thead>
			<tbody>
				<?php
				$retour = Sql::getAll("SELECT * FROM ".auth." ORDER BY id");
				foreach($retour as $donnees)
				{
					echo'
					<tr class="alt">
					<td class="tbladmin-td"><strong>'.$donnees->login.'</strong></td>
					<td class="tbladmin-td">'; 
					if($donnees->niveau==1)
					{
						echo 'Administrateur';
					}
					elseif($donnees->niveau==2)
					{
						echo 'Modérateur';
					}
					else
					{
						echo '<p class="erreur">Erreur ! Impossible de définir le Grade !</p>';
					} 
					echo'</td>
					<td style="width:320px;"><ul class="button-bar">
					<li class="first"><a href="?pcat=edit_users&id='.$donnees->id.'">Modifier les informations</a></li>
					<li class="last"><a href="?pcat=users&sup='.$donnees->id.'#enligne">Supprimer le profil</a></li>
					</ul></td>
					</tr>';
				}
				echo'</tbody></table>';
				?>
			</li>
			<li id="enligne">
				<?php
				echo '
				<form action="" method="post">
					<p>Nom d\'utilisateur :
						<input type="text" name="login" value="'; if (isset($_POST['login'])) echo $_POST['login']; echo'" required=required />
						Mot de passe :<br />
						<input type="password" name="pass" value="" required=required />
						Confirmation du mot de passe :<br />
						<input type="password" name="pass_confirm" value="" required=required />
					</p>
					<fieldset>
						<legend>Rôle du nouvel utilisateur :</legend>
						<label for="regularRadio">
							<input type="radio" name="grade" value="1" id="1"; />
							<span>Administrateur</span>
						</label>
						<label for="secondRegularRadio">
							<input type="radio" name="grade" value="2" id="2" checked="checked"; />
							<span>Modérateur</span>
						</label>
					</fieldset>
					<input type="hidden" name="NewUser" value="NewUser" />
					<button class="button" type="submit">Ajouter l\'utilisateur</button>
				</form>';
				?>
			</li>
<?php
else:
	if (isset($_POST['profil']))
	{
		if ((isset($_POST['pass_md5']) && !empty($_POST['pass_md5'])) && (isset($_POST['pass_confirm']) && !empty($_POST['pass_confirm'])))
		{
			if ($_POST['pass_md5'] != $_POST['pass_confirm'])
			{
				$error = '<div style="width:650px;" class="error message">
				<h3 style="color:white">OhOhOh - Erreur</h3>
				<p>Le mot de passe doit être identique. Merci de corriger votre erreur pour continuer</p>
				</div>';
			}
			else
			{
				$req = Sql::count("SELECT * FROM ".auth." WHERE login='". $_POST['pseudo_adm']."'");
				if ($req == 1)
				{
					Sql::update("UPDATE ".auth." SET pass_md5='". md5($_POST['pass_md5'])."' WHERE id='".$login_user."'");
					echo '<div style="width:650px;" class="info message">
					<h3 style="color:white">Votre profil est à jour</h3>
					<p>Votre mot de passe a bien été modifié</p>
				</div>';
				}
				else
				{
					echo'<div style="width:650px;" class="success message">
					<h3 style="color:white">OhOhOh - Erreur</h3>
					<p>Une erreur est survenue lors du traitement</p>
					</div>';
				}
			}
		}
		else
		{
			echo '<div style="width:650px;" class="error message">
			<h3 style="color:white">OhOhOh - Erreur</h3>
			<p>Tous les champs sont obligatoires</p>
			</div>';
		}
	}
?>
<header>
	<h1>Mon profil</h1>
</header>
<?php echo'
	<form action="" method="post" name="profil">
	Nouveau Mot de passe :<br />
	<input type="password" name="pass_md5" value="" required=required />
	Confirmation du mot de passe :<br />
	<input type="password" name="pass_confirm" value="" required=required />
	<input type="hidden" name="id_user" value="'.$userdata->id.'" />
	<input type="hidden" name="pseudo_adm" value="'.$userdata->login.'" />
	<button class="button" name="profil" value="submit">Mettre à jour mon mot de passe</button>
	</form>';
endif;?>
