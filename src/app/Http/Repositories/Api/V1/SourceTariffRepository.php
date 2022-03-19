<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\SourceTariff;
use App\Http\Resources\Api\V1\SourceTariffResource;

class SourceTariffRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(SourceTariff $sourceTariff)
    {
        $this->sourceTariff = $sourceTariff;
    }

    /**
     * Search and Filter SourceTariffs
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\SourceTariffResource
     */
    public function searchSourceTariffs($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->sourceTariff;
        $filters = [
            [
                'field' => 'db',
                'value' => $request->db,
                'query' => 'like'
            ],
        ];
        $data = $this->filterFields($data, $filters);
        $data = $this->setOrder($data, [$request->sort_by, $request->sort]);
        $data = $data->paginate($limit);
        return SourceTariffResource::collection($data);
    }
}
