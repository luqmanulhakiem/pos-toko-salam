<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $data = Cart::with('produk')->get();
        
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $produk = Produk::find($request->produk_id);
            if (!$produk) {
                throw new \Exception("Produk tidak ditemukan");
            }

            if ($request->quantity > 0 && $produk->stock < $request->quantity) {
                throw new \Exception("Stok produk tidak mencukupi");
            }

            $data = Cart::where('produk_id', $request->produk_id)->first();
            
            if ($data) {
                $newQuantity = $data->quantity + $request->quantity;
                if ($newQuantity <= 0) {
                    $data->delete();
                    $data = null;
                } else {
                    $data->update([
                        'quantity' => $newQuantity
                    ]);
                }
            } else {
                if ($request->quantity > 0) {
                    $data = Cart::create([
                        'produk_id' => $request->produk_id,
                        'quantity' => $request->quantity
                    ]);
                } else {
                    throw new \Exception("Kuantitas tidak valid");
                }
            }

            $produk->update(['stock' => $produk->stock - $request->quantity]);

            DB::commit();
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function clearCart()
    {
        DB::beginTransaction();
        try {
            $data = Cart::all();
            foreach ($data as $item) {
                $produk = Produk::find($item->produk_id);
                $produk->update(['stock' => $produk->stock + $item->quantity]);
            }
            Cart::query()->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Keranjang berhasil dibersihkan'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}