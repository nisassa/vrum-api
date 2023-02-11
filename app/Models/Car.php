<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';
    
    protected $primaryKey = 'id';

    protected $visible = [
        'discard',
        'make',
        'model',
        'fuel_type',
        'year',
        'client_id',
    ];

    protected $fillable = [
        'discard',
        'make',
        'model',
        'fuel_type',
        'year',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }
}
