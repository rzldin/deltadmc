@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Company Detail</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Company Detail</li>
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
                            Headers
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="container">
                            <form action="{{ url('master/company_doUpdate/'.$company->id) }}" class="eventInsForm" method="post" target="_self" name="formku" id="formku" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            <div class="col-md-8">
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-xs-4">
                                        Company Code <font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="client_code" name="client_code" 
                                            class="form-control myline" style="margin-bottom:5px" placeholder="Input Company Code..." value="{{ $company->client_code }}">
                                        <input type="hidden" id="id_company" name="id_company" value="{{ $company->id }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Company Name <font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="client_name" name="client_name" 
                                            class="form-control myline" style="margin-bottom:5px"  placeholder="Input Company Name..." value="{{ $company->client_name }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        NPWP <font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="npwp" name="npwp" 
                                            class="form-control myline" style="margin-bottom:5px"  placeholder="NPWP..." value="{{ $company->npwp }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Account <font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="account" id="account">
                                            <option value="" disabled>-- Select Account --</option>
                                            @foreach ($list_account as $account)
                                            <option value="{{ $account->id }}" @if ($company->t_maccount_id == $account->id) selected
                                            @endif>{{ $account->account_name }}</option>
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
                                            <option value="" disabled>-- Select Sales --</option>
                                            @foreach ($list_sales as $sales)
                                            <option value="{{ $sales->user_id }}" @if ($company->sales_by == $sales->user_id) selected
                                                
                                            @endif>{{ $sales->user_name }}</option>
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
                                                <input type="checkbox" id="legal_doc" name="legal_doc" value="1" @if ($company->legal_doc_flag == 1)
                                                    checked
                                                @endif>
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
                                                <input type="checkbox" id="status" name="status" value="1" @if ($company->active_flag == 1)
                                                    checked
                                                @endif>
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
                                                    <input type="checkbox" id="customer" name="customer" value="1" @if ($company->customer_flag == 1) checked @endif>
                                                    <label for="customer">
                                                        CUSTOMER
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="vendor" name="vendor" value="1" @if ($company->vendor_flag == 1) checked 
                                                    @endif>
                                                    <label for="vendor">
                                                        VENDOR
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="buyer" name="buyer" value="1" @if ($company->buyer_flag == 1) checked
                                                    @endif>
                                                    <label for="buyer">
                                                        BUYER
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="seller" name="seller" value="1" @if ($company->seller_flag == 1) checked @endif>
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
                                                    <input type="checkbox" id="shipper" name="shipper" value="1" @if ($company->shipping_line_flag == 1) checked @endif>
                                                    <label for="shipper">
                                                        SHIPPER
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="agent" name="agent" value="1" @if ($company->agent_flag == 1) checked @endif>
                                                    <label for="agent">
                                                        AGENT
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="ppjk" name="ppjk" value="1" @if ($company->ppjk_flag == 1) checked @endif>
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
                    </form>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tittle">
                            <i class="fa fa-map"></i> Address
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table_lowm table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Address Type</th>
                                    <th>Country</th>
                                    <th>Province</th>
                                    <th>City</th>
                                    <th>Postal Code</th> 
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tbody id="tblDetail">
                                </tbody>
                                <tr>
                                    <td><i class="fa fa-plus"></i></td>
                                    <td>
                                        <select class="form-control select2bs44" name="address_type" id="address_type_1">
                                            <option value="" selected>Silahkan Pilih ...</option>
                                            <option value="UTAMA">UTAMA</option>
                                            <option value="GUDANG">GUDANG</option>
                                            <option value="INVOICE">INVOICE</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select2bs44" name="country" id="country_1">
                                            <option value="" selected>Silahkan Pilih ...</option>
                                            @foreach ($list_country as $country)
                                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="province" id="province_1" placeholder="Input Province...">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="city" id="city_1" placeholder="Input City ...">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="postal_code" id="postal_code_1" placeholder="Input Postal Code ...">
                                    </td>
                                    <td>
                                        <textarea name="address" class="form-control" id="address_1" rows="3"></textarea>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-control" name="status" id="status_1" style="width: 15px" value="1" checked>Active
                                    </td>
                                    <td>
                                        <button class="btn btn-block btn-outline-success btn-xs" onclick="saveDetail(1)"><i class="fa fa-plus"></i><span id="add_address">Add</span></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tittle">
                            <i class="fa fa-user-plus"></i> PIC
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table_lowm table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Name</th>
                                    <th>Phone 1</th>
                                    <th>Phone 2</th>
                                    <th>Fax</th>
                                    <th>Email</th> 
                                    <th>PIC Desc</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody id="tblDetailx">
                            </tbody>

                                <tr>
                                    <td><i class="fa fa-plus"></i></td>
                                    <td>
                                        <input type="text" class="form-control" name="pic_name" id="pic_name_1" placeholder="Input Name..">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="phone1" id="phonex_1" placeholder="Input Phone Number ..." onkeyup="numberOnly(this);">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="phone2" id="phonexx_1" placeholder="Input Phone Number 2 ..." onkeyup="numberOnly(this);">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="fax" id="fax_1" placeholder="Input Fax ...">
                                    </td>
                                    <td>
                                        <input type="email" class="form-control" name="email" id="email_1" placeholder="Input Email ..." onkeyup="ValidateEmail();">
                                        <span id="lblError_1" style="color: red"></span>
                                    </td>
                                    <td>
                                        <textarea name="desc" class="form-control" id="pic_desc_1" rows="3" placeholder="PIC Desc..."></textarea>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-control" name="status" id="status_1" style="width: 15px" value="1" checked>Active
                                    </td>
                                    <td>
                                        <button class="btn btn-block btn-outline-success btn-xs" onclick="savexDetail(1)"><i class="fa fa-plus"></i><span id="add_pic">Add</span></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('master.company') }}" class="btn btn-default float-left mr-2"> 
                        <i class="fa fa-angle-left"></i> Back 
                    </a>
                    <button type="button" class="btn btn-primary mb-4 float-right" id="update_company_detail">
                        <i class="fa fa-save"></i> Save
                    </button>
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

        $('#province_1').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        $('#city_1').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        $('#postal_code_1').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        $('#address_1').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        $('#pic_name_1').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });

        $('#pic_desc_1').keyup(function(){
            let position = this.selectionStart
            this.value = this.value.toUpperCase();
            this.selectionEnd = position;
        });


        function ValidateEmail() {
            let email = $("#email_1").val();
            let lblError = document.getElementById("lblError_1");
            lblError.innerHTML = "";
            let expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (!expr.test(email)) {
                lblError.innerHTML = "Invalid email address.";
            }
        }

        
        $("#update_company_detail").click(function(){
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

        function loadDetail(id){
            $.ajax({
                type:"POST",
                url:"{{ route('master.company_loadDetail') }}",
                data:"id="+id,
                dataType:"json",
                success:function(result){
                   let no = 2;
                   let tabel = '';
                   let status = '';
                   let style = '';
                   $.each(result, function(i,data){
                        if(data.active_flag == 1){
                            status = '<span class="badge badge-success">active</span>';
                            style  = 'checked';
                        }else{
                            status = '<span class="badge badge-danger">not active</span>';
                            style = '';
                        }
                        tabel += `<tr>
                            <td class="text-center" style="font-size:12px;">${no-1}</td>
                            <td><label id="lbl_address_type_${no}" style="font-size:12px;">${data.address_type}</label>
                            <select id="address_type_${no}" name="address_type" class="form-control" data-placeholder="Pilih..." style="margin-bottom:5px; display:none">
                                <option value="" >--Silahkan Pilih --</option>
                                
                            </select>
                            </td>
                            <td><label id="lbl_country_${no}" style="font-size:12px;">${data.country_name}</label><select id="country_${no}" name="country" class="form-control select2bs44" data-placeholder="Pilih..." style="margin-bottom:5px; display:none">
                                <option value="">--Silahkan Pilih--</option>
                            </select></td>
                            <td><label id="lbl_province_${no}" style="font-size:12px;">${data.province}</label><input type="text" id="province_${no}" name="province" class="form-control" value="${data.province}" onkeyup="province_font('${no}')" style="display:none"></td>
                            <td><label id="lbl_city_${no}" style="font-size:12px;">${data.city}</label><input type="text" id="city_${no}" name="city" class="form-control" value="${data.city}" style="display:none" onkeyup="city_font('${no}')"></td>
                            <td><label id="lbl_postal_code_${no}" style="font-size:12px;">${data.postal_code}</label><input type="text" id="postal_code_${no}" name="postal_code" class="form-control" style="display:none" value="${data.postal_code}" onkeyup="postal_code_font('${no}')"></td>
                            <td><label id="lbl_address_${no}" style="font-size:12px;">${data.address}</label>
                            <input type="text" id="address_${no}" name="address" class="form-control" style="display:none" value="${data.address}" onkeyup="address_font('${no}')"></td>
                            <td class="text-center" id="td_status_${no}"><label id="lbl_status_${no}">${status}</label>
                           </td>
                            '<td style="text-align:center;"><a href="javascript:;" class="btn btn-xs btn-circle btn-primary" onclick="editDetail('${data.t_mcountry_id}','${data.address_type}','${no}','${style}');" style="margin-top:5px;" id="btnEdit_${no}"><i class="fa fa-edit"></i></a><a href="javascript:;" class="btn btn-xs btn-circle btn-success" onclick="updateDetail('${data.id}','${no}');" style="margin-top:5px; display:none" id="btnUpdate_${no}"><i class="fa fa-save"></i></a><a href="javascript:;" class="btn btn-xs btn-circle btn-danger" onclick="hapusDetail(${data.id});" style="margin-top:5px">
                            <i class="fa fa-trash"></i> </a></td>
                        </tr>;
                        `
                        no++;
                    })
                    $('#tblDetail').html(tabel);
                }
            })
        }


        function province_font(id){
            $('#province_'+id).keyup(function(){
                let position = this.selectionStart
                this.value = this.value.toUpperCase();
                this.selectionEnd = position;
            });
        }

        function city_font(id){
            $('#city_'+id).keyup(function(){
                let position = this.selectionStart
                this.value = this.value.toUpperCase();
                this.selectionEnd = position;
            });
        }

        function postal_code_font(id){
            $('#postal_code_'+id).keyup(function(){
                let position = this.selectionStart
                this.value = this.value.toUpperCase();
                this.selectionEnd = position;
            });
        }

        function address_font(id){
            $('#address_'+id).keyup(function(){
                let position = this.selectionStart
                this.value = this.value.toUpperCase();
                this.selectionEnd = position;
            });
        }


        /** Load Detail PIC **/
        function loadDetailx(id){
            $.ajax({
                type:"POST",
                url:"{{ route('master.company_loadDetailPic') }}",
                data:"id="+id,
                dataType:"json",
                success:function(result){
                   let no = 2;
                   let tabel = '';
                   let status = '';
                   let style = '';
                   $.each(result, function(i,data){
                        if(data.active_flag == 1){
                            status = '<span class="badge badge-success">active</span>';
                            style  = 'checked';
                        }else{
                            status = '<span class="badge badge-danger">not active</span>';
                            style = '';
                        }
                        tabel += `<tr>
                            <td class="text-center" style="font-size:12px;">${no-1}</td>
                            <td><label id="lbl_pic_name_${no}" style="font-size:12px;">${data.name}</label>
                                <input type="text" id="pic_name_${no}" name="pic_name" class="form-control" value="${data.name}" style="display:none" onkeyup="pic_font('${no}')">
                            </td>
                            <td><label id="lbl_phonex_${no}" style="font-size:12px;">${data.phone1}</label>
                            <input type="text" id="phonex_${no}" name="phone1" class="form-control" value="${data.phone1}" style="display:none" onkeyup="numberOnly(this);">
                            </td>
                            <td><label id="lbl_phonexx_${no}" style="font-size:12px;">${data.phone2}</label>
                            <input type="text" id="phonexx_${no}" name="phone2" class="form-control" value="${data.phone2}" style="display:none" onkeyup="numberOnly(this);">
                            </td>
                            <td><label id="lbl_fax_${no}" style="font-size:12px;">${data.fax}</label>
                            <input type="text" id="fax_${no}" name="fax" class="form-control" value="${data.fax}" style="display:none"></td>
                            <td><label id="lbl_email_${no}" style="font-size:12px;">${data.email}</label>
                            <input type="email" id="email_${no}" name="email" class="form-control" style="display:none" value="${data.email}" onkeyup="emailVerif('${no}')"><span id="lblError_${no}" style="color: red"></span>
                            </td>
                            <td><label id="lbl_pic_desc_${no}" style="font-size:12px;">${data.pic_desc}</label>
                            <input type="text" id="pic_desc_${no}" name="desc" class="form-control" style="display:none" value="${data.pic_desc}" onkeyup="pic_desc_font('${no}')"></td>
                            <td class="text-center" id="td_statusx_${no}"><label id="lbl_statusx_${no}">${status}</label>
                           </td>
                            '<td style="text-align:center;"><a href="javascript:;" class="btn btn-xs btn-circle btn-primary" onclick="editDetailx('${no}','${style}');" style="margin-top:5px" id="btnEditx_${no}"><i class="fa fa-edit"></i></a><a href="javascript:;" class="btn btn-xs btn-circle btn-success" onclick="updateDetailx('${data.id}','${no}');" style="margin-top:5px; display:none" id="btnUpdatex_${no}"><i class="fa fa-save"></i> </a><a href="javascript:;" class="btn btn-xs btn-circle btn-danger" onclick="hapusDetailx(${data.id});" style="margin-top:5px">
                            <i class="fa fa-trash"></i> </a></td>
                        </tr>;
                        `
                        no++;
                   })
                    $('#tblDetailx').html(tabel);
                }
            })
        }

        function pic_font(id){
            $('#pic_name_'+id).keyup(function(){
                let position = this.selectionStart
                this.value = this.value.toUpperCase();
                this.selectionEnd = position;
            });
        }

        function pic_desc_font(id){
            $('#pic_desc_'+id).keyup(function(){
                let position = this.selectionStart
                this.value = this.value.toUpperCase();
                this.selectionEnd = position;
            });
        }

        function emailVerif(id) {
            let email = $("#email_"+id).val();
            let lblError = document.getElementById("lblError_"+id);
            lblError.innerHTML = "";
            let expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (!expr.test(email)) {
                lblError.innerHTML = "Invalid email address.";
            }
        }

        function hapusDetail(id){
            var r=confirm("Anda yakin menghapus address?");
            if (r==true){
                $.ajax({
                    type:"POST",
                    url:"{{ route('master.company_deleteAddress') }}",
                    data:"id="+ id,
                    success:function(result){
                        loadDetail($('#id_company').val());   
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Menghapus address!');
				    }, 
                });
            }
        }


        /** Hapus PIC **/
        function hapusDetailx(id){
            var r=confirm("Anda yakin menghapus PIC?");
            if (r==true){
                $.ajax({
                    type:"POST",
                    url:"{{ route('master.company_deletePic') }}",
                    data:"id="+ id,
                    success:function(result){
                        loadDetailx($('#id_company').val());   
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Menghapus PIC!');
				    }, 
                });
            }
        }
        


        /** Edit Detail Address **/
        function editDetail(id_country,address_type,id,c){
            let html = '';
            let country = '';
            let type = '';
            let cek = '';

            $.ajax({
                url: "{{ route('master.country_getAll') }}",
                type: "POST",
                dataType: "json",
                success: function(result) {
                    if(address_type == 'UTAMA'){
                        type += `<option value="UTAMA" selected>UTAMA</option>
                                <option value="GUDANG">GUDANG</option>
                                <option value="INVOICE">INVOICE</option>`;
                    }else if(address_type == 'GUDANG'){
                        type += `<option value="UTAMA">UTAMA</option>
                                <option value="GUDANG" selected>GUDANG</option>
                                <option value="INVOICE">INVOICE</option>`;
                    }else if(address_type == 'INVOICE'){
                        type += `<option value="UTAMA">UTAMA</option>
                                <option value="GUDANG">GUDANG</option>
                                <option value="INVOICE" selected>INVOICE</option>`;
                    }   
                    
                    cek += `<input type="checkbox" id="status_${id}" name="status" style="width: 15px" class="form-control" value="1" style="display:none" ${c}> Active`
                    
                    $.each(result, function(i,data){
                        if(id_country == data.id){
                            country = 'selected';
                        }else{
                            country = '';
                        }
                        html += `<option value="${data.id}" ${country}>${data.country_name}</option>`;
                    })


                    $('#btnEdit_'+id).hide();
                    $('#lbl_address_type_'+id).hide();
                    $('#lbl_country_'+id).hide();
                    $('#lbl_province_'+id).hide();
                    $('#lbl_city_'+id).hide();
                    $('#lbl_postal_code_'+id).hide();
                    $('#lbl_address_'+id).hide();
                    $('#lbl_status_'+id).hide();

                    $("#address_type_"+id).show();
                    $("#address_type_"+id).html(type);
                    $("#address_type_"+id).select2({
                        theme: 'bootstrap4'
                    });
                    $('#btnUpdate_'+id).show();
                    $('#country_'+id).show();
                    $('#country_'+id).html(html);
                    $("#country_"+id).select2({
                        theme: 'bootstrap4'
                    });

                    $('#td_status_'+id).html(cek)

                    $('#province_'+id).show();
                    $('#city_'+id).show();
                    $('#postal_code_'+id).show();
                    $('#address_'+id).show();
                    $('#status_'+id).show();
                }
            });
        }


        /** Edit Detail PIC **/
        function editDetailx(id,c){
            let cek = '';

            cek += `<input type="checkbox" id="statusx_${id}" name="status" style="width: 15px" class="form-control" value="1" style="display:none" ${c}> Active`;

            $('#btnEditx_'+id).hide();
            $('#lbl_pic_name_'+id).hide();
            $('#lbl_phonex_'+id).hide();
            $('#lbl_phonexx_'+id).hide();
            $('#lbl_fax_'+id).hide();
            $('#lbl_email_'+id).hide();
            $('#lbl_pic_desc_'+id).hide();
            $('#lbl_statusx_'+id).hide();

            $('#btnUpdatex_'+id).show();
            $('#pic_name_'+id).show();
            $('#phonex_'+id).show();
            $('#phonexx_'+id).show();
            $('#fax_'+id).show();
            $('#email_'+id).show();
            $('#pic_desc_'+id).show();

            $('#td_statusx_'+id).html(cek)

            
        }


        /** Update Detail PIC **/
        function updateDetailx(id_detail,id){
            if($.trim($("#pic_name_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input PIC Name!'
                })
            }else if($.trim($("#phonex_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input Phone Number!'
                });
            }else if($.trim($("#email_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input Email!'
                });
            }else if($.trim($("#pic_desc_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input PIC Desc!'
                });
            }else{
                $.ajax({
                    type:"POST",
                    url:"{{ route('master.company_updatePic') }}",
                    data:{
                        id:id_detail,
                        name:$('#pic_name_'+id).val(),
                        desc:$('#pic_desc_'+id).val(),
                        phone1:$('#phonex_'+id).val(),
                        phone2:$('#phonexx_'+id).val(),
                        fax:$('#fax_'+id).val(),
                        email:$('#email_'+id).val(),
                        status:$('#statusx_'+id).val()
                    },
                    success:function(result){
                        loadDetailx($('#id_company').val()); 
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Mengupdate address!');
				    },          
                });
            }
        }



        /** Update Detail Address **/
        function updateDetail(id_detail,id){
            if($.trim($("#address_type_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please select Type Address!'
                })
            }else if($.trim($("#country_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please select Country!'
                });
            }else if($.trim($("#province_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input Province!'
                });
            }else{
                $.ajax({
                    type:"POST",
                    url:"{{ route('master.company_updateAddress') }}",
                    data:{
                        id:id_detail,
                        address_type:$('#address_type_'+id).val(),
                        country:$('#country_'+id).val(),
                        province:$('#province_'+id).val(),
                        city:$('#city_'+id).val(),
                        postal_code:$('#postal_code_'+id).val(),
                        address:$('#address_'+id).val(),
                        status:$('#status_'+id).val()
                    },
                    success:function(result){
                        loadDetail($('#id_company').val()); 
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Mengupdate address!');
				    },          
                });
            }
        }

        
        /** Save Detail Address **/
        function saveDetail(id){
            if($.trim($("#address_type_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please select Type Address!'
                })
            }else if($.trim($("#country_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please select Country!'
                });
            }else if($.trim($("#province_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input Province!'
                });
            }else if($.trim($("#province_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input Province!'
                });
            }else{
                $('#add_address').text('Please Wait...');
                $.ajax({
                type:"POST",
                url:"{{ route('master.company_addAddress') }}",
                data:{
                    company:{{ $company->id }},
                    address_type:$('#address_type_'+id).val(),
                    country:$('#country_'+id).val(),
                    province:$('#province_'+id).val(),
                    city:$('#city_'+id).val(),
                    postal_code:$('#postal_code_'+id).val(),
                    address:$('#address_'+id).val(),
                    status:$('#status_'+id).val()
                },
                success:function(result){
                    $('#add_address').text('Add');
                    $('#address_type_'+id).val('').trigger('change');
                    $("#country_"+id).val('').trigger('change');
                    $('#province_'+id).val('');
                    $('#city_'+id).val('');
                    $('#postal_code_'+id).val('');
                    $('#address_'+id).val('');
                    loadDetail($('#id_company').val());
                },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal menambahkan item!');
				    },  
                });
            }
        }

        /** Save Detail PIC **/
        function savexDetail(id){
            if($.trim($("#pic_name_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input PIC Name!'
                })
            }else if($.trim($("#phonex_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input Phone Number!'
                });
            }else if($.trim($("#email_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input Email!'
                });
            }else{
                $('#add_pic').text('Please Wait ...').prop('disabled', true);
                $.ajax({
                    type:"POST",
                    url:"{{ route('master.company_addPic') }}",
                    data:{
                        company:{{ $company->id }},
                        pic_name:$('#pic_name_'+id).val(),
                        phone1:$('#phonex_'+id).val(),
                        phone2:$('#phonexx_'+id).val(),
                        email:$('#email_'+id).val(),
                        fax:$('#fax_'+id).val(),
                        desc:$('#pic_desc_'+id).val(),
                        status:$('#status_'+id).val()
                    },
                    success:function(result){
                        console.log(result);
                        $('#add_pic').text('Add').prop('disabled', false);
                        $('#pic_name_'+id).val('');
                        $("#phonex_"+id).val('');
                        $('#phonexx_'+id).val('');
                        $('#email_'+id).val('');
                        $('#fax_'+id).val('');
                        $('#pic_desc_'+id).val('');
                        loadDetailx($('#id_company').val());
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal menambahkan PIC!');
                    },  
                });
            }
        }


        function numberOnly(root){
            var reet = root.value;    
            var arr1=reet.length;      
            var ruut = reet.charAt(arr1-1);   
                if (reet.length > 0){   
                        var regex = /[0-9]|\./;   
                    if (!ruut.match(regex)){   
                        var reet = reet.slice(0, -1);   
                        $(root).val(reet);   
                    }   
                }  
        }
            
        $(function() {
            loadDetail({{ Request::segment(3) }});
            loadDetailx({{ Request::segment(3) }});
        });
        
    </script>
@endpush