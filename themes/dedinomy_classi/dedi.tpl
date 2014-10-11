<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<!--[if lt IE 9]>
    	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script type="text/javascript" src="{assets_js}marquee.js"></script>
	<script type="text/javascript">
		function init(){
			new Marquee('marqueeBox4', {
				speed : 2,
				dirc : 'left',
				stopOnOver : true,
				draggable : false
			});
		}
	</script>
	<title>{site_name}</title>
	<link href="{assets_css}dedi.css" rel="stylesheet" type="text/css" />
</head>
<body onload="init()">
	<div id="marqueeBox4" class="marqueeBoxH">
		<span id="contentBox4">
			<foreach var="$dedicace" as="d"><if cond="$d[val] == 1">
				<if cond="$datetime">
					<span class="datetime">{d[timestamp]} => </span></if>
					<span class="pseudo">{d[pseudo]}</span>
					<img src="{assets_img}apostrophe1.gif" border="0" width="12" height="12" alt="" align="absmiddle" />
					<span class="message">{d[message]}</span>
					<img src="{assets_img}apostrophe2.gif" border="0" width="12" height="12" alt="" align="absmiddle" />
					<img src="{assets_img}star.gif" border="0" width="24" height="24" alt="" align="absmiddle" />
				</if>
			</foreach>
		</span>
	</div>
</body>
</html>