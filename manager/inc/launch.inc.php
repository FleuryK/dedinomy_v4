<?php if (!defined('SCR_NAME')) exit('No direct script access allowed');
Security::is_admin();?>	
<header>
	<h1>Mise à jour de Dédinomy</h1>
</header>
<hr class="large" />
<div class="doc-section" id="whatAndWhy">
	<p>Nous vous invitons à installer <strong>les mises à jour</strong> afin de remplacer votre <strong>version actuelle de Dédinomy</strong>. Les mises à jour apportent de nouvelles fonctions, des patchs de sécurité, ainsi que des corrections de bugs.</p>
	<?php
		echo Update::launch();
	?>
</div>