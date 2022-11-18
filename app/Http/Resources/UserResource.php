<?php

namespace App\Http\Resources;

class UserResource extends AdjustableDetailLevelResource
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
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'type' => $this->type,
                'manager' => $this->manager,
                'discard' => $this->discard
            ];
        } else {
            return [
                'id' => $this->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'provider' => new ProviderResource($this->whenLoaded('provider'), $this->detailLevel),
                'admin' => $this->admin,
                'developer' => $this->developer,
                'discard' => $this->discard,
                'manager' => $this->manager,
                'type' => $this->type,
                'job_title' => $this->job_title,
                'photo' => $this->photo,
                'landline' => $this->landline,
                'line_1' => $this->line_1,
                'line_2' => $this->line_2,
                'city' => $this->city,
                'county' => $this->county,
                'country' => $this->country,
                'postcode' => $this->postcode,
                'lat' => $this->lat,
                'long' => $this->long
            ];
        }
    }
}
