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


Route::get('faqs', 'API\FaqController@index');
Route::get('faqs/{id}', 'API\FaqController@show');


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

Route::get('levels', 'API\LevelController@index');
Route::get('levels/{id}', 'API\LevelController@show');

Route::get('sections', 'API\SectionController@index');
Route::get('sections/{id}', 'API\SectionController@show');

Route::get('pages', 'API\PageController@index');
Route::get('pages/{id}', 'API\PageController@show');

Route::get('/contact_us', 'API\ContactusController@index');
Route::post('/contact_us', 'API\ContactusController@store');



Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');
    Route::post('profile', 'API\PassportController@profile');
    Route::post('usersettings', 'API\PassportController@usersettings');
    Route::post('logout', 'API\PassportController@logout');
    Route::post('/sendSMS', 'API\PassportController@sendSMS');
    Route::post('/mobile/verify/store', 'API\PassportController@mobileVerifyStore');

    // Bookings
    Route::get('account/booking/projects', 'API\Account\BookingController@projects');
    Route::get('account/booking/services', 'API\Account\BookingController@services');
    Route::get('account/booking/mixtures', 'API\Account\BookingController@mixtures');
    Route::get('account/bookings/{id}', 'API\Account\BookingController@show');
    Route::resource('account/replays', 'API\Account\ReplayController')->except(['index','show']);
    Route::resource('account/reviews', 'API\Account\ReviewController')->except(['index','show']);

    // Projects
    Route::resource('account/projects', 'API\Account\ProjectController', ['names' => 'front_projects']);
    Route::get('account/projects/delete/{id}', 'API\Account\ProjectController@delete');

    // Offers
    Route::resource('offers', 'API\OfferController')->except(['show']);


    // notifications
    Route::resource('account/notifications', 'API\Account\NotificationController');
    Route::get('account/unread/notifications/', 'API\Account\NotificationController@unread');

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


    // Portfolio
    Route::resource('account/teams', 'API\Account\TeamController', ['names' => 'front_team']);
    Route::get('account/teams/delete/{id}', 'API\Account\TeamController@delete')->name('teams.delete');
    Route::get('{team_id}/list/services_provider', 'API\Account\TeamController@listServicesProvider');
    Route::get('account/team', 'API\Account\TeamController@team')->name('front_team');
    Route::post('account/teams/add', 'API\Account\TeamController@addUserToTeam');
    Route::post('account/teams/accept', 'API\Account\TeamController@acceptRequest');
    Route::post('account/teams/refused', 'API\Account\TeamController@refusedRequest');
    Route::post('account/teams/cancel', 'API\Account\TeamController@cancelRequest');
    Route::post('account/teams/delete', 'API\Account\TeamController@DeleteUser');


    // Experiences
    Route::resource('account/experiences', 'API\Account\ExperienceController', ['names' => 'front_experiences']);
    Route::get('account/experiences/delete/{id}', 'API\Account\ExperienceController@delete');

    // Messages
    Route::resource('account/messages', 'API\Account\MessageController');
    Route::get('account/messages/{id}', 'API\Account\MessageController@getMessage');
    Route::post('account/message', 'API\Account\MessageController@sendMessage');

    // Credit
    Route::resource('account/credit', 'API\Account\CreditController', ['names' => 'front_credit']);
    Route::resource('account/transactions', 'API\Account\TransactionController', ['names' => 'front_transactions']);

    // payment
    Route::post('account/payment', 'API\Account\PaymentController@payment_success');


});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
