<?php

namespace App\Http\Resources;

class ServiceTypeResource extends AdjustableDetailLevelResource
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
                'name' => $this->name,
                'notes' => $this->notes,
                'display' => $this->display,
                'discard' => $this->discard,
                'position' => $this->position,
                'provider' => new ProviderResource($this->whenLoaded('provider'), $this->detailLevel),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'auto_allocation' => $this->auto_allocation,
                'cost' => $this->cost,
                'duration_in_minutes' => $this->vat,
                'vat' => $this->vat,
                'category' => new ServiceCategoryResource($this->whenLoaded('category'), $this->detailLevel),
                'category_id' => $this->category_id,
                'pivot_cost' => $this->pivot->cost ?? null,
                'pivot_duration_in_minutes' => $this->pivot->duration_in_minutes ?? null,
                // 'pivot_vat' => $this->pivot->vat ?? null,
            ];
        }
    }
}
