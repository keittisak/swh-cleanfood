<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Counter;
use App\Libraries\Image;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Menu;
use App\Customer;
use DB;
use DataTables;
use App\Course;

class OrderController extends Controller
{
    public function index (Request $request){
        $data = array(
            'pageTitle' => 'Orders',
            'pageSubTitle' => 'ตรวจสอบออเดอร์',
            'shippingZone' => config('shippingZone'),
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
        return view('orders.index', $data);
    }

    public function history (Request $request)
    {
        $data = array(
            'pageTitle' => 'Orders | History',
            'pageSubTitle' => 'ประวัติการสั่งซื้อ',
            'shippingZone' => config('shippingZone'),
        );
        return view('orders.history',$data);
    }

    public function data (Request $request){
        $orders = Order::with(['details', 'created_by_user'])
                    ->whereHas('details', function($q) use ($request){
                        $q->when(isset($request->is_delivery_not_success), function($q) use ($request){
                            return $q->where('status', '!=', 'delivered');
                        });
                    })
                    ->when($request->code, function($q) use ($request){
                        return $q->where('code', $request->code);
                    })
                    ->when($request->type, function($q) use ($request){
                        return $q->where('type', $request->type);
                    })
                    ->when($request->shipping_name, function($q) use ($request){
                        return $q->where('shipping_name', 'like', '%'.$request->shipping_name.'%');
                    })
                    ->when($request->shipping_phone, function($q) use ($request){
                        return $q->where('shipping_phone', 'like', '%'.$request->shipping_phone.'%');
                    })
                    ->when($request->shipping_zone, function($q) use ($request){
                        return $q->where('shipping_zone', $request->shipping_zone);
                    })
                    ->when(isset($request->created_at) && empty($request->code), function($q) use ($request){
                        return $q->whereBetween(DB::raw('date(created_at)'), [$request->created_at[0], $request->created_at[1]]);
                    })
                    ->when(isset($request->status), function($q) use ($request){
                        return $q->where('status', '=', $request->status);
                    });
        return DataTables::of($orders)
            ->editColumn('created_at', function($order) {
                return date('Y-m-d H:i', strtotime($order->created_at));
            })
            ->addColumn('action', function($order) {
                $order->shipping_location_url = base64_encode($order->shipping_location_url);
                return '
                        <button type="button" class="btn btn-info btn-xs btn-show-order" data-order=\''.json_encode($order).'\'><i class="fas fa-list-ul"></i></button>
                        <a href="'.route('orders.edit', $order->id).'" class="btn btn-primary btn-xs"><i class="far fa-edit"></i></a>
                        <button type="button" class="btn btn-danger btn-xs" onclick="deleteAction.deleteRow('.$order->id.')"><i class="fa fa-times"></i></button>';
            })
            ->addColumn('btn_show_details', function($order) {
                $order->shipping_location_url = base64_encode($order->shipping_location_url);
                return '<button type="button" class="btn btn-info btn-xs btn-show-order" data-order=\''.json_encode($order).'\'><i class="fas fa-list-ul"></i></button>';
            })
            ->addColumn('order_json', function($order){
                $order->shipping_location_url = base64_encode($order->shipping_location_url);
                return json_encode($order);
            })
            ->rawColumns(['checkbox','action', 'btn_show_details', 'order_json'])
        ->make(true);
    }
     
    public function create (Request $request){
        $shipping_zone = [];
        foreach(config('shippingZone') as $data){
            $shipping_zone[$data['type']][] = $data;
        }
        usort($shipping_zone['walk_in'], function($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });

        $order = new Order;
        $data = array(
            'pageTitle' => 'Orders | Create',
            'pageSubTitle' => 'สร้างออเดอร์',
            'action' => 'create',
            'products' => Product::with('menus')->get(),
            'shippingZone' => $shipping_zone,
            'courses' => Course::all(),
            'order' => $order,
            'bgStatus' => config('bgStatus'),
            'btnSaveShow' => true
        );
        return view('orders.form', $data);
    }

    public function store (Request $request)
    {
        
        if (isset($request->user()->id)){
            $request->merge(array('created_by' => $request->user()->id));
            $request->merge(array('updated_by' => $request->user()->id));
        }
        if(isset($request->details)){
            $request->merge(array('details' => json_decode($request->details,true)));
        }

        if($request->type !== 'course'){
            $request->request->remove('course_started_at');
            $request->request->remove('course');
        }

        if(isset($request->shipping_zone)){
            $zone = config('shippingZone');
            $request->merge(array('shipping_zone_priority' => $zone[$request->shipping_zone]['priority']));
        }

        $validate = [
            'type' => [
                'in:daily,course'
            ],
            'customer_id' => [
                // 'required',
                // 'integer',
                // 'exists:customers,id'
            ],
            'total_quantity' => [
                'required',
                'numeric',
                'min:1'
            ],
            'total_amount' => [
                'required',
                'numeric',
                'min:1'
            ],
            'packing_charge' => [
                'required',
                'numeric',
                'min:0'
            ],
            'discount' => [
                'numeric',
                'min:0'
            ],
            'shipping_fee' => [
                'numeric',
                'min:0'
            ],
            'net_total_amount' => [
                'required',
                'numeric',
                'min:1'
            ],
            'shipping_zone' => [
                'required',
                'integer',
            ],
            'shipping_zone_priority' => [
                'required',
                'integer',
            ],
            'shipping_location_url' => [
                // 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            ],
            'shipping_phone' => [
                'required',
                'numeric'
            ],
            'shipping_name' => [
                'required',
            ],
            'shipping_address' => [
                'required',
            ],
            'transfer_image' => [
                'mimes:jpeg,bmp,png',
                'max:5000'
            ],
            'status' => [
                'in:order,confirm,cancel'
            ],
            'details' => [
                'required',
                'array'
            ],
            'details.*.quantity' => [
                'required',
                'numeric',
                'min:1'
            ],
            'details.*.total_amount' => [
                'required',
                'numeric',
                'min:0'
            ],
            'details.*.delivered_at' =>[
                'required',
                'date_format:Y-m-d'
            ],
            'course_id' => [
                'numeric',
            ],
            'course_started_at' => [

            ],
            'created_by' =>[
                'integer'
            ],
            'updated_by' => [
                'integer'
            ]
        ];
        $data = array_only($request->all(), array_keys($validate));
        $request->validate($validate);

        try{
            $order = DB::transaction(function() use($request, $data) {
                if(!$request->customer_id){
                    $_request = new Request();
                    $_request->merge([
                        'name' => $data['shipping_name'],
                        'address' => $data['shipping_address'],
                        'phone' => $data['shipping_phone'],
                        'gender' => $request->gender,
                    ]);
                    $customer = (new CustomerController)->store($_request);
                    $customer = json_decode($customer->getContent());
                    $data['customer_id'] = $customer->id;
                }else{
                    $_request = new Request();
                    $_request->merge([
                        'name' => $data['shipping_name'],
                        'address' => $data['shipping_address'],
                        'phone' => $data['shipping_phone'],
                        'gender' => $request->gender,
                    ]);
                    $customer = (new CustomerController)->update($_request, $request->customer_id);
                }

                if($request->hasFile('transfer_image')){
                    $image = new Image();
                    $file = $request->file('transfer_image');
                    $path = 'images/slips/'.date('Ymd');
                    $imageUrl = $image->upload($file, $path);
                    $data['transfer_image'] = $imageUrl;
                }

                $counter = new Counter;
                $data['code'] = $counter->generateCode('so');
                $order = new Order();
                $order = $order->create($data);
                if($request->details){
                    foreach($request->details as $_data){
                        $_data['status'] = 'order';
                        if (isset($request->user()->id)){
                            $_data = array_merge($_data, array("created_by" => $request->user()->id));
                            $_data = array_merge($_data, array("updated_by" => $request->user()->id));
                        }
                        $_data = array_merge($_data, array(
                            'order_id' => $order->id,
                            'delivered_at' => $_data['delivered_at']
                        ));
                        $orderDetail = new OrderDetail();
                        $orderDetail = $orderDetail->create($_data);
                    }
                }
                return $order;
            });
            return response($order,'201');
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()],500);
        }
    }

