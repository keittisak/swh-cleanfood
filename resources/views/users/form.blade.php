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
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body">
                        <form id="form-content" method="post" action="">
                            @csrf
                            <input type="hidden" name="_method" value="">
                        <div class="row">
                            <div class="col-md-4 offset-md-4 col-12">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="******">
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
                <div class="col-md-4 offset-md-4 col-12">
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('??????????????????') }}</a>
                            <button class="btn btn-success float-right">{{ __('????????????????????????????????????') }}</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</section>
@endsection
@section('js')
<script>
        
     $(function () {
         @if ($action == 'show')
         @elseif ($action == 'create')
             $('#form-content').attr('action', "{!! route('users.store') !!}");
             $("input[type='hidden'][name='_method']").val('post');
         @elseif ($action == 'edit')
             $('#form-content').attr('action', "{!! route('users.update', ['user_id' => $user->id]) !!}");
             $("input[type='hidden'][name='_method']").val('put');
         @endif
     });
 
     $(function () {
         $('#form-content').ajaxForm({
             dataType: 'json',
             beforeSubmit: function (arr, $form, options) {
 
                 $('body').append('<div class="preloader"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>');
             },
             success: function (res) {
                 Swal.fire({
                     type: "success",
                     title: "???????????????????????????????????????????????????????????????", 
                 }).then(function(){
                     window.location.replace('{{ route('users.index') }}');
                 });
             },
             error: function (jqXHR, status, options, $form) {
                 $('.preloader').remove();
                 Toast.fire({
                     type: 'error',
                     title: jqXHR.responseJSON.message
                 });
                 if(jqXHR.status === 422){
                     errorManage.validate(jqXHR.responseJSON.errors, $('#form-content'));
                 }
             }
         });
     });
 </script>
@endsection

