<h3 class="block">{{$employee->name}}'s Academic Education Information <br>
    <h4 class="block">Employee ID:{{$employee->employee_id}} <br>
        File NO:{{$employeeDetails->personal_file_no}}</h4>
<?php
$otheremployeeID = null;
if (@$employee->employee_id)
    $otheremployeeID = $employee->employee_id;
?>
{!! Form::hidden('other_employee_id', $value = $otheremployeeID, array('id'=>'other_employee_id', 'class' => 'form-control')) !!}
<div class="row">
    <?php $eduRequiredStatus = 'required=""'; ?>
    @if(count($employeeEducations) > 0)
        <table class="table">
            <thead>
            <tr>
                <th>Level</th>
                <th>Exam</th>
                <th>Group/ Subject</th>
                <th>Institute Type</th>
                <th>Board/ Institute</th>
                <th>Passing Year</th>
                <th>Result Type</th>
                <th>Result</th>
                <th>OUT OF</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($employeeEducations as $employeeEducation)
                <?php $eduRequiredStatus = ''; ?>
                <tr>
                    <td> {{ @$employeeEducation->eduLevel->name }} </td>
                    <td> {{ @$employeeEducation->eduExam->examination }} </td>
                    <td>
                        {{$employeeEducation->group->group_subject_major ?? '' }}
                    </td>
                    <td> {{ $employeeEducation->institute_type }} </td>
                    <td>
                        @if($employeeEducation->board_university)
                            {{ $employeeEducation->board->board_university_institute }}
                        @endif
                        {{-- $employeeEducation->board_university --}}
                    </td>
                    <td> {{ $employeeEducation->passing_year }} </td>
                    <td> {{ $employeeEducation->result_type }} </td>
                    <td> {{ $employeeEducation->result }} </td>
                    <td> {{ $employeeEducation->out_of }} </td>
                    <td>
                        <a href="javascript:;" onclick="educationInfoModal('{{ $employeeEducation->id }}')"><i
                                    class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="{{ url('/deleteEducationInfo/'.$employeeEducation->id) }}" style="color: red"
                           onclick="return confirm('Are you sure?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th width="5%"></th>
            <th width="10%">Level<span class="required">*</span></th>
            <th width="10%">Exam<span class="required">*</span></th>
            <th width="15%">Group/ Subject/ Major<span class="required">*</span></th>
            <th width="8%">Institute Type<span class="required">*</span></th>
            <th width="15%">Board/ University/ Institute<span class="required">*</span></th>
            <th width="8%">Passing Year<span class="required">*</span></th>
            <th width="8%">Result Type<span class="required">*</span></th>
            <th width="8%">Result<span class="required">*</span></th>
            <th width="5%">OUT OF</th>
        </tr>
        </thead>
    </table>

    <table class="table" id="educationInfo" class="educationInfo">
        <tr>
            <th width="2%"><input type="checkbox"/></th>
            <td width="10%">
                {!! Form::select('emp_edu_level[]', $educationLevels, $value = null, array('id'=>'emp_edu_level', 'class' => 'form-control', $eduRequiredStatus)) !!}
            </td>
            <td width="10%">
                {!! Form::select('exam[]', $educationExams, $value = null, array('id'=>'exam', 'class' => 'form-control', $eduRequiredStatus)) !!}
            </td>
            <td width="15%">
                {!! Form::select('group_subject[]', $educationSubjects, $value = null, array('id'=>'group_subject', 'class' => 'form-control', 'data-live-search' =>'true', $eduRequiredStatus)) !!}
            </td>
            <td width="8%">
                {!! Form::select('institute_type[]', $instituteType, $value = null, array('id'=>'institute_type', 'class' => 'form-control', 'data-live-search' =>'true',)) !!}
            </td>
            <td width="15%">
                {!! Form::select('board_university[]', $educationInstitutes, $value = null, array('id'=>'board_university', 'class' => 'form-control', 'data-live-search' =>'true', $eduRequiredStatus)) !!}
            </td>
            <td width="8%">
                {!! Form::text('passing_year[]', $value = null, array('id'=>'passing_year', 'class' => 'form-control', $eduRequiredStatus)) !!}
            </td>
            <td width="8%">
                {!! Form::select('result_type[]', [""=>"--Please Select--"]+$result_type, $value = null, array('id'=>'result_type', 'class' => 'form-control', $eduRequiredStatus)) !!}
            </td>
            <td width="8%">
                {!! Form::number('result[]', $value = null, array('id'=>'result', 'class' => 'form-control', $eduRequiredStatus)) !!}
            </td>
            <td width="5%">
                {!! Form::text('out_of[]', $value = null, array('id'=>'out_of', 'class' => 'form-control')) !!}
            </td>
        </tr>
    </table>
    <div class="actionBar">
        <a onclick="tableAddRow('educationInfo')" class="btn pull-right"><i class="fa fa-plus-square fa-2x"
                                                                            aria-hidden="true"></i></a>
        <a onclick="tableDeleteRow('educationInfo')" class="btn pull-right"><i class="fa fa-minus-square fa-2x"
                                                                               aria-hidden="true"
                                                                               style="color: red"></i></a>
    </div>
