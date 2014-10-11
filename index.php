<?php
header('Content-Type: text/html; charset=utf-8');
require('functions.php');
$data=Sql::getAll('SELECT * FROM '.text.' WHERE val="1" ORDER BY id DESC LIMIT 0,'.$settings->nb_aff);
foreach($data as $k)
{
	$tpl->assignArray('dedicace', array(
		'id'=>$k->id,
		'pseudo' => $k->pseudo,
		'message'=> $k->message,
		'timestamp' => date('d/m/y H:i',$k->timestamp),
		'val' => $k->val,
		'iptrace' => $k->iptrace
		)
	);
}
$tpl->assign(array(
	'datetime'=> $settings->date_onoff,
	'site_name'=>$settings->site.' - DediNomy',
	)
);
$tpl->parse('dedi.tpl');