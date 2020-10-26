<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
class User extends Model
{
    /**
     * The attributes that aren´t max assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the role
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

}
