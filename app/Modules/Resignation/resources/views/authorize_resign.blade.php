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
                <span>Authorize Resign Employee List</span>
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
                @if (session('msg_error'))
                    <div class="alert alert-error">
                        {{ session('msg_error') }}
                    </div>
            @endif
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet blue box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Authorize Resign Employee List</span>
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">

                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                               id="sample_5">
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Employee ID</th>
                                <th class="min-phone-l">Employee Name</th>
                                <th class="min-phone-l">Designation</th>
                                <th class="min-phone-l">Branch/Division</th>
                                <th class="min-phone-l">Resignation Reason</th>
                                <th class="min-phone-l">Remarks</th>
                                <th class="min-phone-l">Resign Date</th>
                                <th class="min-phone-l">Release Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach($resignedEmpLists as $resignedEmp)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $resignedEmp->employee_id }}</td>
                                    <td>{{ $resignedEmp->employee->employee_name ?? '' }}</td>
                                    <td>{{ $resignedEmp->employee->designation ?? '' }}</td>
                                    <td>{{ $resignedEmp->employee->branch_name ?? '' }}</td>
                                    <td>{{ $resignedEmp->resignCat->description ?? '' }}</td>
                                    <td>{{ $resignedEmp->remarks ?? '' }}</td>
                                    <td>{{ $resignedEmp->date_resign ?? '' }}</td>
                                    <td>{{ $resignedEmp->release_date ?? '' }}</td>
                                    <td>
                                        <a href="{{ url('resign-auth/'.$resignedEmp->id) }}"
                                           class="btn btn-circle btn-sm btn-success" title="Approve"
                                           onclick="return confirm('Are you sure?')"><i class="fa fa-check" aria-hidden="true"></i></i>Approve</a>

                                        <a href="{{ url('resign-cancel/'.$resignedEmp->id) }}"
                                           class="btn btn-circle btn-sm btn-danger" title="Cancel"
                                           onclick="return confirm('Are you sure?')"><i class="fa fa-ban" aria-hidden="true"></i></i>Cancel</a>
                                    </td>
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