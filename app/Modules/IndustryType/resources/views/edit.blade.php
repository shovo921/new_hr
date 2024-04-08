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
			<span>Industry Type List</span>
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
	<div class="page-title">Industry Type Edit</div>
	<div class="col-md-8 col-md-offset-1">
		{!! Form::model($industry_type, array('url' => 'industry-type/'.$industry_type->id, 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) !!}

		@include('IndustryType::_from')

		{!! Form::close() !!}
	</div>
</div>

@endsection