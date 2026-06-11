<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->product_code = IdGenerator::generate([
                'table' => $model->getTable(),
                'field' => 'product_code',
                'length' => 9,
                'prefix' => 'PBC-'
            ]);
        });
    }

    public function stokFlows(): HasMany
    {
        return $this->hasMany(StokFlow::class);
    }

    /**
     * Get the product associated with this stock flow.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
}
