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
            'name' => 'required|string|max:255',
            'notes' => 'required|string|max:255',
            'display' => 'nullable|numeric',
            'position' => 'nullable|numeric',
            'category_id' => Rule::exists('service_category', 'id')->where(function ($query) {
                $query->where('discard', 0);
            }),
        ];
    }
}