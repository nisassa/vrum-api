<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends AdjustableDetailLevelResource
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
                'make' => $this->make,
                'model' => $this->model,
                'fuel_type' => $this->fuel_type,
                'year' => $this->year,
                'client_id' => $this->client_id,
                'client' => new UserResource($this->whenLoaded('client'), $this->detailLevel), 
            ];
        }
    }
}
