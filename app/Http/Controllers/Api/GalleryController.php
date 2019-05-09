<?php

namespace App\Http\Controllers\Api;

use App\Gallery;
use App\Http\Requests\Gallery\GalleryIndexRequest;
use App\Http\Requests\Gallery\GalleryStoreRequest;
use App\Http\Requests\Gallery\GalleryUpdateRequest;
use Illuminate\Routing\Controller;
use App\Http\Resources\GalleryResource;

class GalleryController extends Controller
{
    /**
     * Display a listing of the gallery.
     *
     * @param  GalleryIndexRequest  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(GalleryIndexRequest $request)
    {
        $data = $request->only(['name', 'address', 'phone']);

        $gallery = $request->user()->galleries()
            ->when(isset($data['name']), function ($gallery) use ($data) {
                return $gallery->orWhere('name', 'like', '%' . $data['name'] . '%');
            })
            ->when(isset($data['address']), function ($gallery) use ($data) {
                return $gallery->orWhere('address', 'like', '%' . $data['address'] . '%');
            })
            ->when(isset($data['phone']), function ($gallery) use ($data) {
                return $gallery->orWhere('phone', 'like', '%' . $data['phone'] . '%');
            });

        $per_page = 25;
        if (isset($data['per_page'])) {
            $per_page = min(1000, intval($data['per_page']));
        }

        return GalleryResource::collection($gallery->paginate($per_page));
    }

    /**
     * Store a newly created gallery in storage.
     *
     * @param  GalleryStoreRequest  $request
     * @return GalleryResource
     */
    public function store(GalleryStoreRequest $request)
    {
        return new GalleryResource(
            $request
                ->user()
                ->galleries()
                ->create($request->only(['name', 'address', 'phone']))
        );
    }

    /**
     * Display the specified gallery.
     *
     * @param  \App\Gallery  $gallery
     * @return GalleryResource
     */
    public function show(Gallery $gallery)
    {
        if ($gallery->user->id != request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this gallery.');
        }
        return new GalleryResource($gallery);
    }

    /**
     * Update the specified gallery in storage.
     *
     * @param  GalleryUpdateRequest  $request
     * @param  \App\Gallery  $gallery
     * @return GalleryResource
     */
    public function update(GalleryUpdateRequest $request, Gallery $gallery)
    {
        if ($gallery->user->id != request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this gallery.');
        }

        $data = $request->only(['name', 'address', 'phone']);

        $gallery->update($data);

        return new GalleryResource($gallery);
    }

    /**
     * Remove the specified gallery from storage.
     *
     * @param  \App\Gallery  $gallery
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Gallery $gallery)
    {
        if ($gallery->user->id != request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this gallery.');
        }

        $gallery->delete();

        return response()->json(['message' => 'Gallery deleted.'], 200);
    }
}
