@extends('sample/layouts/adminlte3/app_'.$version)
@section('page_title', $page_title)
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Starter Page</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Starter Page</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Card title</h5>

						<p class="card-text">
							Some quick example text to build on the card title and make up the bulk of the card's
							content.
						</p>

						<a href="#" class="card-link">Card link</a>
						<a href="#" class="card-link">Another link</a>
					</div>
				</div>

				<div class="card card-primary card-outline">
					<div class="card-body">
						<h5 class="card-title">Card title</h5>

						<p class="card-text">
							Some quick example text to build on the card title and make up the bulk of the card's
							content.
						</p>
						<a href="#" class="card-link">Card link</a>
						<a href="#" class="card-link">Another link</a>
					</div>
				</div><!-- /.card -->
			</div>
			<!-- /.col-md-6 -->
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">
						<h5 class="m-0">Featured</h5>
					</div>
					<div class="card-body">
						<h6 class="card-title">Special title treatment</h6>

						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a>
					</div>
				</div>

				<div class="card card-primary card-outline">
					<div class="card-header">
						<h5 class="m-0">Featured</h5>
					</div>
					<div class="card-body">
						<h6 class="card-title">Special title treatment</h6>

						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a>
					</div>
				</div>
			</div>
			<!-- /.col-md-6 -->
		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<!-- Default box -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Title</h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
						<i class="fas fa-times"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
				Start creating your amazing application!
			</div>
			<!-- /.card-body -->
			<div class="card-footer">
				Footer
			</div>
			<!-- /.card-footer-->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection