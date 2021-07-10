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
                        <h3 class="card-title float-right">
                            <strong>{{ $quote->shipment_by }}</strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Header</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Road Consigment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-messages-tab" data-toggle="pill" href="#custom-content-below-messages" role="tab" aria-controls="custom-content-below-messages" aria-selected="false">Schedule</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#custom-content-below-settings" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Charges and Fee</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="custom-content-below-tabContent">
                            <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                <div class="container-fluid mt-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="{{ route('quotation.quote_doAdd') }}" class="eventInsForm" method="post" target="_self" name="formku" id="formku" action=""> 
                                                    {{ csrf_field() }}
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Booking Information</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Booking Number</label>
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
                                                                        <input type="text" class="form-control" name="version_no" id="version_no" placeholder="Version No ...">
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
                                                                        <input type="text" class="form-control" name="quote_no" id="quote_no" placeholder="Quote No ..." value="{{ $quote->quote_no }}">
                                                                        <input type="hidden" name="id_quote" id="id_quote" value="{{ $quote->id }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Quote Date</label>
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
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card card-primary">
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
                                                                            <option value="" selected>-- Select Document --</option>
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
                                                            </div>
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-5">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Document Date</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                                            <input type="text" name="doc_date" id="doc_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Shipment Information</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Client</label>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="customer" id="customer" onchange="get_pic(this.value)">
                                                                            <option value="" selected>-- Select Customer --</option>
                                                                            @foreach ($company as $c)
                                                                            <option value="{{ $c->id }}" @if ($quote->customer_id == $c->id)
                                                                                selected
                                                                            @endif>{{ $c->client_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Shipper</label>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="customer" id="customer">
                                                                            <option value="" selected>-- Select Shipper --</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Consignee</label>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="customer" id="customer">
                                                                            <option value="" selected>-- Select Consignee --</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Notify Party</label>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="customer" id="customer">
                                                                            <option value="" selected>-- Select Notify Party --</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Agent</label>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="customer" id="customer">
                                                                            <option value="" selected>-- Select Agent --</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Shipping Line</label>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="customer" id="customer">
                                                                            <option value="" selected>-- Select Shipping Line --</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="vendor" id="vendor">
                                                                            <option value="" selected>-- Select Vendor --</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Carrier</label>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="carrier" id="carrier">
                                                                            <option value="" selected>-- Select Shipping Line --</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                                                                        <label>ETD</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                                            <input type="text" name="etd" id="etd" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
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
                                                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                                            <input type="text" name="eta" id="eta" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
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
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="pol" id="pol">
                                                                            <option value="" selected>-- Select Port Of Loading --</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="pot" id="pot">
                                                                            <option value="" selected>-- Select Port Of Transit --</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Port Of Discharge</label>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="podisc" id="podisc">
                                                                            <option value="" selected>-- Select Port Of Discharge --</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>POD Custom Desc</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="pod_desc" id="pod_desc" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
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
                                                                                        <select class="form-control select2bs44" style="width: 100%;" name="valuta" id="valuta">
                                                                                            <option value="" selected>-- Select Valuta --</option>
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
                                                                <div class="card card-secondary">
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
                                                                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                                                            <input type="text" name="stuf_date" id="stuf_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
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
                                                                                        <textarea name="pos" id="pos" cols="70" rows="3" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-md-4">
                                                                                        <label for="">Delivery Of Goods</label>
                                                                                    </div>
                                                                                    <div class="col-md-8">
                                                                                        <textarea name="dogs" id="dogs" cols="70" rows="3" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
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
                                                        <div class="card card-primary">
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
                                                                                <textarea name="shipper_dtl" id="shipper_dtl" cols="30" rows="3" class="form-control"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <div class="col-md-4">
                                                                                <label>Consignee</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <textarea name="cons_dtl" id="cons_dtl" cols="30" rows="3" class="form-control"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <div class="col-md-4">
                                                                                <label>Notify Party</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <textarea name="notify_dtl" id="notify_dtl" cols="30" rows="3" class="form-control"></textarea>
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
                                                                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                                                    <input type="text" name="mbl_date" id="mbl_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card card-primary">
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
                                                                                <textarea name="shipper_dtl_awb" id="shipper_dtl" cols="30" rows="3" class="form-control"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <div class="col-md-4">
                                                                                <label>Consignee</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <textarea name="cons_dtl_awb" id="cons_dtl" cols="30" rows="3" class="form-control"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <div class="col-md-4">
                                                                                <label>Notify Party</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <textarea name="notify_dtl_awb" id="notify_dtl" cols="30" rows="3" class="form-control"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <div class="col-md-4">
                                                                                <label>BL/AWB Number</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text" class="form-control" name="awb_number" id="awb_number" placeholder="Enter BL/AWB Number ...">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <div class="col-md-4">
                                                                                <label>BL/AWB Date</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                                                    <input type="text" name="awb_date" id="awb_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
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
                                                                                <select class="form-control select2bs44" style="width: 100%;" name="valuta_awb" id="valuta_awb">
                                                                                    <option value="" selected>-- Select Valuta --</option>
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
                                                                <select class="form-control select2bs44" style="width: 100%;" name="bl_issue" id="bl_issue">
                                                                    <option value="" selected>-- Select B/L Issued --</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a class="btn btn-md btn-danger"><i class="fa fa-trash"></i></a>
                                                        <a class="btn btn-md btn-dark" target="_blank"><i class="fa fa-print"></i> Print HBL</a>
                                                        <a class="btn btn-md btn-dark" target="_blank"><i class="fa fa-print"></i> Print HAWB</a>
                                                    </div>
                                                </div>
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Additional Information</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Fumigation</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="fumigation" id="fumigation">
                                                                            <option value="YES" @if ($quote->fumigation_flag == 1)
                                                                                selected
                                                                            @endif>YES</option>
                                                                            <option value="NO" @if ($quote->fumigation_flag == 0)
                                                                                selected
                                                                            @endif>NO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Insurance</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="insurance" id="insurance">
                                                                            <option selected>-- Select --</option>
                                                                            <option value="YES">YES</option>
                                                                            <option value="NO">NO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Incoterms</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <select class="form-control select2bs44" style="width: 100%;" name="incoterms" id="incoterms">
                                                                            @foreach ($inco as $row)
                                                                            <option value="{{ $row->id }}" @if ($row->id == $quote->terms)
                                                                                selected
                                                                            @endif>{{ $row->incoterns_code }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-5">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Total Commodity</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" name="total_commo" id="total_commo" placeholder="Total Commodity ...">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Total Package</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" name="total_package" id="total_package" placeholder="Total Package ...">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Total Container</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" name="total_container" id="total_container" placeholder="Total Container ...">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label>Remarks</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <textarea name="remarks" id="remarks" cols="30" class="form-control" rows="10"></textarea>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                                <section class="content">
                                    <div class="container-fluid">
                                      <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Surat Jalan</h5>
                                                </div>
                                                <div class="card-body">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>                                
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-messages" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
                                Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-settings" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
                                Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection