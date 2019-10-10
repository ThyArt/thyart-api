<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Requests\Customer\CustomerIndexRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Http\Requests\Customer\CustomerStoreRequest;
use Illuminate\Routing\Controller;
use App\Http\Resources\CustomerResource;
use Illuminate\Validation\UnauthorizedException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @group Customers
     *
     * @bodyParam email string the customer's email address
     * @bodyParam phone string the customer's phone number
     * @bodyParam first_name string the customer's first name
     * @bodyParam last_name string the customer's last name
     * @bodyParam per_page_name int the number of customer's to be displayed per page
     * @bodyParam country string the customer's country of residence
     * @bodyParam city string the customer's city of residence
     * @bodyParam address string the customer's address
     *
     * @param CustomerIndexRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(CustomerIndexRequest $request)
    {
        $data = $request->only(['email', 'phone', 'first_name', 'last_name', 'per_page', 'country', 'city', 'address']);

        $customer = $request->user()->gallery->customers()
            ->when(isset($data['first_name']), function ($customer) use ($data) {
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
     * @group Customers
     *
     * @bodyParam email string the customer's email address
     * @bodyParam phone string the customer's phone number
     * @bodyParam first_name string the customer's first name
     * @bodyParam last_name string the customer's last name
     * @bodyParam country string the customer's country of residence
     * @bodyParam city string the customer's city of residence
     * @bodyParam address string the customer's address
     *
     * @return CustomerResource
     */
    public function store(CustomerStoreRequest $request)
    {
        return new CustomerResource(
            $request->user()->gallery->customers()->create(
                $request->only(['email', 'first_name', 'last_name', 'phone', 'country', 'city', 'address'])
            )
        );
    }

    /**
     * Display the specified user.
     *
     * @group Customers
     *
     * @queryParam customer Customer the customer to be displayed
     *
     * @param Customer $customer
     *
     * @return CustomerResource
     */
    public function show(Customer $customer)
    {
        if ($customer->gallery->id != request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this customer.');
        }
        return new CustomerResource($customer);
    }

    /**
     * Update the specified customer in storage.
     *
     * @group Customers
     *
     * @bodyParam email string the customer's email address
     * @bodyParam phone string the customer's phone number
     * @bodyParam first_name string the customer's first name
     * @bodyParam last_name string the customer's last name
     * @bodyParam per_page_name int the number of customer's to be displayed per page
     * @bodyParam country string the customer's country of residence
     * @bodyParam city string the customer's city of residence
     * @bodyParam address string the customer's address
     *
     * @queryParam customer Customer the customer to be modified
     *
     * @param CustomerUpdateRequest $request
     * @param Customer $customer
     *
     * @return CustomerResource
     */
    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        if ($customer->gallery->id != request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this customer.');
        }

        $data = $request->only(['email', 'first_name', 'last_name', 'phone', 'country', 'city', 'address']);

        $customer->update($data);

        return new CustomerResource($customer->refresh());
    }

    /**
     * Remove the specified customer from storage.
     *
     * @group Customers
     *
     * @queryParam customer Customer the customer to be deleted
     *
     * @param Customer $customer
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws UnauthorizedException
     */
    public function destroy(Customer $customer)
    {
        if ($customer->gallery->id != request()->user()->gallery->id) {
            throw new UnauthorizedException('The current gallery does not own this customer.');
        }

        $customer->delete();

        return response()->json(['message' => 'Customer deleted.'], 200);
    }
}
