<?php

namespace App\Http\Controllers;

use App\Http\Requests\KasirStoreRequest;
use App\Models\Cart;
use App\Models\Nota;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\StokFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noNota = 'INV-' . date('ymd') . rand(1000, 9999);
        return view('src.pages.kasir.index', compact('noNota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KasirStoreRequest $request)
    {
        $data = $request->validated();

        if ($data['payment'] < $data['grand_total']) {
            toastr()->error('Pembayaran Belum Lunas');
            return redirect()->back()->withInput();
        }
        DB::beginTransaction();
        try {
            $cart = Cart::get();
            foreach ($cart as $value) {
                Nota::create([
                    "no_nota" => $data['no_nota'],
                    "produk_id" => $value->produk_id,
                    "quantity" =>  $value->quantity,
                ]);
                StokFlow::urusStok(
                    $value->produk_id,
                    $value->quantity,
                    "keluar",
                    "Penjualan dengan No. Nota : " . $data['no_nota'],
                );
                $value->delete();
            }
            Penjualan::create([
                "user_id" => Auth::user()->id,
                "nota_id" => $data["no_nota"],
                "grand_total" => $data["grand_total"],
                "payment" => $data["payment"],
                "charge" => $data["charge"],
            ]);
            DB::commit();
            toastr()->success("Berhasil Melakukan Penjualan");
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["message" => $e->getMessage()]);
        }
    }
}
