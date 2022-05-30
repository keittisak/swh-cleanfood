@extends('layouts.main')
@section('title','Menu Create')

@section('css')
    {{--  Css  --}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>สร้างเมนูอาหาร</h1>
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
                                <label>ประเภทเมนู</label>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="type" value="spicy" {{ ($action ==='edit')?($menu->type ==='spicy')?'checked':'':'checked' }}> รสจัด
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="type" value="soft" {{ ($action ==='edit')?($menu->type ==='soft')?'checked':'':'' }}> รสอ่อน
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
                                    <input type="text" class="form-control" name="name" value="{{ ($action ==='edit')?$menu->name:''}}">
                                </div>
                                <div class="form-group">
                                    <label>รายละเอียด</label>
                                    <textarea class="form-control" row="3" name="detail">{{ ($action ==='edit')?$menu->detail:''}}</textarea>
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
                            <button class="btn btn-success float-right">บันทึกข้อมูล</button>
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
             $('#form-content').attr('action', "{!! route('products.menu.store') !!}");
             $("input[type='hidden'][name='_method']").val('post');
         @elseif ($action == 'edit')
             $('#form-content').attr('action', "{!! route('products.menu.update', ['menu_id' => $menu->id]) !!}");
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
                     title: "บันทึกข้อมูลเมนูอาหารเรียบร้อย", 
                 }).then(function(){
                     window.location.replace('{{ route('products.menu.index') }}');
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
@endsection

