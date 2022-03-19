<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'location_id',
        'organization_id',
        'name',
        'code',
        'address',
        'address_detail',
        'email',
        'phone',
        'nama_sales',
        'top',
        'jenis_pelanggan',
    ];
    protected $dateFormat = 'U';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the Location
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the Organization
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
