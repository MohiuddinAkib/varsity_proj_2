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
    ->middleware(["auth", "role:hostadmin|localadmin"])
    ->name('payment.index');

Route::get('/payment-create', \App\Http\Livewire\PaymentStatusCreate::class)
    ->middleware(["auth", "role:localadmin"])
    ->name('payment.create');

Route::get('/cow-create', \App\Http\Livewire\CowRecordCreate::class)
    ->middleware(["auth", "role:localadmin"])
    ->name('cow.create');

Route::get('/cow', \App\Http\Livewire\CowRecordList::class)
    ->middleware(["auth"])
    ->name('cow.index');

Route::get('/maintenanace', \App\Http\Livewire\MaintenanceFeeList::class)
    ->middleware(["auth", "role:hostadmin|localadmin"])
    ->name('maintenance_fee.index');

Route::get('/maintenanace-create', \App\Http\Livewire\MaintenanceFeeCreate::class)
    ->middleware(["auth", "role:localadmin"])
    ->name('maintenance_fee.create');

Route::get('/worker_status', \App\Http\Livewire\WorkerStatusList::class)
    ->middleware(["auth"])
    ->name('worker_status.index');

Route::get('/health_condition', \App\Http\Livewire\HealthConditionList::class)
    ->middleware(["auth", "role:localadmin|hostadmin"])
    ->name('health_condition.index');

Route::get('/health_condition-create', \App\Http\Livewire\HealthConditionCreate::class)
    ->middleware(["auth", "role:localadmin"])
    ->name('health_condition.create');

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

Route::get('/buy-zone', \App\Http\Livewire\BuyZone::class)
    ->name('buy_zone.index');

Route::get('/localadmin-create', \App\Http\Livewire\LocalAdminCreate::class)
    ->middleware(["auth", "role:hostadmin"])
    ->name('localadmin.create');


