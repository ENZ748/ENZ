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
use App\Http\Controllers\AssignedItemFormController;
use App\Http\Controllers\ItemHistoryController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\InStockController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AssetSignedItemController;
use App\Http\Controllers\SuperAdminCategoryController;
use App\Http\Controllers\SuperAdminBrandController;
use App\Http\Controllers\SuperAdminUnitController;
use App\Http\Controllers\SuperAdminItemController;
use App\Http\Controllers\SuperAdminAccountabilityController;
use App\Http\Controllers\SuperAdminInStockController;

use App\Http\Middleware\Admin;
use App\Http\Middleware\SuperAdmin;

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

//Super Adminnnn
    //Dashboard
    Route::middleware([SuperAdmin::class])->get('/superAdmin/Dashboard', [SuperAdminDashboardController::class, 'index'])->name('superAdmin.dashboard');

    Route::middleware([SuperAdmin::class])->get('/superAdmin', [SuperAdminController::class, 'index'])->name('superAdmin.index');
    Route::get('admin/create', [SuperAdminController::class, 'create'])->name('admin.create');
    Route::post('admin/store', [SuperAdminController::class, 'store'])->name('admin.store');
    Route::get('admin', [SuperAdminController::class, 'index'])->name('admin');
    Route::get('admin/edit/{id}', [SuperAdminController::class, 'edit'])->name('admin.edit');
    Route::put('admin/update/{id}', [SuperAdminController::class, 'update'])->name('admin.update');
    Route::patch('/admin/{id}/toggleStatus', [SuperAdminController::class, 'toggleStatus'])->name('admin.toggleStatus');


    Route::middleware([SuperAdmin::class])->get('superAdmin/user', function () {
        return app('App\Http\Controllers\UserController')->index();
    })->middleware(['auth', 'verified'])->name('superAdmin.user');

    //Items
    Route::middleware([SuperAdmin::class])->get('superAdmin/items', function () {
        return app('App\Http\Controllers\SuperAdminItemController')->index();
    })->middleware(['auth', 'verified'])->name('superAdmin.items');

    //Dashboard
    Route::middleware([SuperAdmin::class])->get('superAdmin/chart', function () {
        return app('App\Http\Controllers\SuperAdminChartController')->showChart();
    })->middleware(['auth', 'verified'])->name('superAdmin.chart');


    Route::middleware(['auth', 'verified', SuperAdmin::class])
    ->get('superAdmin/assigned_items', [SuperAdminAccountabilityController::class, 'index'])
    ->name('superAdminAssigned_items.index');

    // Historyyyyy
    Route::middleware([SuperAdmin::class])->get('superAdmin/history', function () {
        return app('App\Http\Controllers\HistoryController')->index();
    })->middleware(['auth', 'verified'])->name('superAdmin.history');

    Route::middleware([SuperAdmin::class])->get('superAdmin/item/history', function () {
        return app('App\Http\Controllers\ItemHistoryController')->index();
    })->middleware(['auth', 'verified'])->name('superAdmin.item.history');

    Route::middleware([SuperAdmin::class])->get('superAdmin/item/admin/assets', function () {
        return app('App\Http\Controllers\AdminAccountabilityController')->index();
    })->middleware(['auth', 'verified'])->name('superAdmin.admin.accountability');

    Route::middleware(['auth', 'verified', SuperAdmin::class])
    ->get('superAdmin/InStock', [SuperAdminInStockController::class, 'index'])
    ->name('superAdmin.instock');

    //Accountability Forms
    Route::middleware([SuperAdmin::class])->get('superAdmin/form', function () {
        return app('App\Http\Controllers\AssignedItemFormController')->index();
    })->middleware(['auth', 'verified'])->name('superAdmin.assigned_items.forms');
    

    Route::get('/assigned-items/history', [ItemHistoryController::class, 'history'])
    ->name('assigned-items.history');


    //View Categories
        Route::middleware([SuperAdmin::class])->get('SuperAdmin/categories', function () {
            return app('App\Http\Controllers\SuperAdminCategoryController')->index();
        })->middleware(['auth', 'verified'])->name('categories.SuperAdminIndex');
    
    //Brand
        Route::middleware([SuperAdmin::class])->get('SuperAdmin/brands/{categoryID}', function ($categoryID) {
            return app('App\Http\Controllers\SuperAdminBrandController')->index($categoryID);
        })->middleware(['auth', 'verified'])->name('brands.SuperAdminIndex');
    
    //View Unitss
        Route::middleware([SuperAdmin::class])->get('SuperAdmin/units/{brandID}/{categoryID}', function ($brandID, $categoryID) {
            return app('App\Http\Controllers\SuperAdminUnitController')->index($brandID, $categoryID);
        })->middleware(['auth', 'verified'])->name('units.SuperAdminIndex');
        
    //Activity Logs
    Route::get('activity_logs', [SuperAdminController::class, 'activityLog'])->name('admin.activityLogs');
    Route::get('/admin/activity-logs/export', [SuperAdminController::class, 'export'])
    ->name('admin.activityLogs.export');
