<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'item_code',
        'item_name',
        'category_id',
        'supplier_id',
        'stock',
        'unit',
        'price',
        'description',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    /**
     * Relasi: barang milik satu kategori
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relasi: barang milik satu supplier
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Helper: apakah stok menipis (<=10)?
     */
    public function isLowStock(): bool
    {
        return $this->stock <= 10;
    }

    /**
     * Accessor: format harga ke Rupiah
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Accessor: URL gambar (dengan fallback ke placeholder)
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && \Storage::disk('public')->exists('uploads/' . $this->image)) {
            return asset('storage/uploads/' . $this->image);
        }
        return '';
    }
}
