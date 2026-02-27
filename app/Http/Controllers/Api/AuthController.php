<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'Access Granted',
            'user' => Auth::user(),
        ], 200);
    }

    return response()->json(['message' => 'Invalid Credentials'], 401);
}
}
