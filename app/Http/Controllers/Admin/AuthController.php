<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view("auth.admin.login");
    }

    public function login_post(Request $request)
    {
        $request->validate([
            'email' => 'required|min:3|email',
            'password' => 'required|min:3',
        ]);

        // atempt login
        $remember = ($request->has('remember')) ? true : false;
        $login = Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $remember);

        // if login success
        if($login) return redirect()->route('admin.home');

        // if login unsuccessfull
        return back()->withInput()->withErrors(['credentials' => trans('auth.failed')]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.auth.login');
    }
}
