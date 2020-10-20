<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    public $timestamps = false;

    /**
     * The attributes that aren´t maxx assignable
     *
     * @var array
     */
    protected $guarded =['id'];
}
