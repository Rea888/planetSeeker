<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalWeatherHumidityModel extends Model
{
    use HasFactory;

    public float $longitude;
    public float $latitude;
    public int $relative_humidity_2m;
    public string $date_time_of_measurement;
    protected $fillable = [
        'latitude',
        'longitude',
        'date_time_of_measurement',
        'relative_humidity_2m',
    ];
}
