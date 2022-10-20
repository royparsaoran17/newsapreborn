<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('login');
});

Route::get('/logout', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

// ADMIN
Route::get('/inquiry', function () {
    return view('admin.inquiry');
});

Route::get('/quotation', function () {
    return view('admin.quotation');
});

Route::get('/purchase-order', function () {
    return view('admin.purchase-order');
});

Route::get('/sales-order', function () {
    return view('admin.sales-order');
});

Route::get('/outbound-delivery', function () {
    return view('admin.outbound-delivery');
});

Route::get('/transfer-order', function () {
    return view('admin.transfer-order');
});

Route::get('/stock-overview', function () {
    return view('admin.stock-overview');
});

Route::get('/billing-document', function () {
    return view('admin.billing-document');
});

Route::get('/accounting-document', function () {
    return view('admin.accounting-document');
});

Route::get('/incoming-payment', function () {
    return view('admin.incoming-payment');
});

Route::get('/document-flow', function () {
    return view('admin.document-flow');
});

Route::get('/report', function () {
    return view('admin.report');
});

// USERS
Route::get('/user/inquiry', function () {
    return view('user.inquiry');
});

Route::get('/user/quotation', function () {
    return view('user.quotation');
});

Route::get('/user/purchase-order', function () {
    return view('user.purchase_order');
});

Route::get('/user/payment', function () {
    return view('user.payment');
});
