<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Koli extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'connote_id',
        'formula_id',
        'code',
        'length',
        'awb_url',
        'chargeable_weight',
        'width',
        'surcharge',
        'height',
        'description',
        'volume',
        'weight',
        'custome_fields',
    ];
    protected $dateFormat = 'U';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the Connote
     */
    public function connote()
    {
        return $this->belongsTo(Connote::class);
    }

    /**
     * Get the Formula
     */
    public function formula()
    {
        return $this->belongsTo(Formula::class);
    }
}
