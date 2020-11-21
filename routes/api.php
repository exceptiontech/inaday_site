<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');
Route::post('forgot', 'API\PassportController@forgot');
Route::post('/{type}/google', 'API\PassportController@google')->name('google');
Route::post('/auth/google/redirect', 'API\PassportController@googleRedirect');


Route::get('projects', 'API\ProjectController@index');
Route::get('projects/{id}', 'API\ProjectController@show');
Route::get('projects/{id}/offers', 'API\ProjectController@offers');

Route::get('services', 'API\ServiceController@index');
Route::get('services/{id}', 'API\ServiceController@show');

Route::get('mixtures', 'API\MixtureController@index');
Route::get('mixtures/{id}', 'API\MixtureController@show');

Route::get('countries', 'API\CountryController@index');
Route::get('countries/{id}', 'API\CountryController@show');

Route::get('cities', 'API\CityController@index');
Route::get('cities/{id}', 'API\CityController@show');

Route::get('skills', 'API\SkillController@index');
Route::get('skills/{id}', 'API\SkillController@show');

Route::get('sections', 'API\SectionController@index');
Route::get('sections/{id}', 'API\SectionController@show');

Route::get('pages', 'API\PageController@index');
Route::get('pages/{id}', 'API\PageController@show');


Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');
    Route::post('profile', 'API\PassportController@profile');


    // Projects
    Route::resource('account/projects', 'API\Account\ProjectController', ['names' => 'front_projects']);
    Route::get('account/projects/delete/{id}', 'API\Account\ProjectController@delete')->name('projects.delete');

    // Offers
    Route::resource('offers', 'API\OfferController')->except(['show']);

    // Services
    Route::resource('account/services', 'API\Account\ServiceController', ['names' => 'front_services']);
    Route::get('account/services/delete/{id}', 'API\Account\ServiceController@delete')->name('services.delete');

    // mixture
    Route::resource('account/mixtures', 'API\Account\MixtureController', ['names' => 'front_mixtures']);
    Route::get('account/mixtures/create/{id}', 'API\Account\MixtureController@create')->name('mixtures.create');
    Route::get('account/mixtures/delete/{id}', 'API\Account\MixtureController@delete')->name('mixtures.delete');

    // Portfolio
    Route::resource('account/portfolios', 'API\Account\PortfolioController', ['names' => 'front_services']);
    Route::get('account/portfolios/delete/{id}', 'API\Account\PortfolioController@delete')->name('portfolios.delete');



});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
