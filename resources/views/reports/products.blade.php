@extends('layouts.main')
@section('title', $pageTitle)

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
                <h1>{{ $pageSubTitle }}</h1>
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
                    </div> --}}
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-6 col-md-3 mt-2">
                                <div class="form-gorup">
                                    <label>วันที่สร้าง</label>
                                    <input type="text" name="created_at" class="form-control" value="{{ date('Y/m/d').' - '.date('Y/m/d')}}">
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mt-2">
                                <div class="form-gorup">
                                    <label>วันที่จัดส่ง</label>
                                    <input type="text" name="delivered_at" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mt-2">
                                <div class="form-gorup">
                                    <label>User</label>
                                    <select class="form-control form-control-sm select2" name="user" id="select-user">
                                        <option value="all">--user--</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mt-2">
                                <div class="form-gorup">
                                    <label>สถานะออเดอร์</label>
                                    <select class="form-control form-control-sm select2" name="status">
                                        <option value="all">--ทั้งหมด--</option>
                                        <option value="order">Order</option>
                                        <option value="confirm">Confirm</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3 col-md-3 mt-md-2 pt-md-1">
                                <button type="button" class="btn btn-primary btn-sm mt-4" id="btn-search"><i class="fas fa-search"></i> {{ __('ค้นหา') }}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>เมนูอาหาร</th>
                                            <th>จำนวน/กล่อง</th>
                                            <th>จำนวนเงิน</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="1" style="text-align:right">ยอดรวม:</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>

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
        $('.select2').select2({
            theme: 'bootstrap4',
        });
        $('input[name=created_at').setDaterange();
        $('input[name=delivered_at').setDaterange();
        $dt = $('#data-table');
        table = $dt.DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url:"{!! route('reports.products.data') !!}",
                data: function (d) {
                    var status = $('select[name=status]').val();
                    var created_at = $('input[name=created_at]').val();
                    var user_id = $('select[name=user]').val();
                    var delivered_at = $('input[name=delivered_at]').val();
                    if(status){
                        d.status = status
                    }
                    if(user_id)
                    {
                        d.created_by = user_id
                    }
                    if(created_at)
                    {
                        created_at = created_at.split(" - ");
                        d.created_at = [
                            created_at[0].replace(/\//g, "-"),
                            created_at[1].replace(/\//g, "-")
                        ]
                    }
                    if(delivered_at)
                    {
                        delivered_at = delivered_at.split(" - ");
                        d.delivered_at = [
                            delivered_at[0].replace(/\//g, "-"),
                            delivered_at[1].replace(/\//g, "-")
                        ]
                    }
                },
            },
            paging:false,
            columns: [
                { data: 'product_id', name: 'product_id' },
                { data: 'quantity', name: 'quantity' },
                { data: 'total_amount', name: 'total_amount' },
            ],
            drawCallback: function (settings) {
                if (!$dt.parent().hasClass("table-responsive")) {
                    $dt.wrap("<div class='table-responsive text-nowrap'></div>");
                }
            },
            columnDefs: [
                {
                    targets: [1,2],
                    className: 'text-right',
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                },
                {
                    targets : 0,
                    render: function ( data, type, full, meta ) {
                        return full.name+' '+full.menu_name;
                    }
                },
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();
                $(api.column(1).footer()).html(api.column(1).data().sum().toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $(api.column(2).footer()).html(api.column(2).data().sum().toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
            }
        });

        
    });
</script>
<script>
    (function(window, document, $, undefined) {
        $(document).on('click','.btn-show-order',function(e){
            var data = $(this).data('order');
            order.showDetail(data);
        });
        $('#btn-search').click(function(e){
            table.ajax.reload();
        })
    })(window, document, window.jQuery)
</script>
@endsection

