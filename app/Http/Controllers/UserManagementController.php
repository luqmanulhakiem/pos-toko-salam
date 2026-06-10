<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::paginate(10);

        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('src.pages.user-management.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('src.pages.user-management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $data = User::create($data);
            toastr()->success('Berhasil Tambah Data');
            return redirect()->route('userManagement');
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
        $data = User::findorfail($id);
        return view('src.pages.user-management.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $user = User::findorfail($id);

        if (!empty($user)) {
            $user->update($data);
            toastr()->success('Berhasil Update Data');
            return redirect()->route('userManagement');
        } else {
            toastr()->error('User tidak ditemukan');
            return redirect()->route('userManagement');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findorfail($id);
        if (empty($user)) {
            toastr()->error('User tidak ditemukan');
            return redirect()->route('userManagement');
        } else {
            $user->delete();
            toastr()->success('Berhasil Hapus Data');
            return redirect()->route('userManagement');
        }
    }
}
