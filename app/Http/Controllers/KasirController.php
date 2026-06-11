<?php

namespace App\Http\Controllers;

use App\Http\Requests\KasirStoreRequest;
use App\Models\Cart;
use App\Models\Nota;
use App\Models\Penjualan;
use App\Models\StokFlow;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noNota = IdGenerator::generate([
            'table' => 'notas',
            'field' => 'no_nota',
            'length' => 17,
            'prefix' => 'INV-'.date('ymdHis'),
        ]);

        return view('src.pages.kasir.index', compact('noNota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KasirStoreRequest $request)
    {
        $data = $request->validated();
        $cart = Cart::get();
        if ($cart->isEmpty()) {
            toastr()->error('Keranjang Belum Ada Barang');

            return redirect()->back()->withInput();
        }
        if ($data['payment'] < $data['grand_total']) {
            toastr()->error('Pembayaran Belum Lunas');

            return redirect()->back()->withInput();
        }

        DB::beginTransaction();
        try {
            foreach ($cart as $value) {
                Nota::create([
                    'no_nota' => $data['no_nota'],
                    'produk_id' => $value->produk_id,
                    'quantity' => $value->quantity,
                ]);
                StokFlow::urusStok(
                    $value->produk_id,
                    $value->quantity,
                    'keluar',
                    'Penjualan dengan No. Nota : '.$data['no_nota'],
                );
                $value->delete();
            }
            $penjualan = Penjualan::create([
                'user_id' => Auth::user()->id,
                'nota_id' => $data['no_nota'],
                'grand_total' => $data['grand_total'],
                'payment' => $data['payment'],
                'charge' => $data['charge'],
            ]);
            DB::commit();
            toastr()->success('Berhasil Melakukan Penjualan');

            return redirect()->back()->with('print_penjualan_id', $penjualan->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
