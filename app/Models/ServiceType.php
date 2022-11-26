<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Discards;

class ServiceType extends Model
{
    use Discards;

    /**
     * @var string
     */
    protected $table = 'service_types';

    protected $fillable = [
        'name',
        'notes',
        'display',
        'discard',
        'position',
        'provider_id',
        'created_at',
        'updated_at',
        'auto_allocation',
        'cost',
        'vat'
    ];

    protected $visible = [
        'name',
        'notes',
        'display',
        'discard',
        'position',
        'provider_id',
        'created_at',
        'updated_at',
        'auto_allocation',
        'cost',
        'vat'
    ];

    public function provider()
    {
        return $this->BelongsTo(Provider::class, 'provider_id', 'id');
    }
}
