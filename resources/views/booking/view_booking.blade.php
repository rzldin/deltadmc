@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h1>
                View Booking
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
                            <strong>{{ ucwords($booking->activity) }}</strong>
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
                                                                    <input type="text" class="form-control" name="booking_no" id="booking_no" placeholder="Booking No ..." value="{{ $booking->booking_no }}" readonly>
                                                                    <input type="hidden" name="id_booking" value="{{ $booking->id }}">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Booking Date</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                                        <input type="text" name="booking_date" id="booking_date" value="{{ \Carbon\Carbon::parse($booking->booking_date)->format('m/d/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate" disabled/>
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
                                                                    <input type="text" class="form-control" name="version_no" id="version_no" placeholder="Version No ..." value="{{ $booking->version_no }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-5">
                                                            <?php 
                                                                if($booking->nomination_flag == 1){
                                                                    $quote_no = 'Nomination';
                                                                }else{
                                                                    $quote_no = $booking->quote_no;
                                                                }
                                                            ?>
                                                            @if ($booking->copy_booking == null)
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Quote Number</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" name="quote_no" id="quote_no" placeholder="Quote No ..." value="{{ $quote_no }}" readonly>
                                                                    <input type="hidden" name="id_quote" id="id_quote" value="{{ $booking->t_quote_id }}">
                                                                    <input type="hidden" name="activity" id="activityx" value="{{ $booking->activity }}">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                @if ($booking->nomination_flag == 0)
                                                                <div class="col-md-4">
                                                                    <label>Quote Date</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                                        <input type="text" name="date" id="datex" class="form-control datetimepicker-input" value="{{ \Carbon\Carbon::parse($booking->quote_date)->format('m/d/Y') }}" data-target="#reservationdate" readonly/>
                                                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="col-md-12">
                                                                    Note : Jenis Quote <strong>'Nomination'</strong>  
                                                                </div>
                                                                @endif
                                                            </div>
                                                            @else
                                                            <div class="row mb-3">
                                                                <div class="col-md-12 mt-3">
                                                                    Note : Copy From <strong>{{ $booking->copy_booking }}</strong>  
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($booking->activity == 'export' || $booking->activity == 'import')
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
                                                                    <input type="text" class="form-control" value="{{ $booking->name_doc }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Document Number</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" name="doc_no" id="doc_no" value="{{ $booking->custom_doc_no }}" readonly>
                                                                </div>
                                                            </div>
                                                            @if ($booking->activity == 'import')
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Document Date</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="input-group date" id="reservationdateDOC" data-target-input="nearest">
                                                                        <input type="text" name="doc_date" id="doc_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ \Carbon\Carbon::parse($booking->custom_doc_date)->format('m/d/Y') }}" disabled/>
                                                                        <div class="input-group-append" data-target="#reservationdateDOC" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                        @if ($booking->activity == 'export')
                                                        <div class="col-md-5">
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Document Date</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="input-group date" id="reservationdateDOC" data-target-input="nearest">
                                                                        <input type="text" name="doc_date" id="doc_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ \Carbon\Carbon::parse($booking->custom_doc_date)->format('m/d/Y') }}" disabled/>
                                                                        <div class="input-group-append" data-target="#reservationdateDOC" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($booking->activity == 'import')
                                                        <div class="col-md-5">
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label for="">IGM Number</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" name="igm_number" id="igm_number" placeholder="Enter IMG Number ..." value="{{ $booking->igm_no }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>IGM Date</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="igm_date" id="igm_date" value="{{ \Carbon\Carbon::parse($booking->igm_date)->format('m/d/Y') }}" class="form-control" disabled/>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label for="">Pos</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" name="pos" id="pos" placeholder="Enter Pos ..." value="{{ $booking->custom_pos }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label for="">Sub Pos</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" name="sub_pos" id="sub_pos" value="{{ $booking->custom_subpos }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
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
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" value="{{ $booking->company_c }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="client-detail">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Client Address</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->address_c }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Customer PIC</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->pic_c }}" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Shipper</label>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <input type="text" class="form-control" value="{{ $booking->company_f }}" readonly>
                                                                </div>
                                                                <div class="col-md-3 mt-2">
                                                                    <div class="icheck-primary d-inline">
                                                                        <input type="checkbox" id="checkboxPrimary1" name="legal_doc" @if ($booking->legal_f == 1)
                                                                            checked
                                                                        @endif>
                                                                        <label for="checkboxPrimary1">
                                                                            Legal Doc
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="shipper-detail">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Shipper Address</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->address_f }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Shipper PIC</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->pic_f }}" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Consignee</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" value="{{ $booking->company_i }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="consignee-detail">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Consignee Address</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->address_i }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Consignee PIC</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->pic_i }}" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Notify Party</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" value="{{ $booking->company_l }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="not-detail">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Notify Party Address</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->address_l }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Notify Party PIC</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->pic_l }}" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Agent</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" value="{{ $booking->company_o }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="agent-detail">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Agent Address</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->address_o }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Agent PIC</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->pic_o }}" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Shipping Line</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" value="{{ $booking->company_r }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="shipline-detail">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Shipping Line Address</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->address_r }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Shipping Line PIC</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->pic_r }}" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Place of Origin</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="pfo" id="pfo" class="form-control" value="{{ $booking->place_origin }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Place of Destination</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="pod" id="pod" class="form-control" value="{{ $booking->place_destination }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Vendor</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" value="{{ $booking->company_u }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="vendor-detail">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Vendor Address</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->address_u }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Vendor PIC</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" value="{{ $booking->pic_u }}" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Carrier</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" value="{{ $booking->name_carrier }}" readonly>
                                                                </div>
                                                            </div>
                                                            @if ($booking->activity == 'export' || $booking->activity == 'import')
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Voyage/Flight Number</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="voyage" id="voyage" class="form-control" value="{{ $booking->flight_number }}" readonly>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>ETD</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="input-group date" id="reservationdatex" data-target-input="nearest">
                                                                        <input type="text" name="etd" id="etd" value="{{ \Carbon\Carbon::parse($booking->etd_date)->format('m/d/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate" disabled/>
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
                                                                    <div class="input-group date" id="reservationdatez" data-target-input="nearest">
                                                                        <input type="text" name="eta" id="eta" value="{{ \Carbon\Carbon::parse($booking->eta_date)->format('m/d/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate" disabled/>
                                                                        <div class="input-group-append" data-target="#reservationdatez" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if ($booking->activity == 'export' || $booking->activity == 'import')
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Port Of Loading</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" value="{{ $booking->port1 }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>POL Custom Desc</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="pol_desc" id="pol_desc" value="{{ $booking->pol_custom_desc }}" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Port Of Transit</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" value="{{ $booking->port2 }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Port Of Discharge</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                   <input type="text" class="form-control" value="{{ $booking->port3 }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>POD Custom Desc</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="pod_desc" id="pod_desc" value="{{ $booking->pod_custom_desc }}" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            @if ($booking->activity == 'export' || $booking->activity == 'import')
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
                                                                                    <input type="text" class="form-control" value="{{ $booking->charge_name }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-4">
                                                                                    <label>Place Of Payment</label>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <input type="text" name="pop" id="pop" class="form-control" placeholder="Enter Place Of Payment" value="{{ $booking->place_payment }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-4">
                                                                                    <label>Valuta Of Payment</label>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <input type="text" class="form-control" value="{{ $booking->valuta_payment }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-4">
                                                                                    <label>Value Of Prepaid</label>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <input type="text" name="vop" id="vop" class="form-control" placeholder="Enter Value of prepaid" value="{{ $booking->value_prepaid }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-4">
                                                                                    <label>Value Of Collect</label>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <input type="text" name="voc" id="voc" class="form-control" placeholder="Enter Value of Collect" value="{{ $booking->value_collect }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-4">
                                                                                    <label>Freetime Of Detention (Days)</label>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <input type="text" name="fod" id="fod" class="form-control" placeholder="Enter Free time of detention" value="{{ $booking->freetime_detention }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            @if ($booking->activity == 'domestic')
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label>Stuffing Date</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="input-group date" id="reservationdatexx" data-target-input="nearest">
                                                                                <input type="text" name="stuf_date" id="stuf_date" value="{{ \Carbon\Carbon::parse($booking->stuffing_date)->format('m/d/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate" disabled/>
                                                                                <div class="input-group-append" data-target="#reservationdatexx" data-toggle="datetimepicker" aria-disabled="true">
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
                                                                            <textarea name="pos" id="pos" cols="70" rows="3" class="form-control" disabled>{{ $booking->stuffing_place }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label for="">Delivery Of Goods</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <textarea name="dogs" id="dogs" cols="70" rows="3" class="form-control" disabled>{{ $booking->delivery_of_goods }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            @if ($booking->activity == 'export')
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
                                                                                    <div class="input-group date" id="reservationdatexx" data-target-input="nearest">
                                                                                        <input type="text" name="stuf_date" value="{{ \Carbon\Carbon::parse($booking->stuffing_date)->format('m/d/Y') }}" id="stuf_date" class="form-control datetimepicker-input" data-target="#reservationdate" disabled/>
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
                                                                                    <textarea name="posx" id="posx" cols="70" rows="3" class="form-control" disabled>{{ $booking->stuffing_place }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-4">
                                                                                    <label for="">Delivery Of Goods</label>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <textarea name="dogs" id="dogs" cols="70" rows="3" class="form-control" disabled>{{ $booking->delivery_of_goods }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            @if ($booking->activity == 'import')
                                                            <div class="card card-secondary">
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
                                                                                    <input type="text" class="form-control" value="{{ $booking->incoterns_code }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-4">
                                                                                    <label for="">Value Of Commodity</label>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <input type="text" class="form-control" name="value_commodity" id="value_commodity" placeholder="Enter Value Of Commodity ..." value="{{ $booking->value_comm }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-4">
                                                                                    <label>Valuta Of Commodity</label>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <input type="text" value="{{ $booking->valuta_comm }}" class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-4">
                                                                                    <label for="">Exchange Rates</label>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <input type="text" class="form-control" value="{{ $booking->rates_comm }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-4">
                                                                                    <label>Exchange Valuta</label>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <input type="text" value="{{ $booking->exchange_valuta_comm }}" class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif         
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($booking->activity == 'import' || $booking->activity == 'export')
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
                                                                            <textarea name="shipper_mbl" id="shipper_mbl" cols="30" rows="3" class="form-control" disabled>{{ $booking->mbl_shipper }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label>Consignee</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <textarea name="cons_mbl" id="cons_mbl" cols="30" rows="3" class="form-control" disabled>{{ $booking->mbl_consignee }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label>Notify Party</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <textarea name="notify_mbl" id="notify_mbl" cols="30" rows="3" class="form-control" disabled>{{ $booking->mbl_not_party }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label>MBL Number</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text" class="form-control"  value="{{ $booking->mbl_no }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label>MBL Date</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="input-group date" id="reservationdateMBL" data-target-input="nearest">
                                                                                <input type="text" name="mbl_date" value="{{ \Carbon\Carbon::parse($booking->mbl_date)->format('m/d/Y') }}" id="mbl_date" class="form-control datetimepicker-input" data-target="#reservationdate" disabled/>
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
                                                                            <input type="text" value="{{ $booking->valuta_mbl }}" class="form-control" readonly>
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
                                                                            <textarea name="shipper_hbl" id="shipper_hbl" cols="30" rows="3" class="form-control" readonly>{{ $booking->hbl_shipper }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label>Consignee</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <textarea name="cons_hbl" id="cons_hbl" cols="30" rows="3" class="form-control" readonly>{{ $booking->hbl_consignee }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label>Notify Party</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <textarea name="notify_hbl" id="notify_hbl" cols="30" rows="3" class="form-control" readonly>{{ $booking->hbl_not_party }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label>BL/AWB Number</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text" class="form-control" name="hbl_number" id="awb_number" placeholder="Enter BL/AWB Number ..." value="{{ $booking->hbl_no }}" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label>BL/AWB Date</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="input-group date" id="reservationdateAWB" data-target-input="nearest">
                                                                                <input type="text" name="hbl_date" id="hbl_date" value="{{ \Carbon\Carbon::parse($booking->hbl_date)->format('m/d/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate" disabled/>
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
                                                                            <input type="text" value="{{ $booking->valuta_hbl }}" class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if ($booking->activity == 'export')
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label>B/L Issued</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" value="{{ $booking->issued }}" readonly>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <a class="btn btn-md btn-danger"><i class="fa fa-trash"></i></a>
                                                    <a class="btn btn-md btn-dark" target="_blank"><i class="fa fa-print"></i> Print HBL</a>
                                                    <a class="btn btn-md btn-dark" target="_blank"><i class="fa fa-print"></i> Print HAWB</a>
                                                </div>
                                            </div>
                                            <div class="card card-primary mt-3">
                                                <div class="card-header">
                                                    <h3 class="card-title">Additional Information</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        @if ($booking->activity == 'export')
                                                        <div class="col-md-6">
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Fumigation</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select class="form-control select2bs44" style="width: 100%;" name="fumigation" id="fumigation" disabled>
                                                                        <option value="1" @if ($booking->fumigation_flag == 1)
                                                                            selected
                                                                        @endif>YES</option>
                                                                        <option value="0" @if ($booking->fumigation_flag == 0)
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
                                                                    <select class="form-control select2bs44" style="width: 100%;" name="insurance" id="insurance" disabled>
                                                                        <option selected>-- Select --</option>
                                                                        <option value="1"  @if ($booking->insurance_flag == 1)
                                                                            selected
                                                                        @endif>YES</option>
                                                                        <option value="0" @if ($booking->insurance_flag == 0)
                                                                            selected
                                                                        @endif>NO</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Incoterms</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" value="{{ $booking->incoterns_code }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                        @endif
                                                        <div class="col-md-5">
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Total Commodity</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" name="total_commo" id="total_commo" placeholder="Total Commodity ..." value="{{ count($commodity) }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Total Package</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" name="total_package" id="total_package" placeholder="Total Package ..." value="{{ count($packages) }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label>Total Container</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" name="total_container" id="total_container" placeholder="Total Container ..." value="{{ count($container) }}" readonly>
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
                                                    <textarea name="remarks" id="remarks" class="form-control" rows="6" disabled>{{ $booking->remarks }}</textarea>
                                                </div>
                                            </div> 
                                            <div class="row float-right mt-2">
                                                <a href="" class="btn btn-dark btn-sm m-2"><i class="fa fa-print"></i> Print SI Trucking</a>
                                                <a href="" class="btn btn-danger btn-sm m-2"><i class="fa fa-print"></i> Print SI</a>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Commodity ({{ count($commodity) }})</h3>
                                                </div>
                                                <div class="card-body table-responsive p-0">
                                                    <table class="table table_lowm table-bordered" id="Table1">
                                                        <thead>
                                                            <tr>
                                                                <th width="1%">#</th>
                                                                <th width="15%">Hs Code</th>
                                                                <th>Description</th>
                                                                <th>Origin</th>
                                                                <th width="15%">Qty Commodity</th>
                                                                <th width="15%">Qty Packages</th>
                                                                <th width="15%">Weight</th>
                                                                <th >Netto</th>
                                                                <th width="15%">Volume</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($commodity as $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->hs_code }}</td>
                                                                <td>{{ $item->desc }}</td>
                                                                <td>{{ $item->origin }}</td>
                                                                <td>{{ $item->qty_comm }}</td>
                                                                <td>{{ $item->qty_packages }}</td>
                                                                <td>{{ $item->weight }}</td>
                                                                <td>{{ $item->netto }}</td>
                                                                <td>{{ $item->volume }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Packages ({{ count($packages) }})</h3>
                                                </div>
                                                <div class="card-body table-responsive p-0">
                                                    <table class="table table_lowm table-bordered" id="Table1">
                                                        <thead>
                                                            <tr>
                                                                <th width="1%">#</th>
                                                                <th width="35%">Merk</th>
                                                                <th width="15%">Qty</th>
                                                                <th width="15%">Unit</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($packages as $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->desc }}</td>
                                                                <td>{{ $item->qty }}</td>
                                                                <td>{{ $item->code_b }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Container ({{ count($container) }})</h3>
                                                </div>
                                                <div class="card-body table-responsive p-0">
                                                   <table class="table table_lowm table-bordered" id="Table1">
                                                       <thead>
                                                            <tr>
                                                                <th width="1%">#</th>
                                                                <th width="20%">Container Number</th>
                                                                <th width="15%">Size</th>
                                                                <th width="15%">Loaded Type</th>
                                                                <th width="15%">Container Type</th>
                                                                <th>Seal No</th>
                                                                @if ($booking->activity == 'export')
                                                                <th>VGM</th>
                                                                <th>Uom</th>
                                                                <th>Resp.Party</th>
                                                                <th>Auth.Person</th>
                                                                <th>M.o.w</th>
                                                                <th width="15%">Weighing Party</th>
                                                                @endif
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            @foreach ($container as $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->container_no }}</td>
                                                                <td>{{ $item->size }}</td>
                                                                <td>{{ $item->loaded_type }}</td>
                                                                <td>{{ $item->container_type }}</td>
                                                                <td>{{ $item->seal_no }}</td>
                                                                @if ($booking->activity == 'export')
                                                                <td>{{ $item->vgm }}</td>
                                                                <td>{{ $item->uom_code }}</td>
                                                                <td>{{ $item->responsible_party }}</td>
                                                                <td>{{ $item->authorized_person }}</td>
                                                                <td>{{ $item->method_of_weighing }}</td>
                                                                <td>{{ $item->weighing_party }}</td>
                                                                @endif
                                                            </tr>
                                                            @endforeach
                                                       </tbody>
                                                   </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Document ({{ count($doc) }})</h3>
                                                </div>
                                                <div class="card-body table-responsive p-0">
                                                   <table class="table table_lowm table-bordered" id="Table1">
                                                        <thead>
                                                            <tr>
                                                                <th width="1%">#</th>
                                                                <th width="35%">Document Type</th>
                                                                <th width="15%">Document Number</th>
                                                                <th width="15%">Document Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($doc as $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->doc_no }}</td>
                                                                <td>{{ $item->doc_date }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                   </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                                <section class="content">
                                    <div class="container-fluid mt-3">
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h4>Road Consignment</h4>
                                                </div>
                                                <div class="card-body">
                                                    <table id="myTable" class="table table-bordered table-striped" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <td width="15%">No. SJ</td>
                                                                <td width="15%">Vehicle Type</th>
                                                                <td width="10%">Vehicle No</th>
                                                                <td width="20%">Driver</td>
                                                                <td width="10%">Driver Phone</td>
                                                                <td>Pickup Address</td>
                                                                <td>Delivery Address</td>
                                                                <td>Notes</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($roadCons as $item)
                                                            <tr>
                                                                <td>{{ $item->no_sj }}</td>
                                                                <td>{{ $item->type }}</td>
                                                                <td>{{ $item->vehicle_no }}</td>
                                                                <td>{{ $item->driver }}</td>
                                                                <td>{{ $item->driver_phone }}</td>
                                                                <td>{{ $item->pickup_addr }}</td>
                                                                <td>{{ $item->delivery_addr }}</td>
                                                                <td>{{ $item->notes }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>                                
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-messages" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
                                <section class="content">
                                    <div class="container-fluid mt-3">
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h4>Schedule</h4>
                                                </div>
                                                <div class="card-body">
                                                    <table id="myTablex" class="table table-bordered table-striped" width="100%">
                                                        <thead>
                                                          <tr>
                                                            <td>No.</th>
                                                            <td>Schedule</td>
                                                            <td>Description</th>
                                                            <td>Time</td>
                                                            <td>Notes</td>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($schedule as $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->schedule_type }}</td>
                                                                <td>{{ $item->desc }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($item->date)->format('m/d/Y') }}</td>
                                                                <td>{{ $item->notes }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section> 
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-settings" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
                                <section class="content">
                                    <div class="container-fluid mt-3">
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h5>Cost</h5>
                                                </div>
                                                <div class="card-body">
                                                    <table id="myTablex" class="table table-bordered table-striped" width="100%">
                                                        <thead>
                                                          <tr>
                                                            <td>No.</th>
                                                            <td>Service/Fee</td>
                                                            <td>Description</th>
                                                            <td>Reimbursment</td>
                                                            <td>Unit</td>
                                                            <td>Currency</td>
                                                            <td>rate/unit</td>
                                                            <td>Total</td>
                                                            <td>Cost Val</td>
                                                            <td>Vat</td>
                                                            <td>Amount</td>
                                                            <td>Paid To</td>
                                                            <td>Note</td>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $total = 0;
                                                                $amount = 0;
                                                            @endphp
                                                            @foreach  ($quoteDtl as $item)
                                                            @php
                                                                $total += ($item->rate * $item->qty);
                                                                $amount += ($item->cost_val * $total) + $item->vat;
                                                            @endphp     
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->name_charge }}</td>
                                                                <td>{{ $item->desc }}</td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" style="width:50px;" @if ($item->reimburse_flag == 1)
                                                                        checked
                                                                    @endif>
                                                                </td>
                                                                <td>{{ $item->qty }}</td>
                                                                <td>{{ $item->code_currency }}</td>
                                                                <td>{{ number_format($item->rate,2,',','.') }}</td>
                                                                <td>{{ number_format($total,2,',','.') }}</td>
                                                                <td>{{ number_format($item->cost_val,2,',','.') }}</td>
                                                                <td>{{ number_format($item->vat,2,',','.') }}</td>
                                                                <td>{{ number_format($amount,2,',','.') }}</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h5>Sell</h5>
                                                </div>
                                                <div class="card-body">
                                                    <table id="myTablex" class="table table-bordered table-striped" width="100%">
                                                        <thead>
                                                          <tr>
                                                            <td>No.</th>
                                                            <td>Service/Fee</td>
                                                            <td>Description</th>
                                                            <td>Reimbursment</td>
                                                            <td>Unit</td>
                                                            <td>Currency</td>
                                                            <td>rate/unit</td>
                                                            <td>Total</td>
                                                            <td>Sell Val</td>
                                                            <td>Vat</td>
                                                            <td>Amount</td>
                                                            <td>Bill To</td>
                                                            <td>Note</td>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $total = 0;
                                                                $amount = 0;
                                                            @endphp
                                                            @foreach  ($quoteDtl as $item)
                                                            @php
                                                                $total += ($item->rate * $item->qty);
                                                                $amount += ($item->sell_val * $total) + $item->vat;
                                                            @endphp     
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->name_charge }}</td>
                                                                <td>{{ $item->desc }}</td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" style="width:50px;" @if ($item->reimburse_flag == 1)
                                                                        checked
                                                                    @endif>
                                                                </td>
                                                                <td>{{ $item->qty }}</td>
                                                                <td>{{ $item->code_currency }}</td>
                                                                <td>{{ number_format($item->rate,2,',','.') }}</td>
                                                                <td>{{ number_format($total,2,',','.') }}</td>
                                                                <td>{{ number_format($item->sell_val,2,',','.') }}</td>
                                                                <td>{{ number_format($item->vat,2,',','.') }}</td>
                                                                <td>{{ number_format($amount,2,',','.') }}</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h5>Profit Analysis</h5>
                                                </div>
                                                <div class="card-body">
                                                    <table id="myTablex" class="table table-bordered table-striped" width="100%">
                                                        <thead>
                                                          <tr>
                                                            <td>Total Cost</th>
                                                            <td>Total Sell</td>
                                                            <td>Total Profit</th>
                                                            <td>Profit PCT</td>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($profit as $item)
                                                            <tr>
                                                                <td>{{ $item->total_cost }}</td>
                                                                <td>{{ $item->total_sell }}</td>
                                                                <td>{{ $item->total_profit }}</td>
                                                                <td>{{ $item->profit_pct }}%</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3 mb-3">
                @if ($booking->status == 0 && $booking->final_flag == 1)
                <a href="javascript:;" class="btn btn-success float-right" onclick="approve('{{ $booking->id }}')"><i class="fa fa-check"></i> Approve</a>
                @endif
                <a href="{{ route('booking.list') }}" class="btn btn-secondary float-left"><i class="fa fa-angle-left"></i> Back</a>
                <a onclick="copyBooking('{{ $booking->booking_no }}')"  class="btn btn-info float-left ml-2"><i class="fa fa-copy"></i> Copy Booking</a>
            </div>
        </div>
    </div>
</section>
@push('after-scripts')
    <script>
        function approve(id)
        {
            Swal.fire({
                title: 'Konfirmasi Approved!',
                text: 'Apakah anda yakin ingin meng Approve data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
                confirmButtonText: "Approved",
		        cancelButtonText: "cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('booking.Approve') }}",
                        data: {id:id},
                        dataType: 'json',
                        cache: false,
                        success: function (response) {
                            location.replace("{{ route('booking.list') }}");
                        },
                    });
                }
            });
        }

        function copyBooking(val)
        {
            var r=confirm(`Anda yakin ingin mengcopy dari data no booking : ${val}?`);
            if(r == true){
                window.location.href = "{{ url('booking/copy_booking/'.$booking->id) }}";
            }
        }
    </script>
@endpush
@endsection