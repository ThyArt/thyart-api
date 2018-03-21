<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
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
     * @param UserIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(UserIndexRequest $request)
    {
        $data = $request->only(['name', 'email', 'per_page']);

        $user = User
            ::when(isset($data['name']), function ($user) use ($data) {
                return $user->orWhere('name', 'like', '%'. $data['name'] . '%');
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
     * @param UserStoreRequest $request
     * @return UserResource
     */
    public function store(UserStoreRequest $request)
    {
        return new UserResource(User::create($request->only(['email', 'name', 'password'])));
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
     * @param UserUpdateRequest $request
     * @return UserResource
     * @throws ValidationException
     */
    public function update(UserUpdateRequest $request)
    {
        $user = $request->user();
        $data = $request->only(['email', 'name', 'password']);

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
