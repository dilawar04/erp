<?php
/**
 * Class DeveloperLog
 * @property App\DeveloperLog $module
 */

namespace App\Http\Controllers\Admin;

use Breadcrumb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DeveloperLogController extends Controller
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
            $user_id = \Auth::user()->id;
            $this->where .= " AND {$this->table}.created_by = '{$user_id}'";
        }
    }


    /**
     * *****************************************************************************************************************
     * @method developer_logs index | Grid | listing
     * *****************************************************************************************************************
     */
    public function index()
    {
        /** -------- Breadcrumb */
        Breadcrumb::add_item($this->_info->title, admin_url('', true));

        /** -------- Pagination Config */
        $config = collect(['sort' => $this->id_key, 'dir' => 'desc', 'limit' => 25, 'group' => 'developer_logs.' . $this->id_key])->merge(request()->query())->toArray();

        /** -------- Query */
        $select = "developer_logs.id
, developer_logs.type
, developer_logs.table
, developer_logs.table_id
, developer_logs.user_id
-- , users.user_id
, developer_logs.user_ip
, developer_logs.status
, developer_logs.created_at
";
        $SQL = $this->model->select(\DB::raw($select));

        /** -------- WHERE */
        $where = $this->where;
        $where .= getWhereClause($select);
        if (!empty($where)) {
            $SQL = $SQL->whereRaw($where);
        }

        //$SQL = $SQL->leftJoin('users', 'users.id', '=', 'developer_logs.user_id');
        // $SQL = $SQL->leftJoin('users', 'users.id', '=', 'developer_logs.user_id');
        $SQL = $SQL->orderBy($config['sort'], $config['dir'])->groupBy($config['group']);

        $paginate_OBJ = $SQL->paginate($config['limit']);
        $query = $SQL->toSql();

        /** -------- RESPONSE */
        if (request()->ajax()) {
            return $paginate_OBJ;
        } else {
            \View::share('_this', (object)get_object_vars($this));
            return view('admin.developer_logs.grid', compact('paginate_OBJ', 'query'));
        }
    }


    /**
     * *****************************************************************************************************************
     * @method developer_logs form
     * *****************************************************************************************************************
     */
    public function form()
    {
        $id = getUri(4);
        if ($id > 0) {
            $row = $this->model->find($id);
            if ($row->id <= 0) {
                return \Redirect::to(admin_url('', true))->with('error', 'Access forbidden!');
            }
        }

        /** -------- Breadcrumb */
        \Breadcrumb::add_item($this->_info->title, $this->_route);
        \Breadcrumb::add_item(($id > 0) ? "Edit -> id:[$id]" : 'Add New');

        /** -------- Response */
        \View::share('_this', (object)get_object_vars($this));
        return view('admin.developer_logs.form', compact('row'));
    }


    /**
     * *****************************************************************************************************************
     * @method developer_logs store | Insert & Update
     * *****************************************************************************************************************
     */
    public function store()
    {
        $id = request()->input($this->id_key);

        /** -------- Validation */
        $validator_rules = [
        ];
        $validator = Validator::make(request()->all(), $validator_rules);
        if ($validator->fails()) {
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
            $row = $row->fill($data['data']);
        } else {
            $row = $this->model->fill($data['data']);
        }

        if ($status = $row->save()) {
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

        if (request()->ajax()) {
            $alert_types = ['success', 'error' => 'danger', 'warning', 'primary', 'info', 'brand'];
            $alerts = collect(session('errors')->all())->append(collect($alert_types)->map(function ($val, $key) {
                return session($val);
            }));
            return $alerts;
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

        return redirect(admin_url('', true));
    }


    /**
     * *****************************************************************************************************************
     * @method developer_logs delete
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
            return redirect()->back()->with('danger', 'Select minimum one row!');
        }

        $unlink = [];
        $affectedRows = delete_rows($this->table, "{$this->id_key} IN(" . implode($ids, ',') . ")", true, $unlink);
        //$this->model->whereIn($this->id_key, $ids)->delete();

        activity_log(getUri(3), $this->table, $ids);

        return \Redirect::to(admin_url('', true))->with('success', 'Record has been deleted!');
    }


    /**
     * *****************************************************************************************************************
     * @method developer_logs view | Record
     * *****************************************************************************************************************
     */
    public function view()
    {
        $id = getUri(4);
        if ($id > 0) {
            $row = $this->model->find($id);
            if ($row->id <= 0) {
                return \Redirect::to(admin_url('', true))->with('error', 'Access forbidden!');
            }

        } else {
            return \Redirect::to(admin_url('', true))->with('error', 'Invalid URL!');
        }

        Breadcrumb::add_item($this->_info->title, $this->_route);
        Breadcrumb::add_item("View -> id:[$id]");

        $config['buttons'] = ['new', 'edit', 'delete', 'refresh', 'print', 'back'];
        $config['hidden_fields'] = ['created_by'];
        $config['image_fields'] = [
        ];
        $config['attributes'] = [
            'id' => ['title' => 'ID'],
            'description' => ['td_attr' => 'style="color: #dc3545; font-size: 16px; font-family: monospace;"'],
        ];

        activity_log(getUri(3), $this->table, $id);

        /** -------- Response */
        \View::share('_this', (object)get_object_vars($this));

        if (request()->ajax()) {
            return $row;
        } else if (view()->exists('admin.developer_logs.view')) {
            return view('admin.developer_logs.view', compact('row', 'config'));
        } else {
            return view('admin.layouts.view_record', compact('row', 'config'));
        }
    }

    /**
     * *****************************************************************************************************************
     * @method developer_logs AJAX actions
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
                if ($row->id > 0) {
                    exit('false');
                }
                exit('true');
                break;
        }

        return $JSON;
    }


    /**
     * *****************************************************************************************************************
     * @method developer_logs import
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
        $newID = $newOBJ->id;

        return \Redirect::to(admin_url("form/{$newID}", true))->with('success', 'Record has been duplicated!');
    }

    /**
     * *****************************************************************************************************************
     * @method developer_logs import
     * *****************************************************************************************************************
     */
    public function import()
    {
        if (\request()->isMethod('POST')) {
            $model = \Str::studly($this->module);
            $import_CLS = "App\Imports\\{$model}Import";
            Excel::import(new $import_CLS(), request()->file('file'));
            return redirect(admin_url('', true))->with('success', 'All records has been import!');
        } else {

            /** -------- Breadcrumb */
            \Breadcrumb::add_item($this->_info->title, $this->_route);
            \Breadcrumb::add_item("Import");

            return view('admin.layouts.import');
        }
    }

    /**
     * *****************************************************************************************************************
     * @method developer_logs export
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


    public function file_upload()
    {
        $data = [];
        $dir = "assets/front/{$this->table}/";
        $files = upload_files([], $dir, ['ext' => ""]);
        if (count($files) > 0) {
            foreach ($files as $name => $file) {
                if ($file) {
                    $data[$name]->name = $file->getFilename();
                    $data[$name]->image_url = $dir . $data[$name]->name;
                    $data[$name]->thumb_url = _img($dir . $data[$name]->name, 100, 100);
                    $data[$name]->title = $file->getFilename();
                    $data[$name]->size = $file->getSize();
                    $data[$name]->ext = $file->getClientOriginalExtension();
                } else {
                    $data[$name]->name = $file->getFilename();
                    $data[$name]->error = $file->error;
                }
            }
        }

        return $data;
    }

}
