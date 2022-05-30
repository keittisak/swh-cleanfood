@extends('layouts.main')
@section('title','Menu')

@section('css')
    {{--  Css  --}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-6">
                <h1>เมนูอาหาร</h1>
            </div>
            <div class="col-6">
                <a href="{{route('products.menu.create')}}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> {{ __('เพิ่มข้อมูล') }}</a>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    {{-- <div class="card-header">
                        <h3 class="card-title">รายการ</h3>
                        <div class="card-tools">
                            <a href="{{route('products.menu.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> {{ __('เพิ่มข้อมูล') }}</a>
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered" id="data-table-menu">
                                    <thead>
                                        <tr>
                                            <th>เมนู</th>
                                            <th>ประเภท</th>
                                            <th>รายละเอียด</th>
                                            <th>การจัดการ</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
</section>
@endsection
@section('js')
<script>
    var table;
    $(function () {
        $dt = $('#data-table-menu');
        table = $dt.DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('products.menu.data') !!}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'type', name: 'type' },
                { data: 'detail', name: 'detail'},
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            drawCallback: function (settings) {
                if (!$dt.parent().hasClass("table-responsive")) {
                    $dt.wrap("<div class='table-responsive text-nowrap'></div>");
                }
            },
        });

        deleteAction = {
            deleteRow:function(id){
                Swal.fire({
                    title: 'คุณแน่ใจใช่ไหม?',
                    text: "คุณต้องการที่จะลบเมนูอาหารนี้!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบเมนูอาหาร!',
                    cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                    if (result.value) {
                        var url = "{!! route('products.menu.destroy',['menu_id'=>':id']) !!}";
                        url = url.replace(':id', id);
                        $.ajax({
                            url: url,
                            method:'POST',
                            dataType:'json',
                            data: {_token:'{{ Session::token() }}', _method:'DELETE'},
                        })
                            .done(function(data, textStatus, jqXHR) {
                                Toast.fire({
                                    type: 'success',
                                    title: 'ลบข้อมูลเมนูอาหารเรียบร้อย'
                                })
                                table.ajax.reload();
                            })
                            .fail(function(jqXHR, textStatus) {
                                Toast.fire({
                                    type: 'error',
                                    title: jqXHR.responseJSON.message
                                })
                            })
                    }
                });
            }
        }
    });
</script>
@endsection

