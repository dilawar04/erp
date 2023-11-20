<?php

namespace App\Imports;

use App\EmailTemplate;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MessageTemplateImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'msg_id' => $row['msg_id'],
                        'lang_code' => $row['lang_code'],
                        'title' => $row['title'],
                        'subject' => $row['subject'],
                        'message' => $row['message'],
                    ];

        return new EmailTemplate($_data);
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
