<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'user_email' => 'required|string|email|max:255|unique:users',
            'user_number' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->user_email = $request->user_email;
        $user->user_number = $request->user_number;
        $user->password = bcrypt($request->password);
        $user->save();

        return view('/');
    }
}
