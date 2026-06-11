<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukStoreUpdateRequest;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $query = Produk::query();

        if (!empty(trim($keyword))) {
            $query->where('name', 'LIKE', "%{$keyword}%")->orWhere('product_code', 'LIKE', "{$keyword}%");
        }

        $data = $query->paginate(10);

        $title = 'Delete Produk!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('src.pages.produk.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::get();
        return view('src.pages.produk.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdukStoreUpdateRequest $request)
    {
        $data = $request->validated();

        try {
            $data = Produk::create($data);
            toastr()->success('Berhasil Tambah Data');
            return redirect()->route('produk');
        } catch (\Throwable $th) {
            toastr()->error('Gagal ' . $th);
            return redirect()->back()->withInput()->withErrors(['message' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Produk::findorfail($id);
        $kategori = Kategori::get();

        return view('src.pages.produk.edit', compact('data', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdukStoreUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $item = Produk::findorfail($id);

        if (!empty($item)) {
            $item->update($data);
            toastr()->success('Berhasil Update Data');
            return redirect()->route('produk');
        } else {
            toastr()->error('User tidak ditemukan');
            return redirect()->route('produk');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Produk::findorfail($id);
        if (empty($item)) {
            toastr()->error('Produk tidak ditemukan');
            return redirect()->route('produk');
        } else {
            $item->delete();
            toastr()->success('Berhasil Hapus Data');
            return redirect()->route('produk');
        }
    }
}
