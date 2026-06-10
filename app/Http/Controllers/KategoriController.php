<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriStoreUpdateRequest;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kategori::paginate(10);

        $title = 'Delete Kategori!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('src.pages.kategori.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('src.pages.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriStoreUpdateRequest $request)
    {
        $data = $request->validated();

        try {
            $data = Kategori::create($data);
            toastr()->success('Berhasil Tambah Data');
            return redirect()->route('kategori');
        } catch (\Throwable $th) {
            toastr()->error('Gagal ' . $th);
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
        $data = Kategori::findorfail($id);
        return view('src.pages.kategori.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KategoriStoreUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $user = Kategori::findorfail($id);

        if (!empty($user)) {
            $user->update($data);
            toastr()->success('Berhasil Update Data');
            return redirect()->route('kategori');
        } else {
            toastr()->error('User tidak ditemukan');
            return redirect()->route('kategori');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Kategori::findorfail($id);
        if (empty($user)) {
            toastr()->error('User tidak ditemukan');
            return redirect()->route('kategori');
        } else {
            $user->delete();
            toastr()->success('Berhasil Hapus Data');
            return redirect()->route('kategori');
        }
    }
}
