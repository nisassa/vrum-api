<?php

namespace App\Http\Resources;

class ProviderResource extends AdjustableDetailLevelResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->detailLevel === self::DETAIL_MINIMAL) {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'live_api_key' => $this->live_api_key,
                'test_api_key' => $this->test_api_key,
            ];
        } else {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'live_api_key' => $this->live_api_key,
                'test_api_key' => $this->test_api_key,
                'invoice_email' => $this->invoice_email,
                'vip' => $this->vip,
                'booking_by_specialist' => $this->booking_by_specialist,
                'booking_auto_allocation' => $this->booking_auto_allocation,
                'show_service_prices_to_client' => $this->show_service_prices_to_client,
                'landline' => $this->landline,
                'discard' => $this->discard,
                'line_1' => $this->line_1,
                'line_2' => $this->line_2,
                'city' => $this->city,
                'county' => $this->county,
                'country' => $this->country,
                'postcode' => $this->postcode,
                'lat' => $this->lat,
                'long' => $this->long,
                'working_days' => WorkingDays::collection($this->whenLoaded('working_days')),
            ];
        }
    }
}
