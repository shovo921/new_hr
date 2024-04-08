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


    <div class="row">
        <div class="col-md-12" style="margin-top:20px;">
            <div class="table-responsive">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet blue box">
                    <div class="portlet-title">
{{--                        @if (in_array(auth()->user()->role_id,['1','3']))--}}
{{--                            <a href="{{  url('/employee/create') }}" class="btn btn-default pull-right" style="margin-top: 3px;">--}}
{{--                                <i class="fa fa-plus"></i>--}}
{{--                                Create New Employee--}}
{{--                            </a>--}}
{{--                        @endif--}}
                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Employment log List</span>
                        </div>
                        <div class="tools"> </div>
                    </div>


                    <div class="portlet-body">
                        {{--                    sarch--}}
                        <div class="form-group">
                            {{Form::open(['url'=>'employment-log','method'=>'get'])}}
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Employee ID:</label>
                                {!! Form::select('employee_id', $allEmployees, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2', 'placeholder'=>'Select a Employee')) !!}

                            </div>

                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            {{Form::close()}}

                        </div>


                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Full Name</th>
                                <th class="min-phone-l">Employee ID</th>
                                <th class="desktop">Prv employment type</th>
                                <th class="desktop">Employment type</th>
                                <th class="desktop">Employment started</th>
                                <th class="desktop">Start date</th>
                                <th class="desktop">End date</th>

                            </tr>
                            </thead>
                            <tbody>


                            <?php $i =0 ?>

                            @foreach($data as $user)
                                    <?php $i++; ?>
                                <tr>

                                    <td>{{ $i }}</td>
                                    <td>{{ $user->employee->employee_name }}</td>
                                    <td>{{ $user->employee->employee_id }}</td>
                                    <td>{{ $user->prev_type->employment_type }}</td>
                                    <td>{{ $user->current_type->employment_type }}</td>
                                    <td>{{ $user->employment_started }}</td>
                                    <td>{{ $user->start_date }}</td>
                                    <td>{{ $user->end_date }}</td>



                                </tr>
                            @endforeach
                            </tbody>
                        </table>

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