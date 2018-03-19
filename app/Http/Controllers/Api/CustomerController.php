<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use Illuminate\Routing\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        $data = request(['name', 'email', 'phone', 'firstname', 'lastname', 'all']);
        $user = User::when(isset($data['all']), function ($user) use ($data) {
            return $user->where('name', 'like', '%'.$data['all'].'%')
                ->orWhere('email', 'like', '%'.$data['all'].'%');
        })
            ->when(isset($data['name']), function ($user) use ($data) {
                return $user->orWhere('name', 'like', '%'.$data['name'].'%');
            })
            ->when(isset($data['email']), function ($user) use ($data) {
                return $user->orWhere('email', 'like', '%' . $data['email'] . '%');
            });
        return $user->get();
    }
}
