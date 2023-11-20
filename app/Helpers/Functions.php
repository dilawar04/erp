<?php


function pre($array)
{
    echo("<pre>");
    print_r($array);
    echo("</pre>");
}

function make_url($params, $except_params = [],  $url = null){

    $new_keys = collect($params)->keys();
    $except_params = array_merge($except_params, $new_keys);
    $uris = collect(\request()->query())->except($except_params)->merge($params)->toArray();
    $uri_str = \Arr::query($uris);
    $url = $url ?? \url()->current();
    if(count($uris) > 0) {
        $url .= (!\Str::contains('?', $url) ? '?' : '&');
    }
    return $url . $uri_str;
}

function generate_url($params, $append = true, $url = '')
{
    if (is_string($params)) {
        $params = [$params];
    }
    if (empty($url)) {
        $url = request()->url();
        $query_str = request()->getQueryString();
        if (!empty($query_str)) {
            $q_params = [];
            foreach (explode('&', $query_str) as $item) {
                $item = explode('=', $item);
                if (!in_array($item[0], $params)) {
                    $q_params[$item[0]] = $item[1];
                } else {
                    unset($q_params[$item[0]]);
                }
            }
            if ($append) {
                $params = array_merge($q_params, $params);
            } else {
                $params = $q_params;
            }
            $query_str = http_build_query($params);
            if (count($q_params) > 0) {
                $url .= "?" . $query_str;
            }
        } else {
            $url .= "?do=1";
        }
    } else {
        $url .= "?do=1";
    }
    return $url;
}

/**
 * @param string $path
 * @param string $from
 * @return string
 */
function media_url($path = '', $from = 'theme')
{
    $from = ($from !== 'theme' ? $from : opt('theme'));

    return asset("assets/{$from}/{$path}");
}

function media_dir($path = '', $from = null)
{
    $from_dir = ($from === null ? opt('theme') : $from);
    return asset_path("{$from_dir}/{$path}", $from);
}

/**
 * @param string $path
 * @param string $from
 * @return string
 */
function asset_path($path = '', $from = 'front')
{
    if($from === null){
        return public_path('assets/' . $path);
    }
    $from = ($from === 'front' ? $from : 'admin');
    return public_path('assets/' . $from . '/' . $path);
}

function asset_dir($path = '', $from = 'front')
{
    return asset_path($path, $from);
}

/**
 * @param string $path
 * @param string $from
 * @return string
 */
function asset_url($path = '', $from = 'front')
{
    if($from === 's3' && !empty($path)){
        return \Storage::disk('s3')->url($path);
    }

    if($from === null){
        return asset('assets/' . $path);
    }
    $from = ($from === 'front' ? $from : 'admin');
    return asset('assets/' . $from . '/' . $path);
}

/**
 * @param string $path
 * @param bool $module
 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
 */
function admin_url($path = '', $module = false)
{
    $path = ($module ? request()->segment(2) . '/' . $path : $path);
    return url(env('ADMIN_DIR') . '/' . $path);
}

function getUri($num)
{
    return request()->segment($num);
}


function getVar($name)
{
    return request()->input($name);
}

if(!function_exists('req')) {
    /**
     * @param $name
     * @param  string|array|null  $default
     * @param  string|array|null  $set_value
     * @return array|string|null
     *
     */
    function req($name, $default = null, $set_value = null) {
        if($set_value === null) {
            return request($name, $default);
        } else {
            return request()->request->add([$name => $set_value]);
        }
    }
}

/**
 * @param string|int $value
 * @param string|int|array $selected
 * @return string
 */
function _selected($value, $selected){
    if(!is_array($selected)) $selected = [$selected];
    return (in_array($value, $selected) ? 'selected' : '');
}

/**
 * @param string|int $value
 * @param string|int|array $selected
 * @return string
 */
function _checked($value, $selected){
    if(!is_array($selected)) $selected = [$selected];
    return (in_array($value, $selected) ? 'checked' : '');
}

/**
 * @param $path
 * @param null $width
 * @param null $height
 * @param null $alt_image
 * @param array $params
 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
 */
