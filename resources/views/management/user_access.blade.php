@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>User Access</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">User Access</li>
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
                                <th>No</th>
                                <th>Role</th>
                                <th>Menu Name</th>
                                <th>Menu Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_data as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $list->responsibility_name }}</td>
                                <td>{{ $list->apps_menu_name }}</td>
                                <td>{{ $list->apps_menu_level }}</td>
                                <td align="center">
                                    @if ($list->active_flag == 1)
                                        <span class="badge badge-success">ACTIVE</span>
                                    @else
                                        <span class="badge badge-danger">NOT ACTIVE</span>
                                    @endif
                                </td>
                                <td>
                                    <a onclick="editData({{ $list->id }})" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Update </a>
                                    <a href="{{ '/user/access_delete/'.$list->id }}" class="btn btn-danger btn-xs hapus-link"><i class="fa fa-trash"></i> Delete </a>
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
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                           Role<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs4" style="width: 100%;margin-bottom:5px;" name="role" id="role">
                                <option value="" disabled selected>-- Select Role --</option>
                                @foreach ($list_user as $lu)
                                    <option value="{{ $lu->id }}">{{ $lu->responsibility_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Apps Menu<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs4" multiple="multiple" style="width: 100%;margin-bottom:5px;" name="menu[]" id="menu">
                                @foreach ($list_menu as $m)
                                    <option value="{{ $m->id }}">{{ $m->apps_menu_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Status<font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <label for="status">
                            <input type="checkbox" id="status" name="status" checked> <b>Active</b></label>
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
            $('#role').val('');
            $('#menu').val('');
            dsState = "Input";
            
            $("#myModal").find('.modal-title').text('Add Data');
            $("#myModal").modal('show',{backdrop: 'true'}); 
        }

        function simpandata(){
            if($.trim($("#role").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select Role!',
                    icon: 'error'
                })
            }else if($.trim($("#menu").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please Select menu',
                    icon: 'error'
                })
            }else{
                if(dsState=="Input"){                   
                    $('#formku').attr("action", "{{ route('user.access_doAdd') }}");
                    $('#formku').submit();              
                }else{
                    $('#formku').attr("action", "{{ route('user.access_doEdit') }}");
                    $('#formku').submit(); 
                }
            }
            
        };

        function editData(id){
            dsState = "Edit";
            $.ajax({
                type: "POST",
                url: "{{ route('user.access_get') }}",
                dataType: 'json',
                data : {id: id},
                success: function (result){
                    console.log(result.id)
                    $('#id').val(result.id);
                    $('#role').val(result.t_mresponsibility_id).trigger("change");
                    $('#menu').val(result.t_mapps_menu_id).trigger("change");
                    $("#myModal").find('.modal-title').text('Edit Data');
                    $("#myModal").modal('show',{backdrop: 'true'});           
                }
            });
        }



    </script>
@endpush