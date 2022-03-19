<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\Origin;
use App\Http\Resources\Api\V1\OriginResource;

class OriginRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(Origin $origin)
    {
        $this->origin = $origin;
    }

    /**
     * Search and Filter Origins
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\OriginResource
     */
    public function searchOrigins($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->origin;
        $filters = [
            [
                'field' => 'transaction_id',
                'value' => $request->transaction_id,
            ],
            [
                'field' => 'customer_id',
                'value' => $request->customer_id,
            ],
        ];
        $data = $this->filterFields($data, $filters);
        $data = $this->setOrder($data, [$request->sort_by, $request->sort]);
        $data = $data->paginate($limit);
        return OriginResource::collection($data);
    }
}
