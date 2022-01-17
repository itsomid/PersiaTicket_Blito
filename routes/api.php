<?php

use App\Models\City;
use App\Models\Order;
use App\Models\Ticket;
use App\User;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();


});
Route::get('/asdasd', function(Request $request) {

});

Route::group(['prefix' => 'v1'], function () {


    Route::resource('devices', 'API\DeviceController');

    Route::group(['prefix' => 'genres'], function () {
        Route::get('/', 'API\GenresController@get');
    });
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'API\AuthController@login');
        Route::post('login/confirm', 'API\AuthController@continueLogin');
    });
    Route::group(['prefix' => 'cities'], function () {
        Route::get('/{shows?}', 'API\CitiesController@listCities')->where('shows','true');
        Route::get('/{id}', 'API\CitiesController@getCity');

    });
    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('favorites', 'API\FavoritesController@store');
        Route::delete('favorites/{id}', 'API\FavoritesController@destroy');
        Route::get('favorites', 'API\FavoritesController@index');

        Route::group(['prefix' => 'external'], function () {
            Route::get('seatmap/{showtime_uid}', 'API\ExternalSourcesController@seatMapForExternalShowtime');
            Route::post('reserve', 'API\ExternalSourcesController@reserve');
        });
        Route::group(['prefix' => 'promotions'], function(){
            Route::post('check','API\PromotionsController@checkPrice');
        });
    });
    Route::group(['prefix' => 'shows'], function () {
        Route::get('/{uid}', 'API\ShowsController@show');
        Route::get('/{uid}/showtimes', 'API\ShowsController@showtimes');
        Route::post('/search/{genre_id?}','API\ShowsController@search');
    });
    Route::group(['prefix' => 'showtimes'], function () {
        Route::get('/{uid}', 'API\ShowtimesController@showtime');
    });
    Route::group(['prefix' => 'tickets'], function () {
        //Route::get('/reserve/{uid}','API\ShowtimesController@showtime');
        Route::group(['middleware' => ['jwt.auth']], function () {
            Route::get('/reserved', 'API\TicketsController@reserved');
        });
    });
    Route::group(['prefix' => 'orders', 'middleware' => ['jwt.auth']], function () {
        Route::post('/', 'API\OrdersController@create');
        Route::get('/', 'API\OrdersController@index');

        Route::get('/{uid}', 'API\OrdersController@show');
        Route::get('/{uid}/pdf', 'API\OrdersController@pdf');
        Route::post('/{uid}/confirm', 'API\OrdersController@confirm');
    });

    Route::group(['prefix' => 'payments', 'middleware' => ['jwt.auth']], function () {
        Route::get('/', 'API\PaymentsController@my');
    });
    Route::group(['prefix' => 'users', 'middleware' => ['jwt.auth']], function () {
        Route::post('/profile', 'API\UsersController@updateProfile');
        Route::get('/profile', 'API\UsersController@profile');
        Route::post('/avatar', 'API\UsersController@uploadAvatar');
        Route::delete('/avatar', 'API\UsersController@deleteAvatar');
    });
    Route::get('test', function () {
        //$cache = new \App\Models\ShowTimeCache(1);

        //return json_encode($cache);
        $city = City::find(1);
        return $city->categories()->get();
    });

    Route::get('test/sold/{id}', function ($id) {
        $tickets = \App\Models\Ticket::where('id', '>', $id)->limit(5)->get();
        $ids = [];
        foreach ($tickets as $ticket) {
            $ids[] = $ticket->id;
        }
        return json_encode(Order::createOrderForTickets($tickets, User::find(1)));
        /*
        if($status == "true"){
            return response()->json($ticket->reserveForUser(\App\User::find(1)));
        }else
        {
            return response()->json($ticket->cancelReservationFor(\App\User::find(1)));
        }*/

    });

    Route::get('/test-tiwall/{urn}',function($urn){
        $seebTiwall = new \App\Classes\Seeb\Vendors\SeebTiwall();

        $url = 'https://www.tiwall.com/theater/'.$urn;
        $seebTiwall->importShow($urn);

        return "done";
        //return response()->json($response);
    });

});