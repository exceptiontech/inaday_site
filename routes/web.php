<?php

use Illuminate\Support\Facades\Route;

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

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

Route::get('/', 'FrontController@index')->name('home');

Route::get('/{type}/google', 'UsersController@google')->name('google');
Route::get('/auth/google/redirect', 'UsersController@googleRedirect');

Route::get('/{type}/twitter', 'UsersController@twitter')->name('twitter');
Route::get('/auth/twitter/redirect', 'UsersController@twitterRedirect');


Route::get('/{type}/facebook', 'UsersController@facebook')->name('facebook');
Route::get('/auth/facebook/redirect', 'UsersController@facebookRedirect');

Route::get('/search/','FrontController@SearchIndex');
Route::post('/newsletter/subscribe', 'SubscriberController@store');


Auth::routes(['verify' => true]);

Route::get('/home', 'FrontController@index');
Route::get('/contact_us', 'ContactusController@index')->name('contact_us');
Route::post('/contact_us', 'ContactusController@store');


Route::resource('blog','ArticleController');
Route::resource('faqs','FaqController');
Route::resource('services-provider','ServicesProviderController');
Route::resource('entrepreneur','EntrepreneurController');
Route::resource('sponsors','SponsorController');
Route::resource('pages','PageController');

Route::get('register/{type}', 'UsersController@register')->name('account');
Route::post('register/services_provider/update', 'UsersController@update')->name('services_provider_update');

Route::get('registration', 'UsersController@registration');


Route::get('projects', 'ProjectController@index')->name('projects.index');
Route::post('projects/search', 'ProjectController@searchBySkills')->name('projects.searchBySkills');
Route::get('projects/{id}', 'ProjectController@show')->name('projects.show');
Route::get('services', 'ServiceController@index')->name('services.index');
Route::get('services/{id}', 'ServiceController@show')->name('services.show');

Route::group(['middleware'=>'verified'], function() {

    // Profile
    Route::get('account/profile', 'UsersController@show')->name('account.profile');
    Route::post('update-profile', 'UsersController@update_profile')->name('update_profile');
    // Profile
    Route::resource('account/interviews', 'InterviewController', ['names' => 'front_interviews']);
    //notifications
    Route::get('account/notifications', 'UsersController@notifications');


    //projects
    Route::resource('account/projects', 'ProjectController', ['names' => 'front_projects'])->except(['index','show']);
    Route::get('projects/delete/{id}', 'ProjectController@delete')->name('projects.delete');

    //teams
    Route::resource('account/teams', 'TeamController', ['names' => 'front_teams'])->except(['destory']);
    Route::get('list/services_provider', 'TeamController@listServicesProvider');
    Route::post('account/teams/add', 'TeamController@addUserToTeam');
    Route::post('account/teams/accept', 'TeamController@acceptRequest');
    Route::post('account/teams/refused', 'TeamController@refusedRequest');
    Route::post('account/teams/cancel', 'TeamController@cancelRequest');

    //offers
    Route::resource('offers', 'OfferController')->except(['index','show']);

    // services
    Route::resource('account/services', 'ServiceController', ['names' => 'front_services'])->except(['index','show']);
    Route::get('services/delete/{id}', 'ServiceController@delete')->name('services.delete');
    //
    Route::get('payment', 'PaymentController@index');
    Route::post('paypal/{title}/{id}/charge', 'PaymentController@charge');
    Route::get('paymentsuccess', 'PaymentController@payment_success');
    Route::get('paymenterror', 'PaymentController@payment_error');


    Route::resource('bookings', 'BookingController', ['names' => 'front_bookings'])->only(['show']);
    Route::resource('replays', 'ReplayController')->except(['index','show']);

});

Route::group(['middleware' => ['role:Admin'],'prefix' => 'admin','name' => 'admin'], function() {

	Route::get('/', 'AdminController@index');
    Route::resource('articles','Admin\ArticleController');
    Route::resource('pages','Admin\PageController');
    Route::resource('levels','Admin\LevelController');
    Route::resource('prefers','Admin\PreferController');
    Route::resource('rewardkinds','Admin\RewardkindController');
    Route::resource('readinesskinds','Admin\ReadinesskindController');
    Route::resource('costkinds','Admin\CostkindController');
    Route::resource('beneficiaries','Admin\BeneficiaryController');
    Route::resource('jobtypes','Admin\JobtypeController');
    Route::resource('applykinds','Admin\ApplykindController');
    Route::resource('averagekinds','Admin\AveragekindController');
    Route::resource('countries','Admin\CountryController');
    Route::resource('statuses','Admin\StatusController');
    Route::resource('sponsors','Admin\SponsorController');
    Route::resource('skills','Admin\SkillController');
    Route::resource('sections','Admin\SectionController');
    Route::resource('roles','Admin\RoleController');
    Route::resource('logs', 'Admin\LogsController');
    Route::resource('cities', 'Admin\CityController');
    Route::resource('users','Admin\UserController');
    Route::resource('projects','Admin\ProjectController');
    Route::resource('stages','Admin\StageController');
    Route::resource('services','Admin\ServiceController');
    Route::resource('interviews','Admin\InterviewController');
    Route::resource('questions','Admin\QuestionController');
    Route::resource('teams','Admin\TeamController');

});
