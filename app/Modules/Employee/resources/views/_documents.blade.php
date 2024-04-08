<h3 class="block">{{$employee->name}}'s Uploaded Documents <br>
	<h4>Employee ID:{{$employee->employee_id}} <br>
		File NO:{{$employeeDetails->personal_file_no}}</h4>

<table class="table">
	<thead>
		<tr>
			<th>Document Name</th>
			<th>Document</th>
			<th>Receive Date</th>
			<th>Remarks</th>
			<th>Actions</th>
		</tr>
	</thead>
	@foreach($employeeDocuments as $employeeDocument)
	<tr>
		<td>{{ $employeeDocument->document->document_type ?? '' }}</td>
		<td>{{ $employeeDocument->attachment }}</td>
		<td>{{ $employeeDocument->received_date }}</td>
		<td>{{ $employeeDocument->remarks }}</td>
		<td><a href="{{ url('/deleteFile/'.$employeeDocument->employee_id.'/'.$employeeDocument->document_type_id) }}" onclick="return confirm('Are you sure?');"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
	</tr>
	@endforeach
</table>

<h3 class="block">Documents</h3>

<?php
$documentEmployeeID = null;
if(@$employee->employee_id)
	$documentEmployeeID = $employee->employee_id;
?>
{!! Form::hidden('document_employee_id', @$documentEmployeeID, array('id'=>'document_employee_id')) !!}

@foreach($documentList as $document)
	<?php
	$isRequired = "";
	$requiredStatus = "0";
	if($document->is_required == 'YES') {
		$requiredStatus = "1";
		$isRequired = "'required'=>''";
	}
	?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-4 control-label">
				{{ $document->document_type }}

				@if($requiredStatus == '1')
					<span class="required">*</span>
				@endif
			</label>
			<div class="col-md-8">
				{!! Form::file(str_replace(" ", "_",$document->document_type), $value = null, array('id'=>$document->document_type, 'class' => 'form-control', $isRequired)) !!}
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-4 control-label">Remarks</label>
			<div class="col-md-8">
				{!! Form::text("remarks_".$document->document_type, $value = null, array('id'=>"remarks_".$document->document_type, 'class' => 'form-control')) !!}
			</div>
		</div>
	</div>
</div>
@endforeach

<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button type="submit" class="btn btn-success">Upload</button>
        <a class="btn btn-primary" href="{{url('/employee') }}"> Cancel</a>
    </div>
</div>