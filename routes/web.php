<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// LOGIN

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'login_action'])->name('login.action');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('register', [LoginController::class, 'register'])->name('register');
Route::post('register', [LoginController::class, 'register_action'])->name('register.action');

// ADMIN
// Route::get('/inquiry', [AdminController::class, 'inquiry'])->name('inquiry');
Route::get('/quotation', [AdminController::class, 'quotation'])->name('quotation');
Route::post('/quotation', [AdminController::class, 'quotation_action'])->name('quotation.action');

// Route::get('/purchase-order', [AdminController::class, 'purchase_order'])->name('purchase_order');
Route::get('/sales-order', [AdminController::class, 'sales_order'])->name('sales_order');
Route::post('/sales-order', [AdminController::class, 'sales_order_action'])->name('sales_order.action');

Route::get('/outbound-delivery', [AdminController::class, 'outbound_delivery'])->name('outbound_delivery');
Route::post('/outbound-delivery', [AdminController::class, 'outbound_delivery_action'])->name('outbound_delivery.action');
Route::post('/outbound-delivery/{id}', [AdminController::class, 'outbound_delivery_goodissue'])->name('outbound_delivery_goodissue');

Route::get('/transfer-order', [AdminController::class, 'transfer_order'])->name('transfer_order');
Route::post('/transfer-order', [AdminController::class, 'transfer_order_action'])->name('transfer_order.action');

Route::get('/stock-overview', [AdminController::class, 'stock_overview'])->name('stock_overview');
Route::post('/stock-overview', [AdminController::class, 'stock_overview_action'])->name('stock_overview.action');

Route::get('/billing-document', [AdminController::class, 'billing_document'])->name('billing_document');
Route::post('/billing-document', [AdminController::class, 'billing_document_action'])->name('billing_document.action');

Route::get('/accounting-document', [AdminController::class, 'accounting_document'])->name('accounting_document');
Route::post('/accounting-document', [AdminController::class, 'accounting_document_action'])->name('accounting_document.action');

Route::get('/incoming-payment', [AdminController::class, 'incoming_payment'])->name('incoming_payment');
Route::post('/incoming-payment', [AdminController::class, 'incoming_payment_action'])->name('incoming_payment.action');

Route::get('/document-flow', [AdminController::class, 'document_flow'])->name('document_flow');
Route::post('/document-flow', [AdminController::class, 'document_flow_action'])->name('document_flow.action');

Route::get('/report', [AdminController::class, 'report'])->name('report');
Route::post('/report', [AdminController::class, 'report_action'])->name('report.action');


// USERS
Route::get('/user/inquiry', [UserController::class, 'inquiry'])->name('inquiry');
Route::post('/user/inquiry', [UserController::class, 'inquiry_action'])->name('inquiry.action');

Route::get('/user/quotation', [UserController::class, 'quotation'])->name('quotation');

Route::get('/user/purchase-order', [UserController::class, 'purchase_order'])->name('purchase_order');
Route::post('/user/purchase-order', [UserController::class, 'purchase_order_action'])->name('purchase_order.action');

Route::get('/user/payment', [UserController::class, 'payment'])->name('payment');
Route::post('/user/payment', [UserController::class, 'payment_action'])->name('payment.action');


// DATA
Route::get('dropdown/company/{id}', [DataController::class, 'dropdown_company'])->name('dropdown_company');
Route::get('dropdown/material/{id}', [DataController::class, 'dropdown_material'])->name('dropdown_material');
Route::get('dropdown/quotation/{id}', [DataController::class, 'dropdown_quotation'])->name('dropdown_quotation');
Route::get('dropdown/billing-document/{id}', [DataController::class, 'dropdown_billing_document'])->name('dropdown_billing_document');
Route::get('dropdown/inquiry/{id}', [DataController::class, 'dropdown_inquiry'])->name('dropdown_inquiry');

Route::get('admin/dropdown/inquiry/{id}', [DataController::class, 'admin_dropdown_inquiry'])->name('admin_dropdown_inquiry');
Route::get('admin/dropdown/purchase-order/{id}', [DataController::class, 'admin_dropdown_purchase_order'])->name('admin_dropdown_purchase_order');
Route::get('admin/dropdown/sales-order/{id}', [DataController::class, 'admin_dropdown_sales_order'])->name('admin_dropdown_sales_order');
Route::get('admin/dropdown/outbound-delivery/{id}', [DataController::class, 'admin_dropdown_outbound_delivery'])->name('admin_dropdown_outbound_delivery');
Route::get('admin/dropdown/accounting-document/{id}', [DataController::class, 'admin_dropdown_accounting_document'])->name('admin_dropdown_accounting_document');
