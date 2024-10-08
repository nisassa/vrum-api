<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Discards;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use App\Interfaces\HasWorkingDays;

class User extends Authenticatable implements JWTSubject, HasWorkingDays
{
    use HasFactory, Notifiable, Discards;

    public const SERVICE_PROVIDER_TYPE = 'service_provider';
    public const SERVICE_PROVIDER_STAFF_TYPE = 'service_provider_staff';
    public const CLIENT_TYPE = 'client';

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

    protected $with = ['provider', 'working_days', 'provider.working_days'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    public function service_types()
    {   
        return $this
            ->belongsToMany(ServiceType::class, 'user_service_types', 'user_id', 'service_type_id')
            ->withPivot([
                'user_id',
                'service_type_id',
            ]);
    }

    public function working_days()
    {
        return $this->hasMany(WorkingDays::class, 'user_id', 'id');
    }
}
