@extends('layouts.main')
@section('title', $pageTitle)

@section('css')
    <style>
        .select2-container .select2-selection--single .select2-selection__rendered {
            display:inline;
        }
        .product-list{
            margin-bottom:5px
        }
        .item-no{
            font-size:16px
        }
        .hr_border{
            /*border-top: 4px solid rgba(0,0,0,.1);*/
            border-top: 3px solid #000;
            margin-bottom: 2rem;
        }
    </style>
@endsection

@section('content')
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>{{ $pageSubTitle }}</h1>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('orders.index')}}">{{ __('ออเดอร์') }}</a></li>
                    <li class="breadcrumb-item active">{{ $pageSubTitle }}</li>
                </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <form id="form-content" method="post" action="#" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="post">
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">ประเภทการขาย</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 offset-md-3 col-12">
                                    <p>{{ strtoupper($order->code) }}</p>
                                    <div class="row">
                                        <div class="col-md-2 col-4">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="type" value="daily" checked> รายวัน
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-4">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="type" value="course"> คอร์ส
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="display-course" style="display:none">
                                <div class="col-md-8 offset-md-3 col-12">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="form-group">
                                                <label>วันที่เริ่มคอร์ส</label>
                                                <input class="form-control form-control-sm" type="text" name="course_started_at" value="{{ ($order->course_started_at)?$order->course_started_at:date('Y-m-d') }}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            
                                            <label>เมนูคอร์ส</label>
                                            <div class="form-group">
                                            @foreach($courses as $course)
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="course_id" value="{{$course->id}}" data-items='{!! $course->items !!}' {{ ($action === 'edit' && $order->course_id)?($order->course_id == $course->id)?'checked':'':'' }}> {{$course->name}}
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">ลูกค้า</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 offset-md-3 col-12">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="form-group">
                                                <label for="shipping_phone">เบอร์โทรศัพท์</label>
                                                <div class="input-group">
                                                    <input type="text" name="shipping_phone" id="shipping_phone" class="form-control number-only" autocomplete="off" value="{{($action === 'edit')?$order->shipping_phone:''}}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger" id="btn-search-phone"><i class="fas fa-search"></i> ค้นหา</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="shipping_name">ชื่อลูกค้า</label>
                                                        <input type="text" name="shipping_name" id="shipping_name" class="form-control" autocomplete="off" value="{{($action === 'edit')?$order->shipping_name:''}}">
                                                        <input type="hidden" name="customer_id" value="{{($action === 'edit')?$order->customer_id:''}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-4">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="gender" value="male" {{($action === 'edit')?($order->customer->gender === 'male')?'checked':'':'checked'}}> ผู้ชาย
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-4">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="gender" value="female" {{($action === 'edit')?($order->customer->gender === 'female')?'checked':'':''}}> ผู้หญิง
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="shipping_address">ที่อยู่</label>
                                                <textarea class="form-control" rows="3" name="shipping_address" id="shipping_address">{{ ($action === 'edit')?$order->shipping_address:'' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">โซนการจัดส่ง</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 offset-md-3 col-12">
                                    <div class="form-group">
                                        <label for="shipping_location_url">ลิ้งค์ที่สถานที่จัดส่ง Google Map</label>
                                        <input type="text" name="shipping_location_url" id="shipping_location_url" class="form-control" autocomplete="off" value="{{($action === 'edit')?$order->shipping_location_url:''}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 offset-md-3 col-12">
                                    <div class="row">
                                        <div class="col-12">

                                            @foreach($shippingZone['on_demand'] as $data)
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="shipping_zone" value="{{$data['id']}}" {{ ($action === 'edit' && $order->shipping_zone === $data['id'])?'checked':'' }}>
                                                        <span>{{$data['title']}}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 offset-md-3 col-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="shipping_zone" value="walkin" {{ ($action === 'edit' &&  in_array($order->shipping_zone,[6,7,8,9,10,11,12,13,14,15]))?'checked':'' }}>
                                                <span>รับเองที่ร้าน</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" style="{{ ($action === 'edit' && in_array($order->shipping_zone,[6,7,8,9,10,11,12,13,14,15]))?'':'display:none' }}" id="display_shipping_zone_walkin">
                                        <select class="form-control" id="shipping_zone_walkin">
                                            <option value="">--ช่วงเวลา--</option>
                                            @foreach($shippingZone['walk_in'] as $data)
                                            <option value="{{$data['id']}}" @if($order->shipping_zone == $data['id']) selected @endif>{{$data['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">รายการอาหาร</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 offset-md-3 col-12">
                                    <div id="order-details-list">
                                    @if($action === 'edit')
                                        @php
                                            $days = array(
                                                'Monday' => [
                                                    'name' => 'จันทร์',
                                                    'color' => '#ffec8b'
                                                ],
                                                'Tuesday' => [
                                                    'name' => 'อังคาร',
                                                    'color' => '#ffccff'
                                                ],
                                                'Wednesday' => [
                                                    'name' => 'พุธ',
                                                    'color' => '#66cdaa'
                                                ],
                                                'Thursday' => [
                                                    'name' => 'พฤหัส',
                                                    'color' => '#ffa54f'
                                                ],
                                                'Friday' => [
                                                    'name' => 'ศุกร์',
                                                    'color' => '#a4d3ee'
                                                ],
                                                'Saturday' => [
                                                    'name' => 'เสาร์',
                                                    'color' => '#ccccff'
                                                ],
                                                'Sunday' => [
                                                    'name' => 'อาทิตย์',
                                                    'color' => '#fa8072'
                                                ]
                                            )
                                        @endphp
                                        @foreach($order->details as $index => $detail)
                                        <div class="row product-list" style="">
                                            <input type="hidden" class="detail-id" value="{{$detail->id}}">
                                            <div class="col-12">
                                                <label class="item-no">#{{ ($index+1) }}</label>   
                                                @if(in_array($detail->status, ['order', 'pending']))
                                                <button type="button" class="btn btn-danger btn-xs float-right btn-remove-item">
                                                    <i class="fas fa-times"></i>
                                                </button>   
                                                @else
                                                    <span class="float-right badge {{ $bgStatus[$detail->status] }}">{{ strtoupper($detail->status) }}</span>
                                                @endif
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-sm-6 col-6">
                                                        <div class="form-group">
                                                            <select class="form-control form-control-sm select-product" @if(in_array($detail->status, ['confirm', 'delivered', 'cancel'])) disabled @endif>
                                                                <option value="0">--สินค้า--</option>
                                                                @foreach($products as $product)
                                                                <option value="{{$product->id}}" {{ ($detail->product_id === $product->id)?'selected':'' }}>{{$product->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-6">
                                                        <div class="form-group" @if($detail->type==="exclusive") style="display:none;" @endif>
                                                            <select class="form-control form-control-sm select-menu" @if(in_array($detail->status, ['confirm', 'delivered', 'cancel'])) disabled @endif>
                                                                <option value="0">--เมนู--</option>
                                                                @if(isset($menus[$detail->product_id]))
                                                                @foreach($menus[$detail->product_id] as $menu)
                                                                <option value="{{$menu->id}}" {{ ($detail->menu_id === $menu->id)?'selected':'' }}>{{$menu->name}}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <div class="input-group input-group-sm">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">จำนวน</span>
                                                            </div>
                                                            <input type="text" class="form-control text-center product-quantity" value="{{ $detail->quantity }}" @if(in_array($detail->status, ['confirm', 'delivered', 'cancel'])) disabled @endif>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">กล่อง</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <h6 class="text-center">ราคา <span class="product-price">{{$detail->total_amount}}</span> บาท</h6>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>วันที่จัดส่ง</label>
                                                            <div class="input-group input-group-sm">
                                                                <input class="form-control form-control-sm product-delivered-at" type="text" value="{{$detail->delivered_at}}" @if(in_array($detail->status, ['confirm', 'delivered', 'cancel'])) disabled @endif>
                                                                <div class="input-group-append">
                                                                    @php
                                                                        $day = date('l', strtotime($detail->delivered_at));
                                                                    @endphp
                                                                    <span class="input-group-text delivered-day" style="background-color:{{$days[$day]['color']}}">{{($days[$day])?$days[$day]['name']:'-'}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>หมายเหตุ</label>
                                                            <input type="text" class="form-control form-control-sm product-remark" value="{{$detail->remark}}" @if(in_array($detail->status, ['confirm', 'delivered', 'cancel'])) disabled @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12"><hr class="hr_border"></div>
                                        </div>
                                   
                                        @endforeach
                                    @endif
                                    </div>
                                    @if($btnSaveShow)
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary" id="btn-add-product"><i class="fas fa-plus"></i> {{ __('เพิ่มรายการ') }}</button>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-12">
                                            <div class="form-group" id="adjust-delivery-date-to-start-corse-display" style="display:none">
                                                <label>#เปลี่ยนวันที่จัดส่งทั้งหมดเป็นวันที่เริ่มคอร์ส: </label>
                                                <button type="button" class="btn btn-primary btn-xs" id="adjust-delivery-date-to-start-corse">ยืนยัน</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>#เลื่อนวันที่จัดส่ง</label>
                                                <button type="button" class="btn btn-danger btn-xs adjust-date" data-value="-2">-2</button>
                                                <button type="button" class="btn btn-danger btn-xs adjust-date" data-value="-1">-1</button>
                                                <button type="button" class="btn btn-warning btn-xs adjust-date" data-value="1">+1</button>
                                                <button type="button" class="btn btn-warning btn-xs adjust-date" data-value="2">+2</button>
                                                <button type="button" class="btn btn-warning btn-xs adjust-date" data-value="3">+3</button>
                                                <button type="button" class="btn btn-warning btn-xs adjust-date" data-value="5">+5</button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-6 offset-md-3 col-12">
                                    <div class="form-horizontal">
                                        <div class="card-body">
                                            <div class="form-group row d-none">
                                                <label for="" class="col-sm-3 control-label">กล่องใส่อาหาร:</label>
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="packing_charge" value="0" {{ ($action === 'edit' && $order->packing_charge === 0)?'checked':'checked' }}> ธรรมดา
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="packing_charge" value="10" {{ ($action === 'edit' && $order->packing_charge > 0)?'checked':'' }}> ไมโครเวฟ +10 บาท
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-3 control-label">จำนวน/กล่อง:</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="total_quantity" id="total_quantity" value="{{ ($action === 'edit')?$order->total_quantity:'0' }}" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-3 control-label">ราคาทั้งหมด:</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="total_amount" id="total_amount" value="{{ ($action === 'edit')?$order->total_amount:'0' }}" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-3 control-label">ค่าจัดส่ง:</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="shipping_fee" id="shipping_fee" min="0" value="{{ ($action === 'edit')?$order->shipping_fee:'0' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-3 control-label">ส่วนลด:</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="discount" id="discount" value="{{ ($action === 'edit')?$order->discount:'0' }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-3 control-label">ยอดเงินสุทธิ:</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="net_total_amount" id="net_total_amount" value="{{ ($action === 'edit')?$order->net_total_amount:'0' }}" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">หลักฐานการโอนเงิน</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 offset-md-3 col-12">
                                    <div>
                                    <img src="{{ ($action === 'edit' && $order->transfer_image)?$order->transfer_image:'' }}" class="img-thumbnail" id="transfer-image-preview" {{ ($action === 'edit' && $order->transfer_image)?'': "style=display:none"}}>
                                    </div>
                                    <br>
                                    <input type="file" name="transfer_image" style="display:none" accept="image/png, image/jpeg">
                                    @if($btnSaveShow)<button type="button" class="btn btn-primary" id="btn-uploade-file-image"><i class="fas fa-upload"></i> อัพโหลดสลิป</button>@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 offset-md-3 col-12">
                    <div class="row">
                        <div class="col-12">
                            @if($btnSaveShow)
                            <a href="{{ route('orders.index') }}" class="btn btn-secondary">ยกเลิก</a>
                            <button type="button" class="btn btn-success float-right" id="btn-save">บันทึกข้อมูล</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </form>
        </div>
    </section>
@endsection
@section('js')
<script>
    var days = {
                'Sun':{
                    'name':'อาทิตย์',
                    'color':'#fa8072'
                },
                'Mon':{
                    'name':'จันทร์',
                    'color':'#ffec8b'
                },
                'Tue':{
                    'name':'อังคาร',
                    'color':'#ffccff'
                },
                'Wed':{
                    'name':'พุธ',
                    'color':'#66cdaa'
                },
                'Thu':{
                    'name':'พฤหัส',
                    'color':'#ffa54f'
                },
                'Fri':{
                    'name':'ศุกร์',
                    'color':'#a4d3ee'
                },
                'Sat':{
                    'name':'เสาร์',
                    'color':'#ccccff'
                }
        }
    $(function () {
        @if ($action == 'show')
        @elseif ($action == 'create')
            $('#form-content').attr('action', "{!! route('orders.store') !!}");
            $("input[type='hidden'][name='_method']").val('post');
        @elseif ($action == 'edit')
            $('#form-content').attr('action', "{!! route('orders.update', ['order_id' => $order->id]) !!}");
            $("input[type='hidden'][name='_method']").val('put');
        @endif
    });

    $(function () {
        @if($action === 'edit')
            $('input[name=type][value={{ $order->type }}]').prop('checked',true).change();
            $('#shipping_fee').val({{$order->shipping_fee}});
        @endif
    });
</script>
<script>
    var $products = JSON.parse('{!! json_encode($products) !!}');
    $(function(){
        calculateAction = {
            total:function(){
                var packingCharge = $('input[name=packing_charge]:checked').val()
                var discount = $('input[name=discount]').val();
                var shippingFee = $('input[name=shipping_fee]').val();
                var totalAmount = 0;
                var totalQuantity = 0;
                var netTotalAmount = 0;
                $('.product-list').each(function(key,element){
                    var price = $(element).find('.product-price').text();
                    var quantity = $(element).find('.product-quantity').val();
                    totalAmount = totalAmount + parseInt(price);
                    totalQuantity = totalQuantity + parseInt(quantity);
                });
                packingCharge = parseInt(packingCharge)*parseInt(totalQuantity)
                $('input[name=total_quantity]').val(totalQuantity);
                $('input[name=total_amount]').val(totalAmount);

                netTotalAmount = (totalAmount + parseInt(shippingFee) + packingCharge) - parseInt(discount)
                $('input[name=net_total_amount]').val(netTotalAmount);
            }
        }

        productAction = {
            addProduct:function(e){
                var today = moment().format('YYYY-MM-DD')
                var number = $('.product-list').length;
                var element = `
                    <div class="row product-list">
                        <input type="hidden" class="detail-id" value="">
                        <div class="col-12">
                            <label class="item-no">#${number+1}</label>   
                            <button type="button" class="btn btn-danger btn-xs float-right btn-remove-item">
                                <i class="fas fa-times"></i>
                            </button>   
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <select class="form-control form-control-sm select-product">
                                            <option value="0">--สินค้า--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <select class="form-control form-control-sm select-menu">
                                            <option value="0">--เมนู--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">จำนวน</span>
                                        </div>
                                        <input type="text" class="form-control text-center product-quantity" value="1">
                                        <div class="input-group-append">
                                            <span class="input-group-text">กล่อง</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h6 class="text-center">ราคา <span class="product-price">0</span> บาท</h6>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>วันที่จัดส่ง</label>
                                        <div class="input-group input-group-sm">
                                            <input class="form-control form-control-sm product-delivered-at" type="text" value="{{date('Y-m-d')}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text delivered-day" style="background-color:${days[moment(today).format('ddd')]['color']}">${days[moment(today).format('ddd')]['name']}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>หมายเหตุ</label>
                                        <input type="text" class="form-control form-control-sm product-remark">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12"><hr class="hr_border"></div>
                    </div>
                    
                `;
                $('#order-details-list').append(element);
                var productData = [];
                $.each($products,function(index,product){
                    productData.push({
                        id:product.id,
                        text:product.name
                    })
                })
                $('.select-product').select2({
                    theme: 'bootstrap4',
                    data:productData
                });

                $('.select-menu').select2({
                    theme: 'bootstrap4'
                });

                delivereyDatepicker.init();

            },
            changeProduct:function(element,product_id){
                var product = $products.find(product => product.id === parseInt(product_id));
                var productList = $(element).closest('.product-list')
                $(productList).find('.select-menu').html('').select2();
                var menuData = [{id:0,text:'--เมนู--'}];
                if(product.type === 'material'){
                    
                    $.each(product.menus,function(index,menu){
                        menuData.push({
                            id:menu.id,
                            text:menu.name
                        })
                    })
                }
                $(productList).find('.select-menu').select2({
                    data:menuData,
                    theme: 'bootstrap4'
                });
                if(product.type === 'exclusive'){
                    $(productList).find('.select-menu').next(".select2-container").hide();
                }

                var quantity = $(productList).find('.product-quantity').val();
                var productPrice = parseInt(product.price) * parseInt(quantity);
                $(productList).find('.product-price').html(productPrice);
                calculateAction.total();
            },
            addQuantity:function(element, quantity){
                var productList = $(element).closest('.product-list');
                var productID = $(productList).find('.select-product').val();
                var product = $products.find(product => product.id === parseInt(productID));
                var productPrice = parseInt(product.price) * parseInt(quantity);
                $(productList).find('.product-price').html(productPrice);
                calculateAction.total();
            },
            addProductCourse:function(element){
                var courseStartedAt = $('input[name=course_started_at]').val();
                if(courseStartedAt === ""){
                    alert('กรุณาใส่วันที่เริ่มคอร์ส');
                    return false;
                }
                $('#order-details-list').html('');

                var items = element.data('items');
                $.each(items, function(index,item){
                    var number = $('.product-list').length;
                    var element = `
                        <div class="row product-list">
                            <input type="hidden" class="detail-id" value="">                        
                            <div class="col-12">
                                <label class="item-no">#${number+1}</label>   
                                <button type="button" class="btn btn-danger btn-xs float-right btn-remove-item">
                                    <i class="fas fa-times"></i>
                                </button>   
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm select-product">
                                                <option value="0">--สินค้า--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm select-menu">
                                                <option value="0">--เมนู--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">จำนวน</span>
                                            </div>
                                            <input type="text" class="form-control text-center product-quantity" value="1">
                                            <div class="input-group-append">
                                                <span class="input-group-text">กล่อง</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-center">ราคา <span class="product-price">0</span> บาท</h6>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>วันที่จัดส่ง</label>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control form-control-sm product-delivered-at" type="text" value="{{date('Y-m-d')}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text delivered-day">-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>หมายเหตุ</label>
                                            <input type="text" class="form-control form-control-sm product-remark">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12"><hr class="hr_border"></div>
                        </div>
                        
                    `;
                    $('#order-details-list').append(element);
                });

                var productData = [];
                $.each($products,function(index,product){
                    productData.push({
                        id:product.id,
                        text:product.name,
                    })
                })
                $('.select-product').select2({
                    theme: 'bootstrap4',
                    data:productData
                });
                $('.select-menu').select2({
                    theme: 'bootstrap4'
                });

                delivereyDatepicker.init();

                var started_course_day = moment(courseStartedAt).format('ddd');
                //var started_course_day = 'Sat'
                var item_key =  items.findIndex(function(v){
                    return v.day === started_course_day
                })
                var sorted_items = items.slice(item_key).concat(items.slice(0,item_key));

                var stem_day = moment(courseStartedAt).format('ddd');
                var number_day = 0;
                var $i = 0;
                var last_items = new Array();
                $.each(sorted_items, function (index, item){
                    if(item.day !== 'Last'){
                        var list = $('.product-list')[$i];
                        $(list).find('.select-product').val(item.product_id).trigger('change');
                        $(list).find('.product-quantity').val(item.quantity);
                        productAction.addQuantity($(list), item.quantity);
    
                        if(stem_day !== item.day){
                            stem_day = item.day;
                            number_day = number_day+1
                        }

                        $(list).find('.product-delivered-at').data({'date':moment(courseStartedAt).add(number_day,'day').format('YYYY-MM-DD')});
                        $(list).find('.product-delivered-at').val(moment(courseStartedAt).add(number_day,'day').format('YYYY-MM-DD'));
                        $(list).find('.product-delivered-at').datepicker('update');
                        $(list).find('.delivered-day').html(days[moment(courseStartedAt).add(number_day,'day').format('ddd')]['name']);
                        $(list).find('.delivered-day').css({
                            'background-color':days[moment(courseStartedAt).add(number_day,'day').format('ddd')]['color']
                        })
                        if(item.menu.id !== undefined){
                            $(list).find('.select-menu').val(item.menu.id).trigger('change');
                        }
                        $i++;
                    }else{

                        // Add Item Last Day 
                        last_items.push(item)
                    }
                })
                
                // Item Last Day 
                if(last_items.length > 0){
                    $.each(last_items, function (index, item){
                        var list = $('.product-list')[$i];
                        $(list).find('.select-product').val(item.product_id).trigger('change');
                        $(list).find('.product-quantity').val(item.quantity);
                        productAction.addQuantity($(list), item.quantity);

                        $(list).find('.product-delivered-at').val(moment(courseStartedAt).add(number_day,'day').format('YYYY-MM-DD'));
                        $(list).find('.delivered-day').html(days[moment(courseStartedAt).add(number_day,'day').format('ddd')]);
    
                        if(item.menu.id !== undefined){
                            $(list).find('.select-menu').val(item.menu.id).trigger('change');
                        }
                        $i++;
                    })
                }
                
                
            },
            remove:function(element){
                var productList = $(element).closest('.product-list');
                productList.remove();
                $('.product-list').each(function(key,element){
                    $(element).find('.item-no').html(key+1);
                });
                calculateAction.total();

            }
        }

        customerAction = {
            searchPhone:function(phone){
                var url = "{!! route('customers.search-phone') !!}";
                $.ajax({
                    url: url,
                    method:'GET',
                    dataType:'json',
                    data:{phone:phone},
                    beforeSend: function() {
                        $('body').append('<div class="preloader"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>');
                    }
                })
                .done(function(data, textStatus, jqXHR) {
                    if(data.id){
                        $('input[name=shipping_name]').val(data.name);
                        $('input[name=customer_id]').val(data.id);
                        $('textarea[name=shipping_address]').val(data.address);
                        $("input[name=gender][value="+data.gender+"]").prop("checked",true);
                    }else{
                        $('input[name=shipping_name]').val('');
                        $('input[name=customer_id]').val('');
                        $('textarea[name=shipping_address]').val('');
                        $("input[name=gender][value=male]").prop("checked",true);
                    }
                    $('.preloader').remove();
                })
                .fail(function(jqXHR, textStatus) {
                    $('.preloader').remove();
                    Toast.fire({
                        type: 'error',
                        title: jqXHR.responseJSON.message
                    });
                })
            }
        }

        delivereyDatepicker = {
            init:function(){
                $('.product-delivered-at').datepicker({
                    autoclose:true,
                    format:'yyyy-mm-dd',
                    language:'th'
                }).on('changeDate', function(e) {
                    var day = e.format('DD');
                    $(e.target).closest('.input-group').find('.delivered-day').html(day);
                    $(e.target).closest('.input-group').find('.delivered-day').css({'background-color':days[moment(e.format('yyyy-mm-dd')).format('ddd')].color})
                });
            }
        }
    })
</script>
<script>
    (function(window, document, $, undefined) {
        $('input[name=course_started_at]').datepicker({
            autoclose:true,
            format:'yyyy-mm-dd',
            language:'th'
        }).on('changeDate', function(e) {
            if($('input[name=course_id]:checked').val() !== undefined){
                $('#order-details-list').html('');
                $('input[name=course_id]').prop('checked',false);
            }
        });
        $('input[name=type]').change(function(e){
            if($(this).val() === 'daily'){
                $('#display-course').hide();
                $('input[name=course_id]').prop('checked',false);
                $('#adjust-delivery-date-to-start-corse-display').hide();
            }else{
                $('#display-course').show();
                $('#adjust-delivery-date-to-start-corse-display').show();
            }
            //$('#order-details-list').html('');

        });
        $('#btn-add-product').click(function(e){
            productAction.addProduct();
        });
        $('input[name=course_id]').change(function(e){
            productAction.addProductCourse($(this));
        });
        $(document).on('change', '.select-product', function(e){
            var product_id = $(this).val();
            productAction.changeProduct($(this), product_id);
        });
        $(document).on('keyup', '.product-quantity', function(e){
            if($(this).val() === "") return false;
            productAction.addQuantity($(this), $(this).val());
        })
        $('input[name=discount]').keyup(function(e){
            if($(this).val() === "") return false;
            calculateAction.total();
        });
        $('input[name=shipping_fee]').keyup(function(e){
            calculateAction.total();
        });
        $('input[name=packing_charge]').change(function(e){
            calculateAction.total();
        });
        $('#btn-uploade-file-image').click(function(e){
            $('input[name=transfer_image').click();
        });
        $('#btn-search-phone').click(function(e){
            var phone = $('input[name=shipping_phone]').val()
            if(phone === "") return false;
            customerAction.searchPhone(phone);
        });
        $('input[name=transfer_image').change(function(e){
            readURL(this, '#transfer-image-preview');
            $('#transfer-image-preview').show();
        });
        $(document).on('click','.btn-remove-item',function(e){
            var element = $(this);
            Swal.fire({
                title: 'คุณแน่ใจใช่ไหม?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน!',
                cancelButtonText: 'ยกเลิก'
              }).then((result) => {
                if (result.value) {
                    productAction.remove(element);
                }
            });
            
        });

        $('input[name=shipping_zone]').change(function(e){
            var val = $(this).val();
            if(val ==='walkin'){
                $('#display_shipping_zone_walkin').show();
            }else{
                $('#display_shipping_zone_walkin').hide();
            }
        });

        $('.adjust-date').click(function(e){
            Swal.fire({
                title: 'คุณแน่ใจใช่ไหม?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน!',
                cancelButtonText: 'ยกเลิก'
              }).then((result) => {
                if(result.value){
                    var number_day = $(this).data('value');
                    $('.product-list').each(function(index,element){
                        var input = $(element).find('.product-delivered-at');
                        var today = moment().format('YYYY-MM-DD');
                        if(!input.prop('disabled')){
                            var adjust_date = moment(input.val()).add(number_day,'day');
                            if(number_day < 1){
                                if(moment(input.val()).unix() >= moment(today).unix()){
                                    $(input).data({'date':adjust_date.format('YYYY-MM-DD')})
                                    $(input).val(adjust_date.format('YYYY-MM-DD'));
                                    $(input).datepicker('update');
                                    $(element).find('.delivered-day').html(days[adjust_date.format('ddd')].name).css({'background-color':days[adjust_date.format('ddd')].color});
                                }
                            }else{
                                $(input).data({'date':adjust_date.format('YYYY-MM-DD')})
                                $(input).val(adjust_date.format('YYYY-MM-DD'));
                                $(input).datepicker('update');
                                $(element).find('.delivered-day').html(days[adjust_date.format('ddd')].name).css({'background-color':days[adjust_date.format('ddd')].color});
                            }
                        }
                        
                    })
                }
            });
        })

        $('#adjust-delivery-date-to-start-corse').click(function(e){
            Swal.fire({
                title: 'คุณแน่ใจใช่ไหม?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน!',
                cancelButtonText: 'ยกเลิก'
              }).then((result) => {
                if(result.value){
                    var course_start_date = $('input[name=course_started_at]').val();
                    $('.product-delivered-at').val(course_start_date)
                    $('.product-delivered-at').datepicker('update');
                }
            })
        })
    })(window, document, window.jQuery);
</script>
<script>
    $(function () {

        delivereyDatepicker.init();

        $('#btn-save').click(function(e){
            var data = $('#form-content').serializeArray();
            var error = false;
            var details = [];
            if($('.product-list').length){
                $('.product-list').each(function(key,element){
                    var productID = $(element).find('.select-product').val();
                    if(productID === '0'){
                        alert('กรุณาเลือกสินค้ารายการที่ '+ (key+1));
                        error = true;
                        return;
                    }
                    
                    var product = $products.find(product => product.id === parseInt(productID));
                    var detailId = $(element).find('.detail-id').val();
                    var toalAmount = $(element).find('.product-price').text();
                    var totalQuantity = $(element).find('.product-quantity').val();
                    var deliveredAt = $(element).find('.product-delivered-at').val();
                    var remark = $(element).find('.product-remark').val();
                    details[key] = {
                        id:detailId,
                        product_id:product.id,
                        name:product.name,
                        type:product.type,
                        price:product.price,
                        total_amount:toalAmount,
                        quantity:totalQuantity,
                        remark:remark,
                        delivered_at:deliveredAt,
                    }

                    if(product.type === 'material'){
                        var menuID = $(element).find('.select-menu').val();
                        var productMenus = product.menus;

                        if(menuID === '0'){
                            alert('กรุณาเลือกเมนูอาหารรายการที่ '+ (key+1));
                            error = true;
                            return;
                        }

                        var menu = productMenus.find(menu => menu.id === parseInt(menuID));
                        details[key] = $.extend({
                            menu_id:menu.id,
                            menu_name:menu.name,
                            menu_type:menu.type,
                        }, details[key]);
                    }
                });

                if(details.length > 0){
                    data.push({
                        name:'details',
                        value: JSON.stringify(details)
                    })
                }
            }

            if($('input[name=transfer_image').val() !== ""){
                data.push({
                    name:'transfer_image',
                    value:$('input[name=transfer_image').prop('files')[0]
                })
            }

            var shipping_zone_key = null;
            data.map(function(v,k){
                if(v.name === 'shipping_zone'){
                    shipping_zone_key = k
                }
            })
            if(shipping_zone_key){
                if(data[shipping_zone_key].value === 'walkin'){
                    data[shipping_zone_key]['value'] = $('#shipping_zone_walkin').val();
                }
            }
            

            var formData = new FormData();
            $.each(data, function (key, input) {
                formData.append(input.name, input.value);
            });


            if(error) return false;

            var url = $('#form-content').attr('action');
            $.ajax({
                url: url,
                method:'POST',
                dataType:'json',
                processData: false,
                contentType: false,
                data:formData,
                beforeSend: function() {
                    $('body').append('<div class="preloader"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>');
                }
            })
            .done(function(data, textStatus, jqXHR) {
                Swal.fire({
                    type: "success",
                    title: "บันทึกข้อมูลออเดอร์เรียบร้อย", 
                }).then(function(){
                    window.location.replace('{{ route('orders.index') }}');
                });
            })
            .fail(function(jqXHR, textStatus) {
                $('.preloader').remove();
                Toast.fire({
                    type: 'error',
                    title: jqXHR.responseJSON.message
                });
                if(jqXHR.status === 422){
                    errorManage.validate(jqXHR.responseJSON.errors, $('#form-content'));
                }
            })

        })
        
    });
</script>
@endsection

