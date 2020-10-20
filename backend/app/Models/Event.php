<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 *
 * @author lacal
 */
class Event extends Model
{
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
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the place that belongs to the event
     */
    public function place()
    {
        return $this->belongsTo('App\Models\Place');
    }

    /**
     * Get the faculty that belongs to the event
     */
    public function faculty()
    {
        return $this->belongsTo('App\Models\Place');
    }

    /**
     * Get the department that belongs to the event
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    /**
     * Get the repetiton
     */
    public function repeat()
    {

    }
}
