<?php if (!defined('SCR_NAME')) exit('No direct script access allowed');
Security::is_admin();?>
<header>
	<h1>Mise à jour de Dédinomy</h1>
</header>
<hr class="large" />
<div class="doc-section" id="whatAndWhy">
	<p>Nous vous invitons à installer <strong>les mises à jour</strong> afin de remplacer votre <strong>version actuelle de Dedinomy.</strong> Les mises à jour apportent de nouvelles fonctions, des patchs de sécurité, ainsi que des corrections de bugs.</p>
	<?php
	if(!Update::check())
	{
		echo '<div style="margin-left:170px;margin-top:70px;width:220px;border-radius:10px;padding:10px;padding-left:30px;padding-right:30px;font-size:15px;background:#393939;color:#909090"> Votre système est à jour ! </div>';
	}
	else
	{
		echo Update::info();
	}
	?>
</div>