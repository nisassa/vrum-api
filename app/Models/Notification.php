<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Discards;

class Notification extends Model
{
    use HasFactory, Discards;

    protected $table = 'notifications';

    /**
     * @var string
     */
	const CREATED_AT = 'created';

    /**
     * @var string
     */
	const UPDATED_AT = 'updated';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = [
    	'user_id',
    	'target_id',
    	'target_table',
    	'target_sub_type_id',
    	'payload',
    	'discard',
    	'website_read',
	    'email_read',
    	'mobile_notification_read',
    	'push_notification_read',
	    'created'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'website_read',
        'email_read',
        'mobile_notification_read',
        'push_notification_read',
        'created',
        'updated',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'target_id' => 'integer',
        'target_sub_type_id' => 'integer',
        'payload' => 'array',
        'discard' => 'integer'
    ];

    /**
     * @var string[]
     */
    protected $visible = [
	    'id',
    	'user_id',
    	'target',
    	'target_id',
    	'target_table',
    	'target_type',
    	'target_type_id',
    	'target_sub_type',
    	'target_sub_type_id',
    	'payload',
	    'decoded_payload',
	    'discard',
	    'is_read',
    	'website_read',
	    'email_read',
    	'mobile_notification_read',
    	'push_notification_read',
	    'created',
    	'updated'
    ];

    /**
     * @var string[]
     */
    protected $appends = [
	    'is_read',
	    'target_type_id',
	    'decoded_payload'
    ];

    /**
     * @param User $user
     * @return array
     */
    public static function getUnreadNotificationCountsForUser(User $user): array
    {
        // Get the unread counts.
        $unreads = \DB::table('notifications')
            ->select([
                \DB::raw('COUNT(*) as count')
            ])
            ->where([
                ['user_id', '=', $user->id],
                ['website_read', '=', null],
                ['email_read', '=', null],
                ['mobile_notification_read', '=', null],
                ['push_notification_read', '=', null]
            ])
            ->groupBy([
                'notifications.target_sub_type_id'
            ])->get();

        return [
            'total' => $unreads->sum('count'),
            'counts' => $unreads->map(function ($c) {
                return [
                    'count' => (int)$c->count,
                    'target_sub_type_id' => $c->target_sub_type_id !== null
                        ? (int)$c->target_sub_type_id
                        : null
                ];
            })->toArray()
        ];
    }

    /***
     * ACCESSORS
     */

    /**
     * @return int
     */
    public function getIsReadAttribute(): int
    {
	    return (
	        $this->mobile_notification_read !== null
            || $this->push_notification_read !== null
            || $this->email_read !== null
            || $this->website_read !== null
        ) ? 1 : 0;
    }

    /**
     * @return float|int|null
     */
    public function getTargetTypeIdAttribute()
    {
	    return $this->target_type === null ? null : abs($this->target_type->id);
    }

    /**
     * @return mixed|null
     */
    public function getDecodedPayloadAttribute()
    {
	    return empty($this->attributes['payload']) ? null : json_decode($this->attributes['payload']);
    }

    /***
     * SCOPES
     */

    /**
     * @param Builder $query
     * @param User|int|string $user
     * @return Builder
     */
    public function scopeForUser(Builder $query, $user): Builder
    {
        return $query->where('user_id', $user instanceof User ? $user->id : $user);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeRead(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            return $query->whereNotNull('website_read')
                ->orWhereNotNull('mobile_notification_read')
                ->orWhereNotNull('email_read')
                ->orWhereNotNull('push_notification_read');
        });
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->where([
            ['website_read', '=', null],
            ['mobile_notification_read', '=', null],
            ['email_read', '=', null],
            ['push_notification_read', '=', null]
        ]);
    }

    /***
     * METHODS
     */

    /**
     * Mark the notification as website read.
     *
     * @return void
     */
    public function markAsWebsiteRead()
    {
        if (is_null($this->website_read)) {
            $this->fill(['website_read' => $this->freshTimestamp()])->save();
        }
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subTypes()
    {
        return $this->hasMany(NotificationTargetTypeSubType::class, 'target_type_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @note Legacy
     */
    public function notification_target_type_sub_types()
    {
	    return $this->subTypes();
    }
}
