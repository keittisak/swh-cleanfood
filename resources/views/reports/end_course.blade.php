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
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>ลูกค้า</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th>วันที่เริ่ม</th>
                                            <th>จำนวน/วัน</th>
                                            <th width="40%">รายละเอียด/วัน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($datas as $data)
                                        <tr>
                                        <td><a href="{{route('orders.history').'?code='.$data['code']}}" target="_blank">{{strtoupper($data['code'])}}</a></td>
                                            <td>{{$data['shipping_name']}}</td>
                                            <td>{{$data['shipping_phone']}}</td>
                                            <td>{{$data['course_started_at']}}</td>
                                            <td>{{count($data['date_remain'])}}</td>
                                            <td>{{implode(', ', $data['date_remain'])}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
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
    $('.table').dataTable({
        order: [[ 4, "asc" ]],
    });
</script>
@endsection

