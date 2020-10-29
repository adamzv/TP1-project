<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Department
 *
 * @author lacal
 */
class Department extends Model
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
     * Get the faculty that owns the department
     */
    public function faculty()
    {
        return $this->belongsTo('App\Models\Faculty');
    }
}
