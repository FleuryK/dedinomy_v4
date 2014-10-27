<?php if (!defined('SCR_NAME')) exit('No direct script access allowed');?>
<header>
	<h1>Modifier une dédicace</h1>
</header>    
<?php 
$sql = Sql::get("SELECT * FROM ".text." WHERE id='".$_GET['id']."'");
if (isset($_POST['pseudo']) AND isset($_POST['message']))
{
	echo '<div style="width:650px;" class="success message">
	<h3 style="color:white">Dédicace modifiée avec succès</h3>
	<p>La dédicace à été modifiée avec succès.</p></div>';
	Sql::update("UPDATE ".text." SET pseudo='".$_POST['pseudo']."', message='".$_POST['message']."' WHERE id='".$_POST['id']."'");
}
$disable='';
if($sql->pseudo=="SMS"){$disable='disabled="disabled" ';}
echo'<form action="#" method="post">
<label>Pseudo :</strong></label><input type="text" size="30" name="pseudo" value="'.$sql->pseudo.'" '.$disable.' required=required /><br />
<label>Message :</strong></label>
<input type="text" size="50" name="message" value="'.$sql->message.'" required=required />
<input type="hidden" name="id" value="'.$sql->id.'" />
<input type="submit" class="button" value="Modifier la dédicace" />
</form>';
