@extends('layouts.main')
@section('title','Create Topic')

@section('css')
    {{--  Css  --}}
@endsection

@section('content')
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>สร้างหัวข้อรายงาน</h1>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('topic.index')}}">หัวข้อรายงาน</a></li>
                    <li class="breadcrumb-item active">สร้าง</li>
                </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">หัวข้อ</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">คะแนน</label>
                                <div class="col-sm-10">
                                    <h4>12</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td style="width:15%">รหัส</td>
                                        <td class="w-75">หัวข้อ</td>
                                        <td>คะแนน</td>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tobdy>
                                    <tr>
                                        <td>1</td>
                                        <td>Opening Checklist</td>
                                        <td>1</td>
                                        <td>
                                            <button class="btn btn-xs btn-block btn-info"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-block btn-info"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Opening Checklist</td>
                                        <td>11</td>
                                        <td>
                                            <button class="btn btn-xs btn-block btn-info"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-block btn-info"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfooter>

                                </tfooter>
                            </table>
                            <br>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td style="width:15%">รหัส</td>
                                        <td class="w-75">หัวข้อ</td>
                                        <td>คะแนน</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm float-right">บันทึก</button>
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

