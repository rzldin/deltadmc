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
                                <td class="text-center">{{ $row->version_no }}</td>
                                <td>{{ $row->client_name }}</td>
                                <td>{{ $row->name_pic }}</td>
                                <td>{{ ucwords($row->activity) }}</td>
                                <td>{{ $row->loaded_type }}</td>
                                <td>{{ $row->shipment_by }}</td>
                                @if ($row->status == 1)
                                    <td class="bg-success text-center">
                                        Approved
                                    </td>
                                @else
                                    <td class="bg-secondary text-center">
                                        New
                                    </td>
                                @endif
                                <td>
                                    <a class="btn btn-primary btn-sm" onclick="viewVersion('{{ $row->quote_no }}','{{ $row->version_no }}', 'view', '{{ $row->id }}')"><i class="fa fa-file-alt"></i> View </a>
                                    <a class="btn btn-info btn-sm" onclick="viewVersion('{{ $row->quote_no }}','{{ $row->version_no }}','edit', '{{ $row->id }}')" status="edit"><i class="fa fa-edit"></i> Edit </a>
                                    @if ($row->status == 0)
                                    {{-- <a class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete </a>                                         --}}
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
                            <input type="hidden" name="quote_no" id="quote_no" value="">
                            <input type="hidden" name="id_quote" id="id_quotex" value="">
                            <input type="hidden" id="status" value="">
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

        function viewVersion(quote_no, verse, status, id){
            $.ajax({
                type: "POST",
                url: "{{ route('quotation.cekVersion') }}",
                data:{quote_no:quote_no, verse:verse},
                dataType:"json",
                success: function (result) {
                    if(result){
                        if(status == 'view'){
                            $('#selectVersion').html(`<option value="${verse}"></option>`);
                            $('#quote_no').val(quote_no);
                            $('#formku').attr("action", "{{ route('quotation.getView') }}");
                            $('#formku').submit(); 
                        }else{
                            $('#id_quotex').val(id);
                            $('#quote_no').val(quote_no);
                            $('#formku').attr("action", `{{ url('quotation/quote_edit/${id}') }}`);
                            $('#formku').submit(); 
                        }
                    }else{  
                        viewVersionx(quote_no, verse, status);
                    } 
                }
            });
        }

        function viewVersionx(quote_no, verse, status){
            dsState == "View";
            $.ajax({
                type: "POST",
                url: "{{ route('quotation.viewVersion') }}",
                data:{quote_no:quote_no, verse:verse},
                dataType:"html",
                success: function (result) {
                    var tabel = JSON.parse(result);

                    if(status == 'view'){
                        $('#selectVersion').html(tabel[0]);
                    }else{
                        $('#selectVersion').html(tabel[1]);
                    }
                    $('#quote_no').val(quote_no);
                    $('#status').val(status);
                    $("#myModal").find('.modal-title').text('Select Version');
                    $("#myModal").modal('show',{backdrop: 'true'}); 
                }
            });
        }

        function simpandata()
        {
            let id = $('#selectVersion').val();
            if($('#status').val() == 'view'){
                $('#formku').attr("action", "{{ route('quotation.getView') }}");
            }else{
                $('#formku').attr("action", `{{ url('quotation/quote_edit/${id}') }}`);
            }
            $('#formku').submit();    
        }
        
    </script> 
@endpush