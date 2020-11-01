<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class State
 *
 * @author lacal
 */
class State extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the cities for the State
     */
    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }
}
