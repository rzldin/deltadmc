@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>List Of Account Type</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">List Of Account Type</li>
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
                @if(count($errors)>0)
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>          
                    @endforeach
                @endif
                <div class="flash-data" data-flashdata="{{ session('status') }}">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Account Type Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_data as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $list->type_name }}</td>
                                <td>
                                    <a onclick="editData({{ $list->id }})" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit </a>
                                    <a href="{{ '/master/acc_type_delete/'.$list->id }}" class="btn btn-danger btn-xs hapus-link"><i class="fa fa-trash"></i> Delete </a>
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
                    <input type="hidden" id="id" name="id">
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Account Type Name<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="account_name" name="account_name" 
                                class="form-control myline" placeholder="Input Account Type Name .." style="margin-bottom:5px">
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
            $('#account_name').val('');
            dsState = "Input";
            
            $("#myModal").find('.modal-title').text('Add Data');
            $("#myModal").modal('show',{backdrop: 'true'}); 
        }

        function simpandata(){
            if($.trim($("#account_name").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Account Type Name!',
                    icon: 'error'
                })
            }else{
                if(dsState=="Input"){                
                    $('#formku').attr("action", "{{ route('master.acc_type_doAdd') }}");
                    $('#formku').submit();              
                }else{
                    $('#formku').attr("action", "{{ route('master.acc_type_doEdit') }}");
                    $('#formku').submit(); 
                }
            }
            
        };

        function editData(id){
            dsState = "Edit";
            $.ajax({
                type: "POST",
                url: "{{ route('master.acc_type_get') }}",
                dataType: 'json',
                data : {id: id},
                success: function (result){
                    $('#id').val(result.id);
                    $('#account_name').val(result.type_name);

                    $("#myModal").find('.modal-title').text('Edit Data');
                    $("#myModal").modal('show',{backdrop: 'true'});           
                }
            });
        }

    </script>
@endpush