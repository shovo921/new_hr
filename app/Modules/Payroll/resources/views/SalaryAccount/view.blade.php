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
                <span>Employee Salary Account Information</span>
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
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <div class="row">
        <div class="col-md-12" style="margin-top:20px;">
            <div class="table-responsive">

                @if (session('msg_success'))
                    <div class="alert alert-success">
                        {{ session('msg_success') }}
                    </div>
            @endif

            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet blue box">
                    <div class="portlet-title">

                        <a href="{{  url('/salary-account/create') }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Add New Employee Salary Account
                        </a>


                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Employee Salary Account List</span>
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">

                        <div class="portlet-body">
                            <div class="form-group">
                                {{Form::open(['url'=>'salary-account/','method'=>'get'])}}
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label for="FromDate" class="control-label">Employee ID:</label>
                                    {!! Form::select('employee_id', $employeeList, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2')) !!}

                                </div>
                                <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                    <label for="ID" class="control-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                                {{Form::close()}}
                            </div>


                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                                   id="sample_5">
                                <thead>
                                <tr>
                                    <th class="all">SI No</th>
                                    <th class="min-phone-l">Employee</th>
                                    <th class="min-phone-l">Account Information</th>
                                    <th class="min-phone-l">Branch</th>
                                    <th class="min-phone-l">Designation</th>
                                    <th class="min-phone-l">Basic</th>
                                    <th class="min-phone-l">Gross Total</th>
                                    <th> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0 ?>


                                @foreach($salaryAccount as $salaryAccounts)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $salaryAccounts->employee->name ?? '' }}
                                            ({{ $salaryAccounts->employee_id }})
                                        </td>
                                        <td>{{ $salaryAccounts->account_no ?? '' }}</td>
                                        <td>{{ $salaryAccounts->employeeDetails->branch_name ?? ''}}</td>
                                        <td>{{ $salaryAccounts->employeeDetails->designation ?? '' }}</td>
                                        <td>{{ $salaryAccounts->salaryAccount->current_basic ?? ''}}</td>
                                        <td>{{ $salaryAccounts->salaryAccount->gross_total ?? '' }}</td>
                                        <td>
                                            <a href="{{ url('salary-account/edit/'.$salaryAccounts->id) }}"
                                               class="btn btn-circle btn-success btn-sm pull-left">
                                                <i class="fa fa-edit"></i>
                                                Account Edit</a> <br>
                                            <a href="{{ url('salary-amount/view/'.$salaryAccounts->employee_id) }}"
                                               class="btn btn-circle btn green btn-sm purple pull-left">
                                                <i class="fa fa-edit"></i>
                                                Salary Setup</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if($salaryAccount->count()>0)
                                {{$salaryAccount->appends($_REQUEST)->render()}}
                            @endif
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->

        @endsection

        {{--script--}}
@section('script')
            <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"
                    type="text/javascript"></script>
            <script src="{{ asset('assets/pages/scripts/components-multi-select.min.js') }}"
                    type="text/javascript"></script>

@endsection
