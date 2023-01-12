<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Discards;
use App\Models\ProviderServices;
use App\Interfaces\HasWorkingDays;

class Provider extends Model implements HasWorkingDays
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
        'booking_auto_allocation',
        'show_service_prices_to_client',
        'landline',
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
        'show_service_prices_to_client',
        'landline',
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

    public function gallery_images()
    {
        return $this->hasMany(PhotoGallery::class, 'provider_id', 'id');
    }

    public function working_days()
    {
        return $this->hasMany(WorkingDays::class, 'provider_id', 'id');
    }

    public function services()
    {
        return $this
            ->belongsToMany(ServiceType::class, 'provider_services', 'provider_id', 'service_id')
            ->withPivot([
                'provider_id',
                'service_id'
            ]);
    }
}
