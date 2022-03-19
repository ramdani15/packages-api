<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Http\Requests\Api\V1\PackageRequest;
use App\Http\Resources\Api\V1\PackageResource;
use App\Repositories\Api\V1\PackageRepository;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    use ApiResponse;

    public function __construct(
        Transaction $transaction,
        PackageRepository $packageRepository
    ) {
        $this->transaction = $transaction;
        $this->packageRepository = $packageRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/packages",
     *      summary="List Packages",
     *      description="Get List Packages",
     *      tags={"Packages"},
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Packages."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $packages = $this->packageRepository->searchPackages($request);
            return $this->responseJson('pagination', 'Get Packages Successfully.', $packages, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Packages.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/packages",
     *      summary="Create Package",
     *      description="Create Package",
     *      tags={"Packages"},
     *      @OA\Parameter(
     *          name="body",
     *          in="query",
     *          required=false,
     *          explode=true,
     *          @OA\Schema(
     *              collectionFormat="multi",
     *              required={"payment_type_id", "state_id", "amount", "discount", "code", "order", "cash_amount", "cash_change", "origin_customer_id", "destination_customer_id", "connote"},
     *              @OA\Property(property="payment_type_id", type="number", example=1),
     *              @OA\Property(property="state_id", type="number", example=1),
     *              @OA\Property(property="amount", type="string", example="10"),
     *              @OA\Property(property="discount", type="string", example="11"),
     *              @OA\Property(property="additional_field", type="string", example=null),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="order", type="number", example=11),
     *              @OA\Property(property="cash_amount", type="decimal", example=12.5),
     *              @OA\Property(property="cash_change", type="decimal", example=13.5),
     *              @OA\Property(property="origin_customer_id", type="number", example=1),
     *              @OA\Property(property="destination_customer_id", type="number", example=2),
     *              @OA\Property(
     *                    property="connote",
     *                    type="array",
     *                    @OA\Items(
     *                          type="object",
     *                          format="query",
     *                          @OA\Property(property="source_tariff_id", type="number", example=1),
     *                          @OA\Property(property="state_id", type="number", example=1),
     *                          @OA\Property(property="service", type="string", example="service1"),
     *                          @OA\Property(property="code", type="string", example="code1"),
     *                          @OA\Property(property="booking_code", type="string", example=null),
     *                          @OA\Property(property="actual_weight", type="decimal", example=10.5),
     *                          @OA\Property(property="volume_weight", type="decimal", example=11.5),
     *                          @OA\Property(property="chargeable_weight", type="decimal", example=12.5),
     *                          @OA\Property(property="total_package", type="number", example=13),
     *                          @OA\Property(property="surcharge_amount", type="number", example=14),
     *                          @OA\Property(property="sla_day", type="number", example=15),
     *                          @OA\Property(property="pod", type="string", example=null),
     *                    ),
     *              ),
     *              @OA\Property(
     *                    property="kolis[0]",
     *                    type="array",
     *                    @OA\Items(
     *                          type="object",
     *                          format="query",
     *                          @OA\Property(property="length", type="number", example=10),
     *                          @OA\Property(property="awb_url", type="string", example="http://localhost.com/awb.png"),
     *                          @OA\Property(property="chargeable_weight", type="decimal", example=11.5),
     *                          @OA\Property(property="width", type="numeric", example=12),
     *                          @OA\Property(property="height", type="numeric", example=13),
     *                          @OA\Property(property="description", type="string", example="description1"),
     *                          @OA\Property(property="volume", type="decimal", example=13.5),
     *                          @OA\Property(property="weight", type="number", example=14),
     *                    ),
     *              ),
     *              @OA\Property(
     *                    property="kolis[1]",
     *                    type="array",
     *                    @OA\Items(
     *                          type="object",
     *                          format="query",
     *                          @OA\Property(property="length", type="number", example=10),
     *                          @OA\Property(property="awb_url", type="string", example="http://localhost.com/awb.png"),
     *                          @OA\Property(property="chargeable_weight", type="decimal", example=11.5),
     *                          @OA\Property(property="width", type="numeric", example=12),
     *                          @OA\Property(property="height", type="numeric", example=13),
     *                          @OA\Property(property="description", type="string", example="description2"),
     *                          @OA\Property(property="volume", type="decimal", example=13.5),
     *                          @OA\Property(property="weight", type="number", example=14),
     *                    ),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="payment_type_id", type="number", example=1),
     *              @OA\Property(property="state_id", type="number", example=1),
     *              @OA\Property(property="amount", type="string", example="10"),
     *              @OA\Property(property="discount", type="string", example="11"),
     *              @OA\Property(property="additional_field", type="string", example=null),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="order", type="number", example=11),
     *              @OA\Property(property="cash_amount", type="decimal", example=12.5),
     *              @OA\Property(property="cash_change", type="decimal", example=13.5),
     *              @OA\Property(property="origin_customer_id", type="number", example=1),
     *              @OA\Property(property="destination_customer_id", type="number", example=2),
     *              @OA\Property(
     *                    property="connote",
     *                    type="array",
     *                    @OA\Items(
     *                          type="object",
     *                          format="query",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="source_tariff_id", type="number", example=1),
     *                          @OA\Property(property="state_id", type="number", example=1),
     *                          @OA\Property(property="service", type="string", example="service1"),
     *                          @OA\Property(property="code", type="string", example="code1"),
     *                          @OA\Property(property="booking_code", type="string", example=null),
     *                          @OA\Property(property="actual_weight", type="decimal", example=10.5),
     *                          @OA\Property(property="volume_weight", type="decimal", example=11.5),
     *                          @OA\Property(property="chargeable_weight", type="decimal", example=12.5),
     *                          @OA\Property(property="total_package", type="number", example=13),
     *                          @OA\Property(property="surcharge_amount", type="number", example=14),
     *                          @OA\Property(property="sla_day", type="number", example=15),
     *                          @OA\Property(property="pod", type="string", example=null),
     *                    ),
     *              ),
     *              @OA\Property(
     *                    property="kolis[0]",
     *                    type="array",
     *                    @OA\Items(
     *                          type="object",
     *                          format="query",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="length", type="number", example=10),
     *                          @OA\Property(property="awb_url", type="string", example="http://localhost.com/awb.png"),
     *                          @OA\Property(property="chargeable_weight", type="decimal", example=11.5),
     *                          @OA\Property(property="width", type="numeric", example=12),
     *                          @OA\Property(property="height", type="numeric", example=13),
     *                          @OA\Property(property="description", type="string", example="description1"),
     *                          @OA\Property(property="volume", type="decimal", example=13.5),
     *                          @OA\Property(property="weight", type="number", example=14),
     *                    ),
     *              ),
     *              @OA\Property(
     *                    property="kolis[1]",
     *                    type="array",
     *                    @OA\Items(
     *                          type="object",
     *                          format="query",
     *                          @OA\Property(property="id", type="number", example=2),
     *                          @OA\Property(property="length", type="number", example=10),
     *                          @OA\Property(property="awb_url", type="string", example="http://localhost.com/awb.png"),
     *                          @OA\Property(property="chargeable_weight", type="decimal", example=11.5),
     *                          @OA\Property(property="width", type="numeric", example=12),
     *                          @OA\Property(property="height", type="numeric", example=13),
     *                          @OA\Property(property="description", type="string", example="description2"),
     *                          @OA\Property(property="volume", type="decimal", example=13.5),
     *                          @OA\Property(property="weight", type="number", example=14),
     *                    ),
     *              ),
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
     *              @OA\Property(property="message", type="string", example="Failed to Create Package."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(PackageRequest $request)
    {
        try {
            $package = $this->packageRepository->create($request->validated());
            return $this->responseJson('created', 'Create Package Successfully.', $package, 201);
        } catch (\Throwable $th) {
            Log::info($th);
            return $this->responseJson('error', 'Failed to Create Package.', $th, 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/packages/{id}",
     *      summary="Detail Package",
     *      description="Get Detail Package",
     *      tags={"Packages"},
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
     *              @OA\Property(property="payment_type_id", type="number", example=1),
     *              @OA\Property(property="state_id", type="number", example=1),
     *              @OA\Property(property="amount", type="string", example="10"),
     *              @OA\Property(property="discount", type="string", example="11"),
     *              @OA\Property(property="additional_field", type="string", example=null),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="order", type="number", example=11),
     *              @OA\Property(property="cash_amount", type="decimal", example=12.5),
     *              @OA\Property(property="cash_change", type="decimal", example=13.5),
     *              @OA\Property(property="origin_customer_id", type="number", example=1),
     *              @OA\Property(property="destination_customer_id", type="number", example=2),
     *              @OA\Property(
     *                    property="connote",
     *                    type="array",
     *                    @OA\Items(
     *                          type="object",
     *                          format="query",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="source_tariff_id", type="number", example=1),
     *                          @OA\Property(property="state_id", type="number", example=1),
     *                          @OA\Property(property="service", type="string", example="service1"),
     *                          @OA\Property(property="code", type="string", example="code1"),
     *                          @OA\Property(property="booking_code", type="string", example=null),
     *                          @OA\Property(property="actual_weight", type="decimal", example=10.5),
     *                          @OA\Property(property="volume_weight", type="decimal", example=11.5),
     *                          @OA\Property(property="chargeable_weight", type="decimal", example=12.5),
     *                          @OA\Property(property="total_package", type="number", example=13),
     *                          @OA\Property(property="surcharge_amount", type="number", example=14),
     *                          @OA\Property(property="sla_day", type="number", example=15),
     *                          @OA\Property(property="pod", type="string", example=null),
     *                    ),
     *              ),
     *              @OA\Property(
     *                    property="kolis[0]",
     *                    type="array",
     *                    @OA\Items(
     *                          type="object",
     *                          format="query",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="length", type="number", example=10),
     *                          @OA\Property(property="awb_url", type="string", example="http://localhost.com/awb.png"),
     *                          @OA\Property(property="chargeable_weight", type="decimal", example=11.5),
     *                          @OA\Property(property="width", type="numeric", example=12),
     *                          @OA\Property(property="height", type="numeric", example=13),
     *                          @OA\Property(property="description", type="string", example="description1"),
     *                          @OA\Property(property="volume", type="decimal", example=13.5),
     *                          @OA\Property(property="weight", type="number", example=14),
     *                    ),
     *              ),
     *              @OA\Property(
     *                    property="kolis[1]",
     *                    type="array",
     *                    @OA\Items(
     *                          type="object",
     *                          format="query",
     *                          @OA\Property(property="id", type="number", example=2),
     *                          @OA\Property(property="length", type="number", example=10),
     *                          @OA\Property(property="awb_url", type="string", example="http://localhost.com/awb.png"),
     *                          @OA\Property(property="chargeable_weight", type="decimal", example=11.5),
     *                          @OA\Property(property="width", type="numeric", example=12),
     *                          @OA\Property(property="height", type="numeric", example=13),
     *                          @OA\Property(property="description", type="string", example="description2"),
     *                          @OA\Property(property="volume", type="decimal", example=13.5),
     *                          @OA\Property(property="weight", type="number", example=14),
     *                    ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Package Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail Package."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(PackageRequest $request)
    {
        try {
            $package = $this->transaction->find($request->id);
            if (!$package) {
                return $this->responseJson('error', 'Package Not Found', '', 404);
            }
            $package = new PackageResource($package);
            return $this->responseJson('success', 'Get Detail Package Successfully.', $package);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail Package.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/packages/{id}",
     *      summary="Update Package",
     *      description="Update Data Package",
     *      tags={"Packages"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass package credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="code", type="string", example="update code1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="payment_type_id", type="number", example=1),
     *              @OA\Property(property="state_id", type="number", example=1),
     *              @OA\Property(property="amount", type="string", example="10"),
     *              @OA\Property(property="discount", type="string", example="11"),
     *              @OA\Property(property="additional_field", type="string", example=null),
     *              @OA\Property(property="code", type="string", example="update code1"),
     *              @OA\Property(property="order", type="number", example=11),
     *              @OA\Property(property="cash_amount", type="decimal", example=12.5),
     *              @OA\Property(property="cash_change", type="decimal", example=13.5),
     *              @OA\Property(property="origin_customer_id", type="number", example=1),
     *              @OA\Property(property="destination_customer_id", type="number", example=2),
     *              @OA\Property(
     *                    property="connote",
     *                    type="array",
     *                    @OA\Items(
     *                          type="object",
     *                          format="query",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="source_tariff_id", type="number", example=1),
     *                          @OA\Property(property="state_id", type="number", example=1),
     *                          @OA\Property(property="service", type="string", example="service1"),
     *                          @OA\Property(property="code", type="string", example="code1"),
     *                          @OA\Property(property="booking_code", type="string", example=null),
     *                          @OA\Property(property="actual_weight", type="decimal", example=10.5),
     *                          @OA\Property(property="volume_weight", type="decimal", example=11.5),
     *                          @OA\Property(property="chargeable_weight", type="decimal", example=12.5),
     *                          @OA\Property(property="total_package", type="number", example=13),
     *                          @OA\Property(property="surcharge_amount", type="number", example=14),
     *                          @OA\Property(property="sla_day", type="number", example=15),
     *                          @OA\Property(property="pod", type="string", example=null),
     *                    ),
     *              ),
     *              @OA\Property(
     *                    property="kolis[0]",
     *                    type="array",
     *                    @OA\Items(
     *                          type="object",
     *                          format="query",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="length", type="number", example=10),
     *                          @OA\Property(property="awb_url", type="string", example="http://localhost.com/awb.png"),
     *                          @OA\Property(property="chargeable_weight", type="decimal", example=11.5),
     *                          @OA\Property(property="width", type="numeric", example=12),
     *                          @OA\Property(property="height", type="numeric", example=13),
     *                          @OA\Property(property="description", type="string", example="description1"),
     *                          @OA\Property(property="volume", type="decimal", example=13.5),
     *                          @OA\Property(property="weight", type="number", example=14),
     *                    ),
     *              ),
     *              @OA\Property(
     *                    property="kolis[1]",
     *                    type="array",
     *                    @OA\Items(
     *                          type="object",
     *                          format="query",
     *                          @OA\Property(property="id", type="number", example=2),
     *                          @OA\Property(property="length", type="number", example=10),
     *                          @OA\Property(property="awb_url", type="string", example="http://localhost.com/awb.png"),
     *                          @OA\Property(property="chargeable_weight", type="decimal", example=11.5),
     *                          @OA\Property(property="width", type="numeric", example=12),
     *                          @OA\Property(property="height", type="numeric", example=13),
     *                          @OA\Property(property="description", type="string", example="description2"),
     *                          @OA\Property(property="volume", type="decimal", example=13.5),
     *                          @OA\Property(property="weight", type="number", example=14),
     *                    ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Package Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Update Data Package."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(PackageRequest $request)
    {
        try {
            $package = $this->transaction->find($request->id);
            if (!$package) {
                return $this->responseJson('error', 'Package Not Found', '', 404);
            }
            $package = $this->packageRepository->update($request->validated());
            return $this->responseJson('success', 'Update Package Successfully.', $package);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update Package.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/packages/{id}",
     *      summary="Delete Package",
     *      description="Delete Data Package",
     *      tags={"Packages"},
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
     *              @OA\Property(property="message", type="string", example="Package Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Delete Package."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(PackageRequest $request)
    {
        try {
            $package = $this->transaction->find($request->id);
            if (!$package) {
                return $this->responseJson('error', 'Package Not Found', '', 404);
            }
            $this->packageRepository->delete($package);
            return $this->responseJson('deleted', 'Delete Package Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete Package.', $th, $th->getCode() ?? 500);
        }
    }
}
