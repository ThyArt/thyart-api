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
        $data = $request->only(['name', 'address' ,'phone']);

        $gallery = Gallery
            ::when(isset($data['name']), function ($gallery) use ($data) {
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
        $data = $request->only(['name', 'address', 'phone']);

        $gallery = Gallery::newModelInstance();
        $gallery->name = $data['name'];
        $gallery->address = $data['address'];
        $gallery->phone = $data['phone'];

        $gallery->save();
        return new GalleryResource($gallery);
    }

    /**
     * Display the specified gallery.
     *
     * @param  \App\Gallery  $gallery
     * @return GalleryResource
     */
    public function show(Gallery $gallery)
    {
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
        $data = $request->only(['name', 'address', 'phone']);


        if (isset($data['name'])) {
            $gallery->name = $data['name'];
        }

        if (isset($data['address'])) {
            $gallery->address = $data['address'];
        }

        if (isset($data['phone'])) {
            $gallery->phone = $data['phone'];
        }

        $gallery->save();

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
        $gallery->delete();

        return response()->json(['message' => 'Gallery deleted.'], 200);

    }
}
