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
                <span>Holiday CSV Import</span>
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
    <div class="portlet blue box">
        <div class="portlet-title">

            <a href="{{  route('csv.download') }}" class="btn btn-default pull-right" style="margin-top: 3px; margin-right: 20px">
                <i class="icon-settings"></i>
                Download demo CSV File
            </a>
            <a href="{{ asset('/holiday') }}" class="btn btn-default pull-right" style="margin-top: 3px; margin-right: 20px">
                <i class="fa fa-plus"></i>
                Holiday List
            </a>
            <div class="caption">
                <i class="fa fa-bullhorn"></i>
                <span class="caption-subject bold uppercase">Holidays Csv Import </span>
            </div>
            <div class="tools"> </div>
        </div>
        <div class="portlet-body">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('csv.import') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="csv_file">Choose CSV File:</label>
                                <input type="file" class="form-control-file" id="csv_file" name="csv_file" accept=".csv">
                            </div>
                            <button type="submit" class="btn btn-primary">Import CSV</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        </div>

@endsection