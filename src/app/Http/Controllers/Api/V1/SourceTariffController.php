<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SourceTariff;
use App\Http\Requests\Api\V1\SourceTariffRequest;
use App\Http\Resources\Api\V1\SourceTariffResource;
use App\Repositories\Api\V1\SourceTariffRepository;

class SourceTariffController extends Controller
{
    use ApiResponse;

    public function __construct(
        SourceTariff $sourceTariff,
        SourceTariffRepository $sourceTariffRepository
    ) {
        $this->sourceTariff = $sourceTariff;
        $this->sourceTariffRepository = $sourceTariffRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/source-tariffs",
     *      summary="List SourceTariffs",
     *      description="Get List SourceTariffs",
     *      tags={"SourceTariffs"},
     *      @OA\Parameter(
     *          name="db",
     *          in="query",
     *          description="DB"
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
     *              @OA\Property(property="message", type="string", example="Failed to Get SourceTariffs."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $sourceTariffs = $this->sourceTariffRepository->searchSourceTariffs($request);
            return $this->responseJson('pagination', 'Get SourceTariffs Successfully.', $sourceTariffs, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get SourceTariffs.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/source-tariffs",
     *      summary="Create SourceTariff",
     *      description="Create SourceTariff",
     *      tags={"SourceTariffs"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass sourceTariff credentials",
     *          @OA\JsonContent(
     *              required={"db"},
     *              @OA\Property(property="db", type="string", example="db1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="db", type="string", example="db1"),
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
     *              @OA\Property(property="message", type="string", example="Failed to Create SourceTariff."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(SourceTariffRequest $request)
    {
        try {
            $sourceTariff = $this->sourceTariff->create($request->validated());
            return $this->responseJson('created', 'Create SourceTariff Successfully.', $sourceTariff, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create SourceTariff.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/source-tariffs/{id}",
     *      summary="Detail SourceTariff",
     *      description="Get Detail SourceTariff",
     *      tags={"SourceTariffs"},
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
     *              @OA\Property(property="db", type="string", example="db1"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="SourceTariff Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail SourceTariff."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(SourceTariffRequest $request)
    {
        try {
            $sourceTariff = $this->sourceTariff->find($request->id);
            if (!$sourceTariff) {
                return $this->responseJson('error', 'SourceTariff Not Found', '', 404);
            }
            $sourceTariff = new SourceTariffResource($sourceTariff);
            return $this->responseJson('success', 'Get Detail SourceTariff Successfully.', $sourceTariff);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail SourceTariff.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/source-tariffs/{id}",
     *      summary="Update SourceTariff",
     *      description="Update Data SourceTariff",
     *      tags={"SourceTariffs"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass sourceTariff credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="db", type="string", example="update db1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="update db1"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="SourceTariff Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Update Data SourceTariff."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(SourceTariffRequest $request)
    {
        try {
            $sourceTariff = $this->sourceTariff->find($request->id);
            if (!$sourceTariff) {
                return $this->responseJson('error', 'SourceTariff Not Found', '', 404);
            }
            $sourceTariff->update($request->validated());
            $sourceTariff = new SourceTariffResource($this->sourceTariff->find($sourceTariff->id));
            return $this->responseJson('success', 'Update SourceTariff Successfully.', $sourceTariff);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update SourceTariff.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/source-tariffs/{id}",
     *      summary="Delete SourceTariff",
     *      description="Delete Data SourceTariff",
     *      tags={"SourceTariffs"},
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
     *              @OA\Property(property="message", type="string", example="SourceTariff Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Delete SourceTariff."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(SourceTariffRequest $request)
    {
        try {
            $sourceTariff = $this->sourceTariff->find($request->id);
            if (!$sourceTariff) {
                return $this->responseJson('error', 'SourceTariff Not Found', '', 404);
            }
            $sourceTariff->delete();
            return $this->responseJson('deleted', 'Delete SourceTariff Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete SourceTariff.', $th, $th->getCode() ?? 500);
        }
    }
}
