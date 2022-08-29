@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>List of Port</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">List of Port</li>
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
                    <table id="datatable1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Code</th>
                                <th width="45%">Name</th>
                                <th width="15%">Country</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
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
                            Port Code <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="port" name="port" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Port Code ...">
                            <input type="hidden" id="id" name="id">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Port Name <font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="port_name" name="port_name" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Port Name ...">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Port Type <font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs4" style="width: 100%;margin-bottom:5px;" name="port_type" id="port_type">
                                <option value="" disabled selected>-- Select Port Type --</option>
                                <option value="SEA">SEA</option>
                                <option value="AIR">AIR</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Country <font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs4" style="width: 100%;margin-bottom:5px;" name="country" id="country">
                                <option value="" disabled selected>-- Select Country --</option>
                                @foreach ($list_country as $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                           Province <font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="province" name="province" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Province ...">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                           City <font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="city" name="city" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input City ...">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                           Postal Code <font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="postal_code" name="postal_code" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Postal Code ...">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                           Address <font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <textarea name="address" id="address" class="form-control" rows="3" placeholder="Input Address..."></textarea>
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
        $(function() {
            $('#datatable1').DataTable({
                processing: true,
                serverSide: true,
                ajax: {    
                   url: '{{ route('master.port_data') }}',
                   type: "POST",
                   headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    { data: 'port_code', port_code: 'name' },
                    { data: 'port_name', name: 'port_name' },
                    { data: 'country_name', name: 'country_name' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' }
                ]
            });
        });

        var dsState;

        $('#port').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });
        
        $('#port_name').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        $('#province').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        $('#city').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        function newData(){
            $('#id').val('');
            $('#port').val('');
            $('#port_name').val('');
            $('#port_type').val('').trigger("change");
            $('#country').val('').trigger("change");
            $('#province').val('');
            $('#city').val('');
            $('#postal_code').val('');
            $('#address').val('');
            dsState = "Input";
            
            $("#myModal").find('.modal-title').text('Add Data');
            $("#myModal").modal('show',{backdrop: 'true'}); 
        }

        function simpandata(){
            if($.trim($("#port").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Port Code',
                    icon: 'error'
                });
            }else if($.trim($("#port_name").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Port Name',
                    icon: 'error'
                });
            }else if($.trim($("#port_type").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select Port Type',
                    icon: 'error'
                });
            }else if($.trim($("#country").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select Country',
                    icon: 'error'
                });
            }else if($.trim($("#province").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Province',
                    icon: 'error'
                });
            }else if($.trim($("#city").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter City',
                    icon: 'error'
                });
            }else if($.trim($("#postal_code").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Postal Code',
                    icon: 'error'
                });
            }else{
                if(dsState=="Input"){
                    $.ajax({
                        type:"POST",
                        url:"{{ route('master.cek_port_code') }}",
                        data:"data="+$("#port").val(),
                        success:function(result){
                            if(result=="duplicate"){
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Port Code Existing',
                                    icon: 'error'
                                })
                            }else{
                                $('#formku').attr("action", "{{ route('master.port_doAdd') }}");
                                $('#formku').submit();              
                            }
                        }
                    });            
                }else{
                    $('#formku').attr("action", "{{ route('master.port_doEdit') }}");
                    $('#formku').submit(); 
                }
            }
            
        };

        function editData(id){
            dsState = "Edit";
            $.ajax({
                type: "POST",
                url: "{{ route('master.port_get') }}",
                dataType: 'json',
                data : {id: id},
                success: function (result){
                    $('#id').val(result.id);
                    $('#port').val(result.port_code);
                    $('#port_name').val(result.port_name);
                    $('#port_type').val(result.port_type).trigger("change");
                    $('#country').val(result.t_mcountry_id).trigger("change");
                    $('#province').val(result.province);
                    $('#city').val(result.city);
                    $('#postal_code').val(result.postal_code);
                    $('#address').val(result.address);
                    $('#status').val(result.active_flag);
                    $("#myModal").find('.modal-title').text('Edit Data');
                    $("#myModal").modal('show',{backdrop: 'true'});           
                }
            });
        }



    </script>
@endpush