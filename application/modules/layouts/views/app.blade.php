<?php
$theme = 'https://adminlte.io/themes/v3/';
$app_logo = $theme.'dist/img/AdminLTELogo.png';
$app_name = 'AdminLTE 3';
$app_url = site_url();
$app_lang_config = $this->config->item('language_cookie_name');
$app_lang = $this->input->cookie($app_lang_config) ?? 'us';
if ($app_lang == 'en') {
	$app_lang = 'us';
}
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="<?=$app_lang ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('page_title')</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="<?=$theme?>plugins/fontawesome-free/css/all.min.css">
<!-- Flag -->
<link rel="stylesheet" href="<?=$theme?>plugins/flag-icon-css/css/flag-icon.min.css">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="<?=$theme?>plugins/sweetalert2/sweetalert2.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?=$theme?>dist/css/adminlte.min.css">
<!-- Override style -->
<style>
.wrapper > .content-wrapper { padding-bottom: 1px; }
</style>
<?php "\n" ?>
@yield('css')

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="javascript:void(0)" role="button"><i class="fas fa-bars"></i></a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="<?=$app_url ?>" class="nav-link"><?=lang('Home') ?></a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="#" class="nav-link">Contact</a>
			</li>
		</ul>

		<!-- Right navbar links -->
		<ul class="navbar-nav ml-auto">
			<!-- Navbar Search -->
			<li class="nav-item">
				<a class="nav-link" data-widget="navbar-search" href="javascript:void(0)" role="button">
					<i class="fas fa-search"></i>
				</a>
				<div class="navbar-search-block">
					<form class="form-inline">
						<div class="input-group input-group-sm">
							<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
							<div class="input-group-append">
								<button class="btn btn-navbar" type="submit">
									<i class="fas fa-search"></i>
								</button>
								<button class="btn btn-navbar" type="button" data-widget="navbar-search">
									<i class="fas fa-times"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</li>

			<!-- Messages Dropdown Menu -->
			<li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
					<i class="far fa-comments"></i>
					<span class="badge badge-danger navbar-badge">3</span>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<a href="#" class="dropdown-item">
						<!-- Message Start -->
						<div class="media">
							<img src="<?=$theme?>dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
							<div class="media-body">
								<h3 class="dropdown-item-title">
									Brad Diesel
									<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
								</h3>
								<p class="text-sm">Call me whenever you can...</p>
								<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
							</div>
						</div>
						<!-- Message End -->
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item">
						<!-- Message Start -->
						<div class="media">
							<img src="<?=$theme?>dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
							<div class="media-body">
								<h3 class="dropdown-item-title">
									John Pierce
									<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
								</h3>
								<p class="text-sm">I got your message bro</p>
								<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
							</div>
						</div>
						<!-- Message End -->
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item">
						<!-- Message Start -->
						<div class="media">
							<img src="<?=$theme?>dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
							<div class="media-body">
								<h3 class="dropdown-item-title">
									Nora Silvester
									<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
								</h3>
								<p class="text-sm">The subject goes here</p>
								<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
							</div>
						</div>
						<!-- Message End -->
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
				</div>
			</li>

			<!-- Notifications Dropdown Menu -->
			<li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
					<i class="far fa-bell"></i>
					<span class="badge badge-warning navbar-badge">15</span>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<span class="dropdown-header">15 Notifications</span>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item">
						<i class="fas fa-envelope mr-2"></i> 4 new messages
						<span class="float-right text-muted text-sm">3 mins</span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item">
						<i class="fas fa-users mr-2"></i> 8 friend requests
						<span class="float-right text-muted text-sm">12 hours</span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item">
						<i class="fas fa-file mr-2"></i> 3 new reports
						<span class="float-right text-muted text-sm">2 days</span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
				</div>
			</li>

			<!-- Select Language -->
			<li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="javascript:void()">
					<i class="flag-icon flag-icon-<?=$app_lang ?>"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-right p-0">
					<a href="javascript:lang('en')" class="dropdown-item">
						<i class="flag-icon flag-icon-us mr-2"></i> English
					</a>
					<a href="javascript:lang('id')" class="dropdown-item">
						<i class="flag-icon flag-icon-id mr-2"></i> Indonesia
					</a>
				</div>
			</li>

			<!-- User Dropdown Menu -->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown">
					<i class="fas fa-user"></i>
				</a>
				<ul class="dropdown-menu dropdown-menu-right border-0 shadow">
					<li><a class="dropdown-item" href="#"><?=lang('Home') ?></a></li>
					<li><a class="dropdown-item" href="#">Profile</a></li>
					<li><a class="dropdown-item" href="<?=site_url('user/settings') ?>"><?=lang('Settings') ?></a></li>
					<li class="dropdown-divider"></li>
					<li><a class="dropdown-item" href="<?=site_url('logout') ?>"><i class="fas fa-sign-out-alt mr-2"></i> <?=lang('Logout') ?></a></li>
				</ul>
			</li>
		</ul>
	</nav>
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	<aside class="main-sidebar sidebar-dark-primary">
		<!-- Brand Logo -->
		<a href="<?=$app_url ?>" class="brand-link">
			<img src="<?=$app_logo?>" alt="<?=$app_name ?> Logo" class="brand-image img-circle" style="opacity: .8">
			<span class="brand-text font-weight-light"><?=$app_name ?></span>
		</a>

		<!-- Sidebar -->
		<div class="sidebar">
			<!-- Sidebar user panel (optional) -->
			<div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="image">
					<img src="<?=$theme?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
				</div>
				<div class="info">
					<a href="#" class="d-block">Alexander Pierce</a>
				</div>
			</div>

			<!-- SidebarSearch Form -->
			<div class="form-inline">
				<div class="input-group" data-widget="sidebar-search">
					<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
					<div class="input-group-append">
						<button class="btn btn-sidebar">
							<i class="fas fa-search fa-fw"></i>
						</button>
					</div>
				</div>
			</div>

			<!-- Sidebar Menu -->
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<!-- Add icons to the links using the .nav-icon class
					with font-awesome or any other icon font library -->
					<li class="nav-item">
						<a href="<?=site_url('user/dashboard') ?>" class="nav-link">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p><?=lang('Dashboard') ?></p>
						</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>Starter Pages <i class="right fas fa-angle-left"></i></p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?=current_url() ?>" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Active Page</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Inactive Page</p>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-th"></i>
							<p>Simple Link <span class="right badge badge-danger">New</span></p>
						</a>
					</li>
				</ul>
			</nav>
			<!-- /.sidebar-menu -->
		</div>
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		@yield('content')
	</div>
	<!-- /.content-wrapper -->

	<!-- Main Footer -->
	<footer class="main-footer text-sm">
		<div class="col-12">
			<!-- To the right -->
			<div class="float-right d-none d-sm-inline">
				Anything you want
			</div>
			<!-- Default to the left -->
			<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
		</div>
	</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?=$theme?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=$theme?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?=$theme?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=$theme?>dist/js/adminlte.min.js"></script>
<script type="text/javascript">
//auto active sidebar by url prefix
$(function() {
	/** add active class and stay opened when selected */
	var url = window.location.origin + window.location.pathname;
	var urlText = url.toString();

	// for sidebar menu entirely but not cover treeview
	$('ul.nav-sidebar a').filter(function() {
		return this.href == url || urlText.startsWith(this.href + '/');
	}).addClass('active');

	// for treeview
	$('ul.nav-treeview a').filter(function() {
		return this.href == url || urlText.startsWith(this.href + '/');
	}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
});

//set language
function lang(language_code) {
	async function setCookie(cname, cvalue, extime) {
		const d = new Date();
		d.setTime(d.getTime() + (extime*1000));
		let expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	let languageKey = '<?=$this->config->item('language_cookie_name') ?>';
	let expire = <?=$this->config->item('sess_expiration') ?>;
	setCookie(languageKey, language_code, expire);
	document.write('Loading...');
	window.location = window.location.href;
}
</script>
<?php "\n" ?>
@yield('js')

</body>
</html>
