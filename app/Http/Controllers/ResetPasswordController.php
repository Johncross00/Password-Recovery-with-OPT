<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    private $otp;

    public function __construct()
    {
        $this->otp = new Otp();
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $otpValidation = $this->otp->validate($request->email, $request->otp);

        if (!$otpValidation->status) {
            return response()->json(['error' => 'OTP invalide ou expiré.'], 401);
        }

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mot de passe mis à jour avec succès.',
        ], 200);
    }
}