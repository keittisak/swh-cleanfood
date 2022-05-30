<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap4.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/flat/blue.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker-bs3.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
  
  <link rel="stylesheet" href="{{ asset('plugins/sweet-alert2/sweet-alert2.min.css') }}?v={{config('app')['css_version']}}">
  <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2/select2-bootstrap4.min.css') }}">  

  <!-- Google Font: Source Sans Pro -->
  {{--  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">  --}}
  {{--  <link href="https://fonts.googleapis.com/css?family=Athiti&display=swap" rel="stylesheet">  --}}
  {{--  <link href="https://fonts.googleapis.com/css?family=Kanit|Open+Sans&display=swap" rel="stylesheet">  --}}
  <link href="https://fonts.googleapis.com/css?family=Prompt&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{config('app')['css_version']}}">
  {{--  <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{date('his')}}">  --}}
  <style>
      .swal2-container{
        z-index: 9999;
      }
      .preloader{
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        border-radius: .25rem;
        align-items: center;
        background: rgba(255,255,255,.7);
        display: flex;
        justify-content: center;
        z-index: 9998;
      }
  </style>
  @yield('css')
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
      
    @include('layouts.topbar')
    @include('layouts.sidebar')

    <div class="content-wrapper">
        @yield('content')
    </br>
    </div>
    
    <footer class="main-footer">
        <strong>Copyright &copy; 2019
          {{--  <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.  --}}
        <div class="float-right d-none d-sm-inline-block">
            {{--  <b>Version</b> 3.0.0-alpha  --}}
        </div>
    </footer>
  </div>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    //$.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.12/api/sum().js"></script>

    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    
    <!-- datepicker -->
    <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.th.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>

    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

    <!-- Slimscroll -->
    <script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>

    <!-- FastClick -->
    <script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.js') }}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('js/demo.js') }}"></script>

    <script src="{{ asset('plugins/sweet-alert2/sweet-alert2.min.js') }}?v1"></script>
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery/jquery.form.js') }}"></script>
    <script>
      var Toast
      $(function(){
        Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: true,
          timer: 15000
        })

        errorManage = {
          validate:function (errors = null, $form = null){
            if($form)
            {
              $.each(errors, function (key, text){
                
                    var $input = $form.find('#'+key);
                    $($input).closest(".form-group").addClass("has-error")
                    if($($input).closest(".form-group").find('.input-group')){
                      $($input).closest(".form-group").append($('<div></div><span class="help-block text-danger"><i class="far fa-times-circle"></i> '+text+'</span></div>'));
                    }else{
                      $($input).parent().append($('<div></div><span class="help-block text-danger"><i class="far fa-times-circle"></i> '+text+'</span></div>'));
                    }
                    
              });
            }
          }
        }
      });
      function readURL(input, element) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(element).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
      }
    </script>
    <script>
    (function( $ ){
        $.fn.setDaterange = function() {
            var element = $(this);
            element.daterangepicker({
                format:'YYYY/MM/DD',
                buttonClasses: 'btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-secondary',
                startDate: moment(),
                endDate: moment(),
                locale: {
                    daysOfWeek: [
                      "อา",
                      "จ",
                      "อ",
                      "พ",
                      "พฤ",
                      "ศ",
                      "ส"
                  ],
                  monthNames: [
                      "ม.ค.",
                      "ก.พ.",
                      "มี.ค.",
                      "เม.ย.",
                      "พ.ค.",
                      "มิ.ย",
                      "ก.ค.",
                      "ส.ค.",
                      "ก.ย.",
                      "ต.ค.",
                      "พ.ย.",
                      "ธ.ค."
                  ],    
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
            }, function(start,end){
                var daterange = start.format('YYYY/MM/DD')+' - '+end.format('YYYY/MM/DD');
                element.val(daterange);
            });
        }; 
    })( jQuery );
</script>
<script>
    $(document).on('keypress keyup blur','.number-only',function(event){
      // $(this).val($(this).val().replace(/[^\d].+/, ""));
      $(this).val($(this).val().replace(/\D/g, ""));
      if ((event.which < 48 || event.which > 57)) {
          event.preventDefault();
      }
  });
</script>
</body>
@yield('js')
</html>