<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticateEcho(Request $request)
{
    // Check if the user is authenticated using Sanctum guard
    if (Auth::guard('sanctum')->check()) {
        // User is authenticated, return a success response
        return response()->json(['auth' => true]);
    }

    // If the token is not valid or the user is not authenticated, return an error response
    return response()->json(['auth' => false], 403);
}
}
