{{Form::model($profTraining,['url'=>['profTrainingUpdate',$profTraining->id],'method'=>'put', 'class' => 'form-horizontal'])}}

<div class="form-body">
    <div class="form-group">
        <label class="col-md-4 control-label">Organization Name<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('org_name', $trainingOrganization, $value = null, array('id'=>'org_name', 'class' => 'form-control', 'required'=>"")) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Subject<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('subject', $trainingSubject, $value = null, array('id'=>'subject', 'class' => 'form-control', 'required'=>"")) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Start Date<span class="required">*</span></label>
        <div class="col-md-8">
            <?php
            $course_start_date = null;
            $course_end_date = null;
            $course_passed_date = null;

            if (!empty($profTraining->start_date) || !empty($profTraining->end_date) || !empty($profTraining->passed_date)) {
                $course_start_date = date('d/m/Y', strtotime($profTraining->start_date));
                $course_end_date = date('d/m/Y', strtotime($profTraining->end_date));
                $course_passed_date = date('d/m/Y', strtotime($profTraining->passed_date));
            }
            ?>
            {!! Form::text('start_date', $value = $course_start_date, array('id'=>'start_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', )) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">End Date</label>
        <div class="col-md-8">
            {!! Form::text('end_date', $value = $course_end_date, array('id'=>'end_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', )) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Passed Date</label>
        <div class="col-md-8">
            {!! Form::text('passed_date', $value = $course_passed_date, array('id'=>'passed_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', )) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Training Type</label>
        <div class="col-md-8">
            {!! Form::select('traning_type', [""=>"--Please Select--"]+$training_type, $value = null, array('id'=>'traning_type', 'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Venue</label>
        <div class="col-md-8">
            {!! Form::text('venue', $value = null, array('id'=>'venue', 'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Remarks</label>
        <div class="col-md-8">
            {!! Form::text('remarks', $value = null, array('id'=>'remarks', 'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Update', array('class' => "btn btn-primary")) !!} &nbsp;
            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Back</button>
        </div>

    </div>
</div>

{{Form::close()}}