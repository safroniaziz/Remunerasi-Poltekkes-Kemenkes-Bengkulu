<?php

use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    activity()->log('Look mum, I logged something');

    return view('backend.dashboard');
})->name('dashboard');

Route::controller(PegawaiController::class)->group(function () {
    Route::get('/manajemen_data_dosen', 'index')->name('dosen');
    Route::get('/manajemen_data_dosen/create', 'create')->name('dosen.create');
    Route::post('/manajemen_data_dosen', 'store')->name('dosen.store');
    Route::patch('/manajemen_data_dosen/{dosen}/set_active', 'setActive')->name('dosen.set_active');
    Route::patch('/manajemen_data_dosen/{dosen}/set_nonactive', 'setnonActive')->name('dosen.set_nonactive');
    Route::get('/manajemen_data_dosen/{pegawai:slug}/edit', 'edit')->name('dosen.edit');
    Route::patch('/manajemen_data_dosen/{pegawai:slug}/update', 'update')->name('dosen.update');

});