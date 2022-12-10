<?php

namespace App\Http\Requests\Provider\Service;

use App\Http\Requests\Provider\IndexRequest;

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
        ];
    }
}