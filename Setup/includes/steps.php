<?php
$steps = array(
	// Step 1
	array(
		'name' => $this->language['step_1_name'],
		'fields' => array(
			array(
				'type' => 'info',
				'value' => $this->language['step_1_value1'],
			),
			array(
				'type' => 'language',
				'label' => 'Language',
				'name' => 'language',
			),
		),
	),
	// Step 2
	array(
		'name' => $this->language['step_2_name'],
		'fields' => array(
			array(
				'type' => 'info',
				'value' => $this->language['step_2_value1'],
			),
			array(
				'type' => 'info',
				'value' => $this->language['step_2_value2'],
			),
			array(
				'type' => 'php-config',
				'label' => $this->language['step_2_label3'],
				'items' => array(
					'php_version' => array('>=5.2', $this->language['PHP_Version']),
					'register_globals' => false,
					'safe_mode' => false,
				),
			),
			array(
				'type' => 'php-modules',
				'label' => $this->language['step_2_label4'],
				'items' => array(
					'mysql' => array(true, 'MySQL'),
					'curl'=>array(true, 'Curl'),
					'ionCube Loader'=>array(true, 'IonCube Loader'),
				),
			),
			array(
				'type' => 'file-permissions',
				'label' => $this->language['step_2_label5'],
				'items' => array(
					'../Core/Templating' => 'write',
					'../Core/Templating/cache/' => 'write',
					'../Core/Templating/compile/' => 'write',
					'../themes/' => 'write',
					'../themes/dedinomy_classi/' => 'write',
					'../Conf.d/' => 'write',
				),
			),
		),
	),
	// Step 3
	array(
		'name' => $this->language['step_3_name'],
		'fields' => array(
			array(
				'type' => 'info',
				'value' => $this->language['step_3_value1'],
			),
			array(
				'type' => 'text',
				'label' => $this->language['step_3_label3'],
				'name' => 'virtual_path',
				'default' => rtrim(preg_replace('#/Setup/$#', '', VIRTUAL_PATH), '/').'/',
				'validate' => array(
					array('rule' => 'required'),
				),
			),
			array(
				'type' => 'text',
				'label' => $this->language['step_3_label4'],
				'name' => 'system_path',
				'default' => rtrim(preg_replace('#/Setup/$#', '', BASE_PATH), '/').'/',
				'validate' => array(
					array('rule' => 'required'),
				),
			),
		),
	),
	// Step 4
	array(
		'name' => $this->language['step_4_name'],
		'fields' => array(
			array(
				'type' => 'info',
				'value' => $this->language['step_4_value1'],
			),
			array(
				'type' => 'info',
				'value' => $this->language['step_4_value2'],
			),
			array(
				'label' => $this->language['step_4_label3'],
				'name' => 'db_hostname',
				'type' => 'text',
				'default' => 'localhost',
				'validate' => array(
					array('rule' => 'required'),
				),
			),
			array(
				'label' => $this->language['step_4_label4'],
				'name' => 'db_username',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required'),
				),
			),
			array(
				'label' => $this->language['step_4_label5'],
				'name' => 'db_password',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required'),
				),
			),
			array(
				'label' => $this->language['step_4_label6'],
				'name' => 'db_name',
				'type' => 'text',
				'default' => '',
				'highlight_on_error' => true,
				'validate' => array(
					array('rule' => 'required'),
					array(
						'rule' => 'database',
						'params' => array(
							'db_host' => 'db_hostname',
							'db_user' => 'db_username',
							'db_pass' => 'db_password',
							'db_name' => 'db_name',
							'db_prefix' => 'db_prefix'
						)
					),
				),
			),
			array(
				'label' => $this->language['step_4_label7'],
				'name' => 'db_prefix',
				'type' => 'text',
				'default' => 'dedi',
				'highlight_on_error' => true,
				'validate' => array(
					array('rule' => 'required'),
					array(
						'rule' => 'database',
						'params' => array(
							'db_host' => 'db_hostname',
							'db_user' => 'db_username',
							'db_pass' => 'db_password',
							'db_name' => 'db_name',
							'db_prefix' => 'db_prefix'
						)
					),
				),
			),
		),
	),
	// Step 5
	array(
		'name' => $this->language['step_5_name'],
		'fields' => array(
			array(
				'type' => 'info',
				'value' => $this->language['step_5_value1'],
			),
		),
		'callbacks' => array(
			array('name' => 'install'),
		),
	),



	// Step 6
	array(
		'name'=>'Configuration',
		'fields'=>array(
			array(
				'type'=>'info',
				'value'=>'<span style="color:dimgrey; font-weight:bold">Création des identifiants de l\'administrateur</span>',
				),
			array(
				'label'=>'Nom d\'utilisateur',
				'type'=>'text',
				'default'=>'',
				'name'=>'adm_username',
				'highlight_on_error'=>true,
				'validate'=>array(
					array('rule'=>'required'),
					),
				),
			array(
				'label'=>'Mot de passe',
				'type'=>'text',
				'default'=>'',
				'name'=>'adm_password',
				'highlight_on_error'=>true,
				'validate'=>array(
					array('rule'=>'required'),
					),
				),
			array(
				'type'=>'info',
				'value'=>'',
				),
			array(
				'type'=>'info',
				'value'=>'<span style="color:dimgrey; font-weight:bold">Configuration du script</span>',
				),
			array(
				'label'=>'Votre E-Mail',
				'type'=>'text',
				'default'=>'',
				'name'=>'adm_mail',
				'highlight_on_error'=>true,
				'validate'=>array(
					array('rule'=>'required'),
					array('rule'=>'valid_email'),
					),
				),
			array(
				'label'=>'Nom de votre site',
				'type'=>'text',
				'default'=>'',
				'name'=>'adm_sitename',
				'highlight_on_error'=>true,
				'validate'=>array(
					array('rule'=>'required'),
					),
				),
			array(
				'label'=>'Adresse de votre site',
				'type'=>'text',
				'default'=>(isset($_SESSION['params']['virtual_path']))?$_SESSION['params']['virtual_path']:'0',
				'name'=>'adm_siteurl',
				'highlight_on_error'=>true,
				'validate'=>array(
					array('rule'=>'required'),
					),
				),
			),
		'callbacks'=>array(
			array(
				'name' => 'configuration',
        		'execute' => 'after',
        		'params' => array()
				),
			),
		),
	// Step 7
	array(
		'name' => $this->language['step_6_name'],
		'fields' => array(
			array(
				'type' => 'info',
				'value' => $this->language['step_6_value1'],
			),
			array(
				'type' => 'info',
				'value' => $this->language['step_6_value2'].'<a href="'.rtrim(isset($_SESSION['params']['virtual_path']) ? $_SESSION['params']['virtual_path'].'manager' : '', '/').'" target="_blank">'.rtrim(isset($_SESSION['params']['virtual_path']) ? $_SESSION['params']['virtual_path'].'manager' : '', '/').'</a>'),
			array(
				'type' => 'info',
				'value' => $this->language['step_6_value3'],
			),
			array(
				'type' => 'info',
				'value' => $this->language['step_6_value5'],
			),
		),
		'callbacks' => array(
			array('name' => 'reset_session'),
		),
	),
);