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
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Quote Number</label>
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
                                        <input type="checkbox" name="final" id="final" style="margin-right: 5px" @if ($quote->final_flag == 1)
                                            checked
                                        @endif><label> FINAL</label>
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
                                    <div class="col-md-6">
                                        <select class="form-control select2bs44" style="width: 100%;" name="customer" id="customer" onchange="get_pic(this.value)">
                                            <option value="" selected>-- Select Customer --</option>
                                            @foreach ($company as $c)
                                            <option value="{{ $c->id }}" @if ($quote->customer_id == $c->id)
                                                selected
                                            @endif>{{ $c->client_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mt-1">
                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                                            <option value="{{ $quote->id_pic }}" selected>{{ $quote->name_pic }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mt-1">
                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                                   <th width="1%">#</th>
                                   <th width="10%">Length</th>
                                   <th width="10%">Width</th>
                                   <th width="10%">Height</th>
                                   <th width="15%">UOM</th>
                                   <th width="10%">Pieces</th>
                                   <th width="9%">Wight</th>
                                   <th width="15%">UOM</th>
                                   <th width="15%">Action</th>
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
                                        <input type="text" class="form-control" name="length" id="length_1" placeholder="Length ..." onkeyup="numberOnly(this)">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="width" id="width_1" placeholder="Width ..." onkeyup="numberOnly(this)">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="height" id="height_1" placeholder="Height ..." onkeyup="numberOnly(this)">
                                   </td>
                                   <td>
                                       <select class="form-control select2bs44" name="height_uom" id="height_uom_1">
                                            <option value="">--Select Uom--</option>
                                            @foreach ($uom as $item)
                                            <option value="{{ $item->id }}">{{ $item->uom_code }}</option>                                                
                                            @endforeach
                                       </select>
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="pieces" id="pieces_1" placeholder="Pieces ..." onkeyup="numberOnly(this)">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="wight" id="wight_1" placeholder="Wight ..." onkeyup="numberOnly(this)">
                                   </td>
                                   <td>
                                        <select class="form-control select2bs44" name="wight_uom" id="wight_uom_1">
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
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table_lowm table-bordered" id="Table1">
                           <thead>
                               <tr>
                                   <th width="1%">#</th>
                                   <th width="2%">No</th>
                                   <th width="15%">Carrier</th>
                                   <th width="10%">Routing</th>
                                   <th width="5%">Transit time(days)</th>
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
                                   <th width="6%">Action</th>
                               </tr>
                           </thead>
                           <tbody>
                               <tbody id="tblShipping">

                               </tbody>
                               <tr>
                                   <td>
                                       <input type="checkbox" name="cek" id="cek_1">
                                   </td>
                                   <td>
                                        <i class="fa fa-plus"></i>
                                   </td>
                                   <td>
                                        <select class="form-control select2bs44" name="carrier" id="carrier_1">
                                            <option value="">--Select Carrier--</option>
                                            @foreach ($carrier as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>                                                
                                            @endforeach
                                        </select>
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="routing" id="routing_1" placeholder="Routing ...">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="transit_time" id="transit_1" placeholder="Transit..." onkeyup="numberOnly(this)">
                                   </td>
                                   <td>
                                        <select class="form-control select2bs44" name="currency" id="currency_1">
                                            <option value="">--Select Currency--</option>
                                            @foreach ($currency as $item)
                                            <option value="{{ $item->id }}">{{ $item->code }}</option>                                                
                                            @endforeach
                                        </select>
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="rate" id="rate_1" placeholder="Rate ..." onkeyup="numberOnly(this)">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="cost" id="cost_1" placeholder="Cost ..." onkeyup="numberOnly(this)">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="sell" id="sell_1" placeholder="Sell ..." onkeyup="numberOnly(this)">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="qty" id="qty_1" placeholder="Qty ..." onkeyup="hitung(1)">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="cost_value" id="cost_val_1" placeholder="Cost Value ..." onkeyup="numberOnly(this)">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="sell_value" id="sell_val_1" placeholder="Sell Value ..." onkeyup="hitung(1)">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="vat" id="vat_1" placeholder="Vat ..." onkeyup="hitung(1)">
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="total" id="total_1" placeholder="Total ..." readonly>
                                   </td>
                                   <td>
                                        <input type="text" class="form-control" name="note" id="note_1" placeholder="Note ...">
                                   </td>
                                   <td>
                                        <button class="btn btn-block btn-outline-success btn-xs" onclick="saveDetailxx(1)"><i class="fa fa-plus"></i> Add</button>
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
                        <h3 class="card-title">Detail quote</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table_lowm table-bordered" id="Table2">
                           <thead>
                               <tr>
                                   <th>#</th>
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
                                   <th width="6%">Action</th>
                               </tr>
                           </thead>
                           <tbody>
                               <tbody id="tblDetail">

                               </tbody>
                               <tr>
                                   <td>
                                        <input type="checkbox" name="cek" id="cekx_1">
                                   </td>
                                   <td>
                                        <i class="fa fa-plus"></i>
                                   </td>
                                   <td>
                                        <select class="form-control select2bs44" name="charge" id="charge_1">
                                            <option value="">--Select Charge Code--</option>
                                            @foreach ($charge as $item)
                                            <option value="{{ $item->id }}">{{ $item->code }}</option>                                                
                                            @endforeach
                                        </select>
                                   </td>
                                   <td>
                                    <input type="text" class="form-control" name="desc" id="descx_1" placeholder="Desc ...">
                                   </td>
                                   <td align="center">
                                        <input type="checkbox" name="reimbursx" id="reimburs_1" onchange="reims(1)">
                                        <input type="hidden" name="reimbursxx" id="reimbursx_1" value="">
                                   </td>
                                   <td>
                                    <select class="form-control select2bs44" name="currency" id="currencyx_1">
                                        <option value="">--Select Currency--</option>
                                        @foreach ($currency as $item)
                                        <option value="{{ $item->id }}">{{ $item->code }}</option>                                                
                                        @endforeach
                                    </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="rate" id="ratex_1" placeholder="Rate ..." onkeyup="numberOnly(this)">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="cost" id="costx_1" placeholder="Cost ..." onkeyup="numberOnly(this)">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="sell" id="sellx_1" placeholder="Sell ..." onkeyup="numberOnly(this)">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="qty" id="qtyx_1" placeholder="Qty ..." onkeyup="hitungx(1)">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="cost_value" id="costx_val_1" placeholder="Cost Value ..." onkeyup="numberOnly(this)">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="sell_value" id="sellx_val_1" placeholder="Sell Value ..." onkeyup="hitungx(1)">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="vat" id="vatx_1" placeholder="Vat ..." onkeyup="hitungx(1)">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="total" id="totalx_1" placeholder="Total ..." readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="note" id="notex_1" placeholder="Note ...">
                                    </td>
                                    <td>
                                        <button class="btn btn-block btn-outline-success btn-xs" onclick="saveDetailxxx(1)"><i class="fa fa-plus"></i> Add</button>
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
                        <h3 class="card-title">Profit Analysis</h3>
                        <button type="button" class="btn btn-primary float-right" id="calculate" onclick="calculate()"><i class="fa fa-calculator"></i> Calculate</button>
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table_lowm table-bordered">
                           <thead>
                               <tr>
                                   <td class="text-center">Carrier</td>
                                   <td class="text-center">Routing</td>
                                   <td class="text-center">Transit Time</td>
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
                <a href="{{ url('quotation/quote_new/'.$quote->id) }}" class="btn btn-info float-left mr-2"> 
                    <i class="fa fa-plus"></i> New Version 
                </a>
                <a href="" class="btn btn-primary float-left mr-2"> 
                    <i class="fa fa-file"></i> Preview Quotation 
                </a>
                <a href="" class="btn btn-danger float-left mr-2 @if ($quote->final_flag !== 1)
                    disabledx
                @endif"> 
                    <i class="fa fa-envelope"></i> Send Email 
                </a>
                <a href="{{ url('booking/header_booking/'.$quote->id) }}" class="btn btn-success float-left mr-2 @if ($quote->final_flag !== 1)
                    disabledx
                @endif"> 
                    <i class="fa fa-plus"></i> Create Booking Order 
                </a>
            </div>
        </div>
    </div>
</section>
  @push('after-scripts')

  <script>
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function reims(id)
    {
        $(this).val($(this).attr('checked') ? $('#reimbursx_'+id).val(1) : $('#reimbursx_'+id).val(0) )
        //$(this).val($(this).attr('checked') ? alert('1') : alert('0') )
    }
    
    function get_pic(val){
        if(val!= ''){
            $.ajax({
                url: "{{ route('get.pic') }}",
                type: "POST",
                data: "id="+val,
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

    /** Load Dimension **/
    function loadDimension(id){
        $.ajax({
            type:"POST",
            url:"{{ route('quotation.quote_loadDimension') }}",
            data:"id="+id,
            dataType:"html",
            success:function(result){
                // console.log(result)
                var tabel = JSON.parse(result);
                // console.warn(xhr.tabel)
                $('#tblDimension').html(tabel);
            }
        })
    }


    /** Load Dimension **/
    function loadShipping(id){
        $.ajax({
            type:"POST",
            url:"{{ route('quotation.quote_loadShipping') }}",
            data:"id="+id,
            dataType:"html",
            success:function(result){
                var tabel = JSON.parse(result);
                $('#tblShipping').html(tabel);
            }
        })
    }

    /** Load Dimension **/
    function loadDetail(id){
        $.ajax({
            type:"POST",
            url:"{{ route('quotation.quote_loadDetail') }}",
            data:"id="+id,
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
            data:"id="+id,
            dataType:"html",
            success:function(result){
                var tabel = JSON.parse(result);
                $('#tblProfit').html(tabel);
            }
        })
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
                    loadDimension({{ Request::segment(3) }});   
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
                    loadShipping({{ Request::segment(3) }});   
                },error: function (xhr, ajaxOptions, thrownError) {           
                    alert('Gagal Menghapus Dimension!');
                }, 
            });
        }
    }

    /*** Hapus Shipping **/
    function hapusDetailx(id){
        var r=confirm("Anda yakin menghapus data ini?");
        if (r==true){
            $.ajax({
                type:"POST",
                url:"{{ route('quotation.quote_deleteDetail') }}",
                data:"id="+ id,
                success:function(result){
                    Toast.fire({
                        icon: 'success',
                        title: 'success deleted!'
                    })
                    loadDetail({{ Request::segment(3) }});   
                },error: function (xhr, ajaxOptions, thrownError) {           
                    alert('Gagal Menghapus Dimension!');
                }, 
            });
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
                $('#lbl_pieces_'+id).hide();
                $('#lbl_wight_'+id).hide();
                $('#lbl_wight_uom_'+id).hide();

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
                $('#btnUpdated_'+id).show();
            }
        });
    }

    /*** Edit Dimension **/
    function editDetails(carrier, currency, id){
        $.ajax({
            url: "{{ route('quotation.quote_getDetailShipping') }}",
            type: "POST",
            data: {
                carrier: carrier,
                currency: currency
            },
            dataType: "html",
            success: function(result) {
                let data = JSON.parse(result);

                $('#btnEdits_'+id).hide();
                $('#lbl_carrier_'+id).hide();
                $('#lbl_routing_'+id).hide();
                $('#lbl_transit_'+id).hide();
                $('#lbl_currency_'+id).hide();
                $('#lbl_rate_'+id).hide();
                $('#lbl_cost_'+id).hide();
                $('#lbl_sell_'+id).hide();
                $('#lbl_qty_'+id).hide();
                $('#lbl_cost_val_'+id).hide();
                $('#lbl_sell_val_'+id).hide();
                $('#lbl_vat_'+id).hide();
                $('#lbl_total_'+id).hide();
                $('#lbl_note_'+id).hide();

                $('#carrier_'+id).show();
                $('#carrier_'+id).html(data[0])
                $("#carrier_"+id).select2({
                    theme: 'bootstrap4'
                });
                $('#routing_'+id).show();
                $('#transit_'+id).show();
                $('#rate_'+id).show();
                $('#cost_'+id).show();
                $('#sell_'+id).show();
                $('#qty_'+id).show();
                $('#cost_val_'+id).show();
                $('#sell_val_'+id).show();
                $('#vat_'+id).show();
                $('#total_'+id).show();
                $('#note_'+id).show();

                $('#currency_'+id).show();
                $("#currency_"+id).html(data[1]);
                $("#currency_"+id).select2({
                    theme: 'bootstrap4'
                });
                $('#btnUpdates_'+id).show();
            }
        });
    }

     /*** Edit Detail Quote **/
     function editDetailx(charge, currency,id){
        let style = '';
        let style2 = '';
        let html = '';
        let html2 = '';
        $.ajax({
            url: "{{ route('quotation.quote_getDetailQ') }}",
            type: "POST",
            data: {
                charge: charge,
                currency: currency
            },
            dataType: "html",
            success: function(result) {
                let data = JSON.parse(result);
               

                $('#btnEditx_'+id).hide();
                $('#lbl_charge_'+id).hide();
                $('#lbl_descx_'+id).hide();
                $('#lbl_currencyx_'+id).hide();
                $('#lbl_ratex_'+id).hide();
                $('#lbl_costx_'+id).hide();
                $('#lbl_sellx_'+id).hide();
                $('#lbl_qtyx_'+id).hide();
                $('#lbl_costx_val_'+id).hide();
                $('#lbl_sellx_val_'+id).hide();
                $('#lbl_vatx_'+id).hide();
                $('#lbl_totalx_'+id).hide();
                $('#lbl_notex_'+id).hide();

                $("#charge_"+id).show();
                $("#charge_"+id).html(data[0]);
                $("#charge_"+id).select2({
                    theme: 'bootstrap4'
                });
                
                $('#currencyx_'+id).show();
                $('#currencyx_'+id).html(data[1]);
                $("#currencyx_"+id).select2({
                    theme: 'bootstrap4'
                });

                $('#descx_'+id).show();
                $('#ratex_'+id).show();
                $('#costx_'+id).show();
                $('#sellx_'+id).show();
                $('#qtyx_'+id).show();
                $('#costx_val_'+id).show();
                $('#sellx_val_'+id).show();
                $('#vatx_'+id).show();
                $('#totalx_'+id).show();
                $('#notex_'+id).show();
                $('#btnUpdatex_'+id).show();
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
                    height_uom:$('#height_uom_'+id).val(),
                    wight:$('#wight_'+id).val(),
                    wight_uom:$('#wight_uom_'+id).val(),
                    pieces:$('#pieces_'+id).val()
                },
                success:function(result){
                    loadDimension({{ Request::segment(3) }}); 
                },error: function (xhr, ajaxOptions, thrownError) {           
                    alert('Gagal Mengupdate Dimension!');
                },          
            });
        }
    }


    /** Update Shipping **/
    function updateDetails(id_detail, id)
    {
        if($.trim($("#carrier_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please Select Carrier!'
            })
        }else if($.trim($("#routing_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Routing!'
            });
        }else if($.trim($("#transit_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Transit Time!'
            });
        }else if($.trim($("#currency_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please select Currency!'
            });
        }else if($.trim($("#rate_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Rate!'
            });
        }else if($.trim($("#cost_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Cost!'
            });
        }else if($.trim($("#sell_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Sell!'
            });
        }else if($.trim($("#qty_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Qty!'
            });
        }else if($.trim($("#cost_val_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Cost Value!'
            });
        }else if($.trim($("#sell_val_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Sell Value!'
            });
        }else if($.trim($("#vat_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Vat!'
            });
        }else{
            $.ajax({
                type:"POST",
                url:"{{ route('quotation.quote_updateShipping') }}",
                data:{
                    id:id_detail,
                    carrier:$('#carrier_'+id).val(),
                    routing:$('#routing_'+id).val(),
                    transit:$('#transit_'+id).val(),
                    currency:$('#currency_'+id).val(),
                    rate:$('#rate_'+id).val(),
                    cost:$('#cost_'+id).val(),
                    sell:$('#sell_'+id).val(),
                    qty:$('#qty_'+id).val(),
                    cost_val:$('#cost_val_'+id).val(),
                    sell_val:$('#sell_val_'+id).val(),
                    vat:$('#vat_'+id).val(),
                    total:$('#total_'+id).val(),
                    note:$('#note_'+id).val()
                },
                success:function(result){
                    loadShipping({{ Request::segment(3) }}); 
                },error: function (xhr, ajaxOptions, thrownError) {           
                    alert('Gagal Mengupdate Dimension!');
                },          
            });
        }
    }


    /** Update Detail**/
    function updateDetailx(id_detail, id)
    {
        if($.trim($("#charge_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please Select Charge!'
            })
        }else if($.trim($("#currencyx_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please Select Currency!'
            });
        }else if($.trim($("#ratex_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Rate!'
            });
        }else if($.trim($("#costx_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Cost!'
            });
        }else if($.trim($("#sellx_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Sell!'
            });
        }else if($.trim($("#qtyx_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Qty!'
            });
        }else if($.trim($("#costx_val_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Cost Value!'
            });
        }else if($.trim($("#sellx_val_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Sell Value!'
            });
        }else{
            $.ajax({
                type:"POST",
                url:"{{ route('quotation.quote_updateDetail') }}",
                data:{
                    id:id_detail,
                    charge:$('#charge_'+id).val(),
                    desc:$('#descx_'+id).val(),
                    reimburs:$('#reimbursx_'+id).val(),
                    currency:$('#currencyx_'+id).val(),
                    rate:$('#ratex_'+id).val(),
                    cost:$('#costx_'+id).val(),
                    sell:$('#sellx_'+id).val(),
                    qty:$('#qtyx_'+id).val(),
                    cost_val:$('#costx_val_'+id).val(),
                    sell_val:$('#sellx_val_'+id).val(),
                    vat:$('#vatx_'+id).val(),
                    total:$('#totalx_'+id).val(),
                    note:$('#notex_'+id).val()
                },
                success:function(result){
                    loadDetail({{ Request::segment(3) }}); 
                },error: function (xhr, ajaxOptions, thrownError) {           
                    alert('Gagal Mengupdate!');
                },          
            });
        }
    }

    /** Calculate Profit **/
    function calculate()
    {
       
				
        if($('input[name="cekShipping"]:checked').val() == null){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Shipping',
                icon: 'error'
            })
        }else{
            let dtlQuote = [];
            let shipping = [];
            $('input[name="cekDetail"]:checked').each(function(){        
                var valDtlQuote = $(this).val();
                dtlQuote.push(valDtlQuote);
            });

            $('input[name="cekShipping"]:checked').each(function(){        
                let valShipping = $(this).val();
                shipping.push(valShipping);
            });
            $.ajax({
                type: "POST",
                url: "{{ route('quotation.quote_addProfit') }}",
                data: {detail:dtlQuote, shipping:shipping},
                dataType: 'json',
                cache: false,
                success: function (response) {
                    $('input[name="cekShipping"').prop('checked', false);
                    $('input[name="cekDetail"').prop('checked', false);
                    loadProfit({{ Request::segment(3) }});
                },
                error: function (xhr, ajaxOptions, thrownError) {           
                    alert('gagal')           
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
                height_uom:$('#height_uom_'+id).val(),
                wight:$('#wight_'+id).val(),
                wight_uom:$('#wight_uom_'+id).val(),
                pieces:$('#pieces_'+id).val()
            },
            success:function(result){
                $('#length_'+id).val('');
                $("#width_"+id).val('');
                $('#height_'+id).val('');
                $('#height_uom_'+id).val('').trigger('change');
                $('#wight_'+id).val('');
                $('#wight_uom_'+id).val('').trigger('change');
                $('#pieces_'+id).val('');
                loadDimension({{ Request::segment(3) }});
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
    function saveDetailxx(id){
        if($.trim($("#carrier_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please Select Carrier!'
            })
        }else if($.trim($("#routing_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Routing!'
            });
        }else if($.trim($("#transit_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Transit Time!'
            });
        }else if($.trim($("#currency_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please select Currency!'
            });
        }else if($.trim($("#rate_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Rate!'
            });
        }else if($.trim($("#cost_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Cost!'
            });
        }else if($.trim($("#sell_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Sell!'
            });
        }else if($.trim($("#qty_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Qty!'
            });
        }else if($.trim($("#cost_val_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Cost Value!'
            });
        }else if($.trim($("#sell_val_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Sell Value!'
            });
        }else{
            $.ajax({
            type:"POST",
            url:"{{ route('quotation.quote_addShipping') }}",
            data:{
                quote:{{ $quote->id }},
                carrier:$('#carrier_'+id).val(),
                routing:$('#routing_'+id).val(),
                transit:$('#transit_'+id).val(),
                currency:$('#currency_'+id).val(),
                rate:$('#rate_'+id).val(),
                cost:$('#cost_'+id).val(),
                sell:$('#sell_'+id).val(),
                qty:$('#qty_'+id).val(),
                cost_val:$('#cost_val_'+id).val(),
                sell_val:$('#sell_val_'+id).val(),
                vat:$('#vat_'+id).val(),
                total:$('#total_'+id).val(),
                note:$('#note_'+id).val()
            },
            success:function(result){
                $('#carrier_'+id).val('').trigger('change');
                $('#routing_'+id).val('');
                $('#transit_'+id).val('');
                $('#currency_'+id).val('').trigger('change');
                $('#rate_'+id).val('');
                $('#cost_'+id).val('');
                $('#sell_'+id).val('');
                $('#qty_'+id).val('');
                $('#cost_val_'+id).val('');
                $('#sell_val_'+id).val('');
                $('#vat_'+id).val('');
                $('#total_'+id).val('');
                $('#note_'+id).val('')
                loadShipping({{ Request::segment(3) }});
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

     /** Save Detail Quote **/
     function saveDetailxxx(id){

        if($.trim($("#charge_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please Select Charge!'
            })
        }else if($.trim($("#currencyx_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please Select Currency!'
            });
        }else if($.trim($("#ratex_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Rate!'
            });
        }else if($.trim($("#costx_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Cost!'
            });
        }else if($.trim($("#sellx_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Sell!'
            });
        }else if($.trim($("#qtyx_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Qty!'
            });
        }else if($.trim($("#costx_val_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Cost Value!'
            });
        }else if($.trim($("#sellx_val_"+id).val()) == ""){
            Toast.fire({
                icon: 'error',
                title: 'Please input Sell Value!'
            });
        }else{
            $.ajax({
            type:"POST",
            url:"{{ route('quotation.quote_addDetail') }}",
            data:{
                quote:{{ $quote->id }},
                charge:$('#charge_'+id).val(),
                desc:$('#descx_'+id).val(),
                reimburs:$('#reimbursx_'+id).val(),
                currency:$('#currencyx_'+id).val(),
                rate:$('#ratex_'+id).val(),
                cost:$('#costx_'+id).val(),
                sell:$('#sellx_'+id).val(),
                qty:$('#qtyx_'+id).val(),
                cost_val:$('#costx_val_'+id).val(),
                sell_val:$('#sellx_val_'+id).val(),
                vat:$('#vatx_'+id).val(),
                total:$('#totalx_'+id).val(),
                note:$('#notex_'+id).val()
            },
            success:function(result){
                $('#charge_'+id).val('').trigger('change');
                $('#descx_'+id).val('');
                $('#reimburs_'+id).val('');
                $('#reimburs_'+id).prop('checked',false);
                $('#currencyx_'+id).val('').trigger('change');
                $('#ratex_'+id).val('');
                $('#costx_'+id).val('');
                $('#sellx_'+id).val('');
                $('#qtyx_'+id).val('');
                $('#costx_val_'+id).val('');
                $('#sellx_val_'+id).val('');
                $('#vatx_'+id).val('');
                $('#totalx_'+id).val('');
                $('#notex_'+id).val('')
                loadDetail({{ Request::segment(3) }});
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

    function updateData()
    {
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
            $(this).prop('disabled', false).text('Please Wait ...');
            $('#formku').submit();
        }
    }

    $(function() {
        loadDimension({{ Request::segment(3) }});
        loadShipping({{ Request::segment(3) }});
        loadDetail({{ Request::segment(3) }});
        loadProfit({{ Request::segment(3) }}); 
    });
  </script>
      
  @endpush    
@endsection


