<?php

namespace App\Http\Controllers\Api;

use App\Artwork;
use App\Http\Controllers\Controller;
use App\Http\Requests\Artwork\ArtworkIndexRequest;
use App\Http\Requests\Artwork\ArtworkStoreRequest;
use App\Http\Requests\Artwork\ArtworkUpdateRequest;
use App\Http\Requests\Artwork\ImageStoreRequest;
use App\Http\Resources\ArtworkResource;
use Illuminate\Http\Response;
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
        $artworks = $request->user()->gallery->artworks()
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
            foreach ($request->file('images') as $file) {
                $artwork->storeImage($file);
            }
        }

        return new ArtworkResource(
            $request
                ->user()
                ->gallery
                ->artworks()
                ->save($artwork)
        );
    }

    /**
     * Store an image in storage.
     *
     * @param ImageStoreRequest $request
     * @param Artwork $artwork
     * @return ArtworkResource
     */

    public function storeImage(ImageStoreRequest $request, Artwork $artwork)
    {
        if ($artwork->gallery->id !== $request->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this artwork.');
        }

        foreach ($request->file('images') as $file) {
            $artwork->storeImage($file);
        }

        $artwork->save();

        return new ArtworkResource($artwork->refresh());
    }

    /**
     * Store a compressed image in storage.
     *
     * @param ImageStoreRequest $request
     * @param Artwork $artwork
     * @return ArtworkResource
     */

    public function storeCImage(ImageStoreRequest $request, Artwork $artwork)
    {
        if ($artwork->gallery->id !== $request->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this artwork.');
        }

        foreach ($request->file('images') as $file) {
            $artwork->storeCImage($file);
        }

        $artwork->save();

        return new ArtworkResource($artwork->refresh());
    }

public function destroyImage(Artwork $artwork, $media)
    {
        if ($artwork->gallery->id !== request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this artwork.');
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
     * @param  $artwork
     * @return ArtworkResource
     */

    public function show(Artwork $artwork)
    {
        if ($artwork->gallery->id !== request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this artwork.');
        }
        return new ArtworkResource($artwork);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ArtworkUpdateRequest $request
     * @param  $artwork
     * @return ArtworkResource
     */
    public function update(ArtworkUpdateRequest $request, Artwork $artwork)
    {
        if ($artwork->gallery->id !== request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this artwork.');
        }
        $artwork->fill($request->only(['name', 'price', 'state', 'ref']));
        $artwork->save();

        return new ArtworkResource($artwork->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $artwork
     * @return Response
     * @throws \Exception
     */
    public function destroy(Artwork $artwork)
    {
        if ($artwork->gallery->id !== request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this artwork.');
        }

        $artwork->delete();

        return response()->json(['message' => 'Artwork deleted.'], 200);
    }
}
