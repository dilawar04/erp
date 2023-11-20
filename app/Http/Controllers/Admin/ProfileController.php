<?php
/**
 * Class User
 * @property App\User $module
 */

namespace App\Http\Controllers\Admin;

use App\User;
use Breadcrumb;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProfileController extends Controller
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
        $this->module = 'users';
        $this->_route = admin_url($this->module);
        $model = 'App\\' . \Str::studly(\Str::singular($this->module));
        $this->model = new $model;
        $this->table = $this->model->getTable();
        $this->id_key = $this->model->getKeyName();

        $this->_info = getModuleDetail();

        $agent_type_id = opt('agent_type_id');
        $user_level = \Auth::user()->usertype->level;
        $this->where .= " AND {$this->table}.user_type_id NOT IN({$agent_type_id}) AND user_types.level <= '{$user_level}'";
        if (user_do_action('self_records')) {
            $user_id = \Auth::user()->id;
            $this->where .= " AND {$this->table}.created_by = '{$user_id}'";
        }
    }


    /**
     * *****************************************************************************************************************
     * @method users form
     * *****************************************************************************************************************
     */
    public function index()
    {
        $id = \Auth::id();
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
        return view('admin.users.profile', compact('row'));
    }


    /**
     * *****************************************************************************************************************
     * @method users store | Insert & Update
     * *****************************************************************************************************************
     */
    public function store()
    {
        $id = request()->input($this->id_key);

        /** -------- Validation */
        $validator_rules = [
            //'user_type_id' => "required",
            'first_name' => "required",
            'email' => "required|email",
            'photo' => "image|mimes:gif,jpg,jpeg,png|max:2048",

            'username' => "required|unique:{$this->module},username,{$id},{$this->id_key}",
            'password' => "required|min:8|max:12",
        ];
        if ($id > 0) {
            unset($validator_rules['password']);
        }
        $validator = \Validator::make(request()->all(), $validator_rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $data = DB_FormFields($this->model);

        /** -------- Upload Files */
        $files = upload_files(['photo'], "assets/front/{$this->table}/");
        if (count($files) > 0) {
            foreach ($files as $name => $file) {
                if ($file) {
                    $data['data'][$name] = $file->getFilename();
                }
            }
        }

        $row = $this->model->find($id);
        $row = $row->fill($data['data']);

        if ($status = $row->save()) {
            set_notification('Record has been updated!', 'success');
            activity_log('Update Profile', $this->table, $id);
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
            return redirect($__redirect);
        }

    }

    /**
     * *****************************************************************************************************************
     * @method users AJAX actions
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
                $JSON['status'] = delete_rows($this->table, [$this->id_key => $id], false, $del_img);
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

            case 'chart':
                $_type = getUri(5);
                switch ($_type) {
                    case 'users':
                        $user_type[] = opt('admin_user_type');

                        $ch_rows = \DB::table('users')->leftJoin('user_types', 'user_types.id', '=', 'users.user_type_id')
                            ->whereNotIn('users.id', $user_type)
                            ->groupBy('users.user_type_id')
                            ->selectRaw('count(users.id) AS total, user_types.user_type')
                            ->get();

                        $chart_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $chart_data['legend_data'][] = $ch_row->user_type;
                                $chart_data['series_data_pie'][] = ['value' => $ch_row->total, 'name' => $ch_row->user_type];
                            }
                        }
                        $JSON = $chart_data;
                        $JSON['text'] = __('User Statistics');
                        $JSON['subtext'] = __('');
                        break;
                    case 'income-expense':
                        $where = '';
                        $SQL = "SELECT `type` , SUM(amount) AS total
                                FROM acc_transactions
                                WHERE 1 {$where} GROUP BY `type`";

                        $ch_rows = $this->db->query($SQL)->result();
                        $chart_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $chart_data['legend_data'][] = $ch_row->type;
                                $chart_data['series_data_pie'][] = ['value' => $ch_row->total, 'name' => $ch_row->type];
                            }
                        }
                        $JSON = $chart_data;
                        $JSON['text'] = __('Income & Expense');
                        $JSON['subtext'] = __('');

                        break;
                    case 'income-expense-yearly':
                        $where = '';
                        $year = (req('year') ?? date('Y'));
                        $sub_title = __('Year') . ' ' . $year;
                        //$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $SQL = "SELECT IF(Paid = 'Yes', 'Income', 'Expense') AS `type`
                                , SUM(TotalPrice) AS total
                                , MONTH(`reservation_date`) AS `month`
                                FROM booked_tours
                                WHERE 1 {$where}
                                AND YEAR(`reservation_date`) ='{$year}'
                                GROUP BY `type`, `month`";

                        $ch_rows = \DB::select($SQL);

                        $ch_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $ch_data[$ch_row->month][$ch_row->type] = $ch_row->total;
                            }
                        }

                        $chart_data = [];
                        for ($i = 1; $i <= 12; $i++) {
                            $ch_row = $ch_data[$i];
                            $d_i = (strlen($i) == 1 ? '0' . $i : $i);
                            $month_name = date('F', strtotime("01-{$d_i}-{$year}"));
                            $chart_data['legend_data'][] = $month_name;
                            $chart_data['Income'][] = ['value' => intval($ch_row['Income']), 'name' => $month_name];
                            $chart_data['Expense'][] = ['value' => intval($ch_row['Expense']), 'name' => $month_name];
                        }

                        $JSON = $chart_data;
                        //echo '<pre>'; print_r($JSON); echo '</pre>';
                        $JSON['text'] = __('Income Report');
                        $JSON['subtext'] = __($sub_title);
                        break;
                    case 'income-expense-monthly':
                        $where = '';
                        $month = date('m');
                        if (!empty($month)) {
                            $where .= " AND MONTH(`date`) ='{$month}' ";
                        }
                        $year = date('Y');
                        $sub_title = date('F Y', strtotime("01-{$month}-{$year}"));
                        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $SQL = "SELECT `type`
                                , SUM(amount) AS total
                                , DAY(`date`) AS `day`
                                FROM acc_transactions
                                WHERE 1 {$where}
                                AND YEAR(`date`) ='{$year}'
                                GROUP BY `type`, `day`";

                        $ch_rows = $this->db->query($SQL)->result();

                        $ch_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $ch_data[$ch_row->day][$ch_row->type] = $ch_row->total;
                            }
                        }

                        $chart_data = [];
                        for ($i = 1; $i <= $days; $i++) {
                            $ch_row = $ch_data[$i];

                            $chart_data['legend_data'][] = $i;
                            $chart_data['Income'][] = ['value' => intval($ch_row['Income']), 'name' => $i];
                            $chart_data['Expense'][] = ['value' => intval($ch_row['Expense']), 'name' => $i];
                        }

                        $JSON = $chart_data;
                        //echo '<pre>'; print_r($JSON); echo '</pre>';
                        $JSON['text'] = __('Income & Expense');
                        $JSON['subtext'] = __($sub_title);
                        break;

                    case 'income-yearly':
                        $where = '';
                        $year = date('Y');
                        $sub_title = __('Year') . ' ' . $year;
                        //$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $SQL = "SELECT SUM(TotalPrice) AS total , MONTH(`reservation_date`) AS `month`
                                FROM booked_tours
                                WHERE 1 {$where} AND YEAR(`reservation_date`) ='{$year}'
                                GROUP BY `month`";

                        $ch_rows = \DB::select($SQL);

                        $ch_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $ch_data[$ch_row->month] = $ch_row->total;
                            }
                        }

                        $chart_data = [];
                        for ($i = 1; $i <= 12; $i++) {
                            $ch_row = $ch_data[$i];
                            $d_i = (strlen($i) == 1 ? '0' . $i : $i);
                            $month_name = date('F', strtotime("01-{$d_i}-{$year}"));
                            $chart_data['legend_data'][] = $month_name;
                            $chart_data['Income'][] = ['value' => intval($ch_row), 'name' => $month_name];
                        }

                        $JSON = $chart_data;
                        //echo '<pre>'; print_r($JSON); echo '</pre>';
                        $JSON['text'] = __('Income');
                        $JSON['subtext'] = __($sub_title);
                        break;
                    case 'income-pie':
                        $where = '';
                        $SQL = "SELECT status AS income_head, COUNT(id) AS total
                                FROM booked_tours
                                WHERE 1 {$where} GROUP BY income_head";

                        $ch_rows = \DB::select($SQL);
                        $up_chart_rows = [];
                        $chart_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $ch_row->income_head = preg_replace('/\s\#\d+/', '', $ch_row->income_head);
                                if (is_array($up_chart_rows[$ch_row->income_head])) {
                                    $up_chart_rows[$ch_row->income_head]['total'] += $ch_row->total;

                                } else {
                                    $up_chart_rows[$ch_row->income_head]['total'] = $ch_row->total;
                                    $up_chart_rows[$ch_row->income_head]['name'] = $ch_row->income_head;
                                }
                                //$chart_data['legend_data'][] = date('M', strtotime("01-{$ch_row->income_head}-" . date('Y')));
                            }

                            foreach ($up_chart_rows as $ch_row) {
                                $chart_data['legend_data'][] = $ch_row['name'];
                                $chart_data['series_data_pie'][] = ['value' => $ch_row['total'], 'name' => $ch_row['name']];
                            }
                            /*foreach ($ch_rows as $ch_row) {
                                $chart_data['legend_data'][] = $ch_row->income_head;
                                $chart_data['series_data_pie'][] = ['value' => $ch_row->total, 'name' => $ch_row->income_head];
                            }*/
                        }
                        $JSON = $chart_data;
                        $JSON['text'] = __("Booking's");
                        $JSON['subtext'] = __('');

                        break;
                }

                break;
        }

        echo json_encode($JSON);
    }


    /**
     * *****************************************************************************************************************
     * @method users import
     * *****************************************************************************************************************
     */

    public function duplicate()
    {
        $id = getUri(4);
        $OBJ = $this->model->find($id);
        $unique = [];
        $newOBJ = $OBJ->replicate($unique);

        $newOBJ->save();
        $newID = $newOBJ->id;

        return \Redirect::to(admin_url("form/{$newID}", true))->with('success', 'Record has been duplicated!');
    }

    /**
     * *****************************************************************************************************************
     * @method users import
     * *****************************************************************************************************************
     */
    public function import()
    {
        if (\request()->isMethod('POST')) {
            $model = \Str::studly($this->module);
            $import_CLS = "App\Imports\\{$model}Import";
            Excel::import(new $import_CLS(), request()->file('file'));
            return \Redirect::to(admin_url('', true))->with('success', 'All records has been import!');
        } else {

            /** -------- Breadcrumb */
            Breadcrumb::add_item($this->_info->title, $this->_route);
            Breadcrumb::add_item("Import");

            return view('admin.layouts.import');
        }
    }

    /**
     * *****************************************************************************************************************
     * @method users export
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
        $files = upload_files(['photo'], $dir, ['ext' => gif, jpg, jpeg, png]);
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
