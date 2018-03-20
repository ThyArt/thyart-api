<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['store']);
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $data = request(['name', 'email', 'all', 'per_page']);

        $valid = validator($data, ['per_page' => 'integer']);
        if ($valid->fails()) {
            throw new ValidationException($valid);
        }

        $user = User::when(isset($data['all']), function ($user) use ($data) {
            return $user->where('name', 'like', '%'.$data['all'].'%')
                ->orWhere('email', 'like', '%'.$data['all'].'%');
        })
            ->when(isset($data['name']), function ($user) use ($data) {
                return $user->orWhere('name', 'like', '%'.$data['name'].'%');
            })
            ->when(isset($data['email']), function ($user) use ($data) {
                return $user->orWhere('email', 'like', '%' . $data['email'] . '%');
            });

        $per_page = 25;
        if (isset($data['per_page'])) {
            $per_page = min(1000, $data['per_page']);
        }
        return UserResource::collection($user->paginate($per_page));
    }

    /**
     * Store a newly created user in storage.
     *
     * @return UserResource
     */
    public function store()
    {
        $data = request(['email', 'name', 'password']);
        $valid = validator(
            $data,
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]
        );
        if ($valid->fails()) {
            throw new ValidationException($valid);
        }

        return new UserResource(User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]
        ));
    }

    /**
     * Display the specified user.
     *
     * @param  \App\User  $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified user in storage.
     *
     * @return UserResource
     */
    public function update()
    {
        $user = request()->user();
        $data = request(['email', 'name', 'password']);

        $valid = validator(
            $data,
            [
                'name' => 'string|max:255',
                'email' => 'string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'string|min:6',
            ]
        );
        if ($valid->fails()) {
            throw new ValidationException($valid);
        }

        if (isset($data['email'])) {
            $user->email = $data['email'];
        }

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        if (isset($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        $user->save();

        return new UserResource($user->refresh());
    }

    /**
     * Remove the specified user from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = request()->user();

        $user->delete();

        return response()->json(['message' => 'User deleted.'], 200);
    }
}
