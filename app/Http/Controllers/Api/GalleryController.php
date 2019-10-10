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
     * @group Galleries
     *
     * @bodyParam name string the name of the gallery
     * @bodyParam address string the address of the gallery
     * @bodyParam phone string the gallery's phone number
     *
     * @param  GalleryIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(GalleryIndexRequest $request)
    {
        $data = $request->only(['name', 'address', 'phone']);

        $gallery = $request->user()->gallery
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
     * Display the specified gallery.
     *
     * @group Galleries
     *
     * @queryParam gallery Gallery the gallery to be shown
     *
     * @return GalleryResource
     */
    public function show()
    {
        $gallery = request()->user()->gallery;
        return new GalleryResource($gallery);
    }

    /**
     * Update the specified gallery in storage.
     *
     * @group Galleries
     *
     * @bodyParam name string the name of the gallery
     * @bodyParam address string the address of the gallery
     * @bodyParam phone string the gallery's phone number
     *
     * @queryParam gallery Gallery the gallery to be modified
     *
     * @param  GalleryUpdateRequest  $request
     * @return GalleryResource
     */
    public function update(GalleryUpdateRequest $request)
    {
        $data = $request->only(['name', 'address', 'phone']);

        $gallery = $request->user()->gallery;
        $gallery->update($data);

        return new GalleryResource($gallery);
    }

    /**
     * Remove the specified gallery from storage.
     *
     * @group Galleries
     *
     * @queryParam gallery Gallery the gallery to be deleted
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $gallery = request()->user()->gallery;
        $gallery->delete();

        return response()->json(['message' => 'Gallery deleted.'], 200);
    }
}
