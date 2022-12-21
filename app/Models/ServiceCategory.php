<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Discards;

class ServiceCategory extends Model
{
    use HasFactory, Discards;

    /**
     * @var string
     */
    protected $table = 'service_category';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'discard'
    ];

    protected $visible = [
        'id',
        'name',
        'slug',
        'description',
        'icon',
        'discard'
    ];

    protected $with = ['services']; 

    public function services()
    {
        return $this->hasMany(ServiceType::class, 'category_id', 'id');
    }
}
