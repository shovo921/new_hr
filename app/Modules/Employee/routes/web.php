<?php
Route::group(['middleware'=>['web','auth']],function(){

    Route::get('getEmpDoc', 'EmployeeController@getEmpdoc');
    Route::get('downloadEmpDoc', 'EmployeeController@ExportEmployee');
    Route::resource('employee', 'EmployeeController');

	Route::post('getUpdatedEmployeeID', 'EmployeeController@getUpdatedEmployeeID');
	Route::post('getEmployeeFileNumber', 'EmployeeController@getEmployeeFileNumber');
	Route::post('getEmployeeInfo', 'EmployeeController@getEmployeeInfo');


	Route::post('createEmployee', 'EmployeeController@storeEmployee');

	Route::post('updateUserBasicInfo', 'EmployeeController@updateUserBasicInfo');

	Route::post('updateEmployee', 'EmployeeController@updateEmployee');
	Route::post('updateEmployeeOtherInfo', 'EmployeeController@updateEmployeeOtherInfo');
	Route::post('updateEmployeeSkillInfo', 'EmployeeController@updateEmployeeSkillInfo');
	Route::post('updateEmployeeTransferInfo', 'EmployeeController@updateEmployeeTransferInfo');
	Route::post('updateEmployeeExperienceInfo', 'EmployeeController@updateEmployeeExperienceInfo');

	Route::post('file-upload', 'EmployeeController@fileUploadPost')->name('file.upload.post');

	Route::get('deleteFile/{employee_id}/{doc_type_id}', 'EmployeeController@deleteFile');

	Route::get('employeeSalary/{employee_id}/', 'EmployeeController@employeeSalary');


	Route::get('educationEdit/', 'EmployeeController@employeeEducationEdit');
	Route::put('employeeEducationUpdate/{id}/', 'EmployeeController@employeeEducationUpdate');
	Route::get('deleteEducationInfo/{id}/', 'EmployeeController@deleteEducationInfo');

    Route::get('profInstituteNameAdd/', 'EmployeeController@employeeProfDegreeDiplomaAdd');
    Route::put('profInstituteNameStore/', 'EmployeeController@employeeProfDegreeDiplomaStore');

	Route::get('profDegreeEdit/', 'EmployeeController@employeeProfEducationEdit');
	Route::put('employeeProfEducationUpdate/{id}/', 'EmployeeController@employeeProfEducationUpdate');
	Route::get('deleteProfEducationInfo/{id}/', 'EmployeeController@deleteProfEducationInfo');

	Route::get('profTrainingEdit/', 'EmployeeController@profTrainingEdit');
	Route::put('profTrainingUpdate/{id}/', 'EmployeeController@profTrainingUpdate');
	Route::get('deleteProfTrainingInfo/{id}/', 'EmployeeController@deleteProfTrainingInfo');

	Route::get('childrenInfoEdit/', 'EmployeeController@childrenInfoEdit');
	Route::put('childrenInfoUpdate/{id}/', 'EmployeeController@childrenInfoUpdate');
	Route::get('deleteChildrenInfo/{id}/', 'EmployeeController@deleteChildrenInfo');

	Route::get('referenceInfoEdit/', 'EmployeeController@referenceInfoEdit');
	Route::put('referenceInfoUpdate/{id}/', 'EmployeeController@referenceInfoUpdate');
	Route::get('deleteReferenceInfo/{id}/', 'EmployeeController@deleteReferenceInfo');

	Route::get('nomineeInfoEdit/', 'EmployeeController@nomineeInfoEdit');
	Route::put('nomineeInfoUpdate/{id}/', 'EmployeeController@nomineeInfoUpdate');
	Route::get('deleteNomineeInfo/{id}/', 'EmployeeController@deleteNomineeInfo');
	
	Route::get('projectEdit/', 'EmployeeController@projectEdit');
	Route::put('projectUpdate/{id}/', 'EmployeeController@projectUpdate');
	Route::get('deleteProject/{id}/', 'EmployeeController@deleteProject');

	Route::get('specializationEdit/', 'EmployeeController@specializationEdit');
	Route::put('specializationUpdate/{id}/', 'EmployeeController@specializationUpdate');
	Route::get('deleteSpecialization/{id}/', 'EmployeeController@deleteSpecialization');

	Route::get('experienceEdit/', 'EmployeeController@experienceEdit');
	Route::put('experienceUpdate/{id}/', 'EmployeeController@experienceUpdate');
	Route::get('deleteExperience/{id}/', 'EmployeeController@deleteExperience');

	Route::get('incrementStructure', 'EmployeeController@incrementStructure');
	Route::post('getEmployeeSalarySlaveInfo', 'EmployeeController@getEmployeeSalarySlaveInfo');

	Route::get('employeePromotion/{employee_id}/', 'EmployeePromotionController@employeePromotion');

	Route::get('employeeTransfer', 'EmployeePostingController@employeeTransfer');
	Route::get('posting-edit/{postingId}', 'EmployeePostingController@employeeCurrentTransferView');
	Route::put('posting-edit/{postingId}', 'EmployeePostingController@employeeCurrentTransferEdit');
	Route::post('storeEmployeeTransfer', 'EmployeePostingController@storeEmployeeTransfer');
	Route::get('postingAuthorization', 'EmployeePostingController@postingAuthorization');

    Route::get('getBranchEmployeesByEmp', 'EmployeePostingController@getCurrentEmployeesByEmployeeId');
    Route::get('getCurrentBranchEmployees', 'EmployeePostingController@getCurrentBranchEmployees');
    Route::get('transferTransit/{id},{isEdit}', 'EmployeePostingController@transferTransit');
    Route::put('transferTransitUpdate', 'EmployeePostingController@transferTransitUpdate');
    Route::put('transferTransitAction', 'EmployeePostingController@transferTransitAction');
    Route::get('transferTransitView', 'EmployeePostingController@transferTransitView');

	Route::get('postinglist', 'EmployeePostingController@empPostingInfo');
	Route::get('brdivhead', 'EmployeePostingController@brDivHeadInfo');
	Route::get('viewPosting/{employee_id}/', 'EmployeePostingController@viewCurrentPosting');
	Route::get('viewPostingHistory/{employee_id}/', 'EmployeePostingController@viewPostingHistory');
	Route::get('authorizedPosting/{employee_id}/', 'EmployeePostingController@authorizedPosting');
	Route::get('postingHistory/{employee_id}/', 'EmployeePostingController@postingHistory');
	Route::get('cancelPosting/{employee_id}/', 'EmployeePostingController@cancelPosting');

    //EMPLOYMENT_LOG employment_log
    Route::get('employment-log', 'EmploymentLogController@employment_log');



    //    Division Head Edit
    Route::get('editPosting/{id}/', 'EmployeePostingController@editBrHeadPosting');
    Route::put('updatePosting/{id}/', 'EmployeePostingController@updateBrHeadPosting');

    Route::get('createBrdivhead', 'EmployeePostingController@createBrDivHead');
    Route::post('createBrdivhead', 'EmployeePostingController@storeBrDivHead');

	Route::get('oracle-test', function () {
    	$id = DB::connection('payslip')->table('employee_details')->first();
    	echo '<pre color="red"> sdf dsf => ';
    	print_r($id);
    	echo '</pre>';
    	exit();
	});

   /* Route::get('payslip-insert', function () {
        $conn = oci_connect("hrm_16", "hrm_16", "192.168.200.29:1528/orcl1");
        $sql = "INSERT INTO SALARYPAY_SLIP (EMP_ID,PTYPE_ID,AMOUNT,STATUS,STATUS1)".
            "select '20220306001' ,1 ,'21250', 'Y' ,'A'  from Dual";
        $compiled = oci_parse($conn, $sql);
        echo('successfully executed');
        oci_execute($compiled);
        exit();
    });*/

    Route::get('oracle-test1', function () {
        //$conn = oci_connect("hrm_16", "hrm_16", "192.168.200.29:1528/orcl1");
        //$conn = oci_connect('PAD_HRMS', 'padhrms', '172.31.10.129:1599/hrmdb');
        $conn = oci_connect('PAD_HRMS', 'PAD_HRMS', '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.200.135)(PORT = 1521)) (CONNECT_DATA =(SID = twodb)))');
        //$conn = oci_connect('PAD_HRMS', 'padhrms', '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.31.10.129)(PORT = 1599)) (CONNECT_DATA =(SID = ORCL)))');
        //$conn = oci_connect('PAD_HRMS', 'PAD_HRMS', '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.200.135)(PORT = 1521)) (CONNECT_DATA =(SID = twodb)))');
        //$conn = oci_connect("PAD_HRMS", "PAD_HRMS", "192.168.200.135:1521/twodb");
        //$stdi = oci_parse($conn, "SELECT * FROM SALARYPAY_SLIP where EMP_ID ='20181220001'");

        /*$stdi = oci_parse($conn, "declare
                 PDT_FROM NVARCHAR2(4000) := '17-Oct-2022';
                 begin
                 PAD_HRMS.SP_EMPLOYEE_FINAL_ATTENDANCE_CHECK(PDT_FROM => PDT_FROM);
                 end;");
        oci_execute($stdi);*/
        //echo "success";

        $stdi = oci_parse($conn, "SELECT * FROM V_ALL where EMPLOYEE_ID ='20211226001'");
        oci_execute($stdi);

        echo "<table border='1'>\n";
        while ($row = oci_fetch_array($stdi, OCI_ASSOC+OCI_RETURN_NULLS)) {
            echo "<tr>\n";
            dd($row);
            foreach ($row as $item) {
                echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
        exit();
    });
});



