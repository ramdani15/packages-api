<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Http\Requests\Api\V1\LocationRequest;
use App\Http\Resources\Api\V1\LocationResource;
use App\Repositories\Api\V1\LocationRepository;

class LocationController extends Controller
{
    use ApiResponse;

    public function __construct(
        Location $location,
        LocationRepository $locationRepository
    ) {
        $this->location = $location;
        $this->locationRepository = $locationRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/locations",
     *      summary="List Locations",
     *      description="Get List Locations",
     *      tags={"Locations"},
     *      @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="Name"
     *      ),
     *      @OA\Parameter(
     *          name="zip_code",
     *          in="query",
     *          description="Zip Code"
     *      ),
     *      @OA\Parameter(
     *          name="zone_code",
     *          in="query",
     *          description="Zone Code"
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Locations."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $locations = $this->locationRepository->searchLocations($request);
            return $this->responseJson('pagination', 'Get Locations Successfully.', $locations, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Locations.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/locations",
     *      summary="Create Location",
     *      description="Create Location",
     *      tags={"Locations"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass location credentials",
     *          @OA\JsonContent(
     *              required={"name", "zip_code", "zone_code"},
     *              @OA\Property(property="name", type="string", example="location1"),
     *              @OA\Property(property="zip_code", type="string", example="12420"),
     *              @OA\Property(property="zone_code", type="string", example="CGKFT"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="location1"),
     *              @OA\Property(property="zip_code", type="string", example="12420"),
     *              @OA\Property(property="zone_code", type="string", example="CGKFT"),
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
     *              @OA\Property(property="message", type="string", example="Failed to Create Location."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(LocationRequest $request)
    {
        try {
            $location = $this->location->create($request->validated());
            return $this->responseJson('created', 'Create Location Successfully.', $location, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create Location.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/locations/{id}",
     *      summary="Detail Location",
     *      description="Get Detail Location",
     *      tags={"Locations"},
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
     *              @OA\Property(property="name", type="string", example="location1"),
     *              @OA\Property(property="zip_code", type="string", example="12420"),
     *              @OA\Property(property="zone_code", type="string", example="CGKFT"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Location Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail Location."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(LocationRequest $request)
    {
        try {
            $location = $this->location->find($request->id);
            if (!$location) {
                return $this->responseJson('error', 'Location Not Found', '', 404);
            }
            $location = new LocationResource($location);
            return $this->responseJson('success', 'Get Detail Location Successfully.', $location);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail Location.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/locations/{id}",
     *      summary="Update Location",
     *      description="Update Data Location",
     *      tags={"Locations"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass location credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="location1 update"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="location1 update"),
     *              @OA\Property(property="zip_code", type="string", example="12420"),
     *              @OA\Property(property="zone_code", type="string", example="CGKFT"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Location Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Update Data Location."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(LocationRequest $request)
    {
        try {
            $location = $this->location->find($request->id);
            if (!$location) {
                return $this->responseJson('error', 'Location Not Found', '', 404);
            }
            $location->update($request->validated());
            $location = new LocationResource($this->location->find($location->id));
            return $this->responseJson('success', 'Update Location Successfully.', $location);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update Location.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/locations/{id}",
     *      summary="Delete Location",
     *      description="Delete Data Location",
     *      tags={"Locations"},
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
     *              @OA\Property(property="message", type="string", example="Location Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Delete Location."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(LocationRequest $request)
    {
        try {
            $location = $this->location->find($request->id);
            if (!$location) {
                return $this->responseJson('error', 'Location Not Found', '', 404);
            }
            $location->delete();
            return $this->responseJson('deleted', 'Delete Location Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete Location.', $th, $th->getCode() ?? 500);
        }
    }
}
