@extends('layouts.main')
@section('title','Unit Visit Report')

@section('css')
    {{--  Css  --}}
@endsection

@section('content')
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Unit Visit Report</h1>
                </div>
                <div class="col-sm-6">
                    {{--  <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>  --}}
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Store</th>
                                        <th>Day/Date</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                        <th>Score Total %</th>
                                        <th>Create By</th>
                                        <th>Create at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="#">USR190701001</a></td>
                                        <td>JEFFER001</td>
                                        <td>2019-07-01</td>
                                        <td>13:00</td>
                                        <td>15:30</td>
                                        <td><span class="badge bg-warning">70%</span></td>
                                        <td>สมศักดิ์ สุขใจ</td>
                                        <td>2019-07-01 13:00:00</td>
                                    </tr>
                                    <tr>
                                            <td><a href="#">USR190701002</a></td>
                                            <td>JEFFER002</td>
                                            <td>2019-07-01</td>
                                            <td>13:00</td>
                                            <td>15:30</td>
                                            <td><span class="badge bg-primary">50%</span></td>
                                            <td>สมศักดิ์ สุขใจ</td>
                                            <td>2019-07-01 13:30:31</td>
                                        </tr>
                                        <tr>
                                                <td><a href="#">USR190701003</a></td>
                                                <td>JEFFER003</td>
                                                <td>2019-07-01</td>
                                                <td>13:00</td>
                                                <td>15:30</td>
                                                <td><span class="badge bg-success">92%</span></td>
                                                <td>สมศักดิ์ สุขใจ</td>
                                                <td>2019-07-01 14:01:52</td>
                                            </tr>
                                            <tr>
                                                    <td><a href="#">USR190701004</a></td>
                                                    <td>JEFFER004</td>
                                                    <td>2019-07-01</td>
                                                    <td>13:00</td>
                                                    <td>15:30</td>
                                                    <td><span class="badge bg-danger">35%</span></td>
                                                    <td>สมศักดิ์ สุขใจ</td>
                                                    <td>2019-07-01 13:25:42</td>
                                                </tr>
                                                <tr>
                                                        <td><a href="#">USR190701005</a></td>
                                                        <td>JEFFER005</td>
                                                        <td>2019-07-01</td>
                                                        <td>13:00</td>
                                                        <td>15:30</td>
                                                        <td><span class="badge bg-warning">76%</span></td>
                                                        <td>สมศักดิ์ สุขใจ</td>
                                                        <td>2019-07-01 12:11:23</td>
                                                    </tr>
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
    $(".table").DataTable();
</script>
@endsection

