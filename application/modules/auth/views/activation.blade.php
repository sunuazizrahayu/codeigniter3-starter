@extends('layouts/auth')
@section('page_title', $page_title)
@section('content')
<div class="login-box m-auto pt-4 pb-5">
	<div class="login-logo">
		<a href="javascript:void(0)"><?=lang('Account Activation') ?></a>
	</div>
	<div class="card">
		<div class="card-body login-card-body">
			<form id="myform" action="<?=$url_form ?>" method="post">
				<input type="hidden" name="user_id" value="<?=$user_id ?>">
				<input type="hidden" name="code" value="<?=$code_key ?>">

				<div class="row">
					<div class="col-12">
						<button type="submit" class="btn btn-primary btn-block"><?=lang('Activate Account') ?></button>
					</div>
				</div>
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
			Swal.fire('<?=lang('Congratulations') ?>!', response.message, 'success').then(function() {
				document.write('<?=lang('Please Wait') ?>..');
				window.location = '<?=$url_login ?>';
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
		//reset loading
		btn.prop('disabled', false).button('reset');
	});
})
</script>
@endsection