<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use App\User;
use App\Product;
use DB;
use DataTables;

class ReportController extends Controller
{
    public function sales (Request $request)
    {
        $data = array(
            'pageTitle' => 'Reports | Sales',
            'pageSubTitle' => 'รายงานการขาย',
            'users' => User::get()
        );
        return view('reports.sales', $data);
    }

    public function salesData (Request $request)
    {
        $results = Order::select([
            DB::raw('SUM(total_amount) as total_amount'),
            DB::raw('SUM(packing_charge) as packing_charge'),
            DB::raw('SUM(discount) as discount'),
            DB::raw('SUM(shipping_fee) as shipping_fee'),
            DB::raw('SUM(net_total_amount) as net_total_amount'),
            DB::raw('SUM(total_quantity) as total_quantity'),
            'created_at',
        ])
        ->when(isset($request->status) && $request->status !== 'all', function($q) use ($request){
            return $q->where('status', $request->status);
        })
        ->when(isset($request->created_by) && $request->created_by !== 'all', function($q) use ($request){
            return $q->where('created_by', $request->created_by);
        })
        ->when(isset($request->created_at), function ($query) use ($request) {
            return $query->whereBetween(DB::raw('date(created_at)'), [$request->created_at[0], $request->created_at[1]]);
        })
        ->groupBy(DB::raw('DATE(created_at)'));

        return DataTables::of($results)
        ->editColumn('created_at', function($result) {
            return date('Y-m-d', strtotime($result->created_at));
        })
        ->make(true);
    }

    public function products (Request $request)
    {
        $data = array(
            'pageTitle' => 'Reports | Products',
            'pageSubTitle' => 'รายงานการขายอาหาร',
            'users' => User::get()
        );
        return view('reports.products', $data);
    }

    public function productData (Request $request)
    {
        $results = OrderDetail::select([
            'order_id',
            'type',
            'product_id',
            'name',
            'menu_id',
            'menu_name',
            DB::raw('SUM(quantity) as quantity'),
            DB::raw('SUM(total_amount) as total_amount'),
        ])
        ->with(['order'])
        ->whereHas('order', function($q) use ($request){
            $q->when(isset($request->status) && $request->status !== 'all', function($q) use ($request){
                return $q->where('status', $request->status);
            })
            ->when(isset($request->created_by) && $request->created_by !== 'all', function($q) use ($request){
                return $q->where('created_by', $request->created_by);
            })
            ->when(isset($request->created_at), function ($query) use ($request) {
                return $query->whereBetween(DB::raw('date(created_at)'), [$request->created_at[0], $request->created_at[1]]);
            });
        })
        ->when(isset($request->delivered_at), function ($query) use ($request) {
            return $query->whereBetween(DB::raw('date(delivered_at)'), [$request->delivered_at[0], $request->delivered_at[1]]);
        })
        ->groupBy('product_id', 'menu_id')
        ->orderBy('product_id', 'asc');

        return DataTables::of($results)
        ->make(true);
    }

    public function endCourseData (Request $request)
    {
        $result = Order::select([
            'orders.id as order_id',
            'orders.code',
            'orders.shipping_name',
            'orders.shipping_phone',
            'orders.course_started_at',
            'order_details.delivered_at',
            'order_details.status'
        ])
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->where('order_details.status', '<>', 'delivered')
        ->where('orders.type', 'course')
        // ->where('orders.id', 4)
        ->groupBy('order_details.delivered_at', 'orders.code')
        ->get();
        
        
        $set_data = [];
        foreach($result->toArray() as $data){
            if(!isset($set_data[$data['order_id']])){
                $set_data[$data['order_id']] = $data;
            }

            $set_data[$data['order_id']]['end_course'] = $data['delivered_at'];     
            $set_data[$data['order_id']]['date_remain'][] = $data['delivered_at'];
        }

        $data = array(
            'pageTitle' => 'Reports | End Course',
            'pageSubTitle' => 'รายงานวันครบกำหนดคอร์ส',
            'datas' => $set_data
        );
        return view('reports.end_course', $data);

    }

}
