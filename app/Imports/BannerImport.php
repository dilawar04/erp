<?php

namespace App\Imports;

use App\Banner;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BannerImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'image' => $row['image'],
                        'title' => $row['title'],
                        'type' => $row['type'],
                        'rel_id' => $row['rel_id'],
                        'link' => $row['link'],
                        'ordering' => $row['ordering'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                        'status' => $row['status'],
                        'description' => $row['description'],
                    ];

        return new Banner($_data);
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