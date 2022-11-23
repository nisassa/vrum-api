<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Discards;

class UserLogin extends Model
{
    use Discards;

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
