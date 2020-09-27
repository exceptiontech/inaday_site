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
Route::post('/newsletter/subscribe', 'SubscriberController@store')->name('subscribe');

Route::get('/user/{id}', 'UsersController@show');
Route::get('/user/{id}/about', 'UsersController@about');
Route::get('/user/{id}/services', 'UsersController@services');
Route::get('/user/{id}/skills', 'UsersController@skills');
Route::get('/user/{id}/portfolios', 'UsersController@portfolios');
Route::get('/user/{id}/experiences', 'UsersController@experiences');
Route::get('/user/{id}/reviews', 'UsersController@reviews');
Route::get('/user/{id}/projects', 'UsersController@projects');
Route::get('/user/{id}/mixtures', 'UsersController@mixtures');


Auth::routes(['verify' => true]);

Route::get('/home', 'FrontController@index');
Route::get('/contact_us', 'ContactusController@index')->name('contact_us');
Route::post('/contact_us', 'ContactusController@store');

Route::get('services-provider','UsersController@ServicesProviderIndex');
Route::get('entrepreneur','UsersController@EntrepreneurIndex');
Route::resource('blog','ArticleController');
Route::resource('faqs','FaqController');
Route::resource('sponsors','SponsorController');
Route::resource('pages','PageController');
Route::resource('messages','MessageController');

// Route::get('register/{type}', 'UsersController@register')->name('account');
// Route::post('register/services_provider/update', 'UsersController@update')->name('services_provider_update');

Route::get('registration', 'UsersController@registration');
Route::get('/errors/denied', 'PageController@denied');

Route::get('projects', 'ProjectController@index')->name('projects.index');
Route::get('projects/{id}', 'ProjectController@show')->name('projects.show');

Route::get('services', 'ServiceController@index')->name('services.index');
Route::get('services/{id}', 'ServiceController@show')->name('services.show');

Route::get('mixtures', 'MixtureController@index')->name('mixtures.index');
Route::get('mixtures/{id}', 'MixtureController@show')->name('mixtures.show');



Route::group(['middleware'=>'verified'], function() {

    // Profile
    Route::get('account', 'UsersController@account');
    Route::get('account/profile', 'UsersController@profile')->name('account.profile');
    Route::get('/getCities', ['uses' => 'UsersController@getCities','as' => 'getCities']);  
    Route::get('account/profile/edit', 'UsersController@edit')->name('account.edit');
    Route::post('account/profile/update', 'UsersController@update');

    // settings
    Route::resource('account/settings', 'Account\UsersettingsController', ['names' => 'front_settings']);

    // Projects
    Route::resource('account/projects', 'Account\ProjectController', ['names' => 'front_projects']);
    Route::get('account/projects/delete/{id}', 'Account\ProjectController@delete')->name('projects.delete');

    // Message
    Route::resource('account/messages', 'Account\MessageController', ['names' => 'front_messages']);
    Route::get('account/messages/{id}', 'Account\MessageController@getMessage')->name('message');
    Route::post('account/message', 'Account\MessageController@sendMessage')->name('sendMessage');;


    // Services
    Route::resource('account/services', 'Account\ServiceController', ['names' => 'front_services']);
    Route::get('account/services/delete/{id}', 'Account\ServiceController@delete')->name('services.delete');
    // fav
    Route::get('/account/favorite', ['uses' => 'FavoriteController@update','as' => 'updateFavorite']);  


    // mixture
    Route::resource('account/mixtures', 'Account\MixtureController', ['names' => 'front_mixtures']);
    Route::get('account/mixtures/create/{id}', 'Account\MixtureController@create')->name('mixtures.create');
    Route::get('account/mixtures/delete/{id}', 'Account\MixtureController@delete')->name('mixtures.delete');


    // Portfolios
    Route::resource('account/portfolios', 'Account\PortfolioController', ['names' => 'front_portfolios']);
    Route::get('account/portfolios/delete/{id}', 'Account\PortfolioController@delete')->name('portfolio.delete');

    // Experiences
    Route::resource('account/experiences', 'Account\ExperienceController', ['names' => 'front_experiences']);
    Route::get('account/experiences/delete/{id}', 'Account\ExperienceController@delete')->name('experiences.delete');

    // Skills
    Route::resource('account/skills', 'Account\SkillController', ['names' => 'front_skills']);
    Route::get('account/skills/delete/{id}', 'Account\SkillController@delete')->name('skills.delete');

    // Credit
    Route::resource('account/credit', 'Account\CreditController', ['names' => 'front_credit']);
    Route::resource('account/transactions', 'Account\TransactionController', ['names' => 'front_transactions']);

    // Reviews
    Route::resource('account/reviews', 'Account\ReviewController', ['names' => 'front_reviews']);

    // bookings
    Route::resource('account/bookings', 'Account\BookingController', ['names' => 'front_bookings']);

    // notifications
    Route::resource('account/notifications', 'Account\NotificationController', ['names' => 'front_notifications']);


    // Interview
    Route::resource('account/interviews', 'InterviewController', ['names' => 'front_interviews']);



    //teams
    Route::resource('account/teams', 'Account\TeamController', ['names' => 'front_teams'])->except(['destory']);
    Route::get('account/teams/delete/{id}', 'Account\TeamController@delete')->name('teams.delete');
    Route::get('{team_id}/list/services_provider', 'Account\TeamController@listServicesProvider');
    Route::get('account/team', 'Account\TeamController@team')->name('front_team');
    Route::post('account/teams/add', 'Account\TeamController@addUserToTeam');
    Route::post('account/teams/accept', 'Account\TeamController@acceptRequest');
    Route::post('account/teams/refused', 'Account\TeamController@refusedRequest');
    Route::post('account/teams/cancel', 'Account\TeamController@cancelRequest');
    Route::post('account/teams/delete', 'Account\TeamController@DeleteUser');

    //offers
    Route::resource('offers', 'OfferController')->except(['index','show']);



    Route::get('payment', 'PaymentController@index');
    Route::post('paypal/{title}/{model_id}/{offer_id}/charge', 'PaymentController@charge');
    Route::get('paymentsuccess', 'PaymentController@payment_success');
    Route::get('paymenterror', 'PaymentController@payment_error');


    Route::resource('bookings', 'BookingController', ['names' => 'front_bookings'])->only(['show']);
    Route::resource('replays', 'ReplayController')->except(['index','show']);

    Route::resource('files', 'FileController', ['names' => 'front_teams'])->only(['destory']);
    Route::get('files/delete/{id}', 'FileController@delete')->name('file.delete');


});

Route::group(['middleware' => ['role:Admin'],'prefix' => 'admin','name' => 'admin'], function() {

	Route::get('/', 'AdminController@index');
    Route::resource('articles','Admin\ArticleController');
    Route::resource('faqs','Admin\FaqController');
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
    Route::resource('mixtures','Admin\MixtureController');
    Route::resource('services','Admin\ServiceController');
    Route::resource('interviews','Admin\InterviewController');
    Route::resource('questions','Admin\QuestionController');
    Route::resource('teams','Admin\TeamController');

});
