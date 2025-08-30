<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Language switching route
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.categories.index');
    }
    return redirect()->route('student.initiatives.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('initiatives', \App\Http\Controllers\Admin\InitiativeController::class);
        Route::resource('initiatives.tasks', \App\Http\Controllers\Admin\TaskController::class);
        Route::get('students', [\App\Http\Controllers\Admin\StudentController::class, 'index'])->name('students.index');
        Route::get('students/{student}', [\App\Http\Controllers\Admin\StudentController::class, 'show'])->name('students.show');
        Route::post('tasks/{task}/complete/{student}', [\App\Http\Controllers\Admin\TaskController::class, 'markComplete'])->name('tasks.complete');
        Route::get('rankings', [\App\Http\Controllers\Admin\RankingController::class, 'index'])->name('rankings');
    });
    
    // Student routes
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('initiatives', [\App\Http\Controllers\Student\InitiativeController::class, 'index'])->name('initiatives.index');
        Route::get('initiatives/{initiative}', [\App\Http\Controllers\Student\InitiativeController::class, 'show'])->name('initiatives.show');
        Route::post('initiatives/{initiative}/enroll', [\App\Http\Controllers\Student\InitiativeController::class, 'enroll'])->name('initiatives.enroll');
        Route::get('rankings', [\App\Http\Controllers\Student\RankingController::class, 'index'])->name('rankings');
    });
});

require __DIR__.'/auth.php';
