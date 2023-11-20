<?php

namespace App\Imports;

use App\OperationProcessParameter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OperationProcessParameterImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'product_id' => $row['product_id'],
                        'workstation_id' => $row['workstation_id'],
                        'opration_id' => $row['opration_id'],
                        'instruction' => $row['instruction'],
                        'parameter' => $row['parameter'],
                        'value' => $row['value'],
                        'tolerance' => $row['tolerance'],
                        'type' => $row['type'],
                        'status' => $row['status'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                        'deleted_at' => $row['deleted_at'],
                    ];

        return new OperationProcessParameter($_data);
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