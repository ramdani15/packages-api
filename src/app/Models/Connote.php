<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Connote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'source_tariff_id',
        'state_id',
        'order',
        'number',
        'service',
        'code',
        'booking_code',
        'actual_weight',
        'volume_weight',
        'chargeable_weight',
        'total_package',
        'surcharge_amount',
        'sla_day',
        'pod',
    ];
    protected $dateFormat = 'U';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the Transaction
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the SourceTariff
     */
    public function source_tariff()
    {
        return $this->belongsTo(SourceTariff::class);
    }

    /**
     * Get the State
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Relation to History
     */
    public function histories()
    {
        return $this->hasMany(ConnoteHistory::class);
    }

    /**
     * Relation to Koli
     */
    public function kolis()
    {
        return $this->hasMany(Koli::class);
    }
}
