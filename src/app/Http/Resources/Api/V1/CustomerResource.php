<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'location_id'       => $this->location_id,
            'organization_id'   => $this->organization_id,
            'name'              => $this->name,
            'code'              => $this->code,
            'address'           => $this->address,
            'address_detail'    => $this->address_detail,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'nama_sales'        => $this->nama_sales,
            'top'               => $this->top,
            'jenis_pelanggan'   => $this->jenis_pelanggan,
        ];
    }
}
