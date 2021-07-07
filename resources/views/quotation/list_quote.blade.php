@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Quotation List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Quotation List</li>
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
                    <a class="btn btn-primary btn-sm" href="{{ url('quotation/quote_add') }}"><i class="fa fa-plus"></i> Add Data</a>
                </div>
                <div class="flash-data" data-flashdata="{{ session('status') }}">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="3%">No</th>
                                <th width="15%">Quote No</th>
                                <th width="8%">Date</th>
                                <th>Latest Version</th>
                                <th>Customer</th>
                                <th>PIC</th>
                                <th>Activity</th>
                                <th>Type</th>
                                <th>Shipment By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->quote_no }}</td>
                                <td>{{ $row->quote_date }}</td>
                                <td>{{ $row->version_no }}</td>
                                <td>{{ $row->client_name }}</td>
                                <td>{{ $row->name_pic }}</td>
                                <td>{{ ucwords($row->activity) }}</td>
                                <td>{{ $row->loaded_type }}</td>
                                <td>{{ $row->shipment_by }}</td>
                                <td class="text-center">
                                    @if ($row->status == 0)
                                        <span class="badge badge-secondary">New</span>
                                    @else
                                        <span class="badge badge-danger">Approved</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-xs" onclick="viewVersion('{{ $row->quote_no }}','{{ $row->version_no }}')"><i class="fa fa-file-alt"></i> View </a>
                                    <a href="javascript:;" class="btn btn-success btn-xs" style="@if($row->status == 1) display:none; @endif" onclick="approve('{{ $row->id }}')"><i class="fa fa-check"></i> Approve</a>
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
                            <input type="hidden" name="quote_no" id="quote_no" value="">
                            <input type="hidden" name="id_quote" id="id_quote" value="">
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
        function viewVersion(quote_no, verse){
            $.ajax({
                type: "POST",
                url: "{{ route('quotation.viewVersion') }}",
                data:{quote_no:quote_no, verse:verse},
                dataType:"html",
                success: function (result) {
                    var tabel = JSON.parse(result);
                    $('#selectVersion').html(tabel);
                    $('#quote_no').val(quote_no);
                    $("#myModal").find('.modal-title').text('Select Version');
                    $("#myModal").modal('show',{backdrop: 'true'}); 
                }
            });
        }

        function simpandata()
        {
            $('#formku').attr("action", "{{ route('quotation.getView') }}");
            $('#formku').submit();    
        }
        
        
        function approve(id)
        {
            Swal.fire({
                title: 'Konfirmasi Approved!',
                text: 'Apakah anda yakin ingin meng Approve data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
                confirmButtonText: "Approved",
		        cancelButtonText: "cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('quotation.quoteApprove') }}",
                        data: {id:id},
                        dataType: 'json',
                        cache: false,
                        success: function (response) {
                            location.replace(location.href.split('#')[0]);
                        },
                    });
                }
            });
        }   
    </script> 
@endpush