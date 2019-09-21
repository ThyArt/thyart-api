<?php


namespace App\Http\Controllers\Api;

use App\Exhibition;
use App\Http\Requests\Exhibition\ExhibitionIndexRequest;
use App\Http\Requests\Exhibition\ExhibitionStoreRequest;
use App\Http\Requests\Exhibition\ExhibitionUpdateRequest;
use App\Http\Resources\ExhibitionResource;
use Illuminate\Validation\UnauthorizedException;

class ExhibitionController
{
    /**
     * Display a listing of the exhibitions.
     *
     * @param NewsletterIndexRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ExhibitionIndexRequest $request)
    {
        $data = $request->only(['name', 'begin', 'end', 'per_page']);

        $exhibition = $request->user()->gallery->exhibitions()
            ->when(isset($data['name']), function ($exhibition) use ($data) {
                return $exhibition->where('name', 'like', '%' . $data['name'] . '%');
            })
            ->when(isset($data['begin']), function ($exhibition) use ($data) {
                return $exhibition->where('begin', 'like', '%' . $data['begin'] . '%');
            })
            ->when(isset($data['end']), function ($exhibition) use ($data) {
                return $exhibition->where('end', 'like', '%' . $data['end'] . '%');
            });

        $per_page = 25;
        if (isset($data['per_page'])) {
            $per_page = min(1000, intval($data['per_page']));
        }

        return ExhibitionResource::collection($exhibition->paginate($per_page));
    }

    /**
     * Store a newly created exhibition in storage.
     *
     * @param NewsletterStoreRequest $request
     *
     * @return ExhibitionResource
     */
    public function store(ExhibitionStoreRequest $request)
    {
        return new ExhibitionResource(
            $request->user()->gallery->exhibitions()->create(
                $request->only(['name', 'begin', 'end'])
            )
        );
    }

    /**
     * Display the specified user.
     *
     * @param Exhibition $exhibition
     *
     * @return ExhibitionResource
     */
    public function show(Exhibition $exhibition)
    {
        if ($exhibition->gallery->id != request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this exhibition.');
        }
        return new ExhibitionResource($exhibition);
    }

    /**
     * Update the specified exhibition in storage.
     *
     * @param NewsletterUpdateRequest $request
     * @param Exhibition $exhibition
     *
     * @return ExhibitionResource
     */
    public function update(ExhibitionUpdateRequest $request, Exhibition $exhibition)
    {
        if ($exhibition->gallery->id != request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this exhibition.');
        }

        $data = $request->only(['name', 'begin', 'end']);

        if (!isset($data['begin']) &&
            isset($data['end']) &&
            strtotime($data['end']) < strtotime($exhibition->begin)) {
            throw new UnauthorizedException('The end can\'t happen before the beginning of an event');
        }

        $exhibition->update($data);

        return new ExhibitionResource($exhibition->refresh());
    }

    /**
     * Remove the specified exhibition from storage.
     *
     * @param Exhibition $exhibition
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Exhibition $exhibition)
    {
        if ($exhibition->gallery->id != request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this exhibition.');
        }

        $exhibition->delete();

        return response()->json(['message' => 'Exhibition deleted.'], 200);
    }
}
