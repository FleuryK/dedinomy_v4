<?php
class Update
{
	public static function check()
	{
		$url = 'http://manager.nubox.fr/soapi/v4/maj_api.php?version='.ver;
		$ch=curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$r=curl_exec($ch);
		if(curl_errno($ch))
		{
			return false;
		}
		else
		{
			$arr = json_decode($r,true);
			if ($arr > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		curl_close($ch);
	}
	public static function info()
	{
		$url = 'http://manager.nubox.fr/soapi/v4/maj_api.php?version='.ver.'&check=true';
		$ch=curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$r=curl_exec($ch);
		if(curl_errno($ch))
		{
			$html="Erreur lors de la récupération des informations de mise à jour.";
		}
		else
		{
			$arr = json_decode($r,true);
			$html='<br /><br />
			<a href="?pcat=launch" class="button">Mettre à jour</a>
			<table class="striped" cellspacing="0" cellpadding="0">
	  		<thead><tr class="alt first last">
	    		<th><h6>Version à installer</h6></th>
	    		<th><h6>Description de la mise à jour</h6></th>
	  		</tr></thead>
			<tbody>';
			foreach($arr as $k)
			{
				$html.='<tr class="alt"><td class="tbladmin-td"><center>'.$k['version'].'</center></td><td>'.$k['texte'].'</td>';
			}
			$html.='</tbody></table>';
		}
		curl_close($ch);
		return $html;
	}
	private static function ClearDir($dirname)
	{
		if (is_dir($dirname))
		{
           $dir_handle = opendir($dirname);
		}
		if (!$dir_handle)
		{
		    return false;
		}
		while($file = readdir($dir_handle))
		{
	       	if ($file != "." && $file != "..")
	       	{
	            if(!is_dir($dirname."/".$file))
	            {
	                 unlink($dirname."/".$file);
	            }
	            else
	            {
	                 delete_directory($dirname.'/'.$file);
	            }
	       	}
		}
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	}
	public static function launch()
	{
		$url = 'http://manager.nubox.fr/soapi/v4/maj_api.php?version='.ver.'&check=true';
		$ch=curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$r=curl_exec($ch);
		curl_close($ch);
		$arr = json_decode($r,true);
		$html='<br /><table class="striped" cellspacing="0" cellpadding="0"><tbody>';
		foreach($arr as $k)
		{
			$aV = $k['version'];
			$html.='<tr><td><br /><h4>Mise à jour de votre version de Dédinomy vers la version '.$aV.'</h4></td></tr>';
			if(!is_file('../updates/update_dedinomy_'.$aV.'.zip' ))
			{
				if(!is_dir('../updates/'))mkdir("../updates/");
				$fp = fopen('../updates/update_dedinomy_'.$aV.'.zip', 'w');
				$path = '../updates/update_dedinomy_'.$aV.'.zip';
				$url='http://repo.nubox.fr/updates/update_dedinomy_'.$aV.'.zip';
				$fp = fopen($path, 'w');
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_FILE, $fp);
				$data = curl_exec($ch);
				$curl_errno = curl_errno($ch);
				$curl_error = curl_error($ch);
				curl_close($ch);
				fclose($fp);
			}
			$zipHandle = zip_open('../updates/update_dedinomy_'.$aV.'.zip');
			while($aF = zip_read($zipHandle))
			{
				$thisFileName = zip_entry_name($aF);
				$thisFileDir = dirname($thisFileName);
				if(substr($thisFileName,-1,1) == '/') continue;
				if(!is_dir('../'.$thisFileDir))
				{
					mkdir ('../'.$thisFileDir);
					$html.='<tr class="alt"><td class="tbladmin-td">Mise à jour du répertoire '.$thisFileDir.'</td></tr>';
				}
				if(!is_dir('../'.$thisFileName))
				{
					if($thisFileName=="upgrade.php")
					{
						$html.='<tr class="alt"><td class="tbladmin-td">Création du fichier <strong>'.$thisFileName.'</strong></td>';
					}
					else $html.='<tr class="alt"><td class="tbladmin-td">Mise à jour du fichier <strong>'.$thisFileName.'</strong></td>';
					$contents = zip_entry_read($aF, zip_entry_filesize($aF));
					$contents = str_replace("\r\n", "\n", $contents);
					$updateThis = '';
					if ($thisFileName=='upgrade.php')
					{
						$upgradeExec = fopen('../upgrade.php','w');
						fwrite($upgradeExec, $contents);
						fclose($upgradeExec);
						require('../upgrade.php');
						unlink('../upgrade.php');
					}
					else
					{
						$updateThis = fopen('../'.$thisFileName, 'w');
						fwrite($updateThis, $contents);
						fclose($updateThis);
						unset($contents);
					}
				}
			}
		}
		$html.='<tr class="alt"><td class="tbladmin-td"><strong>Terminé !</strong></td>';
		$html.='</tbody></table>';
		$html.='<div style="width:650px;" class="success message"><h3 style="color:white">Dédinomy est maintenant à jour</h3><p>Votre version de Dédinomy est à jour - Plus sûr, plus moderne, plus innovante.</p></div>';
		self::clearDir('../updates');
		return $html;
	}
}