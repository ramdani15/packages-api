<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class KoliResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'connote_id'        => $this->connote_id,
            'formula_id'        => $this->formula_id,
            'code'              => $this->code,
            'length'            => $this->length,
            'awb_url'           => $this->awb_url,
            'chargeable_weight' => $this->chargeable_weight,
            'width'             => $this->width,
            'surcharge'         => json_decode($this->surcharge),
            'height'            => $this->height,
            'description'       => $this->description,
            'volume'            => $this->volume,
            'weight'            => $this->weight,
            'custome_fields'    => json_decode($this->custome_fields),
        ];
    }
}
