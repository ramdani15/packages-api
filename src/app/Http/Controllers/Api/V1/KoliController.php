<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Koli;
use App\Http\Requests\Api\V1\KoliRequest;
use App\Http\Resources\Api\V1\KoliResource;
use App\Repositories\Api\V1\KoliRepository;

class KoliController extends Controller
{
    use ApiResponse;

    public function __construct(
        Koli $koli,
        KoliRepository $koliRepository
    ) {
        $this->koli = $koli;
        $this->koliRepository = $koliRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/kolis",
     *      summary="List Kolis",
     *      description="Get List Kolis",
     *      tags={"Kolis"},
     *      @OA\Parameter(
     *          name="connote_id",
     *          in="query",
     *          description="Connote ID"
     *      ),
     *      @OA\Parameter(
     *          name="formula_id",
     *          in="query",
     *          description="Formula ID"
     *      ),
     *      @OA\Parameter(
     *          name="code",
     *          in="query",
     *          description="Code"
     *      ),
     *      @OA\Parameter(
     *          name="length",
     *          in="query",
     *          description="Length"
     *      ),
     *      @OA\Parameter(
     *          name="awb_url",
     *          in="query",
     *          description="Awb Url"
     *      ),
     *      @OA\Parameter(
     *          name="chargeable_weight",
     *          in="query",
     *          description="Chargeable Weight"
     *      ),
     *      @OA\Parameter(
     *          name="width",
     *          in="query",
     *          description="Width"
     *      ),
     *      @OA\Parameter(
     *          name="height",
     *          in="query",
     *          description="Height"
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          in="query",
     *          description="Description"
     *      ),
     *      @OA\Parameter(
     *          name="volume",
     *          in="query",
     *          description="Volume"
     *      ),
     *      @OA\Parameter(
     *          name="weight",
     *          in="query",
     *          description="Weight"
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Kolis."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $kolis = $this->koliRepository->searchKolis($request);
            return $this->responseJson('pagination', 'Get Kolis Successfully.', $kolis, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Kolis.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/kolis",
     *      summary="Create Koli",
     *      description="Create Koli",
     *      tags={"Kolis"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass koli credentials",
     *          @OA\JsonContent(
     *              required={"connote_id", "code", "length", "awb_url", "chargeable_weight", "width", "height", "description", "volume", "weight"},
     *              @OA\Property(property="connote_id", type="number", example=1),
     *              @OA\Property(property="formula_id", type="number", example=null),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="length", type="number", example=10),
     *              @OA\Property(property="awb_url", type="string", example="http://localhost.com/awb.png"),
     *              @OA\Property(property="chargeable_weight", type="decimal", example=11.5),
     *              @OA\Property(property="width", type="numeric", example=12),
     *              @OA\Property(property="height", type="numeric", example=13),
     *              @OA\Property(property="description", type="string", example="description1"),
     *              @OA\Property(property="volume", type="decimal", example=13.5),
     *              @OA\Property(property="weight", type="number", example=14),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="connote_id", type="number", example=1),
     *              @OA\Property(property="formula_id", type="number", example=null),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="length", type="number", example=10),
     *              @OA\Property(property="awb_url", type="string", example="http://localhost.com/awb.png"),
     *              @OA\Property(property="chargeable_weight", type="decimal", example=11.5),
     *              @OA\Property(property="width", type="numeric", example=12),
     *              @OA\Property(property="height", type="numeric", example=13),
     *              @OA\Property(property="description", type="string", example="description1"),
     *              @OA\Property(property="volume", type="decimal", example=13.5),
     *              @OA\Property(property="weight", type="number", example=14),
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
     *              @OA\Property(property="message", type="string", example="Failed to Create Koli."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(KoliRequest $request)
    {
        try {
            $koli = $this->koli->create($request->validated());
            return $this->responseJson('created', 'Create Koli Successfully.', $koli, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create Koli.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/kolis/{id}",
     *      summary="Detail Koli",
     *      description="Get Detail Koli",
     *      tags={"Kolis"},
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
     *              @OA\Property(property="connote_id", type="number", example=1),
     *              @OA\Property(property="formula_id", type="number", example=null),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="length", type="number", example=10),
     *              @OA\Property(property="awb_url", type="string", example="http://localhost.com/awb.png"),
     *              @OA\Property(property="chargeable_weight", type="decimal", example=11.5),
     *              @OA\Property(property="width", type="numeric", example=12),
     *              @OA\Property(property="height", type="numeric", example=13),
     *              @OA\Property(property="description", type="string", example="description1"),
     *              @OA\Property(property="volume", type="decimal", example=13.5),
     *              @OA\Property(property="weight", type="number", example=14),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Koli Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail Koli."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(KoliRequest $request)
    {
        try {
            $koli = $this->koli->find($request->id);
            if (!$koli) {
                return $this->responseJson('error', 'Koli Not Found', '', 404);
            }
            $koli = new KoliResource($koli);
            return $this->responseJson('success', 'Get Detail Koli Successfully.', $koli);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail Koli.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/kolis/{id}",
     *      summary="Update Koli",
     *      description="Update Data Koli",
     *      tags={"Kolis"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass koli credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="code", type="string", example="update code1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="connote_id", type="number", example=1),
     *              @OA\Property(property="formula_id", type="number", example=null),
     *              @OA\Property(property="code", type="string", example="update code1"),
     *              @OA\Property(property="length", type="number", example=10),
     *              @OA\Property(property="awb_url", type="string", example="http://localhost.com/awb.png"),
     *              @OA\Property(property="chargeable_weight", type="decimal", example=11.5),
     *              @OA\Property(property="width", type="numeric", example=12),
     *              @OA\Property(property="height", type="numeric", example=13),
     *              @OA\Property(property="description", type="string", example="description1"),
     *              @OA\Property(property="volume", type="decimal", example=13.5),
     *              @OA\Property(property="weight", type="number", example=14),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Koli Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Update Data Koli."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(KoliRequest $request)
    {
        try {
            $koli = $this->koli->find($request->id);
            if (!$koli) {
                return $this->responseJson('error', 'Koli Not Found', '', 404);
            }
            $koli->update($request->validated());
            $koli = new KoliResource($this->koli->find($koli->id));
            return $this->responseJson('success', 'Update Koli Successfully.', $koli);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update Koli.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/kolis/{id}",
     *      summary="Delete Koli",
     *      description="Delete Data Koli",
     *      tags={"Kolis"},
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
     *              @OA\Property(property="message", type="string", example="Koli Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Delete Koli."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(KoliRequest $request)
    {
        try {
            $koli = $this->koli->find($request->id);
            if (!$koli) {
                return $this->responseJson('error', 'Koli Not Found', '', 404);
            }
            $koli->delete();
            return $this->responseJson('deleted', 'Delete Koli Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete Koli.', $th, $th->getCode() ?? 500);
        }
    }
}
