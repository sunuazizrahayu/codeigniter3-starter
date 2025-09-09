@extends('layouts/auth')
@section('page_title', $page_title)
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-12">
				<h1 class="m-0">Welcome to CodeIgniter!</h1>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<!-- Default box -->
		<div class="card rounded-0">
			<div class="card-header">
				<h3 class="card-title">CodeIgniter 3 App Starter</h3>
			</div>
			<div class="card-body">
				Start creating your amazing application!
			</div>
			<!-- /.card-body -->
			<div class="card-footer text-right text-sm">
				<?php echo (ENVIRONMENT === 'development') ? 'Version <strong>' . CI_VERSION . '</strong>' : '' ?>
			</div>
			<!-- /.card-footer-->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection