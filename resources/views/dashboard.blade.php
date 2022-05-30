@extends('layouts.main')
@section('title','Dashboard')

@section('css')
    {{--  Css  --}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="info-box mb-3 bg-success">
                    <span class="info-box-icon"><i class="fab fa-bitcoin"></i></span>
        
                    <div class="info-box-content">
                        <span class="info-box-text">{{ strtoupper('This Month') }}</span>
                        <span class="info-box-number">{{ number_format($thisMonth['netTotalAmount'],'2','.',',') }}</span>
                        <span class="progress-description">ยอดขายเดือนนี้</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="info-box mb-3 bg-success">
                    <span class="info-box-icon"><i class="fas fa-box"></i></span>
        
                    <div class="info-box-content">
                        <span class="info-box-text">{{ strtoupper('This Month') }}</span>
                        <span class="info-box-number">{{ $thisMonth['totalOrder'].'/'.$thisMonth['totalQuantity'] }}</span>
                        <span class="progress-description">ออเดอร์/กล่อง เดือนนี้</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="info-box mb-3 bg-info">
                    <span class="info-box-icon"><i class="fab fa-bitcoin"></i></span>
        
                    <div class="info-box-content">
                        <span class="info-box-text">{{ strtoupper('Last Month') }}</span>
                        <span class="info-box-number">{{ number_format($lastMonth['netTotalAmount'],'2','.',',') }}</span>
                        <span class="progress-description">ยอดขายเดือนที่แล้ว</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="info-box mb-3 bg-info">
                    <span class="info-box-icon"><i class="fas fa-box"></i></span>
        
                    <div class="info-box-content">
                        <span class="info-box-text">{{ strtoupper('Last Month') }}</span>
                        <span class="info-box-number">{{ $lastMonth['totalOrder'].'/'.$lastMonth['totalQuantity'] }}</span>
                        <span class="progress-description">ออเดอร์/กล่อง เดือนที่แล้ว</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">เมนูอาหารในเดือนนี้</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>เมนูอาหาร</th>
                                    <th>จำนวน/กล่อง</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($thisMonth['products'] as $key => $product)
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td>{{ $product->name.' '.$product->menu_name }}</td>
                                    <td class="text-center">{{ $product->quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">เมนูอาหารในเดือนที่แล้ว</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>เมนูอาหาร</th>
                                    <th>จำนวน/กล่อง</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lastMonth['products'] as $key => $product)
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td>{{ $product->name.' '.$product->menu_name }}</td>
                                    <td class="text-center">{{ $product->quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>
@endsection
@section('js')
<script>
    $(function () {
        $("table").DataTable();
    });
</script>
@endsection

