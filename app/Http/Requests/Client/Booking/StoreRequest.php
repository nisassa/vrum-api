<?php

namespace App\Http\Requests\Client\Booking;

use App\Http\Requests\Client\IndexRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends IndexRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [            
            'preferred_date' => [
                'required',
                'date_format:Y-m-d H:i:s',
                'after:'.now(), 
            ],
            'provider_id' => Rule::exists('providers', 'id')->where(function ($query) {
                $query->where('discard', 0);
            }),
            'car_id' => Rule::exists('cars', 'id')->where(function ($query) {
                $query->where('discard', 0);
            }),
            'client_notes' => 'nullable|string|max:1000',
            'service_types' => 'required|array',
            'service_types.*' => Rule::exists('service_types', 'id')->where(function ($query) {
                $query->where('discard', 0);
            }),
        ];
    }
}
