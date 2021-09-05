@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Carrier Data</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Carrier</li>
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
                                <th width="10%">Code</th>
                                <th width="45%">Name</th>
                                <th width="15%">Flag</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_data as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $list->code }}</td>
                                <td>{{ $list->name }}</td>
                                <td>{{ $list->country_name }}</td>
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
                            Code <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="code" name="code" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Code ..">
                            <input type="hidden" id="id" name="id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Name<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="name" name="name" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Name ...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Flag<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs4" style="width: 100%;margin-bottom:5px;" name="flag" id="flag">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach ($list_country as $lc)
                                    <option value="{{ $lc->id }}">{{ $lc->country_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Lloyds Code
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="llyods" name="llyods" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Llyods Code ...">
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

        $('#code').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        $('#name').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        function newData(){
            $('#id').val('');
            $('#code').val('');
            $('#name').val('');
            $('#flag').val('').trigger("change");
            $('#lloyds_code').val('');
            dsState = "Input";
            
            $("#myModal").find('.modal-title').text('Add Data');
            $("#myModal").modal('show',{backdrop: 'true'}); 
        }

        function simpandata(){
            if($.trim($("#code").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Code',
                    icon: 'error'
                })
            }else if($.trim($("#name").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Name',
                    icon: 'error'
                })
            }else if($.trim($("#flag").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select Country',
                    icon: 'error'
                })
            }else{
                if(dsState=="Input"){
                    $.ajax({
                        type:"POST",
                        url:"{{ route('master.cek_carrier_code') }}",
                        data:"data="+$("#code").val(),
                        success:function(result){
                            if(result=="duplicate"){
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Carrier Code Existing',
                                    icon: 'error'
                                })
                            }else{
                                $('#formku').attr("action", "{{ route('master.carrier_doAdd') }}");
                                $('#formku').submit();              
                            }
                        }
                    });
                }else{
                    $('#formku').attr("action", "{{ route('master.carrier_doEdit') }}");
                    $('#formku').submit(); 
                }
            }
            
        };

        function editData(id){
            dsState = "Edit";
            $.ajax({
                type: "POST",
                url: "{{ route('master.carrier_get') }}",
                dataType: 'json',
                data : {id: id},
                success: function (result){
                    $('#id').val(result.id);
                    $('#code').val(result.code);
                    $('#name').val(result.name);
                    $('#flag').val(result.t_mcountry_id).trigger("change");
                    $('#llyods').val(result.lloyds_code);
                    $('#status').val(result.active_flag).prop("checked");
                    $("#myModal").find('.modal-title').text('Edit Data');
                    $("#myModal").modal('show',{backdrop: 'true'});           
                }
            });
        }



    </script>
@endpush