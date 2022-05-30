@extends('layouts.main')
@section('title', $pageTitle)

@section('css')
    {{--  Css  --}}
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
    
            <div class="col-6 col-sm-6 col-md-3">
                <div class="info-box bg-success mb-3">
                <span class="info-box-icon"><i class="fas fa-box"></i></span>
    
                <div class="info-box-content">
                    <span class="info-box-text">จำนวน/กล่อง</span>
                    <span class="info-box-number" id="summary-quantity">{{$total_quantity}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-6 col-sm-6 col-md-3">
                <div class="info-box bg-warning mb-3">
                <span class="info-box-icon"><i class="fas fa-list-ol"></i></span>
    
                <div class="info-box-content">
                    <span class="info-box-text">เมนูอาหาร</span>
                    <span class="info-box-number" id="summary-product-menu">{{$total_product_menu}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    {{-- <div class="card-header">
                        <h3 class="card-title">รายการ</h3>
                    </div> --}}
                    <div class="card-body">
                        <div class="row pl-2 mb-3">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="phone">วันที่จัดส่ง</label>
                                    <input type="text" name="delivered_at" id="input-devliered-at" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-language="th" value="{{date('Y-m-d')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="phone">โซนจัดส่ง</label>
                                    <select class="form-control" name="shipping_zone" id="shipping-zone">
                                        <option value="all">--ทั้งหมด--</option>
                                        @foreach($shippingZone as $data)
                                        <option value="{{$data['id']}}">{{$data['short_title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mt-md-4 pt-md-1">
                                <button type="button" class="btn btn-danger " id="btn-search"><i class="fas fa-search"></i> {{ __('ค้นหา') }}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="checkbox-all" id="checkbox-all" value="all"></th>
                                            <th>รหัส</th>
                                            <th>ลูกค้า</th>
                                            <th>เมนู</th>
                                            <th>จำนวน/กล่อง</th>
                                            <th>โซนจัดส่ง</th>
                                            <th>วันที่จัดส่ง</th>
                                            <th>สร้างโดย</th>
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
    var ids = [];
    var $_shippingZone = JSON.parse('{!! json_encode($shippingZone) !!}');
    $(function () {
        $dt = $('.table');
        table = $dt.DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url:"{!! route('orders.details.data') !!}",
                data: function (d) {
                    var deliveredAt = $('#input-devliered-at').val();
                    var shippingZone = $('#shipping-zone').val();
                    d.status = 'pending';
                    if(deliveredAt){
                        d.delivered_at = deliveredAt;
                    }
                    d.shipping_zone = shippingZone;
                },
            },
            order: [1, 'asc'],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'order.code', name: 'order_id' },
                { data: 'order.shipping_name', name: 'order.shipping_name' },
                { data: 'name', name: 'name' },
                { data: 'quantity', name: 'quantity', class:'text-center'},
                { data: 'order.shipping_zone', name: 'order.shipping_zone', class:'text-center' },
                { data: 'delivered_at', name: 'delivered_at', class:'text-center' },
                { data: 'created_by_user.name', name: 'created_by'},
                { data: 'action', name: 'action', class:'text-center', orderable: false, searchable: false },
            ],
            paging:false,
            drawCallback: function (settings) {
                if (!$dt.parent().hasClass("table-responsive")) {
                    $dt.wrap("<div class='table-responsive text-nowrap'></div>");
                }
            },
            columnDefs: [
                {
                    class:'text-center',
                    orderable: false,
                    searchable: false,
                    targets : 0,
                    render: function ( data, type, full, meta ) {
                        return `<input type="checkbox" class="checkbox-detail" value="${data}">`;
                    }
                },
                {
                    targets : 1,
                    render: function ( data, type, full, meta ) {
                        return data.toUpperCase()
                        return 
                    }
                },
                {
                    targets : 3,
                    render: function ( data, type, full, meta ) {
                        var menu = '';
                        if(full.menu_name){
                            menu = `#${full.menu_name}`;
                        }
                        return `${data} ${menu}`
                    }
                },
                {
                    targets : 5,
                    render: function ( data, type, full, meta ) {
                        return $_shippingZone[data].short_title;
                    }
                },
            ],
            dom: 'l<"datable_toolbar">frtip',
            
            initComplete: function(){
            /*
               $("div.datable_toolbar").html(`
                    <button type="button" class="btn btn-primary mb-3" id="btn-print-lists"><i class="fas fa-print"></i> ปริ้นรายการอาหาร</button>
                    <button type="button" class="btn btn-primary mb-3" id="btn-print-label"><i class="fas fa-print"></i> ปริ้นใบปะหน้ากล่อง</button>
                    <button type="button" class="btn btn-success mb-3" id="btn-moveto-confirm"><i class="far fa-check-circle"></i> ยืนยันรายการอาหาร</button>
               `);   
            */
                $("div.datable_toolbar").html(`
                <button type="button" class="btn btn-success mb-3" id="btn-moveto-confirm"><i class="far fa-check-circle"></i> ยืนยันรายการอาหาร</button>
                `);         
            }
            
        });
    });
