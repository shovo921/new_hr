<div class="form-body">

    <div class="form-group">
        <label class="col-md-4 control-label">Employee ID</label>
        <div class="col-md-8">
            {!! Form::text('employee_id',$value = $paidDayEdit->employee_id, array('id'=>'employee_id', 'class' => 'form-control ','placeholder'=>'Employee Id', 'required'=>"",'readonly'=>"")) !!}
            @if($errors->has('employee_id'))<span class="required">{{ $errors->first('employee_id') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Employee Name</label>
        <div class="col-md-8">
            {!! Form::text('employee_name', $value = $paidDayEdit->employeeDetails->employee_name ?? '', array('id'=>'employee_name','readonly'=>'readonly','placeholder'=>'Employee Name', 'class' => 'form-control')) !!}
            @if($errors->has('employee_name'))<span class="required">{{ $errors->first('employee_name') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Designation</label>
        <div class="col-md-8">
            {!! Form::text('employee_designation', $value = $paidDayEdit->employeeDetails->designation ?? '', array('id'=>'employee_designation','readonly'=>'readonly','placeholder'=>'Designation', 'class' => 'form-control')) !!}
            @if($errors->has('employee_designation'))<span
                    class="required">{{ $errors->first('employee_designation') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Payment Date</label>
        <div class="col-md-8">
            <?php
            use Carbon\Carbon;
            $payment_date = null;
            if(@$paidDayEdit->payment_date != '') {
                $payment_date = date('Y/m/d', strtotime($paidDayEdit->payment_date));
            }
            ?>
            {!! Form::text('payment_date', $value = $payment_date, array('id'=>'payment_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control','readonly'=>"")) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Month & Year</label>
        <div class="col-md-8">
            <?php
            $year_month = null;
            if(@$paidDayEdit->year_month != '') {
                $year_month = date('Y/M', strtotime($paidDayEdit->year_month));
            }
            ?>
            {!! Form::text('year_month', $value = $year_month, array('id'=>'year_month', 'placeholder'=>'mm/yyyy', 'class' => 'form-control','readonly'=>"")) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">First Day</label>
        <div class="col-md-8">
            <?php
            $default_date= null;
            if(@$paidDayEdit->default_date != '') {
                $default_date = date('Y/m/d', strtotime($paidDayEdit->default_date));
            }
            ?>
            {!! Form::text('default_date', $value = $default_date, array('id'=>'default_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control','readonly'=>"")) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Last Day</label>
        <div class="col-md-8">
            <?php
            $end_date= null;
            if(@$paidDayEdit->end_date != '') {
                $end_date = date('Y/m/d', strtotime($paidDayEdit->end_date));
            }
            ?>
            {!! Form::text('end_date', $value = $end_date, array('id'=>'end_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control','readonly'=>"")) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Days Count<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('day_count', $value = $paidDayEdit->day_count, array('id'=>'day_count','placeholder'=>'Please Give Days Count', 'class' => 'form-control', 'required'=>"",'readonly'=>"")) !!}
            @if($errors->has('day_count'))<span
                    class="required">{{ $errors->first('day_count') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Day Paid</label>
        <div class="col-md-8">
            {!! Form::text('day_paid', $value = $paidDayEdit->day_paid ?? '', array('id'=>'day_paid','placeholder'=>'Day Paid', 'class' => 'form-control')) !!}
            @if($errors->has('day_paid'))<span
                    class="required">{{ $errors->first('day_paid') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('status', $status, $value = $paidDayEdit->status, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('status'))<span class="required">{{ $errors->first('status') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Ready to pay<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('ready_to_pay', $ready_to_pay, $value = $paidDayEdit->ready_to_pay, array('id'=>'ready_to_pay', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('ready_to_pay'))<span class="required">{{ $errors->first('ready_to_pay') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Remarks</label>
        <div class="col-md-8">
            {!! Form::text('remarks', $value = $paidDayEdit->remarks ?? '', array('id'=>'remarks','placeholder'=>'Remarks', 'class' => 'form-control')) !!}
            @if($errors->has('remarks'))<span
                    class="required">{{ $errors->first('remarks') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
            <a href="{{  url('salary-process') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>