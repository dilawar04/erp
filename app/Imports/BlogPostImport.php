<?php

namespace App\Imports;

use App\BlogPost;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BlogPostImport implements ToCollection, WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        $_data = [
                    'id' => $row['id'],
                        'author' => $row['author'],
                        'datetime' => $row['datetime'],
                        'title' => $row['title'],
                        'slug' => $row['slug'],
                        'content' => $row['content'],
                        'status' => $row['status'],
                        'comment_status' => $row['comment_status'],
                        'post_name' => $row['post_name'],
                        'modified' => $row['modified'],
                        'ordering' => $row['ordering'],
                        'featured_image' => $row['featured_image'],
                    ];

        return new BlogPost($_data);
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