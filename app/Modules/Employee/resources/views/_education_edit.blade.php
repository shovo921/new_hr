<div class="form-body">
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10">Level : <span style="color:red">*</span></label>
        {!! Form::select('emp_edu_level', $educationLevels, $value = null, array('id'=>'emp_edu_level', 'class' => 'form-control', 'required=""')) !!}
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10">Exam : <span style="color:red">*</span></label>
        {!! Form::select('exam', $educationExams, $value = null, array('id'=>'exam', 'class' => 'form-control', 'required=""')) !!}
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10">Group/ Subject/ Major : <span style="color:red">*</span></label>
        {!! Form::select('group_subject', $educationSubjects, $value = null, array('id'=>'group_subject', 'class' => 'form-control', 'data-live-search' =>'true', 'required=""')) !!}
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10">Institute Type : </label>
        {!! Form::select('institute_type', $instituteType, $value = null, array('id'=>'institute_type', 'class' => 'form-control', 'data-live-search' =>'true', 'required=""')) !!}
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10">Board/ University/ Institute : </label>
        {!! Form::select('board_university', $educationInstitutes, $value = null, array('id'=>'board_university', 'class' => 'form-control', 'data-live-search' =>'true', 'required=""')) !!}
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10">Passing Year : </label>
        {!! Form::text('passing_year', $value = null, array('id'=>'passing_year', 'class' => 'form-control', 'required=""')) !!}
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10">Result Type : </label>
        {!! Form::select('result_type', [""=>"--Please Select--"]+$result_type, $value = null, array('id'=>'result_type', 'class' => 'form-control', 'required=""')) !!}
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10">Result : </label>
        {!! Form::text('result', $value = null, array('id'=>'result', 'class' => 'form-control', 'required=""')) !!}
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10">OUT OF : </label>
        {!! Form::text('out_of', $value = null, array('id'=>'out_of', 'class' => 'form-control')) !!}
    </div>
    <div class="form-group col-md-offset-4">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Back</button>
    </div>
</div> 

