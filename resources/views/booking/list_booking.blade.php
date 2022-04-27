@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Booking List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Booking List</li>
          </ol>
        </div>
      </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-primary btn-sm" href="{{ route('quotation.list') }}"><i class="fa fa-plus"></i> Create Booking</a>
                </div>
                <div class="flash-data" data-flashdata="{{ session('status') }}">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row mb-1">
                      <div class="col-md-1">
                        <label for="Doctor-name">Status</label>
                      </div>
                      <div class="col-md-3">
                        <select class="form-control" name="status" id="status" style="width: 100%;" placeholder="Silahkan pilih...">
                            <option value="">Silahkan Pilih ...</option>
                            <option value="0">Draft</option>
                            <option value="1">Approved</option>
                            <option value="9">Canceled</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <a href="javascript:;" class="btn btn-info btn" id="filter"><i class="fa fa-search"></i> Filter </a>
                      </div>
                    </div>
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Booking Number</th>
                                <th>Version</th>
                                <th>Booking Date</th>
                                <th>Shipper</th>
                                <th>Consignee</th>
                                <th>Client</th>
                                <th>Activity</th>
                                <th>Status</th>
                                <th>Invoice Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 14px">
                            @foreach ($list as $row)
                            <tr>
                                <td>{{ $row->booking_no}}</td>
                                <td>{{ $row->version_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->booking_date)->format('d/m/Y') }}</td>
                                <td>{{ $row->company_d }}</td>
                                <td>{{ $row->company_c }}</td>
                                <td>{{ $row->company_b }}</td>
                                <td>{{ $row->activity }}</td>
                                @if ($row->status == 0)
                                    <td class="bg-secondary text-center">NEW</td>
                                @elseif($row->status == 1) 
                                    <td class="bg-success text-center">Approve</td>
                                @elseif($row->status == 2) 
                                    <td class="bg-danger text-center">Cancel with Invoice</td>
                                @elseif($row->status == 8) 
                                    <td class="bg-warning text-center">On Request</td>
                                @elseif($row->status == 9) 
                                    <td class="bg-danger text-center">Canceled</td>
                                @endif

                                @if ($row->flag_invoice == 0)
                                    <td class="bg-secondary text-center">No Invoice</td>
                                @elseif($row->flag_invoice == 1) 
                                    <td class="bg-success text-center">Invoice Created</td>
                                @endif
                                <td>
                                    <a class="btn btn-primary btn-sm" onclick="viewVersion('{{ $row->booking_no }}','{{ $row->version_no }}', 'view', '{{ $row->id }}')"><i class="fa fa-file-alt"></i> View </a>
                                    @if($row->status!=9)
                                    <a class="btn btn-info btn-sm" onclick="viewVersion('{{ $row->booking_no }}','{{ $row->version_no }}', 'edit', '{{ $row->id }}')"><i class="fa fa-edit"></i> Edit </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!--- Modal Form -->
<div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                <h4 class="modal-title">&nbsp;</h4>
            </div>
            <br>
            <div class="modal-body">
                <form class="eventInsForm" method="post" target="_self" name="formku" 
                      id="formku" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Version
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <select name="version" id="selectVersion" class="form-control select2bs44">
                                
                            </select>
                            <input type="hidden" name="booking_no" id="booking_no" value="">
                            <input type="hidden" name="id_booking" id="id_bx" value="">
                            <input type="hidden" id="status_version" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">                        
                <button type="button" class="btn btn-primary" onClick="simpandata();"><i class="fa fa-save"></i> Select</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-scripts')
    <script>
        var dsState;

        function viewVersion(booking_no, verse, status, id){
            $.ajax({
                type: "POST",
                url: "{{ route('booking.cekVersion') }}",
                data:{booking_no:booking_no, verse:verse},
                dataType:"json",
                success: function (result) {
                    if(result){
                        if(status == 'view'){
                            $('#selectVersion').html(`<option value="${verse}"></option>`);
                            $('#booking_no').val(booking_no);
                            $('#formku').attr("action", "{{ route('booking.getView') }}");
                            $('#formku').submit(); 
                        }else{
                            $('#id_bx').val(id);
                            $('#booking_no').val(booking_no);
                            $('#formku').attr("action", `{{ url('booking/edit_booking/${id}') }}`);
                            $('#formku').submit(); 
                        }
                    }else{  
                        viewVersionx(booking_no, verse, status);
                    } 
                }
            });
        }

        function viewVersionx(booking_no, verse, status){
            dsState == "View";
            $.ajax({
                type: "POST",
                url: "{{ route('booking.viewVersion') }}",
                data:{booking_no:booking_no, verse:verse},
                dataType:"html",
                success: function (result) {
                    var tabel = JSON.parse(result);

                    if(status == 'view'){
                        $('#selectVersion').html(tabel[0]);
                    }else{
                        $('#selectVersion').html(tabel[1]);
                    }
                    $('#booking_no').val(booking_no);
                    $('#status_version').val(status);
                    $("#myModal").find('.modal-title').text('Select Version');
                    $("#myModal").modal('show',{backdrop: 'true'}); 
                }
            });
        }

        function simpandata()
        {
            let id = $('#selectVersion').val();
            if($('#status_version').val() == 'view'){
                $('#formku').attr("action", "{{ route('booking.getView') }}");
            }else{
                $('#formku').attr("action", `{{ url('booking/edit_booking/${id}') }}`);
            }
            $('#formku').submit();    
        }

        $("#filter").click(function () {
            window.location = "{{ route('booking.list') }}?status="+$('#status').val();
        });
    </script>
@endpush