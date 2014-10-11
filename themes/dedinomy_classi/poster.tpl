<!DOCTYPE html>
<html lang="fr">
<head>
	<link href="{assets_css}poster.css" rel="stylesheet" type="text/css" />
	<meta charset="utf-8" />
	<!--[if lt IE 9]>
    	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<title>{site_name}</title>
	<script type="text/javascript">
		var RecaptchaOptions =
		{
			theme : "{captcha_theme}",
			lang : "fr"
		};
	</script>
</head>
<body class="poster">
	<span class="poster">
		<center>
		{message}
		{error_msg}
		<if cond="$display_form">
			<form action="" method="post">
				Ton Pseudo :<br />
				<input type="text" name="pseudo" size="20" maxlength="15" required=required/>
				<br />
				<br />
				Ta Dédicace :
				<br />
				<input type="text" name="message" size="30" maxlength="{caracteres_max}" required=required/>
				<br />
				<em><small>(Limité à {caracteres_max} Caractères)</small></em>
				<br />
				<br />
				<if cond="$captcha_on">
					<div align="center">
						{captcha_code}
					</div>
					<br />
				</if>
				<input type="hidden" name="token" id="token" value="{token}"/>
				<input type="image" Value="Envoyer" src="{assets_img}good.png" alt="Go !!" align="middle" border="0" />
			</form>
		</if>
		</center>
	</span>
</body>
</html>