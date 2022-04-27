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
                        <div class="container-fluid mt-3">
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Booking Ini sudah di Cancel</strong>
                            </div>
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
                                                                <input type="text" name="booking_date" id="booking_date" value="{{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate" disabled/>
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
                                                            $quote_no = $quote->quote_no;
                                                        }
                                                    ?>
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
                                                                <input type="text" name="date" id="datex" class="form-control datetimepicker-input" value="{{ \Carbon\Carbon::parse($quote->quote_date)->format('d/m/Y') }}" data-target="#reservationdate" readonly/>
                                                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($booking->copy_booking != null)
                                                        <div class="col-md-12 mt-3">
                                                            Note : Copy From <strong>{{ $booking->copy_booking }}</strong>  
                                                        </div>
                                                        @endif
                                                        @else
                                                        <div class="col-md-12">
                                                            Note : Jenis Quote <strong>'Nomination'</strong>  
                                                        </div>
                                                        @endif
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
            </div>
        </div>
    </div>
</section>
@endsection