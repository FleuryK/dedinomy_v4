<?php
$config = array(
	'title' => 'DédiNomy 5',
	'description' => 'Cet assistant va vous guider à travers le processus d\'installation',
	'wizard_file' => 'index.php',
	'copyright' => '<a href="http://manager.nubox.fr" target="_blank">NuBOX DevTeam</a> &copy; 2008-'.date('Y'),
	'show_steps' => true,
	'show_back_button' => true,
	'view' => 'default',
	'language' => 'fr',
	'db_type' => 'mysqli',
	'db_show_queries' => false,
	'db_charset' => 'utf8',
	'db_collation' => 'utf8_general_ci',
	'api_key'=> sha1(base64_encode(rand())),
);