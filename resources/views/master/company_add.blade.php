@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Company</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Add Company</li>
          </ol>
        </div>
      </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">
                        Form
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="container">
                        <form action="{{ route('master.company_doAdd') }}" id="formku" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-md-8">
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-xs-4">
                                        Company Code <font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="client_code" name="client_code" 
                                            class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()" placeholder="Input Company Code...">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Company Name <font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="client_name" name="client_name" 
                                            class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()"  placeholder="Input Company Name...">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                       NPWP <font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="npwp" name="npwp" 
                                            class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()"  placeholder="NPWP...">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                       Account <font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="account" id="account">
                                            <option value="" disabled selected>-- Select Account --</option>
                                            @foreach ($list_account as $account)
                                            <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                       Sales By <font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="sales" id="sales">
                                            <option value="" disabled selected>-- Select Sales --</option>
                                            @foreach ($list_sales as $sales)
                                            <option value="{{ $sales->user_id }}">{{ $sales->user_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Status <font color="#f00">*</font>
                                     </div>                                
                                     <div class="col-md-8 col-xs-8">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="customCheckbox11" name="status" value="1" checked>
                                                <label for="customCheckbox1" class="custom-control-label">ACTIVE</label>
                                            </div>
                                     </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Add To
                                    </div>
                                    <div class="col-md-4">
                                      <!-- checkbox -->
                                      <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                          <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="customer" value="1">
                                          <label for="customCheckbox1" class="custom-control-label">CUSTOMER</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox2" name="vendor" value="1">
                                            <label for="customCheckbox2" class="custom-control-label">VENDOR</label>
                                          </div>
                                          <div class="custom-control custom-checkbox mt-2">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox3" name="buyer" value="1">
                                            <label for="customCheckbox3" class="custom-control-label">BUYER</label>
                                          </div>
                                          <div class="custom-control custom-checkbox mt-2">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox4" name="seller" value="1">
                                            <label for="customCheckbox4" class="custom-control-label">SELLER</label>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <!-- radio -->
                                      <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox5" name="shipper" value="1">
                                            <label for="customCheckbox5" class="custom-control-label">SHIPPER</label>
                                          </div>
                                          <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox6" name="agent" value="1">
                                            <label for="customCheckbox6" class="custom-control-label">AGENT</label>
                                          </div>
                                          <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox7" name="ppjk" value="1">
                                            <label for="customCheckbox7" class="custom-control-label">PPJK</label>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('master.company') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
                    <button type="button" class="btn btn-primary float-right" id="saveData"><i class="fa fa-paper-plane"></i> Submit</button>
                </div>
                <form/>
            </div>
        </div>
    </div>
</section>
@endsection

@push('after-scripts')
    <script>
        $("#saveData").click(function(){
            if($.trim($("#client_code").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Company Code',
                    icon: 'error'
                })
            }else if($.trim($("#client_name").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Company Name',
                    icon: 'error'
                })
            }else if($.trim($("#npwp").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter NPWP',
                    icon: 'error'
                })
            }else if($.trim($("#account").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select Account',
                    icon: 'error'
                })
            }else if($.trim($("#sales").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select Sales',
                    icon: 'error'
                })
            }else{
                $(this).prop('disabled', true).text('Please Wait ...');
                $('#formku').submit();
            }
        });
        
    </script>
@endpush