<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{

    //protected $table = 'message_template';
    //protected $primaryKey = 'msg_id';
    public $timestamps = false;
    //const CREATED_AT = 'created';
    //const UPDATED_AT = 'updated';
    //protected $perPage = 15;

    protected $guarded = [];


    public function languages()
    {
        return $this->hasOne('App\language', 'id', 'lang_code');
    }

    function template($data, $template_name, $custom_message = ''){
        if(is_object($data)){
            $data = collect($data)->toArray();
        }
        if(!empty($template_name)){
            $template = self::where(['name' => $template_name])->first();
            $template->message = replace_urls($template->message);
        } elseif (empty($template_name) && !empty($custom_message)){
            $template = new \stdClass();
            $template->message = $template->subject = $custom_message;
        }

        $data['site_url'] = url("");
        $data['asset_url'] = asset_url();
        $data['current_url'] = url()->current();
        $data['base_url'] = url("");
        $data['admin_url'] = admin_url();
        $data['site_title'] = get_option('site_title');
        $data['contact_email'] = get_option('contact_email');
        $data['copyright'] = get_option('copyright');
        $data['logo_url'] = asset_url('images/' . get_option('logo'), true);

        foreach ($data as $col => $val) {
            $template->subject = stripslashes(str_ireplace(['[' . $col . ']', '{' . $col . '}'], $val, $template->subject));
            $template->message = stripslashes(str_ireplace(['[' . $col . ']', '{' . $col . '}'], $val, $template->message));
        }
        $template->subject = preg_replace('/\[(.*)\]/', '', $template->subject);
        $template->message = do_shortcode(preg_replace('/\[(.*)\]/', '', $template->message));

        if(empty($template_name) && !empty($message) && !is_array($message)){
            return $template->message;
        }

        return $template;
    }
}
