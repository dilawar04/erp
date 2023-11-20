<?php
/**
 * Class Menu
 * @property \App\Menu $model
 */

namespace App\Http\Controllers\Admin;

use App\Menu;
use Breadcrumb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Multilevel;

class MenuController extends Controller
{
    public $module = ''; //Project module name
    public $_info = null; // Project module info
    public $_route = '';

    public $model = null; // Model Object
    public $table = '';
    public $id_key = '';

    var $where = '1';

    var $menu_cats;


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
            $user_id = \Auth::id();
            $this->where .= " AND {$this->table}.created_by = '{$user_id}'";
        }
    }

    /**
     * *****************************************************************************************************************
     * @method menus index | Grid | listing
     * *****************************************************************************************************************
     */
    public function index()
    {
        /** -------- Breadcrumb */
        \Breadcrumb::add_item($this->_info->title, admin_url('', true));

        /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
         * | # Menu Types
         *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
        $menu_cats = [];
        if (\Schema::hasTable('pages')) {
            $rows = \DB::table('pages')->orderBy('title', 'asc')->get();
            $menu_cats['page'] = [
                'title' => 'Pages',
                'icon-class' => '',
                'url_base' => url('') . '/',
                'rows' => $rows,
            ];

        }
        if (\Schema::hasTable('blog_categories')) {
            //$rows = \DB::table('blog_categories')->selectRaw('id,category as title, slug')->orderBy('category', 'asc')->get();
            $_M = new Multilevel();
            $_M->type = 'tree';
            $_M->id_Column = 'id';
            $_M->title_Column = 'title';
            $_M->link_Column = 'title';
            $_M->level_spacing = 6;
            $_M->selected = old('parent_id', $row->parent_id);
            $_M->query = "SELECT id, category AS title, parent_id, slug FROM blog_categories WHERE 1 ORDER BY id DESC";
            $rows = $_M->build();

            $menu_cats['blog_category'] = [
                'title' => 'Blog Categories',
                'icon-class' => '',
                'url_base' => url('blog/category') . '/',
                'rows' => $rows,
                'tree' => true,
            ];
        }
        if (\Schema::hasTable('blog_posts')) {
            //$rows = \DB::table('blog_categories')->selectRaw('id,category as title, slug')->orderBy('category', 'asc')->get();
            $_M = new Multilevel();
            $_M->type = 'tree';
            $_M->id_Column = 'id';
            $_M->title_Column = 'title';
            $_M->link_Column = 'title';
            $_M->level_spacing = 6;
            $_M->selected = old('parent_id', $row->parent_id);
            $_M->query = "SELECT id, title, parent_id, slug FROM blog_posts WHERE 1 ORDER BY id DESC";
            $rows = $_M->build();

            $menu_cats['blog_posts'] = [
                'title' => 'Blog Posts',
                'icon-class' => '',
                'url_base' => url('blog/post') . '/',
                'rows' => $rows,
                'tree' => true,
            ];
        }
        if (\Schema::hasTable('categories')) {
            //$rows = \DB::table('categories')->selectRaw('id, title, slug')->orderBy('title', 'asc')->where(['parent_id' => 0])->get();
            $_M = new Multilevel();
            $_M->type = 'tree';
            $_M->id_Column = 'id';
            $_M->title_Column = 'title';
            $_M->link_Column = 'title';
            $_M->level_spacing = 6;
            $_M->selected = old('parent_id', $row->parent_id);
            $_M->query = "SELECT id,title,parent_id, slug FROM categories WHERE 1 ORDER BY id DESC";
            $rows = $_M->build();

            $menu_cats['product_category'] = [
                'title' => 'Product Categories',
                'icon-class' => '',
                'url_base' => url('product/category') . '/',
                'rows' => $rows,
                'tree' => true,
            ];
        }
        $this->menu_cats = $menu_cats;

        //dd($menu_cats);
        /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
         * | Menus
         *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
        $menus = [];
        //$menu_type_id = req('menu_type_id');
        //$menus = \App\Menu::where(['menu_type_id' => $menu_type_id])->get();
        $menu_types = \DB::table('menu_types')->get();
        if (count($menu_types) > 0) {
            foreach ($menu_types as $menu_type) {
                //$menus[$menu_type->id] = \App\Menu::where(['menu_type_id' => $menu_type->id])->get();
                $menus[$menu_type->id] = $this->get_menu_items($menu_type->id);
            }
        }

        /** -------- RESPONSE */
        if (request()->ajax()) {
            return $paginate_OBJ;
        } else {
            \View::share('_this', (object)get_object_vars($this));
            return view("admin.{$this->module}.index", compact('menu_cats', 'menu_types', 'menus'));
        }
    }

    private function get_menu_items($menu_id, $parent = 0)
    {
        $items = \App\Menu::where(['menu_type_id' => $menu_id, 'parent_id' => $parent])->orderBy('ordering', 'asc')->get()->toArray();
        foreach ($items as $i => $item) {
            switch ($item['menu_type']) {
                case 'page':
                    $row = \DB::table('pages')->where(['id' => $item['menu_link']])->first(['id', 'slug']);
                    $url = $this->menu_cats[$item['menu_type']]['url_base'] . $row->slug;
                    break;
                case 'blog_category':
                    $row = \DB::table('blog_categories')->where(['id' => $item['menu_link']])->first(['id', 'slug']);
                    $url = $this->menu_cats[$item['menu_type']]['url_base'] . $row->slug;
                    break;
                case 'blog_posts':
                    $row = \DB::table('blog_posts')->where(['id' => $item['menu_link']])->first(['id', 'slug']);
                    $url = $this->menu_cats[$item['menu_type']]['url_base'] . $row->slug;
                    break;

                case 'product_category':
                    $row = \DB::table('categories')->where(['id' => $item['menu_link']])->first(['id', 'slug']);
                    $url = $this->menu_cats[$item['menu_type']]['url_base'] . $row->slug;
                    break;
                default:
                    $url = $item['menu_link'];
                    break;
            }
            $items[$i]['url'] = $url;

            $sub_items = $this->get_menu_items($menu_id, $items[$i]['id']);
            if (!empty($sub_items)) {
                $items[$i]['sub_items'] = $sub_items;
            }
        }

        return $items;
    }

    /**
     * *****************************************************************************************************************
     * @method menus index | Grid | listing
     * *****************************************************************************************************************
     */
    public function index_grid()
    {
        /** -------- Breadcrumb */
        \Breadcrumb::add_item($this->_info->title, admin_url('', true));

        /** -------- Pagination Config */
        $config = collect(['sort' => $this->id_key, 'dir' => 'desc', 'limit' => 25, 'group' => 'menus.' . $this->id_key])->merge(request()->query())->toArray();

        /** -------- Query */
        $select = "menus.id
, menus.parent_id
-- , menus.parent_id
, menus.menu_title
, menus.menu_link
, menus.menu_type
, menus.menu_type_id
-- , menu_types.menu_type_id
, menus.ordering
, menus.status

    ";
        $SQL = $this->model->select(\DB::raw($select));

        /** -------- WHERE */
        $where = $this->where;
        $where .= getWhereClause($select);
        if (!empty($where)) {
            $SQL = $SQL->whereRaw($where);
        }

        //$SQL = $SQL->leftJoin('menus', 'menus.id', '=', 'menus.parent_id');
        //$SQL = $SQL->leftJoin('menu_types', 'menu_types.id', '=', 'menus.menu_type_id');
        $SQL = $SQL->orderBy($config['sort'], $config['dir'])->groupBy($config['group']);

        $paginate_OBJ = $SQL->paginate($config['limit']);
        $query = $SQL->toSql();

        /** -------- RESPONSE */
        if (request()->ajax()) {
            return $paginate_OBJ;
        } else {
            return view("admin.{$this->module}.grid", compact('paginate_OBJ', 'query'));
        }
    }


    /**
     * *****************************************************************************************************************
     * @method menus store | Insert & Update
     * *****************************************************************************************************************
     */
    public function store()
    {
        $id = request()->input($this->id_key);

        $affected_ids = [];
        $items = req('items');

        if (!empty($items)) {
            $affected_ids = $this->update_items($items);
            $this->model->whereNotIn('id', $affected_ids)->delete();
        }

        //set_notification('Record has been updated!', 'success');
        activity_log('Update', $this->table, 0, 0, json_encode($affected_ids));

        $menu_types = \DB::table('menu_types')->get(['id', 'type_name']);
        if (count($menu_types) > 0) {
            foreach ($menu_types as $item) {
                $menu_slug = 'Menu_' . \Str::slug($item->type_name);
                \Cache::forget($menu_slug);
            }
        }

        if (request()->ajax()) {
            $alert_types = ['success', 'error' => 'danger', 'warning', 'primary', 'info', 'brand'];
            $alerts = ['success' => 'Record has been updated!'];
            /*$alerts = collect(session('errors')->all())->append(collect($alert_types)->map(function ($val, $key) {
                return session($val);
            }));*/
            return $alerts;
        } else {
            $__redirect = (!empty(getVar('__redirect')) ? getVar('__redirect') : admin_url("", true));
            return \Redirect::to($__redirect);
        }
    }

    private function update_items($items, $parent_id = 0)
    {

        static $affected;
        if (count($items) > 0 && is_array($items)) {
            foreach ($items as $order => $item) {

                $id = $item['id'];
                parse_str($item['params'], $output);
                $item['params'] = $output['params'];
                $_form = DB_FormFields($this->table, [], $item);
                $data = $_form['data'];
                $data['ordering'] = ($order + 1);
                $data['parent_id'] = $parent_id;

                if ($id == 0) {
                    $id = \DB::table($this->table)->insertGetId($data);
                } else {
                    $menu = \App\Menu::find($id);
                    $menu->fill($data)->save();
                }
                $affected[] = $id;

                if (isset($item['sub_items']) && count($item['sub_items']) > 0) {
                    $this->update_items($item['sub_items'], $id);
                }
            }
        }
        return $affected;
    }


    /**
     * *****************************************************************************************************************
     * @method menus delete
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
     * @method menus AJAX actions
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
     * @method menus import
     * *****************************************************************************************************************
     */
    public function import()
    {
        if (\request()->isMethod('POST')) {
            $import_CLS = "{$this->module}Import";
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
     * @method menus export
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
        $files = upload_files([], $dir, ['ext' => '']);
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
