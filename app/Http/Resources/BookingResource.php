<?php

namespace App\Http\Resources;;

class BookingResource extends AdjustableDetailLevelResource
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
                'status' => $this->status,
                'discard' => $this->discard,
                'preferred_date' => $this->preferred_date,
                'cancelled_at' => $this->cancelled_at,
                'cancelled_reason' => $this->cancelled_reason,
                'rejected_at' => $this->rejected_at,
                'rejected_by' => $this->rejected_by,
                'rejected_reason' => $this->rejected_reason,
                'provider_id' => $this->provider_id,
                'staff_id' => $this->staff_id,
                'client_id' => $this->client_id,
                'car_id' => $this->car_id,
                'change_created_at' => $this->change_created_at,
                'client_notes' => $this->client_notes,
                'provider_notes' => $this->provider_notes,
                'provider' => new ProviderResource($this->whenLoaded('provider'), $this->detailLevel),
                'rejectedBy' => new UserResource($this->whenLoaded('rejectedBy'), $this->detailLevel),  
                'staff' => new UserResource($this->whenLoaded('staff'), $this->detailLevel),  
                'client' => new UserResource($this->whenLoaded('client'), $this->detailLevel),  
            ];
        }
    }
}
