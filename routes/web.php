<?php

use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});


// ako imamo vise korisnika grupisacemo ih da se ne ponavlja kod
Route::middleware(['auth', 'verified'])->group(function() {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    // ovim smo napravili i grupu ako kod studenat budemo imali vise tpova studenata
    Route::prefix('student')
    ->name('student.')
    ->group( function(){

    // prvobitno smo ovu smo rutu kopirali kao i za dashboard i prilagodili za studenta
    
        // Route::get('/student/timetable', [\App\Http\Controllers\Student\TimetableController::class, 'index'])   // prvi red ostavljamo malo izmenjeno
        // ->middleware(['auth', 'verified']) // ni ovo nam netreba jer imamo gore grupisano red 23
        //->name('student.timetable');  // napisacemo jednostavnije drugacije:
        Route::get('timetable', [\App\Http\Controllers\Student\TimetableController::class, 'index']) 
        ->name('timetable');
    
    // Route::get('').....tu bi stavili drugu rutu na primer za studenta2..... 

    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
