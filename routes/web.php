<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Inventoryyyyyy
//add
Route::get('/Inventory', [InventoryController::class, 'index'])->name('inventory');
Route::get('Inventory/create', [InventoryController::class, 'create'])->name('equipment.create');
Route::POST('equipment', [InventoryController::class, 'store'])->name('equipment.store');
//Update
Route::get('Inventory/edit/{id}', [InventoryController::class, 'edit'])->name('equipment.edit');
Route::put('Inventory/update/{id}', [InventoryController::class, 'update'])->name('equipment.update');

//Delete    
Route::delete('/equipment/{id}', [InventoryController::class, 'destroy'])->name('equipment.destroy');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
