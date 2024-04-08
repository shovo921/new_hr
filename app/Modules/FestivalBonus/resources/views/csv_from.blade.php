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
                <span>Festival Bonus CSV Import</span>
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
                <span class="caption-subject bold uppercase">Festival Bonus Csv Import </span>
            </div>
            <div class="tools"> </div>
        </div>
        <div class="portlet-body">
            <div class="col-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">

                    {!! Form::model($FestivalBonus, array('route' => 'bonus.csv.import', 'method' => 'Post', 'role' => 'form', 'class' => 'form-horizontal','enctype' => 'multipart/form-data')) !!}

                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Choose CSV File<span class="required">*</span></label>
                            <div class="col-md-8">
                                {!! Form::file('csv_file', $value = null, array('id'=>'csv_file', 'class' => 'form-control ', 'required'=>"")) !!}
                                @if($errors->has('csv_file'))<span class="required">{{ $errors->first('csv_file') }}</span>@endif


                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">BONUS TYPE<span class="required">*</span></label>
                            <div class="col-md-8">

                                {!! Form::select('bonus_type',$data['bonus_type'], $value = null, array('id'=>'bonus_type', 'class' => 'form-control select2', 'required'=>"")) !!}
                                @if($errors->has('bonus_type'))<span class="required">{{ $errors->first('bonus_type') }}</span>@endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">PAY TYPE<span class="required">*</span></label>
                            <div class="col-md-8">
                                {!! Form::select('pay_type',$data['pay_type'], $value = null, array('id'=>'pay_type', 'class' => 'form-control select2', 'required'=>"")) !!}
                                @if($errors->has('pay_type'))<span class="required">{{ $errors->first('pay_type') }}</span>@endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-8">
                                {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
                                <a href="{{  url('/FestivalBonus') }}" class="btn btn-success">Back</a>
                            </div>

                        </div>

                    {!! Form::close() !!}

{{--                    <div class="card-body">--}}
{{--                        <form action="{{ route('csv.import') }}" method="post" enctype="multipart/form-data">--}}
{{--                            @csrf--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="csv_file">Choose CSV File:</label>--}}
{{--                                <input type="file" class="form-control-file" id="csv_file" name="csv_file" accept=".csv">--}}
{{--                            </div>--}}
{{--                            --}}
{{--                            <button type="submit" class="btn btn-primary">Import CSV</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>

        </div>

@endsection