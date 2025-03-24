<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ItemController;



use App\Http\Middleware\Admin;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('/items', function () {
    return view('inventory.items');
})->name('/');

//Inventoryyyyyy

//add

Route::get('Inventory/create', [InventoryController::class, 'create'])->name('equipment.create');
Route::POST('equipment', [InventoryController::class, 'store'])->name('equipment.store');
//Update
Route::get('Inventory/edit/{id}', [InventoryController::class, 'edit'])->name('equipment.edit');
Route::put('Inventory/update/{id}', [InventoryController::class, 'update'])->name('equipment.update');

//Delete    
Route::delete('/equipment/{id}', [InventoryController::class, 'destroy'])->name('equipment.destroy');


//USERSSSS
//add

Route::POST('employee', [UserController::class, 'store'])->name('employee.store');
Route::get('employee/create', [UserController::class, 'create'])->name('employee.create');
Route::get('employee/edit/{id}', [UserController::class, 'edit'])->name('employee.edit');
Route::put('employee/update/{id}', [UserController::class, 'update'])->name('employee.update');
Route::patch('/employee/{id}/toggleStatus', [UserController::class, 'toggleStatus'])->name('employee.toggleStatus');

// Route for the edit assigned items modal
Route::get('/employee/items/{id}', [UserController::class, 'items'])->name('employee.items');

//Assignnnnn
//Displayy

//Add
Route::get('accountability/add', [AssignController::class, 'create'])->name('accountability.create');
Route::post('accountability/store', [AssignController::class, 'store'])->name('accountability.store');
//Update
Route::get('accountability/edit/{id}', [AssignController::class, 'edit'])->name('accountability.edit');
Route::put('accountability/update/{id}', [AssignController::class, 'update'])->name('accountability.update');
Route::delete('/accountability/{id}', [AssignController::class, 'destroy'])->name('accountability.destroy');



Route::middleware([Admin::class])->get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //Admin Page
    Route::middleware([Admin::class])->get('/accountability', [AssignController::class, 'index'])->name('accountability');
    Route::middleware([Admin::class])->get('/user', [UserController::class, 'index'])->name('user');
    Route::middleware([Admin::class])->get('/Inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::middleware([Admin::class])->get('/chart', [ChartController::class, 'showChart'])->name('chart');

    //Historyyyyy
    Route::middleware([Admin::class])->get('/history', [HistoryController::class, 'index'])->name('history');

});


//Categoryyyyy
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories/add', [CategoryController::class, 'store'])->name('categories.store');


//Brandssssss
Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::post('/brands/add', [BrandController::class, 'store'])->name('brands.store');


//Unitsssssssss
Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
Route::get('/units', [UnitController::class, 'index'])->name('units.index');
Route::post('/units/add', [UnitController::class, 'store'])->name('units.store');

//Itemsssssssssss
Route::get('items', [ItemController::class, 'index'])->name('items');
Route::get('items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('items/store', [ItemController::class, 'store'])->name('items.store');
Route::get('get-brands/{categoryId}', [ItemController::class, 'getBrands']);
Route::get('get-units/{brandId}', [ItemController::class, 'getUnits']);


require __DIR__.'/auth.php';
