<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Models\Invoice_details;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('signin');
});

Route::get('/dashboard', [HomeController::class,'index'])->middleware(['auth', 'verified','is_active'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth','is_active'])->group(function () {

    Route::resource('/invoices', InvoiceController::class);
    Route::resource('/sections', SectionController::class);
    Route::resource('/products', ProductController::class);
    Route::get('sections-del/{section}', [SectionController::class, 'delete']);
    Route::get('products-del/{product}', [ProductController::class, 'delete']);
    Route::get('/section/{id}', [InvoiceController::class, 'getProducts']);
    Route::resource('invoice-details', InvoiceDetailsController::class);
    Route::resource('invoice-attachment', InvoiceAttachmentsController::class);
    Route::get('view-file/{fileName}', [InvoiceDetailsController::class, 'getViewFile']);
    Route::get('download/{fileName}', [InvoiceDetailsController::class, 'downFile']);
    Route::get('del-file/{fileId}', [InvoiceDetailsController::class, 'deleteFile']);
    Route::get('del-invoice/{invoiceId}', [InvoiceController::class, 'deleteInvoice']);

    Route::post('invoice-archive/{id}', [InvoiceController::class, 'archiveInvoice']);
    Route::resource('archive', ArchiveController::class);
    Route::get('del-invoice-archive/{id}', [ArchiveController::class, 'delInvoiceFromArchive']);
    Route::get('payment-change/{id}', [InvoiceController::class, 'show']);
    Route::post('payment-change/{id}', [InvoiceController::class, 'paymentChange']);

    Route::get('/invoice_Paid', [InvoiceController::class, 'InvoicePaid']);
    Route::get('/invoice_UnPaid', [InvoiceController::class, 'InvoiceUnPaid']);
    Route::get('/invoice_Partial', [InvoiceController::class, 'InvoicePartial']);
    Route::get('print_invoice/{id}', [InvoiceController::class, 'printInvoice']);

    Route::get('users/export', [InvoiceController::class, 'export']);

    Route::get('/reports' , [ReportsController::class,'index']);
    Route::post('/search-report' , [ReportsController::class,'searchReport']);
    
    Route::get('/customers-reports' , [CustomersController::class,'index']);
    Route::post('/customers-search-report' , [CustomersController::class,'searchReport']);
});
Route::middleware('auth')->group(function () {
    
    // Our resource routes
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

require __DIR__ . '/auth.php';

/* Route::get('/{page}',[AdminController::class, 'index']); */
