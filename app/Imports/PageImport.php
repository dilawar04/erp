<?php

namespace App\Imports;

use App\Page;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PageImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'url' => $row['url'],
                        'title' => $row['title'],
                        'parent_id' => $row['parent_id'],
                        'show_title' => $row['show_title'],
                        'tagline' => $row['tagline'],
                        'content' => $row['content'],
                        'meta_title' => $row['meta_title'],
                        'meta_keywords' => $row['meta_keywords'],
                        'meta_description' => $row['meta_description'],
                        'status' => $row['status'],
                        'thumbnail' => $row['thumbnail'],
                        'template' => $row['template'],
                        'ordering' => $row['ordering'],
                        'user_only' => $row['user_only'],
                        'params' => $row['params'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                    ];

        return new Page($_data);
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