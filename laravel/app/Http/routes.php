<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('test', 'TestController@test');

Route::get('voice', 'TestController@voice');

Route::get('input', 'TestController@input');

Route::get('/', 'HomeController@show');

Route::auth();

Route::get('verify', 'ProfileController@verify');

Route::get('resend', 'ProfileController@resendConfirmation');

Route::get('verify/change', 'ProfileController@changeEmail');

Route::get('/v/{id}/{code}', 'PublicController@activateUser');

Route::get('/home/', 'HomeController@show');

/*************************************************************************************************************
 *                                         User                                                              *
 *************************************************************************************************************/

Route::get('profile', 'ProfileController@index');

Route::post('profile', 'ProfileController@update');

Route::put('profile', 'ProfileController@changePicture');

Route::get('mysurveys', 'HomeController@mySurveys');

/*************************************************************************************************************
 *                                      Survey MANIPULATION                                                  *
 *************************************************************************************************************/

Route::get('/create/', 'SurveyController@index');

Route::post('/create/', 'SurveyController@create');

Route::post('/create/{id}', 'SurveyController@manipulateSurvey');

Route::put('/create/{id}', 'SurveyController@store');

Route::delete('/create/{id}' , 'SurveyController@destroy');

Route::get('/create/{id}', 'SurveyController@show');

Route::patch('/create/{id}', 'SurveyController@publish');

/*************************************************************************************************************
 *                                           SHARE                                                           *
 *************************************************************************************************************/

Route::get('/share/{id}', 'SurveyController@share');

/*************************************************************************************************************
 *                                          SETTINGS                                                         *
 *************************************************************************************************************/

Route::get('/settings/{id}', 'SurveyController@settings');

Route::post('/settings/{id}', 'SurveyController@update');

Route::patch('/settings/{id}', 'SurveyController@changeOptions');


/*************************************************************************************************************
 *                                          ANSWER                                                           *
 *************************************************************************************************************/

Route::get('/view/{id}', 'SurveyController@view');

Route::get('/answer/{id}', 'ResponseController@show');

Route::post('/answer/{id}', 'ResponseController@store');

/*************************************************************************************************************
 *                                         ANALYZE                                                           *
 *************************************************************************************************************/

Route::get('/analyze/{id}', 'ResultController@show');

Route::get('/analyze/{id}/summary', 'ResultController@summary');

Route::get('/analyze/{id}/user', 'ResultController@user');

Route::get('/analyze/{id}/result.pdf', 'ResultController@generatePdf');

Route::post('/analyze/{id}/user', 'ResultController@getDetails');

Route::post('/analyze/{id}/summary', 'ResultController@addFilter');

Route::delete('/analyze/{id}/summary', 'ResultController@removeFilter');


/*************************************************************************************************************
 *                                          OTHER                                                            *
 *************************************************************************************************************/

Route::get('survey/{id}', 'SurveyController@summary');

Route::get('admin', 'HomeController@show');

/*************************************************************************************************************
 *                                      TEMPLATE MANIPULATION                                                *
 *************************************************************************************************************/

Route::get('templates' , 'SurveyTemplateController@display');

Route::get('templates/{id}' , 'SurveyTemplateController@preview');

/*************************************************************************************************************
 *                                      ADMIN ROUTES                                                         *
 *************************************************************************************************************/

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function(){
    Route::get('/', 'HomeController@show');

    /*************************************************************************************************************
     *                                        USER MANIPULATION                                                  *
     *************************************************************************************************************/

    Route::get('users', 'UserController@index');

    Route::post('users', 'UserController@store');

    Route::patch('users', 'UserController@update');

    Route::group(['prefix' => 'templates'], function(){

        Route::get('/', 'SurveyTemplateController@index');

        Route::get('/create', 'SurveyTemplateController@create');

        Route::get('/create/{id}', 'SurveyTemplateController@show');
    });

    /*************************************************************************************************************
     *                                      SURVEY CATEGORIES                                                    *
     *************************************************************************************************************/

    Route::get('categories', 'SurveyCategoryController@index');

    Route::post('categories', 'SurveyCategoryController@store');

    Route::post('categories/update/{id}', 'SurveyCategoryController@update');

    Route::delete('categories/delete/{id}', 'SurveyCategoryController@destroy');

    /*************************************************************************************************************
     *                                      ROLE MANIPULATION                                                    *
     *************************************************************************************************************/

    Route::get('roles', 'RoleController@index');

    Route::post('roles', 'RoleController@store');

    Route::post('roles/update/{id}', 'RoleController@update');

    Route::delete('roles/delete/{id}', 'RoleController@destroy');

    Route::get('roles/{id}/permissions', 'RoleController@show');

    Route::post('roles/{id}/permissions', 'RoleController@setPermission');

    /*************************************************************************************************************
     *                                      MODULES MANIPULATION                                                 *
     *************************************************************************************************************/

    Route::get('modules', 'ModuleController@index');

});



/**********************************************************************************************************************
 *                                          API FOR ANDROID CLIENT                                                    *
 **********************************************************************************************************************/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function($api){
    $api->get('test/', 'App\Http\Controllers\AndroidController@index');

    $api->post('register/', 'App\Http\Controllers\AndroidController@register');

    $api->post('login', 'App\Http\Controllers\AndroidController@login');

    $api->get('user/{id}/surveys', 'App\Http\Controllers\AndroidController@show');

    $api->post('answer', 'App\Http\Controllers\AndroidController@store');

    $api->get('speech/{id}', 'App\Http\Controllers\AndroidController@downloadSpeech');

});


