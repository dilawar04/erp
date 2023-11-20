<?php

namespace App\Imports;

use App\Review;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReviewImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'user_id' => $row['user_id'],
                        'ip' => $row['ip'],
                        'user_agent' => $row['user_agent'],
                        'rating' => $row['rating'],
                        'title' => $row['title'],
                        'review' => $row['review'],
                        'nickname' => $row['nickname'],
                        'posted_at' => $row['posted_at'],
                        'status' => $row['status'],
                    ];

        return new Review($_data);
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