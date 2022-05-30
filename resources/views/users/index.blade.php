@extends('layouts.main')
@section('title', $pageTitle)

@section('css')
    {{--  Css  --}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-6">
                <h1>{{ $pageSubTitle }}</h1>
            </div>
            <div class="col-6">
                <a href="{{route('users.create')}}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> {{ __('เพิ่มข้อมูล') }}</a>
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
                            <a href="{{route('users.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> {{ __('เพิ่มข้อมูล') }}</a>
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered" id="data-table-menu">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>name</th>
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
            ajax: "{!! route('users.data') !!}",
            columns: [
                { data: 'username', name: 'username' },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', className: 'text-center' }
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
                    text: "คุณต้องการที่จะลบข้อมูลนี้!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่!',
                    cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                    if (result.value) {
                        var url = "{!! route('users.destroy',['user_id'=>':id']) !!}";
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
                                    title: 'ลบข้อมูลเรียบร้อย'
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

