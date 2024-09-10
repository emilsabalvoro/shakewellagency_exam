<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\VoucherCode;

use App\Mail\WelcomeEmail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'first_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'first_name' => $validated['first_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $voucherCode = VoucherCode::create([
            'code' => $this->generateUniqueCode();
        ]);

        Mail::to($user->email)->send(new WelcomeEmail($user, $voucherCode->code));

        return response()->json([
            'message' => 'User successfully registered. Welcome email has been sent'
        ], 201);
    }

    private function generateUniqueCode()
    {
        do {
            $code = strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5));
        } while (VoucherCode::where('code', $code)->exists());

        return $code;
    }
}
