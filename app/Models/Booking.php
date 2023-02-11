<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    
    protected $primaryKey = 'id';

    const STATUS_REQUEST_UNNALOCATED = 1;

    const STATUS_REQUEST_ACCEPTED = 2;

    const STATUS_REQUEST_CONFIRMED = 3;
    
    const STATUS_REQUEST_DONE = 4;

    protected $visible = [
        'status',
        'discard',
        'preferred_date',
        'cancelled',
        'cancelled_at',
        'cancelled_reason',
        'rejected',
        'rejected_at',
        'rejected_by',
        'rejected_reason',
        'provider_id',
        'staff_id',
        'client_id',
        'car_id',
        'change_created_at',
        'client_notes',
        'provider_notes',
    ];
    
    protected $fillable = [
        'status',
        'discard',
        'preferred_date',
        'cancelled',
        'cancelled_at',
        'cancelled_reason',
        'rejected',
        'rejected_at',
        'rejected_by',
        'rejected_reason',
        'provider_id',
        'staff_id',
        'client_id',
        'car_id',
        'change_created_at',
        'client_notes',
        'provider_notes',
    ];
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }
}
