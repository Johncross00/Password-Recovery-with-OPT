<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|',
        ]);

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'dob' => $request->dob,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'message' => 'Registration successful',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        try {

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $user = Auth::user();
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['access_token' => $token, 'token_type' => 'Bearer', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // public function forgotPassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);

    //     $otp = (new Otp)->generate($request->email, 6, 60);

    //     // Envoyer l'OTP par e-mail (implémentez un service de mail)
    //     Mail::to($request->email)->send(new \App\Mail\SendOtpMail($otp->token));

    //     return response()->json(['message' => 'OTP sent to your email.']);
    // }

    // public function verifyOtp(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'otp' => 'required|numeric',
    //     ]);

    //     $otp = (new Otp)->validate($request->email, $request->otp);

    //     if (!$otp->status) {
    //         return response()->json(['message' => 'Invalid OTP'], 401);
    //     }

    //     return response()->json(['message' => 'OTP verified, proceed to reset your password.']);
    // }

    public function findPrimeNumbers(Request $request)
    {
        $request->validate([
            'number' => 'required|integer|min:2',
        ]);

        $n = $request->number;
        $primes = [];

        for ($i = 2; $i < $n; $i++) {
            if ($this->isPrime($i)) {
                $primes[] = $i;
            }
        }

        return response()->json($primes);
    }

    private function isPrime($num)
    {
        for ($i = 2; $i <= sqrt($num); $i++) {
            if ($num % $i === 0) {
                return false;
            }
        }
        return true;
    }
}
