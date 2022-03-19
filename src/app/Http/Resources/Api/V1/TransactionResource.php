<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'payment_type_id'   => $this->payment_type_id,
            'state_id'          => $this->state_id,
            'amount'            => $this->amount,
            'discount'          => $this->discount,
            'additional_field'  => $this->additional_field,
            'code'              => $this->code,
            'order'             => $this->order,
            'cash_amount'       => $this->cash_amount,
            'volume_weight'     => $this->volume_weight,
            'cash_change'       => $this->cash_change,
            'custome_fields'    => json_decode($this->custome_fields),
        ];
    }
}
