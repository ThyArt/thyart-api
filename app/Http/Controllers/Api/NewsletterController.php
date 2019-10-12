<?php


namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Newsletter\NewsletterIndexRequest;
use App\Http\Requests\Newsletter\NewsletterStoreRequest;
use App\Http\Requests\Newsletter\NewsletterUpdateRequest;
use App\Http\Resources\NewsletterResource;
use App\Newsletter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\UnauthorizedException;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the newsletters.
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
            $customer = Customer::find($customerId);
            if (is_null($customer) || ($customer->gallery->id != $user->gallery->id)) {
                $newsletter->customers()->detach();
                $newsletter->delete();
                throw new UnauthorizedException('The Customer doesn\'t exist or doesn\'t belong to you');
            }
            $customer->newsletters()->save($newsletter);
        }
    }

    /**
     * Store a newly created newsletter in storage.
     *
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
        $this->bindNewsletterAndCustomer($customerIds, $newsletter, $request->user());


        return new NewsletterResource($newsletter);
    }

    /**
     * Display the specified user.
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

        $newsletter->update($data);

        return new NewsletterResource($newsletter->refresh());
    }

    /**
     * Remove the specified newsletter from storage.
     *
     * @param Newsletter $newsletter
     *
     * @return \Illuminate\Http\JsonResponse
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
            Mail::send('email.newsletter', ['customer' => $customer, 'newsletter' => $newsletter], function ($m) use ($customer) {
                $m->to($customer->email, $customer->name)->subject('Welcome to ThyArt');
            });
        }

        return response()->json(['message' => 'Newsletter sent.'], 200);
    }
}
