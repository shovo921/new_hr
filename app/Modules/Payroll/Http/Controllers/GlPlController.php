<?php

namespace App\Modules\Payroll\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Payroll\Models\DeductionType;
use App\Modules\Payroll\Models\GlPl;
use App\Modules\Payroll\Models\PayType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class GlPlController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
    }

    /**
     * Display the module welcome screen
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $_SESSION["SubMenuActive"] = "payroll-settings-gl-pl";
        $gl_pl_lists = GlPl::get();

        return view('Payroll::GLPL/index', compact('gl_pl_lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $_SESSION["SubMenuActive"] = "payroll-settings-gl-pl";
        $pay_type_list = $this->makeDD(PayType::where('status', 'A')->pluck('description', 'ptype_id'));
        $deduction_type_list = $this->makeDD(DeductionType::where('status', 'A')->pluck('description', 'dtype_id'));

        $head_type = array(
            '' => '-- Please Select --',
            'P' => 'Payment Type',
            'D' => 'DeductionType'
        );

        $gl_pl = array(
            '' => '-- Please Select --',
            'GL' => 'GL',
            'PL' => 'PL'
        );

        $status = array(
            '' => '-- Please Select --',
            '1' => 'Active',
            '2' => 'Inactive'
        );

        return view('Payroll::GLPL/create', compact('head_type', 'status', 'gl_pl', 'pay_type_list', 'deduction_type_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $_SESSION["SubMenuActive"] = "payroll-settings-gl-pl";
            $inputs = $request->all();

            $validator = \Validator::make($inputs, array(
                'head_type' => 'required',
                'gl_pl' => 'required',
                'gl_pl_no' => 'required',
                'status' => 'required|int'
            ));

            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }

            if (!empty($request->ptype_id)) {
                $data = array(
                    'head_type' => $request->head_type,
                    'gl_pl' => $request->gl_pl,
                    'head_id' => (int)$request->ptype_id,
                    'gl_pl_no' => $request->gl_pl_no,
                    'status' => (int)$request->status
                );
            } else {
                $data = array(
                    'head_type' => $request->head_type,
                    'gl_pl' => $request->gl_pl,
                    'head_id' => (int)$request->dtype_id,
                    'gl_pl_no' => $request->gl_pl_no,
                    'status' => (int)$request->status
                );
            }

            $gl_pl = new GlPl();
            $gl_pl->fill($data)->save();
            return Redirect()->back()->with('msg-success', 'GLPL Account Successfully Created');
        } catch (\Exception $e) {
            \Log::Info('GlPlController-Store' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return void
     */
    public function show(Request $request)
    {

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $_SESSION["SubMenuActive"] = "payroll-settings-gl-pl";

        $pay_type_list = $this->makeDD(PayType::where('status', 'A')->pluck('description', 'ptype_id'));
        $deduction_type_list = $this->makeDD(DeductionType::where('status', 'A')->pluck('description', 'dtype_id'));


        $gl_pl_list = GlPl::findOrFail($id);
        $head_type = array(
            '' => '-- Please Select --',
            'P' => 'Payment Type',
            'D' => 'DeductionType'
        );

        $gl_pl = array(
            '' => '-- Please Select --',
            'GL' => 'GL',
            'PL' => 'PL'
        );

        $status = array(
            '' => '-- Please Select --',
            '1' => 'Active',
            '2' => 'Inactive'
        );

        return view('Payroll::GLPL/edit', compact('gl_pl_list', 'status', 'head_type', 'gl_pl', 'pay_type_list', 'deduction_type_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        GlPl::findOrFail($id);
        $inputs = $request->all();


        $validator = \Validator::make($inputs, array(
            'gl_pl' => 'required',
            'gl_pl_no' => 'required',
            'status' => 'required'
        ));

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }

        if (!empty($inputs['ptype_id'])) {
            $data = array(
                'head_type' => "P",
                'gl_pl' => $request->gl_pl,
                'head_id' => (int)$request->ptype_id,
                'gl_pl_no' => $request->gl_pl_no,
                'status' => (int)$request->status
            );
        } else {
            $data = array(
                'head_type' => "D",
                'gl_pl' => $request->gl_pl,
                'head_id' => (int)$request->dtype_id,
                'gl_pl_no' => $request->gl_pl_no,
                'status' => (int)$request->status
            );
        }

        GlPl::find($id)->update($data);

        return Redirect()->back()->with('msg-success', 'GLPL Account Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        /*        try {
                    Division::destroy($id);
                    return Redirect() -> route('division.index') -> with('msg-success', 'Successfully Deleted.');
                }
                catch (\Exception $e) {
                    return Redirect() -> route('division.index') -> with('msg-error', "This item is already used.");
                }*/
    }

    /**
     * This function will return Head information based on type
     *
     * @param Request $request
     * @return array|string[]
     */
    public function getHead(Request $request)
    {
        $_SESSION["SubMenuActive"] = "payroll-settings-gl-pl";

        $pay_type_list = $this->makeDD(PayType::where('status', 'A')->pluck('description', 'ptype_id'));
        $deduction_type_list = $this->makeDD(DeductionType::where('status', 'A')->pluck('description', 'dtype_id'));
        if ($request->typeId == 'P') {
            return $pay_type_list;
        } else {
            return $deduction_type_list;
        }
    }
}
