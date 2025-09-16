@extends('layouts/auth')
@section('page_title', $page_title)
@section('css')
<style>
pre code {
	background: #f5f5f5;
	padding: 15px;
	padding-top: 0px;
	display: block;
	border: 1px solid #ddd;
	border-radius: 5px;
	color: #333;
	font-family: 'Courier New', Courier, monospace;
	font-size: 14px;
	overflow-x: auto;
	white-space: pre-wrap;
	word-wrap: break-word;
}
</style>
@endsection
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
				<pre><code>
# Session Info
<?php echo json_encode($this->session->all_userdata(), JSON_PRETTY_PRINT); ?>
				</code></pre>

				<pre><code>
# Cookie Info
<?php echo json_encode($_COOKIE, JSON_PRETTY_PRINT) ?>
				</code></pre>
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