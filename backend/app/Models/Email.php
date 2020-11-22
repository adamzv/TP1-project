<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Email
 *
 * @author klukak
 */
class Email extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * The attributes that aren´t max assignable
     *
     * @var array
     */
    protected $guarded = ['id'];


    public function events()
    {
        return $this->belongsToMany('App\Models\Event');
    }

}