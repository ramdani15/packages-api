<?php

namespace App\Repositories\Api\V1;

use App\Traits\ApiFilterTrait;
use App\Repositories\ModelRepository;
use App\Models\Transaction;
use App\Models\Origin;
use App\Models\Destination;
use App\Models\Connote;
use App\Models\Koli;
use App\Http\Resources\Api\V1\PackageResource;

class PackageRepository extends ModelRepository
{
    use ApiFilterTrait;

    public function __construct(
        Transaction $transaction,
        Origin $origin,
        Destination $destination,
        Connote $connote,
        Koli $koli
    ) {
        $this->transaction = $transaction;
        $this->origin = $origin;
        $this->destination = $destination;
        $this->connote = $connote;
        $this->koli = $koli;
    }

    /**
     * Search and Filter Packages
     * @param Illuminate\Http\Request $request
     * @return App\Http\Resources\Api\V1\PackageResource
     */
    public function searchPackages($request)
    {
        $limit = $request->limit ?? 10;
        $data = $this->transaction->whereHas('connote')->whereHas('connote.kolis');
        $filters = [];
        $data = $this->filterFields($data, $filters);
        $data = $this->setOrder($data, [$request->sort_by, $request->sort]);
        $data = $this->setOrder($data, [$request->created_at, -1]);
        $data = $data->paginate($limit);
        return PackageResource::collection($data);
    }

    /**
     * Create Package
     * @param array $data
     * @return App\Http\Resources\Api\V1\PackageResource
     */
    public function create($data)
    {
        $transactionData = $data;
        $connoteData = $data['connote'];
        $kolisData = $data['kolis'];

        $transaction = $this->transaction->create($transactionData);
        $originData = [
            'transaction_id' => $transaction->id,
            'customer_id' => $data['origin_customer_id']
        ];
        $this->origin->update($originData);
        $destinationData = [
            'transaction_id' => $transaction->id,
            'customer_id' => $data['destination_customer_id']
        ];
        $this->destination->update($destinationData);
        $connoteData['transaction_id'] = $transaction->id;
        $connoteData['order'] = $transaction->order;
        $connoteData['number'] = $this->connote->whereTransactionId($transaction->id)->count() + 1;
        $connoteData['code'] = 'AWB'.(sprintf('%03d', $connoteData['number'])).date('d').date('M').date('Y');
        $connote = $this->connote->create($connoteData);

        $number = 1;
        foreach ($kolisData as $key => $value) {
            $kolisData[$key]['connote_id'] = $connote->id;
            $kolisData[$key]['code'] = $connote->code.'.'.($number++);
            $kolisData[$key]['created_at'] = time();
            $kolisData[$key]['updated_at'] = time();
        }
        $this->koli->insert($kolisData);
        return new PackageResource($transaction);
    }

    /**
     * Update Package
     * @param array $data
     * @return App\Http\Resources\Api\V1\PackageResource
     */
    public function update($data)
    {
        $transactionData = $data;
        $connoteData = $data['connote'];
        $kolisData = $data['kolis'];

        $transaction = $this->transaction->create($transactionData);
        $connoteData['transaction_id'] = $transaction->id;
        $connoteData['order'] = $transaction->order;
        $connote = $transaction->connote;
        $connote->update($connoteData);

        foreach ($kolisData as $key => $value) {
            $koli = $this->koli->find($kolisData[$key]['id']);
            $koli ? $koli->update($kolisData[$key]) : null;
        }
        return new PackageResource($transaction);
    }

    /**
     * Delete Package
     * @param \App\Models\Transaction
     * @return void
     */
    public function delete($transaction)
    {
        $transaction->connote->kolis()->delete();
        $transaction->connote()->delete();
        $transaction->origin()->delete();
        $transaction->destination()->delete();
        $transaction->delete();
    }
}
