<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Discards;
use ViewberBase\ViewingItem;

class Provider extends Model
{
    use HasFactory, Discards;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'providers';

    /**
     * The primary key associated with the table.
     *
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
     * The attributes that are mass vissible.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'id',
        'name',
        'live_api_key',
        'test_api_key',
        'invoice_email',
        'vip',
        'booking_by_specialist',
        'booking_approved_by_provider',
        'discard',
        'line_1',
        'line_2',
        'city',
        'county',
        'country',
        'postcode',
        'lat',
        'long',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'live_api_key',
        'test_api_key',
        'invoice_email',
        'vip',
        'booking_by_specialist',
        'booking_approved_by_provider',
        'discard',
        'line_1',
        'line_2',
        'city',
        'county',
        'country',
        'postcode',
        'lat',
        'long',
    ];

    public function gallery()
    {
        return $this->hasMany(PhotoGallery::class, 'provider_id', 'id');
    }
}
