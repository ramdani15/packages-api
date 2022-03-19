<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\Destination;
use App\Http\Resources\Api\V1\DestinationResource;

class DestinationRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(Destination $destination)
    {
        $this->destination = $destination;
    }

    /**
     * Search and Filter Destinations
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\DestinationResource
     */
    public function searchDestinations($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->destination;
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
        return DestinationResource::collection($data);
    }
}
