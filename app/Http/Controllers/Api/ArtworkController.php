<?php

namespace App\Http\Controllers\Api;

use App\Artist;
use App\Artwork;
use App\Http\Controllers\Controller;
use App\Http\Requests\Artwork\ArtworkIndexRequest;
use App\Http\Requests\Artwork\ArtworkStoreRequest;
use App\Http\Requests\Artwork\ArtworkUpdateRequest;
use App\Http\Resources\ArtworkResource;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ArtworkIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ArtworkIndexRequest $request)
    {
        $data = $request->only(['name', 'price_min', 'price_max', 'state', 'ref', 'artist_id']);
        $artworks = $request->user()->artworks()
            ->when(isset($data['name']), function ($artwork) use ($data) {
                return $artwork->where('name', 'like', '%' . $data['name'] . '%');
            })
            ->when(isset($data['price_min']), function ($artwork) use ($data) {
                return $artwork->where('price', '>=', $data['price_min']);
            })
            ->when(isset($data['price_max']), function ($artwork) use ($data) {
                return $artwork->where('price', '<=', $data['price_max']);
            })
            ->when(isset($data['state']), function ($artwork) use ($data) {
                return $artwork->where('state', 'like', $data['state']);
            })
            ->when(isset($data['ref']), function ($artwork) use ($data) {
                return $artwork->where('ref', 'like', $data['ref']);
            })
            ->when(isset($data['artist_id']), function ($artwork) use ($data) {
                return $artwork->where('artist_id', '==', $data['artist_id']);
            });

        $per_page = 25;
        if (isset($data['per_page'])) {
            $per_page = min(1000, intval($data['per_page']));
        }

        return ArtworkResource::collection($artworks->paginate($per_page));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArtworkStoreRequest $request
     * @param Artist $artist
     * @return ArtworkResource
     */
    public function store(ArtworkStoreRequest $request)
    {
        $data = $request->only(['name', 'price', 'state', 'ref']);
        $artwork = new Artwork($data);
        $artist = Artist::findOrFail($request->get('artist_id'));
        $artwork->artist()->associate($artist);
        return new ArtworkResource(
        $request
            ->user()
            ->artworks()
            ->save($artwork)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Artwork  $artwork
     * @return ArtworkResource
     */

    public function show(Artwork $artwork)
    {
        if ($artwork->user->id !== request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this artwork.');
        }
        return new ArtworkResource($artwork);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ArtworkUpdateRequest $request
     * @param  \App\Artwork $artwork
     * @return ArtworkResource
     */
    public function update(ArtworkUpdateRequest $request, Artwork $artwork)
    {
        if ($artwork->user->id !== request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this artwork.');
        }
        $artist_id = $request->get('artist_id');
        if (isset($artist_id)) {
            $artist = Artist::findOrFail($artist_id);
            $artwork->artist()->associate($artist);
        }
        $artwork->fill($request->only(['name', 'price', 'state', 'ref']));
        $artwork->save();

        return new ArtworkResource($artwork->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Artwork $artwork
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Artwork $artwork)
    {
        if ($artwork->user->id !== request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this artwork.');
        }

        $artwork->delete();

        return response()->json(['message' => 'Artwork deleted.'], 200);
    }
}
