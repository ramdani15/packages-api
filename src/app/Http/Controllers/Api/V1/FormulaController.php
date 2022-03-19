<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Formula;
use App\Http\Requests\Api\V1\FormulaRequest;
use App\Http\Resources\Api\V1\FormulaResource;
use App\Repositories\Api\V1\FormulaRepository;

class FormulaController extends Controller
{
    use ApiResponse;

    public function __construct(
        Formula $formula,
        FormulaRepository $formulaRepository
    ) {
        $this->formula = $formula;
        $this->formulaRepository = $formulaRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/formulas",
     *      summary="List Formulas",
     *      description="Get List Formulas",
     *      tags={"Formulas"},
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Formulas."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $formulas = $this->formulaRepository->searchFormulas($request);
            return $this->responseJson('pagination', 'Get Formulas Successfully.', $formulas, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Formulas.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/formulas",
     *      summary="Create Formula",
     *      description="Create Formula",
     *      tags={"Formulas"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass formula credentials",
     *          @OA\JsonContent(
     *              required={"name", "description"},
     *              @OA\Property(property="name", type="string", example="formula1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="formula1"),
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
     *              @OA\Property(property="message", type="string", example="Failed to Create Formula."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(FormulaRequest $request)
    {
        try {
            $formula = $this->formula->create($request->validated());
            return $this->responseJson('created', 'Create Formula Successfully.', $formula, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create Formula.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/formulas/{id}",
     *      summary="Detail Formula",
     *      description="Get Detail Formula",
     *      tags={"Formulas"},
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
     *              @OA\Property(property="name", type="string", example="formula1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Formula Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail Formula."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(FormulaRequest $request)
    {
        try {
            $formula = $this->formula->find($request->id);
            if (!$formula) {
                return $this->responseJson('error', 'Formula Not Found', '', 404);
            }
            $formula = new FormulaResource($formula);
            return $this->responseJson('success', 'Get Detail Formula Successfully.', $formula);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail Formula.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/formulas/{id}",
     *      summary="Update Formula",
     *      description="Update Data Formula",
     *      tags={"Formulas"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass formula credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="update formula1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="update formula1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Formula Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Update Data Formula."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(FormulaRequest $request)
    {
        try {
            $formula = $this->formula->find($request->id);
            if (!$formula) {
                return $this->responseJson('error', 'Formula Not Found', '', 404);
            }
            $formula->update($request->validated());
            $formula = new FormulaResource($this->formula->find($formula->id));
            return $this->responseJson('success', 'Update Formula Successfully.', $formula);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update Formula.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/formulas/{id}",
     *      summary="Delete Formula",
     *      description="Delete Data Formula",
     *      tags={"Formulas"},
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
     *              @OA\Property(property="message", type="string", example="Formula Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Delete Formula."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(FormulaRequest $request)
    {
        try {
            $formula = $this->formula->find($request->id);
            if (!$formula) {
                return $this->responseJson('error', 'Formula Not Found', '', 404);
            }
            $formula->delete();
            return $this->responseJson('deleted', 'Delete Formula Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete Formula.', $th, $th->getCode() ?? 500);
        }
    }
}
