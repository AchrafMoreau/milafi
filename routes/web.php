<?php

use App\Http\Controllers\ProfileController;
use illuminate\support\facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CasController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\JudgeController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\uplaodContnroller;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ContactController;



Route::get("/dashboard", function(){
    return view("calendar");
})->name('dashboard');



Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');


// Route::get('/client',[ClientController::class, 'index']);
// Route::resource('/cas',CasController::class);

// Route::resource('/client',ClientController::class);

Route::middleware(['auth', 'clearNotification'])->group(function () {
    //  client routes for user / lawyer
    Route::get('/client', [ClientController::class, 'index']);
    Route::get('/clientJson', [ClientController::class, 'getAll']);
    Route::get("/client/{client}", [ClientController::class, 'show']);
    Route::post('/store-client', [ClientController::class, 'store'])->name('store-client');
    Route::delete("/client/{client}", [ClientController::class, 'destroy']);
    Route::put("/client/{clinet}", [ClientController::class, 'update']);
    Route::delete("/destroyMany-client", [ClientController::class, 'destroyMany']);

    // judge routes for user / lawyer
    Route::get('/judge', [JudgeController::class, 'index']);
    Route::get('/judgeJson', [JudgeController::class, 'getAll']);
    Route::delete('/judge-delete/{id}', [JudgeController::class, 'destroy']);
    Route::delete('/destroyMany-judge', [JudgeController::class, 'destroyMany']);
    Route::put('/judge/{id}', [JudgeController::class, 'update']);
    Route::post('/store-judge', [JudgeController::class, 'store']);


    // case route for user / lawyer
    Route::get('/cas', [CasController::class, 'index']);
    Route::get('/caseJson', [CasController::class, 'getAll']);
    Route::get('/cas/{id}', [CasController::class, 'show']);
    Route::get('/case-edit/{id}', [CasController::class, 'edit']);
    Route::post('/case-update/{id}', [CasController::class, 'update']);
    Route::delete('/case-delete/{id}', [CasController::class, 'destroy']);
    Route::get('/case-add', [CasController::class, 'create']);
    Route::post('/store-case', [CasController::class, 'store']);
    Route::post('/status/{id}', [CasController::class, 'ChanageStatus']);
    Route::delete('/destroyMany-case', [CasController::class, 'destroyMany']);

    // court route for user / lawyer
    Route::get('/court', [CourtController::class, 'index']);
    Route::get('/courtJson', [CourtController::class, 'getAll']);
    Route::put('/court/{id}', [CourtController::class, 'update']);
    Route::delete('/court-delete/{id}', [CourtController::class, 'destroy']);
    Route::delete('/destroyMany-court', [CourtController::class, 'destroyMany']);
    Route::post('/store-court', [CourtController::class, 'store']);

    // document route for user / lawyer
    Route::get('/document', [DocumentController::class, 'index']);
    Route::get('/documentJson', [DocumentController::class, 'getAll']);
    Route::get('/show-doc/{id}', [DocumentController::class, 'show']);
    Route::get('/uploadFile/{folder}/{filename}', [DocumentController::class, 'downloadFile']);
    Route::put('/document/{id}', [DocumentController::class, 'update']);
    Route::delete('/doc-delete/{id}', [DocumentController::class, 'destroy']);
    Route::delete('/destroyMany-document', [DocumentController::class, 'destroyMany']);
    Route::post('/store-doc', [DocumentController::class, 'store']);
    Route::post('/store-doc-fromCase', [DocumentController::class, 'storeFromCase']);
    Route::delete('/delete-doc-fromCase/{id}', [DocumentController::class, 'deleteFromCase']);


    // event route
    Route::get('/events', [EventController::class, 'index']);
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
    Route::post('/importSchadule', [EventController::class, 'import']);
    // uplaod docs
    Route::post('/upload', [uplaodContnroller::class, 'store']);
    // calander route
    Route::get('/calendar', function(){
        return view('calendar');
    });

    // todo route for user/ laywer
    Route::resource('/todo', TodoController::class);
    Route::get('/getAll', [TodoController::class, 'getAll']);

    // contact route for user / laywer
    Route::resource('/contact', ContactController::class);
    Route::get('/getAllContact', [ContactController::class, 'getAll']);


    

    // procedure route for user / laywer
    Route::post('/procedude-add/{id}', [ProcedureController::class, 'store']);
    // dashboard 
    // auth route 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/avatar', [ProfileController::class, 'updateAvatar']);
});

Route::fallback(function () {
    $path = Request::path();
    if (preg_match('/\.(png|jpe?g|gif|svg|css|js)$/i', $path)) {
        abort(404);  // Return a standard 404 for missing assets
    }
    return response()->view('errors.err404', [], 404);

});
require __dir__.'/auth.php';
