<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function proses_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jabatan' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'nama.required' => 'Nama Lengkap harus diisi!',
            'jabatan.required' => 'Jabatan harus diisi!',
            'email.required' => 'Email Institusi harus diisi!',
            'email.email' => 'Email Institusi salah!',
            'password.required' => 'Password harus diisi!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            alert()->error('Error!', 'Isi data dengan benar!');
            return back()->withInput()->with('error', $error);
        }

        User::create(array_merge($request->all(), [
            'password' => bcrypt($request->password),
            'role' => 'tamu'
        ]));

        alert()->success('Success', 'Berhasil melakukan pendaftaran');

        return redirect('login');
    }

    public function login()
    {
        if (auth()->check()) {
            return redirect('check-user');
        } else {
            return view('login');
        }
    }

    public function proses_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'telp' => 'required',
            'password' => 'required',
        ], [
            'telp.required' => 'No. Telepon harus diisi!',
            'password.required' => 'Password harus diisi!',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', 'Isi data dengan benar!');
            return back()->withInput()->withErrors($validator);
        }

        if (Auth::attempt(['telp' => $request->telp, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect('check-user');
        } else {
            alert()->error('Error', 'No. Telepon atau Password salah!');
            return back()->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }

    public function check_user()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return redirect('admin');
            }
            if (auth()->user()->role == 'user') {
                return redirect('user');
            }
        }

        return redirect('login');
    }
}
