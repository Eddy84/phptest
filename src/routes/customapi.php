<?php

Route::namespace('App\Controllers')->group(function () 
{
    Route::get('/test',                     'TradesController@test');

    Route::delete('/erase',                 'TradesController@erase');
    Route::post('/trades',                  'TradesController@newTrade');
    Route::get('/trades',                   'TradesController@getTrades');
    Route::get('/trades/users/{userId}',    'TradesController@getTradesByUserId');
    Route::get('/stocks/stats',             'TradesController@getStockStats');
    Route::get('/stocks/{stockSymbol}',     'TradesController@getStockSymbolPrices');
    
});