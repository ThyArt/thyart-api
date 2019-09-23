<?php

namespace App\Http\Controllers\Api;

use App\Artist;
use App\Http\Controllers\Controller;
use App\Http\Requests\Artist\ArtistIndexRequest;
use App\Http\Requests\Artist\ArtistStoreRequest;
use App\Http\Requests\Artist\ArtistUpdateRequest;
use App\Http\Resources\ArtistResource;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class ArtistController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @group Artists
     *
     * @bodyParam first_name string the artist's first name
     * @bodyParam last_name string the artist's last name
     * @bodyParam email string the artist's email
     * @bodyParam phone string the artist's phone number
     * @bodyParam address string the artist's address
     * @bodyParam city string the artist's city of residence
     * @bodyParam country string the artist's country of residence
     * @bodyParam per_page int the number of artists to be displayed per page
     *
     * @param ArtistIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ArtistIndexRequest $request)
    {
        $data = $request->only(['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'country', 'per_page']);

        $artists = $request->user()->gallery->artists()
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
     * @group Artists
     *
     * @bodyParam first_name string the artist's first name
     * @bodyParam last_name string the artist's last name
     * @bodyParam email string the artist's email
     * @bodyParam phone string the artist's phone number
     * @bodyParam address string the artist's address
     * @bodyParam city string the artist's city of residence
     * @bodyParam country string the artist's country of residence
     *
     * @param ArtistStoreRequest $request
     * @return ArtistResource
     */
    public function store(ArtistStoreRequest $request)
    {
        return new ArtistResource(
            $request
                ->user()
                ->gallery
                ->artists()
                ->create(request(['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'country']))
        );
    }

    /**
     * Display the specified user.
     *
     * @param Artist $artist
     *
     * @return ArtistResource
     */
    public function show(Artist $artist)
    {
        if ($artist->gallery->id !== request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this artist.');
        }
        return new ArtistResource($artist);
    }

    /**
     * Update the specified user in storage.
     *
     * @group Artists
     *
     * @bodyParam first_name string the artist's first name
     * @bodyParam last_name string the artist's last name
     * @bodyParam email string the artist's email
     * @bodyParam phone string the artist's phone number
     * @bodyParam address string the artist's address
     * @bodyParam city string the artist's city of residence
     * @bodyParam country string the artist's country of residence
     * @bodyParam per_page int the number of artists to be displayed per page
     *
     * @queryParam artist Artist the artist to be modified
     *
     * @param ArtistUpdateRequest $request
     * @param Artist $artist
     * @return ArtistResource
     */
    public function update(ArtistUpdateRequest $request, Artist $artist)
    {
        if ($artist->gallery->id !== $request->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this artist.');
        }

        $artist->update($request->only(['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'country']));

        return new ArtistResource($artist->refresh());
    }

    /**
     * Remove the specified user from storage.
     *
     * @group Artists
     *
     * @queryParam artist Artist the artist to be deleted
     *
     * @param Artist $artist
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Artist $artist)
    {
        if ($artist->gallery->id !== request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this artist.');
        }

        $artist->delete();

        return response()->json(['message' => 'Artist deleted.'], 200);
    }
}
