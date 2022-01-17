
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

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('external/pay/{order_uid}/{scheme?}', 'API\ExternalSourcesController@pay')->name('pay/external');

Route::group(['prefix' => 'bank'], function() {

    Route::group(['prefix' => 'zpal'], function() {
        Route::get('/callback','ZarinPalController@callback')->name('zarinpal/callback');
        Route::get('redirect/{token}','ZarinPalController@redirectToBank');
    });
    Route::get('/redirect/{token}','\DefaultIPG@redirectToBank')->name('bank/redirect');
    Route::get('/pay/result/mobile/{result}/{order_uid}','PaymentsController@result')->name('bank/result');
    Route::get('/tiwall/callback/{order_uid}', 'TiwallController@paymentsCallback')->name('tiwall/callback');


});

Route::get('/faq-mobile', function() {
    return view('static.faq-mobile');
});
Route::get('/test-email', function() {
    $order = \App\Models\Order::find(43);
    //new \App\Mail\TicketsReady($order, null);
    $user = \App\User::find(4);
    return Mail::to($user)->sendNow(new \App\Mail\TicketsReady($order, null));
});

/*
 * Authentication
 *
 */
Auth::routes();
Route::get('/login', array(
    'as' => 'login',
    'uses' => 'Auth\LoginController@getLogin'
));
Route::get('/login2', function (){
     $user = \App\User::whereId(1)->first();
    Auth::login($user);
});


Route::get('logout', function()
{
    \Auth::logout();
    return redirect('/login');
})->name('logout');

/* disable registration */
// Registration routes...
Route::get('register', function()
{
    return redirect('/login');
});

Route::post('register', function() {
    return response()->make(null,404);
});


Route::group(['prefix' => 'panel'], function()
{
    Route::group(['middleware' => ['guest']], function() {
        Route::get('auth/login','Panel\AuthController@getLogin');
        Route::post('auth/login','Panel\AuthController@postLogin')->name('panel/login');
    });
    Route::group(['middleware' => ['auth','panel.access']], function() {
        Route::get('/', function() {
            return response()->redirectToRoute('dashboard');
        });
        Route::get('/dashboard', 'Panel\DashboardController@index')->name('dashboard');
        Route::get('/me','Panel\UsersController@me')->name('panel/me');
        Route::group(['prefix' => 'users', 'middleware' => ['admin.access']], function() {
            Route::get('/', 'Panel\UsersController@index')->name('users/list');
            Route::post('/save/{id?}', 'Panel\UsersController@save')->name('users/save');
            Route::get('/{id}', 'Panel\UsersController@show')->name('users/show');
            Route::post('/', 'Panel\UsersController@search')->name('users/search');
        });
        Route::group(['prefix' => 'shows'], function() {

            Route::get('/pending', 'Panel\ShowsController@pendingShows')->name('shows/pending');
            Route::get('/approve/{uid}', 'Panel\ShowsController@approve')->name('shows/approve');
            Route::get('/edit/{show_uid}', 'Panel\ShowsController@edit')->name('shows/edit');
            Route::get('/cat/{cat_id?}', 'Panel\ShowsController@index')->name('shows/list');


            Route::post('/cat/{cat_id?}', 'Panel\ShowsController@search')->name('shows/search');
            Route::get('/new/{cat_id?}', 'Panel\ShowsController@create')->name('shows/new');
            Route::get('/{show_uid}', 'Panel\ShowsController@show')->name('shows/show');

            Route::get('/scene/{id?}', 'Panel\ShowsController@scene')->name('scene/get');
            Route::post('/import', 'Panel\ShowsController@import')->name('shows/import');
            Route::post('/{id?}', 'Panel\ShowsController@save')->name('shows/save');

            Route::get('/edit/cover/{show_uid}','Panel\ShowsController@setCover')->name('shows/set/cover');


        });
        Route::group(['prefix' => 'showtimes'], function() {
            Route::get('/set/{id}/{status}', 'Panel\ShowtimesController@setStatus')->name('showtime/set-status');

        });
        Route::group(['prefix' => 'promotions'], function() {
            Route::get('/', 'Panel\PromotionsController@index')->name('promotions/list');
            Route::post('/', 'Panel\PromotionsController@add')->name('promotions/add');
            Route::get('/set-status/{promotion_id}/{status}', 'Panel\PromotionsController@add')->name('promotions/set-status');
        });
        Route::group(['prefix' => 'orders'], function() {

            Route::get('/', 'Panel\OrdersController@index')->name('orders/list');
            Route::get('/mine', 'Panel\OrdersController@mine')->name('orders/mine');
            Route::post('/', 'Panel\OrdersController@search')->name('orders/search');
            Route::post('/resend', 'Panel\OrdersController@resend')->name('orders/resend');
            Route::get('/download/{uid}', 'Panel\OrdersController@download')->name('orders/download');
            Route::get('/cancel/{uid}', 'Panel\OrdersController@cancel')->name('orders/cancel');
        });
        Route::group(['prefix' => 'payments', 'middleware' => ['admin.access']], function() {
            Route::get('/', 'Panel\PaymentsController@index')->name('payments/list');
        });
        Route::group(['prefix' => 'reports'], function() {
           Route::get('/show/{show_uid}','Panel\ReportsController@reportForShow');
           Route::get('/user/{user_uid}','Panel\ReportsController@reportForUser');
           Route::get('/','Panel\ReportsController@generalReport')->name('reports/general');
           Route::get('/{uid}','Panel\ReportsController@singleReport')->name('reports/show');
           Route::post('/','Panel\ReportsController@generalReport')->name('reports/filtered');
        });
        Route::group(['prefix' => 'tickets'], function() {
            Route::post('/disable/{showtime_uid}','Panel\TicketsController@setDisabled')->name('disable/tickets');
            Route::post('/enable/{showtime_uid}','Panel\TicketsController@setEnabledWithPrice')->name('enable/tickets');
            Route::post('/set-mine/{showtime_uid}','Panel\TicketsController@setMine')->name('setmine/tickets');
            Route::get('/{showtime_uid}','Panel\TicketsController@ticketsForShow')->name('showtime/tickets');

        });
        Route::group(['prefix' => 'scenes'], function() {
            Route::get('/create','Panel\ScenesController@newScene')->name('newScene');
            Route::get('/','Panel\ScenesController@index')->name('scenes/list');
            Route::post('/','Panel\ScenesController@save')->name('scenes/save');
            Route::get('/delete/{id}','Panel\ScenesController@delete')->name('scenes/delete');
            Route::get('/duplicate/{id}', 'Panel\ScenesController@edit')->name('scene/edit');
        });


    });

});

