@extends('layouts.app')
@include('layouts.menu')
@section('breadcrumb')
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Transfer/Posting Transit Edit</span>
            </li>
        </ul>
        <div class="page-toolbar">
            <div class="pull-right">
                <i class="icon-calendar"></i>&nbsp;
                <span class="thin uppercase hidden-xs">{{ date('D, M d, Y') }}</span>&nbsp;
            </div>
        </div>
    </div>

    <!-- END PAGE BAR -->
@stop
@section('content')
    <div class="row">
        <div class="page-title">Transfer/Posting Transit Edit</div>

        <div class="col-md-8 col-md-offset-1">
            {!! Form::model($data['transitInfo'], array('url' => 'transferTransitUpdate/', 'method' => 'PUT', 'role' => 'form','enctype'=>'multipart/form-data', 'class' => 'form-horizontal')) !!}

            <div class="form-body">

                <div class="form-group hidden">
                    <div class="col-md-8">
                        {!! Form::text('id', $value = $value = $data['transitInfo']->id ?? null, array('id'=>'id', 'class' => 'form-control')) !!}
                        @if($errors->has('id'))
                            <span class="required">{{ $errors->first('id') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Employee Id<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::text('employee_id', $value = $data['transitInfo']->employee->employee_id ?? '', array('id'=>'employee_id', 'class' => 'form-control','readonly'=>'readonly', 'required'=>"" ,'placeholder'=>'Employee Id')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Employee Name</label>
                    <div class="col-md-8">
                        {!! Form::text('employee_name', $value = $data['transitInfo']->employee->employee_name ?? '', ['class' => 'form-control', 'id'=>'employee_name','readonly'=>'readonly', 'required'=>""]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Designation</label>
                    <div class="col-md-8">
                        {!! Form::text('designation', $value = $data['transitInfo']->employee->designation ?? '', ['class' => 'form-control','readonly'=>'readonly', 'id'=>'designation']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Functional Designation</label>
                    <div class="col-md-8">
                        {!! Form::text('func_desig_name', $value = $data['transitInfo']->employee->func_desig_name ?? '', ['class' => 'form-control','readonly'=>'readonly', 'id'=>'func_desig_name']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Current Branch/Division</label>
                    <div class="col-md-8">
                        {!! Form::text('cr_branch_name', $value = $data['transitInfo']->employee->branch_name ?? '', ['class' => 'form-control','readonly'=>'readonly', 'id'=>'cr_branch_name']) !!}
                    </div>
                </div>

                @if($data['transitInfo']->status==1)
                    <div class="form-group">
                        <label class="col-md-4 control-label">Current Branch Reliever</label>
                        <div class="col-md-8">
                            {!! Form::select('cr_branch_reliever', $data['currentEmpLists'], $value =$data['transitInfo']->cr_branch_reliever ?? null, array('id'=>'cr_branch_reliever', 'class' => 'form-control select2')) !!}
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label class="col-md-4 control-label">Transferred Branch/Division</label>
                    <div class="col-md-8">
                        {!! Form::text('posted_branch_name', $value = $data['postingHistory']->branch->branch_name ?? '', ['class' => 'form-control','readonly'=>'readonly', 'id'=>'posted_branch_name']) !!}
                    </div>
                </div>
                @if($data['transitInfo']->status==2)
                    <div class="form-group">
                        <label class="col-md-4 control-label">Posted Branch Reporter</label>
                        <div class="col-md-8">
                            {!! Form::select('posted_reporting_officer', $data['postedEmpLists'], $value = $data['transitInfo']->posted_reporting_officer ?? null, array('id'=>'posted_reporting_officer', 'class' => 'form-control select2')) !!}
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label class="col-md-4 control-label">Last Release Date<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::text('effective_date', $value = $data['postingHistory']->effective_date, array('id'=>'effective_date', 'autocomplete'=>'off', 'placeholder'=>'dd/mm/yyyy','readonly'=>'readonly', 'class' => 'form-control date-picker', 'required'=>"")) !!}
                    </div>
                </div>


            </div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a class="btn btn-primary" href="{{url('/employeeTransfer') }}"> Cancel</a>
                </div>
            </div>

            {!! Form::close() !!}
        </div>


    </div>

@endsection

@section('css')
    <link href="{{ asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet"
          type="text/css"/>
@stop

@section('script')
    <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/my_scripts/transfer.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy'
        });

        $(document).ready(function () {
            var checkboxes = $('.checkboxes');
            checkboxes.change(function () {
                if ($('.checkboxes:checked').length > 0) {
                    checkboxes.removeAttr('required');
                } else {
                    checkboxes.attr('required', 'required');
                }
            });
        });
    </script>
@endsection
