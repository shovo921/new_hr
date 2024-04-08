<?php

namespace App\Modules\EmployeeKpi\Http\Controllers;

use App\Functions\EmployeeFunction;
use App\Http\Controllers\Controller;
use App\Modules\EmployeeKpi\Models\EmployeeKpi;
use App\Modules\EmployeeKpi\Models\KpiFields;
use Illuminate\Http\Request;


class EmployeeKpiController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "employee";
    }

    public function index()
    {
        $data['employeeKpi'] = EmployeeKpi::get();
        return view('EmployeeKpi::index', compact('data'));
    }

    public function createOrEdit($id)
    {
        $data['employeeKpi'] = empty($id) ? null : EmployeeKpi::findOrFail($id);
        $data['allEmployees'] = $this->makeDD(EmployeeFunction::allEmployees());
        $data['kpiFields'] = KpiFields::where('status', 1)->get();
        return view('EmployeeKpi::createOrUpdate', compact('data'));
    }

    public function kpiData($request, $object)
    {


        $allFields = [];
        $allFieldsFromView = [];

// Extract field names from $object
        foreach ($object as $key => $singleObject) {
            $allFields[] = $singleObject->field_name;
            $allFieldsId[$singleObject->field_name] = $singleObject->id;
        }

// Extract field names from $request
        foreach ($request as $key1 => $singleRequest) {
            $allFieldsFromView[] = $key1;
        }

        $matchedValues = [];

        foreach ($allFields as $kpiField) {
            // Sanitize the field names by removing spaces, underscores, and commas
            $sanitizedKpiField = preg_replace('/[\s_,]/', '', $kpiField);
            foreach ($allFieldsFromView as $fieldFromView) {
                // Sanitize the field name from the view similarly
                $sanitizedFieldFromView = preg_replace('/[\s_,]/', '', $fieldFromView);
                if (strcasecmp($sanitizedKpiField, $sanitizedFieldFromView) === 0) {
                    // If the sanitized field names match, add the original field from the view to the matched values array
                    // Also, include the corresponding value from the request
                    $matchedValues[$allFieldsId[$kpiField]] = $request[$fieldFromView];
                    break;
                }
            }
        }

// $matchedValues now contains the matched field names as keys, their corresponding values from the request,
// and their corresponding IDs from $object

        $kpiData['kpiScores'] = empty($matchedValues) ? null : $matchedValues;
        return json_encode($kpiData, JSON_PRETTY_PRINT);

    }

    public function storeOrUpdate(Request $request)
    {
        try {

            $kpiFields = KpiFields::get();
            $inputs = $request->all();
            $getData = $this->kpiData($inputs, $kpiFields);

            // Validation rules
            $rules = [
                'employee_id' => 'required',
                'kpi_year' => 'required|integer',
            ];

            if (!empty($request->id)) {
                $rules['employee_id'] .= '|unique:employee_kpi,employee_id,' . $request->id . ',id,kpi_year,' . $inputs['kpi_year'];
                $rules['kpi_year'] .= '|unique:employee_kpi,kpi_year,' . $request->id . ',id,employee_id,' . $inputs['employee_id'];
            } else {
                // For creation mode
                $rules['employee_id'] .= '|unique:employee_kpi,employee_id,NULL,id,kpi_year,' . $inputs['kpi_year'];
                $rules['kpi_year'] .= '|unique:employee_kpi,kpi_year,NULL,id,employee_id,' . $inputs['employee_id'];
            }

            // Validate inputs
            $validator = \Validator::make($inputs, $rules);

            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }

            $addOrUpdateData = [
                'employee_id' => $inputs['employee_id'],
                'kpi_year' => $inputs['kpi_year'],
                'status' => $inputs['status'],
                'kpi_data' => $getData,

            ];

            $validator = \Validator::make($inputs, array(
                'employee_id' => 'required'
            ));
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }

            $employeeKpi = empty($request->id) ? new EmployeeKpi() : EmployeeKpi::findOrFail($request->id);
            $employeeKpi->fill($addOrUpdateData)->save();

            if (empty($request->id)) {
                return Redirect()->back()->with('msg-success', 'Employee KPI information Successfully Created');
            } else {
                return Redirect()->back()->with('msg-success', 'Employee KPI information Successfully Updated');
            }
        } catch (\Exception $e) {
            \Log::info('EmployeeKpiController-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function destroy($id): RedirectResponse
    {
        try {
            EmployeeKpi::findOrFail($id)->delete();
            return Redirect()->back()->with('msg-success', 'Employee KPI information Successfully Deleted');

        } catch (\Exception $e) {
            \Log::info('EmployeeKpiController-destroy-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

}
