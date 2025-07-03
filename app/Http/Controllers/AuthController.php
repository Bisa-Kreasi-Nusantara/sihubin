<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Auth;
use Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|string',
            'password'  => 'required|min:4'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $credentials = $request->only(['email', 'password']);
        $remember = $request->has('remember_me');
        if(Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // check user status
            // if (!$user->status) {
            //     Auth::logout();
            //     return redirect()->back()->withErrors(['email' => 'Your account is inactive, please contact administrator']);
            // }
            // $user->save();

            $request->session()->regenerate();
            return redirect()->intended('/company-refrences');
        }

        return back()->withErrors(['email' => 'Email or Password is incorrect.'])->withInput();
    }

    public function logout()
    {
        try {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login');

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
