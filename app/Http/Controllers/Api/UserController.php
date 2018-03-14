<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $data = request()->only('name', 'email', 'search');
        $user = User::query();
        $user->when((isset($data['name']) || isset($data['search'])), function ($user) use ($data) {
            if (isset($data['search']))
                return $user->where('name', 'like', '%' . $data['search'] . '%');
            return $user->where('name', 'like', '%'.$data['name'].'%');
        })
            ->when((isset($data['email']) || isset($data['search'])), function ($user) use ($data) {
                if (isset($data['search']))
                    return $user->orWhere('email', 'like', '%' . $data['search'] . '%');
            return $user->orWhere('email', 'like', '%' . $data['email'] . '%');
        });
        return $user->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function store()
    {
        $valid = validator(request()->only('email', 'name', 'password'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($valid->fails()) {
            return response()->json($valid->errors()->all(), 400);
        }

        $data = request()->only('email', 'name', 'password');

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return User
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @return User
     */
    public function update()
    {
        $user = request()->user();

        $valid = validator(request()->only('email', 'name', 'password'), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'string|min:6',
        ]);

        if ($valid->fails()) {
            return response()->json($valid->errors()->all(), 400);
        }

        $data = request()->only('email', 'name', 'password');

        if (isset($data['email']))
            $user->email = $data['email'];

        if (isset($data['name']))
            $user->name = $data['name'];

        if (isset($data['password']))
            $user->password = bcrypt($data['password']);

        $user->save();

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = request()->user();

        $user->delete();

        return response()->json(['User deleted.'], 200);
    }
}
