<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\Location;
use App\Http\Resources\Api\V1\LocationResource;

class LocationRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    /**
     * Search and Filter Locations
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\LocationResource
     */
    public function searchLocations($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->location;
        $filters = [
            [
                'field' => 'name',
                'value' => $request->name,
                'query' => 'like'
            ],
            [
                'field' => 'zip_code',
                'value' => $request->zip_code,
                'query' => 'like'
            ],
            [
                'field' => 'zone_code',
                'value' => $request->zone_code,
                'query' => 'like'
            ],
        ];
        $data = $this->filterFields($data, $filters);
        $data = $this->setOrder($data, [$request->sort_by, $request->sort]);
        $data = $data->paginate($limit);
        return LocationResource::collection($data);
    }
}
