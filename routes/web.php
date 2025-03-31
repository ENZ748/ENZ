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
use App\Http\Controllers\AssignedItemController;
use App\Http\Controllers\ItemHistoryController;


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
    Route::middleware([Admin::class])->get('/item/history', [ItemHistoryController::class, 'index'])->name('item.history');

});


//Categoryyyyy
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories/add', [CategoryController::class, 'store'])->name('categories.store');
Route::post('/categories/check', [CategoryController::class, 'checkCategory'])->name('categories.check');
Route::get('/categories/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');

//Delete Category
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// View Brands with Middleware
Route::middleware([Admin::class])->get('/brands/{categoryID}', function ($categoryID) {
    return app('App\Http\Controllers\BrandController')->index($categoryID);
})->middleware(['auth', 'verified'])->name('brands.index');

// Create and Store Brands
Route::get('/brands/create/{categoryID}', [BrandController::class, 'create'])->name('brands.create');
Route::post('/brands/add/{categoryID}', [BrandController::class, 'store'])->name('brands.store');

// Check Brand Existence
Route::post('/brands/check', [BrandController::class, 'checkBrand'])->name('brands.check');


//Update Brand
Route::get('brands/{id}/edit/{categoryID}', [BrandController::class, 'edit'])->name('brands.edit');
Route::put('/brands/{id}/{categoryID}', [BrandController::class, 'update'])->name('brands.update');

//Delete Brand
Route::delete('/brands/{id}/category/{categoryID}', [BrandController::class, 'destroy'])->name('brands.destroy');


//View Brandsss
Route::get('/brands/{categoryID}', [BrandController::class, 'index'])->name('brands.index');


//Unitsssssssss
Route::get('/units/create/{brandID}/{categoryID}', [UnitController::class, 'create'])->name('units.create');
Route::post('/units/add/{brandID}/{categoryID}', [UnitController::class, 'store'])->name('units.store');
//View Unitss
Route::get('/units/{brandID}/{categoryID}', [UnitController::class, 'index'])->name('units.index');

//Update Unitss
Route::get('/units/{id}/brand/{brandID}/category/{categoryID}', [UnitController::class, 'edit'])->name('units.edit');
Route::put('/units/{id}/update/brand/{brandID}/category/{categoryID}', [UnitController::class, 'update'])->name('units.update');

//Delete Unit
Route::delete('/units/{id}/brand/{brandID}/category/{categoryID}', [UnitController::class, 'destroy'])->name('units.destroy');



//Itemsssssssssss
Route::get('items', [ItemController::class, 'index'])->name('items');
Route::get('items/category', [ItemController::class, 'category'])->name('items.index');

//Update Itemmm
Route::get('items/edit/{id}', [ItemController::class, 'edit'])->name('items.edit');
Route::put('items/update/{id}', [ItemController::class, 'update'])->name('items.update');

//Delete Itemmm
Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');


Route::get('items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('items/store', [ItemController::class, 'store'])->name('items.store');



Route::get('/get-brands/{categoryId}', [ItemController::class, 'getBrands']);
Route::get('/get-units/{brandId}', [ItemController::class, 'getUnits']);
Route::get('/get-serials/{unitId}', [ItemController::class, 'getSerials']);


Route::get('/get-brands/create/{categoryId}', [AssignedItemController::class, 'getBrands']);
Route::get('/get-units/create/{brandId}', [AssignedItemController::class, 'getUnits']);
Route::get('/get-serials/create/{unitId}', [AssignedItemController::class, 'getSerials']);

// web.php

Route::get('/get-brands-by-category/{categoryId}', [AssignedItemController::class, 'getBrandsByCategory']);
Route::get('/get-units-by-brand/{brandId}', [AssignedItemController::class, 'getUnitsByBrand']);
Route::get('/get-serials-by-unit/{unitId}', [AssignedItemController::class, 'getSerialsByUnit']);


//Dashhhhhhhboarrdddddddddddddd



//Assiagned Itemssss(Accountability)
Route::resource('assigned_items', AssignedItemController::class);

Route::get('assigned_items', [AssignedItemController::class, 'index'])->name('assigned_items.index');
Route::get('assigned_items/create', [AssignedItemController::class, 'create'])->name('assigned_items.create');
Route::post('assigned_items', [AssignedItemController::class, 'store'])->name('assigned_items.store');
Route::get('assigned_items/{id}/edit', [AssignedItemController::class, 'edit'])->name('assigned_items.edit');
Route::put('assigned_items/{id}', [AssignedItemController::class, 'update'])->name('assigned_items.update');

Route::post('assigned-items/{id}/return', [AssignedItemController::class, 'markAsReturned'])->name('assigned_items.return');


require __DIR__.'/auth.php';    
