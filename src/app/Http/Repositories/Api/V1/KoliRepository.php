<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\Koli;
use App\Http\Resources\Api\V1\KoliResource;

class KoliRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(Koli $koli)
    {
        $this->koli = $koli;
    }

    /**
     * Search and Filter Kolis
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\KoliResource
     */
    public function searchKolis($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->koli;
        $filters = [
            [
                'field' => 'connote_id',
                'value' => $request->connote_id,
            ],
            [
                'field' => 'formula_id',
                'value' => $request->formula_id,
            ],
            [
                'field' => 'code',
                'value' => $request->code,
            ],
            [
                'field' => 'length',
                'value' => $request->length,
            ],
            [
                'field' => 'awb_url',
                'value' => $request->awb_url,
                'query' => 'like',
            ],
            [
                'field' => 'chargeable_weight',
                'value' => $request->chargeable_weight,
            ],
            [
                'field' => 'width',
                'value' => $request->width,
            ],
            [
                'field' => 'height',
                'value' => $request->height,
            ],
            [
                'field' => 'description',
                'value' => $request->description,
            ],
            [
                'field' => 'volume',
                'value' => $request->volume,
            ],
            [
                'field' => 'weight',
                'value' => $request->weight,
            ],
        ];
        $data = $this->filterFields($data, $filters);
        $data = $this->setOrder($data, [$request->sort_by, $request->sort]);
        $data = $data->paginate($limit);
        return KoliResource::collection($data);
    }
}
