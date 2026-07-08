<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'supplier_name',
        'phone',
        'email',
        'address',
    ];

    const UPDATED_AT = null;

    /**
     * Relasi: satu supplier punya banyak barang
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'supplier_id');
    }
}
