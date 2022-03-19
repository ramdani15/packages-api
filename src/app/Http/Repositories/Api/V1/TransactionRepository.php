<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\Transaction;
use App\Http\Resources\Api\V1\TransactionResource;

class TransactionRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Search and Filter Transactions
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\TransactionResource
     */
    public function searchTransactions($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->transaction;
        $filters = [
            [
                'field' => 'payment_type_id',
                'value' => $request->payment_type_id,
            ],
            [
                'field' => 'state_id',
                'value' => $request->state_id,
            ],
            [
                'field' => 'amount',
                'value' => $request->amount,
            ],
            [
                'field' => 'discount',
                'value' => $request->discount,
            ],
            [
                'field' => 'additional_field',
                'value' => $request->additional_field,
            ],
            [
                'field' => 'code',
                'value' => $request->code,
            ],
            [
                'field' => 'order',
                'value' => $request->order,
            ],
            [
                'field' => 'cash_amount',
                'value' => $request->cash_amount,
            ],
            [
                'field' => 'cash_change',
                'value' => $request->cash_change,
            ],
        ];
        $data = $this->filterFields($data, $filters);
        $data = $this->setOrder($data, [$request->sort_by, $request->sort]);
        $data = $data->paginate($limit);
        return TransactionResource::collection($data);
    }
}
