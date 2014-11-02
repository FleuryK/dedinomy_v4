<?php if (!defined('SCR_NAME')) exit('No direct script access allowed');
Security::is_admin() ?>
<header>
	<h1>Gestion des IP bannies</h1>
</header>
<ul class="tabs">
	<li><a class="moderation" href="#simple">Toutes les IP bannies</a></li>
	<li><a class="enligne" href="#enligne">Ajouter un nouveau ban</a></li>
</ul>       
<?php 
if (isset($_GET['aut']))
{
	$_GET['sup'] = $_GET['aut'];
	Sql::delete("DELETE FROM ".bans." WHERE id='".$_GET["aut"]."'");
		echo '<div style="width:650px;" class="success message">
				<h3 style="color:white">L\'IP a bien été autorisé à accéder aux dédicaces</h3>
				</div>';
}
if (isset($_POST['newip']))
{
	if ((isset($_POST['ip']) && !empty($_POST['ip'])))
	{
		$req = Sql::count("SELECT * FROM ".bans." WHERE ip='". Security::sanitize($_POST['ip'])."'");
		if ($req == 0)
		{
			Sql::insert("INSERT INTO ".bans." (ip) VALUES('".Security::sanitize($_POST['ip'])."')");
			echo '<div style="width:650px;" class="success message">
				<h3 style="color:white">L\'IP '.Security::sanitize($_POST['ip']).' a bien été banni</h3>
				<p>Cette IP ne pourra plus accéder aux dédicaces tant qu\'elle n\'aura pas été réautorisée</p>
				</div>';
		}
	}
	else
	{
		echo  $error = '<div style="width:650px;" class="error message">
			<h3 style="color:white">OhOhOh - Erreur</h3>
			<p>Tous les champs sont obligatoires !</p>
			</div>';
	}
}
?>
<ul class="tabs-content">
	<li class="moderation" id="simple">
		<table class="striped" cellspacing="0" cellpadding="0">
			<thead>
				<tr class="alt first last">
					<th><h6>Adresse IP</h6></th>
					<th><h6>Action</h6></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$retour = Sql::getAll("SELECT * FROM ".bans." ORDER BY id");
				foreach ($retour as $data)
				{
					echo'<tr class="alt">
						<td class="tbladmin-td"><strong>'.$data->ip.'</strong></td>
						<td style="width:580px;"><ul class="button-bar">
						<li class="last"><a href="?pcat=ban&aut='.$data->id.'">Autoriser l\'accès</a></li>
						</ul></td>
						</tr>';
				}
			?>
			</tbody>
		</table>
	</li>
	<li id="enligne">
		<?php
		echo '<form action="index.php?pcat=ban" method="post">
			<p>Adresse IP (ex:102.12.12.1) :
			<input type="text" name="ip" value="'; if (isset($_POST['ip'])) echo Security::sanitize($_POST['ip']); echo'" required=required />
			<button class="button" name="newip" type="submit">Bannir cette IP</button>
			</p>
			</form>';?>
	</li>
</ul>
