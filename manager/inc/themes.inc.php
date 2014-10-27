<?php if (!defined('SCR_NAME')) exit('No direct script access allowed');
Security::is_admin();?>
<header>
	<h1>Thèmes</h1>
</header>
<hr class="large" />
<div class="doc-section" id="whatAndWhy">
	<div class="row clearfix">
	<?php
        if (isset($_GET['activate']))
        {
        	$id=$_GET['activate'];
        	Sql::update("UPDATE ".cfg." SET theme='$id'");
        	Tools::redirect('?pcat=themes&success=1');
        }
        function liste_Dirs($dir)
        {
            global $settings;
            $dossier = opendir($dir);
        	while($item = readdir($dossier))
            {
                $berk = array('.', '..');
                if (!in_array($item, $berk))
                {
                    $new_Dir = $dir.'/'.$item;
                    if(is_dir($new_Dir))
                    {  
                        if ($item==$settings->theme)
                        {
                            echo '<div style="background:#EBEBEB;padding:10px;width:320px;" class="six columns alpha">';
                        }
                        else
                        {
                            echo '<div style="padding:10px;width:320px;"class="six columns alpha">';
                        }
                        echo '<ul class="media-grid"><li><a href="#"><img class="thumbnail" width="100%" src="../themes/'.$item.'/screen.jpg"></a></li></ul>';
                        $fp = fopen("../themes/".$item."/info.txt", "r");
                        $toute_ligne=fread($fp,153);
                        print $toute_ligne;
                        fclose($fp);
                        if ($item!=$settings->theme)
                        {
                            echo '<a class="button" href="?pcat=themes&activate='.$item.'">Selectionner</a>';
                        }
                        echo ' <a class="button" href="?pcat=themes_editor&theme='.$item.'">Editer</a>';
                        echo '</p>';
                        echo '</div>';
                    }
                }
            }
        }
        echo liste_Dirs('../themes/');
    ?>
	</div>				
</div>
<div class="doc-section" id="attribution">
	<p class="remove-bottom"><small>DédiNomy, un script de <a href="http://manager.nubox.fr" target="_blank">NuBOX</a>© 2008-<?php echo date('Y'); ?><br />
	Le design est le fruit du travail de <a href="http://twitter.com/#!/blogosite" target="_blank">#blogosite</a> & <a href="http://twitter.com/#!/nubox_dev" target="_blank">#nubox_dev</a>. Toute reproduction, même partielle, est interdite sans l'autorisation de son auteur. Pour toutes questions, ou suggestions, connectez-vous au forum NuBOX - <a href="http://forum.nubox.fr" target="_blank">forum.nubox.fr</a></small></p>
    </div>
