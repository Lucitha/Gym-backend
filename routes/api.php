<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\RoomsController;
use App\Http\Controllers\Api\CourseTypesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return json_encode(['success' => true, 'data' => 'You are logged in']);
})->middleware('auth:sanctum');

// Route::get('/users', function (Request $request) {
//     return response()->json([]'success' => true,
//             'data' => 'ete'
//         ],200);
// });
Route::get('/dashboard', [UsersController::class, 'index']);
Route::get('/users', [UsersController::class, 'getUsers']);
Route::get('/members', [UsersController::class, 'getMembers']);
Route::post('/newUser', [UsersController::class, 'addUser']);

//rooms
Route::prefix('rooms')->group(function(){
    
    Route::get('/list',[RoomsController::class, 'getRooms'])->name('api.rooms.list');
    Route::post('/new',[RoomsController::class,'addRoom'])->name('api.rooms.new');
    Route::put('/update/{id}',[RoomsController::class,'updateRoom'])->name('api.rooms.update');
    Route::patch('/status/{id}',[RoomsController::class,'toggleRoomStatus'])->name('api.rooms.toggleStatus');   

});

Route::prefix('course-type')->group(function(){
    
    Route::get('/list',[CourseTypesController::class, 'getCourseTypes'])->name('api.course-type.list');
    Route::post('/new',[CourseTypesController::class,'addCourseType'])->name('api.course-type.new');
    Route::put('/update/{id}',[CourseTypesController::class,'update'])->name('api.course-type.update');
    Route::patch('/status/{id}',[CourseTypesController::class,'toggleStatus'])->name('api.course-type.toggleStatus');   

});