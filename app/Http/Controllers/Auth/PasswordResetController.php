<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordReset\PasswordResetCreateRequest;
use App\Http\Requests\PasswordReset\PasswordResetRequest as passwdRestRequest;
use App\Http\Resources\PasswordResetResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;
use App\PasswordReset;

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

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_random(60)
            ]
        );
        $user->notify(
            new PasswordResetRequest($passwordReset->token, $data['endpoint'])
        );
        return response()->json([
            'message' => 'An email has been sent to the user email'
        ]);
    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        }
        return new PasswordResetResource($passwordReset);
    }
    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(passwdRestRequest $request)
    {
        $data = $request->only(['email', 'token', 'password']);

        $passwordReset = PasswordReset::where(['email' => $data['email'], 'token' => $data['token']])->firstOrFail();
        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $user->password = bcrypt($data['password']);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess());
        return new UserResource($user);
    }
}
