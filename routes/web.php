<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\archiveController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ReportController;
use App\Models\invoices_details;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Route::middleware([
    'auth:sanctum',
    'userActive',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    
    Route::get('dashboard', [dashboardController::class, 'index'])->name('dashboard');

      
});

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});


// Auth::routes(['register' => false]);

Route::resource('invoices',InvoicesController::class);
Route::resource('sections',SectionsController::class);
Route::resource('products',ProductController::class);
Route::resource('attachments',InvoicesAttachmentsController::class);
Route::resource('details',InvoicesDetailsController::class);
Route::resource('archiveController',archiveController::class);
Route::get("section/{id}",[InvoicesController::class,"getdata"]);
Route::get("perview/{invoice_number}/{file_name}",[InvoicesAttachmentsController::class,"perview"]);
Route::get("download/{invoice_number}/{file_name}",[InvoicesAttachmentsController::class,"download"]);
Route::get("paid",[InvoicesController::class,"paid_invoces"]);
Route::get("unpaid",[InvoicesController::class,"unpaid_invoces"]);
Route::get("partially",[InvoicesController::class,"partially"]);
Route::get("getArchive",[InvoicesController::class,"get_archive"])->name("getArchive");
Route::get("print/{id}",[InvoicesController::class,"print"])->name("print");
Route::get('invoices/{id}/pdf', [InvoicesController::class,"generatePDF"])->name('invoices.generatePDF');
Route::get('markAsRead', [InvoicesController::class,"markAsRead"])->name('markAsRead');
Route::get('markAsOneRead/{id}/{invoice_id}', [InvoicesController::class,"markAsOneRead"])->name('markAsOneRead');
Route::get('export', [InvoicesController::class, 'export'])->name("export");
Route::get('reports', [ReportController::class, 'index']);
Route::get('getInvoiceNumber', [ReportController::class, 'get_invoice_number'])->name("getInvoiceNumber");
Route::get('getInvoices', [ReportController::class, 'get_invoices'])->name("getInvoices");
Route::get('sectionReport', [ReportController::class, 'section_report'])->name("sectionReport");
Route::get('show_table', [ReportController::class, 'show_table'])->name("show_table");


// Route::get("attachment/{id}",[InvoicesAttachmentsController::class,"index"])->name("attachment");


Route::get('/{page}',[AdminController::class,"home"]);
