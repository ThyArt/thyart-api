<?php

namespace App\Http\Controllers\Api;

use App\Artist;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArtistResource;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class ArtistController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $data = request(['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'country', 'per_page']);

        $valid = validator($data, ['per_page' => 'integer']);

        if ($valid->fails()) {
            throw new ValidationException($valid);
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

    /**
     * Store a newly created user in storage.
     *
     * @return ArtistResource
     */
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
            throw new ValidationException($valid);
        }

        return new ArtistResource(request()->user()->artists()->create($data));
    }

    /**
     * Display the specified user.
     *
     * @param Artist $artise
     *
     * @return ArtistResource
     */
    public function show(Artist $artist)
    {
        if ($artist->user->id !== request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this artist.');
        }
        return new ArtistResource($artist);
    }

    /**
     * Update the specified user in storage.
     *
     * @param Artist $artist
     * @return ArtistResource
     */
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
            throw new ValidationException($valid);
        }

        $artist->update($data);

        return new ArtistResource($artist->refresh());
    }

    /**
     * Remove the specified user from storage.
     *
     * @param Artist $artist
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Artist $artist)
    {
        if ($artist->user->id !== request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this artist.');
        }

        $artist->delete();

        return response()->json(['message' => 'Artist deleted.'], 200);
    }
}
