<?php 
$layout = 'auth';
if ($this->authlib->isLoggedIn()) {
	$layout = 'app';
}
?>
@extends('layouts/'.$layout)
@section('page_title', $page_title)
@section('content')
<!-- Main content -->
<section class="content pt-4 pb-5">
	<div class="error-page">
		<h2 class="headline text-warning">404</h2>

		<div class="error-content">
			<h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
			<p>We could not find the page you were looking for.</p>
		</div>
		<!-- /.error-content -->
	</div>
	<!-- /.error-page -->
</section>
<!-- /.content -->
@endsection