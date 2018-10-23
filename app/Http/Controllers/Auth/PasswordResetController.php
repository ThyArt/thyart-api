<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordReset\PasswordResetCreateRequest;
use App\Notifications\PasswordResetRequest;
use App\User;

class PasswordResetController extends Controller
{
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(PasswordResetCreateRequest $request)
    {
        $data = $request->only(['email', 'endpoint']);
        $user = User::where('email', $data['email'])->firstOrFail();

        $newPassword = str_random();
        $user->password = bcrypt($newPassword);
        $user->save();

        $user->notify(
            new PasswordResetRequest($newPassword)
        );
        return response()->json([
            'message' => 'An email has been sent to the user email'
        ]);
    }
}
