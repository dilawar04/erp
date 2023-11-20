<?php

namespace App\Imports;

use App\Referral;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReferralImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'referral_user_id' => $row['referral_user_id'],
                        'user_id' => $row['user_id'],
                        'code' => $row['code'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                    ];

        return new Referral($_data);
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