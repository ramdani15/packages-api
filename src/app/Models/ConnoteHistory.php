<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConnoteHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'connote_id',
        'name',
        'description',
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
}