//Admin
    Route::middleware([Admin::class])->get('/accountability', function () {
        return app('App\Http\Controllers\AssignController')->index();
    })->middleware(['auth', 'verified'])->name('accountability');

    Route::middleware([Admin::class])->get('/user', function () {
        return app('App\Http\Controllers\UserController')->index();
    })->middleware(['auth', 'verified'])->name('user');

    Route::middleware([Admin::class])->get('/items', function () {
        return app('App\Http\Controllers\ItemController')->index();
    })->middleware(['auth', 'verified'])->name('items');

    Route::middleware([Admin::class])->get('/chart', function () {
        return app('App\Http\Controllers\ChartController')->showChart();
    })->middleware(['auth', 'verified'])->name('chart');


    Route::middleware([Admin::class])->get('assigned_items', function () {
        return app('App\Http\Controllers\AssignedItemController')->index();
    })->middleware(['auth', 'verified'])->name('assigned_items.index');

    // Historyyyyy
    Route::middleware([Admin::class])->get('/history', function () {
        return app('App\Http\Controllers\HistoryController')->index();
    })->middleware(['auth', 'verified'])->name('history');

    Route::middleware([Admin::class])->get('/item/history', function () {
        return app('App\Http\Controllers\ItemHistoryController')->index();
    })->middleware(['auth', 'verified'])->name('item.history');

    Route::middleware([Admin::class])->get('/item/admin/assets', function () {
        return app('App\Http\Controllers\AdminAccountabilityController')->index();
    })->middleware(['auth', 'verified'])->name('admin.accountability');
     
    //InStock
    Route::middleware(['auth', 'verified', Admin::class])
    ->get('/InStock', [InStockController::class, 'index'])
    ->name('instock');

    //Forms
    Route::middleware([Admin::class])->get('/form', function () {
        return app('App\Http\Controllers\AssignedItemFormController')->index();
    })->middleware(['auth', 'verified'])->name('assigned_items.forms');
    
    Route::get('/assigned-items/history', [ItemHistoryController::class, 'history'])
    ->name('assigned-items.history');
});


// Admin Categoryyyyy
    //View Categories
    Route::middleware([Admin::class])->get('/categories', function () {
        return app('App\Http\Controllers\CategoryController')->index();
    })->middleware(['auth', 'verified'])->name('categories.index');

    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/add', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/categories/check', [CategoryController::class, 'checkCategory'])->name('categories.check');
    Route::get('/categories/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');

    //Delete Category
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

//Super Admin Categoryyy
    Route::get('SuperAdmin/categories/create', [SuperAdminCategoryController::class, 'create'])->name('categories.SuperAdminCreate');
    Route::post('SuperAdmin/categories/add', [SuperAdminCategoryController::class, 'store'])->name('categories.SuperAdminStore');
    Route::post('SuperAdmin/categories/check', [SuperAdminCategoryController::class, 'checkCategory'])->name('categories.SuperAdminCheck');
    Route::get('SuperAdmin/categories/{id}', [SuperAdminCategoryController::class, 'edit'])->name('categories.SuperAdminEdit');
    Route::put('SuperAdmin/categories/update/{id}', [SuperAdminCategoryController::class, 'update'])->name('categories.SuperAdminUpdate');

    //Delete Category
    Route::delete('SuperAdmin/categories/{id}', [SuperAdminCategoryController::class, 'destroy'])->name('categories.SuperAdminDestroy');



