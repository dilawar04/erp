<?php

namespace App\Imports;

use App\ContentType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContentTypeImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'title' => $row['title'],
                        'identifier' => $row['identifier'],
                        'meta_title' => $row['meta_title'],
                        'meta_description' => $row['meta_description'],
                        'meta_keywords' => $row['meta_keywords'],
                        'robots' => $row['robots'],
                        'sitemap' => $row['sitemap'],
                        'search' => $row['search'],
                        'layout' => $row['layout'],
                        'fileds' => $row['fileds'],
                        'status' => $row['status'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                    ];

        return new ContentType($_data);
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