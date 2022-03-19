<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\Connote;
use App\Http\Resources\Api\V1\ConnoteResource;

class ConnoteRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(Connote $connote)
    {
        $this->connote = $connote;
    }

    /**
     * Search and Filter Connotes
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\ConnoteResource
     */
    public function searchConnotes($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->connote;
        $filters = [
            [
                'field' => 'transaction_id',
                'value' => $request->transaction_id,
            ],
            [
                'field' => 'source_tariff_id',
                'value' => $request->source_tariff_id,
            ],
            [
                'field' => 'state_id',
                'value' => $request->state_id,
            ],
            [
                'field' => 'service',
                'value' => $request->service,
            ],
            [
                'field' => 'code',
                'value' => $request->code,
                'query' => 'like',
            ],
            [
                'field' => 'booking_code',
                'value' => $request->booking_code,
                'query' => 'like',
            ],
            [
                'field' => 'actual_weight',
                'value' => $request->actual_weight,
            ],
            [
                'field' => 'volume_weight',
                'value' => $request->volume_weight,
            ],
            [
                'field' => 'chargeable_weight',
                'value' => $request->chargeable_weight,
            ],
            [
                'field' => 'total_package',
                'value' => $request->total_package,
            ],
            [
                'field' => 'surcharge_amount',
                'value' => $request->surcharge_amount,
            ],
            [
                'field' => 'sla_day',
                'value' => $request->sla_day,
            ],
            [
                'field' => 'pod',
                'value' => $request->pod,
            ],
        ];
        $data = $this->filterFields($data, $filters);
        $data = $this->setOrder($data, [$request->sort_by, $request->sort]);
        $data = $data->paginate($limit);
        return ConnoteResource::collection($data);
    }
}
