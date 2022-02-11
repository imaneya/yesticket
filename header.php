<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>YES TICKET</title>
	<link href="./css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css">
</head>
<body>
	<header>
		<article class="w1000">

		<div id="topmenu" style="color:#EC8AAB">
			<ul class="fr">
				<? if ($is_member) {?><li>LOG OUT</li><? } else {?><li>LOG IN</li><? }?>
				<? if (!$is_member) {?><li>SIGN UP</li><? }?>
				<? if ($is_member) {?><li>MY PAGE</li><? }?>
				<? if ($is_member) {?><li>CUSTOMER SERVICE</li><? }?>
			</ul>
		</div>
		<div id="mainmenu">

			<ul>
				<a href="/"><img id="logo" src="./img/logo.png" alt="YesTicket Logo" class="fl"></a>
				<li><a href="">TICKET</a></li>
				<li><a href="">TOUR</a></li>
				<li><a href="">GOODS</a></li>
				<li><a href="">HOTEL</a></li>
				<li><a href="">CAR</a></li>
			</ul>
			<span class="fr">
				<input id="searchbox" placeholder="Tickets, Tour Programs, Goods, and so on...">
			</span>
		</div>
		</article>
	</header>


	<style>
		header #logo {width:90px;}
		#topmenu li {float: left; margin-right:30px;}
		#mainmenu li{font-weight: 500; font-size:1.3em; margin:35px 0 35px 30px; float:left; text-align: center;}
		#mainmenu li:hover {font-weight: bold;}
		#searchbox {border:#ec8aab 1px solid; padding:10px; min-width: 300px; margin:25px; outline: none;}
	</style>