function _img($path, $width = null, $height = null, $alt_image = null, $params = [])
{
    $file_path = public_path(str_replace(url(''), '', $path));
    //$file_path = str_replace([env('LARAVEL_DIR') . '/public/'], '', $file_path);
    $_ext = \File::extension($file_path);
    $mimeType = \File::mimeType($file_path);
    $_ext = \File::extension($file_path);

    if(!\Str::contains($mimeType, ['images/', 'image/'])) {
        $file_path = asset_url("media/file_icons/{$_ext}.png", 1);
    }
    if(in_array($_ext, ['svg'])){
        return $path;
    }

    if (!file_exists($file_path) || is_dir($file_path)) {
        $file_path = ($alt_image ?? env('IMG_NA'));
    }

    $func = (isset($params['func']) ? $params['func'] : 'zoomCrop');//resize
    $ext = (isset($params['ext']) ? $params['ext'] : 'png');
    $quality = (isset($params['quality']) ? $params['quality'] : 80);
    $bg = (isset($params['bg']) ? $params['bg'] : '#FFFFFF');
    $img = _Image::open($file_path)->{$func}($width, $height, $bg)->{$ext}($quality);

    return url($img);
}

function __img($url, $width = null, $height = null, $alt_image = null, $params = [], $local_path = 'assets/remote_files/')
{
    $info = pathinfo($url);

    $filename = $info['basename'];
    if(\Str::length($info['filename']) >= 256){
        $filename = \Str::substr($info['filename'], 0, 255) . "." . $info['extension'];
    }

    $path = $local_path . urldecode($filename);

    if (!File::exists(public_path($path))){
        File::put($path, file_get_contents($url));
    }

    return _img($path, $width, $height, $alt_image, $params);
}

/**
 * @param $inputs
 * @param $path
 * @param array $options
 * @return mixed
 */
function upload_files($inputs, $path, $options = [])
{
    if (!is_array($inputs)) {
        $inputs = [$inputs];
    }
    foreach ($inputs as $input) {
        $data[$input] = false;
        if (request()->file($input)) {
            $file_input = request()->file($input);
            if ($file_input->isValid()) {
                if (is_array($file_input)) {
                    foreach ($file_input as $item) {
                        $_files[] = $file_input->move($path, \Str::slug(\Carbon\Carbon::now()) . "-" . $item->getClientOriginalName())->getFilename();
                    }
                    $data[$input] = json_encode($_files);
                } else {
                    $file_obj = $file_input->move($path, \Str::slug(\Carbon\Carbon::now()) . "-" . $file_input->getClientOriginalName());
                    //$data = $file_obj;
                    $data[$input] = $file_obj;
                    //$data[$input]->file = $file_obj->getFilename();
                }
            } else {
                $data[$input]->status = false;
                $data[$input]->error = $file_input->getErrorMessage();
            }
        }
    }
    return $data;
}

/**
 * @param $content
 * @param array $data
 * @param array $brace
 * @return string|string[]
 */
function replace_columns($content, $data, $brace = ['{', '}'])
{
    if (count($data) && !empty($content)) {
        foreach ($data as $key => $val) {
            $content = str_replace($brace[0] . $key . $brace[1], $val, $content);
        }
    }
    return $content;
}


function getModuleDetail($module = '', $where = '')
{
    if (empty($module)) {
        $module = getUri(2);
    };

    //Cache::forget($module . '_info');
    $row = Cache::rememberForever($module . '_info', function () use ($module) {
        $_module = new \App\Module();
        $_module = $_module->selectRaw("*, IF(icon !='', icon, 'module.png') AS icon");
        $_module = $_module->where('module', $module);
        if (!empty($where)) {
            $_module = $_module->whereRaw($where);
        }
        return $_module->first();
    });

    if (strpos($row->icon, 'icon-') !== false) {
        $row->module_icon = '<i class="m-nav__link-icon ' . $row->icon . '"></i>';
    } else {
        $row->module_icon = '<img width="22" src="' . asset_url('uploads/img/icons/22_' . $row->icon) . '"/>';
    }
    return $row;
}

function get_option($name)
{
    //Cache::forget('DB_options');
    $options = Cache::rememberForever('DB_options', function () {
        $opts = \App\Setting::all();
        return Arr::pluck($opts, 'value', 'name');
    });
    return $options[$name];
}

function opt($name)
{
    return get_option($name);
}

function DB_columns($table)
{
    $columns = DB::select(DB::raw("SHOW COLUMNS FROM {$table}"));
    return $columns;
}

function DB_list_fields($row)
{
    return array_keys((array)$row);
}

function DB_found_rows()
{
    //TODO:: SQL_CALC_FOUND_ROWS
    return DB::select(DB::raw('SELECT FOUND_ROWS() AS total'))[0]->total;
}

function DB_enumValues($table, $field, $assoc = true)
{
    $type = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'")[0]->Type;
    preg_match('/^enum\((.*)\)$/', $type, $matches);
    $enum = null;
    foreach (explode(',', $matches[1]) as $value) {
        $v = trim($value, "'");
        if ($assoc) {
            $enum = Arr::add($enum, $v, $v);
        } else {
            $enum[] = $v;
        }
    }
    return $enum;
}

