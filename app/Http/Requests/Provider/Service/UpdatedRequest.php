<?php

namespace App\Http\Requests\Provider\Service;

use App\Http\Requests\Provider\IndexRequest;
use Illuminate\Validation\Rule;

class UpdatedRequest extends IndexRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service_id' => Rule::exists('provider_services', 'service_id')->where(function ($query) {
                $query->where('provider_id', auth()->user()->provider_id);
            }),
            'cost' => 'nullable|numeric',
            'vat' => 'nullable|numeric',
        ];
    }
}