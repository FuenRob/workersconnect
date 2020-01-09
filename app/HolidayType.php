<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayType extends Model
{
    public $table = 'teams_holidays_types';

    public $fillable = [
        'name'
    ];
}