@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Doc Type Data</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Doc Type</li>
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
                                <th>Name</th>
                                <th>Desc</th>
                                <th>Doc Group</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_data as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $list->name }}</td>
                                <td>{{ $list->desc }}</td>
                                <td>{{ $list->doc_group }}</td>
                                <td align="center">
                                    @if ($list->active_flag == 1)
                                        <span class="badge badge-success">ACTIVE</span>
                                    @else
                                        <span class="badge badge-danger">NOT ACTIVE</span>
                                    @endif
                                </td>
                                <td>
                                    <a onclick="editData({{ $list->id }})" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit </a>
                                    <a href="{{ '/master/doc_type_delete/'.$list->id }}" class="btn btn-danger btn-xs hapus-link"><i class="fa fa-trash"></i> Delete </a>
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
                            Name <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="name" name="name" 
                                class="form-control myline" style="margin-bottom:5px" maxlength="25" placeholder="Input Doc Type Name ..">
                            <input type="hidden" id="id" name="id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Desc<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="desc" name="desc" 
                                class="form-control myline" style="margin-bottom:5px" maxlength="50" placeholder="Input Desc ..">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Doc Group<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="doc_group" name="doc_group" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Doc Group ..">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4 col-xs-4">
                            Status
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <div class="custom-control custom-checkbox">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="status" name="status" value="1" checked>
                                    <label for="status">
                                        ACTIVE
                                    </label>
                                </div>
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
            $('#country_code').val('');
            $('#country_phone_code').val('');
            $('#country_name').val('');
            dsState = "Input";
            
            $("#myModal").find('.modal-title').text('Add Data');
            $("#myModal").modal('show',{backdrop: 'true'}); 
        }

        function simpandata(){
            if($.trim($("#name").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Doc Type Name',
                    icon: 'error'
                })
            }else if($.trim($("#desc").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Desc',
                    icon: 'error'
                })
            }else if($.trim($("#doc_group").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Doc Group',
                    icon: 'error'
                })
            }else{
                if(dsState=="Input"){
                    $('#formku').attr("action", "{{ route('master.doc_type_doAdd') }}");
                    $('#formku').submit();
                }else{
                    $('#formku').attr("action", "{{ route('master.doc_type_doEdit') }}");
                    $('#formku').submit(); 
                }
            }
            
        };

        function editData(id){
            dsState = "Edit";
            $.ajax({
                type: "POST",
                url: "{{ route('master.doc_type_get') }}",
                dataType: 'json',
                data : {id: id},
                success: function (result){
                    $('#id').val(result.id);
                    $('#name').val(result.name);
                    $('#desc').val(result.desc);
                    $('#doc_group').val(result.doc_group);
                    if(result.active_flag == 1){
                        $('#status').prop('checked', true);
                    }else{
                        $('#status').prop('checked', false);
                    }

                    $("#myModal").find('.modal-title').text('Edit Data');
                    $("#myModal").modal('show',{backdrop: 'true'});           
                }
            });
        }

    </script>
@endpush