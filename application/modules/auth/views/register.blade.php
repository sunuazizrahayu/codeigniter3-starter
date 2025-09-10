@extends('layouts/auth')
@section('page_title', $page_title)
@section('content')
<div class="login-box m-auto pt-4 pb-5">
	<div class="login-logo">
		<a href="javascript:void(0)">Register</a>
	</div>
	<div class="card">
		<div class="card-body login-card-body">
			<form id="myform" action="<?=$url_form ?>" method="post">
				<div class="input-group">
					<input type="email" name="email" class="form-control" placeholder="Email">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-envelope"></span>
						</div>
					</div>
				</div>
				<div class="text-danger mb-3" data-error="email"></div>

				<div class="input-group">
					<input type="password" name="password" class="form-control" placeholder="New Password" autocomplete="off">
					<div class="input-group-append">
						<div class="input-group-text" style="cursor: pointer;" onclick="showHidePassword('myform','password')">
							<span class="fas fa-eye-slash password-icon"></span>
						</div>
					</div>
				</div>
				<div class="text-danger mb-3" data-error="password"></div>

				<div class="input-group">
					<input type="password" name="password_retype" class="form-control" placeholder="Retype New Password" autocomplete="off">
					<div class="input-group-append">
						<div class="input-group-text" style="cursor: pointer;" onclick="showHidePassword('myform','password_retype')">
							<span class="fas fa-eye-slash password-icon"></span>
						</div>
					</div>
				</div>
				<div class="text-danger mb-3" data-error="password_retype"></div>

				<div class="row">
					<div class="col-8">
						<div class="icheck-primary">
							<input type="checkbox" id="agreeTerms" name="terms" value="agree">
							<label for="agreeTerms">I agree to the <a href="<?=$url_terms ?>">terms</a>.</label>
						</div>
						<div class="text-danger" data-error="terms"></div>
					</div>
					<div class="col-4">
						<button type="submit" class="btn btn-primary btn-block">Register</button>
					</div>
				</div>
				<!-- /.row -->
			</form>
		</div>
		<!-- /.login-card-body -->
	</div>
	<!-- /.card -->
</div>
<!-- /.login-box -->
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
$('#myform').submit(function(e) {
	e.preventDefault();

	let form = $(this);
	let url = form.attr('action');
	let method = form.attr('method');
	let btn = form.find('[type=submit]');
	let errors = form.find('[data-error]');

	$.ajax({
		url: url,
		type: method,
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
			Swal.fire('Success!', response.message, 'success');

			//reset form
			form[0].reset();
			form.find('[name]').removeClass('is-invalid');
			errors.text('');
		},
		error: function(xhr, status, error) {
			let response = xhr.responseJSON;
			let response_status = xhr.status;

			//handle no internet
			if (response_status == 0) {
				Swal.fire('Oops..!', 'No Internet ['+response_status+']', 'warning');
				return;
			}

			//handle server error
			if (response_status >= 500) {
				Swal.fire(error+' ['+response_status+']', 'Please try again or contact our support!', 'error');
				return;
			}

			//handle unwanted response
			if (response == undefined) {
				Swal.fire('Oops..!', 'Unknown Server Response ['+response_status+']', 'error');
				return;
			}

			//other response
			Swal.fire('Oops..!', response.message, 'error');

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