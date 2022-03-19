<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Origin;
use App\Http\Requests\Api\V1\OriginRequest;
use App\Http\Resources\Api\V1\OriginResource;
use App\Repositories\Api\V1\OriginRepository;

class OriginController extends Controller
{
    use ApiResponse;

    public function __construct(
        Origin $origin,
        OriginRepository $originRepository
    ) {
        $this->origin = $origin;
        $this->originRepository = $originRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/origins",
     *      summary="List Origins",
     *      description="Get List Origins",
     *      tags={"Origins"},
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Origins."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $origins = $this->originRepository->searchOrigins($request);
            return $this->responseJson('pagination', 'Get Origins Successfully.', $origins, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Origins.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/origins",
     *      summary="Create Origin",
     *      description="Create Origin",
     *      tags={"Origins"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass origin credentials",
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
     *              @OA\Property(property="message", type="string", example="Failed to Create Origin."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(OriginRequest $request)
    {
        try {
            $origin = $this->origin->create($request->validated());
            return $this->responseJson('created', 'Create Origin Successfully.', $origin, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create Origin.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/origins/{id}",
     *      summary="Detail Origin",
     *      description="Get Detail Origin",
     *      tags={"Origins"},
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
     *              @OA\Property(property="message", type="string", example="Origin Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail Origin."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(OriginRequest $request)
    {
        try {
            $origin = $this->origin->find($request->id);
            if (!$origin) {
                return $this->responseJson('error', 'Origin Not Found', '', 404);
            }
            $origin = new OriginResource($origin);
            return $this->responseJson('success', 'Get Detail Origin Successfully.', $origin);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail Origin.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/origins/{id}",
     *      summary="Update Origin",
     *      description="Update Data Origin",
     *      tags={"Origins"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass origin credentials",
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
     *              @OA\Property(property="message", type="string", example="Origin Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Update Data Origin."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(OriginRequest $request)
    {
        try {
            $origin = $this->origin->find($request->id);
            if (!$origin) {
                return $this->responseJson('error', 'Origin Not Found', '', 404);
            }
            $origin->update($request->validated());
            $origin = new OriginResource($this->origin->find($origin->id));
            return $this->responseJson('success', 'Update Origin Successfully.', $origin);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update Origin.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/origins/{id}",
     *      summary="Delete Origin",
     *      description="Delete Data Origin",
     *      tags={"Origins"},
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
     *              @OA\Property(property="message", type="string", example="Origin Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Delete Origin."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(OriginRequest $request)
    {
        try {
            $origin = $this->origin->find($request->id);
            if (!$origin) {
                return $this->responseJson('error', 'Origin Not Found', '', 404);
            }
            $origin->delete();
            return $this->responseJson('deleted', 'Delete Origin Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete Origin.', $th, $th->getCode() ?? 500);
        }
    }
}
