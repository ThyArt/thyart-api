<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use Illuminate\Routing\Controller;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['store']);
    }

    public function index()
    {
        $data = request(['email', 'phone', 'firstname', 'lastname', 'per_page', 'country', 'city', 'address']);
        $customer = request()->user()->customers()->when(isset($data['firstname']), function ($customer) use ($data) {
                return $customer->where('firstname', 'like', '%' . $data['firstname'] . '%');
            })
            ->when(isset($data['lastname']), function ($customer) use ($data) {
                return $customer->where('lastname', 'like', '%' . $data['lastname'] . '%');
            })
            ->when(isset($data['email']), function ($customer) use ($data) {
                return $customer->where('email', 'like', '%' . $data['email'] . '%');
            })
            ->when(isset($data['phone']), function ($customer) use ($data) {
                return $customer->where('phone', 'like', '%' . $data['phone'] . '%');
            })
            ->when(isset($data['address']), function ($customer) use ($data) {
                return $customer->where('address', 'like', '%' . $data['country'] . '%');
            })
            ->when(isset($data['country']), function ($customer) use ($data) {
                return $customer->where('country', 'like', '%' . $data['country'] . '%');
            })
            ->when(isset($data['city']), function ($customer) use ($data) {
                return $customer->where('city', 'like', '%' . $data['city'] . '%');
            });

        $per_page = 25;
        if (isset($data['per_page'])) {
            $per_page = min(1000, $data['per_page']);
        }
        return CustomerResource::collection($customer->paginate($per_page));
    }

    public function store()
    {
        $data = request(['email', 'firstname', 'lastname', 'phone', 'country', 'city']);
        $valid = validator(
            $data,
            [
                'firstname' => 'required|string|max:255',
                'lastnamename' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone' => 'phone',
                'address' => 'string|max:255',
                'country' => 'string|max:255',
                'city' => 'string|max:255',
            ]
        );

        if ($valid->fails()) {
            return response()->json($valid->errors()->all(), 400);
        }

        return new CustomerResource(Customer::create(
            [
                'user_id' => request()->user()->id(),
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'country' => $data['country'],
                'city' => $data['city'],
            ]
        ));
    }

    public function show(Customer $customer)
    {
        if ($customer->user_id != request()->user()->id)
            return response()->json(['message' => 'Customer not found.'], 404);
        return new CustomerResource($customer);
    }

    public function update(Customer $customer)
    {
        $data = request(['email', 'firstname', 'lastname', 'phone', 'country', 'city']);
        $valid = validator(
            $data,
            [
                'firstname' => 'string|max:255',
                'lastnamename' => 'string|max:255',
                'email' => 'string|email|max:255',
                'phone' => 'phone',
                'address' => 'string|max:255',
                'country' => 'string|max:255',
                'city' => 'string|max:255',
            ]
        );

        if ($valid->fails()) {
            return response()->json($valid->errors()->all(), 400);
        }

        if (isset($data['firstname'])) {
            $customer->firstname = $data['firstname'];
        }
        if (isset($data['lastname'])) {
            $customer->lastname = $data['lastname'];
        }
        if (isset($data['email'])) {
            $customer->email = $data['email'];
        }
        if (isset($data['phone'])) {
            $customer->phone = $data['phone'];
        }
        if (isset($data['address'])) {
            $customer->address = $data['address'];
        }
        if (isset($data['country'])) {
            $customer->country = $data['country'];
        }
        if (isset($data['address'])) {
            $customer->city = $data['city'];
        }

        $customer->save();

        return new CustomerResource($customer->refresh());
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json(['message' => 'Customer deleted.'], 200);
    }
}