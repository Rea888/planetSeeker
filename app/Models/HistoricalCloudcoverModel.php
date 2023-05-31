<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalCloudcoverModel extends Model
{
    protected $fillable = [
        'latitude',
        'longitude',
        'date_time_of_measurement',
        'cloudcover',
    ];
}
