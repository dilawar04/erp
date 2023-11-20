<?php

namespace App\Imports;

use App\Package;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PackageImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'title' => $row['title'],
                        'description' => $row['description'],
                        'price' => $row['price'],
                        'currency' => $row['currency'],
                        'info' => $row['info'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                        'status' => $row['status'],
                        'ordering' => $row['ordering'],
                    ];

        return new Package($_data);
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