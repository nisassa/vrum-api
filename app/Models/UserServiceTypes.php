<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserServiceTypes extends Model
{
    use HasFactory;


    /**
     * @var string
     */
    protected $table = 'user_service_types';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'service_type_id',
    ];
}
