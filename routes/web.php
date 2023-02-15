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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/date/{cityName}', [\App\Http\Controllers\HistoricalWeatherHumidityController::class, 'getHistoricalWeatherHumidity']);

//Route::get('/date', function (){
//
//    $start = (new DateTime('2013-01-01'))->modify('first day of this month');
//    $end = (new DateTime('2023-01-01'))->modify('first day of next month');
//    $interval = DateInterval::createFromDateString('1 month');
//    $period = new DatePeriod($start, $interval, $end);
//    $data = array();
//
//    foreach ($period as $dt) {
//        $data_month = array($dt->format("Y-m-d"));
//        $data[] = $data_month;
//    }
//
//     var_dump($data);
//});
