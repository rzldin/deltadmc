@extends('layouts.master')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>New Version</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('quotation.list') }}">List Quote</a></li>
                    <li class="breadcrumb-item active">Quote New Version</li>
                </ol>
            </div>
      </div>
    </div>
    <!-- /.container-fluid -->
</section>
  <!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Header</h3>
                    </div>
                    @if(count($errors)>0)
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>  		
                        @endforeach
                    @endif
                    <!-- form start -->
                    <form action="{{ route('quotation.quote_doAdd') }}" class="eventInsForm" method="post" target="_self" name="formku" id="formku" action=""> 
                    {{ csrf_field() }}   
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Quote Number</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="quote_no" id="quote_no" placeholder="Quote No ..." value="{{ $quote->quote_no }}">
                                        <input type="hidden" name="id_quote" name="id_quote" value="{{ Request::segment(3) }}">
                                        <input type="hidden" name="new_version" value="new">
                                    </div>
                                </div>
                                <div class="row mb-3 mt-3">
                                    <div class="col-md-4">
                                        <label>Version</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="version" id="version" placeholder="Version ..." value="{{ $quote->version_no+1 }}" onkeyup="numberOnly(this);" readonly>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <input type="checkbox" name="final" id="final" style="margin-right: 5px" ><label> FINAL</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="date" id="datex" class="form-control datetimepicker-input" value="{{ \Carbon\Carbon::parse($quote->quote_date)->format('d/m/Y') }}" data-target="#reservationdate"/>
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Customer</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control select2bs44" style="width: 100%;" name="customer_add" id="customer_add" onchange="get_pic(this.value)">
                                        
                                        </select>
                                    </div>
                                    <div class="col-md-1 mt-1">
                                        <a href="javascript:;" onclick="addCustomer()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Activity</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="activity" id="activity">
                                            <option value="" selected>-- Select Activity --</option>
                                            <option value="export" @if ($quote->activity == 'export')
                                                selected
                                            @endif>EXPORT</option>
                                            <option value="import" @if ($quote->activity == 'import')
                                                selected
                                            @endif>IMPORT</option>
                                            <option value="domestic" @if ($quote->activity == 'domestic')
                                                selected
                                            @endif>DOMESTIC</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4" style="padding: 10px">
                                        @foreach ($loaded as $l)
                                        <input type="radio" name="loaded" id="loaded" value="{{ $l->id }}" @if ($l->id == $quote->t_mloaded_type_id)
                                            checked
                                        @endif>
                                        <label>{{ $l->loaded_type }}</label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>From</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" list="fromx" class="form-control" name="from" id="from" placeholder="From ..." value="{{ $quote->from_text }}">
                                        <datalist id="fromx">
                                            @foreach ($port as $p)
                                            <option id="{{ $p->id }}" value="{{ $p->port_name }}"></option>
                                            @endforeach
                                        </datalist>
                                        <input type="hidden" name="from_id" id="from_id">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Commodity</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="commodity" id="commodity" placeholder="Commodity ..." value="{{ $quote->commodity }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>PIC</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control select2bs44" name="pic" id="pic" style="width: 100%;">
                                            <option>-- Select Customer First --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mt-1">
                                        <a href="javascript:;" onclick="addPic()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Shipment By</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" name="shipment" id="shipment" style="width: 100%;">
                                            <option selected>-- Select Shipment --</option>
                                            <option value="SEA" @if ($quote->shipment_by == "SEA")
                                                selected
                                            @endif>SEA</option>
                                            <option value="AIR" @if ($quote->shipment_by == "AIR")
                                                selected
                                            @endif>AIR</option>
                                            <option value="LAND" @if ($quote->shipment_by == "LAND")
                                                selected
                                            @endif>LAND</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Terms</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" name="terms" id="terms" style="width: 100%;">
                                            <option selected>-- Select Incoterms --</option>
                                            @foreach ($inco as $i)
                                            <option value="{{ $i->id }}" @if ($quote->terms == $i->id)
                                                selected
                                            @endif>{{ $i->incoterns_code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>To</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" list="tox" class="form-control" name="to" id="to" placeholder="To ..." value="{{ $quote->to_text }}">
                                        <datalist id="tox">
                                            @foreach ($port as $p)
                                            <option id="{{ $p->id }}" value="{{ $p->port_name }}"></option>
                                            @endforeach
                                            <input type="hidden" name="to_id" id="to_id">
                                        </datalist>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Pieces</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="pieces" id="pieces" onkeyup="numberOnly(this);" placeholder="Pieces ..." value="{{ $quote->pieces }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Weight</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="weight" id="weight" onkeyup="numberOnly(this);" placeholder="Weight ..." value="{{ $quote->weight }}">
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control select2bs44" name="uom_weight" id="uom_weight" style="width: 100%;">
                                            <option selected>-- Select UOM --</option>
                                        @foreach ($uom as $u)
                                            <option value="{{ $u->id }}" @if ($quote->weight_uom_id == $u->id)
                                                selected
                                            @endif>{{ $u->uom_code }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Volume</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="volume" id="volume" onkeyup="numberOnly(this);" placeholder="Volume ..." value="{{ $quote->volume }}">
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control select2bs44" name="uom_volume" id="uom_volume" style="width: 100%;">
                                            <option selected>-- Select UOM --</option>
                                        @foreach ($uom as $u)
                                            <option value="{{ $u->id }}" @if ($volume_uom->id == $u->id)
                                                selected
                                            @endif>{{ $u->uom_code }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="hazard" @if ($quote->hazardous_flag == 1)
                                                checked
                                            @endif>
                                            <label for="customCheckbox1" class="custom-control-label">Is Hazardous</label>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="hazard_txt" placeholder="Material Information ....." value="{{ $quote->hazardous_info }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="">Additional Information</label>
                                    </div>
                                    <div class="col-md 10">
                                        <textarea class="form-control" rows="5" name="additional" placeholder="Additional Information ...">{{ $quote->additional_info }}</textarea>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox2" name="delivery" @if ($quote->pickup_delivery_flag == 1)
                                            checked
                                            @endif>
                                            <label for="customCheckbox2" class="custom-control-label">Need Pickup/ Delivery</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox3" name="custom" @if ($quote->custom_flag == 1)
                                            checked
                                            @endif>
                                            <label for="customCheckbox3" class="custom-control-label">Need Custom Clearance</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox4" name="fumigation" @if ($quote->fumigation_flag == 1)
                                            checked
                                            @endif>
                                            <label for="customCheckbox4" class="custom-control-label">Fumigation Required</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox5" name="goods" @if ($quote->stackable_flag == 1)
                                            checked
                                            @endif>
                                            <label for="customCheckbox5" class="custom-control-label">Goods are Stackable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dimension Info</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table_lowm table-bordered" id="Table2">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="10%">Length</th>
                                    <th width="10%">Width</th>
                                    <th width="10%">Height</th>
                                    <th width="15%">UOM</th>
                                    <th width="10%">Pieces</th>
                                    <th width="9%">Wight</th>
                                    <th width="15%">UOM</th>
                                </tr>
                            </thead>
                            <tbody id="tblDimension">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Shipping Detail</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table_lowm table-bordered" id="myTable2" style="@if($quote->shipment_by != 'LAND') width: 150% @else width: 105% @endif">
                           <thead>
                               <tr>
                                   <th width="2%">No</th>
                                   @if ($quote->shipment_by == 'LAND')
                                   <th width="15%">Truck Size</th>
                                   @else
                                   <th width="15%">Carrier</th>
                                   <th width="10%">Routing</th>
                                   <th width="5%" style="font-size: 12px">Transit time(days)</th>
                                   @endif
                                   <th width="10%">Currency</th>
                                   <th>Rate</th>
                                   <th>Cost</th>
                                   <th>Sell</th>
                                   <th width="5%">Qty</th>
                                   <th>Cost Value</th>
                                   <th>Sell Value</th>
                                   <th width="5%">Vat</th>
                                   <th width="10%">Total</th>
                                   <th width="10%">Note</th>
                               </tr>
                           </thead>
                           <tbody id="tblShipping">
                           </tbody>
                       </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail quote</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table_lowm table-bordered" id="myTable2" style="width: 150%">
                           <thead>
                               <tr>
                                   <th>No</th>
                                   <th>Service/Fee</th>
                                   <th>Description</th>
                                   <th>Reimbursment</th>
                                   <th>Currency</th>
                                   <th>Rate</th>
                                   <th>Cost</th>
                                   <th>Sell</th>
                                   <th>Qty</th>
                                   <th>Cost Value</th>
                                   <th>Sell Value</th>
                                   <th>Vat</th>
                                   <th>Total</th>
                                   <th>Note</th>
                               </tr>
                           </thead>
                           <tbody id="tblDetail">
                           </tbody>
                       </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Profit Analysis</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table_lowm table-bordered">
                           <thead>
                               <tr>
                                   @if ($quote->shipment_by != 'LAND')
                                   <td class="text-center">Carrier</td>
                                   <td class="text-center">Routing</td>
                                   <td class="text-center">Transit Time</td>
                                   @endif
                                   <td class="text-center">Total Cost</td>
                                   <td class="text-center">Total Sell</td>
                                   <td class="text-center">Total Profit</td>
                                   <td class="text-center">Profil PCT</td>
                               </tr>
                           </thead>
                           <tbody id="tblProfit">
                           </tbody>
                       </table>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ url('quotation/quote_edit/'.$quote->id) }}" class="btn btn-default float-left mr-2"> 
                      <i class="fa fa-angle-left"></i> Back 
                    </a>
                    <button type="button" class="btn btn-primary float-right" id="saveData"><i class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </div>
        </form>
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
                    <form class="eventInsForm" method="post" target="_self" name="formku" 
                            id="formRoad" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Company Code <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="client_code" name="client_code" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Company Code...">
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
                                NPWP <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="npwp" name="npwp" 
                                    class="form-control myline" style="margin-bottom:5px"  placeholder="NPWP...">
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
                                <input type="hidden" id="company_id">
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

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function reims(id)
    {
        $(this).val($(this).attr('checked') ? $('#reimbursx_'+id).val(1) : $('#reimbursx_'+id).val(0) )
        //$(this).val($(this).attr('checked') ? alert('1') : alert('0') )
    }

    /** Add Customer **/
    function addCustomer(val)
    {
        $('#client_code').val('');
        $('#client_name').val('');
        $('#npwp').val('');
        $('#account').val('').trigger("change");
        $('#sales').val('').trigger("change");
        $('#legal_doc').prop('checked', false);
        $('#customer').prop('checked', false);
        $('#vendor').prop('checked', false);
        $('#buyer').prop('checked', false);
        $('#seller').prop('checked', false);
        $('#shipper').prop('checked', false);
        $('#agent').prop('checked', false);
        $('#ppjk').prop('checked', false);
        
        $("#add-customer").find('.modal-title').text('Add Data');
        $("#add-customer").modal('show',{backdrop: 'true'}); 
    }


    /** Add PIC **/
    function addPic()
    {
        $('#pic_name').val('');
        $('#phonex').val('');
        $('#phonexx').val('');
        $('#fax').val('');
        $('#email').val('');
        $('#pic_desc').val('');
        
        $("#add-pic").find('.modal-title').text('Add Data');
        $("#add-pic").modal('show',{backdrop: 'true'}); 
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
                vendor : $('#vendor').val(),
                buyer : $('#buyer').val(),
                seller : $('#seller').val(),
                shipper : $('#shipper').val(),
                agent : $('#agent').val(),
                ppjk : $('#ppjk').val()

            },
            success:function(result){
                $('#add-customer').modal('hide')
                get_customer({{ $quote->customer_id }});
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
                    company:$('#customer_add').val(),
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
                    get_pic($('#customer_add').val());
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

    /** Load Dimension **/
    function loadDimension(id, val){
        $.ajax({
            type:"POST",
            url:"{{ route('quotation.quote_loadDimension') }}",
            data:{
                id : id,
                val : val
            },
            dataType:"html",
            success:function(result){
                if(result == '""'){
                    $('#tblDimension').html(`<tr><td colspan="14" class="text-center"><strong>Not Available.</strong></td></tr>`)
                }else{
                    var tabel = JSON.parse(result);
                    console.log(tabel);
                    $('#tblDimension').html(tabel);
                }
            }
        })
    }

    /** Load Shipping **/
    function loadShipping(id, val){
        $.ajax({
            type:"POST",
            url:"{{ route('quotation.quote_loadShipping') }}",
            data:{
                id : id,
                val : val
            },
            dataType:"html",
            success:function(result){
                var tabel = JSON.parse(result);
                $('#tblShipping').html(tabel);
            }
        })
    }

    /** Load Detail Quote **/
    function loadDetail(id, val){
        $.ajax({
            type:"POST",
            url:"{{ route('quotation.quote_loadDetail') }}",
            data:{
                id : id,
                val : val
            },
            dataType:"html",
            success:function(result){
                var tabel = JSON.parse(result);
                $('#tblDetail').html(tabel);
            }
        })
    }

    /** Load Profit **/
    function loadProfit(id){
        $.ajax({
            type:"POST",
            url:"{{ route('quotation.quote_loadProfit') }}",
            data:{
                id : id
            },
            dataType:"html",
            success:function(result){
                var tabel = JSON.parse(result);
                $('#tblProfit').html(tabel);
            }
        })
    }
    
    function get_pic(val){
        if(val!= ''){
            $.ajax({
                url: "{{ route('get.pic') }}",
                type: "POST",
                data: {
                    id : val,
                    pic_id : {{ $quote->id_pic }}
                },
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    
                    $("#pic").html(final);
                }
            });
        }
    }

    $(function() {
        $('input[name=from]').on('input',function() {
            var selectedOption = $('option[value="'+$(this).val()+'"]');
            console.log(selectedOption.length ? selectedOption.attr('id') : 'This option is not in the list!');
            var id = selectedOption.attr('id');
            $('#from_id').val(id)
        });
    });

    $(function() {
        $('input[name=to]').on('input',function() {
            var selectedOption = $('option[value="'+$(this).val()+'"]');
            console.log(selectedOption.length ? selectedOption.attr('id') : 'This option is not in the list!');
            var id = selectedOption.attr('id');
            $('#to_id').val(id)
        });
    });

    
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

    function hitung(id){
        const cost = $('#qty_'+id).val()*$('#sell_val_'+id).val();
        let total = Number(cost)+Number($('#vat_'+id).val());
        total = total.toFixed(2)
        total = numberWithCommas(Number(total));
        $('#total_'+id).val(total);
    }

    function hitungx(id){
        const cost = $('#qtyx_'+id).val()*$('#sellx_val_'+id).val();
        let total = Number(cost)+Number($('#vatx_'+id).val());
        total = total.toFixed(2)
        total = numberWithCommas(Number(total));
        $('#totalx_'+id).val(total);
    }


    $("#saveData").click(function(){
        if($.trim($("#quote_no").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Quote Number',
                icon: 'error'
            })
        }else if($.trim($("#datex").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Date',
                icon: 'error'
            })
        }else if($.trim($("#customer").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Customer',
                icon: 'error'
            })
        }else if($.trim($("#activity").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Activity',
                icon: 'error'
            })
        }else if($.trim($("#loaded").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Choose One Loaded Type',
                icon: 'error'
            })
        }else if($.trim($("#from").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input From',
                icon: 'error'
            })
        }else if($.trim($("#commodity").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Commodity',
                icon: 'error'
            })
        }else if($.trim($("#pic").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select PIC',
                icon: 'error'
            })
        }else if($.trim($("#pic").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select PIC',
                icon: 'error'
            })
        }else if($.trim($("#shipment").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Shipment',
                icon: 'error'
            })
        }else if($.trim($("#terms").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Incoterms',
                icon: 'error'
            })
        }else if($.trim($("#to").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Input To',
                icon: 'error'
            })
        }else if($.trim($("#pieces").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Pieces',
                icon: 'error'
            })
        }else if($.trim($("#weight").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Weight',
                icon: 'error'
            })
        }else if($.trim($("#uom_weight").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select UOM Weight',
                icon: 'error'
            })
        }else if($.trim($("#volume").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Volume',
                icon: 'error'
            })
        }else if($.trim($("#uom_volume").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select UOM Volume',
                icon: 'error'
            })
        }else{
            $(this).prop('disabled', true).text('Please Wait ...');
            $('#formku').submit();
        }
    });

    $(function() {
        loadDimension({{ Request::segment(3) }}, 'b');
        loadShipping({{ Request::segment(3) }}, 'b');
        loadDetail({{ Request::segment(3) }}, 'b');
        loadProfit({{ Request::segment(3) }}); 
        get_customer({{ $quote->customer_id }});
        get_pic({{ $quote->customer_id }})
    });

  </script>
      
  @endpush    
@endsection


