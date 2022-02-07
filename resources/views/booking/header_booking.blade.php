@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-plus"></i>
                Create Booking
            </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Booking</li>
          </ol>
        </div>
      </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">
                            <strong>Header</strong>
                        </h3>
                        <h5 class="card-tittle float-right">
                            {{ ucwords($quote->activity) }}
                        </h5>
                    </div>
                    @if($errors->any())
                        <div class="row">
                            <div class="col-12 alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button class="close" onclick="$('.alert').hide()"><i class="fa fa-close"></i></button>
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('booking.doAdd') }}" class="eventInsForm" method="post" target="_self" name="formku" id="formku" action=""> 
                        {{ csrf_field() }}
                    <input type="hidden" id="t_mloaded_type_id" name="t_mloaded_type_id" value="{{ $quote->t_mloaded_type_id }}">
                    <div class="card-body">
                        <div class="container-fluid mt-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="add_booking" value="true">
                                    @if ($quote->activity == 'domestic')
                                    {{\App\Http\Controllers\BookingController::header_domestic($quote)}}
                                    @elseif($quote->activity == 'export')
                                    {{\App\Http\Controllers\BookingController::header_export($quote)}}
                                    @elseif($quote->activity == 'import')
                                    {{\App\Http\Controllers\BookingController::header_import($quote)}}
                                    @endif
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary float-right" id="saveData"><i class="fa fa-paper-plane"></i> Submit</button>
                    </div>  
                    </form> 
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Customer -->
    <div class="modal fade" id="add-customer" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <br>
                <div class="modal-body">
                    <form class="eventInsForm" method="post" target="_self" name="formRoad" 
                            id="formRoad" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Company Code <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="client_code" name="client_code" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Company Code...">
                                <input type="hidden" id="company_type">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Company Name <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="client_name" name="client_name" 
                                    class="form-control myline" style="margin-bottom:5px"  placeholder="Input Company Name...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Tax ID <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="npwp" name="npwp" 
                                    class="form-control myline" style="margin-bottom:5px"  placeholder="Tax ID...">
                            </div>
                        </div>
                        <div class="row mt-2">
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
                        <div class="row mt-2">
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
                                            <input type="checkbox" id="vendor_mdl" name="vendor_mdl" value="1">
                                            <label for="vendor_mdl">
                                                VENDOR
                                            </label>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="buyer_mdl" name="buyer" value="1">
                                            <label for="buyer_mdl">
                                                BUYER
                                            </label>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="seller_mdl" name="seller" value="1">
                                            <label for="seller_mdl">
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
                                            <input type="checkbox" id="shipper_mdl" name="shipper" value="1">
                                            <label for="shipper_mdl">
                                                SHIPPER
                                            </label>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="agent_mdl" name="agent" value="1">
                                            <label for="agent_mdl">
                                                AGENT
                                            </label>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="ppjk_mdl" name="ppjk" value="1">
                                            <label for="ppjk_mdl">
                                                PPJK
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">                        
                    <button type="button" class="btn btn-primary" onClick="saveCustomer();"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add PIC -->
    <div class="modal fade" id="add-pic" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <br>
                <div class="modal-body">
                    <form class="eventInsForm" method="post" target="_self" name="formku" 
                          id="formRoad" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                PIC Name <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" class="form-control" name="pic_name" id="pic_name" placeholder="Input Name..">
                                <input type="hidden" id="company_id_pic">
                                <input type="hidden" id="pic_type">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Phone 1 <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" class="form-control" name="phone1" id="phonex" placeholder="Input Phone Number ..." onkeyup="numberOnly(this);">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Phone 2
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" class="form-control" name="phone2" id="phonexx" placeholder="Input Phone Number 2 ..." onkeyup="numberOnly(this);">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Fax
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" class="form-control" name="fax" id="fax" placeholder="Input Fax ...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Email <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Input Email ..." onkeyup="ValidateEmail();">
                                <span id="lblError" style="color: red"></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 col-xs-4">
                                Desc
                            </div>
                            <div class="col-md-8 col-xs-8">
                                <input type="text" name="desc" class="form-control" id="pic_desc" placeholder="PIC Desc...">
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
                    <button type="button" class="btn btn-primary" onClick="savePic();"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Address -->
    <div class="modal fade" id="add-address" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <br>
                <div class="modal-body">
                    <form class="eventInsForm" method="post" target="_self" name="formku" 
                            id="formRoad" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Address Type <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <select class="form-control select2bs44" name="address_type" id="address_type">
                                    <option value="" selected>Silahkan Pilih ...</option>
                                    <option value="UTAMA">UTAMA</option>
                                    <option value="GUDANG">GUDANG</option>
                                    <option value="INVOICE">INVOICE</option>
                                </select>
                                <input type="hidden" id="company_id_addr">
                                <input type="hidden" id="addr_type">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                               Country <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <select class="form-control select2bs44" name="country" id="country">
                                    <option value="" selected>Silahkan Pilih ...</option>
                                    @foreach ($list_country as $country)
                                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Province
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" class="form-control" name="province" id="province" placeholder="Input Province...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                City
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" class="form-control" name="city" id="city" placeholder="Input City ...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Postal Code <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" class="form-control" name="postal_code" id="postal_code" placeholder="Input Postal Code ...">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 col-xs-4">
                                Address <font color="#f00">*</font>
                            </div>
                            <div class="col-md-8 col-xs-8">
                                <input type="text" name="address" class="form-control" id="address" placeholder="Input Address ...">
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
                    <button type="button" class="btn btn-primary" onClick="saveAddress();"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--- Modal Add Carrier -->
    <div class="modal fade" id="add-carrier" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <br>
                <div class="modal-body">
                    <form class="eventInsForm" method="post" target="_self" name="formCarrier" 
                        id="formCarrier" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Code <font color="#f00">*</font>
                            </div>
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="code" name="code" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Code ..">
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Name<font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="name" name="name" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Name ...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Flag<font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="flag" id="flag">
                                    <option value="" disabled selected>--Pilih--</option>
                                    @foreach ($list_country as $lc)
                                        <option value="{{ $lc->id }}">{{ $lc->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Lloyds Code
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="llyods" name="llyods" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Llyods Code ...">
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
                    <button type="button" class="btn btn-primary" onClick="saveCarrier();"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--- Modal Add Port -->
    <div class="modal fade" id="add-port" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <br>
                <div class="modal-body">
                    <form class="eventInsForm" method="post" target="_self" name="formPort" 
                        id="formPort" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Port Code <font color="#f00">*</font>
                            </div>
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="port" name="port" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Port Code ...">
                                <input type="hidden" id="type_add" name="id">
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
                                <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="port_type" id="port_type">
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
                                <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="country" id="country_port">
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
                                <input type="text" id="province_port" name="province" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Province ...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                            City <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="city_port" name="city" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input City ...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                            Postal Code <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="postal_code_port" name="postal_code" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Postal Code ...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                            Address <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <textarea name="address" id="address_port" class="form-control" rows="3" placeholder="Input Address..."></textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Status
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="status_port" name="status" checked>
                                    <label for="status">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">                        
                    <button type="button" class="btn btn-primary" onClick="savePort();"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

</section>
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

    $('#pic_name').keyup(function(){
        let position = this.selectionStart
        this.value = this.value.toUpperCase();
        this.selectionEnd = position;
    });

    $('#pic_desc').keyup(function(){
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

    $('#postal_code').keyup(function(){
        let position = this.selectionStart
        this.value = this.value.toUpperCase();
        this.selectionEnd = position;
    });

    $('#address').keyup(function(){
        let position = this.selectionStart
        this.value = this.value.toUpperCase();
        this.selectionEnd = position;
    });

    $('#code').keyup(function(){
        let position = this.selectionStart
        this.value = this.value.toUpperCase();
        this.selectionEnd = position;
    });

    $('#name').keyup(function(){
        let position = this.selectionStart
        this.value = this.value.toUpperCase();
        this.selectionEnd = position;
    });

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

    $('#province_port').keyup(function(){
        let position = this.selectionStart
        this.value = this.value.toUpperCase();
        this.selectionEnd = position;
    });

    $('#city_port').keyup(function(){
        let position = this.selectionStart
        this.value = this.value.toUpperCase();
        this.selectionEnd = position;
    });


    /** Add Customer **/
    function addCustomer(val)
    {
        if(val == 'client'){
            $('#company_type').val('client')
        }else if(val == 'shipper'){
            $('#company_type').val('shipper')
        }else if(val == 'consignee'){
            $('#company_type').val('consignee')
        }else if(val == 'notifyParty'){
            $('#company_type').val('notifyParty')
        }else if(val == 'agent'){
            $('#company_type').val('agent')
        }else if(val == 'shipline'){
            $('#company_type').val('shipline')
        }else if(val == 'vendor'){
            $('#company_type').val('vendor')
        }

        $('#client_code').val('');
        $('#client_name').val('');
        $('#npwp').val('');
        $('#account').val('').trigger("change");
        $('#sales').val('').trigger("change");
        $('#legal_doc').prop('checked', false);
        $('#customer').prop('checked', false);
        $('#vendor_mdl').prop('checked', false);
        $('#buyer_mdl').prop('checked', false);
        $('#seller_mdl').prop('checked', false);
        $('#shipper_mdl').prop('checked', false);
        $('#agent_mdl').prop('checked', false);
        $('#ppjk_mdl').prop('checked', false);
        
        $("#add-customer").find('.modal-title').text('Add Data');
        $("#add-customer").modal('show',{backdrop: 'true'}); 
    }

    /** Add PIC **/
    function addPic(val)
    {
        if(val == 'client'){
            $('#company_id_pic').val($('#customer_add').val())
            $('#pic_type').val('client')
        }else if(val == 'shipper'){
            $('#company_id_pic').val($('#shipper').val())
            $('#pic_type').val('shipper')
        }else if(val == 'consignee'){
            $('#company_id_pic').val($('#consignee').val())
            $('#pic_type').val('consignee')
        }else if(val == 'notifyParty'){
            $('#company_id_pic').val($('#notify_party').val())
            $('#pic_type').val('notifyParty')
        }else if(val == 'agent'){
            $('#company_id_pic').val($('#agent').val())
            $('#pic_type').val('agent')
        }else if(val == 'shipline'){
            $('#company_id_pic').val($('#shipping_line').val())
            $('#pic_type').val('shipline')
        }else if(val == 'vendor'){
            $('#company_id_pic').val($('#vendor').val())
            $('#pic_type').val('vendor')
        }

        $('#pic_name').val('');
        $('#phonex').val('');
        $('#phonexx').val('');
        $('#fax').val('');
        $('#email').val('');
        $('#pic_desc').val('');
        
        $("#add-pic").find('.modal-title').text('Add Data');
        $("#add-pic").modal('show',{backdrop: 'true'}); 
    }

    /** Add Address **/
    function addAddress(val)
    {
        if(val == 'client'){
            $('#company_id_addr').val($('#customer_add').val())
            $("#addr_type").val('client')
        }else if(val == 'shipper'){
            $('#company_id_addr').val($('#shipper').val())
            $("#addr_type").val('shipper')
        }else if(val == 'consignee'){
            $('#company_id_addr').val($('#consignee').val())
            $("#addr_type").val('consignee')
        }else if(val == 'notifyParty'){
            $('#company_id_addr').val($('#notify_party').val())
            $("#addr_type").val('notifyParty')
        }else if(val == 'agent'){
            $('#company_id_addr').val($('#agent').val())
            $("#addr_type").val('agent')
        }else if(val == 'shipline'){
            $('#company_id_addr').val($('#shipping_line').val())
            $("#addr_type").val('shipline')
        }else if(val == 'vendor'){
            $('#company_id_addr').val($('#vendor').val())
            $("#addr_type").val('vendor')
        }

        $('#address_type').val('').trigger("change");
        $('#country').val('').trigger("change");
        $('#province').val('');
        $('#city').val('');
        $('#postal_code').val('');
        $('#address').val('');
        
        $("#add-address").find('.modal-title').text('Add Data');
        $("#add-address").modal('show',{backdrop: 'true'}); 
    }


    /** Add Carrier **/
    function addCarrier()
    {
        $('#code').val('');
        $('#name').val('');
        $('#flag').val('').trigger("change");
        $('#lloyds_code').val('');
        
        $("#add-carrier").find('.modal-title').text('Add Data');
        $("#add-carrier").modal('show',{backdrop: 'true'}); 
    }

    /** Add Port **/
    function addPort(val)
    {
        $('#port').val('');
        $('#port_name').val('');
        $('#port_type').val('').trigger("change");
        $('#country_port').val('').trigger("change");
        $('#province_port').val('');
        $('#city_port').val('');
        $('#postal_code_port').val('');
        $('#address_port').val('');
        $('#type_add').val(val);
        
        $("#add-port").find('.modal-title').text('Add Data');
        $("#add-port").modal('show',{backdrop: 'true'}); 
    }

    function ValidateEmail() {
        let email = $("#email").val();
        let lblError = document.getElementById("lblError");
        lblError.innerHTML = "";
        let expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (!expr.test(email)) {
            lblError.innerHTML = "Invalid email address.";
        }
    }

    function load_carrier(val)
    {
        $.ajax({
            url: "{{ route('get.carrier') }}",
            type: "POST",
            data : "carrier_id="+val,
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#carrier").html(final)
            }
        })
    }

    function portOfLoading()
    {
        $.ajax({
            url: "{{ route('get.port_b') }}",
            type: "GET",
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#pol").html(final)
            }
        })
    }

    function portOfTransit()
    {
        $.ajax({
            url: "{{ route('get.port_b') }}",
            type: "GET",
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#pot").html(final)
            }
        })
    }


    function portOfDischarge()
    {
        $.ajax({
            url: "{{ route('get.port_b') }}",
            type: "GET",
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#podisc").html(final)
            }
        })
    }

    function get_customer(val)
    {
        $.ajax({
            url: "{{ route('get.customer') }}",
            type: "POST",
            data : "company_id="+val,
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#customer_add").html(final)
            }
        })
    }

    function get_shipper()
    {
        $.ajax({
            url: "{{ route('get.shipper') }}",
            type: "GET",
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#shipper").html(final)
            }
        })
    }

    function get_consignee()
    {
        $.ajax({
            url: "{{ route('get.consignee') }}",
            type: "GET",
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#consignee").html(final)
            }
        })
    }

    function get_notifyParty()
    {
        $.ajax({
            url: "{{ route('get.notify_party') }}",
            type: "GET",
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#notify_party").html(final)
            }
        })
    }

    function get_agent()
    {
        $.ajax({
            url: "{{ route('get.agent') }}",
            type: "GET",
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#agent").html(final)
            }
        })
    }

    function get_shippingLine()
    {
        $.ajax({
            url: "{{ route('get.shipping_line') }}",
            type: "GET",
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#shipping_line").html(final)
            }
        })
    }


    function get_vendor()
    {
        $.ajax({
            url: "{{ route('get.vendor') }}",
            type: "GET",
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#vendor").html(final)
            }
        })
    }

    function get_pic(val){
        if(val!= ''){
            $.ajax({
                url: "{{ route('get.pic_b') }}",
                type: "POST",
                data: {
                    id : val,
                    pic_id : {{ $quote->id_pic }}
                },
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    customer_pic(val);
                    customer_addr(val);
                    $("#legalDoc").html(final[2]);
                }
            });
        }
    }

    function customer_pic(val)
    {
        $.ajax({
            url: "{{ route('get.pic_b') }}",
            type: "POST",
            data: {
                id : val,
                pic_id : {{ $quote->id_pic }}
            },
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#customer_pic").html(final[0]);
            }
        });
    }


    function customer_addr(val)
    {
        $.ajax({
            url: "{{ route('get.pic_b') }}",
            type: "POST",
            data: {
                id : val
            },
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#customer_addr").html(final[1]);
            }
        });
    }

    /** Save Customer **/
    function saveCustomer(){
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
            $.ajax({
            type:"POST",
            url:"{{ route('master.company_doAdd') }}",
            data:{
                client_code : $('#client_code').val(),
                client_name : $('#client_name').val(),
                npwp : $('#npwp').val(),
                account : $('#account').val(),
                sales : $('#sales').val(),
                legal_doc : $('#legal_doc').val(),
                status : $('#status').val(),
                customer : $('#customer').val(),
                vendor : $('#vendor_mdl').val(),
                buyer : $('#buyer_mdl').val(),
                seller : $('#seller_mdl').val(),
                shipper : $('#shipper_mdl').val(),
                agent : $('#agent_mdl').val(),
                ppjk : $('#ppjk_mdl').val()

            },
            success:function(result){
                $('#add-customer').modal('hide')

                if($('#company_type').val() == 'client'){
                    get_customer({{ $quote->customer_id }});
                }else if($('#company_type').val() == 'shipper'){
                    get_shipper();
                }else if($('#company_type').val() == 'consignee'){
                    get_consignee();
                }else if($('#company_type').val() == 'notifyParty'){
                    get_notifyParty();
                }else if($('#company_type').val() == 'agent'){
                    get_agent();
                }else if($('#company_type').val() == 'shipline'){
                    get_shippingLine();
                }else if($('#company_type').val() == 'vendor'){
                    get_vendor();    
                }
                
                Toast.fire({
                    icon: 'success',
                    title: 'Sukses Add Data!'
                });
            },error: function (xhr, ajaxOptions, thrownError) {           
                    alert('Gagal menambahkan item!');
                },  
            });
        }
    }

    /** Save PIC **/
    function savePic(){
        if($.trim($("#pic_name").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter PIC Name',
                icon: 'error'
            })
        }else if($.trim($("#phonex").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter PIC Phone',
                icon: 'error'
            })
        }else{
            $.ajax({
                type:"POST",
                url:"{{ route('master.company_addPic') }}",
                data:{
                    company:$('#company_id_pic').val(),
                    pic_name:$('#pic_name').val(),
                    phone1:$('#phonex').val(),
                    phone2:$('#phonexx').val(),
                    email:$('#email').val(),
                    fax:$('#fax').val(),
                    desc:$('#pic_desc').val(),
                    status:$('#status').val()

                },
                success:function(result){
                    $('#add-pic').modal('hide')

                    if($('#pic_type').val() == 'client'){
                        customer_pic($('#customer_add').val());
                    }else if($('#pic_type').val() == 'shipper'){
                        shipper_pic($('#shipper').val());
                    }else if($('#pic_type').val() == 'consignee'){
                        consignee_pic($('#consignee').val());
                    }else if($('#pic_type').val() == 'notifyParty'){
                        not_pic($('#notify_party').val());
                    }else if($('#pic_type').val() == 'agent'){
                        agent_pic($('#agent').val());
                    }else if($('#pic_type').val() == 'shipline'){
                        shipline_pic($('#shipping_line').val());
                    }else if($('#pic_type').val() == 'vendor'){
                        vendor_pic($("#vendor").val());    
                    }
                    
                    Toast.fire({
                        icon: 'success',
                        title: 'Sukses Add Data!'
                    });
                },error: function (xhr, ajaxOptions, thrownError) {           
                    alert('Gagal menambahkan item!');
                },  
            });
        }
    }

    function saveAddress(){
        if($.trim($("#address_type").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Address Type',
                icon: 'error'
            })
        }else if($.trim($("#country").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Address Country',
                icon: 'error'
            })
        }else if($.trim($("#address").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Address',
                icon: 'error'
            })
        }else{
            $.ajax({
                type:"POST",
                url:"{{ route('master.company_addAddress') }}",
                data:{
                    company:$('#company_id_addr').val(),
                    address_type:$('#address_type').val(),
                    country:$('#country').val(),
                    city:$('#city').val(),
                    postal_code:$('#postal_code').val(),
                    province:$('#province').val(),
                    address:$('#address').val(),
                    status:$('#status').val()

                },
                success:function(result){
                    $('#add-address').modal('hide')

                    if($('#addr_type').val() == 'client'){
                        customer_addr($('#customer_add').val());
                    }else if($('#addr_type').val() == 'shipper'){
                        shipper_addr($('#shipper').val());
                    }else if($('#addr_type').val() == 'consignee'){
                        consignee_addr($('#consignee').val());
                    }else if($('#addr_type').val() == 'notifyParty'){
                        not_addr($('#notify_party').val());
                    }else if($('#addr_type').val() == 'agent'){
                        agent_addr($('#agent').val());
                    }else if($('#addr_type').val() == 'shipline'){
                        shipline_addr($('#shipping_line').val());
                    }else if($('#addr_type').val() == 'vendor'){
                        vendor_addr($('#vendor').val())  
                    }
                    
                    Toast.fire({
                        icon: 'success',
                        title: 'Sukses Add Data!'
                    });
                },error: function (xhr, ajaxOptions, thrownError) {           
                    alert('Gagal menambahkan item!');
                },  
            });
        }
    }

    /** save Carrier **/
    function saveCarrier(){
        if($.trim($("#code").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter Code',
                icon: 'error'
            })
        }else if($.trim($("#name").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter Name',
                icon: 'error'
            })
        }else if($.trim($("#flag").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Country',
                icon: 'error'
            })
        }else{
            $.ajax({
                type:"POST",
                url:"{{ route('master.cek_carrier_code') }}",
                data:"data="+$("#code").val(),
                success:function(result){
                    if(result=="duplicate"){
                        Swal.fire({
                            title: 'Error!',
                            text: 'Carrier Code Existing',
                            icon: 'error'
                        })
                    }else{    
                        $.ajax({
                            type:"POST",
                            url:"{{ route('master.carrier_doAdd') }}",
                            data:{
                                code:$('#code').val(),
                                name:$('#name').val(),
                                flag:$('#flag').val(),
                                llyods:$('#lloyds_code').val(),
                                status:$('#status').val()

                            },
                            success:function(result){
                                $('#add-carrier').modal('hide')
                                load_carrier({{ $quote->carrier_id }})
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Sukses Add Data!'
                                });
                            },error: function (xhr, ajaxOptions, thrownError) {           
                                alert('Gagal menambahkan item!');
                            },  
                        });         
                    }
                }
            });
        }
        
    };


    /** save port **/
    function savePort(){

        let type = $("#type_add").val();

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
        }else if($.trim($("#country_port").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Country',
                icon: 'error'
            });
        }else if($.trim($("#province_port").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter Province',
                icon: 'error'
            });
        }else if($.trim($("#city_port").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter City',
                icon: 'error'
            });
        }else{
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

                        $.ajax({
                            type:"POST",
                            url:"{{ route('master.port_doAdd') }}",
                            data:{
                                port:$('#port').val(),
                                port_name:$('#port_name').val(),
                                port_type:$('#port_type').val(),
                                country:$('#country_port').val(),
                                province:$('#province_port').val(),
                                city:$('#city_port').val(),
                                postal_code:$('#postal_code_port').val(),
                                address:$('#address_port').val(),
                                status:$('#status_port').val()

                            },
                            success:function(result){
                                $('#add-port').modal('hide')

                                if(type == 'pol'){
                                    portOfLoading();
                                }else if(type == 'pot'){
                                    portOfTransit();
                                }else if(type == 'pod'){
                                    portOfDischarge();
                                }
                                // portOfLoading()
                                // portOfTransit()
                                // portOfDischarge()
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Sukses Add Data!'
                                });
                            },error: function (xhr, ajaxOptions, thrownError) {           
                                alert('Gagal menambahkan item!');
                            },  
                        });            
                    }
                }
            });  
        }
        
    };


    function shipper_detail(val)
    {
        $('.shipper-detail').show();
        shipper_addr(val);
        shipper_pic(val);
    }

    function shipper_addr(val)
    {
        $.ajax({
            url: "{{ route('booking.detail') }}",
            type: "POST",
            data: "id="+val,
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#shipper_addr").html(final[0]);
            }
        });
    }

    function shipper_pic(val)
    {
        $.ajax({
            url: "{{ route('booking.detail') }}",
            type: "POST",
            data: "id="+val,
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#shipper_pic").html(final[1]);
            }
        });
    }

    function consignee_detail(val)
    {
        $('.consignee-detail').show();
        consignee_addr(val)
        consignee_pic(val)
    }

    function consignee_addr(val)
    {
        $.ajax({
            url: "{{ route('booking.detail') }}",
            type: "POST",
            data: "id="+val,
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#consignee_addr").html(final[0]);
            }
        });
    }

    function consignee_pic(val)
    {
        $.ajax({
            url: "{{ route('booking.detail') }}",
            type: "POST",
            data: "id="+val,
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#consignee_pic").html(final[1]);
            }
        });
    }

    function not_detail(val)
    {
        $('.not-detail').show();
        not_addr(val);
        not_pic(val);
    }

    function not_addr(val)
    {
        $.ajax({
            url: "{{ route('booking.detail') }}",
            type: "POST",
            data: "id="+val,
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#not_addr").html(final[0]);
            }
        });
    }

    function not_pic(val)
    {
        $.ajax({
            url: "{{ route('booking.detail') }}",
            type: "POST",
            data: "id="+val,
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#not_pic").html(final[1]);
            }
        });
    }

    function agent_detail(val)
    {
        $('.agent-detail').show();
        agent_addr(val);
        agent_pic(val);
    }

    function agent_addr(val)
    {
        $.ajax({
            url: "{{ route('booking.detail') }}",
            type: "POST",
            data: "id="+val,
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#agent_addr").html(final[0]);
            }
        });
    }


    function agent_pic(val)
    {
        $.ajax({
            url: "{{ route('booking.detail') }}",
            type: "POST",
            data: "id="+val,
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#agent_pic").html(final[1]);
            }
        });
    }


    function shipline_detail(val)
    {
        $('.shipline-detail').show();
        shipline_addr(val);
        shipline_pic(val);
    }


    function shipline_addr(val)
    {
        $.ajax({
            url: "{{ route('booking.detail') }}",
            type: "POST",
            data: "id="+val,
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#shipline_addr").html(final[0]);
            }
        });
    }

    function shipline_pic(val)
    {
        $.ajax({
            url: "{{ route('booking.detail') }}",
            type: "POST",
            data: "id="+val,
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#shipline_pic").html(final[1]);
            }
        });
    }

    function vendor_detail(val)
    {
        $('.vendor-detail').show();
        vendor_pic(val);
        vendor_addr(val);
    }

    function vendor_pic(val)
    {
        if(val!= ''){
            $.ajax({
                url: "{{ route('booking.detail') }}",
                type: "POST",
                data: "id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    $("#vendor_pic").html(final[1]);
                }
            });
        }
    }

    function vendor_addr(val)
    {
        if(val!= ''){
            $.ajax({
                url: "{{ route('booking.detail') }}",
                type: "POST",
                data: "id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    $("#vendor_addr").html(final[0]);
                }
            });
        }
    }

    $("#saveData").click(function(){
        if($.trim($("#booking_no").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Booking Number',
                icon: 'error'
            });
        }else if($.trim($('#booking_date').val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Booking Date',
                icon: 'error'
            });
        }else{
            $(this).prop('disabled', true).text('Please Wait ...');
            $('#formku').submit();
        }
    });

    $(function() {
        $('.select-ajax-port').select2({
            theme: "bootstrap4",
          ajax: {
            url: "{{route('booking.getPort')}}",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
              var query = {
                search: params.term,
              }

              // Query parameters will be ?search=[term]&type=public
              return query;
            },
            processResults: function(data, params) {
                console.log(data);
                return {results: data};
            },
            cache: true
          },
        });

        get_customer({{ $quote->customer_id }});
        get_pic({{ $quote->customer_id }})
        load_carrier({{ $quote->carrier_id }})
        // portOfLoading();
        // portOfTransit();
        // portOfDischarge();
        get_shipper();
        get_consignee();
        get_notifyParty();
        get_agent();
        get_shippingLine();
        get_vendor();
    });
    </script>
@endpush
@endsection