</script>
<script>
    reloadSummary = {
        init:function(){
            var url = "{!! route('widget.detail.ajax') !!}?status=pending";
            $.ajax({
                url: url,
                method:'get',
                dataType:'json',
            })
            .done(function(data, textStatus, jqXHR) {
                $("#summary-quantity").text(data.total_quantity);
                $("#summary-product-menu").text(data.total_product_menu);
            })
            .fail(function(jqXHR, textStatus) {
                // messages = jqXHR.responseJSON.message;
                // Notification.error(messages);
            })
        }
    }
    
    changeStatus = {
        batch:function(){
            var url = "{!! route('orders.details.status.bulk') !!}";
            $.ajax({
                url: url,
                method:'post',
                dataType:'json',
                data: {_token:'{{ Session::token() }}', status: 'confirm', ids: ids, _method:'patch'},
                beforeSend: function() {
                    $('body').append('<div class="preloader"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>');
                }
            })
            .done(function(data, textStatus, jqXHR) {
                Swal.fire({
                    type: "success",
                    title: "บันทึกข้อมูลเรียบร้อย", 
                }).then(function(){
                    ids = [];
                    table.ajax.reload();
                    reloadSummary.init();
                    $('.preloader').remove();
                });
            })
            .fail(function(jqXHR, textStatus) {
                $('.preloader').remove();
                Toast.fire({
                    type: 'error',
                    title: jqXHR.responseJSON.message
                });
                if(jqXHR.status === 422){
                    errorManage.validate(jqXHR.responseJSON.errors, $form);
                }
            })
        }
    }
</script>
<script>
    (function(window, document, $, undefined) {
        $('#btn-search').click(function(){
            table.ajax.reload();
        });

        $(document).on('click', '#btn-moveto-confirm', function(e){
            if(ids.length === 0){
                Toast.fire({
                    type: 'error',
                    title: 'กรุณาเลือกรายการ'
                });
                return false;
            }
            Swal.fire({
                title: 'คุณแน่ใจใช่ไหม?',
                text: "ต้องการยืนยันการตรวจสอบรายการอาหาร!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน!',
                cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                if (result.value) {
                    changeStatus.batch();
                }
            });
            
    
        });
        $("#checkbox-all").click(function(){
            if($(this).is(':checked'))
            {
                $('.checkbox-detail').prop('checked', true);
            }else{
                $('.checkbox-detail').prop('checked', false);
            }

            $('.checkbox-detail').each(function(index,element){
                if($(element).is(":checked")){
                    ids.push($(this).val())
                }else{
                    var detailId = $(this).val();
                    ids = ids.filter(function(id){
                        return id != detailId; 
                    });
                }
            });
        });

        $(document).on('click', '.checkbox-detail', function(e){
            if($(this).is(":checked")){
                ids.push($(this).val())
            }else{
                var detailId = $(this).val();
                ids = ids.filter(function(id){
                    return id != detailId; 
                });
            }
        });

        $(document).on('click', '#btn-print-lists', function(e){
            if(ids.length === 0) return false;
            window.open("{!! route('orders.details.lists.print') !!}"+"?"+jQuery.param({ids}), '_newtab');
            return false
        });
        $(document).on('click', '#btn-print-label', function(e){
            if(ids.length === 0) return false;
            window.open("{!! route('orders.details.label.print') !!}"+"?"+jQuery.param({ids}), '_newtab');
            return false
        });
    })(window, document, window.jQuery);
</script>
@endsection

