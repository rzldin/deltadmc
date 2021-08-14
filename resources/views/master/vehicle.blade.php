@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Vehicle Data</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">vehicle</li>
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
                    <a class="btn btn-primary btn-sm" onclick="newData()"><i class="fa fa-plus"></i> Add Data</a>
                </div>
                <div class="flash-data" data-flashdata="{{ session('status') }}">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="12%">Vehicle No</th>
                                <th width="14%">Shipment Type</th>
                                <th width="12%">Vehicle Type</th>
                                <th width="30%">Vendor</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_data as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $list->vehicle_no }}</td>
                                <td>{{ $list->shipment_type }}</td>
                                <td>{{ $list->type }}</td>
                                <td>{{ $list->client_name }}</td>
                                <td align="center">
                                    @if ($list->active_flag == 1)
                                        <span class="badge badge-success">ACTIVE</span>
                                    @else
                                        <span class="badge badge-danger">NOT ACTIVE</span>
                                    @endif
                                </td>
                                <td>
                                    <a onclick="editData({{ $list->id }})" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit </a>
                                    <a href="{{ '/master/carrier_delete/'.$list->id }}" class="btn btn-danger btn-xs hapus-link"><i class="fa fa-trash"></i> Delete </a>
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!--- Modal Form -->
<div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                            Vehicle No <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="nopol" name="nopol" 
                                class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()" placeholder="Input Vehicle No ...">
                            <input type="hidden" id="id" name="id">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Vehicle Type<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs4" style="width: 100%;margin-bottom:5px;" name="type" id="type">
                                <option value="" disabled selected>-- Select Type Vehicle --</option>
                                @foreach ($list_type_vehicle as $tv)
                                    <option value="{{ $tv->id }}">{{ $tv->type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Vendor Ownership<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs4" style="width: 100%;margin-bottom:5px;" name="vendor" id="vendor">
                                <option value="" disabled selected>-- Select Vendor --</option>
                                @foreach ($list_vendor as $v)
                                    <option value="{{ $v->id }}">{{ $v->client_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Shipment Type<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs4" style="width: 100%;margin-bottom:5px;" name="shipment" id="shipment">
                                <option value="" disabled selected>-- Select Type Shipment --</option>
                                <option value="SEA">SEA</option>
                                <option value="AIR">AIR</option>
                                <option value="LAND">LAND</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Status
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="status" name="status" checked>
                                <label for="status">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">                        
                <button type="button" class="btn btn-primary" onClick="simpandata();"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-scripts')
    <script>
        var dsState;

        function newData(){
            $('#id').val('');
            $('#code').val('');
            $('#name').val('');
            $('#flag').val('');
            $('#lloyds_code').val('');
            dsState = "Input";
            
            $("#myModal").find('.modal-title').text('Add Data');
            $("#myModal").modal('show',{backdrop: 'true'}); 
        }

        function simpandata(){
            if($.trim($("#nopol").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter No. Pol',
                    icon: 'error'
                })
            }else if($.trim($("#type").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Vehicle Type',
                    icon: 'error'
                })
            }else if($.trim($("#vendor").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select Vendor',
                    icon: 'error'
                })
            }else if($.trim($("#shipment").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select Shipment Type',
                    icon: 'error'
                })
            }else{
                if(dsState=="Input"){                   
                    $('#formku').attr("action", "{{ route('master.vehicle_doAdd') }}");
                    $('#formku').submit();              
                }else{
                    $('#formku').attr("action", "{{ route('master.vehicle_doEdit') }}");
                    $('#formku').submit(); 
                }
            }
            
        };

        function editData(id){
            dsState = "Edit";
            $.ajax({
                type: "POST",
                url: "{{ route('master.vehicle_get') }}",
                dataType: 'json',
                data : {id: id},
                success: function (result){
                    console.log(result.id)
                    $('#id').val(result.id);
                    $('#nopol').val(result.vehicle_no);
                    $('#type').val(result.t_mvehicle_type_id).trigger("change");
                    $('#vendor').val(result.t_mcompany_id).trigger("change");
                    $('#shipment').val(result.shipment_type).trigger("change");
                    $("#myModal").find('.modal-title').text('Edit Data');
                    $("#myModal").modal('show',{backdrop: 'true'});           
                }
            });
        }



    </script>
@endpush