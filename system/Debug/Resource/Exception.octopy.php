<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="author" content="Supian M">
		<meta name="description" content="Octopy Framework">
		<meta name="keywords" content="Octopy Framework, PHP Octopy Framework, PHP Framework">
		<meta property="og:title" content="Octopy Framework">
		<meta property="og:type" content="article">
		<meta property="og:url" content="https://framework.octopy.xyz/">
		<meta property="og:image" content="img/octopy.png">
		<title>Octopy Framework</title>
		<link href="img/octopy.png" rel="icon">
		<style type="text/css">
			@import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);
			body, html{
				background-color:#0c1021;
			}
			.octopy > .content{
				font-family:'Open Sans', sans-serif;
				text-align:center;
				color:#fff;
			}
			.octopy > .head {
				position:relative;
				border:1px solid #0c1021;
				border-bottom:0;
				height:28px
			}
			.octopy > .head> .buttons{
				float:left;padding:6px;
				position:relative;
				z-index:1
			}

			.octopy>.head>.buttons a{
				cursor:pointer;
				display:inline-block;
				text-align:center;
				text-decoration:none;
				margin:0 2px;
				-moz-border-radius:50%;
				-webkit-border-radius:50%;
				border-radius:50%;
				width:15px;
				height:15px;
				font-size:1.5em;
				line-height:.83333em
			}

			.octopy > .head > .buttons a i{
				text-align:center;
				width:100%;
				height:15px;
				display:block;
				font-size:.55556em;
				line-height:1.5em
			}
			
			.octopy > .head > .buttons a.close{
				background:#f25056;
			}
			.octopy >.head >.buttons a.minimize{
				background:#fac536;
			}

			.octopy>.head>.buttons a.enlarge{
				background:#39ea49;
			}
		</style>
	</head>
	<body>
		<div class="octopy">
			<div class="head">
				<div class="buttons">
					<a href="javascript:;" class="close" title="Close"></a>
					<a href="javascript:;" class="minimize" title="Minimize"></a>
					<a href="javascript:;" class="enlarge" title="Enlarge"></a>
				</div>
			</div>
			<div class="content">
				
			</div>
		</div>
	</body>
</html>