//website

Route::group(['prefix' => "/"], function() {

    Route::get('/about',function(){
        return view('website.about');
    })->name('website/about');;
    Route::get('/faqs',function(){
        return view('website.faqs');
    })->name('website/faqs');;
    Route::get('/rules',function(){
        return view('website.rules');
    })->name('website/rules');


    Route::group(['prefix'=>"profile", 'middleware' => ['web.access']],function()
    {
        Route::get('/', 'Website\ProfileController@getProfile')->name('website/profile');
        Route::post('update','Website\ProfileController@updateProfile')->name('website/profile/update');
        Route::post('new','Website\ProfileController@newProfile')->name('website/profile/new');
    });
    Route::group(['prefix'=>"orders", 'middleware' => ['web.access']],function() {
        Route::get('/{uid}/pdf', 'API\OrdersController@pdf')->name('website/order/pdf');
    });

    Route::get('/', 'Website\HomeViewController@home')->name('website/home');
    Route::post('/', 'Website\HomeViewController@homeCity')->name('website/home/city');



    Route::group(['prefix' => 'shows'], function()
    {
        Route::get('/{uid}','Website\ShowsController@getShow')->name('website/get/show');
        Route::post('/like','API\FavoritesController@store')->name('website/favorite');
        Route::post('/dislike/{uid}','API\FavoritesController@destroy')->name('website/favorite/dislike');
    });
    Route::group(['prefix' => 'auth'], function()
    {
        Route::get('/login','Website\HomeViewController@home')->middleware('web.access')->name('');
        Route::post('login','Website\AuthController@postLogin')->name('website/login');
        Route::post('confirm','Website\AuthController@continueLogin')->name('website/login/continue');
    });
//    Route::group('/login',)
    Route::get('test-login', function(Request $request) {

//        $request->session()->forget('key');
        if (\Session::exists('cityid')) {
            Session::forget('cityid');
        }
        \Auth::loginUsingId(1);
    });
    Route::get('logout', function(Request $request) {
        \Auth::logout();
        return redirect('/');
    })->name('website/logout');

    Route::group(['prefix'=>'store'],function()
    {
        Route::get('/{uid}','Website\StoreController@getStore')->name('website/get/store');
        Route::post('/promotion','API\PromotionsController@checkPrice')->name('website/promotion');
    });
    Route::group(['prefix' => 'showtimes'], function() {
        Route::group(['prefix' => 'external'], function () {
            Route::get('seatmap/{showtime_uid?}', 'API\ExternalSourcesController@seatMapForExternalShowtime')->name('website/seatmap/external');
            Route::post('reserve', 'API\ExternalSourcesController@reserve')->middleware(['web.access'])->name('website/reserve/external');
            Route::post('guest-reserve', 'API\ExternalSourcesController@guestReserveAndConfirm')->name('website/guest-reserve/external');
            Route::post('confirm/{uid?}', 'API\ExternalSourcesController@confirm')->name('website/confirm/external');
        });
        Route::group(['prefix' => 'internal'], function () {
            Route::get('seatmap/{uid?}', 'API\ShowtimesController@showtime')->name('website/seatmap/internal');
            Route::post('reserve', 'API\OrdersController@create')->middleware(['web.access'])->name('website/reserve/internal');
            Route::post('reserve/chairless', 'API\OrdersController@createChairless')->middleware(['web.access'])->name('website/reserve/internal/chairless');
            Route::post('confirm/{uid?}', 'API\OrdersController@confirm')->middleware(['web.access'])->name('website/confirm/internal');
            Route::post('guest-reserve', 'API\OrdersController@guestReserveAndConfirm')->name('website/guest-reserve/internal');
//            Route::post('guest-reserve/chairless', 'API\OrdersController@guestReserveAndConfirmChairless')->middleware(['web.access'])->name('website/guest-reserve/internal/chairless');

        });
    });

    Route::group(['prefix'=>'search'],function(){
       Route::get('/','Website\HomeViewController@search')->name('website/search');
       Route::get('/{search_key?}','Website\SearchController@searchView')->name('website/search/view');
    });

    Route::group(['prefix'=>'bank'],function (){
       Route::get('/pay/result/{result}/{order_uid}','Website\PaymentController@result')->name('website/bank/result');

    });

});