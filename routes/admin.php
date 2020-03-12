<?php

use Illuminate\Support\Facades\Route;

/**
 * @todo Update these controllers to match the rest (location and naming convention)
 */
Route::group(['middleware' => ['auth', 'isAdmin']], function () {
    Route::resource('users', 'UserController');
});


Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'isAdmin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('pay-statements', 'AdminPaystatementController@paystatement')->name('pay-statements');

    Route::get('agreement', 'AdminAgreementController@agreementlist')->name('agreement-list');

    Route::get('registration', 'AdminController@index')->name('registration');
    Route::get('expences_report', 'AdminController@expences_report')->name('expense-report');
    Route::get('milegebook', 'AdminController@milegebook')->name('mileage-book');
    Route::get('tech_maintanance', 'AdminController@tech_maintanance')->name('tech-maintenance');
    Route::get('timeoff', 'AdminController@timeoff')->name('timeoff');
    Route::get('reportconcern', 'AdminController@reportconcern')->name('report-concern');
    Route::post('add_registration', 'AdminController@add_registration')->name('add-registration');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.','middleware' => ['auth', 'isAdmin']], function () {
    // permissions
    Route::resource('permissions', 'AdminPermissionsController');
    Route::resource('roles', 'AdminRolesController');

    ## ClassRoom
    Route::group(['prefix' => 'classroom', 'as' => 'classroom.'], function () {

        Route::get('view-results/{user}/{course}','AdminClassroomController@viewCourseUserResults')->name('view-results');

        Route::group(['prefix' => 'chapter', 'as' => 'chapter.'], function () {
            Route::get('{course}', 'AdminClassroomController@chapters')->name('list');
            Route::get('create/{course}','AdminClassroomController@createChapter')->name('create');
            Route::post('store','AdminClassroomController@storeChapter')->name('store');
            Route::get('edit/{chapter}','AdminClassroomController@editChapter')->name('edit');
            Route::delete('destroy/{chapter}','AdminClassroomController@deleteChapter')->name('destroy');

            Route::any('add-question/{chapter}','AdminClassroomController@addQuestion')->name('add-question');
            Route::post('save-question/{chapter}','AdminClassroomController@saveQuestion')->name('save-question');
            Route::get('edit-question/{question}','AdminClassroomController@editQuestion')->name('edit-question');
            Route::delete('delete-question/{question}','AdminClassroomController@deleteQuestion')->name('destroy-question');

            Route::post('update-question-order','AdminClassroomController@updateQuestionOrder')->name('update-question-order');
            Route::post('update-chapter-order','AdminClassroomController@updateChapterOrder')->name('update-chapter-order');


            Route::get('view-chapter-results/{user}/{chapter}','AdminClassroomController@viewChapterResults')->name('view-chapter-results');
        });
    });
    Route::resource('classroom','AdminClassroomController',['except' => 'show','updated']);
});


