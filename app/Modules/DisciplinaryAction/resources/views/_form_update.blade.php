<div class="form-body">

    <div class="form-group">
        <label class="col-md-4 control-label">Employee Name<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('employee_id', $value = $disciplinaryAction->employee_id.' - '.$disciplinaryAction->employee->name, array('id'=>'employee_id', 'readonly'=>'readonly', 'class' => 'form-control')) !!}
            @if($errors->has('employee_id'))<span class="required">{{ $errors->first('employee_id') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Disciplinary Type<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('dis_cat_id', $disciplinaryCategory, $value =  $disciplinaryAction->dis_cat_id, array('id'=>'dis_cat_id', 'class' => 'form-control', 'required'=>"",'placeholder'=>'Select Action Type')) !!}
            @if($errors->has('dis_cat_id'))<span class="required">{{ $errors->first('dis_cat_id') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Action Start Date</label>
        <div class="col-md-8">
            <?php
            use Carbon\Carbon;
            $action_start_date = null;

            if(@$disciplinaryAction->action_start_date != '') {
                $action_start_date = date('d/m/Y', strtotime($disciplinaryAction->action_start_date));
//				$action_start_date = Carbon::parse($disciplinaryAction->action_start_date)->isoFormat('d-mm-YYYY');

            }
            ?>
            {!! Form::text('action_start_date', $value = $action_start_date, array('id'=>'action_start_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Action End Date</label>
        <div class="col-md-8">
            <?php
            $action_end_date = null;

            if(@$disciplinaryAction->action_end_date != '') {
                $action_end_date = date('d/m/Y', strtotime($disciplinaryAction->action_end_date));
                //$action_end_date = date('d-m-Y');
            }
            ?>
            {!! Form::text('action_end_date', $value = $action_end_date, array('id'=>'action_end_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Action Details<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::textarea('action_details', $value = $disciplinaryAction->action_details, array('id'=>'action_details', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('action_details'))<span class="required">{{ $errors->first('action_details') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('status', $status, $value = $disciplinaryAction->status, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('status'))<span class="required">{{ $errors->first('status') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Action Type</label>
        <div class="col-md-8">
            {!! Form::select('action_type', $type, $value = $disciplinaryAction->action_type, array('id'=>'action_type', 'class' => 'form-control','onchange'=>"getDisciplinaryPunishments(this.value)")) !!}

        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Final Action Taken</label>
        <div class="col-md-8">
            {!! Form::select('action_taken_id', $final_action_type_list, $value = $disciplinaryAction->action_taken_id, array('id'=>'action_taken_id', 'class' => 'form-control')) !!}

        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Start Date</label>
        <div class="col-md-8">
            <?php
            $start_date = null;

            if(@$disciplinaryAction->start_date != '') {
                $start_date = date('d/m/Y ', strtotime($disciplinaryAction->start_date));
                //$action_start_date = Carbon::parse($disciplinaryAction->action_start_date)->isoFormat('d-mm-YYYY');

            }
            ?>
            {!! Form::text('start_date', $value = $start_date, array('id'=>'start_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">End Date</label>
        <div class="col-md-8">
            <?php
            $end_date = null;

            if(@$disciplinaryAction->end_date != '') {
                $end_date = date('d/m/Y ', strtotime($disciplinaryAction->end_date));

            }
            ?>
            {!! Form::text('end_date', $value = $end_date, array('id'=>'end_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Remarks</label>
        <div class="col-md-8">
            {!! Form::text('remarks', $value = $disciplinaryAction->remarks, array('id'=>'remarks', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('remarks'))<span class="required">{{ $errors->first('remarks') }}</span>@endif
        </div>
    </div>


    {{--  Attachment--}}

    {{--	<div class="container">--}}
    {{--		<div class="row">--}}
    {{--			<div class="col-lg-12">--}}
    {{--				<div class="card">--}}
    {{--					<div class="card-header">--}}
    {{--					</div>--}}
    {{--					<div class="card-body card-block">--}}
    {{--						<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">--}}

    {{--							<div class="row form-group">--}}
    {{--								<div class="col-12 col-md-12">--}}
    {{--									<div class="control-group" id="fields">--}}
    {{--										<label class="control-label" for="field1">--}}
    {{--											Attachment--}}
    {{--										</label>--}}
    {{--										<div class="controls">--}}
    {{--											<div class="entry input-group upload-input-group">--}}
    {{--												<input class="form-control" name="fields[]" type="file">--}}
    {{--												<button class="btn btn-upload btn-success btn-add" type="button">--}}
    {{--													<i class="fa fa-plus"></i>--}}
    {{--												</button>--}}
    {{--											</div>--}}

    {{--										</div>--}}
    {{--										<button class="btn btn-primary">Upload</button>--}}

    {{--									</div>--}}


    {{--								</div>--}}

    {{--							</div>--}}

    {{--						</form>--}}
    {{--					</div>--}}
    {{--				</div>--}}
    {{--			</div>--}}
    {{--		</div>--}}
    {{--	</div>--}}


    {{--  Attachment End--}}


    {{--		<div class="form-group">--}}
    {{--			<label class="col-md-4 control-label">Attachment</label>--}}
    {{--			<div class="col-md-8">--}}
    {{--				<input class="form-control" type="file" name="name" multiple><br><br>--}}
    {{--				{!! Form::file('file', $value = null, array('id'=>'file','multiple'=>'multiple', 'class' => 'form-control')) !!}--}}
    {{--			</div>--}}
    {{--		</div>--}}

    <div class="form-group">
        <label class="col-md-4 control-label" >Old Attachment</label>
        <div class="col-md-8">
            <table class="col-md-8">
                <tr>
                </tr>

                @foreach($disciplinaryActionAttachment as $disciplinaryAttachment)
                <tr>
                    @if(!empty($disciplinaryAttachment->attachment))
                        <td> {{$disciplinaryAttachment->attachment}} <a href="{{ asset('uploads/employeedata/'. $disciplinaryAction->employee_id . '/disciplinaryaction/'.$disciplinaryAction->id .'/'.$disciplinaryAttachment->attachment) }}" target="_blank"><i class="fa fa-eye"></i></a></td>
                    @endif
                </tr>
                @endforeach
            </table>
        </div>
    </div>



    <div class="form-group">
        <label class="col-md-4 control-label"> New Attachment</label>
        <div class="col-md-8">
            <input type="file" class="course form-control" name="images[]" multiple>
            {{--			{!! Form::file('file', $value = null, array('id'=>'file', 'class' => 'form-control')) !!}--}}
        </div>
    </div>

    {{--	<div class="form-group">--}}
    {{--		<label class="col-md-4 control-label">Attachment</label>--}}
    {{--		<div class="input-group xpress control-group lst increment">--}}
    {{--			<input class="myfrm form-control" type="file" name="filenames[]"><br>--}}
    {{--			<div class="input-group-btn">--}}
    {{--				<button class="btn btn-success" type="button">Add</button>--}}
    {{--		    </div>--}}
    {{--			<div class="çlone d-none" >--}}
    {{--				<div class="xpress control-group lst input-group">--}}
    {{--					<input class="myfrm form-control" type="file" name="filenames[]" ><br>--}}
    {{--					<div class="input-group-btn">--}}
    {{--						<button class="btn btn-danger" type="button">Remove</button>--}}
    {{--					</div>--}}
    {{--			</div>--}}
    {{--		</div>--}}
    {{--	</div>--}}

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
            <a href="{{  url('/disciplinaryActionHistory/'. $disciplinaryAction->employee_id) }}" class="btn btn-success">Back</a>
        </div>
    </div>


</div>



