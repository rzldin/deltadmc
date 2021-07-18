@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>List Users</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">list users</li>
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
                                <th width="5%">No</th>
                                <th width="30%">Name</th>
                                <th width="40%">Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_data as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $list->name }}</td>
                                <td>{{ $list->address }}</td>
                                <td align="center">
                                    @if ($list->active_flag == 1)
                                        <span class="badge badge-success">ACTIVE</span>
                                    @else
                                        <span class="badge badge-danger">NOT ACTIVE</span>
                                    @endif
                                </td>
                                <td>
                                    <a onclick="editData({{ $list->id }})" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Update </a>
                                    <a href="{{ '/master/users_delete/'.$list->id }}" class="btn btn-danger btn-xs hapus-link"><i class="fa fa-trash"></i> Delete </a>
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
                            Name <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="name" name="name" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Name ..." onkeyup="this.value = this.value.toUpperCase()">
                            <input type="hidden" id="id" name="id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Username<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="username" name="username" 
                                class="form-control myline" placeholder="Input Username .." style="margin-bottom:5px" maxlength="50">
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
                            Province<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="province" name="province" 
                                class="form-control myline" style="margin-bottom:5px"  placeholder="Input Province ...">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Address<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                           <textarea name="address" id="address" class="form-control" rows="3" placeholder="Input Address.."></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            City<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="city" name="city" 
                                class="form-control myline" style="margin-bottom:5px"  placeholder="Input City ...">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Postal Code<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="postal_code" name="postal_code" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Postal Code ...">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Phone 1<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="phone1" name="phone1" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Phone Number 1 ...">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Phone 2<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="phone2" name="phone2" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Phone Number 2 ....">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Fax<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="text" id="fax" name="fax" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Fax ....">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-xs-4">
                            Email<font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="email" id="email" name="email" 
                                class="form-control myline" style="margin-bottom:5px" placeholder="Input Email ...">
                        </div>
                    </div>
                    <div class="row pw-1">
                        <div class="col-md-4 col-xs-4">
                            Password <font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="password" id="password" name="password" 
                                class="form-control myline" style="margin-bottom:5px" maxlength="15" placeholder="Input Password ....">
                        </div>
                    </div>
                    <div class="row pw-2">
                        <div class="col-md-4 col-xs-4">
                            Password Confirm <font color="#f00">*</font>
                        </div>                                
                        <div class="col-md-8 col-xs-8">
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                class="form-control myline" style="margin-bottom:5px" onkeyup="checkPassword(this.value)" placeholder="Ulangi password" autocomplete="new-password">
                            <p class="text-muted" id="passwordWarning" style="display: none;">Password tidak sesuai</p>
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
            $('#name').val('');
            $('#username').val('');
            $('#country').val();
            $('#address').val('');
            $('#city').val('');
            $('#province').val('');
            $('#postal_code').val('');
            $('#phone1').val('');
            $('#phone2').val('');
            $('#fax').val('');
            $('#email').val('');
            $('#password').val('');
            $('.pw-1').show();
            $('.pw-2').show();
            dsState = "Input";
            
            $("#myModal").find('.modal-title').text('Add Data');
            $("#myModal").modal('show',{backdrop: 'true'}); 
        }

        function simpandata(){
            if($.trim($("#name").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Name Users!',
                    icon: 'error'
                })
            }else if($.trim($("#username").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Username!',
                    icon: 'error'
                })
            }else if($.trim($("#country").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please Select Country!',
                    icon: 'error'
                })
            }else if($.trim($("#address").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please input Address!',
                    icon: 'error'
                })
            }else if($.trim($("#email").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please input Email!',
                    icon: 'error'
                })
            }else{
                if(dsState=="Input"){
                    $.ajax({
                        type:"POST",
                        url:"{{ route('master.cek_username') }}",
                        data:"data="+$("#username").val(),
                        success:function(result){
                            if(result=="duplicate"){
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Username Existing!',
                                    icon: 'error'
                                })
                            }else{
                                $('#formku').attr("action", "{{ route('master.user_doAdd') }}");
                                $('#formku').submit();              
                            }
                        }
                    });
                }else{
                    $('#formku').attr("action", "{{ route('master.user_doEdit') }}");
                    $('#formku').submit(); 
                }
            }
            
        };

        function editData(id){
            dsState = "Edit";
            $.ajax({
                type: "POST",
                url: "{{ route('master.users_get') }}",
                dataType: 'json',
                data : {id: id},
                success: function (result){
                    $('#id').val(result.id);
                    $('#name').val(result.name);
                    $('#username').val(result.username);
                    $('#country').val(result.t_mcountry_id).trigger("change");
                    $('#province').val(result.province);
                    $('#address').val(result.address);
                    $('#city').val(result.city);
                    $('#postal_code').val(result.postal_code);
                    $('#phone1').val(result.phone1);
                    $('#phone2').val(result.phone2);
                    $('#fax').val(result.fax);
                    $('#email').val(result.email);
                    $('.pw-1').hide();
                    $('.pw-2').hide();

                    $("#myModal").find('.modal-title').text('Edit Data');
                    $("#myModal").modal('show',{backdrop: 'true'});           
                }
            });
        }

        function checkPassword(value) {
            const password = $('#password').val();
            const check = $('#password_confirmation').val();
            if (password != check) {
                $('#password_confirmation').css({ 'background-color' : '#ffc89e' });
                $('#passwordWarning').show();
            } else {
                $('#password_confirmation').css({ 'background-color' : '#ffffff' });
                $('#passwordWarning').hide();
            }
        }

    </script>
@endpush