<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Discards;

class PhotoGallery extends Model
{
    use Discards;

    /**
     * @var string
     */
    protected $table = 'photo_gallery';

    protected $fillable = [
        'photo',
        'name',
        'discard',
        'provider_id',
        'created_at',
        'updated_at'
    ];

    protected $visible = [
        'photo',
        'name',
        'discard',
        'provider_id',
        'created_at',
        'updated_at'
    ];

    protected $with = ['provider'];

    public function provider()
    {
        return $this->BelongsTo(Provider::class, 'provider_id', 'id');
    }
}