/**
 * @param $data
 * @param string $selected
 * @param null $template
 * @param array $pluck_column
 * @return string
 *
 */
function selectBox($data, $selected = '', $template = null, $pluck_column = [])
{
    $template = $template ?? '<option {selected} value="{key}">{val}</option>';
    if (is_array($pluck_column) && count($pluck_column) > 0 && is_array($data)) {
        //$data = Arr::pluck($data, key($pluck_column), $pluck_column[key($pluck_column)]);
        $data = Arr::pluck($data, $pluck_column[key($pluck_column)], key($pluck_column));
    }

    $HTML = '';
    if (is_array($data)) {
        foreach ($data as $key => $OP) {
            if (is_array($OP)) {
                $HTML .= "<optgroup label='{$key}'>";
                foreach ($OP as $opt_key => $item) {
                    $_selected = ((is_array($selected) && in_array($opt_key, $selected) || (!is_array($selected) && $opt_key == $selected)) ? 'selected' : '');
                    $HTML .= replace_columns($template, ['key' => $opt_key, 'val' => $item, 'selected' => $_selected]);
                }
                $HTML .= "</optgroup>";
            } else {

                $_selected = ((is_array($selected) && in_array($key, $selected) || (!is_array($selected) && $key == $selected)) ? 'selected' : '');
                $HTML .= replace_columns($template, ['key' => $key, 'val' => $OP, 'selected' => $_selected]);
            }
        }
    } else {
        $OP = DB::select($data);
        foreach ($OP as $item) {
            $item = (is_array($item) ? $item : (array)$item);
            $_keys = array_keys($item);
            $item['key'] = $key = $item[$_keys[0]];
            $item['val'] = $item[$_keys[1]];
            $item['selected'] = ((is_array($selected) && in_array($key, $selected) || (!is_array($selected) && $key == $selected)) ? 'selected' : '');
            $HTML .= replace_columns($template, $item);
        }
    }
    return $HTML;
}

/**
 * @param string|array $data
 * @param string $name
 * @param string|array $checked
 * @param string $type checkbox or radio
 * @param array $params
 * @return string
 */
function checkBox($data, $name, $checked = '', $type = 'checkbox', $params = [])
{
    if(empty($type)){
        $type = 'checkbox';
    }
    $params = array_merge([
        'input' => '<input type="{_type}" name="{_name}" value="{key}" {_checked} {_attr}>',
        'attr' => "",
        'label_position' => 'right',
        'wrap_start' => '<li class="checkbox_li li_{key}">',
        'wrap_end' => '</li>'
    ], $params);

    $template = $params['wrap_start'];
    if($params['label_position'] != 'right'){$template .= " {_value}";}
    $template .= $params['input'];
    if($params['label_position'] == 'right'){$template .= " {_value}";}
    $template .= $params['wrap_end'];

    $HTML = '';
    if (is_array($data)) {
        foreach ($data as $key => $item) {
                $_checked = ((is_array($checked) && in_array($key, $checked) || (!is_array($checked) && $key == $checked)) ? 'checked' : '');
                $HTML .= replace_columns($template, ['_name' => $name, 'key' => $key, '_value' => $item, '_type' => $type, '_checked' => $_checked, '_attr' => $params['attr']]);
        }
    } else {
        $OP = DB::select($data);
        foreach ($OP as $item) {
            $item = (is_array($item) ? $item : (array)$item);
            $_keys = array_keys($item);
            $item['key'] = $key = $item[$_keys[0]];
            $item['_value'] = $item[$_keys[1]];
            $item['_name'] = $name;
            $item['_type'] = $type;
            $item['_attr'] = $params['attr'];
            $item['_checked'] = ((is_array($checked) && in_array($key, $checked) || (!is_array($checked) && $key == $checked)) ? 'checked' : '');;

            $HTML .= replace_columns($template, $item);
        }
    }
    return $HTML;
}


function delete_rows($table, $where = null, $force_delete = TRUE, $unlink_files = [])
{
    if (count($unlink_files) > 0) {
        foreach ($unlink_files as $field_name => $file_path) {
            $SQL = DB::table($table)->select($field_name);
            if (is_array($where)) {
                $SQL = $SQL->where($where);
            } else if (!empty($where)) {
                $SQL = $SQL->whereRaw($where);
            }
            $rows = $SQL->get();
            foreach ($rows as $row) {
                @unlink($file_path . $row->{$field_name});
            }
        }
    }

    $SQL = DB::table($table);
    if (is_array($where)) {
        $SQL = $SQL->where($where);
    } else if (!empty($where)) {
        $SQL = $SQL->whereRaw($where);
    }

    if ($force_delete) {
        $affectedRows = $SQL->delete();
    } else {
        $update_files = collect(array_keys($unlink_files))->flip()->map(function ($key, $val) {
            return $update_files[$key] = '';
        })->toArray();
        $affectedRows = $SQL->update($update_files);
    }

    return $affectedRows;

}

