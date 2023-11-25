<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FullCalenderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use FFMpeg\Filters\Video\VideoFilters;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

Route::get('/', 'IndexController@index');

Route::get('/ch-posts', function() {
    dd('Call');
});
Route::get('/clear-cache/{module?}', function($module = '') {

    if(!empty($module)){
        \Cache::forget($module);
        dd("Cache forget: " . $module);
    } else {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Cache::flush();

        Gregwar\Image\GarbageCollect::dropOldFiles(__DIR__ . '/../../assets/cache', 1, true);
        dd("Cache is cleared");
    }
});


/**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Admin
 *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/

Route::get('/RetrieveSecurityToken' , 'RetrieveSecurityTokenController@index');

Route::get(env('ADMIN_URI') . '/login', 'Admin\LoginController@index');
Route::post(env('ADMIN_URI') . '/login/do_login', 'Admin\LoginController@do_login');
Route::get(env('ADMIN_URI') . '/login/logout', 'Admin\LoginController@logout');

Route::middleware(['auth', 'admin'])->prefix(env('ADMIN_URI'))->group( function () {

    Route::any('/{controller}/{method?}/{params?}',
        function ($controller, $method = 'index', $params = null) {
            $app = app();
            $controller = Str::studly(Str::singular($controller));
            $controller_cls = "App\Http\Controllers\\".Str::studly(env('ADMIN_DIR'))."\\{$controller}Controller";
            if(class_exists($controller_cls)) {
                $controller = $app->make($controller_cls);
                try {
                    return $controller->callAction($method, ['params' => $params]);
                } catch (Exception $e) {
                    developer_log('', $e);
                    return View::make('errors.error', compact('e'));
                }
            } else {
                return View::make('errors.404');
            }
        }
    )->where('params', '.*');

    Route::get('/', 'Admin\LoginController@index');
});

Route::get(env('ADMIN_URI'), 'Admin\LoginController@index')->name('login');
/**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Auth Login
 *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/

//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

//Route::post('/login', 'AuthController@login')->name('login');
//Route::post('/registration', 'AuthController@registration')->name('register');
//Route::get('/verify', 'AuthController@verify')->name('verify');

/*Route::get('/login', 'AuthController@index')->name('login');
Route::get('/register', 'AuthController@register')->name('register');*/
//Route::get('/logout', 'AuthController@logout')->name('logout');


// Route::get('admin.full_calenders', [FullCalenderController::class, 'index'])->name('full_calenders.index');

// Route::post('admin.full_calenders/action', [FullCalenderController::class, 'action'])->name('full_calenders.action');



//test deployment

Route::get('posts', 'BlogController@index')->name('blog');
Route::get('posts/category/{slug}', 'BlogController@index');
Route::get('post/category/{slug}', 'BlogController@index');
Route::get('post/{slug}', 'BlogController@detail');
/**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Front End
 *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
Route::any('/{controller}/{method?}/{params?}',
    function ($controller = 'index', $method = 'index', $params = null) {
        $app = app();
        $controller = Str::studly(Str::singular($controller));

        $controller_cls = "App\Http\Controllers\\{$controller}Controller";
        if(class_exists($controller_cls)) {
            $controller = $app->make($controller_cls);
            try {
                return $controller->callAction($method, ['params' => $params]);
            } catch (Exception $e) {
                return View::make('errors.404');
            }
        } else {
            $controller_cls = "App\Http\Controllers\IndexController";
            if(class_exists($controller_cls)) {
                $controller = $app->make($controller_cls);
                try {
                    return $controller->callAction('index', ['params' => $params]);
                } catch (Exception $e) {
                    return View::make('errors.404');
                }
            }

            return View::make('errors.404');
        }
    }
)->where('params', '.*');




Route::get('/admin/full_calenders', [FullCalenderController::class, 'index']);

Route::post('/admin/full_calenders/action', [FullCalenderController::class, 'action']);



