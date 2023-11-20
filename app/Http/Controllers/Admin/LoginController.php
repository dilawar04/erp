<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public $_info;

    public function index()
    {
        if (Auth::check()) {
            return redirect()->intended(admin_url('dashboard'));
        }
        $data = [];
        $this->_info->title = 'Login';
        \View::share('_this', $this);
        return view('admin.auth.login', compact('data'));
    }

    function do_login(Request $request)
    {

        $validator = \Validator::make(request()->all(), [
            'username' => "required",
            'password' => "required|min:8|max:16",
        ]);

        /*if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }*/
        $JSON['status'] = false;
        $credentials = $request->only('username', 'password');
        $credentials['status'] = 'Active';

        if (Auth::attempt($credentials, intval(getVar('remember')))) {
            _session('user_type_id', Auth::user()->usertype->id);
            activity_log('login', 'users', Auth::id(), Auth::id());
            if ($request->ajax()) {
                $JSON['status'] = true;
                $JSON['message'] = 'Successfully login!';
                $JSON['redirect'] = redirect()->intended(admin_url('dashboard'))->getTargetUrl();
            } else {
                return redirect()->intended(admin_url('dashboard'));
            }
        } else {
            $JSON['message'] = 'Incorrect username or password. Please try again!';
        }

        return $JSON;
    }

    function logout()
    {
        activity_log('logout', 'users', Auth::id(), Auth::id());
        Auth::logout();
        \Session::forget('user_type_id');
        return \Redirect::to(admin_url('login'));
    }
}
