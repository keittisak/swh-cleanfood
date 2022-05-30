@extends('layouts.main')
@section('title','Unit Visit Report | create')

@section('css')

@endsection

@section('content')
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Create Unit Visit Report</h1>
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
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Store</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Day/Date</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Time In</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Time Out</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Restaurant Manager</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Duty Manager</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Area Coach</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Announce</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                        <label class="form-check-label" for="exampleCheck2">Un Announce</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th style="width:40%"></th>
                                        <th>คะแนนเต็ม</th>
                                        <th>คะแนนเต็มหลัง NA</th>
                                        <th>คะแนนที่ได้</th>
                                        <th>%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1. Preperation</td>
                                        <td align="right">12</td>
                                        <td><input type="number" class="form-control form-control-sm"/></td>
                                        <td><input type="number" class="form-control form-control-sm"/></td>
                                        <td><span class="badge bg-primary">50%</span></td>
                                    </tr>
                                    <tr>
                                        <td>2. Training System</td>
                                        <td align="right">4</td>
                                        <td><input type="number" class="form-control form-control-sm"/></td>
                                        <td><input type="number" class="form-control form-control-sm"/></td>
                                        <td><span class="badge bg-warning">70%</span></td>
                                    </tr>
                                    <tr>
                                        <td>3. Inventory</td>
                                        <td align="right">8</td>
                                        <td><input type="number" class="form-control form-control-sm"/></td>
                                        <td><input type="number" class="form-control form-control-sm"/></td>
                                        <td><span class="badge bg-danger">30%</span></td>
                                    </tr>
                                    <tr>
                                        <td>4. Cash Management</td>
                                        <td align="right">8</td>
                                        <td><input type="number" class="form-control form-control-sm"/></td>
                                        <td><input type="number" class="form-control form-control-sm"/></td>
                                        <td><span class="badge bg-success">90%</span></td>
                                    </tr>
                                    <tr>
                                        <td>5. Sales Management</td>
                                        <td align="right">8</td>
                                        <td><input type="number" class="form-control form-control-sm"/></td>
                                        <td><input type="number" class="form-control form-control-sm"/></td>
                                        <td><span class="badge bg-primary">60%</span></td>
                                    </tr>
                                    <tr>
                                        <td>6. Hospifality</td>
                                        <td align="right">32</td>
                                        <td><input type="number" class="form-control form-control-sm"/></td>
                                        <td><input type="number" class="form-control form-control-sm"/></td>
                                        <td><span class="badge bg-success">90%</span></td>
                                    </tr>
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <td>Total</td>
                                        <td align="right">200</td>
                                        <td align="right">100</td>
                                        <td align="right">100</td>
                                        <td><span class="badge bg-success">90%</span></td>
                                    </tr>
                                </tfooter>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success-test collapsed-card card-outline fs-1">
                        <div class="card-header">
                            <h5 class="card-title">Preperation (การเตรียมการขาย)</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="2">Standard Score = 12</th>
                                        <th>Score</th>
                                        <th>Comment</th>
                                        <th>When</th>
                                        <th>Who</th>
                                        <th>Finish</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td class="w-25">Opening Checklist</td>
                                        <td>1</td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                    </tr>
                                </tobody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success-test-test collapsed-card card-outline fs-1">
                        <div class="card-header">
                            <h5 class="card-title">Training System (ระบบการฝึกอบรม)</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="2">Standard Score = 4</th>
                                        <th>Score</th>
                                        <th>Comment</th>
                                        <th>When</th>
                                        <th>Who</th>
                                        <th>Finish</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td class="w-25">Opening Checklist</td>
                                        <td>1</td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                    </tr>
                                </tobody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success-test-test collapsed-card card-outline fs-1">
                        <div class="card-header">
                            <h5 class="card-title">Competitor</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Competitor:</label>
                                <textarea class="form-control" rows="5"></textarea>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Admin <br><span>เอกสารราชการ</span></p>
                                    <div class="ml-5">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="option1">
                                                <label class="form-check-label">ภพ 20</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="option1">
                                                <label class="form-check-label">ภพ 09</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="option1">
                                                <label class="form-check-label">ภพ 06</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="option1">
                                                <label class="form-check-label">ใบอนุญาตขายสุรา</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="option1">
                                                <label class="form-check-label">ใบอนุญาตสะสมอาหาร</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="option1">
                                                <label class="form-check-label">ถังดับเพลิง</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p>Promotions</p>
                                    <div class="ml-4">
                                        <div class="form-group row">
                                            <label class="col-sm-1 col-form-label text-right">1.</label>
                                            <div class="col-sm-11">
                                            <input type="text" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-1 col-form-label text-right">2.</label>
                                            <div class="col-sm-11">
                                            <input type="text" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-1 col-form-label text-right">3.</label>
                                            <div class="col-sm-11">
                                            <input type="text" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Delivery:</label>
                                <textarea class="form-control" rows="5"></textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success-test-test collapsed-card card-outline fs-1">
                        <div class="card-header">
                            <h5 class="card-title">Action Plan</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th style="width:5%">#</th>
                                        <th class="text-center" style="width:65%">Action Activities</th>
                                        <th class="text-center" >By When</th>
                                        <th class="text-center" >By Who</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                        <td><input type="text" class="form-control form-control-sm"></td>
                                    </tr>
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <td colspan="4"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button></td>
                              
                                    </tr>
                                </tfooter>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection



