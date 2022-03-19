<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use App\Http\Requests\Api\V1\PaymentTypeRequest;
use App\Http\Resources\Api\V1\PaymentTypeResource;
use App\Repositories\Api\V1\PaymentTypeRepository;

class PaymentTypeController extends Controller
{
    use ApiResponse;

    public function __construct(
        PaymentType $paymentType,
        PaymentTypeRepository $paymentTypeRepository
    ) {
        $this->paymentType = $paymentType;
        $this->paymentTypeRepository = $paymentTypeRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/payment-types",
     *      summary="List PaymentTypes",
     *      description="Get List PaymentTypes",
     *      tags={"PaymentTypes"},
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
     *              @OA\Property(property="message", type="string", example="Failed to Get PaymentTypes."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $paymentTypes = $this->paymentTypeRepository->searchPaymentTypes($request);
            return $this->responseJson('pagination', 'Get PaymentTypes Successfully.', $paymentTypes, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get PaymentTypes.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/payment-types",
     *      summary="Create PaymentType",
     *      description="Create PaymentType",
     *      tags={"PaymentTypes"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass paymentType credentials",
     *          @OA\JsonContent(
     *              required={"name", "description"},
     *              @OA\Property(property="name", type="string", example="paymentType1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="paymentType1"),
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
     *              @OA\Property(property="message", type="string", example="Failed to Create PaymentType."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(PaymentTypeRequest $request)
    {
        try {
            $paymentType = $this->paymentType->create($request->validated());
            return $this->responseJson('created', 'Create PaymentType Successfully.', $paymentType, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create PaymentType.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/payment-types/{id}",
     *      summary="Detail PaymentType",
     *      description="Get Detail PaymentType",
     *      tags={"PaymentTypes"},
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
     *              @OA\Property(property="name", type="string", example="paymentType1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="PaymentType Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail PaymentType."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(PaymentTypeRequest $request)
    {
        try {
            $paymentType = $this->paymentType->find($request->id);
            if (!$paymentType) {
                return $this->responseJson('error', 'PaymentType Not Found', '', 404);
            }
            $paymentType = new PaymentTypeResource($paymentType);
            return $this->responseJson('success', 'Get Detail PaymentType Successfully.', $paymentType);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail PaymentType.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/payment-types/{id}",
     *      summary="Update PaymentType",
     *      description="Update Data PaymentType",
     *      tags={"PaymentTypes"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass paymentType credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="update paymentType1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="update paymentType1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="PaymentType Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Update Data PaymentType."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(PaymentTypeRequest $request)
    {
        try {
            $paymentType = $this->paymentType->find($request->id);
            if (!$paymentType) {
                return $this->responseJson('error', 'PaymentType Not Found', '', 404);
            }
            $paymentType->update($request->validated());
            $paymentType = new PaymentTypeResource($this->paymentType->find($paymentType->id));
            return $this->responseJson('success', 'Update PaymentType Successfully.', $paymentType);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update PaymentType.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/payment-types/{id}",
     *      summary="Delete PaymentType",
     *      description="Delete Data PaymentType",
     *      tags={"PaymentTypes"},
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
     *              @OA\Property(property="message", type="string", example="PaymentType Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Delete PaymentType."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(PaymentTypeRequest $request)
    {
        try {
            $paymentType = $this->paymentType->find($request->id);
            if (!$paymentType) {
                return $this->responseJson('error', 'PaymentType Not Found', '', 404);
            }
            $paymentType->delete();
            return $this->responseJson('deleted', 'Delete PaymentType Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete PaymentType.', $th, $th->getCode() ?? 500);
        }
    }
}
