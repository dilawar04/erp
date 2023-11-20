<?php

namespace App\Imports;

use App\Machine;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MachineImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'machine_id' => $row['machine_id'],
                        'name' => $row['name'],
                        'code' => $row['code'],
                        'serial_no' => $row['serial_no'],
                        'make' => $row['make'],
                        'model' => $row['model'],
                        'year' => $row['year'],
                        'purchase_date' => $row['purchase_date'],
                        'installation_date' => $row['installation_date'],
                        'workstation_id' => $row['workstation_id'],
                        'warranty_type' => $row['warranty_type'],
                        'status' => $row['status'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                        'deleted_at' => $row['deleted_at'],
                    ];

        return new Machine($_data);
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