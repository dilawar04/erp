<?php

namespace App\Imports;

use App\ModePackaging;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ModePackagingImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'title' => $row['title'],
                        'status' => $row['status'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                        'deleted_at' => $row['deleted_at'],
                    ];

        return new ModePackaging($_data);
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