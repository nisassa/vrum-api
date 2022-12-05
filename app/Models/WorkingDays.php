<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingDays extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'working_days';

    /**
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * @var string[]
     */
    protected $fillable = [
        'day',
        'start_at',
        'end_at',
        'provider_id',
        'user_id',
        'is_active',
    ];

    /**
     * @var string[]
     */
    protected $visible = [
        'id',
        'day',
        'start_at',
        'end_at',
        'provider_id',
        'user_id',
        'is_active',
    ];

    public function provider()
    {
        return $this->BelongsTo(Provider::class, 'provider_id', 'id');
    }

    public function user()
    {
        return $this->BelongsTo(User::class, 'user_id', 'id');
    }
}
