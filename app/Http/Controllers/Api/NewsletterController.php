<?php


namespace App\Http\Controllers\Api;

use App\Artwork;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Newsletter\NewsletterIndexRequest;
use App\Http\Requests\Newsletter\NewsletterStoreRequest;
use App\Http\Requests\Newsletter\NewsletterUpdateRequest;
use App\Http\Resources\NewsletterResource;
use App\Newsletter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\UnauthorizedException;
use View;


class NewsletterController extends Controller
{
    /**
     * Display a listing of the newsletters.
     *
     * @group Newsletters
     *
     * @bodyParam subject string the subject of the newsletter
     * @bodyParam description string a description of the newsletter
     * @per_page int the number of newsletters to be displayed per page
     *
     * @param NewsletterIndexRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(NewsletterIndexRequest $request)
    {
        $data = $request->only(['subject', 'description', 'per_page']);

        $newsletter = $request->user()->gallery->newsletters()
            ->when(isset($data['subject']), function ($newsletter) use ($data) {
                return $newsletter->where('subject', 'like', '%' . $data['subject'] . '%');
            })
            ->when(isset($data['description']), function ($newsletter) use ($data) {
                return $newsletter->where('description', 'like', '%' . $data['description'] . '%');
            });

        $per_page = 25;
        if (isset($data['per_page'])) {
            $per_page = min(1000, intval($data['per_page']));
        }

        return NewsletterResource::collection($newsletter->paginate($per_page));
    }

    private function bindNewsletterAndCustomer($customerIds, $newsletter, $user)
    {
        foreach ($customerIds as $customerId) {
            $customer = Customer::findOrFail($customerId);
            if (!isset($customer) || ($customer->gallery->id != $user->gallery->id)) {
                $newsletter->customers()->detach();
                $newsletter->delete();
                throw new UnauthorizedException('The Customer doesn\'t exist or doesn\'t belong to you');
            }
            $customer->newsletters()->save($newsletter);
        }
    }

    private function bindNewsletterAndArtwork($artworkIds, $newsletter, $user)
    {
        foreach ($artworkIds as $artworkId) {
            $artwork = Artwork::findOrFail($artworkId);
            if (!isset($artwork) || ($artwork->gallery->id != $user->gallery->id)) {
                $newsletter->artworks()->detach();
                $newsletter->delete();
                throw new UnauthorizedException('The Artwork doesn\'t exist or doesn\'t belong to you');
            }
            $artwork->newsletters()->save($newsletter);
        }
    }

    /**
     * Store a newly created newsletter in storage.
     *
     * @group Newsletters
     *
     * @bodyParam subject string the subject of the newsletter
     * @bodyParam description string a description of the newsletter

     * @param NewsletterStoreRequest $request
     *
     * @return NewsletterResource
     */
    public function store(NewsletterStoreRequest $request)
    {
        $newsletter = $request->user()->gallery->newsletters()->create(
            $request->only(['subject', 'description'])
        );

        $customerIds = explode(',', $request->get('customer_list'));
        $artworkIds = explode(',', $request->get('artwork_list'));
        $this->bindNewsletterAndCustomer($customerIds, $newsletter, $request->user());
        $this->bindNewsletterAndArtwork($artworkIds, $newsletter, $request->user());


        return new NewsletterResource($newsletter);
    }

    /**
     * Display the specified user.
     *
     * @group Newsletters
     *
     * @queryParam newsletter Newsletter the newsletter to be displayed
     *
     * @param Newsletter $newsletter
     *
     * @return NewsletterResource
     */
    public function show(Newsletter $newsletter)
    {
        if ($newsletter->gallery->id != request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this newsletter.');
        }
        return new NewsletterResource($newsletter);
    }

    /**
     * Update the specified newsletter in storage.
     *
     * @group Newsletters
     *
     * @bodyParam subject string the subject of the newsletter
     * @bodyParam description string a description of the newsletter
     *
     * @queryParam newsletter Newsletter the newsletter to be modified
     *
     * @param NewsletterUpdateRequest $request
     * @param Newsletter $newsletter
     *
     * @return NewsletterResource
     */
    public function update(NewsletterUpdateRequest $request, Newsletter $newsletter)
    {
        if ($newsletter->gallery->id != request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this newsletter.');
        }

        $data = $request->only(['subject', 'description', 'customer_list']);


        if (isset($data['customer_list'])) {
            $customerIds = explode(',', $data['customer_list']);
            $newsletter->customers()->detach();
            $this->bindNewsletterAndCustomer($customerIds, $newsletter, $request->user());
        }

        if (isset($data['artwork_list'])) {
            $artworkIds = explode(',', $data['artwork_list']);
            $newsletter->artworks()->detach();
            $this->bindNewsletterAndArtwork($artworkIds, $newsletter, $request->user());
        }

        $newsletter->update($data);

        return new NewsletterResource($newsletter->refresh());
    }

    /**
     * Remove the specified newsletter from storage.
     *
     * @group Newsletters
     *
     * @queryParam newsletter Newsletter the newsletter to be deleted
     *
     * @param Newsletter $newsletter
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws UnauthorizedException
     */
    public function destroy(Newsletter $newsletter)
    {
        if ($newsletter->gallery->id != request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this newsletter.');
        }
        $newsletter->customers()->detach();
        $newsletter->delete();

        return response()->json(['message' => 'Newsletter deleted.'], 200);
    }

    /**
     * Send the specified newsletter.
     *
     * @group Newsletters
     *
     * @queryParam newsletter Newsletter the newsletter to be sent
     *
     * @param Newsletter $newsletter
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Newsletter $newsletter)
    {
        if ($newsletter->gallery->id != request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this newsletter.');
        }

        foreach ($newsletter->customers()->get() as $customer) {
            Mail::send('email.newsletter', ['customer' => $customer, 'newsletter' => $newsletter], function ($m) use ($customer, $newsletter) {
                $m->to($customer->email, $customer->name)->subject($newsletter->subject);
            });
        }

        return response()->json(['message' => 'Newsletter sent.'], 200);
    }

    /**
     * Preview the specified newsletter.
     *
     * @group Newsletters
     *
     * @queryParam newsletter Newsletter the newsletter to be sent
     *
     * @param Newsletter $newsletter
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function preview(Newsletter $newsletter)
    {
        if ($newsletter->gallery->id != request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this newsletter.');
        }
        $customer = $newsletter->customers()->get()->first();
        $view = View::make('email.newsletter', ['customer' => $customer, 'newsletter' => $newsletter]);

        $html = $view->render();

        return response()->json(['view' => $html], 200);
    }
}
