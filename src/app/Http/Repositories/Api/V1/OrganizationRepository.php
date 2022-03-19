<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\Organization;
use App\Http\Resources\Api\V1\OrganizationResource;

class OrganizationRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Search and Filter Organizations
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\OrganizationResource
     */
    public function searchOrganizations($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->organization;
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
        return OrganizationResource::collection($data);
    }
}
