<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <title>{{ config('app.name', 'DeltaDMC') }}</title>

      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="{{ asset('admin/dist/css/font.css') }}">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
      <!-- SweetAlert2 -->
      <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
      <!-- DataTables -->
      <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
      <!-- Ionicons -->
      <link rel="stylesheet" href="{{ asset('admin/dist/css/ionicons.min.css') }}">
      <!-- Tempusdominus Bootstrap 4 -->
      <link rel="stylesheet" href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
      <!-- iCheck -->
      <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
      <!-- JQVMap -->
      <link rel="stylesheet" href="{{ asset('admin/plugins/jqvmap/jqvmap.min.css') }}">
      <!-- Theme style -->
      <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
      <!-- Select2 -->
      <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
      <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
      <!-- summernote -->
      <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">

      <!-- CUSTOM CSS -->
      <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
      <style>
          .disabledx {
            opacity: .4;
            pointer-events: none;
            cursor: no-drop !important;
          }

          #myTable2 tbody th, #myTable2 tbody td {
              padding: 4px 8px;
          }

          #myTable tbody th, #myTable tbody td {
              padding: 4px 8px;
          }

          .list-item-inv {
            list-style-type: none; position: absolute; top: 0; padding-left: 7px;
          }

      </style>
      <!-- jQuery -->
      <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
      <!-- jQuery UI 1.11.4 -->
      <script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
      <script type="text/javascript">
        $(function () {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
        });
      </script>
      <!-- SweetAlert2 -->
      <script src="{{ asset('admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
      <script>
        const Toast = Swal.mixin({
          toast: true,
          position: 'bottom-end',
          showConfirmButton: false,
          timer: 3000
        });
      </script>
    </head>

    <!-- Navbar -->
    @include('layouts.navbar')
    <!-- /Navbar -->

    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- /Sidebar -->

    <div class="content-wrapper">
    <!-- page content -->
      @yield('content')
    <!-- /Page Content -->
    </div>

    <!-- Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; {{ date('Y') }}</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.1.0
      </div>
    </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @stack('before-scripts')


    @include('sweetalert::alert')
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('admin/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    {{-- <script src="{{ asset('admin/plugins/sparklines/sparkline.js')}}"></script> --}}
    <!-- JQVMap -->
    <script src="{{ asset('admin/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('admin/plugins/moment/moment.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>
    <!-- SweetAlert -->
    <script src="{{ asset('swal/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/myapps.js') }}"></script>

    <!-- Datatble spesifics script -->
    <script>

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    $('#bookingdate').datetimepicker({
        format: 'L'
    });

    $('#docdate').datetimepicker({
        format: 'L'
    });

    $('#igmdate').datetimepicker({
        format: 'L'
    });

    $('#reservationdatex').datetimepicker({
        format: 'L'
    });

    $('#reservationdatexx').datetimepicker({
        format: 'L'
    });

    $('#reservationdateDOC').datetimepicker({
        format: 'L'
    });

    $('#reservationdateMBL').datetimepicker({
        format: 'L'
    });

    $('#reservationdatez').datetimepicker({
        format: 'L'
    });

    $('#reservationdateAWB').datetimepicker({
        format: 'L'
    });

    $('#reservationdatec').datetimepicker({
        format: 'L'
    });

    $('#ETA').datetimepicker({
        format: 'L'
    });

    $('#stuffingDate').datetimepicker({
        format : 'L'
    });

      $(function () {
        $('#myTable').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
          "responsive": true,
        });
      });

      $(function () {
        $('#myTablex').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
          "responsive": true,
        });
      });

      $(function () {
        $('#myTable2').DataTable({
          "paging":false,
          "lengthChange": true,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": true,
          "responsive": true,
          language : {
            "zeroRecords": " "
          },
        });
      });

      $(document).ready(function(){
        $(".dataTables_empty").hide();
      });

      $(function () {
        $('#myTable3').DataTable({
          "paging":false,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": true,
          "responsive": true,
          language : {
            "zeroRecords": " "
          },
        });
      });

      $(document).ready(function () {
        $('#dtHorizontalExample').DataTable({
          "scrollX": true
        });
      });

      $(function(){
        $('.select2bs4').select2({
          theme: 'bootstrap4',
          tags: false,
          dropdownParent: $("#myModal")
        })
      })
      $(function(){
        $('.select2bs4k').select2({
          theme: 'bootstrap4',
          tags: false,
          dropdownParent: $("#myModalx")
        })
      })

      function numberOnly(root){
        var reet = root.value;
        var arr1=reet.length;
        var ruut = reet.charAt(arr1-1);
            if (reet.length > 0){
                    var regex = /[0-9]|\./;
                if (!ruut.match(regex)){
                    var reet = reet.slice(0, -1);
                    $(root).val(reet);
                }
            }
      }

      $(function(){
        $('.select2bs44').select2({
          theme: 'bootstrap4',
          tags: false,
        })
      })

      $('#date_id').datetimepicker({
          format: 'YYYY-MM-DD',
      });

      $('#date_jt').datetimepicker({
          format: 'YYYY-MM-DD'
      });

      $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

      $.fn.modal.Constructor.prototype._enforceFocus = function() {};
    </script>

    @stack('after-scripts')
  </body>
</html>

