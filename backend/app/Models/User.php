<?php

namespace App\Models;

use App\Notifications\VerifyApiEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak, lacal
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes, Notifiable, HasApiTokens;

    /**
     * The attributes that aren´t max assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'id_role');
    }

    /**
     * Get the events where the user is registered
     */
    public function events()
    {
        return $this->belongsToMany('App\Models\Event');

    }

    /**
     * Email notification
     */
    public function sendApiEmailVerificationNotification()
    {
        $this->notify(new VerifyApiEmail);
    }
}
