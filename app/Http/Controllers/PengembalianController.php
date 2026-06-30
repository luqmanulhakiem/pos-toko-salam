<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Produk;
use App\Models\StokFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PengembalianController extends Controller
{
    public function index()
    {
        return view('src.pages.pengembalian.index');
    }

    public function searchNota($no_nota)
    {
        // Cari nota beserta relasi produknya
        $notas = Nota::with('produk')->where('no_nota', $no_nota)->get();

        if ($notas->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Nota tidak ditemukan.'
            ], 404);
        }

        $data = $notas->map(function ($nota) {
            return [
                'id' => $nota->id,
                'no_nota' => $nota->no_nota,
                'produk_id' => $nota->produk_id,
                'produk_name' => $nota->produk ? $nota->produk->name : 'Produk Tidak Ditemukan',
                'produk_code' => $nota->produk ? $nota->produk->product_code : '-',
                'price_sell' => $nota->produk ? $nota->produk->price_sell : 0,
                'max_quantity' => $nota->quantity,
                'return_quantity' => 0 // Inisialisasi awal 0
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function listPenjualan()
    {
        // Ambil 100 penjualan terakhir
        $penjualans = \App\Models\Penjualan::with('user')->orderBy('created_at', 'desc')->limit(100)->get();
        return response()->json([
            'status' => true,
            'data' => $penjualans
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_nota' => 'required|string',
            'items' => 'required|array',
            'items.*.produk_id' => 'required|integer',
            'items.*.return_quantity' => 'required|integer|min:0',
        ]);

        $no_nota = $request->no_nota;
        $itemsToReturn = array_filter($request->items, function ($item) {
            return $item['return_quantity'] > 0;
        });

        if (empty($itemsToReturn)) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada barang yang diretur.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            foreach ($itemsToReturn as $item) {
                $produk_id = $item['produk_id'];
                $return_quantity = $item['return_quantity'];

                // Validasi bahwa return quantity tidak melebihi yang ada di nota
                $nota = Nota::where('no_nota', $no_nota)
                            ->where('produk_id', $produk_id)
                            ->first();

                if (!$nota) {
                    throw new Exception("Produk ID {$produk_id} tidak ada di nota ini.");
                }

                if ($return_quantity > $nota->quantity) {
                    throw new Exception("Jumlah retur melebihi jumlah pembelian untuk produk ID {$produk_id}.");
                }

                // Tambahkan stok produk dan rekam di StokFlow
                StokFlow::urusStok(
                    $produk_id, 
                    $return_quantity, 
                    'masuk', 
                    "Pengembalian barang dari Nota: {$no_nota}"
                );

                // Rekam di history pengembalian
                \App\Models\Pengembalian::create([
                    'no_nota' => $no_nota,
                    'produk_id' => $produk_id,
                    'quantity' => $return_quantity,
                    'user_id' => \Illuminate\Support\Facades\Auth::id(),
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Pengembalian barang berhasil diproses.'
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function history()
    {
        $pengembalians = \App\Models\Pengembalian::with(['produk', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('src.pages.laporan.pengembalian.index', compact('pengembalians'));
    }
}
