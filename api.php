<?php
header('Content-Type: text/html; charset=utf-8');
require('functions.php');
System::is_ban();
function token($data)
{
	global $settings;
	$token = $settings->api_key;
	if ($data!=$token)
	{
		$response = array('statut'=>'error','message'=>'Une clef d\'API VALIDE est necessaire pour accéder à cette fonction.');
		return json_encode($response);
	}
}
function t_statut_access($method)
{
	global $settings;
	if($method=='list_dedi')
	{
		return $settings->api_list_dedi;
	}
	if($method=='publish_dedi')
	{
		return $settings->api_publish_dedi;
	}
	if($method=='delete_dedi')
	{
		return $settings->api_delete_dedi;
	}
}
function f_statut_access($method)
{
	global $settings;
	if($method=='list_dedi')
	{
		if($settings->api_list_dedi){return true;}else{return false;}
	}
	if($method=='publish_dedi')
	{
		if($settings->api_publish_dedi){return true;}else{return false;}
	}
	if($method=='delete_dedi')
	{
		if($settings->api_delete_dedi){return true;}else{return false;}
	}
}
/* ___________________________________________________________ 
/**
* FONCTION POUR LISTER LES DEDICACES 
* api.php?method=list_dedi
* 
*/
if (isset($_GET['method']) && $_GET['method']=='list_dedi')
{
	if(f_statut_access('list_dedi'))
	{
		token($_GET['token']);
	}
	$result = Sql::getAll("SELECT * FROM ".text." WHERE val='1'");
	$response = array();
	$response['statut']='OK';
	$posts = array();
	foreach($result as $row)
	{
		$pseudo=$row['pseudo'];
		$message= $row['message'];
		$timestamp= $row['timestamp'];
		$id=$row['id'];
		$val=$row['val'];
		$iptrace=$row['iptrace'];
		$posts[] = array('id'=> $id,'pseudo'=> $pseudo, 'message'=> $message, 'timestamp'=>$timestamp, 'val'=>$val,'iptrace'=>$iptrace);
	} 
	$response['results'] = $posts;
	return json_encode($response);
}
/* ___________________________________________________________ 
/**
* FONCTION POUR SUPPRIMER UNE DEDICACE 
* api.php?method=delete_dedi&id=2
* 
*/
if (isset($_GET['method']) && $_GET['method']=='delete_dedi')
{
	if(f_statut_access('delete_dedi'))
	{
		token($_GET['token']);
	}
	$response = array();
	if(!isset($_GET['id']) OR !$_GET['id'])
	{
		$response['statut']='error';
	}
	else
	{
		$id = $_GET['id'];
		$result = Sql::get("DELETE FROM ".text." WHERE id='$id'");
		$response['statut']='OK';
	}
	return json_encode($response);
}
/* ___________________________________________________________ 
/**
* FONCTION POUR PUBLIER AUTOMATIQUEMENT DEDICACES VIA API [TOKEN]
* api.php?token=XXXX&method=publish_dedi
* Token nécessaire pour cette fonction
*/
if (isset($_GET['method']) AND $_GET['method']=='publish_dedi')
{
	if(f_statut_access('publish_dedi'))
	{
		token($_GET['token']);
	}
	$val = false;
	if(!isset($_GET['data_pseudo']) OR empty($_GET['data_pseudo']))
	{
		$response = array('statut'=>'error','message'=>'Vous devez ajouter un pseudo via la methode data_pseudo');
		return json_encode($response);
	}
	elseif(!isset($_GET['data_message']) OR empty($_GET['data_message']))
	{
		$response = array('statut'=>'error','message'=>'Vous devez ajouter un message via la methode data_message');
		return json_encode($response);
	}
	if ($_GET['data_val'])
	{
		$val = true;
	}
	$pseudo = $_GET['data_pseudo'];
	$message = $_GET['data_message'];
	Sql::insert("INSERT INTO ".text." (id,pseudo,message,timestamp,val,iptrace) VALUES ('','$pseudo','$message','".time()."','$val','".$iptrace."')");
	$id = Sql::$_lastId;
	$result = $db->get("SELECT * FROM ".text." WHERE id='$id'");
	$response['statut']='succes';
	$posts = array();
	foreach($result as $row)
	{ 
		$pseudo=$row->pseudo; 
		$message=$row->message;
		$val=$row->val;
		$id=$row->id;
		$timestamp=$row->timestamp;
		$iptrace=$row->iptrace;
		$posts = array('id'=> $id,'pseudo'=> $pseudo, 'message'=> $message,'val'=>$val,'timestamp'=>$timestamp,'iptrace'=>$iptrace);
	}
	$response['results'] = $posts;
	return json_encode($response);
}
/* ___________________________________________________________ 
/**
* FONCTION POUR VERIFIER SI METHODE NECESSITE CLEF API 
* api.php?method=statut_access&to=XXXXX
* 
*/
if (isset($_GET['method']) && isset($_GET['to']) && $_GET['method']=='statut_access')
{
	t_statut_access($_GET['to']);
}
/* ___________________________________________________________ 
/**
* FONCTION POUR VERIFIER SI METHODE NECESSITE CLEF API 
* api.php?method=verif_api&key=XXXXX
* 
*/
if (isset($_GET['method']) && isset($_GET['key']) && $_GET['method']=='verif_api')
{
	token($_GET['key']);
}
/* ___________________________________________________________ */