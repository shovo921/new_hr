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
            <span>Salary Head List</span>
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
                    <a href="{{  url('/salary-head/create') }}" class="btn btn-default pull-right" style="margin-top: 3px;">
                        <i class="fa fa-plus"></i>
                        Add New Salary Head
                    </a>

                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase">Salary Head List</span>
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">                            

                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                        <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Salary Head</th>
                                <th class="min-phone-l">Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>  
                            <?php $i =0 ?> 
                            @foreach($salary_heads as $salary_head)   
                            <?php $i++; ?>                                           
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $salary_head->salary_head }}</td>
                                <td>{{ ($salary_head->status == '1') ? 'Active':'Inactive' }}</td>
                                <td>
                                    <a href="{{ url('salary-head/'.$salary_head->id.'/edit') }}" class="btn btn-circle green btn-sm purple pull-left"><i class="fa fa-edit"></i>Edit</a>

                                    <form class="delete_item_form" accept-charset="UTF-8" action="salary-head/{{ $salary_head->id }}" method="POST"> 
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