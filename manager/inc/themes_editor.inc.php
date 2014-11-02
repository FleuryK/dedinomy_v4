<?php if (!defined('SCR_NAME')) exit('No direct script access allowed');
Security::is_admin();
$ext_autorise = array('.tpl', '.txt', '.html', '.css', '.js');
$theme=(isset($_GET['theme']))?$_GET['theme']:'';
$folder= "../themes/".$theme."";
function Save($folder)
{
    global $ext_autorise;
	if($dossierOuvert=opendir($folder))
    {
        while(($fichier=readdir($dossierOuvert))!== false)
        {
            if ($fichier==".." || $fichier==".")
            {
                continue;
            }
            else
            {
            	$extension = strrchr($fichier, '.');
				if(is_dir("$folder/$fichier"))
                {
                	Save($folder.'/'.$fichier);
                }
                else
                {
                	if(in_array($extension, $ext_autorise))
                	{
	                    $id=str_replace('.','',$fichier);
						$textarea=$_POST["$id"];
						$fp = fopen($folder.'/'.$fichier, 'w+');
						fputs($fp, $textarea);
						fclose($fp);
						echo '<div style="width:650px;" class="success message">
						<h3 style="color:white">Thème mis à jour</h3>
						<p>Le thème a bien été mis à jour.</p>
						</div>';
					}
                }
            }
        }
    }
}
function LoadHtml($folder)
{
    global $ext_autorise;
	if($dossierOuvert=opendir($folder))
    {
        while(($fichier=readdir($dossierOuvert))!== false)
        {
            if ($fichier==".." || $fichier==".")
            {
                continue;
            }
            else
            {
            	$extension = strrchr($fichier, '.');
				if(is_dir($folder.'/'.$fichier))
                {
                	LoadHtml($folder.'/'.$fichier);
                }
                else
                {
                	if(in_array($extension, $ext_autorise))
                	{
	                    $id=str_replace('.','',$fichier);
						echo '<li id="'.$id.'">';
						$content=file_get_contents($folder.'/'.$fichier.'');
						$required=($id!="indextpl")?'required=required':'';
						echo '<textarea name="'.$id.'" style="width:100%;height:500px;" >'.$content.'</textarea></li>';
					}
                }
            }
        }
    }
}
function LoadTab($folder)
{
    global $ext_autorise;
	if($dossierOuvert=opendir($folder))
    {
        while(($fichier=readdir($dossierOuvert))!== false)
        {
            if ($fichier==".." || $fichier==".")
            {
                continue;
            }
            else
            {
            	$extension = strrchr($fichier, '.');
				if(is_dir($folder.'/'.$fichier))
                {
                	LoadTab($folder.'/'.$fichier);
                }
                else
                {
                	if(in_array($extension, $ext_autorise))
                	{
                		$id=str_replace('.','',$fichier);
						echo '<li><a class="moderation" href="#'.$id.'">'.$fichier.'</a></li>';
					}
                }
            }
        }
    }
}
if(isset($_POST['update']))
{
	Save($folder);
}
?>
<header>
	<h1>Édition : <?php echo $_GET['theme'];?></h1>
</header>
<ul class="tabs">
	<?php
	LoadTab($folder);
	?>
</ul>
<form method="post" action="">
	<ul class="tabs-content">
		<?php
		LoadHtml($folder);
		?>
		</ul>
		<input type="submit" name="update" class="button" value="Mettre à jour le thème" />
	</form>