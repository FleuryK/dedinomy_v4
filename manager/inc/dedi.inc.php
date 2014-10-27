<?php if (!defined('SCR_NAME')) exit('No direct script access allowed');?>
<header>
	<h1>Dédicaces</h1>
</header>
<script>
	var checkflag = "false"; 
	function check(field)
	{ 
		if (checkflag == "false")
		{ 
			for (i = 0; i < field.length; i++)
			{ 
				field[i].checked = true;
			} 
			checkflag = "true"; 
			return "Tout décocher";
		} 
		else
		{ 
			for (i = 0; i < field.length; i++)
			{ 
				field[i].checked = false;
			} 
			checkflag = "false"; 
			return "Tout cocher";
		} 
	}
</script>
<ul class="tabs">
	<li><a class="moderation" href="#moderation">En attente de modération <?php echo Tools::notification();?></a></li>
	<li><a class="enligne" href="#enligne">En ligne</a></li>
	<li><a href="#publier">Publier sous <strong><?php echo $userdata->login ;?></strong></a></li>
</ul>
<ul class="tabs-content">
	<li class="moderation" id="moderation">  
		<?php 
		if (isset($_POST['del']))
		{
			$sup = '<div style="width:650px;" class="error message">
					<h3 style="color:white">Dédicaces supprimées</h3>
					<p>Les dédicaces ont été supprimées avec succès.</p>
					</div>';
			foreach(Security::sanitize($_POST['choix']) as $val)
			{
				Sql::delete("DELETE FROM ".text." WHERE id='".$val."'");
			}
		}
		if (isset($_GET['sup']))
		{
			$sup = '<div style="width:650px;" class="error message">
					<h3 style="color:white">Dédicace supprimée</h3>
					<p>La dédicace à été supprimée avec succès du site.</p>
					</div>';
			Sql::delete("DELETE FROM ".text." WHERE id='".Security::sanitize($_GET["sup"])."'");
		}
		if (isset($_GET['val']))
		{
			$val = '<div style="width:650px;" class="success message">
					<h3 style="color:white">Dédicace publiée</h3>
					<p>La dédicace a bien été validée - elle est désormais affichée sur le site.</p>
					</div>';
			Sql::update("UPDATE ".text." SET val='1' WHERE id='".Security::sanitize($_GET["val"])."'");
		}
		$total_moderation=Sql::Pcount(text,"WHERE val='0'");
		$epp_moderation=$settings->adm_nb_page;
		$nbPages_moderation=ceil($total_moderation / $epp_moderation);
		$current_moderation=1;
		if (isset($_GET['dpm']) && is_numeric($_GET['dpm']))
		{
        	$page_moderation = intval(Security::sanitize($_GET['dpm']));
	        if ($page_moderation >= 1 && $page_moderation <= $nbPages_moderation)
	        {
	            $current_moderation=$page_moderation;
	        }
	        elseif ($page_moderation < 1)
	        {
	            $current_moderation=1;
	        }
	        else
	        {
	            $current_moderation = $nbPages_moderation;
	        }
    	}
    	$start_moderation=($current_moderation * $epp_moderation - $epp_moderation);
    	$sql_moderation=Sql::getAll("SELECT * FROM ".text." WHERE val='0' ORDER BY id DESC LIMIT $start_moderation,$epp_moderation");
		if(isset($val))
		{
			echo $val;
		}
		if($sql_moderation)
		{
			echo '<table class="striped" cellspacing="0" cellpadding="0">
					<thead><tr class="alt first last">
					<th><h6>Utilisateur</h6></th>
					<th><h6>Date de publication</h6></th>
					<th><h6>Contenu</h6></th>
					<th><h6>Actions</h6></th>
					</tr></thead>
					<tbody>';
			foreach ($sql_moderation as $rep_moderation)
			{
				if(!$rep_moderation->val)
				{
					echo'<tr class="alt">
						<td><h6>'.$rep_moderation->pseudo.' </h6><em>'.$rep_moderation->iptrace.'</em></td>
						<td><bold>'.date('d/m/Y', $rep_moderation->timestamp).'</bold></td>
						<td>'.$rep_moderation->message.'</td>
						<td style="width:250px;"><ul class="button-bar">
						<li class="first"><a href="?pcat=edit_dedi&id='.$rep_moderation->id.'">Editer</a></li>
						<li><a href="?pcat=dedi&sup='.$rep_moderation->id.'#moderation">Supprimer</a></li>
						<li class="last"><a href="?pcat=dedi&val='.$rep_moderation->id.'#moderation">Valider</a></li>
						</ul></td>
						</tr>';
				}
			}
			echo'</tbody></table>';
			echo Paginate::numbers('?pcat=dedi', '&dpm=', $nbPages_moderation, $current_moderation,3,'#moderation');
		}
		else
			echo '<div style="margin-left:200px;margin-top:70px;width:190px;border-radius:10px;padding:10px;padding-left:30px;padding-right:30px;font-size:15px;background:#393939;color:#909090">Aucune dédicace à modérer</div>';
		?>
	</li>
	<li id="enligne">
		<?php 
		if(isset($sup))
		{
			echo $sup;
		}                                                     
		echo '<form method="post" action="">
				<input type="submit" name="del" value="Supprimer la sélection" class="button">
				<table class="striped" cellspacing="0" cellpadding="0">
				<thead><tr class="alt first last">
				<th><input name="tout" type="checkbox" onClick="this.value=check(this.form);" />
				</th>
				<th><h6>Utilisateur</h6></th>
				<th><h6>Date</h6></th>
				<th><h6>Contenu</h6></th>
				<th><h6>Actions</h6></th>
				</tr></thead>
				<tbody>';
		$total_enligne=Sql::Pcount(text,"WHERE val='1'");
		$epp_enligne=$settings->adm_nb_page;
		$nbPages_enligne=ceil($total_enligne / $epp_enligne);
		$current_enligne=1;
		if (isset($_GET['dpl']) && is_numeric($_GET['dpl']))
		{
        	$page_enligne = intval($_GET['dpl']);
	        if ($page_enligne >= 1 && $page_enligne <= $nbPages_enligne)
	        {
	            $current_enligne=$page_enligne;
	        }
	        elseif ($page_enligne < 1)
	        {
	            $current_enligne=1;
	        }
	        else
	        {
	            $current_enligne = $nbPages_enligne;
	        }
    	}
    	$start_enligne=($current_enligne * $epp_enligne - $epp_enligne);
    	$sql_enligne=Sql::getAll("SELECT * FROM ".text." WHERE val='1' ORDER BY id DESC LIMIT $start_enligne,$epp_enligne");
		foreach($sql_enligne as $rep_enligne)
		{
			echo'<tr class="alt">
				<td><input type="checkbox" name="choix[]" value="'.$rep_enligne->id.'"></td>
				<td><h6>'.$rep_enligne->pseudo.' </h6><em>'.$rep_enligne->iptrace.'</em></td>
				<td><bold>'.date('d/m/Y', $rep_enligne->timestamp).'</bold></td>
				<td>'.$rep_enligne->message.'</td>
				<td style="width:150px;"><ul class="button-bar">
				<li class="first"><a href="?pcat=edit_dedi&id='.$rep_enligne->id.'">Editer</a></li>
				<li class="last"><a href="?pcat=dedi&sup='.$rep_enligne->id.'#enligne">Supprimer</a></li>
				</ul></td>
				</tr>';
		}
		echo'</tbody></table>';
		echo Paginate::numbers('?pcat=dedi', '&dpl=', $nbPages_enligne, $current_enligne,3,'#enligne');
		?>
	</li>
	<li id="publier">
		<?php if (isset($_POST['pseudo']) AND isset($_POST['message']))
		{
			if (!$_POST['id'])
			{
				echo $ins = '<div style="width:650px;" class="success message">
						<h3 style="color:white">Dédicace publiée</h3>
						<p>La dédicace a bien été publié - elle est désormais affichée sur le site.</p>
						</div>';
				Sql::insert("INSERT INTO ".text." VALUES('', '".Security::sanitize($_POST['pseudo'])."', '".Security::sanitize($_POST['message'])."', '".time()."', '1', '".$iptrace."')");
			}
		}
		else
		{
			echo '<form action="" method="post">
					<p><strong>Pseudo :</strong><br />
					<input type="text" size="30" name="pseudo" value="'.$userdata->login.'" required=required /></p>
					<p><strong>Message :</strong>
					<textarea rows="10" name="message">'; if(isset($_POST['message'])){echo Security::sanitize($_POST['message']);}echo'</textarea></p>
					<input type="hidden" name="id" value="0" />
					<button class="button" type="submit">Publier la dédicace</button>
					</form>';
		}
		?>
	</li>
</ul>
