<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    use HasFactory;

    protected $table = 'bookings_items';
    
    protected $primaryKey = 'id';

    protected $visible = [
        'discard',
        'booking_id',
        'services_id',
        'cost',
        'vat',
    ];

    protected $fillable = [
        'discard',
        'booking_id',
        'services_id',
        'cost',
        'vat',
    ];

    public function booking()
    {
        return $this->belongsTo(Car::class, 'booking_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(ProviderServices::class, 'services_id', 'id');
    }
}
