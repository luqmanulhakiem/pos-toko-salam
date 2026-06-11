<?php

namespace App\Http\Controllers;

use App\Http\Requests\StokFlowStoreRequest;
use App\Models\Produk;
use App\Models\StokFlow;
use Illuminate\Http\Request;

class StokFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->type;
        $query = StokFlow::with(['user', 'produk']);

        if (!empty(trim($type))) {
            $query->where('type', $type);
        }

        $data = $query->latest()->paginate(10);
        return view('src.pages.stok.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addStock(string $idProduk)
    {
        $data = Produk::find($idProduk);
        return view('src.pages.stok.add', compact('data'));
    }

    public function decreaseStock(string $idProduk)
    {
        $data = Produk::find($idProduk);
        return view('src.pages.stok.decrease', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StokFlowStoreRequest $request)
    {
        $data = $request->validated();

        try {
            StokFlow::urusStok(
                $data['produk_id'],
                $data['quantity'],
                $data['type'],
                $data['description']
            );

            toastr()->success("Data stok berhasil diperbarui");
            return redirect()->route('produk');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["message" => $e->getMessage()]);
        }
    }
}
