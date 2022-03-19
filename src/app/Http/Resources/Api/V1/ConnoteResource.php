<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ConnoteResource extends JsonResource
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
            'transaction_id'    => $this->transaction_id,
            'source_tariff_id'  => $this->source_tariff_id,
            'state_id'          => $this->state_id,
            'number'            => $this->number,
            'service'           => $this->service,
            'code'              => $this->code,
            'booking_code'      => $this->booking_code,
            'actual_weight'     => $this->actual_weight,
            'volume_weight'     => $this->volume_weight,
            'chargeable_weight' => $this->chargeable_weight,
            'total_package'     => $this->total_package,
            'surcharge_amount'  => $this->surcharge_amount,
            'sla_day'           => $this->sla_day,
            'pod'               => $this->pod,
        ];
    }
}
