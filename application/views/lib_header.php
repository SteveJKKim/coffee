
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Coffee Me - Admin</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/css/bootstrap-responsive.min.css" />
	<link rel="stylesheet" href="/css/uniform.css" />
	<link rel="stylesheet" href="/css/select2.css" />
	<link rel="stylesheet" href="/css/matrix-style.css" />
	<link rel="stylesheet" href="/css/matrix-media.css" />
	<link href="/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
	<h1><a href="main.html">Admin</a></h1>
</div>
<!--close-Header-part-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
	<ul class="nav">
		<li class=""><a title="" href="/login/logout"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
	</ul>
</div>

<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-th"></i>Tables</a>
	<ul>
		<li class="<?=$this->func->menu_main($this->MM, 1);?>"><a href="/summary"><i class="icon icon-home"></i> <span>Summary</span></a> </li>
		<li class="<?=$this->func->menu_main($this->MM, 2);?>"><a href="/report"><i class="icon icon-signal"></i> <span>Report</span></a> </li>
		<li class="submenu <?=$this->func->menu_main($this->MM, 3);?>"><a href="#"><i class="icon icon-user"></i> <span>Member</span></a>
			<ul>
				<li<?=($this->SM == '1') ? ' style="background-color:#28b779;"':'';?>><a href="/member">회원리스트</a></li>
				<li<?=($this->SM == '2') ? ' style="background-color:#28b779;"':'';?>><a href="javascript:;">출석순위</a></li>
				<li<?=($this->SM == '3') ? ' style="background-color:#28b779;"':'';?>><a href="javascript:;">친구초대 순위</a></li>
			</ul>
		</li>
		<li class="<?=$this->func->menu_main($this->MM, 4);?>"><a href="/event"><i class="icon icon-calendar"></i> <span>Event</span></a> </li>
	</ul>
</div>
