@extends('layouts.main')
@section('title','Coures')

@section('css')
<style>
    .select2-container .select2-selection--single .select2-selection__rendered {
        display:inline;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>คอร์สอาหาร</h1>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body">
                    <form id="form-content" method="post" action="">
                        @csrf
                        <input type="hidden" name="_method" value="">
                        <div class="row">
                            <div class="col-md-4 offset-md-4 col-12">
                                <div class="form-group">
                                    <label>ชื่อ</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ ($course)?$course->name:'' }}">
                                </div>
                                <div class="form-group">
                                    <label>รายละเอียด</label>
                                    <textarea class="form-control" row="3" name="detail" id="detail">{{ ($course)?$course->detail:'' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 offset-md-3 col-12">
                                <label>#รายการอาหาร</label>
                                <div id="items">
                                    @if($action === 'edit')
                                    @foreach(json_decode($course->items) as $index => $item)
                                    <div class="row item-list">
                                        <div class="col-12">
                                            <label>#{{ $index+1 }}</label>   
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <select class="form-control form-control-sm select-day">
                                                            <option value="" {{ ($item->day)?'selected':'' }}>--วัน--</option>
                                                            <option value="Mon" {{ ($item->day === 'Mon')?'selected':'' }}>จันทร์</option>
                                                            <option value="Tue" {{ ($item->day === 'Tue')?'selected':'' }}>อังคาร</option>
                                                            <option value="Wed" {{ ($item->day === 'Wed')?'selected':'' }}>พุธ</option>
                                                            <option value="Thu" {{ ($item->day === 'Thu')?'selected':'' }}>พฤหัสบดี</option>
                                                            <option value="Fri" {{ ($item->day === 'Fri')?'selected':'' }}>ศุกร์</option>
                                                            <option value="Sat" {{ ($item->day === 'Sat')?'selected':'' }}>เสาร์</option>
                                                            <option value="Sun" {{ ($item->day === 'Sun')?'selected':'' }}>อาทิตย์</option>
                                                            <option value="Last" {{ ($item->day === 'Last')?'selected':'' }}>วันสุดท้าย</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger btn-xs float-right mb-2 btn-remove-item">
                                                        <i class="fas fa-times"></i>
                                                    </button>  
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <select class="form-control form-control-sm select-product">
                                                            <option value="0">--สินค้า--</option>
                                                            @foreach($products as $product)
                                                            <option value="{{$product->id}}" {{ ($item->product_id === $product->id)?'selected':'' }}>{{$product->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group" @if($item->product_type==="exclusive") style="display:none;" @endif>
                                                        <select class="form-control form-control-sm select-menu">
                                                            <option value="0">--เมนู--</option>
                                                            @if($item->product_type === 'material')
                                                            @foreach($menus[$item->product_id] as $menu)
                                                            <option value="{{$menu->id}}" {{ ($item->menu->id === $menu->id)?'selected':'' }}>{{$menu->name}}</option>
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
                                                        <input type="text" class="form-control text-center product-quantity" value="{{ $item->quantity }}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">กล่อง</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <h5 class="text-center">ราคา <span class="product-price">{{ isset($item->amount)?$productKey[$item->product_id]->price*$item->quantity:'0' }}</span> บาท</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12"><hr></div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-primary btn-sm" id="btn-add-product">เพิ่มรายการ​</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        

        <div class="row">
            <div class="col-md-4 offset-md-4 col-12">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('courses.index') }}" class="btn btn-secondary">{{ __('ยกเลิก') }}</a>
                        <button type="button" class="btn btn-success float-right" id="btn-save">{{ __('บันทึกข้อมูล') }}</button>
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
    var $products = JSON.parse('{!! json_encode($products) !!}');
    $(function () {
        @if ($action == 'show')
        @elseif ($action == 'create')
            $('#form-content').attr('action', "{!! route('courses.store') !!}");
            $("input[type='hidden'][name='_method']").val('post');
        @elseif ($action == 'edit')
            $('#form-content').attr('action', "{!! route('courses.update', ['course_id' => $course->id]) !!}");
            $("input[type='hidden'][name='_method']").val('put');
        @endif

        $('.select-product').select2({
            theme: 'bootstrap4',
        });
        $('.select-menu').select2({
            theme: 'bootstrap4'
        });
    });
</script>
<script>
    productAction = {
        addProduct:function(e){
            var number = $('.item-list').length;
            var element = `<div class="row item-list">
                    <div class="col-12">
                        <label>#${number+1}</label>   
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <select class="form-control form-control-sm select-day">
                                        <option value="">--วัน--</option>
                                        <option value="Mon">จันทร์</option>
                                        <option value="Tue">อังคาร</option>
                                        <option value="Wed">พุธ</option>
                                        <option value="Thu">พฤหัสบดี</option>
                                        <option value="Fri">ศุกร์</option>
                                        <option value="Sat">เสาร์</option>
                                        <option value="Sun">อาทิตย์</option>
                                        <option value="Last">วันสุดท้าย</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-danger btn-xs float-right mb-2 btn-remove-item">
                                    <i class="fas fa-times"></i>
                                </button>  
                            </div>
                        </div> 
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
                                <h5 class="text-center">ราคา <span class="product-price">0</span> บาท</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-12"><hr></div>
                </div>`;
            $('#items').append(element);
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
            var productList = $(element).closest('.item-list')
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

            if(product.type === 'exclusive'){
                $(productList).find('.select-menu').next(".select2-container").hide();
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
        },
        addQuantity:function(element, quantity){
            var productList = $(element).closest('.item-list');
            var productID = $(productList).find('.select-product').val();
            var product = $products.find(product => product.id === parseInt(productID));
            var productPrice = parseInt(product.price) * parseInt(quantity);
            $(productList).find('.product-price').html(productPrice);
        },
        remove:function(element){
            var productList = $(element).closest('.item-list');
            productList.remove();
            $('.item-list').each(function(key,element){
                $(element).find('.item-no').html(key+1);
            });
        }
    }
</script>
<script>
    (function(window, document, $, undefined) {
        $('#btn-add-product').click(function(e){
            productAction.addProduct();
        });
        $(document).on('change', '.select-product', function(e){
            var product_id = $(this).val();
            productAction.changeProduct($(this), product_id);
        });
        $(document).on('keyup', '.product-quantity', function(e){
            if($(this).val() === "") return false;
            productAction.addQuantity($(this), $(this).val());
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
            var error = false;
            var data = $('#form-content').serializeArray();
            var items = [];
            if($('.item-list').length){
                $('.item-list').each(function(key,element){
                    var selectedDay = $(element).find('.select-day').val();
                    var productID = $(element).find('.select-product').val();
                    var quantity = $(element).find('.product-quantity').val();
                    if(selectedDay === ''){
                        alert('กรุณาเลือกวันที่รายการที่ '+ (key+1));
                        error = true;
                        return false;
                    }
                    if(productID === '0'){
                        alert('กรุณาเลือกสินค้ารายการที่ '+ (key+1));
                        error = true;
                        return false;
                    }
                    var product = $products.find(product => product.id === parseInt(productID));
                    var amount = parseInt(product.price) * parseInt(quantity);
                    items[key] = {
                        product_id:product.id,
                        product_type:product.type,
                        quantity:quantity,
                        amount:amount,
                        day:selectedDay,
                        menu:{}
                    }
                    if(product.type === 'material'){
                        var menuID = $(element).find('.select-menu').val();
                        var productMenus = product.menus;

                        if(menuID === '0'){
                            alert('กรุณาเลือกเมนูอาหารรายการที่ '+ (key+1));
                            error = true;
                            return false;
                        }

                        var menu = productMenus.find(menu => menu.id === parseInt(menuID));
                        items[key].menu = {
                            id:menu.id,
                            name:menu.name,
                            type:menu.type,
                        }
                    }
                });
                if(items.length > 0){
                    data.push({
                        name:'items',
                        value: JSON.stringify(items)
                    })
                }
            }else{
                error = true;
                return false;
            }
            if(error){ return false }
            var formData = new FormData();
            $.each(data, function (key, input) {
                formData.append(input.name, input.value);
            });
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
                    title: "บันทึกข้อมูลคอร์สอาหารเรียบร้อย", 
                }).then(function(){
                    window.location.replace('{{ route('courses.index') }}');
                });
            })
            .fail(function(jqXHR, textStatus, $form) {
                $('.preloader').remove();
                Toast.fire({
                    type: 'error',
                    title: jqXHR.responseJSON.message
                });
                if(jqXHR.status === 422){
                    errorManage.validate(jqXHR.responseJSON.errors, $('#form-content'));
                }
            })
        });
    })
</script>
@endsection

