<?php

namespace App\Modules\Designation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Designation\Models\Designation;
use App\Modules\Employee\Models\EmploymentType;
use App\Modules\Division\Models\Division;
use App\Modules\District\Models\District;

use Carbon\Carbon;

use DB;

class DesignationController extends Controller
{
	public function __construct(){
		$_SESSION["MenuActive"] = "settings";
	}
    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$_SESSION["SubMenuActive"] = "designation";


        //$designation = Designation::all()->sortBy('sorting_order');
        $designation = Designation::where('deleted_at',null)->orderby('seniority_order')->get();

        /*$sql = "SELECT A.DESIGNATION, A.SHORTCODE, A.EMPLOYMENT_TYPE, A.SORTING_ORDER, A.ID, B.EMPLOYMENT_TYPE FROM DESIGNATION A LEFT JOIN EMPLOYMENT_TYPES B ON A.EMPLOYMENT_TYPE=B.ID ORDER BY SORTING_ORDER ASC";
        $designation = DB::connection('oracle')->select($sql);
        */
        
        return view("Designation::index", compact('designation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$employmentType = $this->makeDD(EmploymentType::pluck('employment_type', 'id'));
    	return view('Designation::create', compact('employmentType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

    	$validator = \Validator::make($inputs, array(
    		'designation'=>'required', 
    		'shortcode'=>'required', 
    		'employment_type'=>'required|int',
    		'sorting_order'=>'required|numeric'
    	));

        $data['designation']=$inputs['designation'];
        $data['shortcode']=$inputs['shortcode'];
        $data['sorting_order']=$inputs['sorting_order'];
        $data['employment_type']=$inputs['employment_type'];
        $data['seniority_order']=$inputs['sorting_order'];
        $data['created_at']=Carbon::now();

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

        //$inputs['created_at'] = Carbon::now();

    	$designation = new Designation();
    	$designation->fill($data)->save();

    	return Redirect() -> to('designation') -> with('msg_success', 'Designation Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$designation = Designation::findOrFail($id);

    	$employmentType = $this->makeDD(EmploymentType::pluck('employment_type', 'id'));

    	return view('Designation::edit',compact('designation', 'employmentType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $designation = Designation::findOrFail($id);
    	$inputs = $request->all();

    	$validator = \Validator::make($inputs, array(
    		'designation'=>'required', 
    		'shortcode'=>'required', 
    		'employment_type'=>'required|int',
    		'sorting_order'=>'required|numeric'
    	));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
        }
        $designationInfo["designation"] = $request->designation;
        $designationInfo["shortcode"] = $request->shortcode;
        $designationInfo["employment_type"] = $request->employment_type;
        $designationInfo["sorting_order"] = $request->sorting_order;
        $designationInfo["seniority_order"] = $request->sorting_order;
        $branchInfo["updated_at"] = Carbon::now();

        //Designation::where('id', $id)->update($designationInfo);
        Designation::find($id)->update($designationInfo);

    	return Redirect() -> to('designation') -> with('msg_success', 'Designation Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	try {
            $model = Designation::find( $id );
            $model->delete();
    		return Redirect() -> route('designation.index') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
    		return Redirect() -> route('designation.index') -> with('msg-error', "This item is already used.");
    	}
    }

    public function getDistricts(Request $request) {
        $data = District::where([['division_id','=',$request->division_id]])
        ->get();

        $option = "";
        foreach ($data as $key => $value) {
            $option .= '<option value='.$value->id.' >'.$value->name.'</option>';
        }
        return $option;
    }
}
