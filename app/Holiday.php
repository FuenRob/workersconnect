<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    public $table = 'teams_holidays';

    public $fillable = [
        'id_company', 'id_team', 'id_user', 'id_type', 'start', 'finish', 'status'
    ];
}
