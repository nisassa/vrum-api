<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderServices extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'provider_services';

    public $timestamps = false;
    
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * @var string[]
     */
    protected $fillable = [
        'provider_id',
        'service_id',
        'cost',
        'vat',
        'duration_in_minutes'
    ];

    public function service()
    {
        return $this->belongsTo(ServiceType::class, 'service_id', 'id');
    }
}
