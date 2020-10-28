<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
class User extends Model
{
    use SoftDeletes;

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

    /**
     * Get the filters for the User
     */
    public function filters()
    {
        return $this->belongsToMany('App\Models\Filter')
            ->withPivot('filter_value')
            ->withTimestamps();
    }

    /**
     * Get the events where the user is registered
     */
    public function events()
    {
        return $this->belongsToMany('App\Models\Event')
            ->withTimestamps();
    }
}
