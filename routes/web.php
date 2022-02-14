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

/* Route::get('/', function () {
    return view('welcome');
})->name('welcome'); */

Route::redirect('/', 'login')->name('welcome');

// Auth::routes();
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth','authorize']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/notifications', 'NotificationController@index')->name('notifications.index');
    Route::get('/notifications/mark-as-read', 'NotificationController@markAsRead')->name('notifications.mark-as-read');
    Route::get('/notifications/destroy', 'NotificationController@destroy')->name('notifications.destroy');

    Route::resource('branches', 'BranchController')->except(['show']);
    Route::resource('departments', 'DepartmentController')->except(['show']);
    Route::get('departments/{id}/get-designation', 'DepartmentController@getDesignation')->name('departments.get-designation');
    Route::resource('designations', 'DesignationController')->except(['show']);
    Route::resource('employees', 'EmployeeController');

//    EmployeeDocument Route
    Route::post('employees/{id}/documents', 'EmployeeDocumentController@store')->name('employees.document.store');
    Route::delete('employees/{employeeId}/documents/{id}', 'EmployeeDocumentController@destroy')->name('employees.document.destroy');

    //    Employee Banks Route
    Route::post('employees/{employeeId}/banks', 'EmployeeBankController@store')->name('employees.bank.store');
    Route::put('employees/{employeeId}/banks/{id}', 'EmployeeBankController@update')->name('employees.bank.update');
    Route::delete('employees/{employeeId}/banks/{id}', 'EmployeeBankController@destroy')->name('employees.bank.destroy');
    // AllowancesDeductions
    Route::group(['as' => 'payroll.', 'prefix' => 'payroll'], function () {
        Route::group(['as'=>'salary.manager.','prefix' => 'salary-manager'], function () {
            Route::get('/', 'SalaryManagerController@index')->name('index');
            Route::get('/{eCode}', 'SalaryManagerController@manage')->name('manage');
            Route::post('/{eCode}/allowance', 'SalaryManagerController@storeAllowance')->name('allowance.store');
            Route::delete('/{eCode}/allowance/{id}', 'SalaryManagerController@destroyAllowance')->name('allowance.destroy');
            Route::post('/{eCode}/deduction', 'SalaryManagerController@storeDeduction')->name('deduction.store');
            Route::delete('/{eCode}/deduction/{id}', 'SalaryManagerController@destroyDeduction')->name('deduction.destroy');

            Route::post('/{eCode}/increment', 'SalaryManagerController@storeIncrement')->name('increment.store');
            Route::delete('/{eCode}/increment/{id}', 'SalaryManagerController@destroyIncrement')->name('increment.destroy');
        });
        Route::group(['as'=>'salary.increment.','prefix' => 'salary-increment'], function () {
            Route::get('/', 'SalaryIncrementController@index')->name('index');
        });
        Route::resource('payslips', 'PayslipController');
        Route::get('payslips/{id}/print', 'PayslipController@print')->name('payslips.print');
    });

    Route::resource('expenses', 'ExpenseController')->except(['show']);

    Route::group(['as'=>'leave.','prefix' => 'leave'], function () {
        Route::resource('types', 'LeaveTypeController')->except(['create', 'show', 'edit', ]);
        Route::resource('applications', 'LeaveApplicationController')->except(['show']);
    });

    Route::resource('attendances', 'AttendanceController')->except(['show']);
    Route::get('attendances/report', 'AttendanceReportController@index')->name('attendances.report');
    Route::get('attendances/report/print', 'AttendanceReportController@print')->name('attendances.print');

    Route::group(['as'=>'award.','prefix' => 'award'], function () {
        Route::resource('types', 'AwardTypeController')->except(['create', 'show', 'edit', ]);
    });
    Route::resource('awards', 'AwardController')->except(['show']);
    Route::resource('events', 'EventController')->except(['show']);
    Route::get('calendar', 'EventController@calendar')->name('events.calendar');

    Route::resource('noticeboard', 'NoticeController');

    // only for devloper
    // Route::resource('permissions', 'PermissionController')->except(['show', 'edit', 'update']);

    Route::resource('roles', 'RoleController')->except(['show']);
    Route::resource('users', 'UserController');

    Route::get('profile', 'UserController@profile')->name('users.profile');
    Route::post('profile', 'UserController@profileUpdate')->name('users.profile.update');
    Route::get('change-password', 'UserController@changePassword')->name('users.password.change');
    Route::put('change-password', 'UserController@updatePassword')->name('users.password.update');

    Route::get('settings', 'SettingController@index')->name('settings.index');
    Route::put('settings', 'SettingController@update')->name('settings.update');
});
