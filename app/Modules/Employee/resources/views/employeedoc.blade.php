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
                            <span class="caption-subject bold uppercase">Employees Document List</span>
                        </div>
                        <div class="tools"> </div>
                    </div>


                    <div class="portlet-body">
                        {{--                    sarch--}}
                        <div class="form-group">
                            {{Form::open(['url'=>'getEmpDoc','method'=>'get'])}}
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Employee ID:</label>
                                {!! Form::select('employee_id', $allEmployees, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2', 'placeholder'=>'Select a Employee')) !!}

                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Branch/Division:</label>
                                {!! Form::select('branch', $branchList, $value = null, array('id'=>'branch', 'class' => 'form-control select2', 'placeholder'=>'Select a Branch/Division')) !!}
                            </div>
{{--                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">--}}
{{--                                <label for="FromDate" class="control-label">Designation:</label>--}}
{{--                                {!! Form::select('designation_id', $designationList, $value = null, array('id'=>'designation_id', 'class' => 'form-control select2', 'placeholder'=>'designation id')) !!}--}}
{{--                            </div>--}}
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            {{Form::close()}}
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                <a  class="btn btn-primary" href="{{url('downloadEmpDoc')}}">
                                              Download Excell
                                </a>
                            </div>

                        </div>
                        <table  class="table table-striped table-bordered table-hover dt-responsive" width="100%" ><!--  id="sample_5" id="sample_5" -->
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Full Name</th>
                                <th class="min-phone-l">Employee ID</th>
                                <th class="min-phone-l">Designation</th>
                                <th class="min-phone-l">NID</th>
                                <th class="desktop">Tin</th>
                                <th class="desktop">Passport</th>
                                <th class="desktop">Employee Photo</th>
                                <th class="desktop">Nominee Photo</th>
                                <th class="desktop">Academic Certificate</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $i =0 ?>

                            @foreach($results as $user)
                                    <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $user->employee_name }}</td>
                                    <td>{{ $user->employee_id }}</td>
                                    <td>{{ $user->designation }}</td>

                                    <td>
                                    @if (in_array(pathinfo($user->nid, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('uploads/' . $user->nid) }}" alt="nid Photo" style="width: 80px; height: 60px;">
                                    @elseif (in_array(pathinfo($user->nid, PATHINFO_EXTENSION), ['pdf']))
                                        <embed src="{{ asset('uploads/' . $user->nid) }}" type="application/pdf" width="80px" height="60px">
                                    @else
                                        <p>Empty</p>
                                    @endif
                                    </td>

                                    <td>
                                        @if (in_array(pathinfo($user->tin, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('uploads/' . $user->tin) }}" alt="tin Photo"  style="width: 80px; height: 60px;">
                                        @elseif (in_array(pathinfo($user->tin, PATHINFO_EXTENSION), ['pdf']))
                                            <embed src="{{ asset('uploads/' . $user->tin) }}" type="application/pdf"  width="80px" height="60px">
                                        @else
                                            <p>Empty</p>
                                        @endif
                                    </td>

                                    <td>
                                        @if (in_array(pathinfo($user->passport, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('uploads/' . $user->passport) }}" alt="passport Photo"  style="width: 80px; height: 60px;">
                                        @elseif (in_array(pathinfo($user->passport, PATHINFO_EXTENSION), ['pdf']))
                                            <embed src="{{ asset('uploads/' . $user->passport) }}" type="application/pdf" width="80px" height="60px">
                                        @else
                                            <p>Empty</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if (in_array(pathinfo($user->employee_photo, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('uploads/' . $user->employee_photo) }}" alt="Employee Photo"  style="width: 80px; height: 60px;">
                                        @elseif (in_array(pathinfo($user->employee_photo, PATHINFO_EXTENSION), ['pdf']))
                                            <embed src="{{ asset('uploads/' . $user->employee_photo) }}" type="application/pdf"  width="80px" height="60px">
                                        @else
                                            <p>Empty</p>
                                        @endif
                                    </td>

                                    <td>
                                        @if (in_array(pathinfo($user->nominee_photo, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('uploads/' . $user->nominee_photo) }}" alt="nominee Photo"  style="width: 80px; height: 60px;">
                                        @elseif (in_array(pathinfo($user->nominee_photo, PATHINFO_EXTENSION), ['pdf']))
                                            <embed src="{{ asset('uploads/' . $user->nominee_photo) }}" type="application/pdf"  width="80px" height="60px">
                                        @else
                                            <p>Empty</p>
                                        @endif
                                    </td>

                                    <td>
                                        @if (in_array(pathinfo($user->academic_certificate, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('uploads/' . $user->academic_certificate) }}" alt="academic certificate"  style="width: 80px; height: 60px;">
                                        @elseif (in_array(pathinfo($user->academic_certificate, PATHINFO_EXTENSION), ['pdf']))
                                            <embed src="{{ asset('uploads/' . $user->academic_certificate) }}" type="application/pdf" width="80px" height="60px">
                                        @else
                                            <p>Empty</p>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($results->count()>0)
                            {{$results->appends($_REQUEST)->render()}}
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