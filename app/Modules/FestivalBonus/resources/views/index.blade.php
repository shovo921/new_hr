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
            <span>Festival Bonus List</span>
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
                    <a href="{{  url('/holiday/create') }}" class="btn btn-default pull-right" style="margin-top: 3px;">
                        <i class="fa fa-plus"></i>
                        Add New Employee Bonus
                    </a>
                    <a href="{{  route('bonus.csv.index') }}" class="btn btn-default pull-right" style="margin-top: 3px; margin-right: 20px">
                        <i class="icon-settings"></i>
                        Csv file import
                    </a>
                    <div class="caption">
                        <i class="fa fa-bullhorn"></i>
                        <span class="caption-subject bold uppercase">Festival Bonus List</span>
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">                            

                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                        <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Employee</th>
                                <th class="min-phone-l">BONUS TYPE</th>
                                <th class="min-phone-l">PAY TYPE</th>
                                <th class="min-phone-l">AMOUNT</th>
                                <th class="min-phone-l">REMARKS</th>
                                <th class="min-phone-l">PAYMENT DATE</th>
                                <th class="min-phone-l">STATUS</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>  
                            <?php $i =0 ?> 
                            @foreach($bonus as $bonus)
                            <?php $i++; ?>                                           
                            <tr>

                                <td>{{ $i }}</td>
                              <?php   $bonus->payment_date = date('Y-m-d', strtotime($bonus->payment_date));?>
                                <td>{{ $bonus->employee_id.' - '.$bonus->EmployeeName->employee_name }}</td>
                                <td>{{ $bonus->bonusTypeName->type }}</td>
                                <td>{{ $bonus->PayTypeName->description }}</td>
                                <td>{{ $bonus->amount }}</td>
                                <td>{{ $bonus->remarks }}</td>
                                <td>{{ $bonus->payment_date }}</td>
                                <td>@if($bonus->status == 1)
                                        No
                                    @elseif($bonus->status == 2)
                                        Yes
                                    @elseif($bonus->status == 3)
                                        On Provision
                                    @endif</td>

                                <td>
                                    <a href="{{ url('FestivalBonus/'.$bonus->id.'/edit') }}" class="btn btn-circle green btn-sm purple pull-left"><i class="fa fa-edit"></i>Edit</a>

                                    <!-- <a href="{{ url('FestivalBonus/'.$bonus->id) }}" class="btn btn-circle btn green btn-sm purple pull-left"><i class="fa fa-eye"></i> View</a> -->

                                    <form class="delete_item_form" accept-charset="UTF-8" action="FestivalBonus/{{ $bonus->id }}" method="POST">
                                    {!! csrf_field() !!} 
                                    <input type="hidden" value="DELETE" name="_method"><button class="btn btn-outline btn-circle dark btn-sm red" type="submit"><i class="fa fa-trash-o"></i> Delete</button>
                                    </form>
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