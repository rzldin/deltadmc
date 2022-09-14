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
                            Nomination
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
                    <form action="{{ route('booking.doAdd') }}" class="eventInsForm" method="post" target="_self" 
                        name="formku" id="formku" action=""> 
                        {{ csrf_field() }}
                    <div class="card-body">
                        <div class="container-fluid mt-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Booking Information</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label>Booking Number <font color="red">*</font></label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="booking_no" id="booking_no" placeholder="Booking No ...">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label>Booking Date</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                                <input type="text" name="booking_date" id="booking_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label>Version No</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="version_no" id="version_no" placeholder="Version No ..." value="1" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-5">
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label>Quote Number</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="quote_no" id="quote_no" placeholder="Quote No ..." value="Nomination" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label>Activity  <font color="red">*</font></label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="activity" id="activity" onchange="get_activity(this.value)">
                                                                <option value="" selected>-- Select Activity --</option>
                                                                <option value="export">EXPORT</option>
                                                                <option value="import">IMPORT</option>
                                                                <option value="domestic">DOMESTIC</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4" style="padding: 10px">
                                                            @foreach ($loaded as $l)
                                                            <div class="icheck-primary d-inline">
                                                                <input type="radio" class="loaded" id="loaded_{{ $l->id }}" name="loaded" value="{{ $l->id }}">
                                                                <label for="loaded_{{ $l->id }}">
                                                                    {{ $l->loaded_type }}
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            Note : Jenis Quote <strong>'Nomination'</strong>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="card card-primary customs-information">
                            <div class="card-header">
                                <h3 class="card-title">Customs Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Document Type</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control select2bs44" style="width: 100%;" name="doctype" id="doctype" >
                                                    <option value="">-- Select Document --</option>
                                                    @foreach ($doc as $d)
                                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Document Number</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="doc_no" id="doc_no" placeholder="Doc No ...">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Document Date</label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group date" id="reservationdateDOC" data-target-input="nearest">
                                                    <input type="text" name="doc_date" id="doc_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                    <div class="input-group-append" data-target="#reservationdateDOC" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-5 only-import">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="">IGM Number</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="igm_number" id="igm_number" placeholder="Enter IMG Number ...">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>IGM Date</label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group date" id="reservationdatez" data-target-input="nearest">
                                                    <input type="text" name="igm_date" id="igm_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                    <div class="input-group-append" data-target="#reservationdatez" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="">Pos</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="pos" id="pos" placeholder="Enter Pos ...">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="">Sub Pos</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="sub_pos" id="sub_pos" placeholder="Enter Sub Pos ...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-primary shipment-information">
                            <div class="card-header">
                                <h3 class="card-title">Shipment Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Shipment By</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control select2bs44" name="shipment_by" id="shipment_by">
                                                    <option selected>-- Select Shipment --</option>
                                                    <option value="SEA">SEA</option>
                                                    <option value="AIR">AIR</option>
                                                    <option value="LAND">LAND</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Client <font color="red">*</font></label>
                                            </div>
                                            <div class="col-md-7">
                                                <select class="form-control select2bs44" style="width: 100%;" name="customer_add" id="customer" onchange="client_detail(this.value)">
                                                    <option value="" selected>-- Select Customer --</option>
                                                    @foreach ($company as $c)
                                                    <option value="{{ $c->id }}">{{ $c->client_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-1">
                                                <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-7 mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="legalDoc" name="legal_doc" disabled>
                                                    <label for="legalDoc">
                                                        Legal Doc
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="client-detail">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Client Address</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="customer_addr" id="customer_addr">
                                                        <option value="" selected>-- Select Client Address --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Customer PIC</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="customer_pic" id="customer_pic">
                                                        <option value="" selected>-- Select Client PIC --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Shipper <font color="red">*</font></label>
                                            </div>
                                            <div class="col-md-7">
                                                <select class="form-control select2bs44" style="width: 100%;" name="shipper" id="shipper" onchange="shipper_detail(this.value)">
                                                    <option value="" selected>-- Select Shipper --</option>
                                                    @foreach ($company as $item)
                                                    <option value="{{ $item->id }}">{{ $item->client_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-1">
                                                <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="shipper-detail">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Shipper Address</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="shipper_addr" id="shipper_addr">
                                                        <option value="" selected>-- Select Shipper Address --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Shipper PIC</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="shipper_pic" id="shipper_pic">
                                                        <option value="" selected>-- Select Shipper PIC --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Consignee <font color="red">*</font></label>
                                            </div>
                                            <div class="col-md-7">
                                                <select class="form-control select2bs44" style="width: 100%;" name="consignee" id="consignee" onchange="consignee_detail(this.value)">
                                                    <option value="" selected>-- Select Consignee --</option>
                                                    @foreach ($company as $item)
                                                    <option value="{{ $item->id }}">{{ $item->client_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-1">
                                                <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="consignee-detail">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Consignee Address</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="consignee_addr" id="consignee_addr">
                                                        <option value="" selected>-- Select consignee Address --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Consignee PIC</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="consignee_pic" id="consignee_pic">
                                                        <option value="" selected>-- Select consignee PIC --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Notify Party <font color="red">*</font></label>
                                            </div>
                                            <div class="col-md-7">
                                                <select class="form-control select2bs44" style="width: 100%;" name="notify_party" id="notify_party" onchange="not_detail(this.value)">
                                                    <option value="" selected>-- Select Notify Party --</option>
                                                    @foreach ($company as $item)
                                                    <option value="{{ $item->id }}">{{ $item->client_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-1">
                                                <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="not-detail">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Notify Party Address</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="not_addr" id="not_addr">
                                                        <option value="" selected>-- Select Notify Party Address --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Notify Party PIC</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="not_pic" id="not_pic">
                                                        <option value="" selected>-- Select Notify Party PIC --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Agent</label>
                                            </div>
                                            <div class="col-md-7">
                                                <select class="form-control select2bs44" style="width: 100%;" name="agent" id="agent" onchange="agent_detail(this.value)">
                                                    <option value="" selected>-- Select Agent --</option>
                                                    @foreach ($company as $item)
                                                    <option value="{{ $item->id }}">{{ $item->client_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-1">
                                                <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="agent-detail">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Agent Address</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="agent_addr" id="agent_addr">
                                                        <option value="" selected>-- Select agent Address --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Agent PIC</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="agent_pic" id="agent_pic">
                                                        <option value="" selected>-- Select Agent PIC --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Shipping Line</label>
                                            </div>
                                            <div class="col-md-7">
                                                <select class="form-control select2bs44" style="width: 100%;" name="shipping_line" id="shipping_line" onchange="shipline_detail(this.value)">
                                                    <option value="" selected>-- Select Shipping Line --</option>
                                                    @foreach ($company as $item)
                                                    <option value="{{ $item->id }}">{{ $item->client_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-1">
                                                <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="shipline-detail">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Shipping Line Address</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="shipline_addr" id="shipline_addr">
                                                        <option value="" selected>-- Select Shipping Line Address --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Shipping Line PIC</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="shipline_pic" id="shipline_pic">
                                                        <option value="" selected>-- Select Shipping Line PIC --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Place of Origin</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="pfo" id="pfo" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Place of Destination</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="pod" id="pod" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Vendor</label>
                                            </div>
                                            <div class="col-md-7">
                                                <select class="form-control select2bs44" style="width: 100%;" name="vendor" id="vendor" onchange="vendor_detail(this.value)">
                                                    <option value="" selected>-- Select Vendor --</option>
                                                    @foreach ($company as $item)
                                                    <option value="{{ $item->id }}">{{ $item->client_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-1">
                                                <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="vendor-detail">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Vendor Address</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="vendor_addr" id="vendor_addr">
                                                        <option value="" selected>-- Select Vendor Address --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Vendor PIC</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control select2bs44" style="width: 100%;" name="vendor_pic" id="vendor_pic">
                                                        <option value="" selected>-- Select Vendor PIC --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Carrier</label>
                                            </div>
                                            <div class="col-md-7">
                                                <select class="form-control select2bs44" style="width: 100%;" name="carrier" id="carrier">
                                                    <option value="" selected>-- Select Carrier --</option>
                                                    @foreach ($carrier as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-1">
                                                <a href="{{ url('master/carrier') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Voyage/Flight Number</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="voyage" id="voyage" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Connecting Vessel</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="conn_vessel" id="conn_vessel" class="form-control" value="" placeholder="Connecting Vessel ...">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>ETD</label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group date" id="reservationdatex" data-target-input="nearest">
                                                    <input type="text" name="etd_date" id="etd_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                    <div class="input-group-append" data-target="#reservationdatex" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>ETA</label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group date" id="ETA" data-target-input="nearest">
                                                    <input type="text" name="eta_date" id="eta_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                    <div class="input-group-append" data-target="#ETA" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Port Of Loading</label>
                                            </div>
                                            <div class="col-md-7">
                                                <select class="form-control select-ajax-port" style="width: 100%;" name="pol" id="pol">
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-1">
                                                <a href="javascript:;" onclick="addPort('pol')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>POL Custom Desc</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="pol_desc" id="pol_desc" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Port Of Transit</label>
                                            </div>
                                            <div class="col-md-7">
                                                <select class="form-control select-ajax-port" style="width: 100%;" name="pot" id="pot">
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-1">
                                                <a href="javascript:;" onclick="addPort('pot')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Port Of Discharge</label>
                                            </div>
                                            <div class="col-md-7">
                                                <select class="form-control select-ajax-port" style="width: 100%;" name="podisc" id="podisc">
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-1">
                                                <a href="javascript:;" onclick="addPort('pod')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="row mb-3 pod-custom-desc">
                                            <div class="col-md-4">
                                                <label>POD Custom Desc</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="pod_desc" id="pod_desc" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 freight-charges">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">Freight & Charges</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Type Of Freight Charges</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control select2bs44" style="width: 100%;" name="freight_charges" id="freight_charges">
                                                                    <option value="" selected>-- Select Port Of Freight Charges --</option>
                                                                    @foreach ($freight as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->freight_charge }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Place Of Payment</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="pop" id="pop" class="form-control" placeholder="Enter Place Of Payment">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Valuta Of Payment</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control select2bs44" style="width: 100%;" name="valuta_payment" id="valuta_payment">
                                                                    <option value="" selected>-- Select Valuta --</option>
                                                                    @foreach ($currency as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->code }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Value Of Prepaid</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="vop" id="vop" class="form-control" placeholder="Enter Value of prepaid">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Value Of Collect</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="voc" id="voc" class="form-control" placeholder="Enter Value of Collect">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Freetime Of Detention (Days)</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="fod" id="fod" class="form-control" placeholder="Enter Free time of detention">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-secondary stuffing-information">
                                            <div class="card-header">
                                                <h3 class="card-title">Stuffing Information</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Stuffing Date</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="input-group date" id="reservationdatexx" data-target-input="nearest">
                                                                    <input type="text" name="stuf_date_export" id="stuf_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                                    <div class="input-group-append" data-target="#reservationdatexx" data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label for="">Place Of Stuffing</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <textarea name="posx_export" id="posx" cols="70" rows="3" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label for="">Delivery Of Goods</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <textarea name="dogs_export" id="dogs" cols="70" rows="3" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-secondary commodity-of-terms">
                                            <div class="card-header">
                                                <h3 class="card-title">Commodity Of Terms</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Incoterms</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control select2bs44" style="width: 100%;" name="incoterms" id="incoterms">
                                                                    @foreach ($inco as $row)
                                                                    <option value="{{ $row->id }}">{{ $row->incoterns_code }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label for="">Value Of Commodity</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" name="value_commodity" id="value_commodity" placeholder="Enter Value Of Commodity ...">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Valuta Of Commodity</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control select2bs44" style="width: 100%;" name="valuta_com" id="valuta_com">
                                                                    <option value="" selected>-- Select Valuta --</option>
                                                                    @foreach ($currency as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->code }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label for="">Exchange Rates</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" name="exchange_rate" id="exchange_rate" placeholder="Enter Exchange Rate ...">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Exchange Valuta</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control select2bs44" style="width: 100%;" name="exchange_valuta" id="exchange_valuta">
                                                                    <option value="" selected>-- Select Valuta --</option>
                                                                    @foreach ($currency as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->code }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 domestic">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Stuffing Date</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="input-group date" id="stuffingDate" data-target-input="nearest">
                                                            <input type="text" name="stuf_date_domestic" id="stuf_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                            <div class="input-group-append" data-target="#stuffingDate" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label for="">Place Of Stuffing</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <textarea name="posx_domestic" id="pos" cols="70" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label for="">Delivery Of Goods</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <textarea name="dogs_domestic" id="dogs" cols="70" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-primary master-bl-information">
                                    <div class="card-header">
                                        <h3 class="card-title">Master B/L Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Shipper</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <textarea name="shipper_mbl" id="shipper_mbl" cols="30" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Consignee</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <textarea name="cons_mbl" id="cons_mbl" cols="30" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Notify Party</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <textarea name="notify_mbl" id="notify_mbl" cols="30" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Description</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <textarea name="desc_mbl" id="desc_mbl" cols="30" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>MBL Number</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="mbl_number" id="mbl_number" placeholder="Enter MBL Number ...">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>MBL Date</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="input-group date" id="reservationdateMBL" data-target-input="nearest">
                                                            <input type="text" name="mbl_date" id="mbl_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                            <div class="input-group-append" data-target="#reservationdateMBL" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Valuta Of Payment</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select class="form-control select2bs44" style="width: 100%;" name="valuta_mbl" id="valuta_mbl">
                                                            <option value="" selected>-- Select Valuta --</option>
                                                            @foreach ($currency as $item)
                                                            <option value="{{ $item->id }}">{{ $item->code }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-primary house-awb-information">
                                    <div class="card-header">
                                        <h3 class="card-title">House B/L/ AWB Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Shipper</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <textarea name="shipper_hbl" id="shipper_hbl" cols="30" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Consignee</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <textarea name="cons_hbl" id="cons_hbl" cols="30" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Notify Party</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <textarea name="notify_hbl" id="notify_hbl" cols="30" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Description</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <textarea name="desc_hbl" id="desc_hbl" cols="30" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>BL/AWB Number</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="hbl_number" id="hbl_number" placeholder="Enter BL/AWB Number ...">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>BL/AWB Date</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="input-group date" id="reservationdateAWB" data-target-input="nearest">
                                                            <input type="text" name="hbl_date" id="hbl_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                            <div class="input-group-append" data-target="#reservationdateAWB" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Valuta Of Payment</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select class="form-control select2bs44" style="width: 100%;" name="valuta_hbl" id="valuta_hbl">
                                                            <option value="" selected>-- Select Valuta --</option>
                                                            @foreach ($currency as $item)
                                                            <option value="{{ $item->id }}">{{ $item->code }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>B/L Issued</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" style="width: 100%;" name="mbl_issued" id="mbl_issued">
                                            <option value="" selected>-- Select B/L Issued --</option>
                                            @foreach ($mbl_issued as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>B/L AWB Issued</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" style="width: 100%;" name="hbl_issued" id="hbl_issued">
                                            <option value="" selected>-- Select B/L Issued --</option>
                                            @foreach ($mbl_issued as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row remarks">
                            <div class="col-md-2">
                                <label>Remarks</label>
                            </div>
                            <div class="col-md-10">
                                <textarea name="remarks" id="remarks" class="form-control" rows="6"></textarea>
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
</section>
@push('after-scripts')
    <script>
    
    $(document).ready(function(){
        $(".customs-information").hide();
        $(".only-import").hide();
        $(".shipment-information").hide();
        $(".freight-charges").hide();
        $(".stuffing-information").hide();
        $(".port-of-loading").hide();
        $(".pol-custom-desc").hide();
        $(".port-of-transit").hide();
        $(".port-of-discharge").hide();
        $(".pod-custom-desc").hide();
        $(".domestic").hide();
        $(".commodity-of-terms").hide();
        $(".master-bl-information").hide();
        $(".house-awb-information").hide();
        $(".bl-issued").hide();
        $(".print-hbl-awb").hide();
        $(".remarks").hide();
        
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
    })

    function get_activity(val)
    {
        if(val == 'export'){
            $(".customs-information").show();
            $(".only-import").hide();
            $(".shipment-information").show();
            $(".freight-charges").show();
            $(".stuffing-information").show();
            $(".port-of-loading").show();
            $(".pol-custom-desc").show();
            $(".port-of-transit").show();
            $(".port-of-discharge").show();
            $(".pod-custom-desc").show();
            $(".domestic").hide();
            $(".commodity-of-terms").hide();
            $(".master-bl-information").show();
            $(".house-awb-information").show();
            $(".bl-issued").show();
            $(".print-hbl-awb").show();
            $(".remarks").show();
        }else if(val == 'import'){
            $(".customs-information").show();
            $(".only-import").show();
            $(".shipment-information").show();
            $(".freight-charges").show();
            $(".stuffing-information").hide();
            $(".port-of-loading").show();
            $(".pol-custom-desc").show();
            $(".port-of-transit").show();
            $(".port-of-discharge").show();
            $(".pod-custom-desc").show();
            $(".domestic").hide();
            $(".commodity-of-terms").show();
            $(".master-bl-information").show();
            $(".house-awb-information").show();
            $(".bl-issued").hide();
            $(".print-hbl-awb").show();
            $(".remarks").show();
        }else if(val == 'domestic'){
            $(".customs-information").hide();
            $(".only-import").hide();
            $(".shipment-information").show();
            $(".freight-charges").hide();
            $(".stuffing-information").hide();
            $(".port-of-loading").hide();
            $(".pol-custom-desc").hide();
            $(".port-of-transit").hide();
            $(".port-of-discharge").hide();
            $(".pod-custom-desc").hide();
            $(".domestic").show();
            $(".commodity-of-terms").hide();
            $(".master-bl-information").hide();
            $(".house-awb-information").hide();
            $(".bl-issued").hide();
            $(".print-hbl-awb").hide();
            $(".remarks").show();
        }
    }
    

    function client_detail(val){
        if(val!= ''){
            $.ajax({
                url: "{{ route('booking.detail') }}",
                type: "POST",
                data: "id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    let legal = final[2].legal_doc_flag;
                    $("#customer_addr").html(final[0]);
                    $("#customer_pic").html(final[1]);
                    if(legal == 1){
                        $('#legalDoc').prop('checked', true);
                    }else{
                        $('#legalDoc').prop('checked', false);
                    }
                }
            })
            $.ajax({
                url: "{{ route('booking.detail') }}",
                type: "POST",
                data: "id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    $("#customer_addr").html(final[0]);
                    $("#customer_pic").html(final[1]);
                }
            });
        }
    }

    function shipper_detail(val){
        if(val!= ''){
            $.ajax({
                url: "{{ route('booking.detail') }}",
                type: "POST",
                data: "id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    var check = final[2];
                    $('.shipper-detail').show();
                    $("#shipper_addr").html(final[0]);
                    $("#shipper_pic").html(final[1]);
                }
            });
        }
    }

    function consignee_detail(val)
    {
        if(val!= ''){
            $.ajax({
                url: "{{ route('booking.detail') }}",
                type: "POST",
                data: "id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);

                    $('.consignee-detail').show();
                    $("#consignee_addr").html(final[0]);
                    $("#consignee_pic").html(final[1]);
                }
            });
        }
    }

    function not_detail(val)
    {
        if(val!= ''){
            $.ajax({
                url: "{{ route('booking.detail') }}",
                type: "POST",
                data: "id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);

                    $('.not-detail').show();
                    $("#not_addr").html(final[0]);
                    $("#not_pic").html(final[1]);
                }
            });
        }
    }

    function agent_detail(val)
    {
        if(val!= ''){
            $.ajax({
                url: "{{ route('booking.detail') }}",
                type: "POST",
                data: "id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);

                    $('.agent-detail').show();
                    $("#agent_addr").html(final[0]);
                    $("#agent_pic").html(final[1]);
                }
            });
        }
    }

    function shipline_detail(val)
    {
        if(val!= ''){
            $.ajax({
                url: "{{ route('booking.detail') }}",
                type: "POST",
                data: "id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);

                    $('.shipline-detail').show();
                    $("#shipline_addr").html(final[0]);
                    $("#shipline_pic").html(final[1]);
                }
            });
        }
    }

    function vendor_detail(val)
    {
        if(val!= ''){
            $.ajax({
                url: "{{ route('booking.detail') }}",
                type: "POST",
                data: "id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);

                    $('.vendor-detail').show();
                    $("#vendor_addr").html(final[0]);
                    $("#vendor_pic").html(final[1]);
                }
            });
        }
    }

    $("#saveData").click(function(){
        const rbs = document.querySelectorAll('input[name="loaded"]');
        let selectedLoaded;
        for (const rb of rbs) {
            if (rb.checked) {
                selectedLoaded = rb.value;
                break;
            }
        }

        if (!selectedLoaded){
            Swal.fire({
                title: 'Error!',
                text: 'Harap pilih FCL/LCL',
                icon: 'error'
            })
        }else if($.trim($("#booking_no").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Booking Number',
                icon: 'error'
            })
        }else if($.trim($("#booking_date").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Booking Date',
                icon: 'error'
            })
        }else if($.trim($("#shipment_by").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Shipment By',
                icon: 'error'
            })
        }else{
            $(this).prop('disabled', true).text('Please Wait ...');
            $('#formku').submit();
        }
    });
    </script>
@endpush
@endsection