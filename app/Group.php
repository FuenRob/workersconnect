<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $table = 'groups';

    public $fillable = [
        'name', 'description', 'id_company'
    ];
}