</div>

<h3 class="block">Professional Degree/Diploma Information</h3>

<div class="row">
    @if(count($employeeProfessionalDegrees) > 0)
        <table class="table">
            <thead>
            <tr>
                <th width="10%">Institute Name</th>
                <th width="10%">Course/Subject</th>
                <th width="10%">Start Date</th>
                <th width="10%">End Date</th>
                <th width="10%">Passed Date</th>
                <th width="10%">Result</th>
                <th width="10%">Location</th>
                <th width="10%">Action</th>
            </tr>
            </thead>
            <?php $traRequiredStatus = 'required=""'; ?>
            @foreach($employeeProfessionalDegrees as $employeeProfessionalDegree)
                <?php $traRequiredStatus = ''; ?>
                <tr>
                    <td width="10%"> {{ $employeeProfessionalDegree->profInstitue->institute_name }} </td>
                    <td width="10%"> {{ $employeeProfessionalDegree->course }} </td>
                    <td width="10%"> {{ $employeeProfessionalDegree->course_start_date }} </td>
                    <td width="10%"> {{ $employeeProfessionalDegree->course_end_date }} </td>
                    <td width="10%"> {{ $employeeProfessionalDegree->course_passed_date }} </td>
                    <td width="10%"> {{ $employeeProfessionalDegree->course_result }} </td>
                    <td width="10%"> {{ $employeeProfessionalDegree->course_location }} </td>
                    <td width="10%">
                        <a href="javascript:;" onclick="profDegreeModal('{{ $employeeProfessionalDegree->id }}')"><i
                                    class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="{{ url('/deleteProfEducationInfo/'.$employeeProfessionalDegree->id) }}"
                           style="color: red" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"
                                                                                            aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th width="3%"></th>
            <th width="10%">Institute Name</th>
            <th width="10%">Course/Subject</th>
            <th width="10%">Start Date</th>
            <th width="10%">End Date</th>
            <th width="10%">Passed Date</th>
            <th width="10%">Result</th>
            <th width="10%">Location</th>
            <th width="10%">Remarks</th>
        </tr>
        </thead>
    </table>
    <table class="table" id="professionDegreeInfo">
        <tr>
            <th width="1%"><input type="checkbox"/></th>
            <td width="10%">
            {!! Form::select('institute_name[]', $professionalInstitue/*+["Add New"=>"Add New"]*/, $value = null, array('id'=>'institute_name', 'class' => 'form-control')) !!}

                {{--  <a onclick="tableAddRow('educationInfo')" class="btn pull-right"><i c lass="fa fa-plus-square fa-2x" aria-hidden="true"></i></a>
            <td width="2%">

            </td>--}}
            </td>
            <td width="10%">
                {!! Form::text('course[]', $value = null, array('id'=>'course', 'class' => 'form-control')) !!}
            </td>
            <td width="10%">
                {!! Form::text('course_start_date[]', $value = null, array('id'=>'course_start_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
            </td>
            <td width="10%">
                {!! Form::text('course_end_date[]', $value = null, array('id'=>'course_end_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
            </td>
            <td width="10%">
                {!! Form::text('course_passed_date[]', $value = null, array('id'=>'course_passed_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
            </td>
            <td width="10%">
                {!! Form::text('course_result[]', $value = null, array('id'=>'course_result', 'class' => 'form-control')) !!}
            </td>
            <td width="10%">
                {!! Form::select('course_location[]', [""=>"--Please Select--"]+$location, $value = null, array('id'=>'course_location', 'class' => 'form-control')) !!}
            </td>
            <td width="10%">
                {!! Form::text('course_remarks[]', $value = null, array('id'=>'course_remarks', 'class' => 'form-control')) !!}
            </td>
        </tr>
    </table>
    <div class="actionBar">
        <a onclick="tableAddRow('professionDegreeInfo')" class="btn pull-right"><i class="fa fa-plus-square fa-2x"
                                                                                   aria-hidden="true"></i></a>
        <a onclick="tableDeleteRow('professionDegreeInfo')" class="btn pull-right"><i class="fa fa-minus-square fa-2x"
                                                                                      aria-hidden="true"
                                                                                      style="color: red"></i></a>
    </div>
</div>

<h3 class="block">Professional Training Information</h3>

<div class="row">
    @if(count($employeeTrainings) > 0)
        <table class="table">
            <thead>
            <tr>
                <th width="10%">Organization Name</th>
                <th width="10%">Subject</th>
                <th width="10%">Start Date</th>
                <th width="10%">End Date</th>
                <th width="10%">Passed Date</th>
                <th width="10%">Training Type</th>
                <th width="10%">Venue</th>
                <th width="10%">Action</th>
            </tr>
            </thead>
            <?php $traRequiredStatus = 'required=""'; ?>
            @foreach($employeeTrainings as $employeeTraining)
                <?php $traRequiredStatus = ''; ?>
                <tr>
                    <td width="10%"> {{ @$employeeTraining->orgName->organization_name }} </td>
                    <td width="10%"> {{ @$employeeTraining->subjectName->subject_name }} </td>
                    <td width="10%"> {{ $employeeTraining->start_date }} </td>
                    <td width="10%"> {{ $employeeTraining->end_date }} </td>
                    <td width="10%"> {{ $employeeTraining->passed_date }} </td>
                    <td width="10%"> {{ $employeeTraining->traning_type }} </td>
                    <td width="10%"> {{ $employeeTraining->venue }} </td>
                    <td width="10%">
                        <a href="javascript:;" onclick="profTrainingModal('{{ $employeeTraining->id }}')"><i
                                    class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="{{ url('/deleteProfTrainingInfo/'.$employeeTraining->id) }}" style="color: red"
                           onclick="return confirm('Are you sure?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th width="5%"></th>
            <th width="10%">Organization Name</th>
            <th width="10%">Subject</th>
            <th width="10%">Start Date</th>
            <th width="10%">End Date</th>
            <th width="10%">Passed Date</th>
            <th width="10%">Training Type</th>
            <th width="10%">Venue / Location</th>
            <th width="10%">Remarks</th>
        </tr>
        </thead>
    </table>
    <table class="table" id="trainingInfo">
        <tr>
            <th width="2%"><input type="checkbox"/></th>
            <td width="10%">
                {!! Form::select('org_name[]', $trainingOrganization, $value = null, array('id'=>'org_name', 'class' => 'form-control')) !!}
            </td>
            <td width="10%">
                {!! Form::select('subject[]', $trainingSubject, $value = null, array('id'=>'subject', 'class' => 'form-control')) !!}
            </td>
            <td width="10%">
                {!! Form::text('start_date[]', $value = null, array('id'=>'start_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
            </td>
            <td width="10%">
                {!! Form::text('end_date[]', $value = null, array('id'=>'end_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
            </td>
            <td width="10%">
                {!! Form::text('passed_date[]', $value = null, array('id'=>'passed_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
            </td>
            <td width="10%">
                {!! Form::select('traning_type[]', [""=>"--Please Select--"]+$training_type, $value = null, array('id'=>'traning_type', 'class' => 'form-control')) !!}
            </td>
            <td width="10%">
                {!! Form::text('venue[]', $value = null, array('id'=>'venue', 'class' => 'form-control')) !!}
            </td>
            <td width="10%">
                {!! Form::text('remarks[]', $value = null, array('id'=>'remarks', 'class' => 'form-control')) !!}
            </td>
        </tr>
    </table>
    <div class="actionBar">
        <a onclick="tableAddRow('trainingInfo')" class="btn pull-right"><i class="fa fa-plus-square fa-2x"
                                                                           aria-hidden="true"></i></a>
        <a onclick="tableDeleteRow('trainingInfo')" class="btn pull-right"><i class="fa fa-minus-square fa-2x"
                                                                              aria-hidden="true" style="color: red"></i></a>
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button type="button" class="btn btn-success" onclick="updateOtherUserInfo()">Update</button>
        <a class="btn btn-primary" href="{{url('/employee') }}"> Cancel</a>
    </div>
</div>


{{--@section('script')
    <script>

    </script>
@endsection--}}
