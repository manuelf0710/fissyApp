<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    //return view('welcome');
/*
	$data = array("algo"=>"si");
        $subject = "Asunto del correo desde locall";
        $for = "manuelf0710@gmail.com";
        Mail::send('welcome',$data, function($msj) use($subject,$for){
            $msj->from("info@myfissy.com","fissy");
            $msj->subject($subject);
            $msj->to($for);
        });*/
    //return view('auth/login');
     return redirect('/home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
*
*Routes for auth 
*
 */
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'confirm']);
Route::get('email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');

Route::get('/users/conectar', 'UserController@conectar')->name('user_conectar');


Route::group(['middleware' => ['auth']], function () {
    Route::post('/users/invite', [App\Http\Controllers\HomeController::class, 'invitarfissy'])->name('invitar_fissy');
    Route::post('/users/contacto', [App\Http\Controllers\HomeController::class, 'contactofissy'])->name('contacto_fissy');
    Route::post('/users/referido', [App\Http\Controllers\HomeController::class, 'referidofissy'])->name('referido_fissy');
    Route::get('/users/aprobar_referido_lista', [App\Http\Controllers\HomeController::class, 'aprobarReferidoLista'])->name('aprobar_referido_lista');
    Route::post('/users/aprobar_referido', [App\Http\Controllers\HomeController::class, 'aprobarReferido'])->name('aprobar_referido');
    Route::get('/users/aprobar_contacto_lista', [App\Http\Controllers\HomeController::class, 'aprobarContactoLista'])->name('aprobar_contacto_lista');
    Route::post('/users/aprobar_contacto', [App\Http\Controllers\HomeController::class, 'aprobarContacto'])->name('aprobar_contacto_fissy');
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('view_table_users');
    Route::get('/users/lista', [App\Http\Controllers\UserController::class, 'getData'])->name('list_users');
    Route::get('/users/{id_user}', [App\Http\Controllers\UserController::class, 'edit'])->name('user_edit');
    Route::post('/users/update/{id_user}', [App\Http\Controllers\UserController::class, 'update'])->name('user_upd');    
    Route::get('situacion/financiera', [App\Http\Controllers\FinancieraController::class, 'index'])->name('situacion_financiera');
    Route::get('gastos/lista', [App\Http\Controllers\FinancieraController::class, 'getData'])->name('gastos_lista');
    Route::get('gastos', [App\Http\Controllers\GastoController::class, 'index'])->name('gastos');
    Route::post('gastos/import/excel', [App\Http\Controllers\GastoController::class, 'import'])->name('gastos_import');
    Route::get('misdatos', [App\Http\Controllers\UserController::class, 'misDatos'])->name('misdatos');    
    Route::post('soportes/extractos', [App\Http\Controllers\SoporteController::class, 'store'])->name('add_extractos');
	
	Route::group(['middleware' => 'admin'], function () { 
	/*
	*
	* Middleware nombre admin solo permite usuarios con id_perfil 1 super admin
	* /app/Http/middleware/AdminMiddleware.php
	*/
        Route::get('/users/admin/{id_user}', [App\Http\Controllers\UserController::class, 'editForAdmin'])->name('user_admin_edit');
        Route::post('/users/admin/update/{id_user}', [App\Http\Controllers\UserController::class, 'updateForAdmin'])->name('user_admin_upd');
        Route::get('users/export/excel', [App\Http\Controllers\UserController::class, 'exportUsers'])->name('users_export');
	});	
    



	Route::prefix('fissy')->group(function () {
        Route::get('/home', [App\Http\Controllers\FissyController::class, 'create'])->name('fissy_crear');
        Route::get('store', [App\Http\Controllers\FissyController::class, 'store'])->name('fissy_store');
        Route::get('', [App\Http\Controllers\FissyController::class, 'index'])->name('view_table_fissy');
        Route::get('lista', [App\Http\Controllers\FissyController::class, 'getData'])->name('fissy_list');
        Route::get('lista2/{type}', [App\Http\Controllers\FissyController::class, 'getData'])->name('fissy_list2');
        Route::get('plan/{id_fissy}', [App\Http\Controllers\FissyController::class, 'viewPlan'])->name('fissy_plan');
        Route::get('edit/{id_fissy}', [App\Http\Controllers\FissyController::class, 'edit'])->name('fissy_edit');
        Route::get('update/{id_fissy}', [App\Http\Controllers\FissyController::class, 'update'])->name('fissy_upd');
        Route::get('aplicar/{id_fissy}', [App\Http\Controllers\FissyController::class, 'aplicar'])->name('fissy_aplicar');
        Route::get('confirmar/table/view', [App\Http\Controllers\FissyController::class, 'confirmarTableView'])->name('fissy_confirmar_view');
        Route::get('confirmar/aplicar/{id_fissy}', [App\Http\Controllers\FissyController::class, 'confirmarAplicar'])->name('fissy_confirmar_aplicar');
        Route::get('pagos/ingresos', [App\Http\Controllers\PagoIngresoController::class, 'index'])->name('fissy_pagos_ingresos');
        Route::get('pagos/mispagos', [App\Http\Controllers\PagoIngresoController::class, 'misPagos'])->name('fissy_mispagos');
        Route::get('pagos/misingresos', [App\Http\Controllers\PagoIngresoController::class, 'misIngresos'])->name('fissy_misingresos');		
	});	
	
});		
