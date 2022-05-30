<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Libraries\Counter;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Menu;
use App\Customer;
use DB;
use DataTables;
use Carbon\Carbon;

class OrderDetailController extends Controller
{
    public function index (Request $request)
    {
        $data = array(
            'pageTitle' => 'Orders | Details',
            'pageSubTitle' => 'ตรวจสอบรายการอาหาร',
            'shippingZone' => config('shippingZone'),
            'total_quantity' => OrderDetail::select(DB::raw('SUM(quantity) as quantity'))
                                    ->where('status', 'pending')
                                    ->first()->quantity,
            'total_product_menu' => OrderDetail::where('status', 'pending')
                                    ->groupBy('product_id', 'menu_id')
                                    ->get()->count(),
        );
        $data['total_quantity'] = ($data['total_quantity'])?$data['total_quantity']:0;
        return view('order_details.index', $data);
    }

    public function confirm (Request $request)
    {
        $data = array(
            'pageTitle' => 'Orders | Details',
            'pageSubTitle' => 'การจัดการอาหาร',
            'shippingZone' => config('shippingZone'),
            'total_quantity' => OrderDetail::select(DB::raw('SUM(quantity) as quantity'))
                                    ->where('status', 'confirm')
                                    ->first()->quantity,
            'total_product_menu' => OrderDetail::where('status', 'confirm')
                                    ->groupBy(['product_id', 'menu_id'])
                                    ->get()->count(),
        );
        $data['total_quantity'] = ($data['total_quantity'])?$data['total_quantity']:0;
        return view('order_details.confirm', $data);
    }

    public function data (Request $request)
    {
        $carbon = new Carbon(); 
        $details = OrderDetail::with(['order','created_by_user'])
                ->whereHas('order', function($q) use ($request){
                    $q->where('status', '=', 'confirm')
                    ->when(isset($request->shipping_zone) && $request->shipping_zone !== 'all', function($q) use ($request){
                        return $q->where('shipping_zone', $request->shipping_zone);
                    });
                })
                ->when(isset($request->status), function($q) use ($request){
                    return $q->where('status', $request->status);
                })
                ->when(isset($request->delivered_at), function($q) use ($request,$carbon){
                    return $q->whereDate('delivered_at', $request->delivered_at);
                });
        return DataTables::of($details)
        // ->editColumn('delivered_at', function($detail) {
        //     return date('Y-m-d', strtotime($detail->delivered_at));
        // })
        ->addColumn('action', function($detail) {
            return '
                    <a href="'.route('orders.edit', $detail->order_id).'" class="btn btn-warning btn-xs"><i class="far fa-edit"></i></a>';
        })
        ->rawColumns(['checkbox','action'])
    ->make(true);
    }

    public function changeStatus (Request $request, int $id)
    {
        if (isset($request->user()->id)){
            $request->merge(array('updated_by' => $request->user()->id));
        }

        $validate = [
            'status' => [
                'required',
                'in:order,pending,confirm,delivered,cancel'
            ],
            'updated_by' => [
                'integer'
            ]
        ];
        $request->validate($validate);
        $data = array_only($request->all(), ['status', 'updated_by']);
        try{
            $order = DB::transaction(function() use($request, $data, $id) {
                $detail = OrderDetail::findOrFail($id);
                $detail->update($data);
            });
            return response()->json(["message" => "Detail is updated success."], 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],500);
        }
    }

    public function changeStatusBatch (Request $request)
    {
        if (isset($request->user()->id)){
            $request->merge(array('updated_by' => $request->user()->id));
        }

        $validate = [
            'ids' => [
                'required',
                'array'
            ],
            'status' => [
                'required',
                'in:order,pending,confirm,delivered'
            ],
            'updated_by' => [
                'integer'
            ]
        ];

        $request->validate($validate);
        $data = array_only($request->all(), ['status', 'updated_by']);
        try{
            $order = DB::transaction(function() use($request, $data) {
                foreach($request->ids as $id){
                    $order = OrderDetail::findOrFail($id);
                    $order->update($data);
                }
            });
            return response()->json(["message" => "Detail is updated success."], 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],500);
        }
    }

    public function listsPrint (Request $request)
    {
        $details = OrderDetail::select([
                        'order_id',
                        'order_details.type',
                        'product_id',
                        'name',
                        'menu_id',
                        'menu_name',
                        DB::raw('SUM(quantity) as quantity'),
                        'remark',
                        'shipping_zone',
                        'shipping_zone_priority',
                        'packing_charge'
                    ])
                    ->join('orders', 'order_id', '=', 'orders.id')
                    ->whereIn('order_details.id', $request->ids)
                    ->when(isset($request->status), function($q) use ($request){
                        return $q->where('order_details.status', $request->status);
                    })
                    ->groupBy('product_id', 'menu_id', 'remark', 'packing_charge', 'shipping_zone')
                    ->orderBy('shipping_zone_priority', 'asc')
                    ->orderBy('product_id', 'asc')
                    ->orderBy('packing_charge', 'asc')
                    ->get();
        $data = array(
            'shippingZone' => config('shippingZone'),
            'details' => $details
        );
        return view('order_details.lists_print', $data);
    }

    public function labelPrint(Request $request)
    {
        $details = OrderDetail::with('order')
            ->whereIn('order_details.id', $request->ids)
            ->when(isset($request->status), function($q) use ($request){
                return $q->where('order_details.status', $request->status);
            })
            ->get();

        $orders = [];
        foreach($details as $index => $data){
            $orders[$data->order_id]['order'] = $data->order;
            $orders[$data->order_id]['details'][$index] = $data;
        }

        $data = array(
        'shippingZone' => config('shippingZone'),
        'orders' => $orders
        );
        return view('order_details.label_print', $data);
    }
}
