<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $table = 'teams';

    public $fillable = [
        'name', 'id_company'
    ];
}
