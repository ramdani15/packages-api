<?php

namespace App\Http\Resources\Api\V1;

use App\Models\ConnoteHistory;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $connote = [];
        $kolis = [];
        if ($this->connote) {
            $connote = new ConnoteResource($this->connote);
            $connote['history'] = ConnoteHistoryResource::collection($this->connote->histories);
            $kolis = KoliResource::collection($this->connote->kolis);
        }

        $origin = [];
        if ($this->origin) {
            $origin = $this->origin;
            $customer = $origin->customer;
            $origin = [
                'customer' => new CustomerResource($customer),
                'location' => new LocationResource($customer->location),
                'organization' => new OrganizationResource($customer->organization),
            ];
        }
        $destination = [];
        if ($this->destination) {
            $destination = $this->destination;
            $customer = $destination->customer;
            $destination = [
                'customer' => new CustomerResource($customer),
                'location' => new LocationResource($customer->location),
                'organization' => new OrganizationResource($customer->organization),
            ];
        }
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
            'connote'           => $connote,
            'origin'            => $origin,
            'destination'       => $destination,
            'kolis'             => $kolis,
        ];
    }
}
