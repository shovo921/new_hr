<?php
/**
 * Purpose: This Controller Used for Employee Information Manage
 * Created: Jobayer Ahmed
 * Change history:
 * 08/02/2021 - Jobayer
 **/

namespace App\Modules\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\EmpInfoDoc;
use App\Modules\Employee\Models\Employee;
use App\Modules\EmployeeIncrement\Models\EmployeeSalaryTemp;
use App\Modules\EmployeePromotion\Models\EmployeePromotion;
use App\Modules\Leave\Models\EmployeeLeave;
use Illuminate\Http\Request;

use App\Http\Requests\StoreEmployeeRequest;

use App\User;

use App\Models\EducationLevel;
use App\Models\EducationExam;
use App\Models\EducationInstitute;
use App\Models\EducationSubject;
use App\Models\InstituteType;
use App\Modules\Division\Models\Division;
use App\Modules\District\Models\District;
use App\Modules\Thana\Models\Thana;
use App\Modules\Specialization\Models\Specialization;
use App\Modules\Designation\Models\Designation;
use App\Modules\Designation\Models\StaffType;
use App\Modules\JobStatus\Models\JobStatus;
use App\Modules\TransferType\Models\TransferType;
use App\Modules\Branch\Models\Branch;
use App\Modules\BrDivision\Models\BrDivision;
use App\Modules\BrDepartment\Models\BrDepartment;
use App\Modules\DepartmentUnit\Models\DepartmentUnit;
use App\Modules\IndustryType\Models\IndustryType;
use App\Modules\Document\Models\Document;
use App\Modules\FunctionalDesignation\Models\FunctionalDesignation;

use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Employee\Models\EmployeeEducation;
use App\Modules\Employee\Models\EmployeeProfessionalDegree;
use App\Modules\Employee\Models\EmployeeTraining;
use App\Modules\Employee\Models\EmployeeChildren;
use App\Modules\Employee\Models\EmployeeReference;
use App\Modules\Employee\Models\EmployeeNominee;
use App\Modules\Employee\Models\EmployeeLanguage;
use App\Modules\Employee\Models\EmployeeProject;
use App\Modules\Employee\Models\EmployeeSpecialization;
use App\Modules\Employee\Models\EmployeePosting;
use App\Modules\Employee\Models\EmployeePostingHistory;
use App\Modules\Employee\Models\EmployeeExperience;
use App\Modules\Employee\Models\EmployeeDocument;
use App\Modules\Employee\Models\EmployeeKinship;

use App\Modules\Employee\Models\EmploymentType;
use App\Modules\Employee\Models\EmployeeSalary;
use App\Modules\Employee\Models\SalarySlave;
use App\Modules\Employee\Models\SalaryIncrementSlave;
use App\Modules\Employee\Models\EmployeeIncrementHistory;
use App\Modules\Employee\Models\EmployeeActivity;

use App\Modules\Leave\Models\EmployeeLeaveApplicationLog;
use App\Modules\LeaveType\Models\LeaveType;
use App\Modules\ProfessionalInstitue\Models\ProfessionalInstitue;
use App\Modules\TrainingOrganization\Models\TrainingOrganization;
use App\Modules\TrainingSubject\Models\TrainingSubject;
use App\Modules\ComputerGeneralSkill\Models\ComputerGeneralSkill;
use App\Modules\ComputerTechnicalSkill\Models\ComputerTechnicalSkill;
use App\Modules\ExtracurriculumActivity\Models\ExtracurriculumActivity;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Exports\EmployeeExport;
use Maatwebsite\Excel\Facades\Excel;


use Carbon\Carbon;

use Auth;


class EmployeeController extends Controller
{

