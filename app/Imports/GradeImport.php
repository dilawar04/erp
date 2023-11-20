<?php

namespace App\Imports;

use App\Grade;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GradeImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'name' => $row['name'],
                        'salary_range_from' => $row['salary_range_from'],
                        'salary_range_to' => $row['salary_range_to'],
                        'allowance_id' => $row['allowance_id'],
                        'employee_contribution' => $row['employee_contribution'],
                        'employers_contribution' => $row['employers_contribution'],
                        'total' => $row['total'],
                        'leaves_id' => $row['leaves_id'],
                        'status' => $row['status'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                        'deleted_at' => $row['deleted_at'],
                    ];

        return new Grade($_data);
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