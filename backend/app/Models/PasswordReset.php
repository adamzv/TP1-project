<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset
 *
 * @author lacal
 */
class PasswordReset extends Model
{
    protected $fillable = [
      'email', 'token'
    ];
}
