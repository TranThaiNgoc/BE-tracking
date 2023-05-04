<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = 'trackings';
    protected $fillable = ['tracking_number', 'data'];
}
