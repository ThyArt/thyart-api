<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Stat\StatRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatController extends Controller
{

    /**
     * @param StatRequest $request
     *
     * @return void
     */
    public function process(StatRequest $request)
    {
        $data = $request->only(['email']);

        $user = $request->user();
        print($user->firstname);
        $orders = User::with('orders', ['price', 'date'])->get();

    }
}
