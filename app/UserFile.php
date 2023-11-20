<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{

    //protected $table = 'user_files';
    public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];


    function insertFiles($user_id, $files_input = 'files', $type = 'image', $files_data_input = 'files_data'){
        $files = request($files_input);
        $files_data = request($files_data_input);

        self::where(['user_id' => $user_id, 'type' => $type])->delete();
        if (count($files) > 0) {
            foreach ($files as $k => $file) {
                if(!empty($file)) {
                    $file_data = [
                        'type' => $type,
                        'user_id' => $user_id,
                        'filename' => $file,
                    ];
                    if (isset($files_data) && isset($files_data['title'])) {
                        $file_data['title'] = $files_data['title'][$k];
                        $file_data['description'] = $files_data['description'][$k];
                    }
                    self::create($file_data);
                }
            }
        }
    }

    function deleteFiles($module, $input = 'images_remove'){
        $images_remove = request($input);
        if (count($images_remove) > 0) {
            foreach ($images_remove as $file) {
                if(!empty($file)){
                    \File::delete(asset_dir("{$module}/$file"));
                }
            }
        }
    }

}
