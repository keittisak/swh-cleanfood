@extends('layouts.main')
@section('title','Topic')

@section('css')
    {{--  Css  --}}
@endsection

@section('content')
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>หัวข้อรายงาน</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{route('topic.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> สร้างหัวข้อรายงาน</a>
                    </div>
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
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>หัวข้อ</th>
                                        <th>คะแนน</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Preperation (การเตรียมการขาย)</td>
                                        <td>12</td>
                                        <td>2019-07-01 13:30:31</td>
                                        <td>2019-07-01 13:30:31</td>
                                        <td>
                                            <button class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-info"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Training System (ระบบการฝึกอบรม)</td>
                                        <td>4</td>
                                        <td>2019-07-01 13:30:31</td>
                                        <td>2019-07-01 13:30:31</td>
                                        <td>
                                            <button class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-info"><i class="fa fa-times"></i></button>
                                        </td>
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
