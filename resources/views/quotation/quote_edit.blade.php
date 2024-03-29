@extends('layouts.master')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Quotation</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('quotation.list') }}">List Quote</a></li>
                    <li class="breadcrumb-item active">Add Detail</li>
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
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Header</h3>
                    </div>
                    <!-- /.card-header -->
                    @if(count($errors)>0)
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>  		
                        @endforeach
                    @endif
                    <!-- form start -->
                  <form action="{{ route('quotation.quote_doUpdate') }}" class="eventInsForm" method="post" target="_self" name="formku" id="formku" action=""> 
                    {{ csrf_field() }}   
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
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
                                        <label>PIC</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control select2bs44" name="pic" id="pic" style="width: 100%;">
                                            <option>-- Select Customer First --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mt-1">
                                        <a href="javascript:;" onclick="addPic()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Quote Number <font color="red">*</font></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="quote_no" id="quote_no" placeholder="Quote No ..." value="{{ $quote->quote_no }}">
                                        <input type="hidden" name="id_quote" name="id_quote" value="{{ $quote->id }}">
                                    </div>
                                </div>
                                <div class="row mb-3 mt-3">
                                    <div class="col-md-4">
                                        <label>Version</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="version" id="version" placeholder="Version ..." value="{{ $quote->version_no }}" onkeyup="numberOnly(this);" readonly>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="final" name="final" @if ($quote->final_flag == 1)
                                                checked
                                            @endif>
                                            <label for="final">
                                                FINAL
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Activity</label>
                                    </div>
                                    <div class="col-md-8">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-primary">
                            <p>Shipment</p>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Shipment By</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" name="shipment" id="shipment" style="width: 100%;" onchange="get_fromto(this.value)">
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
                            </div>
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Shipment By</label>
                                    </div>
                                    <div class="col-md-8" style="padding: 10px">
                                        @foreach ($loaded as $l)
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="loaded_{{ $l->id }}" name="t_mloaded_type_id" value="{{ $l->id }}"  @if ($l->id == $quote->t_mloaded_type_id)
                                                checked
                                            @endif>
                                            <label for="loaded_{{ $l->id }}">
                                                {{ $l->loaded_type }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 show_service">
                            <div class="col-md-2">
                                <label>Shipment Type <font color="red">*</font></label>
                            </div>
                            <div class="col-md-10">
                                <div class="btn-group" data-toggle="buttons">
                                    @foreach ($service as $l)
                                        <label class="btn btn-default mr-3">
                                            <input type="radio" name="t_mservice_type_id" id="service_{{ $l->id }}" autocomplete="off" value="{{ $l->id }}" onchange="show_service(this.value)" @if ($l->id == $quote->t_mservice_type_id)
                                                checked
                                            @endif> {{ $l->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body div_after">
                        <div class="card-primary">
                            <p>Shipment Details</p>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 show_port_from">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>From Country</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" name="from_country" id="from_country" style="width: 100%;">
                                            <option selected>-- Select From Country --</option>
                                            @foreach ($list_country as $i)
                                                <option value="{{ $i->id }}" @if ($quote->from_country == $i->id)
                                                    selected
                                                @endif>
                                                    {{ $i->country_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>From Port</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="from_id" id="from_id" class="form-control select-ajax-port" onchange="get_port_name('from')">
                                            @if($quote->from_id)
                                                <option value="{{$quote->from_id}}" selected="selected">{{ $quote->from_text }}</option>
                                            @endif
                                        </select>
                                        <input type="hidden" class="form-control" name="from" id="from"value="{{ $quote->from_text }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-3 show_port_from">
                                    <div class="col-md-4">
                                        <label>From City</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="from_city" id="from_city" placeholder="From City ..." value="{{ $quote->from_city }}">
                                    </div>
                                </div>
                                <div class="row mb-3 show_door_from">
                                    <div class="col-md-4">
                                        <label>Postal Code</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="from_postal" id="from_postal" placeholder="Postal Code ..." value="{{ $quote->from_postal }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5 show_door_from">
                            <div class="col-md-2">
                                <label>Address</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control" name="from_address" id="from_address">{{ $quote->from_address }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 show_port_to">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>To Country</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" name="to_country" id="to_country" style="width: 100%;">
                                            <option selected>-- Select to Country --</option>
                                            @foreach ($list_country as $i)
                                                <option value="{{ $i->id }}"@if ($quote->to_country == $i->id)
                                                    selected
                                                @endif>
                                                    {{ $i->country_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>To Port</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="to_id" id="to_id" class="form-control select-ajax-port" onchange="get_port_name('to')">
                                            @if($quote->to_id)
                                                <option value="{{$quote->to_id}}" selected="selected">{{ $quote->to_text }}</option>
                                            @endif
                                        </select>
                                        <input type="hidden" class="form-control" name="to" id="to"value="{{ $quote->to_text }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-3 show_port_to">
                                    <div class="col-md-4">
                                        <label>To City</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="to_city" id="to_city" placeholder="to City ..." value="{{ $quote->to_city }}">
                                    </div>
                                </div>
                                <div class="row mb-3 show_door_to">
                                    <div class="col-md-4">
                                        <label>Postal Code</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="to_postal" id="to_postal" placeholder="Postal Code ..." value="{{ $quote->to_postal }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row show_door_to">
                            <div class="col-md-2">
                                <label>Address</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control" name="to_address" id="to_address">{{ $quote->to_address }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-primary">
                            <p>Shipment Details</p>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
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
                            </div>
                            <div class="col-sm-6">

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Commodity</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="commodity" id="commodity" placeholder="Commodity ..." value="{{ $quote->commodity }}">
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
                                            <option value="{{ $u->id }}" <?=((isset($volume_uom) && $volume_uom->id == $u->id)? 'selected':'');?>>{{ $u->uom_code }}</option>
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
                  </form>
                </div>
                 <!-- /.card -->
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dimension Info</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table_lowm table-bordered">
                           <thead>
                               <tr>
                                   <th>#</th>
                                   <th width="13%">Length</th>
                                   <th width="13%">Width</th>
                                   <th width="13%">Height</th>
                                   <th width="15%">Total</th>
                                   <th width="8%">UOM</th>
                                   <th width="10%">Pieces</th>
                                   <th width="9%">Weight</th>
                                   <th width="10%">Total</th>
                                   <th width="8%">UOM</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>
                               <tbody id="tblDimension">

                               </tbody>
                               <tr>
                                    <td>
                                        <i class="fa fa-plus"></i>
                                    </td>
                                   <td>
                                        <input type="text" class="form-control" name="length" id="length_1" placeholder="Length ..." onkeyup="numberOnly(this); hitungberat(1);">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="width" id="width_1" placeholder="Width ..." onkeyup="numberOnly(this); hitungberat(1);">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="height" id="height_1" placeholder="Height ..." onkeyup="numberOnly(this); hitungberat(1);">
                                   </td>
                                   <td>
                                       <input type="text" name="total_cbm" id="total_cbm_1" value="0" class="form-control" readonly>
                                   </td>
                                   <td>
                                       <select class="form-control" name="height_uom" id="height_uom_1">
                                            <option value="">--Select Uom--</option>
                                            @foreach ($uom as $item)
                                            <option value="{{ $item->id }}">{{ $item->uom_code }}</option>                                                
                                            @endforeach
                                       </select>
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="pieces" id="pieces_1" placeholder="Pieces ..." onkeyup="numberOnly(this); hitungweight(1)">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="wight" id="wight_1" placeholder="Weight ..." onkeyup="numberOnly(this); hitungweight(1)">
                                   </td>
                                   <td>
                                       <input type="text" name="total_weight" id="total_weight_1" value="0" class="form-control" readonly>
                                   </td>
                                   <td>
                                        <select class="form-control" name="wight_uom" id="wight_uom_1">
                                            <option value="">--Select Uom--</option>
                                            @foreach ($uom as $item)
                                            <option value="{{ $item->id }}">{{ $item->uom_code }}</option>                                                
                                            @endforeach
                                        </select>
                                   </td>
                                   <td>
                                        <button class="btn btn-block btn-outline-success btn-xs" onclick="saveDetailx(1)"><i class="fa fa-plus"></i> Add</button>
                                   </td>
                               </tr>
                           </tbody>
                       </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Shipping Detail</h3>
                        <a class="btn btn-primary btn-sm float-right" onclick="newShipingDtl()"><i class="fa fa-plus"></i> Add Data</a>
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table-bordered table-striped" id="myTable2">
                            <thead>
                                <tr>
                                    <th width="2%">No</th>
                                    @if ($quote->shipment_by == 'LAND')
                                    <th width="15%">Truck Size</th>
                                    @else
                                    <th width="9%">Carrier</th>
                                    <th width="3%">Routing</th>
                                    <th width="3%" style="font-size: 12px">Transit time(days)</th>
                                    @endif
                                    <th width="3%" style="font-size: 12px">Currency</th>
                                    <th width="5%">Rate</th>
                                    <th width="6%">Cost</th>
                                    <th width="6%">Sell</th>
                                    <th width="3%">Qty</th>
                                    <th width="7%">Cost Value</th>
                                    <th width="7%">Sell Value</th>
                                    <th width="5%">Vat</th>
                                    <th width="9%">Total</th>
                                    <th width="10%">Note</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tblShipping">

                            </tbody>
                       </table>
                    </div>
                </div>
            </div>
            <div class="modal fade myModal" id="shipping-detail" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <input type="hidden" name="id_s" id="id_s">
                                @if ($quote->shipment_by == 'LAND')
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Truck Size<font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="truck_size" id="truck_size" placeholder="Truck Size ...">
                                    </div>
                                </div>
                                @else
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Carrier<font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <select class="form-control select2bs44" name="carrier" id="carrier">
                                            <option value="">--Select Carrier--</option>
                                            @foreach ($carrier as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>                                                
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Routing<font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="routing" id="routing" placeholder="Routing ..." onkeyup="this.value = this.value.toUpperCase()">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                       Transit Time (Days)<font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="transit_time" id="transit" placeholder="Transit..." onkeyup="numberOnly(this)">
                                    </div>
                                </div>
                                @endif
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Currency <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <select class="form-control select2bs44" name="currency" id="currency_ship_dtl" onchange="get_rate(this.value)">
                                            <option value="" selected>--Select Currency--</option>
                                            @foreach ($currency as $item)
                                            <option value="{{ $item->id }}">{{ $item->code }}</option>                                                
                                            @endforeach
                                        </select>
                                    </div>  
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Rate <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="rate" id="rate" placeholder="Rate ..." onkeyup="hitung(this)">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Cost <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="cost" id="cost" placeholder="Cost ..." onkeyup="hitung(this)">                     
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Sell <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="sell" id="sell" placeholder="Sell ..." onkeyup="hitung(this)">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Qty <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="qty" id="qty" placeholder="Qty ..." onkeyup="hitung(this)">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Cost Value <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="cost_val" id="cost_val" placeholder="Cost Value ..." readonly>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Sell Value <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="sell_val" id="sell_val" placeholder="Sell Value ..." readonly>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Vat 
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="vat" id="vat" placeholder="Vat ..." onkeyup="hitung(this)">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Total
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="total" id="total" placeholder="Total ..." readonly>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                       Note
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="note" id="note" placeholder="Note ...">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">                        
                            <button type="button" class="btn btn-primary" onClick="saveDetailxx();"><i class="fa fa-save"></i> Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail quote</h3>
                        <a class="btn btn-danger btn-sm float-right ml-2" onclick="deleteAllQuoteDetail()"><i class="fa fa-trash"></i> Delete All</a>
                        <a class="btn btn-primary btn-sm float-right" onclick="newDetailQuote()"><i class="fa fa-plus"></i> Add Data</a>
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table-bordered table-striped" id="myTable2">
                           <thead>
                                <tr>
                                    <th width="1%">#</th>
                                    <th width="2%">No</th>
                                    <th width="10%">Service/Fee</th>
                                    <th width="10%">Description</th>
                                    <th width="1%" style="font-size: 10px;">Reimbursment</th>
                                    <th width="5%">Currency</th>
                                    <th width="6%">Rate</th>
                                    <th width="6%">Cost</th>
                                    <th width="6%">Sell</th>
                                    <th width="5%">Qty</th>
                                    <th width="6%">Cost Value</th>
                                    <th width="6%">Sell Value</th>
                                    <th width="5%">Vat</th>
                                    <th width="7%">Total</th>
                                    <th width="12%">Note</th>
                                    <th width="5%">Action</th>
                                </tr>
                           </thead>
                           <tbody id="tblDetail">
                               
                           </tbody>
                       </table>
                    </div>
                </div>
            </div>
            <div class="modal fade myModal" id="detail-quote" tabindex="-1" role="basic" aria-hidden="true">
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
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Service/Fee<font color="#f00">*</font>
                                    </div>                                
                                    <div class="col-md-8 col-xs-8">
                                        <select class="form-control select2bs44" name="charge" id="charge">
                                            <option value="">--Select Charge Code--</option>
                                            @foreach ($charge as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>                                                
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="id_dtl_quote" id="id_dtl_quote">
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Description
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="desc" id="descx" placeholder="Desc ...">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Currency <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <select class="form-control select2bs44" name="currency" id="currencyx" onchange="get_rate(this.value)">
                                            <option value="" selected>--Select Currency--</option>
                                            @foreach ($currency as $item)
                                            <option value="{{ $item->id }}">{{ $item->code }}</option>                                                
                                            @endforeach
                                        </select>
                                    </div>  
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Rate <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="rate" id="ratex" placeholder="Rate ..." value="" onkeyup="hitungx(this)">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Cost <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="cost" id="costx" placeholder="Cost ..." onkeyup="hitungx(this)">                     
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Sell <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="sell" id="sellx" placeholder="Sell ..." onkeyup="hitungx(this)">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Qty <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="qty" id="qtyx" placeholder="Qty ..." onkeyup="hitungx(this)">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Cost Value <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="cost_val" id="cost_valx" placeholder="Cost Value ..." readonly>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Sell Value <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="sell_val" id="sell_valx" placeholder="Sell Value ..." readonly>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Vat 
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="vat" id="vatx" placeholder="Vat ..." onkeyup="hitungx(this)">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                        Total <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="total" id="totalx" placeholder="Total ..." readonly>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                       Note
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" class="form-control" name="note" id="notex" placeholder="Note ...">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-xs-4">
                                       Reimbursment
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="checkbox" name="reimburs" id="reimburs" onclick="checkbox()">
                                        <input type="hidden" name="reimbursx" id="reimbursx" value="">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">                        
                            <button type="button" class="btn btn-primary" id="detail_quote_submit" onClick="saveDetailxxx();"><i class="fa fa-save"></i> Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
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
            </div>
            <div class="col-md-12 mt-3">
                <button type="button" class="btn btn-primary mb-4 float-left mr-2" onclick="updateData()">
                <i class="fa fa-save"></i> Save
                </button>
                <a href="{{ url('quotation/quote_new/'.$quote->id) }}" onclick="return confirm('build a new version?')" class="btn btn-info float-left mr-2"> 
                    <i class="fa fa-plus"></i> New Version 
                </a>
                <a href="{{ url('quotation/preview/'.$quote->quote_no.'/'.$quote->id) }}" target="_blank" class="btn btn-primary float-left mr-2"> 
                    <i class="fa fa-file"></i> Preview Quotation 
                </a>
                <a href="" class="btn btn-danger float-left mr-2 @if ($quote->final_flag !== 1)
                    disabledx
                @endif"> 
                    <i class="fa fa-envelope"></i> Send Email 
                </a>
                <a onclick="createBooking()" class="btn btn-success float-left mr-2 @if ($quote->status !== 1)
                    disabledx
                @endif"> 
                    <i class="fa fa-plus"></i> Create Booking Order 
                </a>
            </div>
        </div>
    </div>
    <!-- Modal Add Customer -->
    <div class="modal fade myModal" id="add-customer" tabindex="-1" role="basic" aria-hidden="true">
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
    <div class="modal fade myModal" id="add-pic" tabindex="-1" role="basic" aria-hidden="true">
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
    var dsState;

    function hitungberat(id){
        let l = $('#length_'+id).val().toString().replace(/\./g, "");
        let w = $('#width_'+id).val().toString().replace(/\./g, "");
        let h = $('#height_'+id).val().toString().replace(/\./g, "");
        let total = Number(l)*Number(w)*Number(h)/1000000;
        $('#total_cbm_'+id).val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    }

    function hitungweight(id){
        let p = $('#pieces_'+id).val().toString().replace(/\./g, "");
        let ww = $('#wight_'+id).val().toString().replace(/\./g, "");
        let total_weight = Number(p)*Number(ww);
        $('#total_weight_'+id).val(total_weight.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    }
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

    function checkbox() 
    {
        // var checked = false;
        if($('#reimburs:checkbox:checked').length > 0) {
            // checked = true;
            $('#reimbursx').val(1)
        }else{
            $('#reimbursx').val(0)
        }
        console.log($('#reimbursx').val());
        
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
        
        $("#add-customer").find('.modal-title').text('Add Data Customer');
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
        
        $("#add-pic").find('.modal-title').text('Add Data PIC');
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

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function reims(id)
    {
        $(this).val($(this).attr('checked') ? $('#reimbursx').val(1) : $('#reimbursx').val(0) )
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

    function get_rate(val)
    {
        if(val!=''){
            $.ajax({
                type:"POST",
                url:"{{ route('quotation.quote_getCurrencyCode') }}",
                data:{
                    id : val
                },
                success:function(result){
                    let text = JSON.parse(result);
                    let code = text.code;

                    // if(code == 'IDR' && $('#rate').val() == '' && $('#ratex').val() == ''){
                    if(code == 'IDR'){
                        $('#rate').val(1);
                        $('#ratex').val(1);
                    }
                }
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
                // console.log(result)
                var tabel = JSON.parse(result);
                // console.warn(xhr.tabel)
                $('#tblDimension').html(tabel);
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

    /** Add Shipping Detail **/
    function newShipingDtl()
    {
        $('#id_s').val('');
        $('#truck_size').val('');
        $('#carrier').val('').trigger('change');
        $('#routing').val('');
        $('#transit').val('');
        $('#currency_ship_dtl').val('').trigger('change');
        $('#rate').val('');
        $('#ratex').val('');
        $('#cost').val('');
        $('#sell').val('');
        $('#qty').val('');
        $('#cost_val').val('');
        $('#sell_val').val('');
        $('#vat').val('');
        $('#total').val('');
        $('#note').val('');

        dsState = "Input";
        
        $("#shipping-detail").find('.modal-title').text('Add Shipping Detail');
        $("#shipping-detail").modal('show',{backdrop: 'true'}); 
    }


    /** Add Detail Quote **/
    function newDetailQuote()
    {
        $('#charge').val('').trigger('change');
        $('#descx').val('');
        $('#currencyx').val('').trigger('change');
        $('#reimburs').prop('checked',false);
        $('#reimbursx').val(0);
        $('#rate').val('');
        $('#ratex').val('');
        $('#costx').val('');
        $('#sellx').val('');
        $('#qtyx').val('');
        $('#cost_valx').val('');
        $('#sell_valx').val('');
        $('#vatx').val('');
        $('#totalx').val('');
        $('#notex').val('');

        dsState = "Input";
        
        $("#detail-quote").find('.modal-title').text('Add Detail Quote');
        $("#detail-quote").modal('show',{backdrop: 'true'}); 
    }


    /*** Hapus Dimension **/
    function hapusDetaild(id){
        var r=confirm("Anda yakin menghapus data ini?");
        if (r==true){
            $.ajax({
                type:"POST",
                url:"{{ route('quotation.quote_deleteDimension') }}",
                data:"id="+ id,
                success:function(result){
                    loadDimension({{ Request::segment(3) }}, 'a');   
                },error: function (xhr, ajaxOptions, thrownError) {           
                    alert('Gagal Menghapus Dimension!');
                }, 
            });
        }
    }


    /*** Hapus Shipping **/
    function hapusDetails(id){
        var r=confirm("Anda yakin menghapus data ini?");
        if (r==true){
            $.ajax({
                type:"POST",
                url:"{{ route('quotation.quote_deleteShipping') }}",
                data:"id="+ id,
                success:function(result){
                    Toast.fire({
                        icon: 'success',
                        title: 'success deleted!'
                    })  
                    loadShipping({{ Request::segment(3) }}, 'a'); 
                    loadProfit({{ Request::segment(3) }}); 
                },error: function (xhr, ajaxOptions, thrownError) {           
                    alert('Gagal Menghapus Dimension!');
                }, 
            });
        }
    }

    /*** Hapus Detail Quote **/
    function hapusDetailx(id){
        var r=confirm("Anda yakin menghapus data ini?");
        if (r==true){
            $.ajax({
                type:"POST",
                url:"{{ route('quotation.quote_deleteDetail') }}",
                data:{
                    id : id,
                    quote : {{ Request::segment(3) }}
                },
                success:function(result){
                    Toast.fire({
                        icon: 'success',
                        title: 'success deleted!'
                    })
                    loadDetail({{ Request::segment(3) }}, 'a');   
                    loadProfit({{ Request::segment(3) }}); 
                },error: function (xhr, ajaxOptions, thrownError) {           
                    alert('Gagal Menghapus Dimension!');
                }, 
            });
        }
    }

    /** Delete All Quote Detail **/
    function deleteAllQuoteDetail()
    {
        if($('input[name="deleteAll"]:checked').val() == null){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Min One Quote Detail',
                icon: 'error'
            })
        }else{
            var r=confirm("Anda yakin menghapus semua data yang telah dipilih?");
            if(r==true){
                let dtlQuote = [];
                $('input[name="deleteAll"]:checked').each(function(){        
                    var valDtlQuote = $(this).val();
                    dtlQuote.push(valDtlQuote);
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('quotation.quote_deleteAll') }}",
                    data: {
                        detail:dtlQuote,
                        quote : {{ Request::segment(3) }}
                    },
                    dataType: 'json',
                    cache: false,
                    success: function (response) {
                        Toast.fire({
                            icon: 'success',
                            title: 'success deleted!'
                        })

                        loadDetail({{ Request::segment(3) }}, 'a');   
                        loadProfit({{ Request::segment(3) }}); 
                    },
                    error: function (xhr, ajaxOptions, thrownError) {           
                        alert('gagal')           
                    },

                });
            }
        }
    }

    /*** Edit Dimension **/
    function editDetaild(height_uom, wight_uom,id){
        let style = '';
        let style2 = '';
        let html = '';
        let html2 = '';
        $.ajax({
            url: "{{ route('quotation.quote_getAll') }}",
            type: "POST",
            dataType: "json",
            success: function(result) {
                
                $.each(result, function(i,data){
                    if(height_uom == data.id){
                        style = 'selected';
                    }else{
                        style = '';
                    }
                    html += `<option value="${data.id}" ${style}>${data.uom_code}</option>`;
                })

                $.each(result, function(i,data){
                    if(wight_uom == data.id){
                        style2 = 'selected';
                    }else{
                        style2 = '';
                    }
                    html2 += `<option value="${data.id}" ${style2}>${data.uom_code}</option>`;
                })


                $('#btnEditd_'+id).hide();
                $('#lbl_length_'+id).hide();
                $('#lbl_width_'+id).hide();
                $('#lbl_height_'+id).hide();
                $('#lbl_height_uom_'+id).hide();
                $('#lbl_total_cbm_'+id).hide();
                $('#lbl_pieces_'+id).hide();
                $('#lbl_wight_'+id).hide();
                $('#lbl_wight_uom_'+id).hide();
                $('#lbl_total_weight_'+id).hide();

                $("#height_uom_"+id).show();
                $("#height_uom_"+id).html(html);
                $("#height_uom_"+id).select2({
                    theme: 'bootstrap4'
                });
                
                $('#wight_uom_'+id).show();
                $('#wight_uom_'+id).html(html2);
                $("#wight_uom_"+id).select2({
                    theme: 'bootstrap4'
                });

                $('#length_'+id).show();
                $('#width_'+id).show();
                $('#height_'+id).show();
                $('#pieces_'+id).show();
                $('#wight_'+id).show();
                $('#total_cbm_'+id).show();
                $('#total_weight_'+id).show();
                $('#btnUpdated_'+id).show();
            }
        });
    }

    /*** Edit Dimension **/
    function editDetails(id){
        $.ajax({
            url: "{{ route('quotation.quote_getDetailShipping') }}",
            type: "POST",
            data: {
                id: id
            },
            dataType: "html",
            success: function(result) {
                let data = JSON.parse(result);
                console.log(data);
                let cost_val = data.cost_val
                let sell_val = data.sell_val
                let subtotal = data.subtotal
                cost_val = numberWithCommas(Number(cost_val));
                sell_val = numberWithCommas(Number(sell_val));
                subtotal = numberWithCommas(Number(subtotal));
                $('#id_s').val(data.id);
                $('#truck_size').val(data.truck_size);
                $('#carrier').val(data.t_mcarrier_id).trigger('change');
                $('#routing').val(data.routing);
                $('#transit').val(data.transit_time);
                $('#currency_ship_dtl').val(data.t_mcurrency_id).trigger('change');
                $('#rate').val(Number(data.rate));
                $('#cost').val(Number(data.cost));
                $('#sell').val(Number(data.sell));
                $('#qty').val(data.qty);
                $('#cost_val').val(cost_val);
                $('#sell_val').val(sell_val);
                $('#vat').val(Number(data.vat));
                $('#total').val(subtotal);
                $('#note').val(data.notes);

                dsState = "Edit";
                
                $("#shipping-detail").find('.modal-title').text('Edit Data');
                $("#shipping-detail").modal('show',{backdrop: 'true'}); 
                
            }
        });
    }

     /*** Edit Detail Quote **/
     function editDetailx(id){
        $.ajax({
            url: "{{ route('quotation.quote_getDetailQ') }}",
            type: "POST",
            data: {
                id: id,
            },
            dataType: "html",
            success: function(result) {
                let data = JSON.parse(result);
                let cost_val = data.cost_val
                let sell_val = data.sell_val
                let subtotal = data.subtotal
                cost_val = numberWithCommas(Number(cost_val));
                sell_val = numberWithCommas(Number(sell_val));
                subtotal = numberWithCommas(Number(subtotal));

                $('#charge').val(data.t_mcharge_code_id).trigger('change');
                $('#descx').val(data.desc);
                $('#id_dtl_quote').val(data.id);
                $('#ratex').val(numberWithCommas(Number(data.rate)));
                $('#currencyx').val(data.t_mcurrency_id).trigger('change');
                if(data.reimburse_flag == 1){
                    $('#reimburs').prop('checked',true);
                    $('#reimbursx').val(1);
                }else{
                    $('#reimburs').prop('checked',false);
                    $('#reimbursx').val(0)
                }
                $('#costx').val(numberWithCommas(Number(data.cost)));
                $('#sellx').val(numberWithCommas(Number(data.sell)));
                $('#qtyx').val(numberWithCommas(Number(data.qty)));
                $('#cost_valx').val(cost_val);
                $('#sell_valx').val(sell_val);
                $('#vatx').val(numberWithCommas(Number(data.vat)));
                $('#totalx').val(subtotal);
                $('#notex').val(data.notes);

                dsState = "Edit";
        
                $("#detail-quote").find('.modal-title').text('Edit Detail Quote');
                $("#detail-quote").modal('show',{backdrop: 'true'});
               
            }
        });
    }


    /** Update Dimension **/
    function updateDetaild(id_detail, id)
    {
        if($.trim($("#length_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Length!'
            })
        }else if($.trim($("#width_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input width!'
            });
        }else if($.trim($("#height_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Height!'
            });
        }else if($.trim($("#height_uom_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please select Uom!'
            });
        }else if($.trim($("#wight_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Wight!'
            });
        }else if($.trim($("#wight_uom_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please select Uom!'
            });
        }else{
            $.ajax({
                type:"POST",
                url:"{{ route('quotation.quote_updateDimension') }}",
                data:{
                    id:id_detail,
                    length:$('#length_'+id).val(),
                    width:$('#width_'+id).val(),
                    height:$('#height_'+id).val(),
                    total_cbm:$('#total_cbm_'+id).val(),
                    height_uom:$('#height_uom_'+id).val(),
                    wight:$('#wight_'+id).val(),
                    wight_uom:$('#wight_uom_'+id).val(),
                    total_weight:$('#total_weight_'+id).val(),
                    pieces:$('#pieces_'+id).val()
                },
                success:function(result){
                    loadDimension({{ Request::segment(3) }}, 'a'); 
                },error: function (xhr, ajaxOptions, thrownError) {           
                    alert('Gagal Mengupdate Dimension!');
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
            }else{
                getComa(root.value,root.id);
            }
        }
    }

    function getComa(value, id){
        angka = value.toString().replace(/\./g, "");
        $('#'+id).val(angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    }

    /** Hitung Cost Val Shipping Detail **/
    function hitung(root)
    {
        getComa(root.value,root.id);
        const cost = $('#qty').val().toString().replace(/\./g, "")*Number($('#sell_val').val().toString().replace(/\./g, ""));
        let nilai1 = $('#rate').val().toString().replace(/\./g, "")*$('#cost').val().toString().replace(/\./g, "");
        let nilai2 = $('#rate').val().toString().replace(/\./g, "")*$('#sell').val().toString().replace(/\./g, "");

        /** Menghitung Cost Value **/
        let cost_val = Number(nilai1)*Number($('#qty').val().toString().replace(/\./g, ""));
        cost_val = cost_val.toFixed(2)
        cost_val = numberWithCommas(Number(cost_val));

        /** Menghitung Cost Value **/
        let sell_val = Number(nilai2)*Number($('#qty').val().toString().replace(/\./g, ""));
        sell_val = sell_val.toFixed(2)
        sell_val = numberWithCommas(Number(sell_val));

        
        $('#cost_val').val(cost_val);
        $('#sell_val').val(sell_val);
        hitungTotal();
        
    }

    /** Hitung Cost Val Detail Quote **/
    function hitungx(root)
    {
        getComa(root.value,root.id);
        let nilai1 = $('#ratex').val().toString().replace(/\./g, "")*$('#costx').val().toString().replace(/\./g, "");
        let nilai2 = $('#ratex').val().toString().replace(/\./g, "")*$('#sellx').val().toString().replace(/\./g, "");

        /** Menghitung Cost Value **/
        let cost_val = Number(nilai1)*Number($('#qtyx').val().toString().replace(/\./g, ""));
        cost_val = cost_val.toFixed(2)
        cost_val = numberWithCommas(Number(cost_val));

        /** Menghitung Cost Value **/
        let sell_val = Number(nilai2)*Number($('#qtyx').val().toString().replace(/\./g, ""));
        sell_val = sell_val.toFixed(2)
        sell_val = numberWithCommas(Number(sell_val));

        $('#cost_valx').val(cost_val);
        $('#sell_valx').val(sell_val);
        hitungTotalx();
        
    }

    /** Hitung Total Shipping Detail **/
    function hitungTotal()
    {
        let sellVal = $('#sell_val').val().toString().replace(/\./g, "");
        sellVal = sellVal.toString().replace(/\./g, "");
        // const cost = $('#qty').val()*sellVal;
        let total = Number(sellVal)+Number($('#vat').val().toString().replace(/\./g, ""));
        total = total.toFixed(2)
        total = numberWithCommas(Number(total));
        $('#total').val(total);
    }


    /** Hitung Total Detail Quote **/
    function hitungTotalx()
    {
        let sellVal = $('#sell_valx').val().toString().replace(/\./g, "");
        sellVal = sellVal.toString().replace(/\./g, "");
        // const cost = $('#qtyx').val()*sellVal;
        let total = Number(sellVal)+Number($('#vatx').val().toString().replace(/\./g, ""));
        total = total.toFixed(2)
        total = numberWithCommas(Number(total));
        $('#totalx').val(total);
    }
  

    /** Save Detail Dimension **/
    function saveDetailx(id){
        if($.trim($("#length_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Length!'
            })
        }else if($.trim($("#width_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input width!'
            });
        }else if($.trim($("#height_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Height!'
            });
        }else if($.trim($("#height_uom_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please select Uom!'
            });
        }else if($.trim($("#wight_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Wight!'
            });
        }else if($.trim($("#wight_uom_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please select Uom!'
            });
        }else{
            $.ajax({
            type:"POST",
            url:"{{ route('quotation.quote_addDimension') }}",
            data:{
                quote:{{ $quote->id }},
                length:$('#length_'+id).val(),
                width:$('#width_'+id).val(),
                height:$('#height_'+id).val(),
                total_cbm:$('#total_cbm_'+id).val(),
                height_uom:$('#height_uom_'+id).val(),
                wight:$('#wight_'+id).val(),
                wight_uom:$('#wight_uom_'+id).val(),
                total_weight:$('#total_weight_'+id).val(),
                pieces:$('#pieces_'+id).val()
            },
            success:function(result){
                $('#length_'+id).val('');
                $("#width_"+id).val('');
                $('#height_'+id).val('');
                $('#height_uom_'+id).val('').trigger('change');
                $('#total_cbm_'+id).val('');
                $('#wight_'+id).val('');
                $('#wight_uom_'+id).val('').trigger('change');
                $('#total_weight_'+id).val('');
                $('#pieces_'+id).val('');
                loadDimension({{ Request::segment(3) }}, 'a');
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

    /** Save Detail Shipping **/
    function saveDetailxx(){
       if($.trim($("#currency_ship_dtl").val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please select Currency!'
            });
        }else if($.trim($("#rate").val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Rate!'
            });
        }else if($.trim($("#cost").val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Cost!'
            });
        }else if($.trim($("#sell").val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Sell!'
            });
        }else if($.trim($("#qty").val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Qty!'
            });
        }else{
            if(dsState == "Input"){
                $.ajax({
                type:"POST",
                url:"{{ route('quotation.quote_addShipping') }}",
                data:{
                    quote:{{ $quote->id }},
                    carrier:$('#carrier').val(),
                    routing:$('#routing').val(),
                    transit:$('#transit').val(),
                    currency:$('#currency_ship_dtl').val(),
                    rate:$('#rate').val(),
                    cost:$('#cost').val(),
                    sell:$('#sell').val(),
                    qty:$('#qty').val(),
                    cost_val:$('#cost_val').val(),
                    sell_val:$('#sell_val').val(),
                    vat:$('#vat').val(),
                    total:$('#total').val(),
                    note:$('#note').val(),
                    truck_size:$('#truck_size').val()
                },
                success:function(result){
                    $('#shipping-detail').modal('hide')
                    loadShipping({{ Request::segment(3) }}, 'a');
                    loadProfit({{ Request::segment(3) }}); 
                    Toast.fire({
                        icon: 'success',
                        title: 'Sukses Add Data!'
                    });
                },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal menambahkan item!');
                    },  
                });
            }else{
                $.ajax({
                    type:"POST",
                    url:"{{ route('quotation.quote_updateShipping') }}",
                    data:{
                        id:$('#id_s').val(),
                        carrier:$('#carrier').val(),
                        routing:$('#routing').val(),
                        transit:$('#transit').val(),
                        currency:$('#currency_ship_dtl').val(),
                        rate:$('#rate').val(),
                        cost:$('#cost').val(),
                        sell:$('#sell').val(),
                        qty:$('#qty').val(),
                        cost_val:$('#cost_val').val(),
                        sell_val:$('#sell_val').val(),
                        vat:$('#vat').val(),
                        total:$('#total').val(),
                        note:$('#note').val(),
                        truck_size:$('#truck_size').val(),
                        quote:{{ Request::segment(3) }}
                    },
                    success:function(result){
                        $('#shipping-detail').modal('hide')
                        loadShipping({{ Request::segment(3) }}, 'a');
                        loadProfit({{ Request::segment(3) }}); 
                        Toast.fire({
                            icon: 'success',
                            title: 'Sukses Update Data!'
                        });
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Mengupdate Dimension!');
                    },          
                });
            }
        }
    }

     /** Save Detail Quote **/
     function saveDetailxxx(){
        $('#detail_quote_submit').prop('disabled', true);
        if($.trim($("#charge").val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please Select Charge!'
            });
            $('#detail_quote_submit').prop('disabled', false);
        }else if($.trim($("#currencyx").val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please Select Currency!'
            });
            $('#detail_quote_submit').prop('disabled', false);
        }else if($.trim($("#ratex").val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Rate!'
            });
            $('#detail_quote_submit').prop('disabled', false);
        }else if($.trim($("#costx").val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Cost!'
            });
            $('#detail_quote_submit').prop('disabled', false);
        }else if($.trim($("#sellx").val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Sell!'
            });
            $('#detail_quote_submit').prop('disabled', false);
        }else if($.trim($("#qtyx").val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Qty!'
            });
            $('#detail_quote_submit').prop('disabled', false);
        }else{
            if(dsState == "Input")
            {
                $.ajax({
                    type:"POST",
                    url:"{{ route('quotation.quote_addDetail') }}",
                    data:{
                        quote:{{ $quote->id }},
                        quote_no : $('#quote_no').val(),
                        charge:$('#charge').val(),
                        desc:$('#descx').val(),
                        reimburs:$('#reimbursx').val(),
                        currency:$('#currencyx').val(),
                        rate:$('#ratex').val(),
                        cost:$('#costx').val(),
                        sell:$('#sellx').val(),
                        qty:$('#qtyx').val(),
                        cost_val:$('#cost_valx').val(),
                        sell_val:$('#sell_valx').val(),
                        vat:$('#vatx').val(),
                        total:$('#totalx').val(),
                        note:$('#notex').val()
                    },
                    success:function(result){
                        $('#detail-quote').modal('hide')
                        $('#detail_quote_submit').prop('disabled', false);
                        loadDetail({{ Request::segment(3) }}, 'a');
                        loadProfit({{ Request::segment(3) }}); 
                        Toast.fire({
                            icon: 'success',
                            title: 'Sukses Add Data!'
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {  
                        $('#detail_quote_submit').prop('disabled', false);         
                        alert('Gagal menambahkan item!');
                    },  
                });
            }else{
                $.ajax({
                    type:"POST",
                    url:"{{ route('quotation.quote_updateDetail') }}",
                    data:{
                        id:$('#id_dtl_quote').val(),
                        charge:$('#charge').val(),
                        desc:$('#descx').val(),
                        reimburs:$('#reimbursx').val(),
                        currency:$('#currencyx').val(),
                        rate:$('#ratex').val(),
                        cost:$('#costx').val(),
                        sell:$('#sellx').val(),
                        qty:$('#qtyx').val(),
                        cost_val:$('#cost_valx').val(),
                        sell_val:$('#sell_valx').val(),
                        vat:$('#vatx').val(),
                        total:$('#totalx').val(),
                        note:$('#notex').val(),
                        quote:{{ Request::segment(3) }}
                    },
                    success:function(result){
                        $('#detail_quote_submit').prop('disabled', false);
                        $('#detail-quote').modal('hide')
                        loadDetail({{ Request::segment(3) }}, 'a'); 
                        loadProfit({{ Request::segment(3) }}); 
                        Toast.fire({
                            icon: 'success',
                            title: 'Sukses Update Data!'
                        });
                    },error: function (xhr, ajaxOptions, thrownError) {  
                        $('#detail_quote_submit').prop('disabled', false);        
                        alert('Gagal Mengupdate!');
                    },          
                });
            }
        }
    }

    function createBooking()
    {
        var table = document.getElementById("tblShipping");
        var countTbl = table.rows.length;

        if(countTbl > 1){
            Swal.fire({
                title: 'Error!',
                text: 'shipping details match not be more then one!',
                icon: 'error'
            })
        }else if($("#tabel-shipping-cek").val() == 'true'){
            Swal.fire({
                title: 'Error!',
                text: 'please input shipping details',
                icon: 'error'
            })
        }else{
            window.location.href = "{{ url('booking/header_booking/'.$quote->id) }}";
        }


    }

    function updateData()
    {
        var r=confirm(`Update this data?`);
        if(r == true){
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
            // }else if($.trim($("#pieces").val()) == ""){
            //     Swal.fire({
            //         title: 'Error!',
            //         text: 'Please input Pieces',
            //         icon: 'error'
            //     })
            // }else if($.trim($("#weight").val()) == ""){
            //     Swal.fire({
            //         title: 'Error!',
            //         text: 'Please input Weight',
            //         icon: 'error'
            //     })
            // }else if($.trim($("#uom_weight").val()) == ""){
            //     Swal.fire({
            //         title: 'Error!',
            //         text: 'Please select UOM Weight',
            //         icon: 'error'
            //     })
            // }else if($.trim($("#volume").val()) == ""){
            //     Swal.fire({
            //         title: 'Error!',
            //         text: 'Please input Volume',
            //         icon: 'error'
            //     })
            // }else if($.trim($("#uom_volume").val()) == ""){
            //     Swal.fire({
            //         title: 'Error!',
            //         text: 'Please select UOM Volume',
            //         icon: 'error'
            //     })
            }else{
                $(this).prop('disabled', false).text('Please Wait ...');
                $('#formku').submit();
            }
        }
    }

    function show_service(val)
    {
        if(val!= ''){
            $('.div_after').show();
            $('.show_port_from').hide();
            $('.show_door_from').hide();
            $('.show_port_to').hide();
            $('.show_door_to').hide();
            if(val==1){//port to port
                $('.show_port_from').show();
                $('.show_port_to').show();
            }else if(val==2){//Port to Door
                $('.show_port_from').show();
                $('.show_port_to').show();
                $('.show_door_to').show();
            }else if(val==3){//door to port
                $('.show_port_from').show();
                $('.show_door_from').show();
                $('.show_port_to').show();
            }else if(val==4){//door to door
                $('.show_port_from').show();
                $('.show_door_from').show();
                $('.show_port_to').show();
                $('.show_door_to').show();
            }
        }else{
            $('.div_after').hide();
        }
    }

    function get_port_name(id){
        const port_name = $('#'+id+'_id').select2('data')[0].text;
        $('#'+id).val(port_name);
    }

    $(function() {
        $('.select-ajax-port').select2({
            theme: "bootstrap4",
          ajax: {
            url: '{{ route("quotation.get_where_port") }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
              return {
                results: data.items,
              };
            },
            cache: true
          },
          placeholder: 'Search Port',
          minimumInputLength: 3,
        });
        loadDimension({{ Request::segment(3) }}, 'a');
        loadShipping({{ Request::segment(3) }}, 'a');
        loadDetail({{ Request::segment(3) }}, 'a');
        loadProfit({{ Request::segment(3) }}); 
        show_service({{$quote->t_mservice_type_id}});
        get_customer({{ $quote->customer_id }});
        get_pic({{ $quote->customer_id }});
    });
  </script>
      
  @endpush    
@endsection


