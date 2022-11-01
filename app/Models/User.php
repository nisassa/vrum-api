<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Discards;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Discards;

    public const SERVICE_PROVIDER_TYPE = 'service_provider';

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded  = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that are mass visible.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'email_verified_at',
        'password',
        'provider_id',
        'admin',
        'developer',
        'discard',
        'manager',
        'type',
        'job_title',
        'photo',
        'landline',
        'line_1',
        'line_2',
        'city',
        'county',
        'country',
        'postcode',
        'lat',
        'long'
    ];
}
