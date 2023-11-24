<?php
/**
 * Class FullCalender
 * @property \App\FullCalender $model
 */

namespace App\Http\Controllers\Admin;

use App\FullCalender;
use App\EventsCalender;
use Breadcrumb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class FullCalenderController extends Controller
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

        if(user_do_action('self_records')){
            $user_id = \Auth::id();
            $this->where .= " AND {$this->table}.created_by = '{$user_id}'";
        }
    }


    /**
     * *****************************************************************************************************************
     * @method events index | Grid | listing
     * *****************************************************************************************************************
     */
    public function index()
    {
        \Breadcrumb::add_item($this->_info->title, admin_url('', true));

    	if(request()->ajax())
    	{
    		$data = FullCalender::whereDate('start', '>=', request()->start)
                       ->whereDate('end',   '<=', request()->end)
                       ->get(['id', 'title', 'start', 'end']);
            return response()->json($data);
    	}
        $EventsCalender = EventsCalender::first();
        
        \View::share('_this', (object)get_object_vars($this));
    	return view('/admin/full_calenders/grid')->with(compact('EventsCalender'));
    }

    public function action()
    {
        $id = request()->input($this->id_key);
        $row = EventsCalender::find($id);

        if(request()->ajax())
    	{
            $EventsCalender = EventsCalender::first();

            if(request()->type == 'calender')
    		{
                if(empty($EventsCalender)){
                    $working_days = is_array(request()->working_days) ? request()->working_days : [request()->working_days];
                    // Convert the array to JSON before storing in the database
                    $jsonworking_days = json_encode($working_days);

                    $event = EventsCalender::create([ 
                        'weeks_start_from'	=>	request()->weeks_start_from,
                        'working_days'	=>	$jsonworking_days
                    ]);
                    $id = $row->{$this->id_key};
                    activity_log('Add', 'events_calenders', $id);
                }else {
                    $event = EventsCalender::find(request()->get('id'));
    
                    $working_days = is_array(request()->working_days) ? request()->working_days : [request()->working_days];
                    // Convert the array to JSON before storing in the database
                    $jsonworking_days = json_encode($working_days);
    
                    $event->update([
                        'weeks_start_from'	=>	request()->weeks_start_from,
                        'working_days'	=>	$jsonworking_days
                    ]);
                    $id = $row->{$this->id_key};
                    activity_log('Update', 'events_calenders', $id);
                }
    		}
    		if(request()->type == 'add')
    		{
    			$event = FullCalender::create([ 
    				'title'		=>	request()->title,
    				'start'		=>	request()->start,
    				'end'		=>	request()->end
    			]);

    			return response()->json($event);
    		}

    		if(request()->type == 'update')
    		{
    			$event = FullCalender::find(request()->id)->update([
    				'title'		=>	request()->title,
    				'start'		=>	request()->start,
    				'end'		=>	request()->end
    			]);

    			return response()->json($event);
    		}

    		if(request()->type == 'delete')
    		{
    			$event = FullCalender::find(request()->id)->delete();

    			return response()->json($event);
    		}
    	}
    }
}