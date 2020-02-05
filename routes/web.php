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

use App\Http\Controllers\ServiceTypeController;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['verify' => true, 'register' => false]);

// {token} is a required parameter that will be exposed to us in the controller method
Route::get('accept/{token}', 'InviteController@accept')->name('accept');
Route::post('create_password', 'InviteController@createPassword')->name('create_password');
Route::post('/password-strength', 'PasswordStrengthApi@calc');


Route::group(['middleware' => 'auth'], function () {

    Route::get('/api-user', 'UserApi@index');
    Route::get('/api-user/role-options', 'UserApi@getRoleOptions');
    Route::get('/api-user/options', 'UserApi@getOptions');
    Route::get('/user/download', 'UserController@download')->name('user.download');
    Route::get('/user/print', 'UserController@print')->name('user.print');
    Route::resource('/user', 'UserController');

    Route::get('/api-role-description', 'RoleDescriptionApi@index');
    Route::get('/api-role-description/options', 'RoleDescriptionApi@getOptions');
    Route::get('/role-description/download', 'RoleDescriptionController@download')->name('role-description.download');
    Route::get('/role-description/print', 'RoleDescriptionController@print')->name('role-description.print');
    Route::resource('/role-description', 'RoleDescriptionController');

    ///////////////////////////////////////////////////////////////////////////////
    // Invite Routes
    ///////////////////////////////////////////////////////////////////////////////
    //    Route::get('invite', 'InviteController@invite')->name('invite');
    //    Route::post('invite', 'InviteController@process')->name('process');
    Route::get('/invite/download', 'InviteController@download')->name('invite.download');
    Route::get('/invite/print', 'InviteController@print')->name('invite.print');
    Route::get('invite/{id}/resend', 'InviteController@resend')->name('invite.resend');
    Route::resource('/invite', 'InviteController');
    Route::get('/api-invite', 'InviteApi@index');

    ///////////////////////////////////////////////////////////////////////////////
    // Change Password Routes
    ///////////////////////////////////////////////////////////////////////////////
    Route::get('/change-password', 'ChangePasswordController@changePassword')->name('change_password');
    Route::post('/update-password', 'ChangePasswordController@updatePassword');



    Route::get('/api-applicant', 'ApplicantApi@index');
    Route::get('/api-applicant/options', 'ApplicantApi@getOptions');
    Route::get('/applicant/add', 'ApplicantController@add');
    Route::post('/applicant/add-from-ss', 'ApplicantController@add_from_ss');
    Route::post('/applicant/file-upload', 'ApplicantController@file_upload');

    Route::get('/applicant/download', 'ApplicantController@download');
    Route::resource('/applicant', 'ApplicantController');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/changePassword', 'HomeController@showChangePasswordForm');
    Route::post('/changePassword', 'HomeController@changePassword')->name('changePassword');

    Route::get('/api-applicant', 'ApplicantApi@index');
    Route::get('/api-applicant/options', 'ApplicantApi@getOptions');
    Route::get('/applicant/download', 'ApplicantController@download')->name('applicant.download');
    Route::get('/applicant/print', 'ApplicantController@print')->name('applicant.print');
    Route::resource('/applicant', 'ApplicantController');

    Route::get('/api-status', 'StatusApi@index');
    Route::get('/api-status/options', 'StatusApi@getOptions');
    Route::get('/status/download', 'StatusController@download')->name('status.download');
    Route::get('/status/print', 'StatusController@print')->name('status.print');
    Route::resource('/status', 'StatusController');

    Route::get('/api-assignment', 'AssignmentApi@index');
    Route::get('/api-assignment/options', 'AssignmentApi@getOptions');
    Route::get('/assignment/download', 'AssignmentController@download')->name('assignment.download');
    Route::get('/assignment/print', 'AssignmentController@print')->name('assignment.print');
    Route::resource('/assignment', 'AssignmentController');

    Route::get('/api-conviction', 'ConvictionApi@index');
    Route::get('/api-conviction/options', 'ConvictionApi@getOptions');
    Route::get('/conviction/download', 'ConvictionController@download')->name('conviction.download');
    Route::get('/conviction/print', 'ConvictionController@print')->name('conviction.print');
    Route::resource('/conviction', 'ConvictionController');

    Route::get('/api-charge', 'ChargeApi@index');
    Route::get('/api-charge/options', 'ChargeApi@getOptions');
    Route::get('/charge/download', 'ChargeController@download')->name('charge.download');
    Route::get('/charge/print', 'ChargeController@print')->name('charge.print');
    Route::resource('/charge', 'ChargeController');

    Route::get('/api-data-source', 'DataSourceApi@index');
    Route::get('/api-data-source/options', 'DataSourceApi@getOptions');
    Route::get('/data-source/download', 'DataSourceController@download')->name('data-source.download');
    Route::get('/data-source/print', 'DataSourceController@print')->name('data-source.print');
    Route::resource('/data-source', 'DataSourceController');

    Route::get('/api-step', 'StepApi@index');
    Route::get('/api-step/options', 'StepApi@getOptions');
    Route::get('/step/download', 'StepController@download')->name('step.download');
    Route::get('/step/print', 'StepController@print')->name('step.print');
    Route::resource('/step', 'StepController');

    Route::get('/api-statute', 'StatuteApi@index');
    Route::get('/api-statute/options', 'StatuteApi@getOptions');
    Route::get('/statute/download', 'StatuteController@download')->name('statute.download');
    Route::get('/statute/print', 'StatuteController@print')->name('statute.print');
    Route::resource('/statute', 'StatuteController');

    Route::get('/api-comment', 'CommentApi@index');
    Route::get('/api-comment/options', 'CommentApi@getOptions');
    Route::get('/comment/download', 'CommentController@download')->name('comment.download');
    Route::get('/comment/print', 'CommentController@print')->name('comment.print');
    Route::resource('/comment', 'CommentController');

    Route::get('/api-statutes-eligibility/options', 'StatutesEligibilityApi@getOptions');

    Route::group(['prefix' => '/cms'], function () {
        Route::get('/{cms_matter_number}', 'ApplicantController@show');
        Route::get('/{cms_matter_number}/edit', 'ApplicantController@edit');
    });

    Route::group(['prefix' => 'history'], function () {
        Route::get('charge/{charge}', 'HistoryController@charge');
        Route::get('conviction/{conviction}', 'HistoryController@conviction');
        Route::get('applicant/{client}', 'HistoryController@client');
    });


    Route::group(['prefix' => 'case/{case}/service'], function () {
        Route::post('/create', 'CaseServiceController@store')->name('case-service.store');
        Route::put('/{service}', 'CaseServiceController@update')->name('case-service.update');
        Route::delete('/{service}', 'CaseServiceController@destroy')->name('case-service.destroy');
    });


    Route::get('statutes/all', 'StatuteController@all');
    Route::get('services/all', 'ServiceController@all');
    Route::get('service-types/all', 'ServiceTypeController@all');

    Route::get('/api-service-type', 'ServiceTypeApi@index');
    Route::get('/api-service-type/options', 'ServiceTypeApi@getOptions');
    Route::get('/service-type/download', 'ServiceTypeController@download')->name('service-type.download');
    Route::get('/service-type/print', 'ServiceTypeController@print')->name('service-type.print');
    Route::resource('/service-type', 'ServiceTypeController');

    Route::get('/api-service', 'ServiceApi@index');
    Route::get('/api-service/options', 'ServiceApi@getOptions');
    Route::get('/service/download', 'ServiceController@download')->name('service.download');
    Route::get('/service/print', 'ServiceController@print')->name('service.print');
    Route::resource('/service', 'ServiceController');

    Route::get('/api-applicant', 'ApplicantApi@index');
    Route::get('/api-applicant/options', 'ApplicantApi@getOptions');
    Route::get('/applicant/download', 'ApplicantController@download')->name('applicant.download');
    Route::get('/applicant/print', 'ApplicantController@print')->name('applicant.print');
    Route::resource('/applicant', 'ApplicantController');
});






Route::get('/api-jurisdiction-type', 'JurisdictionTypeApi@index');
Route::get('/api-jurisdiction-type/options', 'JurisdictionTypeApi@getOptions');
Route::post('/api-jurisdiction-type', 'JurisdictionTypeApi@store');

Route::get('/jurisdiction-type/download', 'JurisdictionTypeController@download')->name('jurisdiction-type.download');
Route::get('/jurisdiction-type/print', 'JurisdictionTypeController@print')->name('jurisdiction-type.print');
Route::resource('/jurisdiction-type', 'JurisdictionTypeController');

Route::get('/api-jurisdiction', 'JurisdictionApi@index');
Route::get('/api-jurisdiction/options', 'JurisdictionApi@getOptions');
Route::post('/api-jurisdiction', 'JurisdictionApi@store');

Route::get('/jurisdiction/download', 'JurisdictionController@download')->name('jurisdiction.download');
Route::get('/jurisdiction/print', 'JurisdictionController@print')->name('jurisdiction.print');
Route::resource('/jurisdiction', 'JurisdictionController');
