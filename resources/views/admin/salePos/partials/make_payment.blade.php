@if($model->net_total - $model->paid > 0)
<h3>{{ _lang('Make Payment') }}</h3>
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.sales.payment') }}"  method="post" id="content_form">
            <input type="hidden" name="client_id" value="{{$model->client_id}}">
            <input type="hidden" name="type" value="Credit">
            <input type="hidden" name="transaction_id" value="{{$model->id}}">
            <div class="row">
                <div class="col-md-12">
                    <label for="payment_date">
                        {{ _lang('Date') }}
                    </label>
                    <input type="text" class="form-control date" name="payment_date" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-12">
                    <label for="method">{{ _lang('Method') }} </label>
                    <select name="method" class="form-control method" style="width: 100%">
                        <option value="cash">Cash</option>
                        <option value="check">Check</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-12 reference_no" style="display:none">
                    <label for="">Reference No</label>
                    <input type="text" name="check_no" class="form-control">
                </div>
                <div class="col-md-12">
                    <label for="amount">
                        {{ _lang('Amount') }}
                    </label>
                    <input type="text" class="form-control" name="amount" id="amount" required>
                     <p id="message" style="color: red;"></p>
                </div>
                <div class="col-md-12">
                    <label for="note">
                        {{ _lang('Note') }}
                    </label>
                    <textarea name="note" class="form-control" id="" placeholder="Description"></textarea>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6 mx-auto text-center">
                    <button type="submit" class="btn btn-primary btn-lg w-100" id="submit">{{ _lang('Payment') }}</button>
                    <button type="button" class="btn btn-primary btn-lg w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }}  <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
@else
 <div class="alert alert-success text-light">
  <strong>{{ _lang('This Transection has No Due') }}</strong>.
</div>
@endif