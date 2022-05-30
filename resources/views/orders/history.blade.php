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
            <div class="col-12">
                <div class="card card-default">
                    {{-- <div class="card-header">
                        <h3 class="card-title">รายการ</h3>
                    </div> --}}
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-6 col-md-3 mt-2">
                                <div class="form-gorup">
                                    <label>รหัสออเดอร์</label>
                                <input type="text" name="code" class="form-control form-control-sm" value="{{Request::get('code')}}">
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mt-2">
                                <div class="form-gorup">
                                    <label>ประเภท</label>
                                    <select name="type" class="form-control form-control-sm">
                                        <option value="">--ทั้งหมด--</option>
                                        <option value="daily">รายวัน</option>
                                        <option value="course">คอร์ส</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mt-2">
                                <div class="form-gorup">
                                    <label>ลูกค้า</label>
                                    <input type="text" name="shipping_name" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mt-2">
                                <div class="form-gorup">
                                    <label>เบอร์โทรศัพท์</label>
                                    <input type="text" name="shipping_phone" class="form-control form-control-sm">
                                </div>
                            </div>
                        
            
                            <div class="col-6 col-md-3 mt-2">
                                <div class="form-gorup">
                                    <label>โซนจัดส่ง</label>
                                    <select name="shipping_zone" class="form-control form-control-sm">
                                        <option value="">--ทั้งหมด--</option>
                                        @foreach($shippingZone as $zone)
                                        <option value="{{$zone['id']}}">{{$zone['short_title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mt-2">
                                <div class="form-gorup">
                                    <label>วันที่สร้าง</label>
                                    <input class="form-control form-control-sm" type="text" name="created_at" value="">
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mt-md-4 pt-md-3 mt-xs-4">
                                <div class="form-gorup">
                                    <div class="form-check">
                                        
                                        <label class="form-check-label"><input class="form-check-input" type="checkbox" name="is-delivery-not-success" value="1"> ออเดอร์ที่ยังส่งอาหารไม่ครบ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 col-md-3 mt-md-2 pt-md-1">
                                <button type="button" class="btn btn-primary btn-sm mt-4" id="btn-search"><i class="fas fa-search"></i> {{ __('ค้นหา') }}</button>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered" id="table-order">
                                    <thead>
                                        <tr>
                                            <th>รหัส</th>
                                            <th>ประเภท</th>
                                            <th>ลูกค้า</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th>โซนจัดส่ง</th>
                                            <th>จำนวน</th>
                                            <th>ราคา</th>
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
    $('input[name=created_at').setDaterange();

    $(function () {
        $dt = $('#table-order');
        table = $dt.DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url:"{!! route('orders.data') !!}",
                data: function (d) {
                    var code = $('input[name=code]').val();
                    var type = $('select[name=type]').val();
                    var shipping_name = $('input[name=shipping_name]').val();
                    var shipping_phone = $('input[name=shipping_phone').val();
                    var shipping_zone = $('select[name=shipping_zone]').val();
                    var created_at = $('input[name=created_at]').val();
                    var is_delivery_not_success = $('input[name=is-delivery-not-success]').is(':checked')
                    d.code = code;
                    d.type = type;
                    d.shipping_name = shipping_name;
                    d.shipping_phone = shipping_phone;
                    d.shipping_zone = shipping_zone;
                    if(created_at)
                    {
                        created_at = created_at.split(" - ");
                        d.created_at = [
                            created_at[0].replace(/\//g, "-"),
                            created_at[1].replace(/\//g, "-")
                        ]
                    }
                    if(is_delivery_not_success){
                        d.is_delivery_not_success = is_delivery_not_success
                    }
                },
            },
            columns: [
                { data: 'code', name: 'code' },
                { data: 'type', name: 'type' },
                { data: 'shipping_name', name: 'shipping_name' },
                { data: 'shipping_phone', name: 'shipping_phone'},
                { data: 'shipping_zone', name: 'shipping_zone' },
                { data: 'total_quantity', name: 'total_quantity', class:'text-right' },
                { data: 'net_total_amount', name: 'net_total_amount', class:'text-right' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'  },
            ],
            order: [0, 'asc'],
            searching:false,
            drawCallback: function (settings) {
                if (!$dt.parent().hasClass("table-responsive")) {
                    $dt.wrap("<div class='table-responsive text-nowrap'></div>");
                }
            },
            columnDefs: [
                {
                    targets : 0,
                    render: function ( data, type, full, meta ) {
                        return `<button type="button" class="btn btn-link btn-xs btn-show-order" data-order='${full.order_json}'>${data.toUpperCase()}</button>`;
                        return data.toUpperCase()
                    }
                },
                {
                    targets : 4,
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
                            <td>${detail.name} ${(detail.menu_name != null)?detail.menu_name:''}</td>
                            <td class="text-center">${detail.quantity}</td>
                            <td class="text-center">${detail.delivered_at}</td>
                            <td class="text-center"><span class="badge ${statusColor[detail.status]}">${detail.status.toUpperCase()}</span></td>
                        </tr>
                    `;
                });
                var url = "{{route('orders.edit', 'data')}}";
                url = url.replace('data', order.id);
                $('#modal-detail').find('#detail-items').find('tbody').html(detailItems);
                $('#modal-detail').find('#detail-btn-edit').attr('href', `${url}`);
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
        $('#btn-search').click(function(e){
            table.ajax.reload();
        })
    })(window, document, window.jQuery)
</script>
@endsection

