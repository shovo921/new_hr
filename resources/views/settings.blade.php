@extends('layouts.app')

@section('content')
<!--<div class="row heading-bg">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h5 class="txt-dark">System Users</h5>
    </div>
     Breadcrumb 
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#"><span>speciality pages</span></a></li>
            <li class="active"><span>blank page</span></li>
        </ol>
    </div>
     /Breadcrumb 
</div>-->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Settings</h6>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap">
                        {{Form::open(['route'=>'settings.store','method'=>'post','class'=>'form-horizontal','files'=>true])}}

                        <div class="form-group">
                            <label class="col-sm-3 control-label " for="example-input-normal">Weekly Off Day</label>
                            <div class="col-sm-6">
                                {{Form::select('off_day',allDays(),$settings['off_day'] ?? null,['class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label " for="example-input-normal">Service Charge (%)</label>
                            <div class="col-sm-6">
                                {{Form::text('service_charge',$settings['service_charge'] ?? null,['class'=>'form-control','min'=>'0'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label " for="example-input-normal">Upload Map</label>
                            <div class="col-sm-6">
                                {{Form::file('map',['class'=>'form-control'])}}
                            </div>
                            @if(isset($settings['map']))
                            @if(!is_null($settings['map']))
                            <div class="col-sm-2">
                                <a href="{{url($settings['map'])}}" target="new" class="btn btn-info">View Map</a>
                            </div>
                            @endif
                            @endif
                        </div>
                        <div class="form-group mb-0"> 
                            <div class="col-md-offset-6 col-md-6">
                                <button type="submit" class="btn btn-success btn-anim"><i class="icon-rocket"></i><span class="btn-text">submit</span></button>
                            </div>
                        </div>

                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>

    $(document).ready(function () {
        highlight_nav('settings', 'settings');

    });

</script>
@endpush

