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
            <span>User</span>
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
<div class="search-page search-content-2">
    @if (in_array(auth()->user()->role_id,['1', '2','3']))
    <div class="search-bar ">
        {!! Form::open(array('url' => 'employee', 'method' => 'get', 'role' => 'form', 'class' => 'form-horizontal')) !!}
        <div class="row">
            <div class="col-md-12">
                <h3>Search</h3>
                <div class="form-group">
{{--                    <div class="col-md-2">--}}
{{--                        {!! Form::text('employee_id', $value = Request::get("employee_id"), array('id'=>'employee_id', 'class' => 'form-control', 'placeholder'=>'Employee ID')) !!}--}}
{{--                    </div>--}}
                    @php

                    @endphp
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <label for="FromDate" class="control-label">Employee ID:</label>
                        {!! Form::select('employee_id', $allEmployees, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2', 'placeholder'=>'Select a Employee')) !!}
                    </div>

{{--                    <div class="col-md-2">--}}
{{--                        {!! Form::text('employee_name', $value = Request::get("employee_name"), array('id'=>'employee_name', 'class' => 'form-control', 'placeholder'=>'Employee Name')) !!}--}}
{{--                    </div>--}}
                    <div class="col-md-3">
                        <label for="FromDate" class="control-label">Designation ID:</label>
                        {!! Form::select('designation_id', $designations, Request::get("designation_id"), ['id'=>'designation_id', 'class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-2">
                        <label for="FromDate" class="control-label">File no:</label>
                        {!! Form::text('file_no', $value = Request::get("file_no"), array('id'=>'file_no', 'class' => 'form-control', 'placeholder'=>'File No')) !!}
                    </div>
                    <div class="col-md-2">
                        <br>

                        {!! Form::submit('Filter', array('class' => "btn btn-primary")) !!} &nbsp;
                        <a href="{{  url('/all-employee') }}" class="btn btn-success">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
        @endif
</div>

<div class="row">
    <div class="col-md-12" style="margin-top:20px;">				
        <div class="table-responsive">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet blue box">
                <div class="portlet-title">
                    @if (in_array(auth()->user()->role_id,['1','3']))
                    <a href="{{  url('/employee/create') }}" class="btn btn-default pull-right" style="margin-top: 3px;">
                        <i class="fa fa-plus"></i>
                        Create New Employee
                    </a>
                    @endif
                        <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase">Employee List</span>
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">                            

                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"><!--  id="sample_5" -->
                        <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Full Name</th>
                                <th class="min-phone-l">Employee ID</th>
                                <th class="min-phone-l">Designation</th>
                                @if (in_array(auth()->user()->role_id,['1','3']))
                                <th class="min-phone-l">File No</th>
                                @endif
                                <th class="desktop">Mobile</th>
                                <th class="desktop">Joining Date</th>
                                <th class="desktop">Status</th>
                                @if (in_array(auth()->user()->role_id,['1','3']))
                                <th> Action </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>   
                            <?php $i =0 ?>

                            @foreach($users as $user)
                            <?php $i++; ?>                                           
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $user->employee_name }}</td>
                                <td>{{ $user->employee_id }}</td>
                                <td>{{ $user->designation }}</td>
                                @if (in_array(auth()->user()->role_id,['1','3']))
                                <td>{{ $user->personal_file_no }}</td>
                                @endif
                                <td>{{ $user->phone_no }}</td>
                                <td>{{ $user->joining_date }}</td>
                                <td> 
                                    {!! ($user->status == 1) ? 'Active' : 'Inactive' !!}
                                </td>
                                @if (in_array(auth()->user()->role_id,['1','3']))
                                <td>
                                    @if(auth()->user()->employee_id ==='hradmin' ||auth()->user()->employee_id ==='hrexecutive' )
                                    <a href="{{ url('employee/'.$user->employee_id.'/edit') }}" class="btn btn-circle btn-sm purple pull-left">
                                        <i class="fa fa-edit"></i>
                                        Edit</a>
                                    @endif
                                    @if(auth()->user()->employee_id ==='hradmin' ||auth()->user()->employee_id ==='hrexecutive' )
                                    <a href="{{ url('employee/'.$user->employee_id) }}" class="btn btn-circle btn-sm green-meadow pull-left">
                                        <i class="fa fa-eye"></i>
                                        View</a>
                                        @endif
                                    {{--
                                        @if($user->status == 1 && auth()->user()->role_id == '1')
                                        <a href="{{ url('employeeSalary/'.$user->employee_id.'') }}" class="btn btn-circle btn-sm blue pull-left">
                                            <i class="fa fa-dollar"></i>
                                            Increment</a>

                                        <a href="{{ url('employeePromotion/'.$user->employee_id.'') }}" class="btn btn-circle btn-sm red pull-left">
                                            <i class="fa fa-external-link-square" aria-hidden="true"></i>
                                            Promotion</a> 
                                        @endif
                                    --}}
                                </td>
                                @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($users->count()>0)
                        {{$users->appends($_REQUEST)->render()}}
                        @endif
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->

    @endsection
@section('script')

    <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>

@endsection