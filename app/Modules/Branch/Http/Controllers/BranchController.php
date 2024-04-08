<?php

namespace App\Modules\Branch\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Branch\Models\Branch;
use App\Modules\Branch\Models\Cluster;
use App\Modules\Division\Models\Division;
use App\Modules\District\Models\District;

use Carbon\Carbon;
use DB;

class BranchController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "settings";
    }

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $_SESSION["SubMenuActive"] = "branch";

        $branches = Branch::get();

        return view("Branch::index", compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $head = array(
            '' => '--Please Select--',
            '1' => 'Head Office',
            '2' => 'Branch',
        );
        $branchType = array(
            '' => '--Please Select--',
            '1' => 'Main Branch',
            '2' => 'Sub Branch',
        );
        $status = array(
            '' => '--Please Select--',
            '1' => 'Active',
            '2' => 'Inactive',
        );

        $branchLocation = array(
            '' => '--Please Select--',
            'Urban' => 'Urban',
            'Rural' => 'Rural',
        );

        $branchList = $this->makeDD(Branch::where('head_office', 2)->orderBy('branch_name')->pluck('branch_name', 'id'));
        $clusterList = $this->makeDD(Cluster::where('status', 1)->orderBy('cluster_name')->pluck('cluster_name', 'id'));

        return view('Branch::create', compact('head', 'branchType', 'branchList', 'status', 'branchLocation', 'clusterList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $input = $request->head_office;

        //Head Office 1 or Branch 2
        if ($input == '1') {
            $validator = \Validator::make($inputs, array(
                'branch_name' => 'required',
                'address' => 'required',
                'head_office' => 'required',
                'active_status' => 'required',
                'br_st' => 'required',
            ));
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }

            $current_date = Carbon::now();
            $current_date = $current_date->format('d-M-Y');

            $data = array(
                'branch_name' => $request->branch_name,
                'address' => $request->address,
                'head_office' => $request->head_office,
                'active_status' => $request->active_status,
                'current_date' => $current_date,
                'cbs_branch_code' => '0001',
                'br_st' => strtoupper($request->br_st),
            );
            $br = new Branch();
            $br->fill($data)->save();
            return Redirect()->to('branch')->with('msg_success', 'Branch Successfully Created');
        } else {
            // Main Branch 1 or Sub Branch 2
            $branch_type = $request->branch_type;
            if ($branch_type == '1') {
                //Main Branch
                $validator = \Validator::make($inputs, array(
                    'branch_name' => 'required',
                    'address' => 'required',
                    'head_office' => 'required',
                    'active_status' => 'required',
                    'cbs_branch_code' => 'required',
                    'br_loc' => 'required',
                    'cluster_id' => 'required',
                    'br_st' => 'required',
                    'branch_type' => 'required'
                ));
                if ($validator->fails()) {
                    return Redirect()->back()->withErrors($validator)->withInput();
                }
                $current_date = Carbon::now();
                $current_date = $current_date->format('d-M-Y');

                $data = array(
                    'branch_name' => $request->branch_name,
                    'address' => $request->address,
                    'head_office' => $request->head_office,
                    'active_status' => $request->active_status,
                    'current_date' => $current_date,
                    'cbs_branch_code' => $request->cbs_branch_code,
                    'br_loc' => $request->br_loc,
                    'br_st' => strtoupper($request->br_st),
                    'cluster_id' => $request->cluster_id
                );
                $br = new Branch();
                $br->fill($data)->save();
                return Redirect()->to('branch')->with('msg_success', 'Branch Successfully Created');
            } else {
                // Sub Branch
                $validator = \Validator::make($inputs, array(
                    'branch_name' => 'required',
                    'address' => 'required',
                    'head_office' => 'required',
                    'active_status' => 'required',
                    'cbs_branch_code' => 'required',
                    'br_loc' => 'required',
                    'cluster_id' => 'required',
                    'br_st' => 'required',
                    'branch_type' => 'required',
                    'parent_branch' => 'required'
                ));
                if ($validator->fails()) {
                    return Redirect()->back()->withErrors($validator)->withInput();
                }
                $current_date = Carbon::now();
                $current_date = $current_date->format('d-M-Y');

                $data = array(
                    'branch_name' => $request->branch_name,
                    'address' => $request->address,
                    'head_office' => $request->head_office,
                    'active_status' => $request->active_status,
                    'current_date' => $current_date,
                    'cbs_branch_code' => $request->cbs_branch_code,
                    'br_loc' => $request->br_loc,
                    'br_st' => strtoupper($request->br_st),
                    'cluster_id' => $request->cluster_id,
                    'parent_branch' => $request->parent_branch
                );
                $br = new Branch();
                $br->fill($data)->save();
                return Redirect()->to('branch')->with('msg_success', 'Branch Successfully Created');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = Branch::where('ID', $id)->first();

        $status = array(
            '' => '--Please Select--',
            '1' => 'Active',
            '2' => 'Inactive',
        );

        return view('Branch::edit', compact('branch', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $branch = Branch::where('ID', $id)->first();
        $inputs = $request->all();


        $validator = \Validator::make($inputs, array(
            'branch_name' => 'required',
            'address' => 'required',
            'br_st' => 'required',
            'active_status' => 'required'
        ));
        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }

        $current_date = Carbon::now();

        $branchInfo["branch_name"] = $request->branch_name;
        $branchInfo["address"] = $request->address;
        $branchInfo["br_st"] = $request->br_st;
        $branchInfo["active_status"] = $request->active_status;
        $branchInfo["updated_at"] = $current_date->format('d-M-Y');

        Branch::where('ID', $id)->update($branchInfo);
        return Redirect()->to('branch')->with('msg_success', 'Branch Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Branch::destroy($id);
            return Redirect()->to('branch')->with('msg-success', 'Successfully Deleted.');
        } catch (\Exception $e) {
            return Redirect()->to('branch')->with('msg-error', "This item is already used.");
        }
    }

    public function getDistricts(Request $request)
    {
        $data = District::where([['division_id', '=', $request->division_id]])
            ->get();

        $option = "";
        foreach ($data as $key => $value) {
            $option .= '<option value=' . $value->id . ' >' . $value->name . '</option>';
        }
        return $option;
    }
}
