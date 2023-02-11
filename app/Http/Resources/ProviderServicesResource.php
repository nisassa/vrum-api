<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderServicesResource extends AdjustableDetailLevelResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,    
            'provider_id' => $this->provider_id,    
            'service_id' => $this->service_id,    
            'cost' => $this->cost,    
            'vat' => $this->vat,    
            'duration_in_minutes' => $this->duration_in_minutes,    
            'service' => new ServiceTypeResource($this->whenLoaded('service'), $this->detailLevel),  
        ];
    }
}
