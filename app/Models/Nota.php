<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Nota extends Model
{
    protected $guarded = ['id'];

    public function produk(): HasOne
    {
        return $this->hasOne(Produk::class);
    }
}
