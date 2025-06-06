<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('students', StudentController::class);
Route::get('uploadresult', [ResultController::class, 'resultupload'])->name('uploadresult');
Route::get('uploadedresult', [ResultController::class, 'uploadedresult'])->name('uploadedresult');
Route::get('/get-courses', [ResultController::class, 'getCourseData']);
Route::get('/get-cos', [ResultController::class, 'getCourseofStudyData']);
Route::post('importResult', [ResultController::class, 'importResult'])->name('importResult');
Route::get('uploadedresult', [ResultController::class, 'uploadedresult'])->name('uploadedresult');
Route::get('viewResult/{cid}/{level}/{session}/{semester}', [ResultController::class, 'viewCourseResult'])->name('view.result');
Route::get('deleteResult/{cid}/{level}/{session}/{semester}', [ResultController::class, 'deleteCourseResult'])->name('delete.result');
Route::get('manualresult', [ResultController::class, 'manualupload'])->name('manualresult');
Route::get('prepareResult', [ResultController::class, 'prepareResult'])->name('prepareResult');
Route::get('enterResult/{cid}/{level}/{session}/{semester}/{cos}', [ResultController::class, 'enterCourseResult'])->name('enterResult');
Route::post('saveResult', [ResultController::class, 'saveCourseResult'])->name('saveResult');
Route::get('resultsummary', [ResultController::class, 'resultssummary'])->name('resultsummary');
Route::get('viewResult', [ResultController::class, 'viewResult'])->name('viewResult');
Route::get('resultSummary/{level}/{session}/{semester}/{cos}/{mode?}', [ResultController::class, 'viewResultSummary'])->name('resultSummary');
