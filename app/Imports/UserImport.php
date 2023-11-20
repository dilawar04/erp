<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
            'user_type_id' => $row['user_type_id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'address' => $row['address'],
            'city' => $row['city'],
            'contract_document' => $row['contract_document'],
            'photo' => $row['photo'],
            'status' => $row['status'],
            'email_verified_at' => $row['email_verified_at'],
            'username' => $row['username'],
            'password' => $row['password'],
            'data' => $row['data'],
            'remember_token' => $row['remember_token'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ];

        return new User($_data);
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
