<?php
/**
 * Class WorkstationOperation
 * @property \App\WorkstationOperation $model
 */

namespace App\Http\Controllers\Admin;

use App\WorkstationOperation;
use Breadcrumb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class WorkstationOperationController extends Controller
{
    public $module = ''; //Project module name
    public $_info = null; // Project module info
    public $_route = '';

    public $model = null; // Model Object
    public $table = '';
    public $id_key = '';

    var $where = '1';


    public function __construct()
    {
        $this->module = getUri(2);
        $this->_route = admin_url($this->module);
        $model = 'App\\' . \Str::studly(\Str::singular($this->module));
        $this->model = new $model;
        $this->table = $this->model->getTable();
        $this->id_key = $this->model->getKeyName();

        $this->_info = getModuleDetail();

        if (user_do_action('self_records')) {
            //$user_id = \Auth::id();
            //$this->where .= " AND {$this->table}.user_id = '{$user_id}'";
        }
        if (request('workstation_id') > 0) {
            $this->where .= " AND {$this->table}.workstation_id = '" . intval(request('workstation_id')) . "'";
        }
    }


    /**
     * *****************************************************************************************************************
     * @method workstation_operations index | Grid | listing
     * *****************************************************************************************************************
     */
    public function index()
    {
        /** -------- Breadcrumb */
        \Breadcrumb::add_item($this->_info->title, admin_url('', true));

        /** -------- Pagination Config */
        $config = collect(['sort' => $this->id_key, 'dir' => 'desc', 'limit' => 25, 'group' => 'workstation_operations.' . $this->id_key])->merge(request()->query())->toArray();

        /** -------- Query */
        $select = "workstation_operations.id
        , workstation_operations.name
        , workstation_operations.code
-- , workstation_operations.workstation_id
, work_stations.name as workstation
, workstation_operations.status

    ";
        $SQL = $this->model->select(\DB::raw($select));

        $SQL = $SQL->leftJoin('work_stations', 'work_stations.id', '=', 'workstation_operations.workstation_id');
        //$SQL = $SQL->leftJoin('users', 'users.id', '=', 'workstation_operations.user_id');
        /** -------- WHERE */
        $where = $this->where;
        //$select = $SQL;
        $where .= getWhereClause($select);
        if (!empty($where)) {
            $SQL = $SQL->whereRaw($where);
        }

        $SQL = $SQL->orderBy($config['sort'], $config['dir'])->groupBy($config['group']);
        $paginate_OBJ = $SQL->paginate($config['limit']);
        $query = $SQL->toSql();

        /** -------- Response */
        if (request()->ajax() || request()->is('api/*')) {
            return api_response(['status' => true, 'response' => $paginate_OBJ]);
        } else {
            \View::share('_this', (object)get_object_vars($this));
            return view("admin.{$this->module}.grid", compact('paginate_OBJ', 'query'));
        }
    }


    /**
     * *****************************************************************************************************************
     * @method workstation_operations form
     * *****************************************************************************************************************
     */
    public function form()
    {
        $id = getUri(4);
        if ($id > 0) {
            $row = $this->model->find($id);
            if ($row->{$this->id_key} <= 0) {
                set_notification('Access forbidden!');
                if (request()->ajax() || request()->is('api/*')) {
                    return api_response(['status' => false, 'message' => join('<br/>', show_validation_errors())]);
                }
                return redirect()->back();
            }
        }

        /** -------- Breadcrumb */
        \Breadcrumb::add_item($this->_info->title, $this->_route);
        \Breadcrumb::add_item(($id > 0) ? "Edit -> id:[$id]" : 'Add New');

        /** -------- Response */
        \View::share('_this', (object)get_object_vars($this));
        return view("admin.{$this->module}.form", compact('row'));
    }


    /**
     * *****************************************************************************************************************
     * @method workstation_operations store | Insert & Update
     * *****************************************************************************************************************
     */
    public function store()
    {
        $id = request()->input($this->id_key);

        /** -------- Validation */
        $validator_rules = [
            'name' => "required",
            'code' => "required",
            'workstation_id' => "required",
        ];
        $validator = \Validator::make(request()->all(), $validator_rules);
        if ($validator->fails()) {
            if (request()->ajax() || request()->is('api/*')) {
                return api_response(['status' => false, 'message' => join('<br/>', show_validation_errors($validator))]);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $data = DB_FormFields($this->model);

        /** -------- Upload Files */
        $files = upload_files([], "assets/front/{$this->table}/");
        if (count($files) > 0) {
            foreach ($files as $name => $file) {
                if ($file) {
                    $data['data'][$name] = $file->getFilename();
                }
            }
        }

        if ($id > 0) {
            $row = $this->model->find($id);
            $workstationIdArray = json_decode($data['data']['workstation_id'], true);
            $codeArray = json_decode($data['data']['code'], true);
            $nameArray = json_decode($data['data']['name'], true);
            $row->workstation_id = $workstationIdArray[0];
            $row->code = $codeArray[0];
            $row->name = $nameArray[0];
            $row->save();
            // $row = $row->fill($data['data']);
        } else {
            $rowData = $data['data'];
            // Decode JSON strings into arrays
            $workstationIdArray = json_decode($rowData['workstation_id'], true);
            $codeArray = json_decode($rowData['code'], true);
            $nameArray = json_decode($rowData['name'], true);

            // Create new model instance
            $row = new WorkstationOperation(); // Replace YourModel with your model class name

            // Loop through the arrays and save each element to the respective columns
            foreach ($codeArray as $key => $code) {
                $row->create([
                    'workstation_id' => $workstationIdArray[$key],
                    'code' => $code,
                    'name' => $nameArray[$key] // Make sure indices match between code and name arrays
                ]);
            }
            // $row = $this->model->fill($data['data']);
        }

        if ($status = 'true') {
            if ($id == 0) {
                $id = $row->{$this->id_key};
                set_notification('Record has been inserted!', 'success');
                activity_log('Add', $this->table, $id);
            } else {
                set_notification('Record has been updated!', 'success');
                activity_log('Update', $this->table, $id);
            }
        } else {
            set_notification('Some error occurred!', 'error');
        }

        if (request()->ajax() || request()->is('api/*')) {
            return api_response(['status' => true, 'message' => join('<br/>', show_validation_errors())]);
        } else {
            $__redirect = (!empty(getVar('__redirect')) ? getVar('__redirect') : admin_url("", true));
            return \Redirect::to($__redirect);
        }

    }


    /**
     * *****************************************************************************************************************
     * @method Status
     * @unlink Delete Files (unlink)
     * *****************************************************************************************************************
     */
    function status()
    {
        $id = getUri(4);
        $ids = request()->input('ids');
        if ($id > 0) {
            $ids = [$id];
        }

        $data = ['status' => request('status')];
        $this->model->whereIn($this->id_key, $ids)->update($data);

        set_notification('Status has been updated', 'success');

        activity_log(getUri(3), $this->table, $ids);

        if (request()->ajax() || request()->is('api/*')) {
            return api_response(['status' => true, 'message' => join('<br/>', show_validation_errors())]);
        }

        return redirect()->back();//return redirect(admin_url('', true));
    }


    /**
     * *****************************************************************************************************************
     * @method workstation_operations delete
     * *****************************************************************************************************************
     */
    public function delete()
    {
        $id = getUri(4);
        $ids = request()->input('ids');
        if ($id > 0) {
            $ids = [$id];
        }
        if ($ids == null || count($ids) == 0) {
            set_notification('Select minimum one row!');
            if (request()->ajax() || request()->is('api/*')) {
                return api_response(['status' => false, 'message' => join('<br/>', show_validation_errors())]);
            }
            return redirect()->back();
        }

        $unlink = [];
        $affectedRows = delete_rows($this->table, "{$this->id_key} IN(" . implode($ids, ',') . ")", true, $unlink);
        //$this->model->whereIn($this->id_key, $ids)->delete();

        activity_log(getUri(3), $this->table, $ids);

        set_notification('Record has been deleted!', 'success');
        if (request()->ajax() || request()->is('api/*')) {
            return api_response(['status' => true, 'message' => join('<br/>', show_validation_errors())]);
        }

        return \Redirect::to(admin_url('', true));
    }


    /**
     * *****************************************************************************************************************
     * @method workstation_operations view | Record
     * *****************************************************************************************************************
     */
    public function view()
    {
        $id = getUri(4);
        if ($id > 0) {
            $row = $this->model->find($id);
            if ($row->{$this->id_key} <= 0) {
                set_notification('Access forbidden!');
                if (request()->ajax() || request()->is('api/*')) {
                    return api_response(['status' => false, 'message' => join('<br/>', show_validation_errors())]);
                }
                return redirect()->back();// \Redirect::to(admin_url('', true));
            }

        } else {
            set_notification('Invalid URL!');
            if (request()->ajax() || request()->is('api/*')) {
                return api_response(['status' => false, 'message' => join('<br/>', show_validation_errors())]);
            }
            return redirect()->back();// \Redirect::to(admin_url('', true));
        }

        \Breadcrumb::add_item($this->_info->title, $this->_route);
        \Breadcrumb::add_item("View -> id:[$id]");

        $config['buttons'] = ['new', 'edit', 'delete', 'refresh', 'print', 'back'];
        $config['hidden_fields'] = ['created_by'];
        $config['image_fields'] = [
        ];
        $config['attributes'] = [
            'id' => ['title' => 'ID'],
            'user_id' => ['title' => 'User ID', 'wrap' => function ($value, $row) {
                return "<a target='_blank' href='" . admin_url("user/view/{$value}", 1) . "'>{$value}</a>";
            }],
            'status' => ['wrap' => function ($value, $row) {
                return status_field($value, $row, null, null);
            }],
        ];

        activity_log(getUri(3), $this->table, $id);

        /** -------- Response */
        \View::share('_this', (object)get_object_vars($this));
        if (request()->ajax() || request()->is('api/*')) {
            return api_response(['status' => true, 'response' => $row]);
        } else if (view()->exists("admin.{$this->module}.view")) {
            return view("admin.{$this->module}.view", compact('row', 'config'), ['_info' => $this->_info]);
        } else {
            return view("admin.layouts.view_record", compact('row', 'config'), ['_info' => $this->_info]);
        }
    }

    /**
     * *****************************************************************************************************************
     * @method workstation_operations AJAX actions
     * *****************************************************************************************************************
     */
    function ajax()
    {
        $action = request('action') ?? getUri(4);
        $id = request('id') ?? getUri(5);
        switch ($action) {
            case 'delete_img':
                $field = getUri(6);
                $del_img = [$field => asset_dir("front/{$this->table}/")];
                $JSON['status'] = delete_rows($this->table, [$this->id_key, $id], false, $del_img);
                $JSON['message'] = ucwords($field) . ' has been deleted!';
                break;
            case 'ordering':
                $field = array_keys($_GET)[0];
                $value = getVar($field)[$id];
                $JSON['status'] = $this->model->where($this->id_key, $id)->update([$field => $value]);
                $JSON['message'] = 'updated!';
                break;
            case 'validate':
                $field = array_keys($_GET)[0];
                $value = getVar($field);

                $row = \DB::table($this->table)->where($field, $value);
                if ($id > 0) {
                    $row = $row->where($this->id_key, '!=', $id);
                }
                $row = $row->first();
                if ($row->{$this->id_key} > 0) {
                    exit('false');
                }
                exit('true');
                break;
        }

        return $JSON;
    }


    /**
     * *****************************************************************************************************************
     * @method workstation_operations duplicate
     * *****************************************************************************************************************
     */

    public function duplicate()
    {
        $id = getUri(4);
        $OBJ = $this->model->find($id);
        $unique = [
        ];
        $newOBJ = $OBJ->replicate($unique);

        $newOBJ->save();
        $newID = $newOBJ->{$this->id_key};

        set_notification('Record has been duplicated!', 'success');
        if (request()->ajax() || request()->is('api/*')) {
            return api_response(['status' => true, 'message' => join('<br/>', show_validation_errors()), 'response' => $newOBJ]);
        }
        return \Redirect::to(admin_url("form/{$newID}", true));
    }

    /**
     * *****************************************************************************************************************
     * @method workstation_operations import
     * *****************************************************************************************************************
     */
    public function import()
    {
        if (\request()->isMethod('POST')) {
            $model = \Str::studly($this->module);
            $import_CLS = "App\Imports\\{$model}Import";
            Excel::import(new $import_CLS(), request()->file('file'));

            set_notification('All records has been import!', 'success');

            if (request()->ajax() || request()->is('api/*')) {
                return api_response(['status' => false, 'message' => join('<br/>', show_validation_errors())]);
            }
            return redirect()->back();//redirect(admin_url('', true));
        } else {

            /** -------- Breadcrumb */
            \Breadcrumb::add_item($this->_info->title, $this->_route);
            \Breadcrumb::add_item("Import");

            /** -------- Response */
            \View::share('_this', (object)get_object_vars($this));
            return view('admin.layouts.import');
        }
    }

    /**
     * *****************************************************************************************************************
     * @method workstation_operations export
     * @type csv & xml
     * *****************************************************************************************************************
     */
    public function export()
    {
        $ext = 'csv';
        $OBJ = $this->model->all();
        return $OBJ->downloadExcel("{$this->module}.{$ext}", ucfirst($ext), true);
        //return Excel::download($OBJ, "{$this->module}.{$ext}");
    }


    private function update_files_DB($id)
    {

        $table = '';
        $files_remove = req('files_remove');
        if (count($files_remove) > 0) {
            $delete_files = array(
                //'' => './'
                '' => asset_dir("front/{$this->module}/")
            );
            delete_rows($table, "id IN(" . join(',', $files_remove) . ")  AND ='{$id}'", true, $delete_files);
        }
        //delete_rows($table, "='{$id}'");

        $files = req('files');
        $files_data = req('files_data');

        if (count($files) > 0) {
            foreach ($files as $i => $f) {
                if (!empty($f)) {
                    $__file_db = [
                        '' => $id,
                        '' => $f,
                        '' => $files_data[''][$i],

                        //'created' => date('Y-m-d H:i:s'),
                        //'ordering' => intval($files_data['ordering'][$i])
                        //'desc' => $img_data['desc'][$i],
                        //'default' => (getVar('default') == $img ? 1 : 0),
                        //'ordering' => ($i + 1)
                    ];
                    $where = '';
                    if (!empty($files_data['id'][$i])) {
                        $where .= "id='{$files_data['id'][$i]}'";
                        unset($__file_db['created']);
                    }
                    save($table, $__file_db, $where);
                }
            }
        }

    }

    public function file_upload()
    {
        $data = [];
        $dir = "assets/front/{$this->module}/";
        $files = upload_files([], $dir, ['ext' => '']);
        if (count($files) > 0) {
            foreach ($files as $name => $file) {
                if ($file) {
                    $data[$name]->filename = $file->getFilename();
                    $data[$name]->image_url = $dir . $data[$name]->filename;
                    $data[$name]->thumb_url = _img($dir . $data[$name]->filename, 200, 200);
                    $data[$name]->title = \Str::replaceLast("." . $file->getExtension(), '', $file->getFilename());
                    $data[$name]->size = $file->getSize();
                    $data[$name]->mime = $file->getMimeType();
                    $data[$name]->ext = $file->getExtension();
                } else {
                    $data[$name]->filename = $file->getFilename();
                    $data[$name]->error = $file->error;
                }
            }
        }

        return $data;
    }

}
