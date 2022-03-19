<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Connote;
use App\Http\Requests\Api\V1\ConnoteRequest;
use App\Http\Resources\Api\V1\ConnoteResource;
use App\Repositories\Api\V1\ConnoteRepository;

class ConnoteController extends Controller
{
    use ApiResponse;

    public function __construct(
        Connote $connote,
        ConnoteRepository $connoteRepository
    ) {
        $this->connote = $connote;
        $this->connoteRepository = $connoteRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/connotes",
     *      summary="List Connotes",
     *      description="Get List Connotes",
     *      tags={"Connotes"},
     *      @OA\Parameter(
     *          name="transaction_id",
     *          in="query",
     *          description="Transaction ID"
     *      ),
     *      @OA\Parameter(
     *          name="source_tariff_id",
     *          in="query",
     *          description="Source Tariff ID"
     *      ),
     *      @OA\Parameter(
     *          name="state_id",
     *          in="query",
     *          description="State ID"
     *      ),
     *      @OA\Parameter(
     *          name="number",
     *          in="query",
     *          description="Number"
     *      ),
     *      @OA\Parameter(
     *          name="service",
     *          in="query",
     *          description="Service"
     *      ),
     *      @OA\Parameter(
     *          name="code",
     *          in="query",
     *          description="Code"
     *      ),
     *      @OA\Parameter(
     *          name="booking_code",
     *          in="query",
     *          description="Booking Code"
     *      ),
     *      @OA\Parameter(
     *          name="actual_weight",
     *          in="query",
     *          description="Actual Weight"
     *      ),
     *      @OA\Parameter(
     *          name="volume_weight",
     *          in="query",
     *          description="Volume Weight"
     *      ),
     *      @OA\Parameter(
     *          name="chargeable_weight",
     *          in="query",
     *          description="Chargeable Weight"
     *      ),
     *      @OA\Parameter(
     *          name="total_package",
     *          in="query",
     *          description="Total Package"
     *      ),
     *      @OA\Parameter(
     *          name="surcharge_amount",
     *          in="query",
     *          description="Surcharge Amount"
     *      ),
     *      @OA\Parameter(
     *          name="sla_day",
     *          in="query",
     *          description="Sla Day"
     *      ),
     *      @OA\Parameter(
     *          name="pod",
     *          in="query",
     *          description="POD"
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Connotes."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $connotes = $this->connoteRepository->searchConnotes($request);
            return $this->responseJson('pagination', 'Get Connotes Successfully.', $connotes, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Connotes.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/connotes",
     *      summary="Create Connote",
     *      description="Create Connote",
     *      tags={"Connotes"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass connote credentials",
     *          @OA\JsonContent(
     *              required={"transaction_id", "source_tariff_id", "state_id", "number", "service", "code", "actual_weight", "volume_weight", "chargeable_weight", "total_package", "surcharge_amount", "sla_day"},
     *              @OA\Property(property="transaction_id", type="number", example=1),
     *              @OA\Property(property="source_tariff_id", type="number", example=1),
     *              @OA\Property(property="state_id", type="number", example=1),
     *              @OA\Property(property="number", type="number", example=1),
     *              @OA\Property(property="service", type="string", example="service1"),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="booking_code", type="string", example=null),
     *              @OA\Property(property="actual_weight", type="decimal", example=10.5),
     *              @OA\Property(property="volume_weight", type="decimal", example=11.5),
     *              @OA\Property(property="chargeable_weight", type="decimal", example=12.5),
     *              @OA\Property(property="total_package", type="number", example=13),
     *              @OA\Property(property="surcharge_amount", type="number", example=14),
     *              @OA\Property(property="sla_day", type="number", example=15),
     *              @OA\Property(property="pod", type="string", example=null),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="transaction_id", type="number", example=1),
     *              @OA\Property(property="source_tariff_id", type="number", example=1),
     *              @OA\Property(property="state_id", type="number", example=1),
     *              @OA\Property(property="number", type="number", example=1),
     *              @OA\Property(property="service", type="string", example="service1"),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="booking_code", type="string", example=null),
     *              @OA\Property(property="actual_weight", type="decimal", example=10.5),
     *              @OA\Property(property="volume_weight", type="decimal", example=11.5),
     *              @OA\Property(property="chargeable_weight", type="decimal", example=12.5),
     *              @OA\Property(property="total_package", type="number", example=13),
     *              @OA\Property(property="surcharge_amount", type="number", example=14),
     *              @OA\Property(property="sla_day", type="number", example=15),
     *              @OA\Property(property="pod", type="string", example=null),
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
     *              @OA\Property(property="message", type="string", example="Failed to Create Connote."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(ConnoteRequest $request)
    {
        try {
            $connote = $this->connote->create($request->validated());
            return $this->responseJson('created', 'Create Connote Successfully.', $connote, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create Connote.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/connotes/{id}",
     *      summary="Detail Connote",
     *      description="Get Detail Connote",
     *      tags={"Connotes"},
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
     *              @OA\Property(property="source_tariff_id", type="number", example=1),
     *              @OA\Property(property="state_id", type="number", example=1),
     *              @OA\Property(property="number", type="number", example=1),
     *              @OA\Property(property="service", type="string", example="service1"),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="booking_code", type="string", example=null),
     *              @OA\Property(property="actual_weight", type="decimal", example=10.5),
     *              @OA\Property(property="volume_weight", type="decimal", example=11.5),
     *              @OA\Property(property="chargeable_weight", type="decimal", example=12.5),
     *              @OA\Property(property="total_package", type="number", example=13),
     *              @OA\Property(property="surcharge_amount", type="number", example=14),
     *              @OA\Property(property="sla_day", type="number", example=15),
     *              @OA\Property(property="pod", type="string", example=null),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Connote Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail Connote."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(ConnoteRequest $request)
    {
        try {
            $connote = $this->connote->find($request->id);
            if (!$connote) {
                return $this->responseJson('error', 'Connote Not Found', '', 404);
            }
            $connote = new ConnoteResource($connote);
            return $this->responseJson('success', 'Get Detail Connote Successfully.', $connote);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail Connote.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/connotes/{id}",
     *      summary="Update Connote",
     *      description="Update Data Connote",
     *      tags={"Connotes"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass connote credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="service", type="string", example="update service1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="transaction_id", type="number", example=1),
     *              @OA\Property(property="source_tariff_id", type="number", example=1),
     *              @OA\Property(property="state_id", type="number", example=1),
     *              @OA\Property(property="number", type="number", example=1),
     *              @OA\Property(property="service", type="string", example="update service1"),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="booking_code", type="string", example=null),
     *              @OA\Property(property="actual_weight", type="decimal", example=10.5),
     *              @OA\Property(property="volume_weight", type="decimal", example=11.5),
     *              @OA\Property(property="chargeable_weight", type="decimal", example=12.5),
     *              @OA\Property(property="total_package", type="number", example=13),
     *              @OA\Property(property="surcharge_amount", type="number", example=14),
     *              @OA\Property(property="sla_day", type="number", example=15),
     *              @OA\Property(property="pod", type="string", example=null),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Connote Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Update Data Connote."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(ConnoteRequest $request)
    {
        try {
            $connote = $this->connote->find($request->id);
            if (!$connote) {
                return $this->responseJson('error', 'Connote Not Found', '', 404);
            }
            $connote->update($request->validated());
            $connote = new ConnoteResource($this->connote->find($connote->id));
            return $this->responseJson('success', 'Update Connote Successfully.', $connote);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update Connote.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/connotes/{id}",
     *      summary="Delete Connote",
     *      description="Delete Data Connote",
     *      tags={"Connotes"},
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
     *              @OA\Property(property="message", type="string", example="Connote Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Delete Connote."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(ConnoteRequest $request)
    {
        try {
            $connote = $this->connote->find($request->id);
            if (!$connote) {
                return $this->responseJson('error', 'Connote Not Found', '', 404);
            }
            $connote->delete();
            return $this->responseJson('deleted', 'Delete Connote Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete Connote.', $th, $th->getCode() ?? 500);
        }
    }
}
