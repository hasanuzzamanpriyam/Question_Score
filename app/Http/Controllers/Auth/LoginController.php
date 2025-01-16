<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'user_email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt(['user_email' => $request->user_email, 'password' => $request->password])) {
            return redirect()->route('categories.index');
        } else {
            return view('/');
        }
    }
}
