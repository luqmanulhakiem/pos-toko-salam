<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokFlow extends Model
{
    protected $guarded = ['id'];

    public static function urusStok(int $produkId, int $quantity, string $type, ?string $description = null)
    {
        // Gunakan DB Transaction agar jika salah satu gagal, semua dibatalkan
        return DB::transaction(function () use ($produkId, $quantity, $type, $description) {

            $product = Produk::find($produkId);
            if (!$product) {
                throw new Exception("Produk tidak ditemukan.");
            }

            if ($type == "masuk") {
                $product->update(['stock' => $product->stock + $quantity]);
            } else {
                if ($product->stock < $quantity) {
                    throw new Exception("Stok tidak mencukupi untuk produk: {$product->name}.");
                }
                $product->update(['stock' => $product->stock - $quantity]);
            }

            // Catat ke tabel stok_flows
            return self::create([
                "user_id"     => Auth::user()->id ?? 1,
                "produk_id"   => $produkId,
                "cogs"        => $product->cogs,
                "price_sell"  => $product->price_sell,
                "quantity"    => $quantity,
                "type"        => $type,
                "description" => $description,
            ]);
        });
    }

    /**
     * Get the user who recorded this stock flow.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with this stock flow.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
