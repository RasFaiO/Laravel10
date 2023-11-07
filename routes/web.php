<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Con este bloque de código revisamos el problema n+1
// DB::listen(function ($query) {
//     dump($query->sql);
// });
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

// Si solamente queremos retornar una vista sin más, podemos pasar el siguiente parámetro, para simplificar lo que comentamos 
// Route::get('/', function () {
//     return view('welcome');
// });
// y también le podemos agregar un nombre
Route::view('/','welcome')->name('welcome');

// Route::get('/chirps/{chirps}', function($chirp){
//     if($chirp === '2'){
//         // Para evitar utilzar la función redirect()->route() utilizaremos to_route()
//         return to_route('chirps.index');
//     }
//     return 'chirp details #'.$chirp;
// });

// Lo simplificaremos dentro del middleware auth 
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard','dashboard')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/chirps', [ChirpController::class, 'index'])->name('chirps.index');
    Route::post('/chirps', [ChirpController::class, 'store'])->name('chirps.store');
    Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit'])->name('chirps.edit');
    Route::put('/chirps/{chirp}', [ChirpController::class, 'update'])->name('chirps.update');
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy'])->name('chirps.destroy');
});

require __DIR__.'/auth.php';