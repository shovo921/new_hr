<?php

namespace App\Modules\DisciplinaryAction\Http\Controllers;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\User;
use App\Modules\DisciplinaryAction\Models\DisciplinaryAction;
use App\Modules\DisciplinaryAction\Models\DisciplinaryActionHistory;
use App\Modules\DisciplinaryAction\Models\DisciplinaryPunishments;
use App\Modules\DisciplinaryAction\Models\DisciplinaryActionAttachment;
use App\Modules\DisciplinaryCategory\Models\DisciplinaryCategory;
use App\Modules\Employee\Models\EmployeeDetails;

use DB;
use Illuminate\Http\Response;

class DisciplinaryActionController extends Controller
{

    public function __construct()
    {
        $_SESSION["MenuActive"] = "disciplinary-action";
    }

    /**
     * Display the module welcome screen
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $_SESSION["SubMenuActive"] = "disciplinaryAction";

        $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');

        $employeeList = $this->makeDD($employeeData);


        $disciplinaryActions = $this->__allDisciplinaryActionFilter($request);

//        $disciplinaryActions = DisciplinaryAction::get();


        return view("DisciplinaryAction::index", compact('disciplinaryActions', 'employeeList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $_SESSION["SubMenuActive"] = "addDisciplinaryAction";
        $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');

        $employeeList = $this->makeDD($employeeData);
        $disciplinaryCategory = DisciplinaryCategory::where('status', 1)->pluck('name', 'id');

        $status = array(
            '' => '-- Please Select --',
            '1' => 'Running',
            '2' => 'Closed',
        );

        $type = array(
            '' => '-- Please Select --',
            '1' => 'Minor',
            '2' => 'Major',
        );

        $final_action_type_list = $this->makeDD(DisciplinaryPunishments::where('status', 1)->pluck('punishments', 'id'));


        return view('DisciplinaryAction::create', compact('employeeList', 'disciplinaryCategory', 'status', 'type', 'final_action_type_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $inputs = $request->all();



        $validator = \Validator::make($inputs, array(
            'employee_id' => 'required',
            'dis_cat_id' => 'required|int',
            'action_details' => 'required',
            'status' => 'required|int'
        ));

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }

        $action_start_date = str_replace('/', '-', $request->action_start_date);
        $action_end_date = str_replace('/', '-', $request->action_start_date);
        $start_date = str_replace('/', '-', $request->action_start_date);
        $end_date = str_replace('/', '-', $request->action_start_date);

        $data = array(
            'employee_id' => $request->employee_id,
            'action_type' => (int)$request->action_type,
            'status' => (int)$request->status,
            'dis_cat_id' => (int)$request->dis_cat_id,
            'action_taken_id' => (int)$request->action_taken_id,
            'action_start_date' => date('Y-m-d', strtotime($action_start_date)),
            'action_end_date' => date('Y-m-d', strtotime($action_end_date)),
            'start_date' => date('Y-m-d', strtotime($start_date)),
            'end_date' => date('Y-m-d', strtotime($end_date)),
            'created_by' => auth()->user()->id,
            'action_details' => $request->action_details,
            'remarks' => $request->remarks
        );

        $disciplinaryAction = new DisciplinaryAction();
        $disciplinaryAction->fill($data)->save();
        if (!empty($request->images)) {
            $allowedfileExtension = ['pdf', 'jpg', 'png', 'docx'];
            $files = $request->file('images');
            $time = date('Ymdhis', strtotime(Carbon::now()));
            $i = 0;
            foreach ($files as $image) {
                $path = public_path('uploads/employeedata/' . $request->employee_id . '/disciplinaryaction/' . $disciplinaryAction->id);
                $i = $i + 1;
                $filename = $disciplinaryAction->id . '_' . $time . $i . '.' . $image->extension();
//                    $filename = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);

                if ($check) {
                    $image->move($path, $filename);
                    $attachedFile = array(
                        'attachment' => $filename,
                        'uploaded_at' => Carbon::now(),
                        'dis_id' => $disciplinaryAction->id
                    );
                    $disciplinaryActionAttachment = new DisciplinaryActionAttachment();
                    $disciplinaryActionAttachment->fill($attachedFile)->save();

                } else {
                    return Redirect()->back()->with('msg-error', 'Invalid format, Please use se pdf,jpg,png,docx');
                }

            }
            return Redirect()->to('disciplinaryAction')->with('msg-success', 'Disciplinary Action Successfully Created');
        } else {
            return Redirect()->to('disciplinaryAction')->with('msg-success', 'Disciplinary Action Successfully Created');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $disciplinaryAction = DisciplinaryAction::where('id', $id)->firstOrFail();
        return view('DisciplinaryAction::view', compact('disciplinaryAction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $disciplinaryAction = DisciplinaryAction::where('id', $id)->firstOrFail();
        $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');
        $employeeList = $this->makeDD($employeeData);
        $disciplinaryCategory = DisciplinaryCategory::where('status', 1)->pluck('name', 'id');

        $status = array(
            '' => '-- Please Select --',
            '1' => 'Running',
            '2' => 'Closed',
        );

        $type = array(
            '' => '-- Please Select --',
            '1' => 'Minor',
            '2' => 'Major',
        );

        $final_action_type_list = $this->makeDD(DisciplinaryPunishments::where('status', 1)->pluck('punishments', 'id'));

        $disciplinaryActionAttachment = DisciplinaryActionAttachment::where('dis_id', $id)->get();

        return view('DisciplinaryAction::edit', compact('disciplinaryAction', 'employeeList', 'disciplinaryCategory', 'status', 'type', 'final_action_type_list', 'disciplinaryActionAttachment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        try {
            $DisciplinaryAction = DisciplinaryAction::where('id', $id)->firstOrFail();
            $inputs = $request->all();
            $validator = \Validator::make($inputs, array(
                'employee_id' => 'required',
                'dis_cat_id' => 'required|int',
                'action_details' => 'required',
                'status' => 'required|int'
            ));

            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            if ($request->action_start_date != '') {
                $action_start_date = str_replace('/', '-', $request->action_start_date);
                $action_start_date = date('Y-m-d', strtotime($action_start_date));

            } else {
                $action_start_date = $request->action_start_date;
            }
            if ($request->action_end_date != '') {
                $action_end_date = str_replace('/', '-', $request->action_end_date);
                $action_end_date = date('Y-m-d', strtotime($action_end_date));

            } else {
                $action_end_date = $request->action_end_date;
            }
            if ($request->start_date != '') {
                $start_date = str_replace('/', '-', $request->start_date);
                $start_date = date('Y-m-d', strtotime($start_date));

            } else {
                $start_date = $request->start_date;
            }
            if ($request->end_date != '') {
                $end_date = str_replace('/', '-', $request->end_date);
                $end_date = date('Y-m-d', strtotime($end_date));

            } else {
                $end_date = $request->end_date;
            }

            $data = array(
                'employee_id' => $DisciplinaryAction->employee_id,
                'action_type' => (int)$request->action_type,
                'status' => (int)$request->status,
                'dis_cat_id' => (int)$request->dis_cat_id,
                'action_taken_id' => (int)$request->action_taken_id,
                'action_start_date' => $action_start_date,
                'action_end_date' => $action_end_date,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now(),
                'action_details' => $request->action_details,
                'remarks' => $request->remarks
            );

            DisciplinaryAction::where('id', $id)->firstOrFail()->update($data);

            #Attachment
            if (!empty($request->images)) {
                $allowedfileExtension = ['pdf', 'jpg', 'png', 'docx'];
                $files = $request->file('images');
                $time = date('Ymdhis', strtotime(Carbon::now()));
                $i = 0;
                foreach ($files as $image) {
                    $path = public_path('uploads/employeedata/' . $DisciplinaryAction->employee_id . '/disciplinaryaction/' . $id);
                    $i = $i + 1;
                    $filename = $id . '_' . 'update' . $time . $i . '.' . $image->extension();
//                    $filename = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $check = in_array($extension, $allowedfileExtension);

                    if ($check) {
                        $image->move($path, $filename);
                        $attachedFile = array(
                            'attachment' => $filename,
                            'uploaded_at' => Carbon::now(),
                            'dis_id' => $id
                        );
                        $disciplinaryActionAttachment = new DisciplinaryActionAttachment();
                        $disciplinaryActionAttachment->fill($attachedFile)->save();

                    } else {
                        return Redirect()->back()->with('msg-error', 'Invalid format, Please use se pdf,jpg,png,docx');
                    }

                }
                return Redirect()->back()->with('msg-success', 'Disciplinary Action Successfully Updated');
            } else {
                return Redirect()->back()->with('msg-success', 'Disciplinary Action Successfully Updated');
            }

            return Redirect()->back()->with('msg-success', 'Disciplinary Action Successfully Updated.');

        } catch (\Exception $e) {
            return Redirect()->back()->with('msg-error', "No Match Found");
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($employee_id)
    {
        try {
            $model = DisciplinaryAction::where('employee_id', $employee_id)->firstOrFail();
            $model->delete();
            return Redirect()->back()->with('msg-success', 'Successfully Deleted.');
        } catch (\Exception $e) {
            return Redirect()->back()->with('msg-error', "This item is already used.");
        }
    }

    /**
     * Display the module welcome screen
     *
     * This function will show employee history
     *
     * @return Response
     */
    public function disciplinaryActionHistory($employee_id)
    {
        $_SESSION["SubMenuActive"] = "disciplinaryAction";

        $actionHistoryList = DisciplinaryAction::where('employee_id', $employee_id)->get();
        return view("DisciplinaryAction::actionHistory", compact('actionHistoryList'));
    }

    /**
     * Display the module welcome screen
     *
     * @return string
     */
    public function disciplinaryPunishments(Request $request)
    {
        $data = DisciplinaryPunishments::select('punishments', 'id')
            ->where('type', $request->typeId)
            ->where('status', 1)
            ->get();



        $option = '<option value="">--Please Select--</option>';


        foreach ($data as $key => $value) {
            $option .= '<option value=' . $value->id . ' >' . $value->punishments . '</option>';
        }
        return $option;

    }

    /**
     * Display the module welcome screen
     *
     * @return Response
     */

     private function __allDisciplinaryActionFilter($request)
     {
             $disciplinaryActions = DisciplinaryAction::query();


             if ($request->filled('employee_id')) {
                 $disciplinaryActions->where('employee_id', $request->employee_id);
             }


         return $disciplinaryActions->orderBy('created_at', 'desc')->paginate(10);
     }

}
