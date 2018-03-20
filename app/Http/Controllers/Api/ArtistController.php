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
        $data = request(['firstname', 'lastname', 'email', 'phone', 'address', 'city', 'country', 'per_page']);

        $valid = validator($data, ['per_page' => 'integer']);

        if ($valid->fails()) {
            return response()->json($valid->errors()->all(), 400);
        }

        $artists = request()->user()->artists()
            ->when(isset($data['firstname']), function ($customer) use ($data) {
                return $customer->where('firstname', 'like', '%' . $data['firstname'] . '%');
            })
            ->when(isset($data['lastname']), function ($customer) use ($data) {
                return $customer->where('lastname', 'like', '%' . $data['lastname'] . '%');
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
        $data = request(['firstname', 'lastname', 'email', 'phone', 'address', 'city', 'country']);

        $valid = validator($data, [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|phone:FR,US,EN',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string'
        ]);

        if ($valid->fails()) {
            return response()->json($valid->errors()->all(), 400);
        }

        return new ArtistResource(request()->user()->artists()->create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'city' => $data['city'],
            'country' => $data['country'],
        ]));
    }

    public function show(Artist $artist)
    {
        if ($artist->user !== request()->user) {
            throw new UnauthorizedException('The current user does not own this artist.');
        }
        return new ArtistResource($artist);
    }

    public function update(Artist $artist)
    {
        if ($artist->user !== request()->user) {
            throw new UnauthorizedException('The current user does not own this artist.');
        }

        $data = request(['firstname', 'lastname', 'email', 'phone', 'address', 'city', 'country']);

        $valid = validator($data, [
            'firstname' => 'string',
            'lastname' => 'string',
            'email' => 'string',
            'phone' => 'phone:FR',
            'address' => 'string',
            'city' => 'string',
            'country' => 'string'
        ]);

        if ($valid->fails()) {
            return response()->json($valid->errors()->all(), 400);
        }

        $artist->update($data);

        return new ArtistResource($artist->refresh());
    }

    public function destroy(Artist $artist)
    {
        if (!$artist->user === request()->user) {
            throw new UnauthorizedException('The current user does not own this artist.');
        }

        $artist->delete();

        return response()->json(['message' => 'Artist deleted.'], 200);
    }
}