    public function getEmpdoc(Request $request)
    {

        $allEmployees = $this->makeDD(EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id'));

        $branchList = $this->makeDD(Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')->pluck('branch_name', 'branch'));
        $designationList = $this->makeDD(Designation::select(DB::raw("(designation) designation_name"), 'id as designation_id')->orderby('seniority_order')->pluck('designation_name', 'designation_id'));

        if ($request->filled('employee_id')) {
            session()->forget('branch');
            session()->put('employee_id', $request->employee_id);
            $employee_id=$request->employee_id;
            $results=EmpInfoDoc::where('employee_id',$employee_id)->paginate(10);

        }
        elseif ($request->filled('branch')) {
            session()->forget('employee_id');
            session()->put('branch', $request->branch);
            $results=EmpInfoDoc::where('branch_id',$request->branch)->paginate(10);

        }
//        elseif ($request->filled('designation_id')) {
//            $results=EmpInfoDoc::where('designation',$request->designation_id)->paginate(10);
//
//        }
        else{
            session()->forget('branch');
            session()->forget('employee_id');
            $results = EmpInfoDoc::paginate(10);
        }

        return view("Employee::employeedoc", compact('results','branchList','allEmployees','designationList'));
    }



    public function ExportEmployee()
    {
        $branch=session()->get('branch');
        $employee_id=session()->get('employee_id');
        if($employee_id)
        {
        $results=EmpInfoDoc::where('employee_id',$employee_id)->get();
        }
        elseif ($branch)
        {
            $results=EmpInfoDoc::where('branch_id',$branch)->get();
        }
        else{
            $results = EmpInfoDoc::all();
        }
        return Excel::download(new EmployeeExport($results), 'exported_data.xlsx');


    }

    public function __construct()
    {
        $_SESSION["MenuActive"] = "employee";

    }

    /**
     * Display All Employee List
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $_SESSION["SubMenuActive"] = "employee";

        $designations = $this->makeDD(Designation::orderBy('designation')->pluck('designation', 'id'));

        $users = $this->__filterEmployee($request);
        $allEmployees = $this->makeDD(EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id'));

        return view("Employee::index", compact('users','allEmployees','designations'));
    }

    private function __filterEmployee($request)
    {
        $employee_id = auth()->user()->employee_id;
        if ($employee_id == 'hradmin' || $employee_id == 'hrexecutive') {
            $employeeList = DB::table('employee_details')
                ->select('employee_details.employee_id', 'employee_details.employee_name', 'employee_details.personal_file_no', 'designation.designation', 'employee_details.phone_no', 'employee_details.status', 'employee_details.joining_date')
                ->leftjoin('designation', 'employee_details.designation_id', '=', 'designation.id')
                ->leftjoin('employment_types', 'employee_details.employment_type', '=', 'employment_types.id')
                ->Where('employee_details.status', '=', '1')
                ->orderBy('designation.seniority_order');

        } elseif (auth()->user()->role_id == 2) {
            $employeeList = DB::table('employee_details')
                ->select('employee_details.employee_id', 'employee_details.employee_name', 'employee_details.personal_file_no', 'designation.designation', 'employee_details.phone_no', 'employee_details.status', 'employee_details.joining_date')
                ->leftjoin('designation', 'employee_details.designation_id', '=', 'designation.id')
                ->leftjoin('employment_types', 'employee_details.employment_type', '=', 'employment_types.id')
                ->Where('employee_details.status', '=', '1')
                ->where('employee_details.branch_id', auth()->user()->branch_id)
                ->orderBy('designation.seniority_order');
        } else {
            $employeeList = DB::table('employee_details')
                ->select('employee_details.employee_id', 'employee_details.employee_name', 'employee_details.personal_file_no', 'designation.designation', 'employee_details.phone_no', 'employee_details.status', 'employee_details.joining_date')
                ->leftjoin('designation', 'employee_details.designation_id', '=', 'designation.id')
                ->leftjoin('employment_types', 'employee_details.employment_type', '=', 'employment_types.id')
                ->Where('employee_details.status', '=', '1')
                ->Where('employee_details.employee_id', $employee_id);

        }


        if ($request->filled('employee_id')) {
            $employeeList->where('employee_details.employee_id', $request->employee_id);
        }

        if ($request->filled('employee_name')) {
            $employeeList->where('employee_details.employee_name', 'like', '%' . $request->employee_name . '%');
        }

        if ($request->filled('designation_id')) {
            $employeeList->where('employee_details.designation_id', $request->designation_id);
        }

        if ($request->filled('file_no')) {
            $employeeList->where('employee_details.personal_file_no', $request->file_no);
        }

        /*if (auth()->user()->role_id != ['1','3']) {
            $employeeList->where('employee_details.branch_id', auth()->user()->branch_id);
        }*/
        $employeeList->orderBy('employee_details.employee_id');

        return $employeeList->paginate(10);
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $_SESSION["SubMenuActive"] = "employeeCreate";
        //$branches = Branch::where('branch_id', 'not like', 'H%')->pluck('branch_name','id')->toarray();

        $status = ['0' => 'Inactive', '1' => 'Active'];

        $Role = $this->makeDD(Role::pluck('name', 'id'));

        $genderList = ['Male' => 'Male', 'Female' => 'Female', 'Common' => 'Common'];
        $recruitmentType = ['Normal' => 'Normal', 'Rehired' => 'Rehired', 'Re-employed' => 'Re-employed', 'Reinstated' => 'Reinstated'];

        $divisionList = $this->makeDD(Division::pluck('name', 'id'));
        $districtList = $this->makeDD(District::pluck('name', 'id'));
        $thanaList = $this->makeDD(Thana::pluck('name', 'id'));

        $nationalityList = ['Bangladeshi' => 'Bangladeshi'];

        $maritialList = ['Single' => 'Single', 'Married' => 'Married', 'Widow' => 'Widow', 'Widower' => 'Widower', 'Divorcee' => 'Divorcee'];

        $religionList = ['Islam' => 'Islam', 'Hinduism' => 'Hinduism', 'Christianity' => 'Christianity', 'Buddhism' => 'Buddhism', 'Others' => 'Others'];

        $bloodList = ['A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'];

        $staff_type = $this->makeDD(StaffType::pluck('employee_type', 'employee_type'));

        $training_type = ['In-House' => 'In-House', 'Local' => 'Local', 'Foreign' => 'Foreign'];


        $employment_type = $this->makeDD(EmploymentType::pluck('employment_type', 'id'));
        $educationLevels = $this->makeDD(EducationLevel::pluck('name', 'id'));
        $educationExams = $this->makeDD(EducationExam::pluck('examination', 'id'));
        $educationSubjects = $this->makeDD(EducationSubject::pluck('group_subject_major', 'id'));
        $educationInstitutes = $this->makeDD(EducationInstitute::pluck('board_university_institute', 'id'));

        $result_type = ['division' => 'Division/Class', 'GPA' => 'GPA/CGPA'];

        return view('Employee::create', compact('status', 'Role', 'divisionList', 'districtList', 'thanaList', 'genderList', 'nationalityList', 'maritialList', 'religionList', 'bloodList', 'employment_type', 'staff_type', 'educationLevels', 'educationExams', 'educationSubjects', 'educationInstitutes', 'result_type', 'training_type', 'recruitmentType'));
    }

    /**
     * Get Employee ID When joining date chnge
     *
     */
    public function getUpdatedEmployeeID(Request $request)
    {
        $employee_id = $request->employee_id;
        $joining_date = $request->joining_date;

        if ($joining_date != '') {
            $count = 1;
            $joiningday = strtoupper(date('d-M-y', strtotime(str_replace('/', '-', $joining_date))));

            /*$userCount = User::where('employee_id', $employee_id);

            if($userCount->count() > 0) {*/
            $todays_emp_count = DB::table('employee_details')->where('joining_date', $joining_date)->count();
            // echo $todays_emp_count;exit();
            $count = $count + $todays_emp_count;

            $employeeID = date("Ymd", strtotime($joiningday)) . str_pad($count, 3, '0', STR_PAD_LEFT);

            echo $employeeID;
        } else {
            echo $employee_id;
        }
    }

    /**
     * Get Employee Details Info
     *
     */
    public function getEmployeeInfo(Request $request)
    {
        $employee_id = $request->employee_id;

        if ($employee_id != '') {
            $employeeInfo = EmployeeDetails::select('employee_details.employee_id', 'employee_details.employee_name', 'employee_details.personal_file_no', 'branch.branch_name', 'employee_details.designation')
                ->leftjoin('branch', 'employee_details.branch_id', '=', 'branch.id')
                ->where('employee_details.employee_id', $employee_id)
                ->first();

            echo $employeeInfo;
        } else {
            echo '';
        }
    }

    /**
     * Get Employee Personal File
     *
     */
    public function getEmployeeFileNumber(Request $request)
    {
        $staff_type = $request->staff_type;
        //dd($staff_type);

        $count = 1;

        if ($staff_type == 'Support Staff' || $staff_type == 'Sales Staff') {
            $last_file_no = DB::select("select * from (select CAST(SUBSTR(PERSONAL_FILE_NO, 2, 5) AS NUMBER) file_no from EMPLOYEE_DETAILS  where staff_type='" . $staff_type . "' order by file_no desc) where rownum = 1");
        } else {
            $last_file_no = DB::select("select * from (select CAST(replace(replace(PERSONAL_FILE_NO,'R'),'C') AS NUMBER) file_no from EMPLOYEE_DETAILS  where staff_type='" . $staff_type . "' order by file_no desc) where rownum = 1");
        }

        if (!empty($last_file_no))
            $new_file_no = $count + $last_file_no[0]->file_no;
        else
            $new_file_no = $count;

        echo $new_file_no;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param \app\Http\Requests\StoreEmployeeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeEmployee(StoreEmployeeRequest $request)
    {
//        dd($request->all());
        try {
            \DB::beginTransaction();

            $inputs = $request->all();

            $userData['name'] = $inputs['name'];
            $userData['email'] = $inputs['email'];
            $userData['employee_id'] = $inputs['employee_id'];
            $userData['mobile_no'] = $inputs['mobile_no'];
            $userData['password'] = \Hash::make('12345678');
            $userData['type'] = 'system';
            $userData['role_id'] = 21;
            $userData['status'] = '1';
            $userData['created_by'] = auth()->user()->id;
            $userData['created_at'] = date('d-M-y');


            $user = User::create($userData);

            $employee_id = $user->employee_id;

            //Employee Details create
            $employeeDetails['employee_id'] = $employee_id;

            //dd($inputs);

            $employeeDetails['employee_name'] = $inputs['name'];
            $employeeDetails['email_id'] = $inputs['email'];
            $employeeDetails['phone_no'] = $inputs['mobile_no'];
            $employeeDetails['status'] = '1';
            $employeeDetails['staff_type'] = $inputs['staff_type'];

            if (isset($inputs['prefix']))
                $employeeDetails['prefix'] = $inputs['prefix'];

            $employeeDetails['personal_file_no'] = $inputs['prefix'] . $inputs['personal_file_no'];
            $employeeDetails['joining_date'] = $inputs['joining_date'];

            $employeeDetails['employment_type'] = $inputs['employment_type'];
            $employmentInfo = EmploymentType::findOrFail($inputs['employment_type']);

            if ($employmentInfo->employment_type == 'Contractual' || $employmentInfo->employment_type == 'Probation') {

                $employeeDetails['period_start_date'] = $inputs['period_start_date'];
                $employeeDetails['period_end_date'] = $inputs['period_end_date'];
            }

            $employeeDetails['status'] = '1';

            $userDetails = EmployeeDetails::create($employeeDetails);
            //dd($userDetails);

            \DB::commit();

            $this->updateEmployeeLeave($employee_id);
            $this->updateEmployeeTransferInfo($employee_id);

            echo $employee_id;
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Display the employee details info.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $employee = EmployeeDetails::where('employee_id', $id)->first();
        $employeeDetails = EmployeeDetails::where('employee_id', $id)->first();

        $employeeEducations = EmployeeEducation::where('employee_id', $id)->get();
        $EmployeeProfessionalDegrees = EmployeeProfessionalDegree::where('employee_id', $id)->get();
        $employeeTrainings = EmployeeTraining::where('employee_id', $id)->get();
        $employeeChildrens = EmployeeChildren::where('employee_id', $id)->get();
        $employeeReferences = EmployeeReference::where('employee_id', $id)->get();
        $employeeNominees = EmployeeNominee::where('employee_id', $id)->get();
        $employeeLanguages = EmployeeLanguage::where('employee_id', $id)->get();
        $employeeProjects = EmployeeProject::where('employee_id', $id)->get();
        $employeeSpecializations = EmployeeSpecialization::where('employee_id', $id)->get();
        $employeeExperiences = EmployeeExperience::where('employee_id', $id)->get();
        $employeeDocuments = EmployeeDocument::where('employee_id', $id)->get();
        $employeeProfilePhoto = EmployeeDocument::where('employee_id', $id)->where('document_type_id', '22')->get();
        $employeePostings = EmployeePosting::where('employee_id', $id)->first();
        $employeeActivities = EmployeeActivity::where('employee_id', $id)->get();
        $postingList = EmployeePostingHistory::where('employee_id', $id)
            ->orderby(DB::raw("TO_DATE(EFFECTIVE_DATE, 'DD-MM-YYYY')"), 'DESC')
            ->get();
        $promotionHistoryList = EmployeePromotion::where('employee_id', $id)
            ->orderby(DB::raw("TO_DATE(PROMOTION_DATE, 'YYYY-MM-DD')"), 'DESC')
            ->get();

        return view('Employee::view', compact('employee', 'employeeProfilePhoto', 'employeeDetails', 'employeeEducations', 'EmployeeProfessionalDegrees', 'employeeTrainings', 'employeeChildrens', 'employeeReferences', 'employeeNominees', 'employeeLanguages', 'employeeProjects', 'employeeSpecializations', 'employeePostings', 'employeeExperiences', 'employeeDocuments', 'employeeActivities','postingList','promotionHistoryList'));
    }

    /**
     * Show the form for editing the specified employee info.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = User::where('employee_id', $id)->first();
        $employeeDetails = EmployeeDetails::where('employee_id', $id)->first();

        $employeeEducations = EmployeeEducation::where('employee_id', $id)->get();
        $employeeProfessionalDegrees = EmployeeProfessionalDegree::where('employee_id', $id)->get();
        $employeeTrainings = EmployeeTraining::where('employee_id', $id)->get();
        $employeeChildrens = EmployeeChildren::where('employee_id', $id)->get();
        $employeeReferences = EmployeeReference::where('employee_id', $id)->get();
        $employeeNominees = EmployeeNominee::where('employee_id', $id)->get();
        $employeeLanguages = EmployeeLanguage::where('employee_id', $id)->get();
        $employeeProjects = EmployeeProject::where('employee_id', $id)->get();
        $employeeSpecializations = EmployeeSpecialization::where('employee_id', $id)->get();
        $employeeExperiences = EmployeeExperience::where('employee_id', $id)->get();
        $employeeDocuments = EmployeeDocument::where('employee_id', $id)->get();
        $employeeKinship = EmployeeKinship::where('employee_id', $id)->first();
        $employeeActivities = EmployeeActivity::where('employee_id', $id)->get();

        $employeePostings = EmployeePosting::where('employee_id', $id)->first();

        $documentList = Document::get();


        $Role = $this->makeDD(Role::OrderBy('name')->pluck('name', 'id'));
        $divisionList = $this->makeDD(Division::OrderBy('name')->pluck('name', 'id'));
        $districtList = $this->makeDD(District::OrderBy('name')->pluck('name', 'id'));
        $thanaList = $this->makeDD(Thana::OrderBy('name')->pluck('name', 'id'));

        $status = ['0' => 'Inactive', '1' => 'Active'];

        $genderList = ['Male' => 'Male', 'Female' => 'Female', 'Common' => 'Common'];

        $recruitmentType = ['Normal' => 'Normal', 'Rehired' => 'Rehired', 'Re-employed' => 'Re-employed', 'Reinstated' => 'Reinstated'];

        $nationalityList = ['Bangladeshi' => 'Bangladeshi'];

        $maritialList = ['Single' => 'Single', 'Married' => 'Married', 'Widow' => 'Widow', 'Widower' => 'Widower', 'Divorcee' => 'Divorcee'];

        $religionList = ['Islam' => 'Islam', 'Hinduism' => 'Hinduism', 'Christianity' => 'Christianity', 'Buddhism' => 'Buddhism', 'Others' => 'Others'];
        $bloodList = ['A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'];
        $training_type = ['In-House' => 'In-House', 'Local' => 'Local', 'Foreign' => 'Foreign'];
        $languages = ['Bangla' => 'Bangla', 'English' => 'English'];

        $proficiency_level = ['Excellent' => 'Excellent', 'Good' => 'Good', 'Moderate' => 'Moderate'];

        $result_type = ['division' => 'Division/Class', 'GPA' => 'GPA/CGPA'];
        $confirmation = ['Yes' => 'Yes', 'No' => 'No'];

        $educationLevels = $this->makeDD(EducationLevel::OrderBy('id')->pluck('name', 'id'));
        $educationExams = $this->makeDD(EducationExam::pluck('examination', 'id'));
        $educationSubjects = $this->makeDD(EducationSubject::pluck('group_subject_major', 'id'));
        $educationInstitutes = $this->makeDD(EducationInstitute::pluck('board_university_institute', 'id'));
        $instituteType = $this->makeDD(InstituteType::pluck('name', 'name'));
        $specializationArea = $this->makeDD(Specialization::pluck('specilized_area', 'id'));
        $designations = $this->makeDD(Designation::orderBy('designation')->pluck('designation', 'id'));
        $jobStatus = $this->makeDD(JobStatus::where('STATUS', '1')->pluck('job_status', 'id'));
        $transferType = $this->makeDD(TransferType::pluck('transfer_type', 'id'));

        $allBranch = Branch::where('branch_id', 'not like', 'H%')->get();
        $branchList = $this->makeDD(Branch::where('branch_id', 'not like', 'H%')->OrderBy('branch_name')->pluck('branch_name', 'id'));

        $branchDivisionList = $this->makeDD(BrDivision::pluck('br_name', 'id'));
        $branchDepartmentList = $this->makeDD(BrDepartment::pluck('dept_name', 'id'));
        $branchUnitList = $this->makeDD(DepartmentUnit::pluck('unit_name', 'id'));
        $employeeList = $this->makeDD(User::OrderBy('name')->pluck('name', 'employee_id'));
        $industryTypeList = $this->makeDD(IndustryType::pluck('industry_type', 'id'));
        $employment_type = $this->makeDD(EmploymentType::pluck('employment_type', 'id'));
        // $functionalDesignations = $this->makeDD(FunctionalDesignation::pluck('designation', 'id'));
        $functionalDesignations = FunctionalDesignation::where('status', 1)->pluck('designation', 'id');
        $staff_type = $this->makeDD(StaffType::pluck('employee_type', 'employee_type'));
        $professionalInstitue = $this->makeDD(ProfessionalInstitue::pluck('institute_name', 'id'));
        $trainingOrganization = $this->makeDD(TrainingOrganization::pluck('organization_name', 'id'));
        $trainingSubject = $this->makeDD(TrainingSubject::pluck('subject_name', 'id'));
        $computerGeneralSkills = ComputerGeneralSkill::get();
        $computerTechnicalSkills = ComputerTechnicalSkill::get();
        $extracurriculumActivity = ExtracurriculumActivity::get();

        $location = ['Local' => 'Local', 'Foreign' => 'Foreign'];

        $releaseOrderTypes = [
            'Clear Release' => 'Clear Release',
            'Conditional Release' => 'Conditional Release',
            'Letter of Termination' => 'Letter of Termination',
            'Letter of Removal' => 'Letter of Removal'
        ];

        return view('Employee::edit', compact('employee', 'employeeDetails', 'employeeEducations', 'employeeProfessionalDegrees', 'employeeTrainings', 'employeeChildrens', 'employeeReferences', 'employeeNominees', 'employeeLanguages', 'employeeProjects', 'employeeSpecializations', 'employeePostings', 'employeeExperiences', 'employeeDocuments', 'documentList', 'status', 'Role', 'divisionList', 'districtList', 'thanaList', 'genderList', 'nationalityList', 'maritialList', 'religionList', 'bloodList', 'employment_type', 'staff_type', 'educationLevels', 'educationExams', 'educationSubjects', 'educationInstitutes', 'specializationArea', 'result_type', 'training_type', 'languages', 'proficiency_level', 'jobStatus', 'designations', 'transferType', 'branchList', 'branchDivisionList', 'branchDepartmentList', 'branchUnitList', 'confirmation', 'employeeList', 'industryTypeList', 'functionalDesignations', 'allBranch', 'recruitmentType', 'instituteType', 'professionalInstitue', 'location', 'trainingOrganization', 'trainingSubject', 'computerGeneralSkills', 'computerTechnicalSkills', 'employeeKinship', 'extracurriculumActivity', 'employeeActivities', 'releaseOrderTypes'));
    }

    /**
     * Show the form for updating the specified employee Basic info.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function updateUserBasicInfo(Request $request)
    {
        try {
            $inputs = $request->all();

            $employee_id = $request->employee_id;

            $userData['name'] = $inputs['name'];
            $userData['employee_id'] = $inputs['employee_id'];
            $userData['mobile_no'] = $inputs['mobile_no'];
            $userData['email'] = $inputs['email'];
            $userData['mobile_no'] = $inputs['mobile_no'];
            $userData['updated_by'] = auth()->user()->id;
            $userData['updated_at'] = Carbon::now();
            User::where('employee_id', $employee_id)->update($userData);

            $this->updateEmployeeLeave($employee_id);
            $this->employeeInitPosting($employee_id);

            $employeeDetails['employee_id'] = $employee_id;
            $employeeDetails['employee_name'] = $inputs['name'];
            $employeeDetails['phone_no'] = $inputs['mobile_no'];
            $employeeDetails['prefix'] = $inputs['prefix'];
            $employeeDetails['personal_file_no'] = $inputs['personal_file_no'];
            $employeeDetails['staff_type'] = $inputs['staff_type'];
            $employeeDetails['joining_date'] = $inputs['joining_date'];
            $employeeDetails['employment_type'] = $inputs['employment_type'];

            $employmentInfo = EmploymentType::findOrFail($inputs['employment_type']);

            if ($employmentInfo->employment_type == 'Contractual' || $employmentInfo->employment_type == 'Probation') {
                $employeeDetails['period_start_date'] = $inputs['period_start_date'];
                $employeeDetails['period_end_date'] = $inputs['period_end_date'];
            } else {
                $employeeDetails['period_start_date'] = '';
                $employeeDetails['period_end_date'] = '';
            }
            // dd()
            EmployeeDetails::where('employee_id', $employee_id)->update($employeeDetails);

            echo $employee_id;
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            echo '';
        }
    }

    /**
     * Show the form for updating the specified employee details profile info.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function updateEmployee(Request $request)
    {
        try {
            $inputs = $request->all();
            //dd($inputs);

            $employee_id = $request->profile_employee_id;
            //dd($employee_id);

            $user = User::where('employee_id', $employee_id)->first();

            $userDetails['employee_id'] = $employee_id;
            $userDetails['father_name'] = $inputs['father_name'];
            $userDetails['mother_name'] = $inputs['mother_name'];
            $userDetails['marital_status'] = $inputs['marital_status'];
            $userDetails['spouse_name'] = $inputs['spouse_name'];


            if ($inputs['marriage_date'] != '') {
                $marriage_date = str_replace('/', '-', $inputs['marriage_date']);
                $userDetails['marriage_date'] = convertOracleDate($marriage_date);
            }

            $userDetails['nationality'] = $inputs['nationality'];
            $userDetails['birth_place'] = $inputs['birth_place'];
            $userDetails['gender'] = $inputs['gender'];
            $userDetails['blood_group'] = $inputs['blood_group'];
            $userDetails['religion'] = $inputs['religion'];
            $userDetails['phone_no'] = @$inputs['phone_no'];


            $birth_date = str_replace('/', '-', $inputs['birth_date']);
            $userDetails['birth_date'] = convertOracleDate($birth_date);

            if ($inputs['appointment_date'] != '') {
                $appointment_date = str_replace('/', '-', $inputs['appointment_date']);
                $userDetails['appointment_date'] = convertOracleDate($appointment_date);
            }

            $userDetails['appointment_ref_no'] = $inputs['appointment_ref_no'];
            $userDetails['nid'] = $inputs['nid'];
            $userDetails['tin'] = $inputs['tin'];
            $userDetails['passport_no'] = $inputs['passport_no'];

            if ($inputs['passport_issue_date'] != '') {

                $userDetails['passport_issue_date'] = $inputs['passport_issue_date'];
            }
            if ($inputs['passport_expire_date'] != '') {
                $userDetails['passport_expire_date'] = $inputs['passport_expire_date'];
            }


            $userDetails['recruitment_type'] = $inputs['recruitment_type'];

            $userDetails['driving_license'] = $inputs['driving_license'];


            $userDetails['kinship_declaration'] = $inputs['kinship_declaration'];


            $userDetails['release_order_type'] = $inputs['release_order_type'];


            //dd($userDetails);

            if ($inputs['release_order_type'] == 'Conditional Release') {
                $userDetails['cond_release_start_date'] = $inputs['cond_release_start_date'];
                $userDetails['cond_release_end_date'] = $inputs['cond_release_end_date'];

            } else {
                $userDetails['cond_release_start_date'] = '';
                $userDetails['cond_release_end_date'] = '';
            }

            //EmployeeDetails::where('employee_id', $employee_id)->update($userDetails);
            //dd('success');

            $designation = Designation::select('designation')->where('id', $inputs['designation_id'])->first();
            $offered_designation = Designation::select('designation')->where('id', $inputs['offered_designation_id'])->first();
            //dd($designation->designation);
            $userDetails['designation_id'] = $inputs['designation_id'];
            $userDetails['offered_designation_id'] = $inputs['offered_designation_id'];
            $userDetails['designation'] = $designation->designation;
            $userDetails['offered_designation'] = $offered_designation->designation;
            $userDetails['batch_no_for_mto'] = $inputs['batch_no_for_mto'];
            $userDetails['identification_mark'] = $inputs['identification_mark'];
            $userDetails['par_info_address'] = $inputs['par_info_address'];
            $userDetails['par_info_village'] = $inputs['par_info_village'];
            $userDetails['par_info_post_office'] = $inputs['par_info_post_office'];
            $userDetails['par_info_division'] = $inputs['par_info_division'];
            $userDetails['par_info_district'] = $inputs['par_info_district'];
            $userDetails['par_info_thana'] = $inputs['par_info_thana'];

            $userDetails['pre_info_address'] = $inputs['pre_info_address'];
            $userDetails['pre_info_village'] = $inputs['pre_info_village'];
            $userDetails['pre_info_post_office'] = $inputs['pre_info_post_office'];
            $userDetails['pre_info_division'] = $inputs['pre_info_division'];
            $userDetails['pre_info_district'] = $inputs['pre_info_district'];
            $userDetails['pre_info_thana'] = $inputs['pre_info_thana'];

            $userDetails['emergency_contact_name'] = $inputs['emergency_contact_name'];
            $userDetails['emergency_contact_address'] = $inputs['emergency_contact_address'];
            $userDetails['emergency_contact_relation'] = $inputs['emergency_contact_relation'];
            $userDetails['emergency_contact_mobile'] = $inputs['emergency_contact_mobile'];
            $userDetails['emergency_contact_email'] = $inputs['emergency_contact_email'];
            $userDetails['emergency_contact_nid'] = $inputs['emergency_contact_nid'];

            $userDetails['emergency_contact_name2'] = $inputs['emergency_contact_name2'];
            $userDetails['emergency_contact_address2'] = $inputs['emergency_contact_address2'];
            $userDetails['emergency_contact_relation2'] = $inputs['emergency_contact_relation2'];
            $userDetails['emergency_contact_mobile2'] = $inputs['emergency_contact_mobile2'];
            $userDetails['emergency_contact_email2'] = $inputs['emergency_contact_email2'];
            $userDetails['emergency_contact_nid2'] = $inputs['emergency_contact_nid2'];
            //dd($userDetails);
            $employeeDetail = EmployeeDetails::where('employee_id', $employee_id);
            //dd($employeeDetail->count());
            if ($employeeDetail->count() > 0) {
                //dd($employee_id);

                EmployeeDetails::where('employee_id', $employee_id)->update($userDetails);
            } else {
                EmployeeDetails::create($userDetails);
            }

            if (!empty($inputs['child_name'][0])) {
                for ($k = 0; $k < sizeof($inputs['child_name']); $k++) {
                    $childInfo['employee_id'] = $employee_id;
                    $childInfo['child_name'] = $inputs['child_name'][$k];
                    $childInfo['child_age'] = $inputs['child_age'][$k];
                    $childInfo['child_gender'] = $inputs['child_gender'][$k];
                    $childInfo['child_education'] = $inputs['child_education'][$k];
                    $childInfo['remarks'] = $inputs['child_remarks'][$k];
                    EmployeeChildren::create($childInfo);
                }
            }


            if ($inputs['kinship_declaration'] == 'Yes') {
                $kinship['employee_id'] = $employee_id;
                $kinship['relation'] = $inputs['relation'];
                $kinship['relative_employee_id'] = $inputs['relative_employee_id'];

                $employeeKinship = EmployeeKinship::where('employee_id', $employee_id);


                if ($employeeDetail->count() > 1) {
                    EmployeeKinship::where('employee_id', $employee_id)->update($kinship);
                } else {
                    $kinship['id'] = $employeeDetail->count() + 1;
                    EmployeeKinship::create($kinship);
                }
            }

            $this->updateEmployeeLeave($employee_id);


            echo $employee_id;
        } catch (\Exception $e) {
            \Log::info('Profile Update Error => ' . $e->getMessage());
            echo '';
        }
    }

    /**
     * Show the form for updating the specified employee Education and Others info.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function updateEmployeeOtherInfo(Request $request)
    {
        $inputs = $request->all();

        $employee_id = $request->other_employee_id;
        //dd('TTT',$inputs);

        if (!empty($inputs['emp_edu_level'][0])) {
            for ($i = 0; $i < sizeof($inputs['emp_edu_level']); $i++) {
                $eduInfo['employee_id'] = $employee_id;
                $eduInfo['emp_edu_level'] = $inputs['emp_edu_level'][$i];
                $eduInfo['exam'] = $inputs['exam'][$i];
                $eduInfo['group_subject'] = $inputs['group_subject'][$i];
                $eduInfo['institute_type'] = $inputs['institute_type'][$i];
                $eduInfo['board_university'] = $inputs['board_university'][$i];
                $eduInfo['passing_year'] = $inputs['passing_year'][$i];
                $eduInfo['result_type'] = $inputs['result_type'][$i];
                $eduInfo['result'] = $inputs['result'][$i];
                $eduInfo['out_of'] = $inputs['out_of'][$i];

                EmployeeEducation::create($eduInfo);
            }
        }

        if (!empty($inputs['institute_name'][0])) {
            for ($j = 0; $j < sizeof($inputs['institute_name']); $j++) {
                $profDegreeInfo['employee_id'] = $employee_id;
                $profDegreeInfo['institute_name'] = $inputs['institute_name'][$j];
                $profDegreeInfo['course'] = $inputs['course'][$j];

                $COURSE_START_DATE = str_replace('/', '-', $inputs['course_start_date'][$j]);
                $COURSE_END_DATE = str_replace('/', '-', $inputs['course_end_date'][$j]);
                $COURSE_PASSED_DATE = str_replace('/', '-', $inputs['course_passed_date'][$j]);
                if (!empty($COURSE_START_DATE) || !empty($COURSE_END_DATE) || !empty($COURSE_PASSED_DATE)) {
                    $profDegreeInfo['course_start_date'] = convertOracleDate($COURSE_START_DATE);
                    $profDegreeInfo['course_end_date'] = convertOracleDate($COURSE_END_DATE);
                    $profDegreeInfo['course_passed_date'] = convertOracleDate($COURSE_PASSED_DATE);
                } else {
                    $profDegreeInfo['course_start_date'] = '';
                    $profDegreeInfo['course_end_date'] = '';
                    $profDegreeInfo['course_passed_date'] = '';
                }

                $profDegreeInfo['course_result'] = $inputs['course_result'][$j];
                $profDegreeInfo['course_location'] = $inputs['course_location'][$j];
                $profDegreeInfo['course_remarks'] = $inputs['course_remarks'][$j];


                EmployeeProfessionalDegree::create($profDegreeInfo);
            }
        }

        if (!empty($inputs['org_name'][0])) {
            for ($j = 0; $j < sizeof($inputs['org_name']); $j++) {
                $traningInfo['employee_id'] = $employee_id;
                $traningInfo['org_name'] = $inputs['org_name'][$j];
                $traningInfo['subject'] = $inputs['subject'][$j];

                $START_DATE = str_replace('/', '-', $inputs['start_date'][$j]);
                $END_DATE = str_replace('/', '-', $inputs['end_date'][$j]);
                $PASSED_DATE = str_replace('/', '-', $inputs['passed_date'][$j]);
                if (!empty($START_DATE) || !empty($END_DATE) || !empty($PASSED_DATE)) {
                    $traningInfo['start_date'] = convertOracleDate($START_DATE);
                    $traningInfo['end_date'] = convertOracleDate($END_DATE);
                    $traningInfo['passed_date'] = convertOracleDate($PASSED_DATE);
                } else {
                    $traningInfo['start_date'] = '';
                    $traningInfo['end_date'] = '';
                    $traningInfo['passed_date'] = '';
                }
                $traningInfo['traning_type'] = $inputs['traning_type'][$j];
                $traningInfo['venue'] = $inputs['venue'][$j];
                $traningInfo['remarks'] = $inputs['remarks'][$j];
                //dd($traningInfo);

                EmployeeTraining::create($traningInfo);
            }
        }

        $this->updateEmployeeLeave($employee_id);

        echo $employee_id;
    }

    /**
     * Show the form for updating the specified employee Skills info.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function updateEmployeeSkillInfo(Request $request)
    {
        $inputs = $request->all();

        $employee_id = $request->skill_employee_id;

        if (isset($inputs['computer_skills']))
            $userData['computer_skills'] = json_encode($inputs['computer_skills']);

        if (isset($inputs['technical_skills']))
            $userData['technical_skills'] = json_encode($inputs['technical_skills']);

        $userData['special_qualification'] = $inputs['special_qualification'];
        // $userData['updated_at'] = date('m/d/Y H:i:s');

        EmployeeDetails::where('employee_id', $employee_id)->update($userData);


        for ($i = 0; $i < sizeof($inputs['language']); $i++) {
            $langInfo['employee_id'] = $employee_id;
            $langInfo['language'] = $inputs['language'][$i];
            $langInfo['reading'] = $inputs['reading'][$i];
            $langInfo['writing'] = $inputs['writing'][$i];
            $langInfo['listening'] = $inputs['listening'][$i];
            $langInfo['speaking'] = $inputs['speaking'][$i];

            EmployeeLanguage::create($langInfo);
        }

        if (!empty($inputs['project_title'][0])) {
            for ($j = 0; $j < sizeof($inputs['project_title']); $j++) {
                $projectInfo['employee_id'] = $employee_id;
                $projectInfo['project_title'] = $inputs['project_title'][$j];
                $projectInfo['details'] = $inputs['details'][$j];

                $projectInfo['completion_date'] = $inputs['completion_date'][$j];

                EmployeeProject::create($projectInfo);
            }
        }

        if (!empty($inputs['specialization_area'][0])) {
            for ($k = 0; $k < sizeof($inputs['specialization_area']); $k++) {
                $specialInfo['employee_id'] = $employee_id;
                $specialInfo['specialization_area'] = $inputs['specialization_area'][$k];
                $specialInfo['details'] = $inputs['details'][$k];

                EmployeeSpecialization::create($specialInfo);
            }
        }

        $this->updateEmployeeLeave($employee_id);

        echo $employee_id;
    }

    /**
     * Show the form for updating the specified employee Transfer Posting info.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function  updateEmployeeTransferInfo ($employee_id)
    {
        try {
            $employeeInfo = EmployeeDetails::where('employee_id', $employee_id)->first();
            $employeePosting = EmployeePosting::where('employee_id', $employee_id);
            $lastPostingInfo = EmployeePostingHistory::where('employee_id', $employee_id)->where('POSTING_STATUS', '1');

            $tansInfo['employee_id'] = $employee_id;
            $tansInfo['job_status_id'] = 3;
            $tansInfo['transfer_type_id'] = 1;
            $tansInfo['branch_id'] = 65;
            $tansInfo['is_current'] = 2;
            $EFFECTIVE_DATE = str_replace('/', '-', $employeeInfo->joining_date);
            $tansInfo['effective_date'] = date("d-m-Y", strtotime($EFFECTIVE_DATE));
            $tansInfo['posting_status'] = '1';

            EmployeePosting::create($tansInfo);
            EmployeePostingHistory::create($tansInfo);

        } catch (\Exception $e) {
            \Log::info('Transfer Posting Error => ' . $e->getMessage());
        }

    }

    /**
     * Show the form for updating the specified employee Professional Experience info.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function updateEmployeeExperienceInfo(Request $request)
    {
        $inputs = $request->all();

        $employee_id = $request->experience_employee_id;

        $serial_no = 1;
        $experienceCount = EmployeeExperience::where('employee_id', $employee_id)->count();

        $serial_no = $experienceCount;

        if (!empty($inputs['industry_type_id'][0])) {
            for ($i = 0; $i < sizeof($inputs['industry_type_id']); $i++) {
                $serial_no++;

                $expInfo['employee_id'] = $employee_id;
                $expInfo['serial'] = $serial_no;
                $expInfo['industry_type_id'] = @$inputs['industry_type_id'][$i];
                $expInfo['designation'] = @$inputs['designation'][$i];
                $expInfo['start_date'] = @$inputs['exp_start_date'][$i];
                $expInfo['end_date'] = @$inputs['exp_end_date'][$i];
                $expInfo['duration'] = @$inputs['duration'][$i];
                $expInfo['job_description'] = @$inputs['job_description'][$i];
                $expInfo['organization_name'] = @$inputs['organization_name'][$i];
                $expInfo['organization_address'] = @$inputs['organization_address'][$i];
                $expInfo['supervisor_name'] = @$inputs['supervisor_name'][$i];
                $expInfo['supervisor_note'] = @$inputs['supervisor_note'][$i];
                $expInfo['contact_number'] = @$inputs['contact_number'][$i];
                $expInfo['position_reports_to'] = @$inputs['position_reports_to'][$i];
                $expInfo['last_salary'] = @$inputs['last_salary'][$i];

                EmployeeExperience::create($expInfo);
            }
        }

        if (!empty($inputs['extra_activity'])) {
            for ($l = 0; $l < sizeof($inputs['extra_activity']); $l++) {
                $activityInfo['employee_id'] = $employee_id;
                $activityInfo['activity_name'] = $inputs['extra_activity'][$l];

                EmployeeActivity::create($activityInfo);
            }
        }

        if (!empty($inputs['ref_name'][0])) {
            for ($l = 0; $l < sizeof($inputs['ref_name']); $l++) {
                $refInfo['employee_id'] = $employee_id;
                $refInfo['ref_name'] = $inputs['ref_name'][$l];
                $refInfo['ref_address'] = $inputs['ref_address'][$l];
                $refInfo['ref_phone'] = $inputs['ref_phone'][$l];
                $refInfo['ref_organization'] = $inputs['ref_organization'][$l];
                $refInfo['ref_designation'] = $inputs['ref_designation'][$l];
                $refInfo['ref_department'] = $inputs['ref_department'][$l];
                $refInfo['ref_email'] = $inputs['ref_email'][$l];
                $refInfo['ref_comments'] = $inputs['ref_comments'][$l];

                EmployeeReference::create($refInfo);
            }
        }

        if (!empty($inputs['nominee_name'][0])) {
            for ($m = 0; $m < sizeof($inputs['nominee_name']); $m++) {
                $nomineeInfo['employee_id'] = $employee_id;
                $nomineeInfo['nominee_no'] = $m + 1;
                $nomineeInfo['nominee_name'] = $inputs['nominee_name'][$m];
                $nomineeInfo['relation'] = $inputs['relation'][$m];
                $nomineeInfo['address'] = $inputs['address'][$m];
                $nomineeInfo['mobile_no'] = $inputs['nominee_mobile_no'][$m];
                $nomineeInfo['nid_birth_cert_pass'] = $inputs['nid_birth_cert_pass'][$m];

                if ($inputs['nominee_birth_date'][$m] != '') {
                    $nomineeInfo['nominee_birth_date'] = $inputs['nominee_birth_date'][$m];
                }

                $nomineeInfo['nominee_age'] = $inputs['nominee_age'][$m];
                $nomineeInfo['distribution_percent'] = $inputs['distribution_percent'][$m];

                EmployeeNominee::create($nomineeInfo);
            }
        }

        $this->updateEmployeeLeave($employee_id);

        echo $employee_id;
    }

    /**
     * Update the specified resource in storage Upload document.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fileUploadPost(Request $request)
    {
        try {
            $inputs = $request->all();


            $documentList = Document::get();

            $employee_id = $request->document_employee_id;

            foreach ($documentList as $document) {
                $documentName = str_replace(" ", "_", $document->document_type);

                //$file = $request->$documentName;

                if ($document->is_required == 'YES') {
                    $request->validate([
                        $documentName => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
                    ]);
                }


                if ($request->hasFile($documentName)) {
                    $fileName = uniqid() . '.' . $request->$documentName->extension();
                    $request->$documentName->move(public_path('uploads'), $fileName);


                    $fileInfo['employee_id'] = $employee_id;
                    $fileInfo['document_type_id'] = $document->id;
                    $fileInfo['received_date'] = date('Y-m-d');
                    $fileInfo['remarks'] = $inputs['remarks_' . $documentName];
                    $fileInfo['attachment'] = $fileName;

                    // dd($fileInfo);

                    $EmployeeDocument = EmployeeDocument::where('employee_id', $employee_id)->where('document_type_id', $document->id);

                    if ($EmployeeDocument->count() > 0) {
                        $EmployeeDocumentInfo = $EmployeeDocument->first();
                        \File::delete(public_path('uploads/' . $EmployeeDocumentInfo->attachment));

                        EmployeeDocument::where('employee_id', $employee_id)->where('document_type_id', $document->id)->update($fileInfo);
                    } else {
                        EmployeeDocument::create($fileInfo);
                    }
                }
            }

            $this->updateEmployeeLeave($employee_id);

            return Redirect()->to('employee/' . $employee_id . '/edit')->with('msg-success', 'Employee Information Successfully Updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $employee_id
     * @param int $doc_type_id
     * @return \Illuminate\Http\Response']
     */
    public function deleteFile($employee_id, $doc_type_id)
    {
        try {
            $EmployeeDocument = EmployeeDocument::where('employee_id', $employee_id)->where('document_type_id', $doc_type_id);
            if ($EmployeeDocument->count() > 0) {
                $EmployeeDocumentInfo = $EmployeeDocument->first();

                $attachment = $EmployeeDocumentInfo->attachment;

                if ($EmployeeDocument->delete()) {
                    \File::delete(public_path('uploads/' . $attachment));

                    return Redirect()->to('employee/' . $employee_id . '/edit')->with('msg-success', 'Employee Information Successfully Deleted');
                } else {
                    return redirect()->back()->with('msg-error', 'Operation Failed.');
                }
            } else {
                return redirect()->back()->with('msg-error', 'Document Information not Found.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response']
     */
    public function destroy($id)
    {
        //
    }

    public function employeeSalary($employee_id)
    {
        try {
            $EmployeeDetails = EmployeeDetails::where('employee_id', $employee_id);
            if ($EmployeeDetails->count() > 0) {
                $EmployeeDetailsInfo = $EmployeeDetails->first();

                $designation_id = $EmployeeDetailsInfo->designation_id;

                $incrementSlave = array(
                    "0" => "0",
                    "1" => "1",
                    "2" => "2",
                    "3" => "3",
                    "4" => "4",
                    "5" => "5",
                    "6" => "6",
                    "7" => "7",
                    "8" => "8",
                    "9" => "9",
                    "10" => "10",
                    "11" => "11",
                    "12" => "12"
                );

                $employeeSalaryData = '';
                $salaryBasicInfo = '';

                $employeeSalaryInfo = EmployeeSalary::where('employee_id', $employee_id);

                if ($employeeSalaryInfo->count() > 0) {
                    $employeeSalaryData = $employeeSalaryInfo->first();
                }

                $salaryBasic = SalarySlave::where('designation_id', $designation_id);

                if ($salaryBasic->count() > 0) {
                    $salaryBasicInfo = $salaryBasic->first();
                }

                return view('Employee::salary', compact('EmployeeDetailsInfo', 'incrementSlave', 'employeeSalaryData', 'salaryBasicInfo'));
            } else {
                return redirect()->back()->with('msg-error', 'Employee Information not Found.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Update the specified employee salary increment.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function employeeSalaryStore(Request $request)
    {
        try {
            \DB::beginTransaction();

            $inputs = $request->all();

            $inc_slab = $inputs['current_inc_slave'];
            $employee_id = $inputs['employee_id'];

            $salaryInfo['employee_id'] = $employee_id;
            $salaryInfo['current_basic'] = $inputs['current_basic'];
            $salaryInfo['consolidated_salary'] = $inputs['consolidated_amount'];
            $salaryInfo['car_allowance'] = $inputs['car_allowance'];
            $salaryInfo['house_rent'] = $inputs['house_rent'];
            $salaryInfo['medical'] = $inputs['medical'];
            $salaryInfo['conveyance'] = $inputs['conveyance'];
            $salaryInfo['house_maintenance'] = $inputs['house_maintenance'];
            $salaryInfo['utility'] = $inputs['utility'];
            $salaryInfo['lfa'] = $inputs['lfa'];
            $salaryInfo['others'] = $inputs['others'];
            $salaryInfo['pf'] = (($inputs['current_basic'] * 10) / 100);
            $salaryInfo['gross_total'] = $inputs['gross_total'];
            $salaryInfo['current_inc_slave'] = $inc_slab;
            $salaryInfo['updated_by'] = auth()->user()->id;
            $salaryInfo['updated_at'] = date('m/d/Y H:i:s');

            $employeeSalary = EmployeeSalary::where('employee_id', $employee_id);

            $salaryInfo['authorize_status'] = '2';
            EmployeeSalaryTemp::create($salaryInfo);

            if ($employeeSalary->count() == 0) {
                /*$salaryInfo['authorize_status'] = '2';
                EmployeeSalary::where('employee_id', $employee_id)->update($salaryInfo);

            } else {*/

                EmployeeSalary::create($salaryInfo);

                $salaryHistory['authorize_status'] = '1';
                $msg = 'Employee Salary Information Successfully Updated.';
            } else {
                $msg = 'Employee increment request has been submitted waiting for authorization';
                $salaryHistory['authorize_status'] = '2';
            }

            $lastIncrementInfo = EmployeeIncrementHistory::where('employee_id', $employee_id)->where('authorize_status', '2');
            if ($lastIncrementInfo->count() == 0) {
                $salaryHistory['employee_id'] = $employee_id;
                $salaryHistory['inc_slave_no'] = $inputs['current_inc_slave'];
                $salaryHistory['increment_date'] = $inputs['increment_date'];
                $salaryHistory['created_by'] = auth()->user()->id;
                $salaryHistory['created_date'] = date('m/d/Y H:i:s');

                EmployeeIncrementHistory::create($salaryHistory);
                \DB::commit();

                return redirect()->back()->with('msg-success', $msg);
            } else {
                return redirect()->back()->with('msg-error', 'Employee Increment Waiting for Authorization.');
            }
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    public function incrementStructure()
    {
        try {
            $salarySlaves = SalarySlave::get();//whereIn('designation_id', ['10','11'])->

            $designation = 0;
            $x = 0;
            $y = 0;
            $nextBasic = 0;
            $lastBasic = 0;
            $prevIncrement = 0;

            // echo '<pre color="red">';

            foreach ($salarySlaves as $salarySlave) {
                if ($salarySlave->designation_id != $designation) {
                    $x = 0;
                    // $y = 0;
                    $basic = 0;
                    $increment = 0;

                    $designation = $salarySlave->designation_id;

                    /*echo '<pre color="red">';
                    print_r($designation);
                    echo '<br/>';
                    echo $x;
                    echo '<br/>';
                    echo $y;
                    echo '<br/>';
                    echo '<br/>';*/
                }


                if (isset($salarySlaves[$y + 1]->basic_salary)) {
                    $nextBasic = $salarySlaves[$y + 1]->basic_salary;
                } else {
                    $nextBasic = $salarySlaves[$y]->basic_salary;
                }


                $basic = $salarySlave->basic_salary;
                $increment = $salarySlave->increment_amount;

                /*echo $x." => ".$designation.' => '. $basic .' => '. $increment .' => '.$nextBasic;
                echo '<br/>';*/

                if ($increment > 0) {
                    for ($j = $basic; $j < $nextBasic; $j += $increment) {
                        $x = $x + 1;

                        $lastBasic = $j;
                        $prevIncrement = $increment;

                        $incrementInfo['designation_id'] = $designation;
                        $incrementInfo['basic_salary'] = $j;
                        $incrementInfo['increment_amount'] = $increment;
                        $incrementInfo['inc_slave_no'] = $x;

                        $salaryIncrement = SalaryIncrementSlave::where('designation_id', $designation)->where('inc_slave_no', $x);

                        if ($salaryIncrement->count() > 0) {
                            SalaryIncrementSlave::where('designation_id', $designation)->where('inc_slave_no', $x)->update($incrementInfo);
                        } else {
                            SalaryIncrementSlave::create($incrementInfo);
                        }
                    }
                } else {
                    $incrementInfo['designation_id'] = $designation;
                    $incrementInfo['basic_salary'] = $lastBasic;
                    $incrementInfo['increment_amount'] = $prevIncrement;
                    $incrementInfo['inc_slave_no'] = $x;

                    /*echo '<pre color="red">';
                    print_r($incrementInfo);
                    echo '</pre>';*/

                    $salaryIncrement = SalaryIncrementSlave::where('designation_id', $designation)->where('inc_slave_no', $x);

                    if ($salaryIncrement->count() > 0) {
                        SalaryIncrementSlave::where('designation_id', $designation)->where('inc_slave_no', $x)->update($incrementInfo);
                    } else {
                        SalaryIncrementSlave::create($incrementInfo);
                    }

                    $lastSlave = $x + 1;

                    $incrementInfo['designation_id'] = $designation;
                    $incrementInfo['basic_salary'] = ($lastBasic + $prevIncrement);
                    $incrementInfo['increment_amount'] = 0;
                    $incrementInfo['inc_slave_no'] = $lastSlave;


                    /*echo '<pre color="red">';
                    print_r($incrementInfo);
                    echo '</pre>';*/

                    $salaryIncrement = SalaryIncrementSlave::where('designation_id', $designation)->where('inc_slave_no', $lastSlave);

                    if ($salaryIncrement->count() > 0) {
                        SalaryIncrementSlave::where('designation_id', $designation)->where('inc_slave_no', $lastSlave)->update($incrementInfo);
                    } else {
                        SalaryIncrementSlave::create($incrementInfo);
                    }
                }

                $y = $y + 1;
            }

            echo '<pre color="red">';
            print_r("Salary Increment Structure Updated");
            echo '</pre>';
            exit();
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }


    /**
     * get the specified salary slave.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getEmployeeSalarySlaveInfo(Request $request)
    {
        $salaryIncrementSlave = SalaryIncrementSlave::where('designation_id', $request->designation_id)
            ->where('inc_slave_no', ($request->incrementSlave))->first();
        //dd($salaryIncrementSlave);
        if ($salaryIncrementSlave->count() > 0) {
            $data['salaryIncrementSlaveData'] = $salaryIncrementSlave->first();
            $data['salaryDetailsData'] = SalarySlave::where('designation_id', $request->designation_id)
                ->where('basic_salary', ($salaryIncrementSlave->basic_salary))->first();
            echo json_encode($data);
        }
    }

    /**
     * Edit the specified employee educational information.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function employeeEducationEdit(Request $request)
    {
        $employeeEducation = EmployeeEducation::where('id', $request->education_id)->first();

        $educationLevels = $this->makeDD(EducationLevel::pluck('name', 'id'));
        $educationExams = $this->makeDD(EducationExam::pluck('examination', 'id'));
        $educationSubjects = $this->makeDD(EducationSubject::pluck('group_subject_major', 'id'));
        $educationInstitutes = $this->makeDD(EducationInstitute::pluck('board_university_institute', 'id'));
        $instituteType = $this->makeDD(InstituteType::pluck('name', 'name'));

        $result_type = ['division' => 'Division/Class', 'GPA' => 'GPA/CGPA'];

        echo view("Employee::educationEdit", compact('employeeEducation', 'educationLevels', 'educationExams', 'educationSubjects', 'educationInstitutes', 'result_type', 'instituteType'));
    }

    /**
     * Update the specified employee Education Information.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function employeeEducationUpdate(Request $request, $id)
    {
        try {
            \DB::beginTransaction();

            $eduInfo['emp_edu_level'] = $request->emp_edu_level;
            $eduInfo['exam'] = $request->exam;
            $eduInfo['group_subject'] = $request->group_subject;
            $eduInfo['board_university'] = $request->board_university;
            $eduInfo['passing_year'] = $request->passing_year;
            $eduInfo['result_type'] = $request->result_type;
            $eduInfo['result'] = $request->result;
            $eduInfo['out_of'] = $request->out_of;
            $eduInfo['institute_type'] = $request->institute_type;

            EmployeeEducation::where('id', $id)->update($eduInfo);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Education Information Successfully Updated.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Delete the specified employee education information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteEducationInfo($id)
    {
        try {
            \DB::beginTransaction();

            $employeeEducation = EmployeeEducation::where('id', $id)->count();
            if ($employeeEducation > 0) {
                EmployeeEducation::where('id', $id)->delete();
            }

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Education Information Successfully Deleted.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


    /**
     * View the specified employee Professional Institute Name Modal.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function employeeProfDegreeDiplomaAdd()
    {
        echo view("Employee::profDiplomaDegreeEdit");
    }

    /**
     * Store the specified employee Professional Institute Name Store
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function employeeProfDegreeDiplomaStore(Request $request)
    {
        try {
            \DB::beginTransaction();

            $instituteInfo['institute_name'] = $request->institute_name;

            ProfessionalInstitue::save($instituteInfo);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Professional Institute Name Successfully Added.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


    /**
     * Edit the professional employee educational information.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function employeeProfEducationEdit(Request $request)
    {
        $employeeProfDegree = EmployeeProfessionalDegree::where('id', $request->prof_degree_id)->first();
        $professionalInstitue = $this->makeDD(ProfessionalInstitue::pluck('institute_name', 'id'));

        echo view("Employee::prof_degree_edit", compact('employeeProfDegree', 'professionalInstitue'));
    }

    /**
     * Update the professional employee Education Information.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function employeeProfEducationUpdate(Request $request, $id)
    {
        try {
            \DB::beginTransaction();

            $profDegreeInfo['institute_name'] = $request->institute_name;
            $profDegreeInfo['course'] = $request->course;

            $COURSE_START_DATE = str_replace('/', '-', $request->course_start_date);
            $COURSE_END_DATE = str_replace('/', '-', $request->course_end_date);
            $COURSE_PASSED_DATE = str_replace('/', '-', $request->course_passed_date);
            if (!empty($COURSE_START_DATE) || !empty($COURSE_END_DATE) || !empty($COURSE_PASSED_DATE)) {
                $profDegreeInfo['course_start_date'] = convertOracleDate($COURSE_START_DATE);
                $profDegreeInfo['course_end_date'] = convertOracleDate($COURSE_END_DATE);
                $profDegreeInfo['course_passed_date'] = convertOracleDate($COURSE_PASSED_DATE);
            } else {
                $profDegreeInfo['course_start_date'] = '';
                $profDegreeInfo['course_end_date'] = '';
                $profDegreeInfo['course_passed_date'] = '';
            }

            $profDegreeInfo['course_result'] = $request->course_result;
            $profDegreeInfo['course_location'] = $request->course_location;
            $profDegreeInfo['course_remarks'] = $request->course_remarks;

            // dd($profDegreeInfo);

            EmployeeProfessionalDegree::where('id', $id)->update($profDegreeInfo);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Professional Degree Successfully Updated.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Delete the professional employee education information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteProfEducationInfo($id)
    {
        try {
            \DB::beginTransaction();

            $EmployeeProfessionalDegree = EmployeeProfessionalDegree::where('id', $id)->count();
            if ($EmployeeProfessionalDegree > 0) {
                EmployeeProfessionalDegree::where('id', $id)->delete();
            }

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Professional Degree Successfully Deleted.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Edit the employee training information.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function profTrainingEdit(Request $request)
    {
        $id = $request->prof_training_id;

        $training_type = ['in-House' => 'In-House', 'Local' => 'Local', 'Foreign' => 'Foreign'];

        $profTraining = EmployeeTraining::where('id', $id)->first();

        $trainingOrganization = $this->makeDD(TrainingOrganization::pluck('organization_name', 'id'));
        $trainingSubject = $this->makeDD(TrainingSubject::pluck('subject_name', 'id'));

        echo view("Employee::prof_training_edit", compact('profTraining', 'training_type', 'trainingOrganization', 'trainingSubject'));
    }

    /**
     * Update the employee training Information.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function profTrainingUpdate(Request $request, $id)
    {
        try {
            \DB::beginTransaction();

            $profTrainingInfo['org_name'] = $request->org_name;
            $profTrainingInfo['subject'] = $request->subject;

            if ($request->start_date != '')
                $profTrainingInfo['start_date'] = $request->start_date;
            if ($request->end_date != '')
                $profTrainingInfo['end_date'] = $request->end_date;
            if ($request->passed_date != '')
                $profTrainingInfo['passed_date'] = $request->passed_date;

            $profTrainingInfo['traning_type'] = $request->traning_type;
            $profTrainingInfo['venue'] = $request->venue;
            $profTrainingInfo['remarks'] = $request->remarks;


            //dd($profTrainingInfo);

            EmployeeTraining::where('id', $id)->update($profTrainingInfo);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Professional Training Successfully Updated.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Delete the employee training information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteProfTrainingInfo($id)
    {
        try {
            \DB::beginTransaction();

            $EmployeeTraining = EmployeeTraining::where('id', $id)->count();
            if ($EmployeeTraining > 0) {
                EmployeeTraining::where('id', $id)->delete();
            }

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Professional Training Successfully Deleted.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Edit the employee children information.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function childrenInfoEdit(Request $request)
    {
        $childrenInfo = EmployeeChildren::where('id', $request->children_id)->first();
        $genderList = ['Male' => 'Male', 'Female' => 'Female', 'Common' => 'Common'];

        echo view("Employee::children_edit", compact('childrenInfo', 'genderList'));
    }

    /**
     * Update the employee children Information.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function childrenInfoUpdate(Request $request, $id)
    {
        try {
            \DB::beginTransaction();

            $childInfo['child_name'] = $request->child_name;
            $childInfo['child_age'] = $request->child_age;
            $childInfo['child_gender'] = $request->child_gender;
            $childInfo['child_education'] = $request->child_education;
            $childInfo['remarks'] = $request->child_remarks;

            EmployeeChildren::where('id', $id)->update($childInfo);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Children Information Successfully Updated.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Delete the employee children information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteChildrenInfo($id)
    {
        try {
            \DB::beginTransaction();

            $EmployeeChildren = EmployeeChildren::where('id', $id)->count();
            if ($EmployeeChildren > 0) {
                EmployeeChildren::where('id', $id)->delete();
            }

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Children Information Successfully Deleted.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Edit the employee Reference information.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function referenceInfoEdit(Request $request)
    {
        $referenceInfo = EmployeeReference::where('id', $request->reference_id)->first();

        echo view("Employee::reference_edit", compact('referenceInfo'));
    }

    /**
     * Update the employee reference Information.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function referenceInfoUpdate(Request $request, $id)
    {
        try {
            \DB::beginTransaction();

            $refInfo['ref_name'] = $request->ref_name;
            $refInfo['ref_address'] = $request->ref_address;
            $refInfo['ref_phone'] = $request->ref_phone;
            $refInfo['ref_organization'] = $request->ref_organization;
            $refInfo['ref_designation'] = $request->ref_designation;
            $refInfo['ref_department'] = $request->ref_department;
            $refInfo['ref_email'] = $request->ref_email;
            $refInfo['ref_comments'] = $request->ref_comments;

            EmployeeReference::where('id', $id)->update($refInfo);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Reference Information Successfully Updated.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Delete the employee Reference information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteReferenceInfo($id)
    {
        try {
            \DB::beginTransaction();

            $EmployeeReference = EmployeeReference::where('id', $id)->count();
            if ($EmployeeReference > 0) {
                EmployeeReference::where('id', $id)->delete();
            }

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Reference Information Successfully Deleted.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Edit the employee Nominee information.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function nomineeInfoEdit(Request $request)
    {
        $nomineeInfo = EmployeeNominee::where('id', $request->nominee_id)->first();

        echo view("Employee::nominee_edit", compact('nomineeInfo'));
    }

    /**
     * Update the employee Nominee Information.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function nomineeInfoUpdate(Request $request, $id)
    {
        try {
            \DB::beginTransaction();

            // $nomineeInfo['nominee_no'] = $request->nominee_no;
            $nomineeInfo['nominee_name'] = $request->nominee_name;
            $nomineeInfo['relation'] = $request->relation;
            $nomineeInfo['address'] = $request->address;
            $nomineeInfo['mobile_no'] = $request->mobile_no;
            $nomineeInfo['nid_birth_cert_pass'] = $request->nid_birth_cert_pass;

            if ($request->nominee_birth_date != '') {
                $nomineeInfo['nominee_birth_date'] = $request->nominee_birth_date;
            }

            $nomineeInfo['nominee_age'] = $request->nominee_age;
            $nomineeInfo['distribution_percent'] = $request->distribution_percent;

            EmployeeNominee::where('id', $id)->update($nomineeInfo);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Nominee Information Successfully Updated.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Delete the employee Nominee information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteNomineeInfo($id)
    {
        try {
            \DB::beginTransaction();

            $EmployeeNominee = EmployeeNominee::where('id', $id)->count();
            if ($EmployeeNominee > 0) {
                EmployeeNominee::where('id', $id)->delete();
            }

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Nominee Information Successfully Deleted.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Edit the project information.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function projectEdit(Request $request)
    {
        $projectInfo = EmployeeProject::where('id', $request->project_id)->first();

        echo view("Employee::project_edit", compact('projectInfo'));
    }

    /**
     * Update the project Information.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function projectUpdate(Request $request, $id)
    {
        try {
            \DB::beginTransaction();

            $project['project_title'] = $request->project_title;
            $project['details'] = $request->details;
            if ($request->completion_date != '') {
                $project['completion_date'] = $request->completion_date;
            }

            EmployeeProject::where('id', $id)->update($project);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Project Works Successfully Updated.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Delete the project information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteProject($id)
    {
        try {
            \DB::beginTransaction();

            $EmployeeProject = EmployeeProject::where('id', $id)->count();
            if ($EmployeeProject > 0) {
                EmployeeProject::where('id', $id)->delete();
            }

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Project Works Successfully Deleted.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Edit the specialization information.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function specializationEdit(Request $request)
    {
        $specializationArea = $this->makeDD(Specialization::pluck('specilized_area', 'id'));

        $specializationInfo = EmployeeSpecialization::where('id', $request->specialization_id)->first();

        echo view("Employee::specialization_edit", compact('specializationInfo', 'specializationArea'));
    }

    /**
     * Update the specialization Information.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function specializationUpdate(Request $request, $id)
    {
        try {
            \DB::beginTransaction();

            $specialization['specialization_area'] = $request->specialization_area;
            $specialization['details'] = $request->details;

            EmployeeSpecialization::where('id', $id)->update($specialization);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Specialization Successfully Updated.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Delete the project information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteSpecialization($id)
    {
        try {
            \DB::beginTransaction();

            $EmployeeSpecialization = EmployeeSpecialization::where('id', $id)->count();
            if ($EmployeeSpecialization > 0) {
                EmployeeSpecialization::where('id', $id)->delete();
            }

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Specialization Successfully Deleted.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Edit the experience information.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function experienceEdit(Request $request)
    {
        $industryTypeList = $this->makeDD(IndustryType::pluck('industry_type', 'id'));

        $experienceInfo = EmployeeExperience::where('id', $request->experience_id)->first();

        echo view("Employee::experience_edit", compact('experienceInfo', 'industryTypeList'));
    }

    /**
     * Update the experience Information.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function experienceUpdate(Request $request, $id)
    {
        try {
            \DB::beginTransaction();

            $inputs = $request->all();

            // $expInfo['serial'] = $inputs['serial'];
            $expInfo['industry_type_id'] = $inputs['industry_type_id'];
            $expInfo['designation'] = $inputs['designation'];
            $expInfo['start_date'] = $inputs['start_date'];
            $expInfo['end_date'] = $inputs['end_date'];
            $expInfo['duration'] = $inputs['duration'];
            $expInfo['job_description'] = $inputs['job_description'];
            $expInfo['organization_name'] = $inputs['organization_name'];
            $expInfo['organization_address'] = $inputs['organization_address'];
            $expInfo['supervisor_name'] = $inputs['supervisor_name'];
            $expInfo['supervisor_note'] = $inputs['supervisor_note'];
            $expInfo['contact_number'] = $inputs['contact_number'];
            $expInfo['position_reports_to'] = $inputs['position_reports_to'];
            $expInfo['last_salary'] = $inputs['last_salary'];

            EmployeeExperience::where('id', $id)->update($expInfo);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Professional Experience Successfully Updated.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Delete the project information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteExperience($id)
    {
        try {
            \DB::beginTransaction();

            $EmployeeExperience = EmployeeExperience::where('id', $id)->count();
            if ($EmployeeExperience > 0) {
                EmployeeExperience::where('id', $id)->delete();
            }

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Professional Experience Successfully Deleted.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Delete the specified employee default leave information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    private function updateEmployeeLeave($employee_id)
    {
        try {
            \DB::beginTransaction();

            $employeeDetailsData = EmployeeDetails::where('employee_id', $employee_id);

            if ($employeeDetailsData->count() > 0) {
                $employeeDetails = $employeeDetailsData->first();

                //$joinning_date =$employeeDetails->joining_date;
                $joinning_date = str_replace('/', '-', $employeeDetails->joining_date);
                $join_date = date("Y-m-d", strtotime($joinning_date));
                $joinning_year = date('Y', strtotime($join_date));

                $joinning_month = date('m', strtotime($join_date));
                $joinning_day = date('d', strtotime($join_date));

                $employeeEducation = EmployeeLeave::where('employee_id', $employee_id)->count();
                //dd($joinning_date,$join_date,$joinning_year,$joinning_month);

                if ($joinning_year == date('Y') && $employeeEducation == 0) {
                    $remaining_month = (12 - $joinning_month);
                    $remaining_day = (365 - $joinning_day);

                    $leaveTypes = LeaveType::get();

                    foreach ($leaveTypes as $leaveType) {
                        $leaveCount = $leaveType->total_leave_per_year;

                        $leaveApplied = 0;

                        if ($leaveType->eligibility_id == 1 && $leaveType->id == 1) {
                            if ($leaveType->carried_forward_status != '1')
                                //$leaveApplied = ceil(($leaveCount / 12) * $remaining_month);
                                $leaveApplied = ceil(($remaining_day * $leaveCount) / 365);
                        } else if ($leaveType->eligibility_id == 1) {
                            $leaveApplied = $leaveCount;
                        }

                        $leave['employee_id'] = $employee_id;
                        $leave['leave_type_id'] = $leaveType->id;
                        $leave['leave_balance'] = $leaveApplied;

                        $employeeLeave = EmployeeLeave::create($leave);
                    }
                } else if ($employeeEducation == 0) {
                    $leaveTypes = LeaveType::get();

                    foreach ($leaveTypes as $leaveType) {
                        $leave['employee_id'] = $employee_id;
                        $leave['leave_type_id'] = $leaveType->id;
                        $leave['leave_balance'] = $leaveType->total_leave_per_year;

                        $employeeLeave = EmployeeLeave::create($leave);
                    }
                }
            }

            \DB::commit();

            \Log::info('Employee Leave Information Successfully Updated.');

            //return redirect()->back()->with('msg-success', 'Employee Leave Information Successfully Updated.');
        } catch (\Exception $e) {
            \DB::rollback();
            // return redirect()->back()->with('msg-error', $e->getMessage());
            \Log::info($e->getMessage());
        }
    }

    /**
     * Employee default posting information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    private function employeeInitPosting($employee_id)
    {
        try {
            \DB::beginTransaction();

            $employeeInfo = EmployeeDetails::where('employee_id', $employee_id)->first();

            if ($employeeInfo->employment_type == '1')
                $ipal_flag['Increment'] = 'Increment';

            $ipal_flag['Pay Slip'] = 'Pay Slip';
            $ipal_flag['Leave'] = 'Leave';

            $tansInfo['employee_id'] = $employee_id;
            $tansInfo['branch_id'] = $employeeInfo->branch_id;
            $tansInfo['transfer_type_id'] = '1';
            $tansInfo['effective_date'] = $employeeInfo->joining_date;
            $tansInfo['handover_status'] = 'Yes';
            $tansInfo['ipal_flag'] = json_encode($ipal_flag);
            $tansInfo['posting_status'] = '1';
            $tansInfo['designation_id'] = $employeeInfo->designation_id;
            // $tansInfo['last_created_date'] = date('m/d/Y h:i:s A');

            EmployeePosting::create($tansInfo);

            EmployeePostingHistory::create($tansInfo);

            \DB::commit();

            \Log::info('Employee Default Posting Information Updated.');

            //return redirect()->back()->with('msg-success', 'Employee Leave Information Successfully Updated.');
        } catch (\Exception $e) {
            \DB::rollback();
            // return redirect()->back()->with('msg-error', $e->getMessage());
            \Log::info($e->getMessage());
        }
    }


}
