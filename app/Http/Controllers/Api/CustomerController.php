<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use Illuminate\Routing\Controller;
use App\Http\Resources\CustomerResource;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $data = request(['email', 'phone', 'first_name', 'last_name', 'per_page', 'country', 'city', 'address']);

        $valid = validator($data, ['per_page' => 'integer']);

        if ($valid->fails()) {
            throw new ValidationException($valid);
        }

        $customer = request()->user()->customers()->when(isset($data['first_name']), function ($customer) use ($data) {
            return $customer->where('first_name', 'like', '%' . $data['first_name'] . '%');
        })
            ->when(isset($data['last_name']), function ($customer) use ($data) {
                return $customer->where('last_name', 'like', '%' . $data['last_name'] . '%');
            })
            ->when(isset($data['email']), function ($customer) use ($data) {
                return $customer->where('email', 'like', '%' . $data['email'] . '%');
            })
            ->when(isset($data['phone']), function ($customer) use ($data) {
                return $customer->where('phone', 'like', '%' . $data['phone'] . '%');
            })
            ->when(isset($data['address']), function ($customer) use ($data) {
                return $customer->where('address', 'like', '%' . $data['address'] . '%');
            })
            ->when(isset($data['country']), function ($customer) use ($data) {
                return $customer->where('country', 'like', '%' . $data['country'] . '%');
            })
            ->when(isset($data['city']), function ($customer) use ($data) {
                return $customer->where('city', 'like', '%' . $data['city'] . '%');
            });

        $per_page = 25;
        if (isset($data['per_page'])) {
            $per_page = min(1000, intval($data['per_page']));
        }

        return CustomerResource::collection($customer->paginate($per_page));
    }

    /**
     * Store a newly created customer in storage.
     *
     * @return CustomerResource
     */
    public function store()
    {
        $data = request(['email', 'first_name', 'last_name', 'phone', 'country', 'city', 'address']);

        $valid = validator(
            $data,
            [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|string|max:255',
                'phone' => 'required|phone:FR',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'country' => 'required|string|max:255',
            ]
        );

        if ($valid->fails()) {
            throw new ValidationException($valid);
        }

        return new CustomerResource(request()->user()->customers()->create($data));
        ;
    }

    /**
     * Display the specified user.
     *
     * @param Customer $customer
     *
     * @return CustomerResource
     */
    public function show(Customer $customer)
    {
        if ($customer->user_id != request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this customer.');
        }
        return new CustomerResource($customer);
    }

    /**
     * Update the specified customer in storage.
     *
     * @param Customer $customer
     * @return CustomerResource
     */
    public function update(Customer $customer)
    {
        if ($customer->user_id !== request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this customer.');
        }

        $data = request(['email', 'first_name', 'last_name', 'phone', 'country', 'city', 'address']);

        $valid = validator($data, [
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'string|email|max:255',
            'phone' => 'phone:FR',
            'address' => 'string|max:255',
            'city' => 'string|max:255',
            'country' => 'string|max:255',
        ]);

        if ($valid->fails()) {
            throw new ValidationException($valid);
        }

        $customer->update($data);

        return new CustomerResource($customer->refresh());
    }

    /**
     * Remove the specified customer from storage.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Customer $customer)
    {
        if ($customer->user_id != request()->user()->id) {
            throw new UnauthorizedException('The current user does not own this customer.');
        }

        $customer->delete();

        return response()->json(['message' => 'Customer deleted.'], 200);
    }
}
