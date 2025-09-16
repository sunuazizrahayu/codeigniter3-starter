@extends('layouts/auth')
@section('page_title', $page_title)
@section('content')
<div class="login-box m-auto pt-4 pb-5">
	<div class="login-logo">
		<a href="javascript:void(0)"><?=lang('Login') ?></a>
	</div>
	<div class="card">
		<div class="card-body login-card-body">
			<form id="myform" action="<?=$url_form ?>" method="post">
				<div class="input-group">
					<input type="email" name="email" class="form-control" placeholder="<?=lang('Email') ?>">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-envelope"></span>
						</div>
					</div>
				</div>
				<div class="text-danger mb-3" data-error="email"></div>

				<div class="input-group">
					<input type="password" name="password" class="form-control" placeholder="<?=lang('Password') ?>">
					<div class="input-group-append">
						<div class="input-group-text" style="cursor: pointer;" onclick="showHidePassword()">
							<span class="fas fa-eye-slash password-icon"></span>
						</div>
					</div>
				</div>
				<div class="text-danger mb-3" data-error="password"></div>

				<div class="row">
					<div class="col-8">
						<div class="icheck-primary">
							<input type="checkbox" id="remember" name="remember">
							<label for="remember"><?=lang('Remember Me') ?></label>
						</div>
					</div>
					<div class="col-4">
						<button type="submit" class="btn btn-primary btn-block"><?=lang('Login') ?></button>
					</div>
				</div>
			</form>

			<div class="social-auth-links text-center mb-3">
				<p>- <?=strtoupper(lang('or')) ?> -</p>
				<a href="#" class="btn btn-block btn-primary">
					<i class="fab fa-facebook mr-2"></i> Sign in using Facebook
				</a>
				<a href="#" class="btn btn-block btn-danger">
					<i class="fab fa-google mr-2"></i> Sign in using Google
				</a>
			</div>
			<!-- /.social-auth-links -->

			<p class="mb-1">
				<a href="<?=$url_forgot_password ?>"><?=lang('Forgot Password') ?></a>
			</p>
			<p class="mb-0">
				<a href="<?=$url_register ?>" class="text-center"><?=lang('Register New Account') ?></a>
			</p>
		</div>
		<!-- /.login-card-body -->
	</div>
	<!-- /.card -->
</div>
<!-- /.login-box -->
@endsection

@section('js')
<script>
function showHidePassword() {
	let element = $('[name=password]');
	let type = element.attr('type');
	if (type == 'password') {
		element.attr('type','text');
		element.parent().find('.password-icon').removeClass('fa-eye-slash').addClass('fa-eye');
	}else{
		element.attr('type','password');
		element.parent().find('.password-icon').removeClass('fa-eye').addClass('fa-eye-slash');
	}
}
$('#myform').submit(function(e) {
	e.preventDefault();

	let form = $(this);
	let url = form.attr('action');
	let method = form.attr('method');
	let btn = form.find('[type=submit]');
	let errors = form.find('[data-error]');

	$.ajax({
		url: url,
		method: method,
		data: form.serialize(),
		dataType: 'json',
		beforeSend: function() {
			//set loading
			btn.prop('disabled', true).button('loading');

			//reset form error
			form.find('[name]').removeClass('is-invalid');
			errors.text('');
		},
		success: function(response, status, xhr) {
			let redirect_url = '<?=site_url() ?>';
			if (response.data && response.data.redirect != undefined) {
				redirect_url = response.data.redirect;
			}

			document.write(response.message);
			window.location = redirect_url;
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
		//reset loading
		btn.prop('disabled', false).button('reset');
	});
})
</script>
@endsection