<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\State;
use App\Http\Resources\Api\V1\StateResource;

class StateRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(State $state)
    {
        $this->state = $state;
    }

    /**
     * Search and Filter States
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\StateResource
     */
    public function searchStates($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->state;
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
        return StateResource::collection($data);
    }
}
