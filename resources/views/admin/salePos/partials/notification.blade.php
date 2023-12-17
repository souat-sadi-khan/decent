<div class="card">
	<div class="card-head">
		<div class="animated-radio-button">
			<label class="ml-5">
				<input type="radio" class="notify" name="radio" value="email_send" checked><span class="label-text">{{ _lang('Email') }}</span>
			</label>
			<label class="ml-5">
				<input type="radio" class="notify" name="radio" value="sms_send"><span class="label-text">{{ _lang('SMS') }}</span>
			</label>
		</div>
	</div>
	<div class="card-body">
	   <div id="email_div">
	   		<form action="{{ route('admin.emailmarketing.transaction_email') }}" id="content_form" method="post">
			<div class="row">
				<div class="col-md-12">
					<label for="email">{{ _lang('Send Mail') }} </label>
					<input type="text" class="form-control" name="email" id="email" value="{{ $model->client->email }}" required>
				</div>
				<div class="col-md-12">
					<label for="subject">{{ _lang('Subject') }} </label>
					<input type="text" class="form-control" name="subject" id="subject" value="" required>
				</div>
				<div class="col-md-12">
					<label for="template">{{ _lang('template') }} </label>
					<select name="template" id="template" class="form-control select">
						@foreach ($templates as $element)
						<option value="{{ $element->id }}">{{ $element->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="row mt-2">
				<div class="col-md-6 mx-auto text-center">
					<button type="submit" class="btn btn-primary btn-lg w-100" id="submit">{{ _lang('Send Mail') }}</button>
					 <button type="button" class="btn btn-info btn-lg w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
				</div>
			</div>
		</form>
	   </div>
	   <div id="sms_div" style="display: none;">
	   		<form action="{{ route('admin.smsmerketing.transaction_sms') }}" class="content_form">
			<div class="row">
				<div class="col-md-12">
					<label for="mobile">{{ _lang('Send Sms Number') }} </label>
					<input type="text" class="form-control" name="mobile" id="mobile" value="{{ $model->client->mobile }}" required>
				</div>
				<div class="col-md-12">
					<label for="message">{{ _lang('Message') }} </label>
					<input type="text" class="form-control" name="message" id="message" value="" required>
					<small>{{ _lang('Maximum 255 Word') }}</small>
				</div>
			</div>
			<div class="row mt-2">
				<div class="col-md-6 mx-auto text-center">
					<button type="submit" class="btn btn-primary btn-lg w-100" id="submit">{{ _lang('Send Sms') }}</button>
					 <button type="button" class="btn btn-info btn-lg w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
				</div>
			</div>
		</form>
	   </div>
	</div>
</div>

<script>
$(document).on('change', '.notify', function(){
    var notification_type = $(this).val();
    if (notification_type == 'sms_send') {
      $('div#email_div').hide();
      $('div#sms_div').show();
    }
    else{
      $('div#email_div').show();
      $('div#sms_div').hide();
    }
  });
</script>