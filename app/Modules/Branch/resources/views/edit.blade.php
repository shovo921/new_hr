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
			<span>Branch List</span>
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
	<div class="page-title">Branch Edit</div>
	<div class="col-md-8 col-md-offset-1">
		{!! Form::model($branch, array('url' => 'branch/'.$branch->id, 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) !!}

		@include('Branch::_from_edit')

		{!! Form::close() !!}
	</div>
</div>

@endsection

@section('script')
	<script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/my_scripts/custom.js') }}" type="text/javascript"></script>

@stop
