<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard (Request $request){
        $carbon = new Carbon;
        $today = $carbon->now();
        $lastday = $carbon->now()->subMonth();

        $thisMonth = Order::select([
                        DB::raw('COUNT(*) as total_order'),
                        DB::raw('SUM(total_quantity) as total_quantity'),
                        DB::raw('SUM(net_total_amount) as net_total_amount')
                    ])
                    ->whereMonth('created_at', '=', $today->format('m'))
                    ->whereYear('created_at', '=', $today->format('Y'))
                    ->where('status', '=', 'confirm')
                    ->first();

        $lastMonth = Order::select([
                        DB::raw('COUNT(*) as total_order'),
                        DB::raw('SUM(total_quantity) as total_quantity'),
                        DB::raw('COUNT(*) as total_order'),
                        DB::raw('SUM(net_total_amount) as net_total_amount')
                    ])
                    ->whereMonth('created_at', '=', $lastday->format('m'))
                    ->whereYear('created_at', '=', $lastday->format('Y'))
                    ->where('status', '=', 'confirm')
                    ->first();

        $productThisMonth = Order::select([
                                'order_id',
                                'product_id',
                                'name',
                                'menu_id',
                                'menu_name',
                                DB::raw('SUM(quantity) as quantity')
                            ])
                            ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_id')
                            ->whereMonth('orders.created_at', '=', $today->format('m'))
                            ->whereYear('orders.created_at', '=', $today->format('Y'))
                            // ->where('orders.status', '=', 'confirm')
                            ->groupBy(['product_id', 'menu_id'])
                            ->orderBy('quantity', 'desc')
                            ->get();

        $productLastMonth = Order::select([
                            'order_id',
                            'product_id',
                            'name',
                            'menu_id',
                            'menu_name',
                            DB::raw('SUM(quantity) as quantity')
                        ])
                        ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_id')
                        ->whereMonth('orders.created_at', '=', $lastday->format('m'))
                        ->whereYear('orders.created_at', '=', $lastday->format('Y'))
                        // ->where('orders.status', '=', 'confirm')
                        ->groupBy(['product_id', 'menu_id'])
                        ->orderBy('quantity', 'desc')
                        ->get();

        $data = array(
            'thisMonth' => [
                'totalOrder' => ($thisMonth->total_order)?$thisMonth->total_order:0,
                'totalQuantity' => ($thisMonth->total_quantity)?$thisMonth->total_quantity:0,
                'netTotalAmount' => ($thisMonth->net_total_amount)?$thisMonth->net_total_amount:0,
                'products' => $productThisMonth,
            ],
            'lastMonth' => [
                'totalOrder' => ($lastMonth->total_order)?$lastMonth->total_order:0,
                'totalQuantity' => ($lastMonth->total_quantity)?$lastMonth->total_quantity:0,
                'netTotalAmount' => ($lastMonth->net_total_amount)?$lastMonth->net_total_amount:0,
                'products' => $productLastMonth
            ]
        );
        return view('dashboard', $data);
    }   

    public function widgetOrder (Request $request)
    {
        $data = array(
            'total_order' => Order::where('status', 'order')->get()->count(),
            'net_total_amount' => Order::select(DB::raw('SUM(net_total_amount) as net_total_amount'))->where('status', 'order')->first()->net_total_amount,
            'total_quantity' => Order::select(DB::raw('SUM(total_quantity) as total_quantity'))->where('status', 'order')->first()->total_quantity,
            'total_product_menu' => Order::leftJoin('order_details','orders.id', '=', 'order_details.order_id')
                                        ->where('orders.status', 'order')           
                                        ->groupBy(['product_id', 'menu_id'])
                                        ->get()->count()
        );
        $data['net_total_amount'] = ($data['net_total_amount'])?$data['net_total_amount']:0;
        $data['total_quantity'] = ($data['total_quantity'])?$data['total_quantity']:0;
        return $data;
    }

    public function widgetDetail (Request $request)
    {
        $data = array(
            'total_quantity' => OrderDetail::select(DB::raw('SUM(quantity) as quantity'))
                                    ->when(isset($request->status), function($q) use ($request){
                                        return $q->where('status', $request->status);
                                    })
                                    ->first()->quantity,
            'total_product_men' => OrderDetail::when(isset($request->status), function($q) use ($request){
                                        return $q->where('status', $request->status);
                                    })
                                    ->groupBy(['product_id', 'menu_id'])
                                    ->get()->count(),
        );
        $data['total_quantity'] = ($data['total_quantity'])?$data['total_quantity']:0;
        return $data;
    }
}
