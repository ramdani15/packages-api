<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Http\Requests\Api\V1\TransactionRequest;
use App\Http\Resources\Api\V1\TransactionResource;
use App\Repositories\Api\V1\TransactionRepository;

class TransactionController extends Controller
{
    use ApiResponse;

    public function __construct(
        Transaction $transaction,
        TransactionRepository $transactionRepository
    ) {
        $this->transaction = $transaction;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/transactions",
     *      summary="List Transactions",
     *      description="Get List Transactions",
     *      tags={"Transactions"},
     *      @OA\Parameter(
     *          name="payment_type_id",
     *          in="query",
     *          description="Payment Type ID"
     *      ),
     *      @OA\Parameter(
     *          name="state_id",
     *          in="query",
     *          description="State ID"
     *      ),
     *      @OA\Parameter(
     *          name="amount",
     *          in="query",
     *          description="Amount"
     *      ),
     *      @OA\Parameter(
     *          name="discount",
     *          in="query",
     *          description="Discount"
     *      ),
     *      @OA\Parameter(
     *          name="additional_field",
     *          in="query",
     *          description="Additional Field"
     *      ),
     *      @OA\Parameter(
     *          name="code",
     *          in="query",
     *          description="Code"
     *      ),
     *      @OA\Parameter(
     *          name="order",
     *          in="query",
     *          description="Order"
     *      ),
     *      @OA\Parameter(
     *          name="cash_amount",
     *          in="query",
     *          description="Cash Amount"
     *      ),
     *      @OA\Parameter(
     *          name="cash_change",
     *          in="query",
     *          description="Cash Change"
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Transactions."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $transactions = $this->transactionRepository->searchTransactions($request);
            return $this->responseJson('pagination', 'Get Transactions Successfully.', $transactions, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Transactions.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/transactions",
     *      summary="Create Transaction",
     *      description="Create Transaction",
     *      tags={"Transactions"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass transaction credentials",
     *          @OA\JsonContent(
     *              required={"payment_type_id", "state_id", "amount", "discount", "code", "order", "cash_amount", "cash_change"},
     *              @OA\Property(property="payment_type_id", type="number", example=1),
     *              @OA\Property(property="state_id", type="number", example=1),
     *              @OA\Property(property="amount", type="string", example="10"),
     *              @OA\Property(property="discount", type="string", example="11"),
     *              @OA\Property(property="additional_field", type="string", example=null),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="order", type="number", example=11),
     *              @OA\Property(property="cash_amount", type="decimal", example=12.5),
     *              @OA\Property(property="cash_change", type="decimal", example=13.5),
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
     *              @OA\Property(property="message", type="string", example="Failed to Create Transaction."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(TransactionRequest $request)
    {
        try {
            $transaction = $this->transaction->create($request->validated());
            return $this->responseJson('created', 'Create Transaction Successfully.', $transaction, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create Transaction.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/transactions/{id}",
     *      summary="Detail Transaction",
     *      description="Get Detail Transaction",
     *      tags={"Transactions"},
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
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Transaction Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail Transaction."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(TransactionRequest $request)
    {
        try {
            $transaction = $this->transaction->find($request->id);
            if (!$transaction) {
                return $this->responseJson('error', 'Transaction Not Found', '', 404);
            }
            $transaction = new TransactionResource($transaction);
            return $this->responseJson('success', 'Get Detail Transaction Successfully.', $transaction);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail Transaction.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/transactions/{id}",
     *      summary="Update Transaction",
     *      description="Update Data Transaction",
     *      tags={"Transactions"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass transaction credentials",
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
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Transaction Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Update Data Transaction."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(TransactionRequest $request)
    {
        try {
            $transaction = $this->transaction->find($request->id);
            if (!$transaction) {
                return $this->responseJson('error', 'Transaction Not Found', '', 404);
            }
            $transaction->update($request->validated());
            $transaction = new TransactionResource($this->transaction->find($transaction->id));
            return $this->responseJson('success', 'Update Transaction Successfully.', $transaction);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update Transaction.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/transactions/{id}",
     *      summary="Delete Transaction",
     *      description="Delete Data Transaction",
     *      tags={"Transactions"},
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
     *              @OA\Property(property="message", type="string", example="Transaction Not Found."),
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
     *              @OA\Property(property="message", type="string", example="Failed to Delete Transaction."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(TransactionRequest $request)
    {
        try {
            $transaction = $this->transaction->find($request->id);
            if (!$transaction) {
                return $this->responseJson('error', 'Transaction Not Found', '', 404);
            }
            $transaction->delete();
            return $this->responseJson('deleted', 'Delete Transaction Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete Transaction.', $th, $th->getCode() ?? 500);
        }
    }
}
