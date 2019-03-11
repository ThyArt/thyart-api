<?php

namespace App\Http\Controllers\Api;

use App\Artist;
use App\Artwork;
use App\Http\Controllers\Controller;
use App\Http\Requests\Artwork\ArtworkIndexRequest;
use App\Http\Requests\Artwork\ArtworkStoreRequest;
use App\Http\Requests\Artwork\ArtworkUpdateRequest;
use App\Http\Requests\Artwork\ImageStoreRequest;
use App\Http\Resources\ArtworkResource;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Spatie\MediaLibrary\Exceptions\MediaCannotBeDeleted;

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
        $data = $request->only(['name', 'price_min', 'price_max', 'state', 'ref']);
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

        /**
         *  We search for media in the request and save them in the artwork's media collection
         */

        if (($request->file('images')) != null) {
            $artwork->addMedia($request->file('images')[0])->toMediaCollection('images');
        }

        return new ArtworkResource(
            $request
                ->user()
                ->artworks()
                ->save($artwork)
        );
    }

    /**
     * Store an image in storage.
     *
     * @param ArtworkStoreRequest $request
     * @param Artwork $artwork
     * @return ArtworkResource
     */

    public function storeImage(ImageStoreRequest $request, Artwork $artwork)
    {
        if ($artwork->user->id !== $request->user()->id) {
            throw new UnauthorizedException('The current user does not own this artwork.');
        }

        $artwork->addMedia($request->file('images')[0])->toMediaCollection('images');
        $artwork->save();

        return new ArtworkResource($artwork->refresh());
    }

    public function destroyImage(Artwork $artwork, $media)
    {
        if ($artwork->user->id !== request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this artwork.');
        }

        try {
            $artwork->deleteMedia($media);
        } catch (MediaCannotBeDeleted $e) {
            throw new UnauthorizedException('Media not found in collection');
        }

        return response()->json(['message' => 'Image deleted.'], 200);
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
