<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Event
 *
 * @author lacal
 */
class Event extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the user that owns the event
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    /**
     * Get the place that belongs to the event
     */
    public function place()
    {
        return $this->belongsTo('App\Models\Place', 'id_place');
    }

    /**
     * Get the faculty that belongs to the event
     */
    public function faculty()
    {
        return $this->belongsTo('App\Models\Faculty', 'id_faculty');
    }

    /**
     * Get the department that belongs to the event
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'id_department');
    }

    /**
     * Get the categories that belong to the event
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');

    }

    /**
     * Get the attendance of users that belongs to the event
     */
    public function attendance()
    {
        return $this->belongsToMany('App\Models\User');

    }


    public function emails()
    {
        return $this->belongsToMany('App\Models\Email', 'event_user');
    }
}
