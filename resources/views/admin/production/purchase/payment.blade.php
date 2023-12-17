<div class="card">
    <div class="card-header">
        <h6>{{_lang('Add payment ')}}</h6>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-4">
                <div class="well">
                    <strong>Purchase By
                    </strong>:{{$model->employee?$model->employee->name:''}}<br>
                    <strong>Brand: </strong>{{$model->brand?$model->brand->name:''}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="well">
                    <strong>Reference No: </strong>{{$model->reference_no}}
                    <br>
                    <strong>Location: </strong>SATT ERP
                </div>
            </div>
            <div class="col-md-4">
                <div class="well">
                    <strong>Total amount: </strong>
                    {{$model->net_total}}<br>
                    <strong>Payment: </strong>{{$model->paid}}<br>
                    <strong>Due: </strong>{{$model->due}}<br>
                </div>
            </div>
        </div>


        <form action="{{route('admin.production-purchase.add_payment', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="table-responsive" style="margin-top: 10px">
                <table class="table table-bordered table-hover" id="normalinvoice">
                    <tfoot>
                        <tr>
                            <td colspan="5" style="text-align:right;"><b> Total Due:</b></td>
                            <td class="text-right">
                                <input id="Totalamt" class="form-control Totalamt" name="Totalamt"
                                    value="{{$model->due}}" readonly="" type="text">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:right;" colspan="5"><span class="text-danger">*</span><b>Paid Amount:</b></td>
                            <td class="text-right">
                                <input id="paidAmount" autocomplete="off" class="form-control" name="paid_amount" required
                                    value="" placeholder="0.00" type="text">
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align:right;" colspan="5"><b>Due:</b></td>
                            <td class="text-right">
                                <input id="dueAmmount" class="form-control valid" name="due_amount" value=""
                                    readonly="" type="text">
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align:right;" colspan="5"><b>Pay Account:</b></td>
                            <td class="text-right">
                           <select name="investment_account_id" id="investment_account_id" class="form-control select">
                            <option value="">Select Account</option>
                            @foreach ($inves_account as $element)
                                <option value="{{ $element->id }}">{{ $element->name }}</option>
                            @endforeach
                        </select>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align:right;" colspan="5"><span class="text-danger">*</span><b>Payment Method:</b></td>
                            <td class="text-right">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-money"></i></span>
                                    </div>
                                    <select data-placeholder="Select Payment Method" class="form-control select" required
                                        id="method" name="method">
                                        <option value="" selected>Select Payment Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr id='tr_hide'>
                            <td colspan="5" style="text-align:right;"><b>Transaction No:</b></td>
                            <td class="text-right">
                                <input class="form-control" placeholder="Transaction No." id="transaction"
                                    name="transaction_no" type="text" value="">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align:right;"><span class="text-danger">*</span> <b>Payment date:</b></td>
                            <td class="text-right">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"
                                            aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" required class="form-control date" name="payment_date" id="payment_date">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align:right;"><b>Payment note:</b></td>
                                <td class="text-right">
                                    <textarea name="payment_note" class="form-control" placeholder="Payment note"></textarea>
                                </td>
                            </tr>
                    </tfoot>
                </table>
            </div>

            <div class="form-group col-md-12" align="right">
                <button type="submit" class="btn btn-primary" id="submit">{{_lang('Payment')}}<i
                        class="icon-arrow-right14 position-right"></i></button>
                <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}
                    <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>

<script>
    _componentDatePicker();
</script>
<script src="{{ asset('js/production/purchase.js') }}"></script>
