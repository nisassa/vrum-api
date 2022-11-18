<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_logins';

    protected $fillable = [
        'user_id',
        'device',
        'browser',
        'os',
    ];
}