function developer_log($table = '', $description = '', $type = 'db', $user_id = 0)
{
    if (Schema::hasTable('developer_logs')) {

        if($description instanceof Exception){
            $msg = $description->getMessage() . "\n";
            $msg .= $description->getFile() . " : " . $description->getLine() ."\n";

            $description = $msg;
        }

        if (getUri(1) == env('ADMIN_DIR')) {
            $table = (!empty($table) ? $table : getUri(2));
            $user_id = ($user_id > 0) ? $user_id : Auth::id();
        } else {
            $table = (!empty($table) ? $table : getUri(1));
            $user_id = ($user_id > 0) ? $user_id : Auth::id();
        }
        $data = [
            //'datetime' => sqlDateTime(),
            'type' => $type,
            'table' => $table,
            'user_id' => $user_id,
            'user_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),

            'current_URL' => url()->current(),
            'description' => $description,
        ];
        $OBJ = new \App\DeveloperLog();
        $OBJ->fill($data)->save();

        //DB::table('activity_logs')->insert($data);
    }
}

function activity_log($activity, $table = '', $rel_id = 0, $user_id = 0, $description = null)
{
    if (!is_array($rel_id)) {
        $rel_id = [$rel_id];
    }

    if (count($rel_id) > 0 && Schema::hasTable('activity_logs')) {
        foreach ($rel_id as $relid) {
            if (getUri(1) == env('ADMIN_DIR')) {
                $table = (!empty($table) ? $table : getUri(2));
                $user_id = ($user_id > 0) ? $user_id : Auth::id();
            } else {
                $table = (!empty($table) ? $table : getUri(1));
                $user_id = ($user_id > 0) ? $user_id : Auth::id();
            }
            $data = [
                'activity' => $activity,
                'table' => $table,
                'user_id' => $user_id,
                'user_ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'rel_id' => $relid,
                'current_URL' => url()->current(),
                'description' => $description
            ];
            $OBJ = new \App\ActivityLog();
            $OBJ->fill($data)->save();
            //DB::table('activity_logs')->insert($data);
        }
    }
}

function get_email_template($var_data_query, $template_name, $message = '')
{

    if (!empty($template_name)) {
        $template = DB::table('email_templates')->where('name', $template_name)->first();
        $template->message = str_replace(['../../../'], [url('')], $template->message);
    } else {
        $template = new stdClass();
        $template->message = $template->subject = $message;
    }

    if (is_object($var_data_query)) {
        $var_data_query = collect($var_data_query)->toArray();
    }

    if (!is_array($var_data_query)) {
        $var_data_query = DB::selectRaw($var_data_query);
    }

    $var_data_query['site_url'] = url('');
    $var_data_query['current_url'] = url()->current();
    $var_data_query['admin_url'] = admin_url('');
    $var_data_query['site_title'] = opt('site_title');
    $var_data_query['contact_email'] = opt('contact_email');
    $var_data_query['copyright'] = opt('copyright');
    $var_data_query['logo_url'] = asset_url('images/' . opt('logo'), 1);


    foreach ($var_data_query as $col => $val) {
        $template->subject = stripslashes(str_ireplace('[' . $col . ']', $val, $template->subject));
        $template->message = stripslashes(str_ireplace('[' . $col . ']', $val, $template->message));
    }
    $template->subject = preg_replace('/\[(.*)\]/', '', $template->subject);
    $template->message = preg_replace('/\[(.*)\]/', '', $template->message);

    if (empty($template_name) && !empty($message)) {
        return $template->message;
    }
    return $template;

}

/**
 * @param $table
 * @param array $ignore
 * @param null $data
 * @return mixed
 */
function DB_FormFields($table, $ignore = [], $data = null)
{
    if (is_object($table)) {
        $OBJ = new $table;
        $table = $OBJ->getTable();
    }
    if ($data === null) {
        $data = request()->input();
    }

    $DB_DATA['table'] = $table;
    $DB_DATA['data'] = [];
    $DB_DATA['where'] = [];

    $columns = DB_columns($table);

    if (count($columns) > 0 && count($data) > 0) {
        foreach ($columns as $column) {

            if (isset($data[$column->Field]) && !in_array($column->Field, $ignore) && !in_array($column->Key, ['PRI'])) {
                $DB_DATA['data'][$column->Field] = (is_array($data[$column->Field]) ? json_encode($data[$column->Field]) : $data[$column->Field]);
            }
            if ($column->Key == 'PRI' && isset($data[$column->Field])) {
                $DB_DATA['where'][$column->Field] = $data[$column->Field];
            }
        }
    }

    return $DB_DATA;
}

