<?php

namespace App\Imports;

use App\ShiftOvertime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShiftOvertimeImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'shift_name' => $row['shift_name'],
                        'start_time' => $row['start_time'],
                        'end_time' => $row['end_time'],
                        'late_till' => $row['late_till'],
                        'half_day_from' => $row['half_day_from'],
                        'brake_name' => $row['brake_name'],
                        'b_from' => $row['b_from'],
                        'b_till' => $row['b_till'],
                        'days' => $row['days'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                        'deleted_at' => $row['deleted_at'],
                    ];

        return new ShiftOvertime($_data);
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $c => $row) {
            if($c > ($this->headingRow() - 1)) {
                return $this->model($row->toArray());
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
