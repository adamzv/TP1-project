<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
class Filter extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * The attributes that aren´t max assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the users for the Filter
     */
    public function user()
    {
        return $this->belongsToMany('App\Models\User')
            ->withTimestamps();
    }
}
