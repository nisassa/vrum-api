<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Discards;

class PasswordReset extends Model
{
    use Discards;

    protected $table = 'password_resets';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

    protected $visible = [
        'id',
        'email',
        'token',
        'created_at',
    ];

    protected $dates = [
        'created_at'
    ];
}
