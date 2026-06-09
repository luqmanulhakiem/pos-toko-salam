<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Flasher\Toastr\Prime\toastr;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('src.pages.auth.index');
    }

    public function login(LoginRequest $request)
    {

        $data = $request->validated();

        $user = User::where("email", $data['email'])->first();

        if (!empty($user)) {
            if (Hash::check($data['password'], $user->password)) {
                // lakukan login
                Auth::attempt(['email' => $data['email'], 'password' => $data['password']]);
                // pesan
                toastr()->success('Berhasil Login');
                // diarahkan ke dashboard
                return redirect()->route('dashboard');
            }
            // apabila password tidak sama
            else {
                toastr()->error('Gagal Login');
                return redirect()->back()->withErrors(['message' => 'password anda salah'])->withInput();
            }
        } else {
            toastr()->error('Gagal Login');
            return redirect()->back()->withErrors(['message' => 'Email tidak ditemukan'])->withInput();
        }
    }

    public function logout()
    {
        // logout
        Auth::logout();
        // pesan
        toastr()->success('Berhasil Logout');
        // diarahkan ke halaman login
        return redirect('/');
    }
}
