@extends('layouts.main')
@section('title','Product Create')

@section('css')
    {{--  Css  --}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>สร้างสินค้า</h1>
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
                                <label>ประเภทสินค้า</label>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="type" value="material" {{ ($action ==='edit')?($product->type ==='material')?'checked':'':'checked' }}> วัตถุดิบ
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="type" value="exclusive" {{ ($action ==='edit')?($product->type ==='exclusive')?'checked':'':'' }}> เมนูพิเศษ
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 offset-md-4 col-12">
                                <div class="form-group">
                                    <label>ชื่อ</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ ($action ==='edit')?$product->name:'' }}">
                                </div>
                                <div class="form-group">
                                    <label>รายละเอียด</label>
                                    <textarea class="form-control" row="3" name="detail" id="detail">{{ ($action ==='edit')?$product->detail:'' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>ราคา</label>
                                    <input type="number" class="form-control" name="price" id="price" value="{{ ($action ==='edit')?$product->price:'' }}">
                                </div>
                            </div>
                        </div>

                        <div class="row" id="menu-display">
                            <div class="col-md-6 offset-md-3 col-12">
                                <h5>เมนู</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>รสจัด</label>
                                        <div class="form-group">
                                            @foreach($menus['spicy'] as $menu)
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name="menu_ids[]" value="{{$menu->id}}" 
                                                    @if($action === 'edit' && in_array($menu->id, $product->menus->pluck('id')->toArray()))
                                                        checked
                                                    @endif
                                                    > {{$menu->name}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <label>รสอ่อน</label>
                                        <div class="form-group">
                                            @foreach($menus['soft'] as $menu)
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name="menu_ids[]" value="{{$menu->id}}"
                                                    @if($action === 'edit' && in_array($menu->id, $product->menus->pluck('id')->toArray()))
                                                        checked
                                                    @endif
                                                    > {{$menu->name}}
                                                </label>
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
            <div class="col-md-4 offset-md-4 col-12">
                <div class="row">
                    <div class="col-12">
                        <a href="#" class="btn btn-secondary">ยกเลิก</a>
                        <button type="summit" value="create" class="btn btn-success float-right">บันทึกข้อมูล</button>
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
            $('#form-content').attr('action', "{!! route('products.store') !!}");
            $("input[type='hidden'][name='_method']").val('post');
        @elseif ($action == 'edit')
            $('#form-content').attr('action', "{!! route('products.update', ['product_id' => $product->id]) !!}");
            $("input[type='hidden'][name='_method']").val('put');
        @endif
    });

    $(function () {
        $('#form-content').ajaxForm({
            dataType: 'json',
            beforeSubmit: function (arr, $form, options) {

                $('body').append('<div class="preloader"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>');
            },
            success: function (res) {
                Swal.fire({
                    type: "success",
                    title: "บันทึกข้อมูลสินค้าเรียบร้อย", 
                }).then(function(){
                    window.location.replace('{{ route('products.index') }}');
                });
            },
            error: function (jqXHR, status, options, $form) {
                $('.preloader').remove();
                Toast.fire({
                    type: 'error',
                    title: jqXHR.responseJSON.message
                });
                if(jqXHR.status === 422){
                    errorManage.validate(jqXHR.responseJSON.errors, $('#form-content'));
                }
            }
        });
    });
</script>
<script>
    menuAction = {
        init:function(value){
            if(value === 'exclusive'){
                $('#menu-display').hide();
            }else{
                $('#menu-display').show();
            }
        }
    }
    $("input[type=radio][name=type]").change(function(e){
        menuAction.init($(this).val());
    })
    menuAction.init('{{($action ==='edit')?$product->type:'material'}}');
</script>
@endsection

