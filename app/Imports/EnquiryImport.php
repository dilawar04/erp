<?php

namespace App\Imports;

use App\Enquiry;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EnquiryImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'name' => $row['name'],
                        'email' => $row['email'],
                        'message' => $row['message'],
                        'status' => $row['status'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                    ];

        return new Enquiry($_data);
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