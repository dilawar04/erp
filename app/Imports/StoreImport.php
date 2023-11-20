<?php

namespace App\Imports;

use App\Store;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StoreImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'name' => $row['name'],
                        'type' => $row['type'],
                        'store_location_type' => $row['store_location_type'],
                        'store_material_type' => $row['store_material_type'],
                        'location' => $row['location'],
                        'no_of_blocks' => $row['no_of_blocks'],
                        'mode_storages' => $row['mode_storages'],
                        'series_type' => $row['series_type'],
                        'address' => $row['address'],
                        'country' => $row['country'],
                        'city' => $row['city'],
                        'state' => $row['state'],
                        'postal_code' => $row['postal_code'],
                        'store_in_charge_name' => $row['store_in_charge_name'],
                        'contact' => $row['contact'],
                        'status' => $row['status'],
                        'created_at' => $row['created_at'],
                        'udated_at' => $row['udated_at'],
                        'deleted_at' => $row['deleted_at'],
                    ];

        return new Store($_data);
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