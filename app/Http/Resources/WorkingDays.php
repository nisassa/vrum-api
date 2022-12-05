<?php

namespace App\Http\Resources;

class WorkingDays extends AdjustableDetailLevelResource
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
            'day' => $this->day,
            'start_at' => \Carbon\Carbon::createFromFormat('H:i:s',$this->start_at)->format('h:i'),
            'end_at' => \Carbon\Carbon::createFromFormat('H:i:s',$this->end_at)->format('h:i'),
            'provider_id' => $this->provider_id,
            'user_id' => $this->user_id,
            'is_active' => $this->is_active,
        ];
    }
}
