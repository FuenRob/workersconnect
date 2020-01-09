<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayManager extends Model
{
    public $table = 'teams_holidays_managers';

    public $fillable = [
        'id_company', 'id_team_holiday', 'id_user'
    ];
}