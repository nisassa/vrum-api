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
        'duration_in_minutes',
        'vat',
        'category_id',
        'approved'
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
        'duration_in_minutes',
        'vat',
        'category_id',
        'approved'
    ];

    public function category()
    {
        return $this->BelongsTo(ServiceCategory::class, 'category_id', 'id');
    }
}
