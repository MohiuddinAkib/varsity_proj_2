<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/payment', \App\Http\Livewire\PaymentStatusList::class)
    ->middleware(["auth"])
    ->name('payment.index');

Route::get('/cow-create', \App\Http\Livewire\CowRecordCreate::class)
    ->middleware(["auth", "role:localadmin"])
    ->name('cow.create');

Route::get('/cow', \App\Http\Livewire\CowRecordList::class)
    ->middleware(["auth"])
    ->name('cow.index');

Route::get('/maintenanace', \App\Http\Livewire\MaintenanceFeeList::class)
    ->middleware(["auth"])
    ->name('maintenance_fee.index');

Route::get('/worker_status', \App\Http\Livewire\WorkerStatusList::class)
    ->middleware(["auth"])
    ->name('worker_status.index');

Route::get('/health_condition', \App\Http\Livewire\HealthConditionList::class)
    ->middleware(["auth"])
    ->name('health_condition.index');

Route::get('/farm', \App\Http\Livewire\FarmList::class)
    ->middleware(["auth", "role:hostadmin"])
    ->name('farm.index');


Route::get('/farm-create', \App\Http\Livewire\FarmCreate::class)
    ->middleware(["auth", "role:hostadmin"])
    ->name('farm.create');

Route::get('/hostadmin', \App\Http\Livewire\HostAdminList::class)
    ->middleware(["auth", "role:superadmin"])
    ->name('hostadmin.index');

Route::get('/hostadmin-create', \App\Http\Livewire\HostAdminCreate::class)
    ->middleware(["auth", "role:superadmin"])
    ->name('hostadmin.create');

Route::get('/localadmin', \App\Http\Livewire\LocalAdminList::class)
    ->middleware(["auth", "role:hostadmin"])
    ->name('localadmin.index');

Route::get('/localadmin-create', \App\Http\Livewire\LocalAdminCreate::class)
    ->middleware(["auth", "role:hostadmin"])
    ->name('localadmin.create');


