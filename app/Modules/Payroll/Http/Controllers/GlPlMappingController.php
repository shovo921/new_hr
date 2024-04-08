<?php

namespace App\Modules\Payroll\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Payroll\Models\GlPlInfoView;
use App\Modules\Payroll\Models\GlPlMapping;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * EmployeeAllowanceController
 * Created By
 * Pronab Kumer Roy
 * Senior Officer
 * Date: 01-03-2022
 * This is used for the operation of Employee Allowance
 */
class GlPlMappingController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
        $_SESSION['SubMenuActive'] = "payroll-allowance";
    }

    public function index()
    {
        $data['glPlMapping'] = GlPlMapping::get();
        return view('Payroll::GLPL/Mapping/index', compact('data'));
    }

    public function createOrEdit($id)
    {
        $data['glPlInfo'] = $this->makeDD(GlPlInfoView::select(DB::raw("(glplinfo) glplinfo"), 'id')
            ->pluck('glplinfo', 'id'));
        $data['office'] = [
            '' => 'Please Select',
            1 => 'Head Office',
            2 => 'Branch',

        ];
        if (empty($id)) {
            $data['glPlMapping'] = null;
        } else {
            $data['glPlMapping'] = GlPlMapping::findOrFail($id);
        }
        return View('Payroll::GLPL/Mapping/createOrUpdate', compact('data'));
    }

    public function storeOrUpdateData($requestedData): array
    {
        $request = $requestedData->all();
            $mappingData = [
                'dac_id' => $request['dac_id'],
                'cac_id' => $request['cac_id'],
                'office' => $request['office'],
                'created_by' => auth()->user()->id,
            ];

        return empty($mappingData) ? [] : $mappingData;
    }

    public function StoreOrUpdate(Request $request): RedirectResponse
    {
        try {
            $glPlMapping = new GlPlMapping();
            if (empty($request->id)) {
                $glPlMapping->fill($this->storeOrUpdateData($request))->save();
                return Redirect()->route('glPlMapping.index')->with('msg-success', 'Data Added Successfully');

            } else {
                $glPlMapping->findOrFail($request->id)->fill($this->storeOrUpdateData($request))->save();
                return Redirect()->route('glPlMapping.index')->with('msg-success', 'Data Updated Successfully');
            }

        } catch (\Exception $e) {
            \Log::info('GlPlMappingController-StoreOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }


    public function destroy($id)
    {
        try {
            GlPlMapping::destroy($id);
            return Redirect()->route('glPlMapping.index')->with('msg-success', 'Data Successfully Deleted');
        } catch (\Exception $e) {
            \Log::info('GlPlMappingController-Delete-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

}