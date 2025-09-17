@extends('layouts/app')
@section('page_title', $page_title)
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-12">
				<h1 class="m-0"><?=lang('Settings') ?></h1>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content-header -->

<!-- Main content -->
<div class="content" id="section-page">
	<div class="container-fluid">
		<div class="card card-primary card-outline card-outline-tabs">
			<div class="card-header p-0 border-bottom-0">
				<ul class="nav nav-tabs" id="page-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="page-tabs-1-nav" data-toggle="pill" href="#page-tabs-1-content"><?=lang('Change Email') ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="page-tabs-2-nav" data-toggle="pill" href="#page-tabs-2-content"><?=lang('Change Password') ?></a>
					</li>
				</ul>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<div class="tab-content" id="page-tabs-contents">
					<div id="page-tabs-1-content" class="tab-pane fade show active">
						<form id="form-change-email" action="<?=$url_form.'ajax_change_email' ?>" method="PATCH">
							<div class="form-group row">
								<label class="col-md-3 col-form-label"><?=lang('Current Email') ?>*</label>
								<div class="col-md-9">
									<input type="email" class="form-control" placeholder="<?=lang('Current Email') ?>" name="email_current" autocomplete="off" value="<?=htmlentities($form_email) ?>" readonly>
									<div class="text-danger" data-error="email_current"></div>
								</div>
							</div><!-- /.form-group -->
							<div class="form-group row">
								<label class="col-md-3 col-form-label"><?=lang('New Email') ?>*</label>
								<div class="col-md-9">
									<input type="email" class="form-control" placeholder="<?=lang('New Email') ?>" name="email_new" autocomplete="off">
									<div class="text-danger" data-error="email_new"></div>
								</div>
							</div><!-- /.form-group -->
						</form>
					</div>
					<div id="page-tabs-2-content" class="tab-pane fade">
						<form id="form-change-password" action="<?=$url_form.'ajax_change_password' ?>" method="PATCH">
							<div class="form-group row">
								<label class="col-md-3 col-form-label"><?=lang('Current Password') ?>*</label>
								<div class="col-md-9">
									<div class="input-group">
										<input type="password" class="form-control" placeholder="<?=lang('Current Password') ?>" name="password_current" autocomplete="off">
										<div class="input-group-append">
											<div class="input-group-text" style="cursor: pointer;" onclick="showHidePassword('form-change-password','password_current')">
												<span class="fas fa-eye-slash password-icon"></span>
											</div>
										</div>
									</div>
									<div class="text-danger" data-error="password_current"></div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label"><?=lang('New Password') ?>*</label>
								<div class="col-md-9">
									<div class="input-group">
										<input type="password" class="form-control" placeholder="<?=lang('New Password') ?>" name="password_new" autocomplete="off">
										<div class="input-group-append">
											<div class="input-group-text" style="cursor: pointer;" onclick="showHidePassword('form-change-password','password_new')">
												<span class="fas fa-eye-slash password-icon"></span>
											</div>
										</div>
									</div>
									<div class="text-danger" data-error="password_new"></div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label"><?=lang('Repeat New Password') ?>*</label>
								<div class="col-md-9">
									<div class="input-group">
										<input type="password" class="form-control" placeholder="<?=lang('Repeat New Password') ?>" name="password_new_repeat" autocomplete="off">
										<div class="input-group-append">
											<div class="input-group-text" style="cursor: pointer;" onclick="showHidePassword('form-change-password','password_new_repeat')">
												<span class="fas fa-eye-slash password-icon"></span>
											</div>
										</div>
									</div>
									<div class="text-danger" data-error="password_new_repeat"></div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /.card-body -->
			<div class="card-footer">
				<button type="button" class="btn btn-primary float-right" id="btnSave"><?=lang('Save') ?></button>
			</div>
			<!-- /.card-footer -->
		</div><!-- /.card -->
	</div><!-- /.container -->
</div>
<!-- /.content -->
@endsection
@section('js')
<script>
function showHidePassword(form_id, input) {
	let element = $('#'+form_id).find('[name='+input+']');
	let type = element.attr('type');
	if (type == 'password') {
		element.attr('type','text');
		element.parent().find('.password-icon').removeClass('fa-eye-slash').addClass('fa-eye').css('margin', '0 1px');
	}else{
		element.attr('type','password');
		element.parent().find('.password-icon').removeClass('fa-eye').addClass('fa-eye-slash').css('margin', 0);
	}
}
</script>

<script>
$('#btnSave').click(function() {
	Swal.fire({
		title: '<?=lang('Are you sure') ?>?',
		text: '<?=lang('txt_warning_change') ?>',
		icon: 'warning',
		showCancelButton: true,
		focusCancel: true,
		cancelButtonColor: '#d33',
		cancelButtonText: '<?=lang('Cancel') ?>',
		confirmButtonColor: '#3085d6',
		confirmButtonText: '<?=lang('Change') ?>',
		showLoaderOnConfirm: true,
		allowOutsideClick: () => !Swal.isLoading(),
		preConfirm: function() {
			return new Promise(function(resolve, reject) {
				let form = $('#page-tabs-contents .active').find('form');

				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					beforeSend: function() {
						//reset form error
						form.find('[name]').removeClass('is-invalid');
						form.find('.text-danger').text('');
					},
					success: function(response) {
						Swal.fire('<?=lang('Success') ?>!', response.message, 'success').then(function() {
							document.write('<?=lang('Please Wait') ?>..');
							window.location = window.location.href;
						});
					},
					error: function(xhr, status, error) {
						let response = xhr.responseJSON;
						let response_status = xhr.status;

						//handle no internet
						if (response_status == 0) {
							Swal.fire('<?=lang('Oops') ?>..!', '<?=lang('No Internet') ?> ['+response_status+']', 'warning');
							return;
						}

						//handle server error
						if (response_status >= 500) {
							Swal.fire(error+' ['+response_status+']', '<?=lang('Please try again or contact our support') ?>!', 'error');
							return;
						}

						//handle unwanted response
						if (response == undefined) {
							Swal.fire('<?=lang('Oops') ?>..!', '<?=lang('Unknown Server Response') ?> ['+response_status+']', 'error');
							return;
						}

						//other response
						Swal.fire('<?=lang('Oops') ?>..!', response.message, 'error');

						//handle form input
						let errors = response.errors;
						if (errors != undefined) {
							Object.keys(errors).forEach(function(k) {
								form.find('[name='+k+']').addClass('is-invalid');
								form.find('[data-error='+k+']').addClass('text-danger text-xs').text(errors[k]);
							})
						}
					}
				}).always(function() {
					resolve();
				});
				//end ajax
			});
			//end promise
		}
		//preconfirm
	}); //swal
}); //btn-click
</script>
@endsection