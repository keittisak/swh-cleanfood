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
                                                        <input class="form-check-input" type="radio" name="course_id" value="{{$course->id}}" data-items='{!! $course->items !!}' {{ ($action === 'edit' && $order->course_id)?($order->course_id === $course->id)?'checked':'':'' }}> {{$course->name}}
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
                                <div class="col-md-10 offset-md-2 col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            @for($i=1;$i<=5;$i++)
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="shipping_zone" value="{{$shippingZone[$i]['id']}}" {{ ($action === 'edit' && $order->shipping_zone === $shippingZone[$i]['id'])?'checked':'' }}>
                                                        <span>{{$shippingZone[$i]['title']}}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @endfor
                                        </div>
                                        <div class="col-6">
                                            @for($i=6;$i<=10;$i++)
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="shipping_zone" value="{{$shippingZone[$i]['id']}}" {{ ($action === 'edit' && $order->shipping_zone === $shippingZone[$i]['id'])?'checked':'' }}>
                                                        <span>{{$shippingZone[$i]['title']}}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @endfor
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
                            <h3 class="card-title">รายการอาหาร</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 offset-md-3 col-12">
                                    <div id="order-details-list">
                                    @if($action === 'edit')
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
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <select class="form-control form-control-sm select-product" @if(in_array($detail->status, ['confirm', 'delivered', 'cancel'])) disabled @endif>
                                                                <option value="0">--สินค้า--</option>
                                                                @foreach($products as $product)
                                                                <option value="{{$product->id}}" {{ ($detail->product_id === $product->id)?'selected':'' }}>{{$product->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <select class="form-control form-control-sm select-menu" @if(in_array($detail->status, ['confirm', 'delivered', 'cancel'])) disabled @endif>
                                                                <option value="0">--เมนู--</option>
                                                                @foreach($menus[$detail->product_id] as $menu)
                                                                <option value="{{$menu->id}}" {{ ($detail->menu_id === $menu->id)?'selected':'' }}>{{$menu->name}}</option>
                                                                @endforeach
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
                                                                <input class="form-control form-control-sm product-delivered-at" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-language="th" value="{{$detail->delivered_at}}" @if(in_array($detail->status, ['confirm', 'delivered', 'cancel'])) disabled @endif>
                                                                <div class="input-group-append">
                                                                    @php
                                                                        $days = 'Mon';
                                                                    @endphp
                                                                    <span class="input-group-text">{{$days}}</span>
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
                                    @if($btnSaveShow)<button type="button" class="btn btn-primary" id="btn-add-product"><i class="fas fa-plus"></i> {{ __('เพิ่มรายการ') }}</button>@endif
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
                var days = {"Sun":"อาทิตย์","Mon":"จันทร์","Tue":"อังคาร","Wed":"พุทธ","Thu":"พฤหัสบดี","Fri":"ศุกร์","Sat":"เสาร์"}
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
                                            <input class="form-control form-control-sm product-delivered-at" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-language="th" value="{{date('Y-m-d')}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">${days[moment(today).format('ddd')]}</span>
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
                                                <input class="form-control form-control-sm product-delivered-at" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-language="th" value="{{date('Y-m-d')}}">
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

                var started_course_day = moment(courseStartedAt).format('ddd');
                //var started_course_day = 'Sat'
                var item_key =  items.findIndex(function(v){
                    return v.day === started_course_day
                })
                var sorted_items = items.slice(item_key).concat(items.slice(0,item_key));
                var days = {"Sun":"อาทิตย์","Mon":"จันทร์","Tue":"อังคาร","Wed":"พุทธ","Thu":"พฤหัสบดี","Fri":"ศุกร์","Sat":"เสาร์"}
                $.each(sorted_items, function (index, item){
                    var list = $('.product-list')[index];
                    $(list).find('.select-product').val(item.product_id).trigger('change');
                    $(list).find('.product-quantity').val(item.quantity);
                    productAction.addQuantity($(list), item.quantity);
                    $(list).find('.product-delivered-at').val(moment(courseStartedAt).add(index,'day').format('YYYY-MM-DD'));
                    $(list).find('.delivered-day').html(days[moment(courseStartedAt).add(index,'day').format('ddd')]);

                    if(item.menu.id !== undefined){
                        $(list).find('.select-menu').val(item.menu.id).trigger('change');
                    }
                })
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
            }else{
                $('#display-course').show();
            }
            //$('#order-details-list').html('');
            $('input[name=course_id]').prop('checked',false);
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
    })(window, document, window.jQuery);
</script>
<script>
    $(function () {
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

