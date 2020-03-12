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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Auth::routes([
    'register' => false,
]);

//Route::get('/login','LoginController@index')->name('login');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', 'HomeController@home')->name('home');
    Route::get('edit-profile', 'HomeController@editProfile')->name('edit-profile');
    Route::post('edit_employee', 'HomeController@editEmployee')->name('edit_employee');

    // Agreements
    Route::group(['prefix' => 'agreements', 'as' => 'agreements.'], function () {
        Route::get('', 'AgreementController@index')->name('index');
        Route::post('', 'AgreementController@store')->name('store');
        Route::delete('/{agreement}', 'AgreementController@destroy')->name('destroy')->middleware('isAdmin');
        Route::get('/search', 'AgreementController@search')->name('search');
    });

    // Expenses
    Route::resource('expenses', 'ExpenseController')->middleware('can:expenses-enabled');
    Route::group(['prefix' => 'expenses', 'as' => 'expenses.', 'middleware' => 'can:expenses-enabled'], function () {
        Route::post('/new/approve/{expense}', 'ExpenseController@approve')->name('approve')->middleware('isAdmin');
        Route::post('/new/reject/{expense}', 'ExpenseController@reject')->name('reject')->middleware('isAdmin');

        Route::post('/new/history', 'ExpenseController@searchHistory')->name('history');
        Route::POST('/pending', 'ExpenseController@searchPending')->name('pending');
    });

    // Additional Benefits Spending
    Route::resource('additionl_benifits_spendings', 'AdditionlBenifitsSpendingController')->middleware('can:additional-spending-enabled');
    Route::group(['prefix' => 'additionl_benifits_spendings', 'as' => 'additionl_benifits_spendings.', 'middleware' => 'can:additional-spending-enabled'], function () {
        Route::post('/approve/{additionl_benifits_spending}', 'AdditionlBenifitsSpendingController@approve')->name('approve')->middleware('isAdmin');
        Route::post('/reject/{additionl_benifits_spending}', 'AdditionlBenifitsSpendingController@reject')->name('reject')->middleware('isAdmin');

        Route::post('/paid/{additionl_benifits_spending}', 'AdditionlBenifitsSpendingController@paid')->name('paid');
        Route::post('/non-paid/{additionl_benifits_spending}', 'AdditionlBenifitsSpendingController@nonPaid')->name('non-paid');

        Route::post('/history', 'AdditionlBenifitsSpendingController@searchHistory')->name('history');
        Route::post('/pending', 'AdditionlBenifitsSpendingController@searchPending')->name('pending');
    });

    // Personal development plan
    Route::resource('personal_development_plans', 'PersonalDevelopmentPlanController')->middleware('can:classroom-enabled');
    Route::group(['prefix' => 'personal_development_plans', 'as' => 'personal_development_plans.', 'middleware' => 'can:classroom-enabled'], function () {
        Route::post('/comment/store/{id}', 'PersonalDevelopmentPlanController@commentStore')->name('comment.store');
        Route::post('/comment/update/{id}', 'PersonalDevelopmentPlanController@commentUpdate')->name('comment.update');

        Route::post('/archive', 'PersonalDevelopmentPlanController@searchArchive')->name('archive');
    });

    // Company
    Route::resource('companies', 'CompanyController')->middleware('isAdmin');
    Route::group(['prefix' => 'companies', 'as' => 'companies.', 'middleware' => 'isAdmin'], function () {
        Route::post('/search', 'CompanyController@searchCompanyPage')->name('search');
    });

    // Efficiency
    Route::group(['prefix' => 'efficiency', 'as' => 'efficiency.', 'middleware' => 'isAdmin'], function () {
        Route::get('', 'EfficiencyController@index')->name('index');
    });

    Route::post('/reset_apssword', 'RegisterController@resetPassword')->name('reset_apssword');
    Route::post('/registration', 'RegisterController@store')->name('registration');

    // Maintenance
    Route::group(['prefix' => 'maintenance_tickets', 'as' => 'maintenance_tickets.', 'middleware' => 'can:maintenance-enabled'], function () {
        Route::post('/ticket_inprogress/{maintenance_ticket}', 'MaintenanceController@ticketInProgress')->name('ticket_inprogress')->middleware('isAdmin');
        Route::post('/ticket_cancel/{maintenance_ticket}', 'MaintenanceController@ticketCancel')->name('ticket_cancel')->middleware('isAdmin');
        Route::get('search', 'MaintenanceController@search')->name('search');

        Route::post('/comment/store/{maintenance_ticket}', 'MaintenanceController@commentStore')->name('comment.store');
        Route::post('/comment/update/{maintenance_ticket}', 'MaintenanceController@commentUpdate')->name('comment.update');
    });
    Route::resource('maintenance_tickets', 'MaintenanceController')->middleware('can:maintenance-enabled');

    // Mileage
    Route::resource('mileages', 'MileageController')->middleware('can:mileage-enabled');
    Route::group(['prefix' => 'mileages', 'as' => 'mileages.', 'middleware' => 'can:mileage-enabled'], function () {
        Route::post('/pending/{mileage}', 'MileageController@mileagePending')->name('pending')->middleware('isAdmin');
        Route::post('/approve/{mileage}', 'MileageController@mileageApprove')->name('approve')->middleware('isAdmin');
        Route::post('/reject/{mileage}', 'MileageController@mileageReject')->name('reject')->middleware('isAdmin');
        Route::post('/search/pending', 'MileageController@searchPendingMileage')->name('searchPending');
        Route::post('/search/history', 'MileageController@searchHistoryMileage')->name('searchHistory');
    });

    // Journal
    Route::group(['middleware' => 'can:classroom-enabled'], function () {
        Route::post('journal/search', 'JournalController@searchJournal')->name('journal.search-journal');
        Route::post('/destroy/{journal}', 'JournalController@destroy')->name('journal.destroy');
        Route::resource('journal', 'JournalController')->only(['index','store','edit','update']);
    });

    // Timeoff route
    Route::group(['prefix' => 'timeoff', 'as' => 'timeoff.'], function () {
        Route::get('/list', 'TimeoffController@timeOffList')->name('list');
    });

    // Paystatement route
    Route::group(['prefix' => 'paystatements', 'as' => 'paystatements.', 'middleware' => 'can:pay-statement-enabled'], function () {
        Route::get('', 'PaystatementController@index')->name('index');
        Route::post('', 'PaystatementController@store')->name('store');
        Route::get('/search', 'PaystatementController@searchPaymentPage')->name('search');
        Route::delete('/{id}', 'PaystatementController@destroy')->name('destroy');
    });

    Route::get('force-login/{user}', 'UserController@forceLogin')->name('force-login');
    Route::get('users/search', 'UserController@search')->name('users.search');

    // Plan routes go here
    Route::group(['prefix' => 'plans', 'as' => 'plans.', 'middleware' => 'can:plan-overview-enabled'], function () {
    Route::get('/', 'PlanController@index')->name('index');
    Route::post('/store', 'PlanController@store')->name('store');
    Route::put('/{plan}', 'PlanController@update')->name('update');
    });

    // Missions routes go here
    Route::group(['prefix' => 'missions', 'as' => 'missions.', 'middleware' => 'can:classroom-enabled'], function () {
    Route::get('/', 'MissionController@index')->name('index');
    Route::post('/store', 'MissionController@store')->name('store');
    Route::put('/{plan}', 'MissionController@update')->name('update');
    });

    // Messages routes go here
    Route::group(['prefix' => 'messages', 'as' => 'messages.'], function () {
        Route::get('/search', 'MessageController@search')->name('search');
        Route::put('/status/{message}', 'MessageController@statusUpdate')->name('status.update');
    });
    Route::resource('messages', 'MessageController');

    Route::group(['prefix' => 'classroom', 'as' => 'employee.classroom.'], function () {
        Route::get('courses','EmployeeClassroomController@courses')->name('courses');
        Route::get('chapters/{course}','EmployeeClassroomController@chapters')->name('chapters');
        Route::get('take-course/{chapter}','EmployeeClassroomController@takeCourse')->name('take-course');
        Route::post('save','EmployeeClassroomController@save')->name('save');
        Route::get('repeat-chapter/{chapter}','EmployeeClassroomController@repeatChapter')->name('repeat-chapter');
    });
    Route::resource('classroom','EmployeeClassroomController');
});

Route::resource('posts', 'PostController');

Route::post('/reset/password/{id}', 'UserController@changeUserPassword')->name('reset.password');
Route::post('/reset/stuff/password/{id}', 'UserController@changeStuffPassword')->name('reset.stuff.password');
Route::get('/employee/module', 'HomeController@employeeModule')->name('employee.module');
Route::get('/benefits/module', 'HomeController@benefitsModule')->name('benefits.module');

