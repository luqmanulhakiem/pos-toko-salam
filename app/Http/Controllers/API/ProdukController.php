<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(){
        $produk = Produk::with('kategori')->get();
        return response()->json([
            'status' => true,
            'data' => $produk
        ]);
    }
}
