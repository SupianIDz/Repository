<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Supian M">
		<meta name="description" content="Octopy Repository">
		<meta name="keywords" content="Octopy Repository, {{ $keywords }}">
		<meta name="csrf-token" content="{{ csrf() }}">
		<meta property="og:title" content="Octopy Repository">
		<meta property="og:type" content="article">
		<meta property="og:url" content="https://repository.octopy.xyz/">
		<meta property="og:image" content="{{ url('img/octopy.png') }}">
		<title>{{ $title }}</title>
		<link href="{{ url('img/octopy.png') }}" rel="icon">
		<link rel="stylesheet" href="{{ url('css/style.css') }}">
		<link rel="stylesheet" href="{{ url('css/font.css') }}">
		<link rel="stylesheet" href="{{ url('css/pace.css') }}">
		<style type="text/css">
			li + li {
				margin-top: -15px;
				margin-bottom: -15px;
			}
			.octopy {
				top: 50%;
			}

			.octopy img {
				max-width: 50px;
				vertical-align: middle;
			}

			.octopy span {
				vertical-align: middle;
				color: #FFF;
				font-weight: bold;
				font-size: 200%;
			}

			* {
				border: none;
			}
		</style>
	</head>
	<body class="grey lighten-5">
		<div id="page-navbar" class="wrapper">
			<nav>
				<div class="nav-wrapper" style="background-color: #0C1021;">
					<div class="container octopy">
						<img src="{{ url('img/octopy.png') }}">
						<span>{{ $title }}</span>
						<ul class="right">
							<li>
								<a href="{{ route('zip') }}">
									<i class="icon-download"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
		<br>
		<div id="page-content" class="container">
			<div id="directory-list-header" class="grey-text text-darken-3">
				<div class="row">
					<div class="col m8 s9" style="font-weight: bold;">Name</div>
					<div class="col m2 s2 text-right" style="font-weight: bold;">Size</div>
					<div class="col m2 hide-on-small-only text-right" style="font-weight: bold;">
						Last Modified
					</div>
				</div>
			</div>
			<ul id="directory-listing" class="nav nav-pills nav-stacked">
				<div class="repository"></div>
			</ul>
		</div>
		<div class="container">
			<div class="divider cyan"></div>
			<div style="margin-top: 10px;margin-bottom: 15px;" class="center-align">
				Powered By <a href="https://www.octopy.xyz" class="cyan-text" target="_blank">Octopy</a> 
				&mdash;
				Made With <a href="https://framework.octopy.xyz" class="cyan-text" target="_blank">Octopy Framework</a>
				&mdash;
				Contact  <a href="mailto:supianidz@gmail.com" class="cyan-text" target="_blank">supianidz@gmail.com</a>
			</div>
		</div>
		<script type="text/javascript" src="{{ url('js/jquery.js') }}"></script>
		<script type="text/javascript" src="{{ url('js/pace.js') }}"></script>
		<script type="text/javascript" src="{{ url('js/octopy.js') }}"></script>
	</body>
</html>