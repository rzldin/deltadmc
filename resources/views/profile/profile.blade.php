@extends('layouts.master')


@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0">Edit Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        Form Edit
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="flash-data" data-flashdata="{{ session('status') }}"></div>
                        <div class="col-md-4 offset-md-4">
                            @if($errors->any())
                            <div class="row">
                                <div class="col-12 col-xs-12 alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                            <form action="{{ route('user.doAdd') }}" method="post" id="formku">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Name <font color="#f00">*</font></label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" readonly>
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                </div>
                                <div class="form-group">
                                    <label for="username" class="col-form-label">Username <font color="#f00">*</font></label>
                                    <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-form-label">Email <font color="#f00">*</font></label>
                                    <input type="text" class="form-control" name="email" id="email" value="{{ $user->email }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="col-form-label">Address <font color="#f00">*</font></label>
                                    <textarea name="address" id="address" cols="10" class="form-control" rows="5" readonly>{!! $user->address !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <a class="btn btn-danger btn-flat" onclick="editData();" id="btnEdit"><i class="fa fa-edit"></i> Edit</a>
                                    <button type="button" class="btn btn-success btn-flat" onclick="simpandata();" id="btnSave"><i class="fa fa-save"></i> Save</button>
                                    <a class="btn btn-warning btn-flat" onclick="change_password();"><i class="fas fa-cog"></i> Change Password</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <br>
                <div class="modal-body">
                    <form class="eventInsForm" method="post" target="_self" name="formku" id="formPassword" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="old_password" class="col-form-label">Old Password <font color="#f00">*</font></label>
                            <input type="password" class="form-control" name="old_password" id="old_password">
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">New Password <font color="#f00">*</font></label>
                            <input type="password" class="form-control" name="new_password" id="new_password">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Confirm New Password <font color="#f00">*</font></label>
                            <input type="password" id="confirm_password" name="confirm_password" 
                                   class="form-control" style="margin-bottom:5px" onkeyup="checkPassword(this.value)"  maxlength="25" value="">
                            <p class="text-muted" id="passwordWarning" style="display: none;">password does not match</p>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">                        
                    <button type="button" class="btn btn-primary" onclick="savePassword()"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('after-scripts')

  <script>
    
    $(function(){
        $('#btnSave').hide();
    });

    $(function() {
        window.setTimeout(function() {
            $('.alert-danger').hide(300);
        }, 3000);
    });

    function checkPassword(value) {
        const new_password = $('#new_password').val();
        const check = $('#confirm_password').val();
        if (new_password != check) {
            $('#confirm_password').css({ 'background-color' : '#ffc89e' });
            $('#passwordWarning').show();
        } else {
            $('#confirm_password').css({ 'background-color' : '#ffffff' });
            $('#passwordWarning').hide();
        }
    }

    function editData(){
        $('#btnEdit').hide();
        $("#name").prop('readonly', false);
        $("#email").prop('readonly', false);
        $("#username").prop('readonly', false);
        $("#address").prop('readonly', false);
        $('#btnSave').show();
    }

    function change_password()
    {
        $("#myModal").find('.modal-title').text('Change Password');
        $("#myModal").modal('show',{backdrop: 'true'}); 
    }

    function simpandata()
    {
        $(this).prop('disabled', true).text('Please Wait ...');
        $('#formku').submit();
    }

    function savePassword()
    {
        $('#formPassword').attr("action", "{{  route('user.change_password') }}");
        $('#formPassword').submit(); 
    }


  </script>
    
@endpush