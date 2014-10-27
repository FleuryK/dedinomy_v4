<?php if (!defined('SCR_NAME')) exit('No direct script access allowed'); 
Security::is_admin();?>
<header>
	<h1>Modifier un profil</h1>
</header>
<?php if (isset($_GET['id']))
{
	$user = Sql::get("SELECT * FROM ".auth." WHERE id='".$_GET['id']."'");
	if (isset($_POST['submit']))
	{
		if ((isset($_POST['pseudo_adm']) && !empty($_POST['pseudo_adm'])))
		{
			if ($_POST['pass_md5'] != $_POST['pass_confirm'])
			{
				$error = 'Les 2 mots de passe sont différents.';
			}
			else
			{
				$count = Sql::count("SELECT count(*) FROM ".auth." WHERE login='". $_POST['pseudo_adm']."'");
				if ($count == 1)
				{
					Sql::update("UPDATE ".auth." SET login='". $_POST['pseudo_adm']."', pass_md5='". md5($_POST['pass_md5'])."', niveau='". $_POST['grade']."' WHERE id='".$_POST['id_user']."'");
					$message = '<div style="width:650px;" class="success message">
					<h3 style="color:white">Modification effectuée avec succès !</h3>
					</div>';
				}
				else
				{
					$message = 'Erreur lors de la mise à jour !';
				}
			}
		}
		else
		{
			$message = '<div style="width:650px;" class="error message">
			<h3 style="color:white">Erreur</h3>
			<p>Au moins un des champs est vide.</p></div>';
		}
	}	
}
if (isset($message)) echo $message; echo'
<form action="" method="post">
	<label>Login / Pseudo :</label>
	<input type="text" name="pseudo_adm" value="'.$user->login.'" required=required />
	<label>Nouveau Mot de passe :</label>
	<input type="password" name="pass_md5" value="" required=required />
	<label>Confirmation du mot de passe :</label>
	<input type="password" name="pass_confirm" value="" required=required />
	<input type="hidden" name="id_user" value="'.$user->id.'" />
<legend>Rôle de l\'utilisateur :</legend>
<label for="regularRadio">
	<input type="radio" name="grade" value="1" id="1" ';if ($user->niveau==1) { echo 'checked="checked"'; } echo' /> 
	<span>Administrateur</span>
</label>
<label for="regularRadio">
	<input type="radio" name="grade" value="2" id="2" ';if ($user->niveau==2) { echo 'checked="checked"'; } echo' />
	<span>Modérateur</span>
</label>
<br/>
<input type="hidden" name="submit" value="Submit" />
<input type="submit" name="submit" value="Mettre à jour" />
</form>';
