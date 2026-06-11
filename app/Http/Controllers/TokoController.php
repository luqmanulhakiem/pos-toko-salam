<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function index()
    {
        $toko = Toko::first();

        return view('src.pages.konfigurasi.index', compact('toko'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $toko = Toko::first();
        if ($toko) {
            $toko->update($request->all());
        } else {
            Toko::create($request->all());
        }
        toastr()->success('Data toko berhasil diperbarui');

        return redirect()->back();
    }
}
