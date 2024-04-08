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
                <span>Employee Transfer/Posting</span>
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
        <div class="page-title">Employee Transfer/Posting</div>

        <div class="col-md-8 col-md-offset-1">
            {!! Form::model($data['transitInfo'], array('url' => 'transferTransitAction/', 'method' => 'PUT', 'role' => 'form','enctype'=>'multipart/form-data', 'class' => 'form-horizontal')) !!}

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
                <div class="form-group">
                    <label class="col-md-4 control-label">Transferred Branch/Division</label>
                    <div class="col-md-8">
                        {!! Form::text('posted_branch_name', $value = $data['postingHistory']->branch->branch_name ?? '', ['class' => 'form-control','readonly'=>'readonly', 'id'=>'posted_branch_name']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Last Release Date<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::text('effective_date', $value = $data['postingHistory']->effective_date, array('id'=>'effective_date', 'autocomplete'=>'off', 'placeholder'=>'dd/mm/yyyy','readonly'=>'readonly', 'class' => 'form-control date-picker', 'required'=>"")) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Transfer Order File</label>
                    <div class="col-md-8">
                        <a href="{{ asset('uploads/employeedata/' . ($data['transitInfo']->employee->employee_id ?? '') . '/transferfile/'.($data['transitInfo']->t_order_file ?? '') ) }}"
                           target="_blank"><i class="fa fa-eye">View File</i></a>
                        @if($errors->has('handortakeover_file'))
                            <span>{{ $errors->first('handortakeover_file') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Handover/Takeover File</label>
                    <div class="col-md-8">

                        @if($data['transitInfo']->status ==2)
                            <a href="{{ asset('uploads/employeedata/' . ($data['transitInfo']->employee->employee_id ?? '') . '/transferfile/'.($data['transitInfo']->handortakeover_file ?? '') ) }}"
                               target="_blank"><i class="fa fa-eye">View File</i></a>
                        @else
                            {!! Form::file(str_replace(" ", "_",'handortakeover_file'), $value = null, array('id'=>'handortakeover_file','class' => 'form-control')) !!}
                        @endif
                        @if($errors->has('handortakeover_file'))
                            <span>{{ $errors->first('handortakeover_file') }}</span>
                        @endif
                    </div>
                </div>
                @if($data['transitInfo']->status ==2)
                    <div class="form-group">
                        <label class="col-md-4 control-label">Joining Letter</label>
                        <div class="col-md-8">

                            {!! Form::file(str_replace(" ", "_",'joining_letter'), $value = null, array('id'=>'joining_letter','class' => 'form-control')) !!}

                            @if($errors->has('joining_letter'))
                                <span>{{ $errors->first('joining_letter') }}</span>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label class="col-md-4 control-label">Remarks</label>
                    <div class="col-md-8">
                        {!! Form::textarea('remarks', $value = null, ['class' => 'form-control', 'id'=>'remarks']) !!}
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
