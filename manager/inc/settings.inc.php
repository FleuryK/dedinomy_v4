<?php if (!defined('SCR_NAME')) exit('No direct script access allowed');
Security::is_admin();
if (isset($_POST['id']))
{
	$message = 'Mise à jour effectuée avec succès !';
	Sql::update("UPDATE ".cfg." SET site='".$_POST['site']."', nb_aff='".$_POST['nb_dedi']."', erreur_mod='".$_POST['int_mod']."', adr_dedi='".$_POST['adr_scr']."', mail='".$_POST['mail_adm']."', msg_mnt='".$_POST['msg_mnt']."', msg_poster_val='".$_POST['msg_poster_val']."', msg_poster='".$_POST['msg_poster']."',val_dedi='".$_POST['val_dedi']."', ca_post='".$_POST['ca_post']."', captcha='".$_POST['captcha']."',api_publish_dedi='".$_POST['api_publish_dedi']."',api_list_dedi='".$_POST['api_list_dedi']."',api_delete_dedi='".$_POST['api_delete_dedi']."',moderation='".$_POST['moderation']."',date_onoff='".$_POST['datetime_status']."',adm_nb_page='".$_POST['adm_nb_page']."' WHERE id='1'");
}
if (isset($message)) echo '
	<div style="width:650px; padding-top: 75px;" class="success message">
		<h3 style="color:white">Paramètres modifiés</h3>
		<p>Vos paramètres ont été modifié avec succès - cliquez sur cette boîte pour la fermer.</p>
	</div>';
	?>
	<form action="#" method="post">
		<h1>Paramètres de configuration</h1>
		<hr class="large" />
		<div class="five columns alpha">
			<br />
			<h4>Paramètres du script</h4>
			<hr class="large"/>
			Vous pouvez modifier l'url d'accès à Dédinomy <strong>seulement, et seulement si</strong> vous êtes sûr de ce que vous faîtes. Nous avons détecté l'url suivante : <em style="color:grey">http://<?php echo $_SERVER["HTTP_HOST"].dirname(dirname($_SERVER["PHP_SELF"]));?></em>
			<input style="margin-top:10px;" type="url" size="30" name="adr_scr" value="<?php if (isset($_POST['adr_scr'])) echo $_POST['adr_scr']; else echo $settings->adr_dedi;?>" required=required />
			<strong>Nom de Votre Site :</strong>
			<br />
			<input type="text" size="30" name="site" value="<?php if (isset($_POST['site'])) echo $_POST['site']; else echo $settings->site;?>" required=required />
			<div class="doc-section" id="mediaQueries"></div>
			<br />
			<h4>Formulaire d'envoi</h4>
			<hr class="large"/>
			<fieldset>
				<legend>Publication des nouvelles dédicaces</legend>
				<label for="regularRadio">
					<input type="radio" name="val_dedi" value="1" <?php if($settings->val_dedi == 1) { echo 'checked'; }?> />
					<span>Automatique</span>
				</label>
				<label for="secondRegularRadio">
					<input type="radio" name="val_dedi" value="0" <?php if($settings->val_dedi == 0) { echo 'checked'; }?> />
					<span>Modération</span>
				</label>
			</fieldset>
			<fieldset>
				<legend>Protection par Captcha anti-spam</legend>
				<label for="regularRadio">
					<input type="radio" name="captcha" value="1" <?php if($settings->captcha == 1) { echo 'checked'; }?> />
					<span>Activé</span>
				</label>
				<label for="secondRegularRadio">
					<input type="radio" name="captcha" value="0" <?php if($settings->captcha == 0) { echo 'checked'; }?> />
					<span>Désactivé</span>
				</label>
			</fieldset>
			<strong>Caractères max de la dédicace</strong>
			<br />
			<input type="number" size="30" name="ca_post" value="<?php if(isset($_POST['ca_post'])) echo $_POST['ca_post']; else echo $settings->ca_post; ?>" required=required pattern="[0-9]{1,5}" />
			<strong>Mots interdits séparés par une virgule</strong>
			<br />
			<input type="text" size="30" name="moderation" value="<?php if(isset($_POST['moderation'])) echo $_POST['moderation']; else echo $settings->moderation;?>" required=required />
			<br />
			<h4>Administration</h4>
			<hr class="large"/>
			<strong>Éléments affichées par page</strong><br />
			<input type="text" size="30" name="adm_nb_page" value="<?php if (isset($_POST['adm_nb_page'])) echo $_POST['admin_nb_page']; else echo $settings->adm_nb_page;?>" required=required pattern="[0-9]{1,5}" />
		</div>
		<div class="six columns omega">
			<br />
			<h4>Gestion Mail</h4>
			<hr class="large"/>
			<strong>E-Mail de l'administrateur du site</strong><br />
			<input type="email" size="30" name="mail_adm" value="<?php if(isset($_POST['mail_adm'])) echo $_POST['mail_adm']; else echo $settings->mail;?>" required=required />
			<div class="doc-section" id="mediaQueries"></div>
			<br />
			<h4>Affichage des dédicaces</h4><hr class="large"/>
			<strong>Nombre de dédicaces affichées</strong><br />
			<input type="text" size="30" name="nb_dedi" value="<?php if (isset($_POST['nb_dedi'])) echo $_POST['nb_dedi']; else echo $settings->nb_aff;?>" required=required pattern="[0-9]{1,5}" />
			<fieldset>
				<legend>Affichage de la date & heure à coté des dédicaces</legend>
				<label for="regularRadio">
					<input type="radio" name="datetime_status" value="1" <?php if($settings->date_onoff == 1) { echo 'checked'; }?> />
					<span>Activé</span>
				</label>
				<label for="secondRegularRadio">
					<input type="radio" name="datetime_status" value="0" <?php if ($settings->date_onoff == 0) { echo 'checked'; }?> />
					<span>Désactivé</span>
				</label>
			</fieldset>
			<br />
			<h4>API Dédinomy</h4><hr class="large" />
			<table class="striped" cellspacing="0" cellpadding="0">
				<thead>
					<tr class="alt first last">
						<th></th>
						<th><h6>Public</h6></th>
						<th><h6>Privé</h6></th>
					</tr>
				</thead>
				<tbody>
					<tr class="alt">
						<td>list_dedi</td>
						<td><input type="radio" name="api_list_dedi" value="0" <?php if ($settings->api_list_dedi == 0) { echo 'checked'; }?> /></td>
						<td><input type="radio" name="api_list_dedi" value="1" <?php if ($settings->api_list_dedi == 1) { echo 'checked'; }?> /></td>
					</tr>
					<tr>
						<td>publish_dedi</td>
						<td><input type="radio" name="api_publish_dedi" value="0" <?php if ($settings->api_publish_dedi == 0) { echo 'checked'; }?> /></td>
						<td><input type="radio" name="api_publish_dedi" value="1" <?php if ($settings->api_publish_dedi == 1) { echo 'checked'; }?> /></td>
					</tr>
					<tr>
						<td>delete_dedi</td>
						<td><input type="radio" name="api_delete_dedi" value="0" <?php if ($settings->api_delete_dedi == 0) { echo 'checked'; }?> /></td>
						<td><input type="radio" name="api_delete_dedi" value="1" <?php if ($settings->api_delete_dedi == 1) { echo 'checked'; }?> /></td>
					</tr>
				</tbody>
			</table>    
			<strong>L'API Dédinomy</strong> vous permet d'accéder aux dédicaces en dehors du script, et d'offrir à vos utilisateurs une autre expérience. Vous pouvez limiter l'accès aux informations - <strong>en mode public</strong>, c'est à dire ouvert, ou en <strong>mode privé</strong> nécessitant une clef API pour pouvoir obtenir les données. Pour plus d'informations, connectez-vous au forum NuBOX.
			<strong>Votre clef API secrète :</strong> <input type="text" style="margin-top:5px; width:260px; " name="key" readonly="readonly" value="<?php echo $settings->api_key;?>" />
		</div>
		<div class="eleven columns alpha">
			<br />
			<hr class="large"/>
			<h3>Messages Personnalisés</h3>
			<ul class="tabs">
				<li><a class="active" href="#Maintenance">Maintenance active</a></li>
				<li><a href="#MessagePub">Message publié</a></li>
				<li><a href="#MessageVal">Message modéré</a></li>
				<li><a href="#Moderateur">Message accès modérateur</a></li>
			</ul>
			<ul class="tabs-content">
				<li class="active" id="Maintenance">
					<strong>Message affiché aux visiteurs lorsque la maintenance est active</em><br />
					</strong>
					<textarea rows="10" cols="620" name="msg_mnt" class="ckeditor" required=required><?php echo $settings->msg_mnt; ?></textarea>
				</li>
				<li id="MessagePub">
					<strong>Message affiché lorsqu'une nouvelle dédicace est soumise à validation<br />
					</strong>
					<textarea rows="10" cols="620" name="msg_poster_val" class="ckeditor" required=required><?php echo $settings->msg_poster_val;?></textarea>
				</li>
				<li id="MessageVal">
					<strong>Message affiché lorsqu'une nouvelle dédicace n'est pas soumise à validation<br />
					</strong>
					<textarea rows="10" cols="620" name="msg_poster" class="ckeditor" required=required><?php echo $settings->msg_poster; ?></textarea>
				</li>
				<li id="Moderateur">
					<strong>Message d'interdiction à afficher aux modérateurs lorsque qu'il tentent d'accéder à une page qui ne leur est pas autorisée<br />
					</strong>
					<textarea rows="10" cols="620" name="int_mod" class="ckeditor" required=required><?php echo $settings->erreur_mod;?></textarea>	
				</li>
			</ul>
		</div>
		<?php echo' 
		<br /><br /><input type="hidden" name="id" value="1" />
		<div style="top: 0px;position:fixed;background:#EBEBEB;width:700px;opacity:0.80;">
			<button style="margin-left:10px;margin-top:10px;" class="button" value="submit">Enregistrer les paramètres</button>
		</form>';?>
