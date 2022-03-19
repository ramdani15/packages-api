<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\Formula;
use App\Http\Resources\Api\V1\FormulaResource;

class FormulaRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(Formula $formula)
    {
        $this->formula = $formula;
    }

    /**
     * Search and Filter Formulas
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\FormulaResource
     */
    public function searchFormulas($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->formula;
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
        return FormulaResource::collection($data);
    }
}
