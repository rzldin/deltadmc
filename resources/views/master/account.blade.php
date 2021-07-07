@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>List Account</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">list Account</li>
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
                    @if (isset($errors) && count($errors))

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }} </li>
                        @endforeach
                    </ul>
    
            @endif
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Account Number</th>
                                <th>Account Name</th>
                                <th>Account Type</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_data as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $list->account_number }}</td>
                                <td>{{ $list->account_name }}</td>
                                <td>{{ $list->account_type }}</td>
                                <td>{{ number_format($list->beginning_ballance,2) }}</td>
                                <td align="center">
                                    @if ($list->active_flag == 1)
                                        <span class="badge badge-success">ACTIVE</span>
                                    @else
                                        <span class="badge badge-danger">NOT ACTIVE</span>
                                    @endif
                                </td>
                                <td>
                                    <a onclick="editData({{ $list->id }})" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Update </a>
                                    <a href="{{ '/master/account_delete/'.$list->id }}" class="btn btn-danger btn-xs hapus-link"><i class="fa fa-trash"></i> Delete </a>
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
                            Account Number <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="account_number" name="account_number" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Account Number ..." onkeyup="this.value = this.value.toUpperCase()">
                            <input type="hidden" id="id" name="id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Account Name<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="account_name" name="account_name" 
                                class="form-control myline" placeholder="Input Account Name .." style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Account Type <font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs4" style="width: 100%;margin-bottom:5px;" name="account_type" id="account_type">
                                <option value="" disabled selected>-- Select Account Type --</option>
                                <option value="Cash/Bank">Cash/Bank</option>
                                <option value="Fixed Asset">Fixed Asset</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Segment <font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs4" style="width: 100%;margin-bottom:5px;" name="segment" id="segment">
                                <option value="" disabled selected>-- Select Segment --</option>
                                @foreach ($list_segment as $ls)
                                <option value="{{ $ls->id }}">{{ $ls->segment_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Parent Account<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs4" style="width: 100%;margin-bottom:5px;" name="parent_account" id="parent_account">
                                <option value="" disabled selected>-- Select Parent Account --</option>
                                @foreach ($list_parent as $ls)
                                <option value="{{ $ls->account_number }}">{{ $ls->account_number }} || {{ $ls->account_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Beginning Balance<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="beginning_balance" name="beginning_ballance" 
                                class="form-control myline" style="margin-bottom:5px" onkeyup="numberOnly(this);"  placeholder="Input Beginning Balance ...">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Start Date<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="date" id="start_date" name="start_date" 
                                class="form-control myline" style="margin-bottom:5px"  placeholder="Input City ...">
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
            $('#account_number').val('');
            $('#account_name').val('');
            $('#account_type').val();
            $('#segment').val('');
            $('#parent_account').val('');
            $('#beginning_balance').val('');
            $('#start_date').val('');
            dsState = "Input";
            
            $("#myModal").find('.modal-title').text('Add Data');
            $("#myModal").modal('show',{backdrop: 'true'}); 
        }

        function simpandata(){
            if($.trim($("#account_number").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Account Number!',
                    icon: 'error'
                })
            }else if($.trim($("#account_name").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Account Name!',
                    icon: 'error'
                })
            }else if($.trim($("#account_type").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Account Type!',
                    icon: 'error'
                })
            }else{
                if(dsState=="Input"){                
                    $('#formku').attr("action", "{{ route('master.account_doAdd') }}");
                    $('#formku').submit();              
                }else{
                    $('#formku').attr("action", "{{ route('master.account_doEdit') }}");
                    $('#formku').submit(); 
                }
            }
            
        };

        function editData(id){
            dsState = "Edit";
            $.ajax({
                type: "POST",
                url: "{{ route('master.account_get') }}",
                dataType: 'json',
                data : {id: id},
                success: function (result){
                    $('#id').val(result.id);
                    $('#account_number').val(result.account_number);
                    $('#account_name').val(result.account_name);
                    $('#account_type').val(result.account_type).trigger("change");
                    $('#segment').val(result.segment_no).trigger("change");
                    $('#parent_account').val(result.parent_account).trigger("change");
                    $('#beginning_balance').val(result.beginning_ballance);
                    $('#start_date').val(result.start_date);
                    $('#status').val(result.active_flag);

                    $("#myModal").find('.modal-title').text('Edit Data');
                    $("#myModal").modal('show',{backdrop: 'true'});           
                }
            });
        }

    </script>
@endpush