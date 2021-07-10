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
                    <div class="card-body">
                        <div class="container-fluid mt-3">
                            <div class="row">
                                <div class="col-md-12">
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
</section>
@push('after-scripts')
    <script>


    function shipper_detail(val){
        if(val!= ''){
            $.ajax({
                url: "{{ route('booking.detail') }}",
                type: "POST",
                data: "id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);

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
        if($.trim($("#booking_no").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Booking Number',
                icon: 'error'
            })
        }else if($.trim($("#booking_date").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Booking Date',
                icon: 'error'
            })
        }else if($.trim($("#customer").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Customer',
                icon: 'error'
            })
        }else if($.trim($("#shipper").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Shipper',
                icon: 'error'
            })
        }else if($.trim($("#consignee").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Consignee',
                icon: 'error'
            })
        }else if($.trim($("#notify_party").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Notify Party',
                icon: 'error'
            })
        }else if($.trim($("#agent").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Agent',
                icon: 'error'
            })
        }else if($.trim($("#shipping_line").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Shipping Line',
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