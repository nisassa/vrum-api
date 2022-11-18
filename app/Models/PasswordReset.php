<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
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
