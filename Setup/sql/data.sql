SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE TABLE IF NOT EXISTS `{:db_prefix}_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` text NOT NULL,
  `pass_md5` text NOT NULL,
  `niveau` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE={:db_engine}  DEFAULT CHARSET={:db_charset} AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `{:db_prefix}_bans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE={:db_engine}  DEFAULT CHARSET={:db_charset} AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `{:db_prefix}_cfg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` text,
  `nb_aff` int(11) DEFAULT '10',
  `erreur_mod` text,
  `mail` text,
  `adr_dedi` text,
  `val_dedi` tinyint(1) DEFAULT '0',
  `ca_post` int(11) DEFAULT '24',
  `captcha` tinyint(1) DEFAULT '1',
  `recaptcha_theme` text,
  `mnt` tinyint(1) DEFAULT '0',
  `cle` text,
  `msg_mnt` text,
  `msg_poster_val` text,
  `msg_poster` text,
  `liserv` tinyint(1) DEFAULT '0',
  `theme` text,
  `api_list_dedi` tinyint(1) DEFAULT '1',
  `api_publish_dedi` tinyint(1) DEFAULT '1',
  `api_delete_dedi` tinyint(1) DEFAULT '1',
  `moderation` text NOT NULL,
  `ch` text NOT NULL,
  `date_onoff` tinyint(1) NOT NULL DEFAULT '1',
  `adm_nb_page` int(11) NOT NULL DEFAULT '10',
  `api_key` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE={:db_engine}  DEFAULT CHARSET={:db_charset} AUTO_INCREMENT=2;
INSERT INTO `{:db_prefix}_cfg` (`id`, `site`, `nb_aff`, `erreur_mod`, `mail`, `adr_dedi`, `val_dedi`, `ca_post`, `captcha`, `recaptcha_theme`, `mnt`, `cle`, `msg_mnt`, `msg_poster_val`, `msg_poster`, `liserv`, `theme`, `api_list_dedi`, `api_publish_dedi`, `api_delete_dedi`, `moderation`, `ch`, `date_onoff`, `adm_nb_page`,`api_key`) VALUES
(1, 'sitename', 10, '<h3>Acces refuse</h3><br />Vous ne disposez pas des droits requis pour pouvoir acceder a cette page.<br />Contactez votre administrateur pour mettre a jour vos droits d\'acces.<br /><a href="index.php">Retour au tableau de bord</a>', '', '', 1, 24, 1, 'clean', 0, '0', 'maintenance en cours', 'en validation', 'maintenant en ligne', 0, 'dedinomy_classi', 1, 1, 1, '', 0, 1, 10,'{:api_key}');
CREATE TABLE IF NOT EXISTS `{:db_prefix}_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` text NOT NULL,
  `message` text NOT NULL,
  `timestamp` text NOT NULL,
  `val` tinyint(1) NOT NULL DEFAULT '0',
  `iptrace` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE={:db_engine}  DEFAULT CHARSET={:db_charset} AUTO_INCREMENT=1 ;