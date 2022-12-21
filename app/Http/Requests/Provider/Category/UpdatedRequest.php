<?php

namespace App\Http\Requests\Provider\Category;

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
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:150',
            'description' => 'required|string|max:225',
            'icon' => 'nullable|string|max:225',
        ];
    }
}

