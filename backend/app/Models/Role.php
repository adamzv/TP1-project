<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
class Role extends Model
{
    public $timestamps = false;

    /**
     * The attributes that aren´t max assignable
     *
     * @var array
     */
    protected $guarded = ['id'];
}
