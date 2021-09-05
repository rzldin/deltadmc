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
                                            class="form-control myline" style="margin-bottom:5px" placeholder="Input Company Code...">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Company Name <font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="client_name" name="client_name" 
                                            class="form-control myline" style="margin-bottom:5px"  placeholder="Input Company Name...">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        NPWP <font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="npwp" name="npwp" 
                                            class="form-control myline" style="margin-bottom:5px"  placeholder="NPWP...">
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
                                        Legal Doc
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <div class="custom-control custom-checkbox">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="legal_doc" name="legal_doc" value="1">
                                                <label for="legal_doc">
                                                    LEGAL DOC
                                                </label>
                                            </div>
                                        </div>
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
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Add To
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="customer" name="customer" value="1">
                                                    <label for="customer">
                                                        CUSTOMER
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="vendor" name="vendor" value="1">
                                                    <label for="vendor">
                                                        VENDOR
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="buyer" name="buyer" value="1">
                                                    <label for="buyer">
                                                        BUYER
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="seller" name="seller" value="1">
                                                    <label for="seller">
                                                        SELLER
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="shipper" name="shipper" value="1">
                                                    <label for="shipper">
                                                        SHIPPER
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="agent" name="agent" value="1">
                                                    <label for="agent">
                                                        AGENT
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="ppjk" name="ppjk" value="1">
                                                    <label for="ppjk">
                                                        PPJK
                                                    </label>
                                                </div>
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
    </div>
</section>
@endsection

@push('after-scripts')
    <script>
        
        $('#client_name').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        $('#client_code').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        $('#npwp').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        /** Save Data **/
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