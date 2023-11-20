<?php

namespace App\Imports;

use App\Menu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MenuImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
            'id' => $row['id'],
            'parent_id' => $row['parent_id'],
            'menu_title' => $row['menu_title'],
            'menu_link' => $row['menu_link'],
            'menu_type' => $row['menu_type'],
            'menu_type_id' => $row['menu_type_id'],
            'ordering' => $row['ordering'],
            'params' => $row['params'],
            'status' => $row['status'],
        ];

        return new Menu($_data);
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $c => $row) {
            if ($c > ($this->headingRow() - 1)) {
                return $this->model($row->toArray());
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
