<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(!\Auth::check()) return redirect()->to('/login');

        return $this->home();
    }

    public function home(){
        if(!\Auth::check()) return redirect()->to('/login');

        return \App\Theme::view('member/dashboard');
    }

    public function reviews(){
        if(!\Auth::check()) return redirect()->to('/login');

        $rows = \App\Review::where(['status' => 'Approved'])->paginate(25);

        return \App\Theme::view('member/reviews', compact('rows'));
    }

    public function review(){
        if(!\Auth::check()) return redirect()->to('/login');

        $id = request()->input('id');

        /** -------- Validation */
        $validator_rules = [
            'review' => "required",
        ];
        $validator = \Validator::make(request()->all(), $validator_rules);
        if ($validator->fails()) {
            if (request()->ajax() || request()->is('api/*')) {
                return api_response(['status' => false, 'message' => join('<br/>', show_validation_errors($validator))]);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $table = \App\Review::getTable();
        $data = DB_FormFields($table);
        if ($id > 0) {
            $row = \App\Review::find($id);
            $row = $row->fill($data['data']);
        } else {
            $row = \App\Review::fill($data['data']);
        }

        if ($status = $row->save()) {
            if ($id == 0) {
                $id = $row->id;
                set_notification('Record has been inserted!', 'success');
                activity_log('Add', $table, $id);
            } else {
                set_notification('Record has been updated!', 'success');
                activity_log('Update', $table, $id);
            }
        } else {
            set_notification('Some error occurred!', 'error');
        }

        if (request()->ajax() || request()->is('api/*')) {
            return api_response(['status' => true, 'message' => join('<br/>', show_validation_errors())]);
        } else {
            return \Redirect::back();
        }
    }

}
