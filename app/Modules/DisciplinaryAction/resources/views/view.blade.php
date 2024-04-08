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
			<span>Disciplinary Action</span>
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
	<div class="page-title">Disciplinary Action Details View</div>

	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-gift"></i>Disciplinary Action Information</div>
		</div>
		<div class="portlet-body">
			<table class="table">
				<tr>
					<th>Employee ID</th>
					<td>{{ $disciplinaryAction->employee_id }}</td>
				</tr>
				<tr>
					<th>Employee Name</th>
					<td>{{ $disciplinaryAction->employee->name }}</td>
				</tr>
				<tr>
					<th>Action Type</th>
					<td>{{ $disciplinaryAction->disciplinarycategory->name ?? '' }}</td>
				</tr>
				<tr>
					<th>Action Start Date</th>
					<td>
						<?php
						$action_start_date = null;

						if(@$disciplinaryAction->action_start_date != '') {
							echo date('d/m/Y' , strtotime($disciplinaryAction->action_start_date));
						}
						?>
					</td>
				</tr>
				<tr>
					<th>Action End Date</th>
					<td>
						<?php
						$action_end_date = null;

						if(@$disciplinaryAction->action_end_date != '') {
							echo date('d/m/Y', strtotime($disciplinaryAction->action_end_date));
						}
						?>
					</td>
				</tr>

				<tr>
					<th>Action Details</th>
					<td>{{ $disciplinaryAction->action_details }}</td>
				</tr>
				<tr>
					<th>Action Type</th>
					<td> 
						@if($disciplinaryAction->action_type == 1)
						{{ 'Minor' }}
						@elseif($disciplinaryAction->action_type == 2)
						{{ 'Major' }}
						@endif
					</td>
				</tr>

				<tr>
					<th>Action Taken</th>
					<td> {{$disciplinaryAction->disciplinaryPunishments->punishments}}
					</td>
				</tr>
				<tr>
					<th>Status</th>
					<td>
						@if($disciplinaryAction->status == 1)
							{{ 'Running' }}
						@elseif($disciplinaryAction->status == 2)
							{{ 'Closed' }}
						@endif
					</td>
				</tr>

				<tr>
					<th>Remarks</th>
					<td>{{$disciplinaryAction->remarks}}
					</td>
				</tr>
				<tr>
					<th>Start Date</th>
					<td>
						<?php
						$start_date = null;

						if(@$disciplinaryAction->start_date != '') {
							echo date('d/m/Y', strtotime($disciplinaryAction->start_date));
						}
						?>
					</td>
				</tr>
				<tr>
					<th>End Date</th>
					<td>
						<?php
						$end_date = null;

						if(@$disciplinaryAction->end_date != '') {
							echo date('d/m/Y', strtotime($disciplinaryAction->end_date));
						}
						?>
					</td>
				</tr>

			</table>
		</div>
	</div>
</div>
@stop