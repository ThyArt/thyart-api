<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ArtworkNotAvailableException;
use App\Order;
use App\Artwork;
use App\Http\Requests\Order\OrderIndexRequest;
use App\Http\Requests\Order\OrderStoreRequest;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderDetailResource;
use Illuminate\Validation\UnauthorizedException;

class OrderController extends Controller
{
    public function index(OrderIndexRequest $request)
    {
        $data = $request->only(['customer_id', 'artwork_id', 'date', 'per_page']);

        $order = $request->user()->orders()
            ->when(isset($data['customer_id']), function ($order) use ($data) {
                return $order->where('customer_id', 'like', '%' . $data['customer_id'] . '%');
            })
            ->when(isset($data['artwork_id']), function ($order) use ($data) {
                return $order->where('artwork_id', 'like', '%' . $data['artwork_id'] . '%');
            })
            ->when(isset($data['date']), function ($order) use ($data) {
                return $order->where('date', 'like', '%' . $data['date'] . '%');
            });

        $per_page = 25;
        if (isset($data['per_page'])) {
            $per_page = min(1000, intval($data['per_page']));
        }
        return OrderResource::collection($order->paginate($per_page));
    }


    /**
     * @param OrderStoreRequest $request
     * @return OrderResource
     * @throws ArtworkNotAvailableException
     */
    public function store(OrderStoreRequest $request)
    {
        $user = $request->user();

        $data = $request->only(['email', 'first_name', 'last_name', 'phone', 'address', 'country', 'city', 'artwork_id', 'date']);

        $artwork =  $user->artworks()->findOrFail($data['artwork_id']);
        if ($artwork->order) {
            abort(400, "An Order with this artwork already exists.");
        }

        $customer = $user->customers()->firstOrNew(
            ['email' => $data['email']],
            ['first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'country' => $data['country'],
                    'city' => $data['city']]
        );

        $customer->save();

        $artwork->state = Artwork::STATE_SOLD;
        $artwork->save();

        return new OrderResource(
            $request->user()->orders()->create([
                'customer_id' => $customer->id,
                'artwork_id' => $artwork->id,
                'date' => Carbon::createFromFormat('Y-m-d', $data['date'])
            ])
        );
    }


    public function show(Order $order)
    {
        if ($order->user->id !== request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this order.');
        }
        return new OrderDetailResource($order);
    }

    public function destroy(Order $order)
    {
        if ($order->user_id != request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this order.');
        }

        $order->artwork->state = Artwork::STATE_IN_STOCK;
        $order->artwork->save();

        $order->delete();

        return response()->json(['message' => 'Order deleted.'], 200);
    }
}
