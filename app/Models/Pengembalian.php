<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $fillable = [
        'no_nota',
        'produk_id',
        'quantity',
        'user_id',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
