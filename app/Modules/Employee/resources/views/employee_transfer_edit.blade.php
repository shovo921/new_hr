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
            <span>Employee Transfer/Posting</span>
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
<div class="row">
    <div class="page-title">Employee Transfer/Posting</div>

        <div class="col-md-8 col-md-offset-1">
            {!! Form::model($empPostingInfo, array('url' => 'posting-edit/'.$empPostingInfo->id, 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) !!}

            @include('Employee::_transfer_from')

            {!! Form::close() !!}
        </div>

</div>

@endsection

@section('css')
<link href="{{ asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('script')
<script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/my_scripts/transfer.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy'
    });

    $(document).ready(function(){
        var checkboxes = $('.checkboxes');
        checkboxes.change(function(){
            if($('.checkboxes:checked').length>0) {
                checkboxes.removeAttr('required');
            } else {
                checkboxes.attr('required', 'required');
            }
        });
    });
</script>
@endsection