<div class="form-body">

    <div class="form-group">
        <label class="col-md-4 control-label">Employee ID<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('employee_id',$value = $loanAcc->employee_id, array('id'=>'employee_id', 'class' => 'form-control ','placeholder'=>'Employee Id', 'required'=>"",'readonly'=>"")) !!}
            @if($errors->has('employee_id'))
                <span class="required">{{ $errors->first('employee_id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Employee Name</label>
        <div class="col-md-8">
            {!! Form::text('employee_name', $value = $loanAcc->employeeDetails->employee_name ?? '', array('id'=>'employee_name','readonly'=>'readonly','placeholder'=>'Employee Name', 'class' => 'form-control')) !!}
            @if($errors->has('employee_name'))
                <span class="required">{{ $errors->first('employee_name') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Designation</label>
        <div class="col-md-8">
            {!! Form::text('employee_designation', $value = $loanAcc->employeeDetails->designation ?? '', array('id'=>'employee_designation','readonly'=>'readonly','placeholder'=>'Designation', 'class' => 'form-control')) !!}
            @if($errors->has('employee_designation'))
                <span
                        class="required">{{ $errors->first('employee_designation') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Account Number<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('acc_no', $value = $loanAcc->acc_no, array('id'=>'acc_no','placeholder'=>'Please Give Account Number', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('acc_no'))
                <span
                        class="required">{{ $errors->first('acc_no') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Disbursement Amount<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('disb_amt', $value = $loanAcc->disb_amt, array('id'=>'disb_amt','placeholder'=>'Please Give Disbursement Amount', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('disb_amt'))
                <span
                        class="required">{{ $errors->first('disb_amt') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Rate<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('rate', $value = $loanAcc->rate, array('id'=>'rate','placeholder'=>'Please Give Rate', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('rate'))
                <span
                        class="required">{{ $errors->first('rate') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Disbursement Date</label>
        <div class="col-md-8">
            <?php

            use Carbon\Carbon;

            $disb_date = null;
            if (@$loanAcc->disb_date != '') {
                $disb_date = date('Y/m/d', strtotime($loanAcc->disb_date));
            }
            ?>
            {!! Form::text('disb_date', $value = $disb_date, array('id'=>'disb_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Start Month</label>
        <div class="col-md-8">
            {!! Form::text('start_month', $value = $loanAcc->start_month, array('id'=>'start_month', 'placeholder'=>'mm-yyyy', 'class' => 'form-control date-picker1')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">End Month</label>
        <div class="col-md-8">
            {!! Form::text('end_month', $value = $loanAcc->end_month, array('id'=>'end_month', 'placeholder'=>'mm-yyyy', 'class' => 'form-control date-picker1')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Tenor<span class="required">*</span></label>
        <div class="row">
            <div class="col-sm-6">
                {!! Form::number('tenor', $value = $loanAcc->tenor, array('id'=>'tenor','placeholder'=>'Please Give Tenor Number', 'class' => 'form-control', 'required'=>"")) !!}
                @if($errors->has('tenor'))
                    <span
                            class="required">{{ $errors->first('tenor') }}</span>
                @endif
            </div>
            <div class="col-sm-1" style="padding-top: 5px">
                Month
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Select Branch<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('branch_id',$branchList, $value = $loanAcc->branch_id, array('id'=>'branch_id', 'class' => 'form-control select2','placeholder'=>'Branch ID', 'required'=>"")) !!}
            @if($errors->has('branch_id'))
                <span class="required">{{ $errors->first('branch_id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Select Deduction Type<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('dtype_id',$dedList, $value = $loanAcc->dtype_id, array('dtype_id'=>'dtype_id', 'class' => 'form-control select2','placeholder'=>'DeductionType', 'required'=>"")) !!}
            @if($errors->has('dtype_id'))
                <span class="required">{{ $errors->first('dtype_id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('status', $status, $value = $loanAcc->status, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('status'))
                <span class="required">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>
    {{--@if($loanAcc->dtype_id == 3)--}}
        <div class="form-group">
            <label class="col-md-4 control-label">Executive Car Loan</label>
            <div class="col-md-8">
                {!! Form::select('exe_car_loan', $data['exe_car_loan'], $value = $loanAcc->exe_car_loan, array('id'=>'exe_car_loan', 'class' => 'form-control', 'required'=>"")) !!}
                @if($errors->has('exe_car_loan'))
                    <span class="required">{{ $errors->first('exe_car_loan') }}</span>
                @endif
            </div>
        </div>
    {{--@endif--}}


    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
            <a href="{{  url('account-loan') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>