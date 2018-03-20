<?php

namespace App\Http\Controllers\Api;

use App\Artist;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArtistResource;
use Illuminate\Validation\UnauthorizedException;

class ArtistController extends Controller
{
    public function index()
    {
        $data = request(['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'country', 'per_page']);

        $valid = validator($data, ['per_page' => 'integer']);

        if ($valid->fails()) {
            return response()->json($valid->errors()->all(), 400);
        }

        $artists = request()->user()->artists()
            ->when(isset($data['first_name']), function ($customer) use ($data) {
                return $customer->where('first_name', 'like', '%' . $data['first_name'] . '%');
            })
            ->when(isset($data['last_name']), function ($customer) use ($data) {
                return $customer->where('last_name', 'like', '%' . $data['last_name'] . '%');
            })
            ->when(isset($data['email']), function ($customer) use ($data) {
                return $customer->where('email', 'like', '%' . $data['email'] . '%');
            })
            ->when(isset($data['phone']), function ($customer) use ($data) {
                return $customer->where('phone', 'like', '%' . $data['phone'] . '%');
            })
            ->when(isset($data['address']), function ($customer) use ($data) {
                return $customer->where('address', 'like', '%' . $data['address'] . '%');
            })
            ->when(isset($data['city']), function ($customer) use ($data) {
                return $customer->where('city', 'like', '%' . $data['city'] . '%');
            })
            ->when(isset($data['country']), function ($customer) use ($data) {
                return $customer->where('country', 'like', '%' . $data['country'] . '%');
            });

        $per_page = 25;
        if (isset($data['per_page'])) {
            $per_page = min(1000, intval($data['per_page']));
        }
        return ArtistResource::collection($artists->paginate($per_page));
    }

    public function store()
    {
        $data = request(['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'country']);

        $valid = validator($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255',
            'phone' => 'required|phone:FR',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255'
        ]);

        if ($valid->fails()) {
            return response()->json($valid->errors()->all(), 400);
        }

        return new ArtistResource(request()->user()->artists()->create($data));
    }

    public function show(Artist $artist)
    {
        if ($artist->user->id !== request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this artist.');
        }
        return new ArtistResource($artist);
    }

    public function update(Artist $artist)
    {
        if ($artist->user->id !== request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this artist.');
        }

        $data = request(['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'country']);

        $valid = validator($data, [
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'string|email|max:255',
            'phone' => 'phone:FR',
            'address' => 'string|max:255',
            'city' => 'string|max:255',
            'country' => 'string|max:255'
        ]);

        if ($valid->fails()) {
            return response()->json($valid->errors()->all(), 400);
        }

        $artist->update($data);

        return new ArtistResource($artist->refresh());
    }

    public function destroy(Artist $artist)
    {
        if ($artist->user->id !== request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this artist.');
        }

        $artist->delete();

        return response()->json(['message' => 'Artist deleted.'], 200);
    }
}
