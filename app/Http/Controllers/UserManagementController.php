<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with('roles')->paginate(10);
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
        $roles = Role::get();

        return view('src.pages.user-management.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $user = User::create([
                "name" => $data['name'],
                "email" => $data['email'],
                "password" => $data['password'],
            ]);
            $user->assignRole($data['role']);
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
        $data = User::with('roles')->where('id', $id)->first();
        $roles = Role::get();

        return view('src.pages.user-management.edit', compact('data', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $user = User::findorfail($id);

        if (!empty($user)) {
            $user->update([
                "name" => $data['name'],
                "email" => $data['email'],
            ]);
            $user->syncRoles($data['role']);
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
