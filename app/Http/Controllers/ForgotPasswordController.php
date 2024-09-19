<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->notify(new ResetPasswordNotification());
        }

        return response()->json([
            'success' => true,
            'message' => 'Si cet email existe, un code OTP a été envoyé.',
        ], 200);
    }
}
