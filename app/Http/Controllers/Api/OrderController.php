<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\Customer;
use App\Artwork;
use App\User;
use Auth;
use App\Http\Requests\Order\OrderIndexRequest;
use App\Http\Requests\Order\OrderStoreRequest;
use Illuminate\Routing\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Validation\UnauthorizedException;

class OrderController extends Controller
{

    public function index(OrderIndexRequest $request)
    {
        $data = $request->only(['price', 'per_page']);

        $order = $request->user()->orders()
            ->when(isset($data['price']), function ($order) use ($data) {
                return $order->where('price', 'like', '%' . $data['price'] . '%');
            });

        $per_page = 25;
        if (isset($data['per_page'])) {
            $per_page = min(1000, intval($data['per_page']));
        }
        return OrderResource::collection($order->paginate($per_page));
    }


    public function store(OrderStoreRequest $request)
    {
        $data = $request->only(['email', 'first_name', 'last_name', 'phone', 'address', 'country', 'city', 'artwork_id', 'date']);
        $customer = Customer::firstOrNew(['email' => $data['email']],
                    ['first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'country' => $data['country'],
                    'city' => $data['city']]);

        $request->user()->customers()->save($customer);
        $artowrk = Artwork::where('id', '=', $data['artwork_id'])->firstOrFail();

        return new OrderResource(
            $request->user()->orders()->create([
                'customer_id' => $customer->id,
                'artwork_id' => $data['artwork_id'],
                'date' => $data['date']
            ]));

    }


    public function show(Order $order)
    {
        if ($order->user->id !== request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this order.');
        }
        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        if ($order->user_id != request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this order.');
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted.'], 200);
    }}
