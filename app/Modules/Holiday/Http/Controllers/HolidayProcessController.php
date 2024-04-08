<?php

namespace App\Modules\Holiday\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Holiday\Models\Holiday;


class HolidayProcessController extends Controller
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
        return Redirect() -> back()-> with('msg_success', ' Yearly Holiday Successfully Updated');

    }


    public function CsvIndex()
    {
        return view("Holiday::csv_from");
    }

    public function DownloadDemoCSv()
    {
        $csvFilePath = public_path('demoCsv/HolidayCSVFileSample.csv');
        return response()->download($csvFilePath, 'Holiday_CSV_File_Sample.csv');
    }
    public  function CsvIport(Request $request)
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


                foreach ($csv_data as $row) {
                    $date = date('d/m/Y', strtotime($row[0]));
                    $formattedDate = date('Y-m-d', strtotime($row[0]));
                    Holiday::updateOrCreate(
                        ['holiday_date' => $formattedDate],
                        ['description' => $row[1]]
                    );
                }
              return redirect()->to('/holiday')->with('msg_success', 'CSV data imported successfully.');
            } else {
                return redirect()->back()->with('msg_error', 'Invalid file.');
            }
        } else {
            return redirect()->back()->with('msg_error', 'No file provided.');
        }
    }
}




