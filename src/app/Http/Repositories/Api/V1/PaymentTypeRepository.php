<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\PaymentType;
use App\Http\Resources\Api\V1\PaymentTypeResource;

class PaymentTypeRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(PaymentType $paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * Search and Filter PaymentTypes
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\PaymentTypeResource
     */
    public function searchPaymentTypes($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->paymentType;
        $filters = [
            [
                'field' => 'name',
                'value' => $request->name,
                'query' => 'like'
            ],
            [
                'field' => 'description',
                'value' => $request->description,
                'query' => 'like'
            ],
        ];
        $data = $this->filterFields($data, $filters);
        $data = $this->setOrder($data, [$request->sort_by, $request->sort]);
        $data = $data->paginate($limit);
        return PaymentTypeResource::collection($data);
    }
}
