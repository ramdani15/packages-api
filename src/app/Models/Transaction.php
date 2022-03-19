<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_type_id',
        'state_id',
        'amount',
        'discount',
        'additional_field',
        'code',
        'order',
        'cash_amount',
        'cash_change',
        'custome_fields',
    ];
    protected $dateFormat = 'U';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the PaymentType
     */
    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class);
    }

    /**
     * Get the State
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    
    /**
     * Relation to Connote
     */
    public function connote()
    {
        return $this->hasOne(Connote::class);
    }

    /**
     * Relation to Origin
     */
    public function origin()
    {
        return $this->hasOne(Origin::class);
    }

    /**
     * Relation to Destination
     */
    public function destination()
    {
        return $this->hasOne(Destination::class);
    }
}
