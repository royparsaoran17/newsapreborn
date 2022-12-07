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

Route::get('/material-purchasing', [AdminController::class, 'material_purchasing'])->name('material_purchasing');
Route::post('/material-purchasing', [AdminController::class, 'material_purchasing_action'])->name('material_purchasing.action');

Route::get('/report', [AdminController::class, 'report'])->name('report');

Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
Route::post('/logs', [AdminController::class, 'logs_action'])->name('logs.action');

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

// SOFT DELETE
Route::post('accounting-document/{id}/delete', [DataController::class, 'accounting_document_delete'])->name('accounting_document_delete');
Route::post('billing-document/{id}/delete', [DataController::class, 'billing_document_delete'])->name('billing_document_delete');
Route::post('company/{id}/delete', [DataController::class, 'company_delete'])->name('company_delete');
Route::post('document-flow/{id}/delete', [DataController::class, 'document_flow_delete'])->name('document_flow_delete');
Route::post('incoming-payment/{id}/delete', [DataController::class, 'incoming_payment_delete'])->name('incoming_payment_delete');
Route::post('inquiry/{id}/delete', [DataController::class, 'inquiry_delete'])->name('inquiry_delete');
Route::post('material/{id}/delete', [DataController::class, 'material_delete'])->name('material_delete');
Route::post('outbound-delivery/{id}/delete', [DataController::class, 'outbound_delivery_delete'])->name('outbound_delivery_delete');
Route::post('purchase-order/{id}/delete', [DataController::class, 'purchase_order_delete'])->name('purchase_order_delete');
Route::post('quotation/{id}/delete', [DataController::class, 'quotation_delete'])->name('quotation_delete');
Route::post('report/{id}/delete', [DataController::class, 'report_delete'])->name('report_delete');
Route::post('sales-order/{id}/delete', [DataController::class, 'sales_order_delete'])->name('sales_order_delete');
Route::post('transfer-order/{id}/delete', [DataController::class, 'transfer_order_delete'])->name('transfer_order_delete');
Route::post('users-payment/{id}/delete', [DataController::class, 'user_payment_delete'])->name('user_payment_delete');
Route::post('users/{id}/delete', [DataController::class, 'user_delete'])->name('user_delete');
