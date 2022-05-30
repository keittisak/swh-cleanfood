<?php

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
// Route::get('/line-bot/reply','LineBotController@reply');
Route::post('/line-bot/reply','LineBotController@reply');
Route::get('/', function () {
    // return view('welcome');
    return redirect('/backoffice/dashboard');
});
Route::get('/artisan/storage', function() {
    $command = 'storage:link';
    $result = \Artisan::call($command);
    return \Artisan::output();
});

// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

// Authentication Routes...
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('auth.logout');
// Route::prefix('backoffice')->middleware(['auth','accessLog'])->group(function(){
Route::prefix('backoffice')->middleware(['auth', 'accessLog'])->group(function(){
    Route::get('/', function () {
        return redirect('/backoffice/dashboard');
    });
    Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');
    Route::get('/orders', 'OrderController@index')->name('orders.index');
    Route::get('/orders/data', 'OrderController@data')->name('orders.data');
    Route::get('/orders/history', 'OrderController@history')->name('orders.history');
    Route::get('/orders/create', 'OrderController@create')->name('orders.create');
    Route::post('/orders/store', 'OrderController@store')->name('orders.store');
    Route::get('/orders/{id}/edit','OrderController@edit')->name('orders.edit');
    Route::put('/orders/{id}/update', 'OrderController@update')->name('orders.update');
    Route::patch('/orders/{id}/status','OrderController@changeStatus')->name('orders.status');
    Route::patch('/orders/status/bulk','OrderController@changeStatusBatch')->name('orders.status.bulk');
    Route::delete('/orders/{id}', 'OrderController@destroy')->name('orders.destroy');

    Route::get('/orders/details', 'OrderDetailController@index')->name('orders.details.index');
    Route::get('/orders/details/confirm', 'OrderDetailController@confirm')->name('orders.details.confirm');
    Route::get('/orders/details/data', 'OrderDetailController@data')->name('orders.details.data');
    Route::patch('/orders/details/{id}/status','OrderDetailController@changeStatus')->name('orders.details.status');
    Route::patch('/orders/details/status/bulk','OrderDetailController@changeStatusBatch')->name('orders.details.status.bulk');
    Route::get('/orders/details/lists/print', 'OrderDetailController@listsPrint')->name('orders.details.lists.print');
    Route::get('/orders/details/label/print', 'OrderDetailController@labelPrint')->name('orders.details.label.print');

    Route::get('/products','ProductController@index')->name('products.index');
    Route::get('/products/data', 'ProductController@data')->name('products.data');
    Route::get('/products/create','ProductController@create')->name('products.create');
    Route::post('/products/store','ProductController@store')->name('products.store');
    Route::get('/products/{id}/edit','ProductController@edit')->name('products.edit');
    Route::put('/products/{id}/update','ProductController@update')->name('products.update');
    Route::delete('/products/{id}/delete','ProductController@destroy')->name('products.destroy');

    Route::get('/products/menu','MenuController@index')->name('products.menu.index');
    Route::get('/products/menu/data','MenuController@data')->name('products.menu.data');
    Route::get('/products/menu/create','MenuController@create')->name('products.menu.create');
    Route::post('/products/menu/store','MenuController@store')->name('products.menu.store');
    Route::get('/products/menu/{id}/edit','MenuController@edit')->name('products.menu.edit');
    Route::put('/products/menu/{id}/update','MenuController@update')->name('products.menu.update');
    Route::delete('/products/menu/{id}/delete','MenuController@destroy')->name('products.menu.destroy');

    
    Route::post('/customers/store', 'CustomerController@store')->name('customers.store');
    Route::put('/customers/{id}/update', 'CustomerController@update')->name('customers.update');
    Route::get('/customers/search-phone', 'CustomerController@searchPhone')->name('customers.search-phone');

    Route::get('courses', 'CourseController@index')->name('courses.index');
    Route::get('courses/data', 'CourseController@data')->name('courses.data');
    Route::get('courses/create', 'CourseController@create')->name('courses.create');
    Route::post('courses', 'CourseController@store')->name('courses.store');
    Route::get('courses/{id}/edit', 'CourseController@edit')->name('courses.edit');
    Route::put('courses/{id}/update', 'CourseController@update')->name('courses.update');
    Route::delete('courses/{id}', 'CourseController@destroy')->name('courses.destroy');
    
    Route::get('widgets/order/ajax', 'DashboardController@widgetOrder')->name('widget.order.ajax');
    Route::get('widgets/detail/ajax', 'DashboardController@widgetOrder')->name('widget.detail.ajax');

    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('users/data', 'UserController@data')->name('users.data');
    Route::get('users/create', 'UserController@create')->name('users.create');
    Route::post('users', 'UserController@store')->name('users.store');
    Route::get('users/{id}/edit', 'UserController@edit')->name('users.edit');
    Route::put('users/{id}/update', 'UserController@update')->name('users.update');
    Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy');

    Route::get('reports/sales', 'ReportController@sales')->name('reports.sales');
    Route::get('reports/sales/data', 'ReportController@salesData')->name('reports.sales.data');
    Route::get('reports/products', 'ReportController@products')->name('reports.products');
    Route::get('reports/products/data', 'ReportController@productData')->name('reports.products.data');
    Route::get('reports/end-course', 'ReportController@endCourseData')->name('reports.end-course.data');

});


