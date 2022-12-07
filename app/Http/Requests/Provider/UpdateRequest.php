<?php

namespace App\Http\Requests\Provider;

use Illuminate\Validation\Rule;

class UpdateRequest extends IndexRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user();

        return [
            'invoice_email' => 'required|email|string|max:255',
            'name' => 'required|string|max:50',
            'postcode' => 'required|string|max:50',
            'line_1' => 'required|string|max:255',
            'line_2' => 'nullable|string|max:255',
            'landline' => 'nullable|string|max:100',
            'city' => 'required|string|max:255',
            'county' => 'nullable|string|max:255',
            'country' => 'required|string|max:2',
            'booking_by_specialist' => 'required:string|boolean',
            'show_service_prices_to_client' => 'required:number',
            'booking_auto_allocation' => 'required:string|boolean',
            'business_days' => 'required|array',
            'business_days.*.id' => Rule::exists('working_days', 'id')->where(function ($query) use ($user) {
                $query->where('provider_id', $user->provider_id);
            }),
        ];
    }
}
