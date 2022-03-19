<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Http\Requests\Api\V1\OrganizationRequest;
use App\Http\Resources\Api\V1\OrganizationResource;
use App\Repositories\Api\V1\OrganizationRepository;

class OrganizationController extends Controller
{
    use ApiResponse;

    public function __construct(
        Organization $organization,
        OrganizationRepository $organizationRepository
    ) {
        $this->organization = $organization;
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/organizations",
     *      summary="List Organizations",
     *      description="Get List Organizations",
     *      tags={"Organizations"},
     *      @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="Name"
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          in="query",
     *          description="Description"
     *      ),
     *      @OA\Parameter(
     *          name="sort",
     *          in="query",
     *          description="1 for Ascending -1 for Descending"
     *      ),
     *      @OA\Parameter(
     *          name="sort_by",
     *          in="query",
     *          description="Field to sort"
     *      ),
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Limit (Default 10)"
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Num Of Page"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object", example={}),
     *              @OA\Property(property="pagination", type="object", example={}),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to Get Organizations."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $organizations = $this->organizationRepository->searchOrganizations($request);
            return $this->responseJson('pagination', 'Get Organizations Successfully.', $organizations, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Organizations.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/organizations",
     *      summary="Create Organization",
     *      description="Create Organization",
     *      tags={"Organizations"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass organization credentials",
     *          @OA\JsonContent(
     *              required={"name", "description"},
     *              @OA\Property(property="name", type="string", example="organization1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="organization1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Wrong Credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={}),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to Create Organization."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(OrganizationRequest $request)
    {
        try {
            $organization = $this->organization->create($request->validated());
            return $this->responseJson('created', 'Create Organization Successfully.', $organization, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create Organization.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/organizations/{id}",
     *      summary="Detail Organization",
     *      description="Get Detail Organization",
     *      tags={"Organizations"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="organization1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Organization Not Found."),
     *              @OA\Property(property="code", type="number", example=404),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Wrong Credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={}),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail Organization."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(OrganizationRequest $request)
    {
        try {
            $organization = $this->organization->find($request->id);
            if (!$organization) {
                return $this->responseJson('error', 'Organization Not Found', '', 404);
            }
            $organization = new OrganizationResource($organization);
            return $this->responseJson('success', 'Get Detail Organization Successfully.', $organization);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail Organization.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/organizations/{id}",
     *      summary="Update Organization",
     *      description="Update Data Organization",
     *      tags={"Organizations"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass organization credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="update organization1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="update organization1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Organization Not Found."),
     *              @OA\Property(property="code", type="number", example=404),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Wrong Credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={}),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to Update Data Organization."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(OrganizationRequest $request)
    {
        try {
            $organization = $this->organization->find($request->id);
            if (!$organization) {
                return $this->responseJson('error', 'Organization Not Found', '', 404);
            }
            $organization->update($request->validated());
            $organization = new OrganizationResource($this->organization->find($organization->id));
            return $this->responseJson('success', 'Update Organization Successfully.', $organization);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update Organization.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/organizations/{id}",
     *      summary="Delete Organization",
     *      description="Delete Data Organization",
     *      tags={"Organizations"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="No Content",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Organization Not Found."),
     *              @OA\Property(property="code", type="number", example=404),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Wrong Credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={}),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to Delete Organization."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(OrganizationRequest $request)
    {
        try {
            $organization = $this->organization->find($request->id);
            if (!$organization) {
                return $this->responseJson('error', 'Organization Not Found', '', 404);
            }
            $organization->delete();
            return $this->responseJson('deleted', 'Delete Organization Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete Organization.', $th, $th->getCode() ?? 500);
        }
    }
}
