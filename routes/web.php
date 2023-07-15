<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\KlubController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\PertandinganController;
use App\Http\Controllers\StandingController;
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


Route::get('klasemen', [PertandinganController::class, 'showKlasemen'])->name('klasemen.show');

Route::get('klub/create', [KlubController::class, 'create'])->name('klub.create');
Route::post('klub', [KlubController::class, 'store'])->name('klub.store');

Route::get('pertandingan/create', [PertandinganController::class, 'create'])->name('pertandingan.create');
Route::post('pertandingan', [PertandinganController::class, 'store'])->name('pertandingan.store');

Route::post('/pertandingan/multiple', [PertandinganController::class, 'storeMultiple'])->name('pertandingan.storeMultiple');
