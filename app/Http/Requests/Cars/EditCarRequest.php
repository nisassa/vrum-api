<?php

namespace App\Http\Requests\Cars;

use Illuminate\Foundation\Http\FormRequest;

class EditCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'fuel_type' => 'required|string|max:255',
            'year' => 'required|string|max:255',
        ];
    }
}
