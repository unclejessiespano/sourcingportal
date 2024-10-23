<?php


use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
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

/*
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/seed', function(){
    //return Artisan::call('tenants:seed');
    return Hash::make('abcd.1234');
});
Route::get('/import', function(){
    Artisan::class('import:oor');
    return false;
});
Route::get('/privacy', function(){
    return Inertia::render('Privacy');
});
Route::get('/terms', function(){
    return Inertia::render('Terms');
});
