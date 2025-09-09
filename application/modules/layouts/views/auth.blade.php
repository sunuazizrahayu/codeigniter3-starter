<?php
$theme = 'https://adminlte.io/themes/v3/';
$app_logo = $theme.'dist/img/AdminLTELogo.png';
$app_name = 'AdminLTE 3';
$app_url = site_url();
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('page_title')</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="<?=$theme?>plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?=$theme?>dist/css/adminlte.min.css">
<!-- Override style -->
<style>
.wrapper > .content-wrapper { padding-bottom: 1px; }
.wrapper > .content-wrapper .content-header { padding: 15px 0 }
.wrapper > .content-wrapper > .content-wrapper2 { max-width: 1140px; margin: auto; }
</style>

@yield('css')

</head>
<body class="hold-transition layout-top-nav layout-fixed">
<div class="wrapper">

	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
		<div class="container">
			<a href="<?=$app_url?>" class="navbar-brand">
				<img src="<?=$app_logo?>" alt="<?=$app_name ?> Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
				<span class="brand-text font-weight-light"><?=$app_name ?></span>
			</a>

			<!-- Right navbar links -->
			<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
				<!-- User Dropdown Menu -->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown">
						<i class="fas fa-user"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right border-0 shadow">
						<li><a class="dropdown-item" href="#">Login</a></li>
						<li><a class="dropdown-item" href="#">Register</a></li>
						<li class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="#">Forgot Password</a></li>
						<li><a class="dropdown-item" href="#">Resend Activation</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	<!-- /.navbar -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<div class="content-wrapper2">
			@yield('content')
		</div>
	</div>
	<!-- /.content-wrapper -->

	<!-- Control Sidebar -->
	<aside class="control-sidebar control-sidebar-dark">
		<!-- Control sidebar content goes here -->
	</aside>
	<!-- /.control-sidebar -->

	<!-- Main Footer -->
	<footer class="main-footer text-sm">
		<div class="container">
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
<!-- AdminLTE App -->
<script src="<?=$theme?>dist/js/adminlte.min.js"></script>

@yield('js')

</body>
</html>
