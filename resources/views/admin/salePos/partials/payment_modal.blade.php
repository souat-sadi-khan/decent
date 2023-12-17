<div id="paymentModal" class="modal fade border-top-success rounded-top-0"  role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-grey-300 bg-info">
                <h5 class="modal-title"></h5>
                <button type="button" class="modal-btn btn btn-danger btn-sm pull-right" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> {{ _lang('Exit') }}</button>
            </div>
            <div class="modal-body">
                <div class="row no-gutters">
                    <div class="col-md-8 p-1">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('paid', _lang('Paid')) }}
                                            {{ Form::text('paid', null, ['class' => 'form-control input_number paid', 'id'=>'paid', 'placeholder' => _lang('Paid')]) }}
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('method', _lang('Method')) }}
                                             <select name="method" class="form-control method">
                                                <option value="cash">Cash</option>
                                                <option value="check">Check</option>
                                                <option value="other">Other</option>
                                             </select>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('method', _lang('Payment Account')) }}
                                            {!! Form::select('account_id', $accounts,null, ['class' => 'form-control select', 'required']); !!}
                                            
                                        </div> 
                                    </div>
                                    <div class="col-md-12 reference_no" style="display:none">
                                         {{ Form::label('check_no', _lang('Reference')) }}
                                            {{ Form::text('check_no', null, ['class' => 'form-control input_number', 'id'=>'check_no', 'placeholder' => _lang('Reference')]) }}
                                    </div>

                                      <div class="col-md-12 ">
                                         {{ Form::label('note', _lang('Payment Note')) }}
                                         {{ Form::textarea('note', null, ['class' => 'form-control', 'placeholder' =>  _lang('Payment Note'), 'rows' => '5']) }}
                                    </div>
                                </div>
                                <div class="row">
                                  
                                    <div class="col-md-6">
                                         {{ Form::label('sale_note', _lang('Sale note')) }}
                                         {{ Form::textarea('sale_note', null, ['class' => 'form-control', 'placeholder' =>  _lang('Sale note'), 'rows' => '5']) }}
                                    </div> 

                                     <div class="col-md-6">
                                         {{ Form::label('stuff_note', _lang('Stuff note')) }}
                                         {{ Form::textarea('stuff_note', null, ['class' => 'form-control', 'placeholder' =>  _lang('Stuff note'), 'rows' => '5']) }}
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box box-solid bg-purple">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>
                                        {{ _lang('Total Items')}}:
                                        </strong>
                                        <br/>
                                        <span class="lead text-bold total_item">0</span>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <strong>
                                        {{ _lang('Total Payable') }}:
                                        </strong>
                                        <br/>
                                        <span class="lead text-bold net_total">0</span>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <strong>
                                        {{ _lang('Total Paying') }}:
                                        </strong>
                                        <br/>
                                        <span class="lead text-bold total_paying">0</span>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <strong>
                                        {{ _lang('Change Return') }}:
                                        </strong>
                                        <br/>
                                        <span class="lead text-bold change_return_span">0</span>
                                        {{ Form::hidden('due', null, ['class' => 'form-control', 'id'=>'due', 'placeholder' => _lang('Due')]) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                      {{ Form::submit(_lang('Make Payment'), ['class' => 'btn btn-outline btn-success btn-round btn-wd w-100 ', 'id' => '']) }}
                         <button type="button" class="btn btn-primary btn-lg w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }}  <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>