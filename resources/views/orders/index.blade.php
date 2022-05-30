@extends('layouts.main')
@section('title', $pageTitle)

@section('css')
<style>
    .borderless td, .borderless th {
        border: none;
    }
    .paddingless td, .paddingless th{
        padding: 0.3rem;
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
            <div class="col-6 col-sm-6 col-md-3">
                <div class="info-box bg-info mb-3">
                <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
    
                <div class="info-box-content">
                    <span class="info-box-text">ออเดอร์</span>
                    <span class="info-box-number" id="summary-order">
                    {{$total_order}}
                    </span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-6 col-sm-6 col-md-3">
                <div class="info-box bg-danger mb-3">
                <span class="info-box-icon"><i class="fab fa-bitcoin"></i></span>
    
                <div class="info-box-content">
                    <span class="info-box-text">จำนวนเงิน</span>
                    <span class="info-box-number" id="summary-net-total-amount">{{$net_total_amount}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
    
            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>
    
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
                <span class="info-box-icon "><i class="fas fa-list-ol"></i></span>
    
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
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered" id="table-order">
                                    
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="checkbox-all" id="checkbox-all" value="all"></th>
                                            <th>รหัส</th>
                                            <th>ประเภท</th>
                                            <th>ลูกค้า</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th>โซนจัดส่ง</th>
                                            <th>จำนวน</th>
                                            <th>ราคา</th>
                                            <th>สร้างโดย</th>
                                            <th>วันที่สร้าง</th>
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
@include('orders.include.detail_modal')
@endsection
@section('js')
<script>
    var $orderIdChecked = [];
    var $_shippingZone = JSON.parse('{!! json_encode($shippingZone) !!}');
    $(function () {
        $dt = $('#table-order');
        table = $dt.DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url:"{!! route('orders.data') !!}",
                data: function (d) {
                    d.status = 'order'
                },
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'code', name: 'code' },
                { data: 'type', name: 'type' },
                { data: 'shipping_name', name: 'shipping_name' },
                { data: 'shipping_phone', name: 'shipping_phone'},
                { data: 'shipping_zone', name: 'shipping_zone' },
                { data: 'total_quantity', name: 'total_quantity', class:'text-right' },
                { data: 'net_total_amount', name: 'net_total_amount', class:'text-right' },
                { data: 'created_by_user.name', name: 'created_by' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false  },
            ],
            order: [1, 'asc'],
            paging:false,
            drawCallback: function (settings) {
                if (!$dt.parent().hasClass("table-responsive")) {
                    $dt.wrap("<div class='table-responsive text-nowrap'></div>");
                }
            },
            dom: 'l<"datable_toolbar">frtip',
            initComplete: function(){
                $("div.datable_toolbar").html(`
                    <button type="button" class="btn btn-success mb-3" id="btn-moveto-confirm"><i class="far fa-check-circle"></i> ยืนยันการตรวจสอบออเดอร์</button>
                `);           
             },
            columnDefs: [
                {
                    class:'text-center',
                    orderable: false,
                    searchable: false,
                    targets : 0,
                    render: function ( data, type, full, meta ) {
                        return `<input type="checkbox" class="checkbox-order" value="${data}">`;
                    }
                },
                {
                    targets : 1,
                    render: function ( data, type, full, meta ) {
                        return `<button type="button" class="btn btn-link btn-xs btn-show-order" data-order='${full.order_json}'>${data.toUpperCase()}</button>`;
                        return data.toUpperCase()
                    }
                },
                {
                    targets : 5,
                    render: function ( data, type, full, meta ) {
                        return $_shippingZone[data].short_title;
                    }
                },
            ]
        });
        
    });