/**
 * @param $table
 * @param $data
 * @param null $where
 * @return int
 */
function save($table, $data, $where = '')
{
    if (is_object($table)) {
        $OBJ = new $table;
        if (empty($where)) {
            $row = $OBJ->firstOrCreate($data);
            return $row->id;
        } else if (is_array($where)) {
            $OBJ = DB::table($OBJ->getTable());
            $OBJ->where($where);
            return $OBJ->update($data);
        } else {
            return false;
        }

    } else if (is_string($table)) {
        $OBJ = DB::table($table);
        if (empty($where)) {
            return $OBJ->insertGetId($data);
        } else if (is_array($where)) {
            $OBJ->where($where);
            return $OBJ->update($data);
        } else {
            return false;
        }
    }
}


function user_do_action($action = null, $module = null, $strict = false)
{
    if (request()->is('api/*')) {
        \Auth::setUser(\App\User::find(1));
    }
    $id = getUri(4);
    $module = $module ?? getUri(2);
    if (request()->is('api/*')) {
        $module = func_num_args()[1] ?? getUri(3);
    }
    if ($action !== null) {
        switch ($action) {
            case 'index':
                $action = null;
                break;
            case 'form':
                $action = 'add';
                if (!empty($id)) {
                    $action = 'edit';
                }
                break;
        }
    }

    $module = Cache::rememberForever("mod_actions_{$module}", function () use($module) {
        return DB::selectOne("SELECT id, actions FROM modules WHERE module=" . DBescape($module));
    });

    $user_type_id = intval(_session('user_type_id'));
    $row = Cache::rememberForever("mod_actions_{$user_type_id}_{$module->id}", function () use($module, $user_type_id) {
        $row = DB::selectOne("SELECT module_id, actions AS user_actions FROM user_type_module_rel
        WHERE module_id='{$module->id}' AND user_type_id = '{$user_type_id}'");
        return $row;
    });

    $module_actions = collect(explode('|', str_replace(['update', 'add', 'edit'], ['edit', 'add|store', 'edit|store'], $module->actions)))->unique()->toArray();
    $user_actions = collect(explode('|', str_replace(['update', 'add', 'edit'], ['edit', 'add|store', 'edit|store'], $row->user_actions)))->unique();

    $user_actions = $user_actions->toArray();

    //dump($module, $action, $user_actions, $module_actions);
    if (empty($module)) {
        //dd('1');
        return true;
    } else if (empty($action) && $row->module_id) {
        //dd('1');
        return true;
    } else if (in_array($action, $user_actions) && in_array($action, $module_actions) && !empty($action)) {
        //dd('2');
        return true;
    } else if (!in_array($action, $user_actions) && !in_array($action, $module_actions) && !empty($action) && $strict) {
        //dd('3');
        return true;
    } else {
        //dd('FALSE');
        return false;
    }
}

function sqlDateTime($datetime = null, $format = 'Y-m-d H:i:s')
{
    $date = date($format, $datetime == null ? time() : strtotime(str_replace(['-'], '/', $datetime)));
    return $date;
}

function dateDiff($date, $date2 = 'now', $format = null){
    $f_date = new \Carbon\Carbon($date);
    if($date2 == 'now'){
        $s_date = \Carbon\Carbon::now();
    } else {
        $s_date = new \Carbon\Carbon($date2);
    }
    $diff = $f_date->diff($s_date);
    if(empty($format) && $format !== null){
        return $diff->format($format);
    } else{
        return $diff;
    }
}

function seconds_to_time($seconds){
    $hours = floor($seconds / 3600);
    $mins = floor($seconds / 60 % 60);
    $secs = floor($seconds % 60);
    $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
    return $timeFormat;
}

function time_to_seconds($str_time){
    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    $time_seconds = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;
    return $time_seconds;
}

function number_to_int($number)
{
    return intval(str_replace(',', '', $number));
}

function dbEscape($value, $like = false)
{
    if ($like) {
        $char = '\\';
        return str_replace(
            [$char, '%', '_'],
            [$char . $char, $char . '%', $char . '_'],
            $value
        );
    }

    return DB::connection()->getPdo()->quote($value);
}

function last_query()
{
    $log = DB::getQueryLog();
    $query = last($log)['query'];
    $bindings = last($log)['bindings'];

    /*$boundSql = str_replace(['%', '?'], ['%%', "'%s'"], $query);
    $boundSql = vsprintf($boundSql, $bindings);*/
    $bindings = collect($bindings)->map(function ($val){
        if(is_numeric($val)){
            return $val;
        } else {
            return "'{$val}'";
        }
    })->toArray();
    return \Str::replaceArray('?', $bindings, $query);
}

function getWhereClause($query, $search_key = 's', $filter_key = 'f')
{
    $search = request($search_key);
    $filter = request($filter_key);

    $search_q = " \n";

    foreach ($search as $field => $value) {
        if (!empty($value)) {

            $query = str_replace('`', '', $query);

            $re = "/(,)(.*?)(as|AS) ({$field})/";
            preg_match($re, $query, $table_alias);
            $column_alias = trim($table_alias[2]);

            if (empty($column_alias)) {
                //preg_match('/\,(.*)?\.' . $field . '\b/i', $query, $table_alias);
                preg_match('/(.*)?\.' . $field . '\b/i', $query, $table_alias);
                $_field = trim($table_alias[0]);
                if(substr($_field, 0, 1) == ','){
                    $_field = trim(substr($_field, 1));
                }
                $column_alias = $_field;
                if (!isset($table_alias[0])) {
                    $column_alias = $field;
                }
            }

            $operator = $filter[$field];
            $search_q .= filter_param($operator, $column_alias, $value) . " \n";
            //dd($search_q);
        }
    }

    //$search_q = substr($search_q, 4);
    return $search_q;
}

function filter_param($operator, $field, $value)
{

    switch ($operator) {
        case '%-%':
            $search_q = "AND {$field} LIKE '%" . dbEscape($value, true) . "%'";
            break;
        case '%!-%':
            $search_q = "AND {$field} NOT LIKE '%" . dbEscape($value, true) . "%'";
            break;
        case '-%':
            $search_q = "AND {$field} LIKE '" . dbEscape($value, true) . "%'";
            break;
        case '%-':
            $search_q = "AND {$field} LIKE '%" . dbEscape($value, true) . "'";
            break;
        case '=':
            $search_q = "AND {$field} = " . dbEscape($value);
            break;
        case '!=':
            $search_q = "AND {$field} != " . dbEscape($value);
            break;
        case '>':
            $search_q = "AND {$field} > " . dbEscape($value);
            break;
        case '>=':
            $search_q = "AND {$field} >= " . dbEscape($value);
            break;
        case '<':
            $search_q = "AND {$field} < " . dbEscape($value);
            break;
        case '<=':
            $search_q = "AND {$field} <= " . dbEscape($value);
            break;
        case 'date_range':
            $dates = explode(' - ', $value);
            $search_q = "AND {$field} BETWEEN " . dbEscape($dates[0]) . " AND " . dbEscape($dates[1]);
            break;
        default:
            if(is_array($value) && count($value)){
                $search_q = "AND {$field} IN('".join($value, "', '")."') ";
            } else
            $search_q = "AND {$field} LIKE '%" . dbEscape($value, true) . "%' ";

    }

    return $search_q;
}

/**
 * @param string|array|int|object $text
 * @param string $key
 */
function set_notification($text, $key = 'error')
{
    $_text = [];
    $flash_prefix= 'notification_';
    if(session()->has($flash_prefix . $key)){
        $_text = session($flash_prefix . $key);
    }
    array_push($_text, $text);
    session()->flash($flash_prefix . $key, $_text);
}

function get_notification($separator = '<br />')
{
    $_text = [];
    $flash_prefix= 'notification_';
    $alert_types = ['success', 'error' => 'danger', 'warning', 'primary', 'info', 'brand'];
    foreach($alert_types as $a_key => $alert_type){
        $key = is_int($a_key) ? $alert_type : $a_key;
        if(session()->has($flash_prefix . $key)){
            $_text[$key] = join($separator, session($flash_prefix . $key));
        }
    }
    return $_text;
}


function show_validation_errors($validator = null, $separator = '<br />')
{
    $_text = get_notification($separator);

    if($validator !== null) {
        $errors = new \Illuminate\Support\MessageBag($validator->errors()->all());
        if ($errors->all()) {
            $_text['error'] .= join($separator, $errors->all());
        }
    }
    return $_text;
}

function api_response($data = [], $status = 200)
{
    return response()->json($data, $status);
}


/**
 * @param $key
 * @param null|string $value
 * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
 */
function _session($key, $value = null){
    if($value == null){
        return \Session::get($key);
    }
    \Session::put($key, $value);
}

/**
 * @return int
 */
function inserted_id()
{
    return DB::getPdo()->lastInsertId();
}

/**
 * @param $input
 * @param $thumb_url
 * @param $delete_url
 * @return string
 */
function thumb_box($input, $thumb_url, $delete_url)
{
    $file_path = public_path(str_replace(asset(''), '', $thumb_url));
    $mimeType = \File::mimeType($file_path);
    $ext = \File::extension($file_path);
    $icon_url = $thumb_url;
    if(!\Str::contains($mimeType, ['images/', 'image/'])){
        $icon_url = asset_url("media/file_icons/{$ext}.png", 1);
    }
    $HTML = '';
    ob_start();
    ?>
    <div class="kt-avatar kt-avatar--outline kt-avatar--circle-" id="kt_apps_user_add_avatar fImg">
        <a href="<?php echo $thumb_url ?>" data-fancybox="image">
            <div class="kt-avatar__holder del-img" style="background-image: url(<?php echo _img($icon_url, 115, 115); ?>);"></div>
        </a>
        <label class="kt-avatar__upload" data-skin="dark" data-toggle="kt-tooltip" title="choose image">
            <i class="fa fa-pen"></i>
            <?php echo $input; ?>
        </label>
        <span class="kt-avatar__cancel" data-skin="dark" data-toggle="kt-tooltip" title="remove image" data-original-title="Cancel avatar" href="<?php echo $delete_url; ?>">
            <i class="fa fa-times"></i>
        </span>
    </div>
    <?php
    $HTML .= ob_get_clean();
    return $HTML;
}


/**
 * @param $table
 * @param $data
 * @return string
 */
function insert_string($table, $data)
{
    $keys = $values = [];

    foreach ($data as $key => $val) {
        $keys[] = '`' . $key . '`';
        $values[] = dbEscape($val);
    }
    return 'INSERT INTO ' . $table . ' (' . implode(', ', $keys) . ') VALUES (' . implode(', ', $values) . ')';
}

function update_string($table, $values, $where = '')
{
    foreach ($values as $key => $val) {
        $valstr[] = $key . ' = ' . $val;
    }

    return 'UPDATE ' . $table . ' SET ' . implode(', ', $valstr) . $where;
}

/**
 * @return mixed
 */
function BD_found_rows(){
    return \DB::selectOne('SELECT FOUND_ROWS() as total')->total;
}

/**
 * @param $items
 * @param $total
 * @param $perPage
 * @param null $currentPage
 * @param array $options
 * @return \Illuminate\Pagination\LengthAwarePaginator
 */
function make_paginator($items, $total, $perPage, $currentPage = null, array $options = []){
    if(count($options) == 0){
        $options = [
            'path'  => \request()->url(),
            'query' => \request()->query(),
        ];
    }
    $paginator = new \Illuminate\Pagination\LengthAwarePaginator($items, $total, $perPage, $currentPage, $options);
    return $paginator;
}

function get_theme(){
    return opt('theme');
}

/**
 * @param bool $full_path
 * @return string
 */
function get_template_directory($full_path = false)
{
    $template = get_theme();
    if (!$full_path) {
        return "themes/{$template}/";
    } else {
        return resource_path("views/themes/{$template}/");
    }
}

/**
 * @param string $uri
 * @param bool $full_path
 * @return string
 */
function theme_dir($uri = '', $full_path = false){
    return get_template_directory($full_path) . $uri;
}


function get_theme_templates($page_start = '')
{
    $page_temp = array();
    foreach (glob(theme_dir('templates', true) . "/{$page_start}*.php") as $item) {
        $page_name = str_replace('.blade.php', '', end(explode('/', $item)));
        $page_temp[$page_name] = ucfirst(str_replace(array('-', '_'), array(' ', ' '), $page_name));
    }
    return $page_temp;
}

/**
 * @param  string|null  $view
 * @param  \Illuminate\Contracts\Support\Arrayable|array   $data
 * @param array $mergeData
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */
function view_theme($view = null, $data = [], $mergeData = []){
    return \view(theme_dir($view), $data, $mergeData);
}


/**
 * @param array $data
 * @return bool|mixed
 */
function send_mail($data){

    try {
        \Mail::send('mail', $data, function ($message) use($data){
            foreach ($data as $key => $val) {
                if(in_array($key, ['message'])) continue;

                if(in_array($key, ['cc', 'bcc', 'to'])){
                    $val = explode(',', $val);
                }
                if(is_array($val)){
                    $_key = key($val);
                    $_val = $val[$_key];
                    $message->{$key}($_key, $_val);
                } else{
                    $_val = $val;
                    if(in_array($key, ['cc', 'bcc', 'to'])){
                        $_val = explode(',', $val);
                    }
                    $message->{$key}($_val);
                }
            }
        });
        return true;
        //return \Mail::failures();
    } catch (Exception $e){
        return false;
    }
}

/**
 * @param $name
 * @param array $config
 * @return array|bool|mixed|string
 */
function getNav($name, $config = []){
    $_M = new Multilevel();
    $_M->id_Column = 'id';
    $_M->title_Column = 'menu_title';
    $_M->link_Column = 'friendly_url';
    $_M->type = 'menu';
    $_M->url = url('') . "/";
    $_M->level_spacing = 5;
    $_M->has_child_html = '';
    $_M->active_link = getUri(1);
    $_M->active_class = 'active';

    $_M->child_li_start = "<li id='menu-{id}' class='nav-item menu-item menu-item-{id} menu-type-{menu_type} {active_class}'>\n  <a href='{href}' class='nav-link'>{title}</a>\n";

    $_M->parent_li_start = "<li id='menu-{id}' class='nav-item menu-item menu-item-{id} menu-type-{menu_type} {active_class} dropdown'>\n  <a href='{href}' class='nav-link dropdown-toggle' data-toggle='dropdown' role='button'>{title}{has_child}</a>";
    $_M->child_ul_start = "<ul class='dropdown-menu'>\n";

    //$_M->url = url("");

    $_M->query = "SELECT
                m.id
                , m.parent_id
                , m.menu_title
                , m.menu_type
                , m.params
                , CASE
                    WHEN m.menu_type = 'blog_category' THEN CONCAT('posts/category/', blog_categories.slug)
                    WHEN m.menu_type = 'custom' THEN m.menu_link
                    WHEN m.menu_type != 'custom' AND p.parent_id > 0 THEN CONCAT(main_pages.slug, '/?tab_id=', p.id)
                    ELSE p.slug
                END AS friendly_url
                , REPLACE(REPLACE(IF(m.menu_type = 'custom',m.menu_link,p.slug),'-',' '),'.html','') as alt_tag
            FROM menus AS m
                LEFT JOIN menu_types ON (menu_types.id = m.menu_type_id)
                LEFT JOIN pages AS p ON (m.menu_link = p.id AND p.`status`='published')
                LEFT JOIN pages AS main_pages ON (main_pages.id = p.parent_id AND p.`status`='published')
                LEFT JOIN blog_categories ON (blog_categories.id = m.menu_link AND blog_categories.`status`='Active')
            WHERE m.`status`='active'
              AND menu_types.type_name='{$name}' ORDER BY m.ordering ASC";

    if (count($config) > 0) {
        foreach ($config as $key => $val) {
            if (isset($config[$key])) {
                $_M->$key = $config[$key];
            }
        }
    }
    return $_M->build();
}

function _tree_menu_list($rows, $level, $cls, $attr = ['type' => 'checkbox', 'name' => 'cats[]'], $selected = []){
    $html = '';
    foreach($rows as $item){
        $html .= '<li>
                <div class="-form-group kt-form__group menu-group-link f-item-'.$cls.'">
                    <label class="kt-'.$attr['type'].' kt-'.$attr['type'].'--square fields-data">
                        <input type="'.$attr['type'].'" class="id-field range-'.$attr['type'].'s" name="'.$attr['name'].'" value="'.$item['id'].'" '._checked($item['id'], $selected).'> '.$item['title'].'
                        <span></span>
                    </label>
                </div>
            </li>';

        if(count($item['children']) > 0 && is_array($item['children'])){
            $html .= '<ul class="tree-menu-level-'.($level+1).'">';
            $html .= _tree_menu_list($item['children'], ($level+1), $cls);
            $html .= '</ul>';
        }
    }
    return $html;
}

/**
 * @param $url
 * @return mixed
 */
function get_youtube_id($url){
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    return $youtube_id = $match[1];
}

/**
 * @param $url
 * @return string
 */
function replace_urls($url){
    return str_replace(['../../..'], [url("")], $url);
}

function getStorageUrl() {
    //$s3 = Storage::disk('s3')->getAdapter()->getClient();

    return "https://".env('AWS_BUCKET').".s3.amazonaws.com/";
}

function multi_array_to_obj($array) {
    $localFlatten = [];

    $key = collect($array)->keys()[0];
    foreach ($array[$key] as $k => $name) {
        foreach ($array as $name => $item) {
            $localFlatten[$k][$name] = $item[$k];
        }
    }

    return $localFlatten;
}
