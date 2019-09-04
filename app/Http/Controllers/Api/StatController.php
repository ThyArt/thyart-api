<?php

namespace App\Http\Controllers\Api;

use App\Artwork;
use App\Http\Requests\Stat\StatRequest;
use App\User;
use App\Http\Resources\StatResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class StatController extends Controller
{

    /**
     * @param StatRequest $request
     *
     * @return array
     */

    public function process(StatRequest $request)
    {
        $userdata = User::with('orders')->get();

        $orders = $userdata[0]->orders;

        $artwork_ids = [];

        foreach ($orders as $order) {
            array_push($artwork_ids, $order->artwork_id);
        }

        $artworks = Artwork::findMany($artwork_ids);

        $now = Carbon::now();
        $day = $now->subDay();
        $now = Carbon::now();
        $week = $now->subWeek();
        $now = Carbon::now();
        $month = $now->subMonth();
        $now = Carbon::now();
        $trimester = $now->subMonths(3);
        $now = Carbon::now();
        $semester = $now->subMonths(6);
        $now = Carbon::now();
        $year = $now->subYear(1);
        $now = Carbon::now();

        $ar = array([
            "daily" => (function () use ($artworks, $orders, $now, $day) {
                $total = 0;
                foreach ($orders as $order) {
                    if (Carbon::createFromTimeString($order->date)->between($now, $day)) {
                        $total += $artworks->find($order->artwork_id)->price;
                    }
                }
                return $total;
            })(),
            "weekly" => (function () use ($artworks, $orders, $now, $week) {
                $total = 0;
                foreach ($orders as $order) {
                    if (Carbon::createFromTimeString($order->date)->between($now, $week)) {
                        $total += $artworks->find($order->artwork_id)->price;
                    }
                }
                return $total;
            })(),
            "monthly" => (function () use ($artworks, $orders, $now, $month) {
                $total = 0;
                foreach ($orders as $order) {
                    if (Carbon::createFromTimeString($order->date)->between($now, $month)) {
                        $total += $artworks->find($order->artwork_id)->price;
                    }
                }
                return $total;
            })(),
            "trimester" => (function () use ($artworks, $orders, $now, $trimester) {
                $total = 0;
                foreach ($orders as $order) {
                    if (Carbon::createFromTimeString($order->date)->between($now, $trimester)) {
                        $total += $artworks->find($order->artwork_id)->price;
                    }
                }
                return $total;
            })(),
            "semester" => (function () use ($artworks, $orders, $now, $semester) {
                $total = 0;
                foreach ($orders as $order) {
                    if (Carbon::createFromTimeString($order->date)->between($now, $semester)) {
                        $total += $artworks->find($order->artwork_id)->price;
                    }
                }
                return $total;
            })(),
            "yearly" => (function () use ($artworks, $orders, $now, $year) {
                $total = 0;
                foreach ($orders as $order) {
                    if (Carbon::createFromTimeString($order->date)->between($now, $year)) {
                        $total += $artworks->find($order->artwork_id)->price;
                    }
                }
                return $total;
            })()
        ]);
        return ($ar);
    }
}
