<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function welcome()
    {
        return view('welcome');
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ], [
            'username.required' => 'Isi data dengan lengkap!',
            'username.unique' => 'Akun sudah ada, Silahkan login! Bila lupa akun silahkan buat akun dengan data lain',
            'password.required' => 'Isi data dengan lengkap!',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $user = [
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ];
    
        User::create($user);
        return redirect()->route('welcome');
    }
    
    

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Isi data dengan lengkap!',
            'password.required' => 'Isi data dengan lengkap!',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        } else {
            // Jika otentikasi gagal, cek apakah username ada di database
            $userExists = User::where('username', $credentials['username'])->exists();
            if (!$userExists) {
                return back()->withErrors(['username' => 'Akun tidak ditemukan, silahkan gunakan data lain atau daftar akun.'])->withInput();
            } else {
                return back()->withErrors(['password' => 'Kombinasi username dan password tidak valid'])->withInput();
            }
        }
    }
    
    
    
    
    
    
    

    public function logout()
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('logout');
    }
}
