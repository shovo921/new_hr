<?php

namespace App\Modules\FestivalBonus\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\FestivalBonus\Models\BonusType;
use App\Modules\FestivalBonus\Models\FestivalBonus;
use App\Modules\Payroll\Models\PayType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Modules\Holiday\Models\Holiday;


class FestivalBonusProcessController extends Controller
{
    public function HolidayProcess()
    {

        $currentYear = now()->year;

        $startDate = $currentYear . '-01-01';
        $endDate = ($currentYear + 1) . '-01-01';

        for ($date = $startDate; $date < $endDate; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
            $dayOfWeek = date('N', strtotime($date));

            // Check if the current day is Saturday (6) or Friday (5)
            if ($dayOfWeek == 6 || $dayOfWeek == 5) {
                $description = ($dayOfWeek == 6) ? 'Saturday' : 'Friday';

                $existingHoliday = Holiday::where('holiday_date', $date)->first();

                if ($existingHoliday) {
                    $existingHoliday->update(['description' => $description]);
                } else {
                    Holiday::create(['holiday_date' => $date, 'description' => $description]);
                }
            }
        }
        return Redirect()->back()->with('msg_success', ' Yearly Holiday Successfully Updated');

    }
    public function CsvIndex()
    {
        $FestivalBonus = null;
        $data['pay_type'] = PayType::all()->pluck('description', 'ptype_id');
        $data['bonus_type'] = BonusType::all()->pluck('type', 'id');
        return view("FestivalBonus::csv_from", compact('FestivalBonus', 'data'));
    }

    public function DownloadDemoCSv()
    {
        $csvFilePath = public_path('demoCsv/HolidayCSVFileSample.csv');
        return response()->download($csvFilePath, 'Holiday_CSV_File_Sample.csv');
    }

    public function CsvIport(Request $request)
    {

        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');

            if ($file->isValid()) {
                $path = $file->getRealPath();

                $data = array_map('str_getcsv', file($path));
                $csv_data = array_slice($data, 1);


                $bonus = new FestivalBonus();
                foreach ($csv_data as  $key => $row) {

                    $validator= $this->statusvalidator($row);
                    if ($validator->fails()) {
                        $csv_file = $validator->errors()->all();
                        return redirect()->back()->withErrors($csv_file);
                    }

                    $branch_id = EmployeeDetails::where('EMPLOYEE_ID', $row[0])->first();

                    $bonusData = [
                        'amount' => $row[1],
                        'branch_id' => $branch_id->branch_id,
                        'status' => strtolower(trim(preg_replace('/\s+/', '', $row[2]))) == "yes" ? 2 : 3,
                        'bonus_type' => $request->bonus_type,
                        'pay_type_id' => $request->pay_type,
                        'payment_date' => $request->payment_date,
                        'remarks' => $row[3]
                    ];

                    FestivalBonus::updateOrCreate(
                        ['employee_id' => $row[0]],
                        $bonusData
                    );


                }
                return redirect()->to('/FestivalBonus')->with('msg_success', 'CSV data imported successfully.');
            } else {
                return redirect()->back()->with('msg_error', 'Invalid file.');
            }
        } else {
            return redirect()->back()->with('msg_error', 'No file provided.');
        }
    }

    public function statusvalidator($row)
    {
        $validator = Validator::make($row, [
//            'row[0]' => 'required|unique|max:255', // Assuming 'value' is the key for $row[2]

        ]);
        $validator->after(function ($validator) use ($row) {
            $value = strtolower(trim(preg_replace('/\s+/', '', $row[2])));
            if ($value !== 'yes' && $value !== 'no') {
                $validator->errors()->add('value', 'The excel status value must be "yes" or "no".');
            }
        });

        return $validator;
    }
}




