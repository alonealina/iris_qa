<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\IrisController@faq')->name('faq');

Route::get('admin/faq_list', 'App\Http\Controllers\IrisController@faq_list')->name('admin.faq_list')->middleware('login_admin');
Route::get('admin/faq_regist', 'App\Http\Controllers\IrisController@faq_regist')->name('admin.faq_regist')->middleware('login_admin');
Route::get('admin/faq_store', 'App\Http\Controllers\IrisController@faq_store')->name('admin.faq_store')->middleware('login_admin');


// 管理側ログイン
Route::get('admin/login', function () { return view('login_admin'); });

Route::POST('/admin_login', 'App\Http\Controllers\IrisController@login_admin')->name('admin.login');
Route::get('/admin_logout', 'App\Http\Controllers\IrisController@logout_admin')->name('admin.logout')->middleware('login_admin');