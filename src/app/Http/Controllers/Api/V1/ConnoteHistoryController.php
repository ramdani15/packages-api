<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ConnoteHistory;
use App\Http\Requests\Api\V1\ConnoteHistoryRequest;
use App\Http\Resources\Api\V1\ConnoteHistoryResource;
use App\Repositories\Api\V1\ConnoteHistoryRepository;

class ConnoteHistoryController extends Controller
{
    use ApiResponse;

    public function __construct(
        ConnoteHistory $connoteHistory,
        ConnoteHistoryRepository $connoteHistoryRepository
    ) {
        $this->connoteHistory = $connoteHistory;
        $this->connoteHistoryRepository = $connoteHistoryRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/connote-histories",
     *      summary="List ConnoteHistories",
     *      description="Get List ConnoteHistories",
     *      tags={"ConnoteHistories"},
     *      @OA\Parameter(
     *          name="connote_id",
     *          in="query",
     *          description="Connote ID"
     *      ),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get ConnoteHistories."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $connoteHistorys = $this->connoteHistoryRepository->searchConnoteHistories($request);
            return $this->responseJson('pagination', 'Get ConnoteHistories Successfully.', $connoteHistorys, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get ConnoteHistories.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/connote-histories",
     *      summary="Create ConnoteHistory",
     *      description="Create ConnoteHistory",
     *      tags={"ConnoteHistories"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass connoteHistory credentials",
     *          @OA\JsonContent(
     *              required={"connote_id", "name", "description"},
     *              @OA\Property(property="connote_id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="connoteHistory1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="connote_id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="connoteHistory1"),
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
     *              @OA\Property(property="message", type="string", example="Failed to Create ConnoteHistory."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(ConnoteHistoryRequest $request)
    {
        try {
            $connoteHistory = $this->connoteHistory->create($request->validated());
            return $this->responseJson('created', 'Create ConnoteHistory Successfully.', $connoteHistory, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create ConnoteHistory.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/connote-histories/{id}",
     *      summary="Detail ConnoteHistory",
     *      description="Get Detail ConnoteHistory",
     *      tags={"ConnoteHistories"},
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
     *              @OA\Property(property="name", type="string", example="connoteHistory1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="ConnoteHistory Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail ConnoteHistory."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(ConnoteHistoryRequest $request)
    {
        try {
            $connoteHistory = $this->connoteHistory->find($request->id);
            if (!$connoteHistory) {
                return $this->responseJson('error', 'ConnoteHistory Not Found', '', 404);
            }
            $connoteHistory = new ConnoteHistoryResource($connoteHistory);
            return $this->responseJson('success', 'Get Detail ConnoteHistory Successfully.', $connoteHistory);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail ConnoteHistory.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/connote-histories/{id}",
     *      summary="Update ConnoteHistory",
     *      description="Update Data ConnoteHistory",
     *      tags={"ConnoteHistories"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass connoteHistory credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="update connoteHistory1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="connote_id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="update connoteHistory1"),
     *              @OA\Property(property="description", type="string", example="description"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="ConnoteHistory Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Update Data ConnoteHistory."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(ConnoteHistoryRequest $request)
    {
        try {
            $connoteHistory = $this->connoteHistory->find($request->id);
            if (!$connoteHistory) {
                return $this->responseJson('error', 'ConnoteHistory Not Found', '', 404);
            }
            $connoteHistory->update($request->validated());
            $connoteHistory = new ConnoteHistoryResource($this->connoteHistory->find($connoteHistory->id));
            return $this->responseJson('success', 'Update ConnoteHistory Successfully.', $connoteHistory);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update ConnoteHistory.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/connote-histories/{id}",
     *      summary="Delete ConnoteHistory",
     *      description="Delete Data ConnoteHistory",
     *      tags={"ConnoteHistories"},
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
     *              @OA\Property(property="message", type="string", example="ConnoteHistory Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Delete ConnoteHistory."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(ConnoteHistoryRequest $request)
    {
        try {
            $connoteHistory = $this->connoteHistory->find($request->id);
            if (!$connoteHistory) {
                return $this->responseJson('error', 'ConnoteHistory Not Found', '', 404);
            }
            $connoteHistory->delete();
            return $this->responseJson('deleted', 'Delete ConnoteHistory Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete ConnoteHistory.', $th, $th->getCode() ?? 500);
        }
    }
}
