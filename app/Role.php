<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = 'roles';

    public $fillable = ['name'];
}
