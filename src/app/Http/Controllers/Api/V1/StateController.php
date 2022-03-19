<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Http\Requests\Api\V1\StateRequest;
use App\Http\Resources\Api\V1\StateResource;
use App\Repositories\Api\V1\StateRepository;

class StateController extends Controller
{
    use ApiResponse;

    public function __construct(
        State $state,
        StateRepository $stateRepository
    ) {
        $this->state = $state;
        $this->stateRepository = $stateRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/states",
     *      summary="List States",
     *      description="Get List States",
     *      tags={"States"},
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
     *              @OA\Property(property="message", type="string", example="Failed to Get States."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $states = $this->stateRepository->searchStates($request);
            return $this->responseJson('pagination', 'Get States Successfully.', $states, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get States.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/states",
     *      summary="Create State",
     *      description="Create State",
     *      tags={"States"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass state credentials",
     *          @OA\JsonContent(
     *              required={"name", "description"},
     *              @OA\Property(property="name", type="string", example="state1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="state1"),
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
     *              @OA\Property(property="message", type="string", example="Failed to Create State."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(StateRequest $request)
    {
        try {
            $state = $this->state->create($request->validated());
            return $this->responseJson('created', 'Create State Successfully.', $state, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create State.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/states/{id}",
     *      summary="Detail State",
     *      description="Get Detail State",
     *      tags={"States"},
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
     *              @OA\Property(property="name", type="string", example="state1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="State Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail State."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(StateRequest $request)
    {
        try {
            $state = $this->state->find($request->id);
            if (!$state) {
                return $this->responseJson('error', 'State Not Found', '', 404);
            }
            $state = new StateResource($state);
            return $this->responseJson('success', 'Get Detail State Successfully.', $state);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail State.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/states/{id}",
     *      summary="Update State",
     *      description="Update Data State",
     *      tags={"States"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass state credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="update state1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="update state1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="State Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Update Data State."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(StateRequest $request)
    {
        try {
            $state = $this->state->find($request->id);
            if (!$state) {
                return $this->responseJson('error', 'State Not Found', '', 404);
            }
            $state->update($request->validated());
            $state = new StateResource($this->state->find($state->id));
            return $this->responseJson('success', 'Update State Successfully.', $state);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update State.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/states/{id}",
     *      summary="Delete State",
     *      description="Delete Data State",
     *      tags={"States"},
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
     *              @OA\Property(property="message", type="string", example="State Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Delete State."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(StateRequest $request)
    {
        try {
            $state = $this->state->find($request->id);
            if (!$state) {
                return $this->responseJson('error', 'State Not Found', '', 404);
            }
            $state->delete();
            return $this->responseJson('deleted', 'Delete State Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete State.', $th, $th->getCode() ?? 500);
        }
    }
}
