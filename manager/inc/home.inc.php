<?php if (!defined('SCR_NAME')) exit('No direct script access allowed');?>
<header>
	<h1 id="numero2">Tableau de bord</h1>
</header>
<hr class="large" />
<div class="doc-section" id="whatAndWhy">
	<h3 id="numero1">Quoi de neuf pour Dédinomy 5 ?</h3>
	<p></p>	
	<div class="row clearfix">
		<div class="two columns alpha"></div>
		<div class="ten columns omega">
			<h5>Nom de code : <strong>FastNomy !</strong></h5>
			Pourquoi "FastNomy" ?<br />
			Tout simplement parce que Dédinomy n'a jamais été aussi léger et rapide que maintenant !<br /><br />
			<p>Le cœur de Dédinomy a été réécrit, permettant entre autres une compatibilité avec PHP 5.6 qui sortira prochainement.<br />
			Une correction de nombreux bugs, la sécurité a également été revue.<br />
			L'intégralité du script fonctionne maintenant en UTF8 afin d'éliminer les problèmes d'encodage qui pouvaient être récurrents dans certains cas.<br />
			La connexion de Dédinomy avec MySQL a également subi un gros lifting<br />
			Le système de thèmes évolue et inclus désormais le formulaire d'envoi de dédicaces.</p><br />
			...Et bien plus encore... <em><small>Pour une liste complète, consultez le changelog de la version 5.0.0 & suivant sur le manager NuBOX</small></em>
		</div>
	</div>
	<div class="row clearfix">
		<div class="four columns alpha"></div>
		<div class="eight columns omega">
			<h5>Exportez vos idées avec l'API-PHP</h5>
			<p>Accéder à votre dédinomy à distance n'a jamais été aussi simple <strong>avec l'API Dédinomy.</strong> Programmez rapidement et simplement vos propres applications connectées à Dédinomy grâce à l'API-PHP. Une documentation est disponible sur le Manager NuBOX dans la rubrique "Dédinomy"</p>
		</div>
	</div>
</div>
<div class="doc-section" id="attribution">
	<p class="remove-bottom"><small>Dédinomy, un script de <a href="http://manager.nubox.fr" target="_blank">NuBOX</a>©, 2008-<?php echo date('Y');?><br />
	Le design est le fruit du travail de <a href="http://twitter.com/blogosite" target="_blank">#blogosite</a> et le développement de la version 5 par <a href="http://www.twitter.com/nubox_dev" target="_blank">#nubox_dev</a>. Toute reproduction, même partielle, est interdite sans l'autorisation de son auteur. Pour toutes questions, ou suggestions, connectez-vous au forum NuBOX - <a id="numero6" href="http://forum.nubox.fr" target="_blank">forum.nubox.fr</a>.
</div>
<?php
//if(Session::exist('first_time') && Session::get('first_time')): Session::set('first_time',false); ?>
<!--<ol id="joyRideTipContent">
	<li data-id="numero1" class="open" data-text="Suivant" data-options="tipAnimation:fade">
		<h3 style="color:white;">Bienvenue dans Dédinomy 5</h3>
		<p>Nous allons dans cette courte visite guidée vous présenter brièvement <strong style="color:white">les fonctionnalités de Dédinomy 5</strong>.</p>
	</li>
	<li data-id="numero2" data-text="Suivant" data-options="tipAnimation:fade">
		<h3 style="color:white;">Tableau de bord</h3>
		<p>Votre Mission Control, outils pour surveiller et contrôler tout Dédinomy en un seul espace.</p>
	</li>
	<li data-id="numero3" data-text="Suivant" data-options="tipAnimation:fade">
		<h3 style="color:white;">Nouveau design</h3>
		<p>Vous retrouverez toutes les rubriques Dédinomy dans ce tout nouveau design plus coloré, simple, et moderne - Nous avons réagencé les catégories, et regroupé les fonctions similaires en une même thématique.</strong></p>
	</li>
	<li data-id="numero4" data-text="Suivant" data-options="tipLocation:top;tipAnimation:fade">
		<h3 style="color:white;">Vos thémes</h3>
		<p>Créer vos propres thémes pour afficher vos dédicaces de maniéres simple et rapide avec notre gestionnaire de théme</p>
	</li>
	<li data-id="numero5" data-text="Suivant" data-options="tipAnimation:fade">
		<h3 style="color:white;">Découvrez notre API</h3>
		<p>Dédinomy 4 inclut une API fantastique qui vous permettra d'accéder aux dédicaces de Dédinomy en dehors du script</p>
	</li>
	<li data-id="numero6" data-text="Quitter la visite" data-options="tipLocation:top;tipAnimation:fade">
		<h3 style="color:white;">Et pour finir</h3>
		<p>Si vous avez des questions, ou suggestions, rendez-vous sur le forum NuBOX.<strong style="color:white"> Nous vous remercions d'avoir suivi notre visite guidée et d'utiliser Dédinomy 4</strong></p>
		<a href="http://forum.nubox.fr" class="joyride-next-tip small nice radius" target="_blank">Sugestions</a>
	</li>
</ol>
<script type="text/javascript">
	$(window).load(function() {
        $('#joyRideTipContent').joyride({
          autoStart : true,
          postStepCallback : function (index, tip) {
          if (index == 2) {
            $(this).joyride('set_li', false, 1);
          }
        },
        modal:true,
        expose: true
        });
      });
</script>-->
<?php //endif; ?>