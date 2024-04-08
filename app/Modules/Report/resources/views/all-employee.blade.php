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
            <span>All EMployee List</span>
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
    <div class="search-bar ">
        {!! Form::open(array('url' => 'all-employee', 'method' => 'get', 'role' => 'form', 'class' => 'form-horizontal')) !!}
        <div class="row">
            <div class="col-md-12">
                <h3>Search</h3>
                <div class="form-group">
                    <div class="col-md-2">
                        {!! Form::text('employee_id', $value = Request::get("employee_id"), array('id'=>'employee_id', 'class' => 'form-control', 'placeholder'=>'Employee ID')) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('employee_name', $value = Request::get("employee_name"), array('id'=>'employee_name', 'class' => 'form-control', 'placeholder'=>'Employee Name')) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::select('designation_id', $designations, Request::get("designation_id"), ['id'=>'designation_id', 'class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('file_no', $value = Request::get("file_no"), array('id'=>'file_no', 'class' => 'form-control', 'placeholder'=>'File No')) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::submit('Filter', array('class' => "btn btn-primary")) !!} &nbsp;
                        <a href="{{  url('/all-employee') }}" class="btn btn-success">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

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
                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase">All Employee List</span>
                    </div>
                    <div class="tools"> </div>
                </div>

                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
                        <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Employee ID</th>
                                <th class="min-phone-l">Name</th>
                                <th class="designation">Designation</th>
                                <th class="min-phone-l">File No</th>
                                <th class="min-phone-l">Employment Type</th>
                                <th class="min-phone-l">Joining Date</th>
                            </tr>
                        </thead>
                        <tbody>  
                            <?php $i =0; ?>
                            @foreach($employeeList as $employee)   
                            <?php $i++; ?>                                           
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $employee->employee_id }}</td>
                                <td>{{ $employee->employee_name }}</td>
                                <td>{{ $employee->designation }}</td>
                                <td>{{ $employee->personal_file_no }}</td>
                                <td>{{ $employee->employment_type }}</td>
                                <td>{{ $employee->joining_date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($employeeList->count()>0)
                    {{$employeeList->appends($_REQUEST)->render()}}
                    @endif
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->

@endsection