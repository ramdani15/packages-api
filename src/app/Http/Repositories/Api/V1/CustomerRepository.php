<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\Customer;
use App\Http\Resources\Api\V1\CustomerResource;

class CustomerRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Search and Filter Customers
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\CustomerResource
     */
    public function searchCustomers($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->customer;
        $filters = [
            [
                'field' => 'location_id',
                'value' => $request->location_id,
            ],
            [
                'field' => 'organization_id',
                'value' => $request->organization_id,
            ],
            [
                'field' => 'name',
                'value' => $request->name,
                'query' => 'like',
            ],
            [
                'field' => 'code',
                'value' => $request->code,
            ],
            [
                'field' => 'address',
                'value' => $request->address,
                'query' => 'like',
            ],
            [
                'field' => 'address_detail',
                'value' => $request->address_detail,
                'query' => 'like',
            ],
            [
                'field' => 'email',
                'value' => $request->email,
            ],
            [
                'field' => 'phone',
                'value' => $request->phone,
                'query' => 'like',
            ],
            [
                'field' => 'nama_sales',
                'value' => $request->nama_sales,
                'query' => 'like',
            ],
            [
                'field' => 'top',
                'value' => $request->top,
            ],
            [
                'field' => 'jenis_pelanggan',
                'value' => $request->jenis_pelanggan,
            ],
        ];
        $data = $this->filterFields($data, $filters);
        $data = $this->setOrder($data, [$request->sort_by, $request->sort]);
        $data = $data->paginate($limit);
        return CustomerResource::collection($data);
    }
}
