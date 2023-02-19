<?php

namespace App\Models;

use App\Traits\Discards;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationTargetType extends Model
{
	use Discards, HasFactory;

    const NEW_BOOKING_RECEIVED_ID = 1;

    /**
     * @var string
     */
    protected $table = 'notification_target_sub_types';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string
     */
    const CREATED_AT = 'created';

    /**
     * @var string
     */
    const UPDATED_AT = 'updated';

    /**
     * @var string[]
     */
    protected $fillable = [
	    'id',
	    'name',
	    'created',
        'updated',
        'discard'
    ];

    /**
     * @var string[]
     */
    protected $visible = [
	    'id',
	    'name',
	    'created',
        'updated',
        'discard'
    ];
    
    // RELATIONS

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(NotificationTargetTypeSubType::class, 'target_sub_type_id', 'id');
    }
}
