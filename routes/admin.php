<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\Category_scheduleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CoachController;
use App\Http\Controllers\Admin\GymController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Client\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Product_typeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\purchaseController;
use App\Http\Controllers\Admin\SupplierController;

Route::resource('categories',         CategoryController::class);
Route::resource('brands',             BrandController::class);
Route::resource('product_types',      Product_typeController::class);
Route::resource('gyms',               GymController::class);
Route::resource('category_schedules', Category_scheduleController::class);
Route::resource('coaches',            CoachController::class);
Route::resource('clients',            ClientController::class);
Route::resource('suppliers',          SupplierController::class);
Route::resource('purchases',          purchaseController::class);
Route::resource('invoices',            InvoiceController::class);

//Ruta para administrar Productos
Route::get('products/showProducts', [ProductController::class, 'showProducts'])
->name('products.showProducts.table');

Route::resource('products', ProductController::class);

// Rutas adicionales para pagos:
Route::get('clients/{client}/payments', [ClientController::class, 'showPaymentsForm'])
    ->name('clients.payments.form');

Route::post('clients/{client}/payments', [ClientController::class, 'storePayment'])
    ->name('clients.payments.store');

Route::post('/clients/{client}/payments', [ClientController::class, 'storeMonthlyPayment'])->name('clients.payments.store');


