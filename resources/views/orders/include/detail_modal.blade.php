<div class="modal fade show" id="modal-detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body px-md-5 px-lg-5">
            <div class="row">
                <div class="col-6">
                    <table class="table borderless paddingless" id="detail-header">
                        <tr>
                            <th>ประเภท</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <th style="50px">วันที่เริ่ม</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <th>เมนูคอร์ส</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <th>ลูกค้า</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <th>เบอร์</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <th>ที่อยู่</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <th>โซนจัดส่ง</th>
                            <td>-</td>
                        </tr>
                    </table>
                </div>
                <div class="col-6">
                    <table class="table borderless paddingless" id="detail-total" style="wdith:400px">
                        <tr>
                            <th>กล่องใส่อาหาร</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <th>จำนวนกล่อง</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <th>ราคาทั้งหมด</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <th>ค่าจัดส่ง</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <th>ส่วนลด</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <th>ยอดเงินสุทธิ</th>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td colspan="2"><a href="https://f.ptcdn.info/649/058/000/pbx1ip7pkYZNFHqbg1B-o.jpg" target="_blank" class="btn btn-primary btn-sm"><i class="far fa-file-image"></i> หลักฐานการโอนเงิน</a></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                    <table class="table table-bordered table-head-fixed" id="detail-items">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>เมนูอาหาร</th>
                                <th>จำนวน</th>
                                <th>วันที่จัดส่ง</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
  
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            <a href="{{route('orders.history')}}" class="btn btn-primary" id="detail-btn-edit"><i class="far fa-edit"></i> แก้ไข</a>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->