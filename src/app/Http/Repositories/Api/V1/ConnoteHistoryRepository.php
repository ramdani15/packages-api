<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\ConnoteHistory;
use App\Http\Resources\Api\V1\ConnoteHistoryResource;

class ConnoteHistoryRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(ConnoteHistory $connoteHistory)
    {
        $this->connoteHistory = $connoteHistory;
    }

    /**
     * Search and Filter ConnoteHistorys
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\ConnoteHistoryResource
     */
    public function searchConnoteHistories($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->connoteHistory;
        $filters = [
            [
                'field' => 'connote_id',
                'value' => $request->connote_id,
            ],
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
        return ConnoteHistoryResource::collection($data);
    }
}