    public function edit (Request $request, int $id)
    {
        $shipping_zone = [];
        foreach(config('shippingZone') as $data){
            $shipping_zone[$data['type']][] = $data;
        }
        usort($shipping_zone['walk_in'], function($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });

        $order = Order::with(['details','customer'])->findOrFail($id);
        $products = Product::with('menus')->get();
        $menus = [];
        foreach($products as $product){
            $menus[$product->id] = $product->menus;
        }
        $btnSave = false;
        if(OrderDetail::where('order_id',$id)->whereIn('status', ['order','pending'])->count()){
            $btnSave = true;
        }
        $data = array(
            'pageTitle' => 'Orders | Edit',
            'pageSubTitle' => 'แก้ไขออเดอร์',
            'action' => 'edit',
            'products' => $products,
            'menus' => $menus,
            'shippingZone' => $shipping_zone,
            'courses' => Course::all(),
            'order' => $order,
            'bgStatus' => config('bgStatus'),
            'btnSaveShow' => $btnSave
        );
        return view('orders.form', $data);
    }

    public function update (Request $request, int $id)
    {
        if (isset($request->user()->id)){
            $request->merge(array('updated_by' => $request->user()->id));
        }
        if(isset($request->details)){
            $request->merge(array('details' => json_decode($request->details,true)));
        }

        if($request->type !== 'course'){
            $request->request->remove('course_started_at');
            $request->request->remove('course');
        }

        if(isset($request->shipping_zone)){
            $zone = config('shippingZone');
            $request->merge(array('shipping_zone_priority' => $zone[$request->shipping_zone]['priority']));
        }

        $validate = [
            'type' => [
                'in:daily,course'
            ],
            'customer_id' => [
                // 'required',
                // 'integer',
                // 'exists:customers,id'
            ],
            'total_quantity' => [
                'required',
                'numeric',
                'min:1'
            ],
            'total_amount' => [
                'required',
                'numeric',
                'min:1'
            ],
            'packing_charge' => [
                'required',
                'numeric',
                'min:0'
            ],
            'discount' => [
                'numeric',
                'min:0'
            ],
            'shipping_fee' => [
                'numeric',
                'min:0'
            ],
            'net_total_amount' => [
                'required',
                'numeric',
                'min:1'
            ],
            'shipping_zone' => [
                'required',
                'integer',
            ],
            'shipping_zone_priority' => [
                'required',
                'integer',
            ],
            'shipping_location_url' => [
                // 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            ],
            'shipping_phone' => [
                'required',
                'numeric'
            ],
            'shipping_name' => [
                'required',
            ],
            'shipping_address' => [
                'required',
            ],
            'transfer_image' => [
                'mimes:jpeg,bmp,png',
                'max:5000'
            ],
            'status' => [
                'in:order,confirm,cancel'
            ],
            'details' => [
                'required',
                'array'
            ],
            'details.*.quantity' => [
                'required',
                'numeric',
                'min:1'
            ],
            'details.*.total_amount' => [
                'required',
                'numeric',
                'min:0'
            ],
            'details.*.delivered_at' =>[
                'required',
                'date_format:Y-m-d'
            ],
            'course_id' => [
                'numeric',
            ],
            'course_started_at' => [

            ],
            'created_by' =>[
                'integer'
            ],
            'updated_by' => [
                'integer'
            ]
        ];

        
        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        try{
            $order = DB::transaction(function() use($request, $data, $id) {
                $detailIds = array();
                if(!$request->customer_id){
                    $_request = new Request();
                    $_request->merge([
                        'name' => $data['shipping_name'],
                        'address' => $data['shipping_address'],
                        'phone' => $data['shipping_phone'],
                        'gender' => $request->gender,
                    ]);
                    $customer = (new CustomerController)->store($_request);
                    $customer = json_decode($customer->getContent());
                    $data['customer_id'] = $customer->id;
                }else{
                    $_request = new Request();
                    $_request->merge([
                        'name' => $data['shipping_name'],
                        'address' => $data['shipping_address'],
                        'phone' => $data['shipping_phone'],
                        'gender' => $request->gender,
                    ]);
                    $customer = (new CustomerController)->update($_request, $request->customer_id);
                }

                if($request->hasFile('transfer_image')){
                    $image = new Image();
                    $file = $request->file('transfer_image');
                    $path = 'images/slips/'.date('Ymd');
                    $imageUrl = $image->upload($file, $path);
                    $data['transfer_image'] = $imageUrl;
                }


                $order = Order::findOrFail($id);
                $result = $order->update($data);

                if($request->details){
                    foreach($request->details as $_data){
                        if(empty($_data['id'])){
                            $_data['status'] = 'order';
                            if($order->status == 'confirm'){
                                $_data['status'] = 'pending';
                            }
                            if (isset($request->user()->id)){
                                $_data = array_merge($_data, array("created_by" => $request->user()->id));
                                $_data = array_merge($_data, array("updated_by" => $request->user()->id));
                            }
                            $_data = array_merge($_data, array(
                                'order_id' => $order->id,
                                'delivered_at' => $_data['delivered_at']
                            ));
                            $orderDetail = new OrderDetail();
                            $orderDetail = $orderDetail->create($_data);
                            $detailIds[] = $orderDetail->id;
                        }else{
                            if (isset($request->user()->id)){
                                $_data = array_merge($_data, array("updated_by" => $request->user()->id));
                            }
                            $_data = array_merge($_data, array(
                                'delivered_at' => $_data['delivered_at']
                            ));
                            $orderdetail = OrderDetail::find($_data['id']);
                            if(in_array($orderdetail->status, ['order', 'pending'])){
                                $_result = $orderdetail->update($_data);
                            }
                            $detailIds[] = $_data['id'];
                            
                        }
                    }

                    //delete
                    $orderDetails = $order->details()->whereNotIn('id', $detailIds);
                    $orderDetails->forceDelete();
                }
                return $order;
            });
            return response($order);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()],500);
        }
    }

    public function changeStatus (Request $request, int $id)
    {

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
                'in:order,confirm'
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
                    $order = Order::with('details')->findOrFail($id);
                    $order->update($data);
                    if($request->status === 'confirm'){
                        foreach($order->details as $detail){
                            $_request = new Request();
                            $_request->merge([
                                'status' => 'pending'
                            ]);
                            (new OrderDetailController)->changeStatus($_request, $detail->id);
                        }
                    }
                }
            });
            return response()->json(["message" => "Orders is updated success."], 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],500);
        }
    }

    public function destroy(Request $request, int $id){
        DB::transaction(function() use($request, $id) {
            $order = Order::findOrFail($id);
            $orderDetails = $order->details();
            if($request->user()->id){
                $order->updated_by = $request->user()->id;
            }
            $orderDetails->delete();
            $order->delete();
        });
        return response('','204');
        // return reponse('test',200);
    }
    
}