</script>
<script>
        order = {
            showDetail:function(order){
                $('#modal-detail').modal('show');
                $('#modal-detail').find('.modal-title').html(order.code.toUpperCase());
                var detailHeader = `
                    <tr>
                        <th>ประเภท:</th>
                        <td>${(order.type ==='daily')?'รายวัน':'คอร์ส'}</td>
                    </tr>
                    <tr>
                        <th>วันที่เริ่ม:</th>
                        <td>${(order.course_started_at)?order.course_started_at:'-'}</td>
                    </tr>
                    <tr>
                        <th>คอร์ส:</th>
                        <td>${(order.course)?order.course:'-'}</td>
                    </tr>
                    <tr>
                        <th>ลูกค้า:</th>
                        <td>${order.shipping_name}</td>
                    </tr>
                    <tr>
                        <th>เบอร์:</th>
                        <td>${order.shipping_phone}</td>
                    </tr>
                    <tr>
                        <th>ที่อยู่:</th>
                        <td>${order.shipping_address}</td>
                    </tr>
                    <tr>
                        <th>โซนจัดส่ง:</th>
                        <td>${$_shippingZone[order.shipping_zone].short_title}</td>
                    </tr>
                `;
                $('#modal-detail').find('#detail-header').html(detailHeader);

                var detailTotal = `
                    <tr>
                        <th>กล่องใส่อาหาร:</th>
                        <td>${(order.packing_charge)?'ไมโครเวฟ +10 บาท':'ธรรมดา'}</td>
                    </tr>
                    <tr>
                        <th>จำนวนกล่อง:</th>
                        <td>${order.total_quantity}</td>
                    </tr>
                    <tr>
                        <th>ราคาทั้งหมด:</th>
                        <td>${order.total_amount}</td>
                    </tr>
                    <tr>
                        <th>ค่าจัดส่ง:</th>
                        <td>${order.shipping_fee}</td>
                    </tr>
                    <tr>
                        <th>ส่วนลด:</th>
                        <td>${order.discount}</td>
                    </tr>
                    <tr>
                        <th>ยอดเงินสุทธิ:</th>
                        <td>${order.net_total_amount}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            ${(order.transfer_image)?`<a href="${order.transfer_image}" target="_blank" class="btn btn-primary btn-sm"><i class="far fa-file-image"></i> หลักฐานการโอนเงิน</a>`:''}
                        </td>
                    </tr>
                `;
                $('#modal-detail').find('#detail-total').html(detailTotal);
                var detailItems = ``;
                var statusColor = {
                    order: 'bg-info',
                    pending: 'bg-warning',
                    confirm: 'bg-primary',
                    delivered: 'bg-success',
                    cancel: 'bg-danger'
                };
                $.each(order.details, function(index,detail){
                    detailItems += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${detail.name} ${detail.menu_name}</td>
                            <td class="text-center">${detail.quantity}</td>
                            <td class="text-center">${detail.delivered_at}</td>
                            <td class="text-center"><span class="badge ${statusColor[detail.status]}">${detail.status.toUpperCase()}</span></td>
                        </tr>
                    `;
                });
                $('#modal-detail').find('#detail-items').find('tbody').html(detailItems);
                $('#modal-detail').find('#detail-btn-edit').attr('href', `{{ url()->full() }}/${order.id}/edit`);
            }
        }

        reloadSummary = {
            init:function(){
                var url = "{!! route('widget.order.ajax') !!}";
                $.ajax({
                    url: url,
                    method:'get',
                    dataType:'json',
                })
                .done(function(data, textStatus, jqXHR) {
                    $("#summary-order").text(data.total_order);
                    $("#summary-net-total-amount").text(data.net_total_amount);
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
            batch:function(status){
                var url = "{!! route('orders.status.bulk') !!}";
                $.ajax({
                    url: url,
                    method:'post',
                    dataType:'json',
                    data: {_token:'{{ Session::token() }}', status: status, ids: $orderIdChecked, _method:'patch'},
                    beforeSend: function() {
                        $('body').append('<div class="preloader"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>');
                    }
                })
                .done(function(data, textStatus, jqXHR) {
                    Swal.fire({
                        type: "success",
                        title: "บันทึกข้อมูลออเดอร์เรียบร้อย", 
                    }).then(function(){
                        $orderIdChecked = [];
                        table.ajax.reload();
                        reloadSummary.init();
                        $('.preloader').remove();
                        //window.location.replace('{{ route('orders.index') }}');
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

        deleteAction = {
            deleteRow:function(id){
                Swal.fire({
                    title: 'คุณแน่ใจใช่ไหม?',
                    text: "คุณต้องการที่จะลบออเดอร์นี้!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบออเดอร์!',
                    cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                    if (result.value) {
                        var url = "{!! route('orders.destroy',['order_id'=>':id']) !!}";
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
                                title: 'ลบออเดอร์เรียบร้อย'
                            })
                            table.ajax.reload();
                            reloadSummary.init();
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
</script>
<script>
    (function(window, document, $, undefined) {
        $(document).on('click','.btn-show-order',function(e){
            var data = $(this).data('order');
            order.showDetail(data);
        });
        $(document).on('click', '#btn-moveto-confirm',function(){
            if($orderIdChecked.length === 0){
                Toast.fire({
                    type: 'error',
                    title: 'กรุณาเลือกรายการ'
                });
                return false;
            } 
            Swal.fire({
                title: 'คุณแน่ใจใช่ไหม?',
                text: "คุณต้องการยืนยันการตรวจสอบออเดอร์!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน!',
                cancelButtonText: 'ยกเลิก'
              }).then((result) => {
                if (result.value) {
                    changeStatus.batch('confirm');
                }
            });
            
  
        });
        $("#checkbox-all").click(function(){
            if($(this).is(':checked'))
            {
                $('.checkbox-order').prop('checked', true);
            }else{
                $('.checkbox-order').prop('checked', false);
            }

            $('.checkbox-order').each(function(index,element){
                if($(element).is(":checked")){
                    $orderIdChecked.push($(this).val())
                }else{
                    var orderId = $(this).val();
                    $orderIdChecked = $orderIdChecked.filter(function(id){
                        return id != orderId; 
                    });
                }
            });
        });

        $(document).on('click', '.checkbox-order', function(e){
            if($(this).is(":checked")){
                $orderIdChecked.push($(this).val())
            }else{
                var orderId = $(this).val();
                $orderIdChecked = $orderIdChecked.filter(function(id){
                    return id != orderId; 
                });
            }
        });
    })(window, document, window.jQuery)
</script>
@endsection

