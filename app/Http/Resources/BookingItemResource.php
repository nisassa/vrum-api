<?php

namespace App\Http\Resources;


class BookingItemResource extends AdjustableDetailLevelResource
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
            ];
        } else {
            return [
                'id' => $this->id,    
                'discard' => $this->discard,
                'booking_id' => $this->booking_id,
                'services_id' => $this->services_id,
                'cost' => $this->cost,
                'vat' => $this->vat,
                'booking' => new BookingResource($this->whenLoaded('booking'), $this->detailLevel),
                'service' => new ProviderServicesResource($this->whenLoaded('service'), $this->detailLevel),  
            ];
        }
    }
}