//Brandssssss
    //View Brandsss
    Route::middleware([Admin::class])->get('/brands/{categoryID}', function ($categoryID) {
        return app('App\Http\Controllers\BrandController')->index($categoryID);
    })->middleware(['auth', 'verified'])->name('brands.index');
       
    Route::get('/brands/create/{categoryID}', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands/add/{categoryID}', [BrandController::class, 'store'])->name('brands.store');

    Route::post('/brands/check', [BrandController::class, 'checkBrand'])->name('brands.check');

    //Update Brand
    Route::get('brands/{id}/edit/{categoryID}', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{id}/{categoryID}', [BrandController::class, 'update'])->name('brands.update');

    //Delete Brand
    Route::delete('/brands/{id}/category/{categoryID}', [BrandController::class, 'destroy'])->name('brands.destroy');


    //Super Admin Brand
    //Update Brand
    Route::get('SuperAdmin/brands/{id}/edit/{categoryID}', [SuperAdminBrandController::class, 'edit'])->name('brands.SuperAdminEdit');
    Route::put('SuperAdmin/brands/{id}/{categoryID}', [SuperAdminBrandController::class, 'update'])->name('brands.SuperAdminUpdate');

    //Delete Brand
    Route::delete('SuperAdmin/brands/{id}/category/{categoryID}', [SuperAdminBrandController::class, 'destroy'])->name('brands.SuperAdminDestroy');

    Route::get('SuperAdmin/brands/create/{categoryID}', [SuperAdminBrandController::class, 'create'])->name('brands.SuperAdminCreate');
    Route::post('SuperAdmin/brands/add/{categoryID}', [SuperAdminBrandController::class, 'store'])->name('brands.SuperAdminStore');

    Route::post('SuperAdmin/brands/check', [SuperAdminBrandController::class, 'checkBrand'])->name('brands.SuperAdminCheck');



//Unitsssssssss
    //View Unitss
    Route::middleware([Admin::class])->get('/units/{brandID}/{categoryID}', function ($brandID, $categoryID) {
        return app('App\Http\Controllers\UnitController')->index($brandID, $categoryID);
    })->middleware(['auth', 'verified'])->name('units.index');
    
    Route::get('/units/create/{brandID}/{categoryID}', [UnitController::class, 'create'])->name('units.create');
    Route::post('/units/add/{brandID}/{categoryID}', [UnitController::class, 'store'])->name('units.store');

    //Update Unitss
    Route::get('/units/{id}/brand/{brandID}/category/{categoryID}', [UnitController::class, 'edit'])->name('units.edit');
    Route::put('/units/{id}/update/brand/{brandID}/category/{categoryID}', [UnitController::class, 'update'])->name('units.update');

    Route::post('/units/check', [UnitController::class, 'checkUnit'])->name('units.check');

    //Delete Unit
    Route::delete('/units/{id}/brand/{brandID}/category/{categoryID}', [UnitController::class, 'destroy'])->name('units.destroy');

//Super Admin Units
    Route::get('superAdmin/units/create/{brandID}/{categoryID}', [SuperAdminUnitController::class, 'create'])->name('units.SuperAdmincreate');
    Route::post('superAdmin/units/add/{brandID}/{categoryID}', [SuperAdminUnitController::class, 'store'])->name('units.SuperAdminstore');

    //Update Unitss
    Route::get('superAdmin/units/{id}/brand/{brandID}/category/{categoryID}', [SuperAdminUnitController::class, 'edit'])->name('units.SuperAdminedit');
    Route::put('superAdmin/units/{id}/update/brand/{brandID}/category/{categoryID}', [SuperAdminUnitController::class, 'update'])->name('units.SuperAdminupdate');

    Route::post('superAdmin/units/check', [SuperAdminUnitController::class, 'checkUnit'])->name('units.SuperAdmincheck');

    //Delete Unit
    Route::delete('superAdmin/units/{id}/brand/{brandID}/category/{categoryID}', [SuperAdminUnitController::class, 'destroy'])->name('units.SuperAdmindestroy');


//Itemsssssssssss
    Route::get('items/category', [ItemController::class, 'search'])->name('items.search');

    //Update Itemmm
    Route::get('items/edit/{id}', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('items/{id}', [ItemController::class, 'update'])->name('items.update');

    //Delete Itemmm
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');


    Route::put('/items/{item}/repair', [ItemController::class, 'repair'])->name('items.repair');

    Route::get('items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('items/store', [ItemController::class, 'store'])->name('items.store');



    Route::get('/get-brands/{categoryId}', [ItemController::class, 'getBrands']);
    Route::get('/get-units/{brandId}', [ItemController::class, 'getUnits']);
    Route::get('/get-serials/{unitId}', [ItemController::class, 'getSerials']);

//Super Admin search Item
    Route::get('/superAdmin/items/category', [SuperAdminItemController::class, 'search'])->name('items.superAdminsearch');


//Dashhhhhhhboarrdddddddddddddd



//Assigned Itemssss(Accountability) 
    Route::resource('assigned_items', AssignedItemController::class);
    //View Accountability

    Route::get('assigned_items/create', [AssignedItemController::class, 'create'])->name('assigned_items.create');
    Route::post('assigned_items', [AssignedItemController::class, 'store'])->name('assigned_items.store');
    Route::get('assigned_items/{id}/edit', [AssignedItemController::class, 'edit'])->name('assigned_items.edit');
    Route::put('assigned_items/{id}', [AssignedItemController::class, 'update'])->name('assigned_items.update');

    
    //Item Status Button
    Route::get('assigned-items/{id}/return', [AssignedItemController::class, 'itemStatus'])->name('assigned_items.itemStatus');
    Route::post('assigned-items/{id}/returned', [AssignedItemController::class, 'markAsReturned'])->name('assigned_items.good');
    Route::post('assigned-items/{id}/damaged', [AssignedItemController::class, 'markAsDamaged'])->name('assigned_items.damaged');

    Route::get('/get-brands/create/{categoryId}', [AssignedItemController::class, 'getBrands']);
    Route::get('/get-units/create/{brandId}', [AssignedItemController::class, 'getUnits']);
    Route::get('/get-serials/create/{unitId}', [AssignedItemController::class, 'getSerials']);

//Super Admin Assiagned Itemssss(Accountability) 
    Route::resource('superAdmin/assigned_items/get', SuperAdminAccountabilityController::class);
    //View Accountability

    Route::get('superAdmin/assigned_items/create', [SuperAdminAccountabilityController::class, 'create'])->name('assigned_items.superAdmincreate');
    Route::post('superAdmin/assigned_items', [SuperAdminAccountabilityController::class, 'store'])->name('assigned_items.superAdminstore');
    Route::get('superAdmin/assigned_items/{id}/edit', [SuperAdminAccountabilityController::class, 'edit'])->name('assigned_items.superAdminedit');
    Route::put('superAdmin/assigned_items/{id}', [SuperAdminAccountabilityController::class, 'update'])->name('assigned_items.superAdminupdate');


    //Item Status Button
    Route::get('superAdmin/assigned-items/{id}/return', [SuperAdminAccountabilityController::class, 'itemStatus'])->name('assigned_items.superAdminitemStatus');
    Route::post('superAdmin/assigned-items/{id}/returned', [SuperAdminAccountabilityController::class, 'markAsReturned'])->name('assigned_items.superAdmingood');
    Route::post('superAdmin/assigned-items/{id}/damaged', [SuperAdminAccountabilityController::class, 'markAsDamaged'])->name('assigned_items.superAdmindamaged');

    Route::get('superAdmin/get-brands/create/{categoryId}', [SuperAdminAccountabilityController::class, 'getBrands']);
    Route::get('superAdmin/get-units/create/{brandId}', [SuperAdminAccountabilityController::class, 'getUnits']);
    Route::get('superAdmin/get-serials/create/{unitId}', [SuperAdminAccountabilityController::class, 'getSerials']);

//Assigned Item Forms
    Route::get('accountability_form/{id}', [AssignedItemFormController::class, 'accountability_form'])->name('form.accountability');
    Route::get('asset_return_form/{id}', [AssignedItemFormController::class, 'asset_return_form'])->name('form.asset_return');
    Route::get('confirm_return/{id}', [AssignedItemFormController::class, 'confirm_History'])->name('form.confirm_return');
    Route::get('confirm_accountability/{id}', [AssignedItemFormController::class, 'confirm_accountability'])->name('form.confirm_accountability');
    Route::get('/form/search', [AssignedItemFormController::class, 'search'])->name('form.search');


    
//PDF
    use App\Http\Controllers\PDFController;
    
    Route::get('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generatePDF');
    Route::get('/Asset_historyGenerate-pdf', [PDFController::class, 'AssetHistoryGeneratePDF'])->name('AssetHistoryGeneratePDF');
    
//Email
    Route::get('send-mail', [MailController::class, 'index']);



    use App\Http\Controllers\FileController;

    Route::get('/files/upload', [FileController::class, 'create'])
    ->name('files.create');

    // Handle file upload
    Route::post('/files/upload', [FileController::class, 'store'])
        ->name('files.store');

    // List all files
    Route::get('/files', [FileController::class, 'index'])
        ->name('files.index');

    // Download file
    Route::get('/employees/{employee}/files/{file}/download', [FileController::class, 'download'])
        ->name('files.download');


    use App\Http\Controllers\ReturnSignedItemController;
    Route::get('/return_files/upload', [ReturnSignedItemController::class, 'create'])
        ->name('return_files.create');

    Route::post('/user_return_files/upload', [ReturnSignedItemController::class, 'store'])
    ->name('user_return_files.store');

        
    // List all return_files
    Route::get('/return_files', [ReturnSignedItemController::class, 'index'])
        ->name('return_files.index');

    // Download file
// In routes/web.php
    Route::get('/employees/{employee}/return_files/{returnFile}/download', 
    [ReturnSignedItemController::class, 'download'])
    ->name('return_files.download');

//Accountability Signed
    Route::post('/assets_signed_files/employee/{id}', [AssetSignedItemController::class, 'store'])
    ->name('assets_signed_files.store');

    Route::get('/assets_files/{assetSignedItem}/download', 
    [AssetSignedItemController::class, 'download'])
    ->name('asset_files.download');

//Item History upload file
    Route::post('/return_files/employee/{id}', [ItemHistoryController::class, 'store'])
    ->name('return_files.store');
    
//Item History Download file
    Route::get('/return_files/{returnedSignedItem}/download', 
    [ItemHistoryController::class, 'download'])
    ->name('return_files_history.download');

    require __DIR__.'/auth.php';    