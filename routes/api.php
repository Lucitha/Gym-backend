<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\RoomsController;
use App\Http\Controllers\Api\CourseTypesController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\DurationTypesController;
use App\Http\Controllers\Api\SubscriptionTypeController;
use App\Http\Controllers\Api\SubscriptionStatusController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\SettingsController;

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
 
//course types
Route::prefix('course-type')->group(function(){
    
    Route::get('/list',[CourseTypesController::class, 'getCourseTypes'])->name('api.course-type.list');
    Route::post('/new',[CourseTypesController::class,'addCourseType'])->name('api.course-type.new');
    Route::put('/update/{id}',[CourseTypesController::class,'update'])->name('api.course-type.update');
    Route::patch('/status/{id}',[CourseTypesController::class,'toggleStatus'])->name('api.course-type.toggleStatus');   

});
//categories
Route::prefix('categories')->group(function(){
    Route::get('/list',[CategoriesController::class, 'getCategories'])->name('api.categories.list');
    Route::post('/new',[CategoriesController::class,'addCategory'])->name('api.categories.new');
    Route::put('/update/{id}',[CategoriesController::class,'update'])->name('api.categories.update');
    Route::patch('/status/{id}',[CategoriesController::class,'toggleStatus'])->name('api.categories.toggleStatus'); 
});

//duration types
Route::prefix('duration-types')->group(function(){
    Route::get('/list',[DurationTypesController::class, 'getDurationTypes'])->name('api.duration-types.list');
    Route::get('/{id}',[DurationTypesController::class, 'getDurationTypeById'])->name('api.duration-types.getById');
    Route::post('/new',[DurationTypesController::class,'addDurationType'])->name('api.duration-types.new');
    Route::put('/update/{id}',[ DurationTypesController::class,'update'])->name('api.duration-types.update');
    Route::patch('/status/{id}',[DurationTypesController::class,'toggleStatus'])->name('api.duration-types.toggleStatus'); 
    Route::delete('/delete/{id}',[ DurationTypesController::class,'deleteDurationType'])->name('api.duration-types.delete');
});

Route::prefix('subscription-types')->group(function(){
    Route::get('/list',[SubscriptionTypeController::class, 'getSubscriptionTypes'])->name('api.subscription-types.list');
    Route::get('/{id}',[SubscriptionTypeController::class, 'getSubscriptionTypesById'])->name('api.subscription-types.getById');
    Route::post('/new',[SubscriptionTypeController::class,'addSubscriptionType'])->name('api.subscription-types.new');
    Route::patch('/status/{id}',[SubscriptionTypeController::class,'toggleStatus'])->name('api.subscription-types.toggleStatus');
    Route::put('/update/{id}',[SubscriptionTypeController::class,'update'])->name('api.subscription-types.update');
    Route::delete('/delete/{id}',[SubscriptionTypeController::class,'deleteSubscriptionType'])->name('api.subscription-types.delete');
});

Route::prefix('subscription-status')->group(function(){
    Route::get('/list',[SubscriptionStatusController::class, 'getSubscriptionStatuses'])->name('api.subscription-status.list');
    Route::get('/{id}',[SubscriptionStatusController::class, 'getSubscriptionStatusById'])->name('api.subscription-status.getById');
    Route::post('/new',[SubscriptionStatusController::class,'addSubscriptionStatus'])->name('api.subscription-status.new');
    Route::patch('/status/{id}',[SubscriptionStatusController::class,'toggleActiveFlag'])->name('api.subscription-status.toggleStatus');
    Route::put('/update/{id}',[SubscriptionStatusController::class,'updateSubscriptionStatus'])->name('api.subscription-status.update');
    Route::delete('/delete/{id}',[SubscriptionStatusController::class,'deleteSubscriptionStatus'])->name('api.subscription-status.delete');
});

Route::prefix('inventory')->group(function(){
    Route::get('/list',[InventoryController::class, 'getInventory'])->name('api.inventory.list');
    Route::post('/new',[InventoryController::class,'addInventory'])->name('api.inventory.new');
});

Route::prefix('settings')->group(function(){
    Route::get('/',[SettingsController::class, 'getSettings'])->name('api.settings.get');
    Route::put('/update/{id}',[SettingsController::class,'updateSettings'])->name('api.settings.update');
});

Route::prefix()->group(function(){
    // Other routes can be added here
});