<?php
header('Content-Type:text/html; charset=UTF-8');
class api_dedinomy
{
	private $url;
	private $api_key;
	private $curl;
	public function __construct($url = null)
	{
		if(is_array($url))
		{
			$link = $url['url'];
			$curl = true;
			(isset($url['api_key']))? $this->api_key = $url['api_key']:$this->api_key='';
		}
		else
		{
			$link=$url;
		}
		$ch=curl_init($link.'/api.php');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$statut=curl_exec($ch);
		$error=curl_errno($ch);
		curl_close($ch);
		if($error!='')
		{
			die('<strong>Erreur</strong> - La bibliotheque API de votre site n\'a pas été trouvé, merci de corriger votre URL');
		}
		$this->url = $link.'/api.php?';
		$this->curl = $curl;
	}
	private function api_requete($url)
	{
		$apar = $this->url.$url;
		$ch=curl_init($apar);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$statut=curl_exec($ch);
		curl_close($ch);
		return $statut;
	}
	public function list_dedi()
	{
		$statut = $this->api_requete('method=statut_access&to=list_dedi'); 
		if ($statut)
		{
			if(!$this->api_key OR !isset($this->api_key))
			{
				die('<strong>Erreur</strong> - Une clef API est nécessaire pour pouvoir accéder à cette fonction - <strong>list_dedi()</strong>');
			}
			$this->OAuth();
		}
		$result = $this->api_requete('method=list_dedi');
		return json_decode($result,true);
	}
	public function delete_dedi($id = null)
	{
		if(!isset($id) OR !$id)
		{
			echo '<strong>Erreur</strong> - Vous devez ajouter un ID comme paramètre - ex : <strong>$demo->delete_dedi(2);</strong>';die();
		}
		$statut = $this->api_requete('method=statut_access&to=delete_dedi');
		if ($statut)
		{
			if(!$this->api_key OR !isset($this->api_key))
			{
				die ('<strong>Erreur</strong> - Une clef API est nécessaire pour pouvoir accéder à cette fonction - <strong>delete_dedi()</strong>');
			}
			$this->OAuth();
		}
		return json_decode($this->api_requete('method=delete_dedi&id='.$id),true);
	}
	public function publish_dedi($v = null)
	{
		$statut = $this->api_requete('method=statut_access&to=publish_dedi');
		if ($statut){
			if(!$this->api_key OR !isset($this->api_key))
			{
				die ('<strong>Erreur</strong> - Une clef API est nécessaire pour pouvoir accéder à cette fonction - <strong>publish_dedi()</strong>');
			}
			$this->OAuth();
		}
		$a = array();
		foreach ($v as $t => $n)
		{
			$a[$t] = str_replace(' ','%20', $n);
		}
		return json_decode($this->api_requete('method=publish_dedi&data_pseudo='.$a["data_pseudo"].'&data_message='.$a["data_message"].'&data_val='.$a["data_val"]),true);
	}
	private function OAuth()
	{
		$statut = json_decode($this->api_requete('method=verif_api&key='.$this->api_key),true);
		if($statut['statut']=='error')
		{
			die ('<strong>Erreur</strong> - Clef API incorrecte, merci de bien vouloir la corriger');
		}
		$this->url = $this->url.'token='.$this->api_key.'&';
	}
}