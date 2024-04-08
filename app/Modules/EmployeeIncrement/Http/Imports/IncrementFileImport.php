<?php

namespace App\Modules\EmployeeIncrement\Http\Imports;

use App\Modules\EmployeeIncrement\Models\IncrementFile;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

// MODELS


class IncrementFileImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new IncrementFile([
            'employee_id' => $row['Employee_ID'],
            'increment_count' => $row['Increment_Count'],
        ]);
    }

    /**
     * Heading row on different row
     * In case your heading row is not on the first row, you can easily specify this.
     * The 2nd row will now be used as heading row.
     */
    public function headingRow(): int
    {
        return 1;
    }
}
