<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Http\Requests\Api\V1\DestinationRequest;
use App\Http\Resources\Api\V1\DestinationResource;
use App\Repositories\Api\V1\DestinationRepository;

class DestinationController extends Controller
{
    use ApiResponse;

    public function __construct(
        Destination $destination,
        DestinationRepository $destinationRepository
    ) {
        $this->destination = $destination;
        $this->destinationRepository = $destinationRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/destinations",
     *      summary="List Destinations",
     *      description="Get List Destinations",
     *      tags={"Destinations"},
     *      @OA\Parameter(
     *          name="transaction_id",
     *          in="query",
     *          description="Transaction ID"
     *      ),
     *      @OA\Parameter(
     *          name="customer_id",
     *          in="query",
     *          description="Customer ID"
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Destinations."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $destinations = $this->destinationRepository->searchDestinations($request);
            return $this->responseJson('pagination', 'Get Destinations Successfully.', $destinations, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Destinations.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/destinations",
     *      summary="Create Destination",
     *      description="Create Destination",
     *      tags={"Destinations"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass destination credentials",
     *          @OA\JsonContent(
     *              required={"transaction_id", "customer_id"},
     *              @OA\Property(property="transaction_id", type="number", example=1),
     *              @OA\Property(property="customer_id", type="number", example=1),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="transaction_id", type="number", example=1),
     *              @OA\Property(property="customer_id", type="number", example=1),
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
     *              @OA\Property(property="message", type="string", example="Failed to Create Destination."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(DestinationRequest $request)
    {
        try {
            $destination = $this->destination->create($request->validated());
            return $this->responseJson('created', 'Create Destination Successfully.', $destination, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create Destination.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/destinations/{id}",
     *      summary="Detail Destination",
     *      description="Get Detail Destination",
     *      tags={"Destinations"},
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
     *              @OA\Property(property="transaction_id", type="number", example=1),
     *              @OA\Property(property="customer_id", type="number", example=1),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Destination Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail Destination."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(DestinationRequest $request)
    {
        try {
            $destination = $this->destination->find($request->id);
            if (!$destination) {
                return $this->responseJson('error', 'Destination Not Found', '', 404);
            }
            $destination = new DestinationResource($destination);
            return $this->responseJson('success', 'Get Detail Destination Successfully.', $destination);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail Destination.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/destinations/{id}",
     *      summary="Update Destination",
     *      description="Update Data Destination",
     *      tags={"Destinations"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass destination credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="customer_id", type="number", example=2),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="transaction_id", type="number", example=1),
     *              @OA\Property(property="customer_id", type="number", example=2),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Destination Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Update Data Destination."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(DestinationRequest $request)
    {
        try {
            $destination = $this->destination->find($request->id);
            if (!$destination) {
                return $this->responseJson('error', 'Destination Not Found', '', 404);
            }
            $destination->update($request->validated());
            $destination = new DestinationResource($this->destination->find($destination->id));
            return $this->responseJson('success', 'Update Destination Successfully.', $destination);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update Destination.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/destinations/{id}",
     *      summary="Delete Destination",
     *      description="Delete Data Destination",
     *      tags={"Destinations"},
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
     *              @OA\Property(property="message", type="string", example="Destination Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Delete Destination."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(DestinationRequest $request)
    {
        try {
            $destination = $this->destination->find($request->id);
            if (!$destination) {
                return $this->responseJson('error', 'Destination Not Found', '', 404);
            }
            $destination->delete();
            return $this->responseJson('deleted', 'Delete Destination Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete Destination.', $th, $th->getCode() ?? 500);
        }
    }
}
