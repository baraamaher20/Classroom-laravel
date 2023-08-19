<?php

use App\Http\Controllers\ClassroomPeopleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\ClassworkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\JoinClassroomController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\SubmissionController;
use App\Models\Comment;

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



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';



Route::middleware('auth')->group(function () {


    #==============================Classroom====================================
    Route::get('/', [ClassroomsController::class, 'index'])
        ->name('classrooms.index');

    Route::prefix('/classrooms/trashed')->as('classroom.trashed')->controller(ClassroomsController::class)->group(function () {
        Route::get('/', 'trashed');
        Route::put('{classroom}', 'restore')->name('.restore');
        Route::delete('/{classroom}', 'forceDelete')->name('.force-deletes');
    });

    Route::resource('classrooms', ClassroomsController::class)
        ->where(['classroom', '\d+'])
        ->except('index');

    Route::get('classrooms/{classroom}/join', [JoinClassroomController::class, 'create'])
        ->middleware('signed')
        ->name('classrooms.join');
    Route::post('classrooms/{classroom}/join', [JoinClassroomController::class, 'store']);

    Route::get('/classrooms/{classroom}/people', [ClassroomPeopleController::class, 'index'])->name('classroom.people');
    Route::delete('/classrooms/{classroom}/people', [ClassroomPeopleController::class, 'destroy'])->name('classroom.people.destroy');
    #================================Topic======================================

    Route::resource('classrooms.topics', TopicsController::class)
        ->where(['topic', '\d+'])
        ->except('show');

    #================================Classwork======================================

    Route::resource('classrooms.classworks', ClassworkController::class);
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('submissions/{classwork}', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('submissions/{submission}/file', [SubmissionController::class, 'file'])->name('submissions.file');

    #================================Posts======================================

    Route::resource('classrooms.posts', PostController::class);
});
