@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus"></i>
                    Create Receive Invoice
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
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
                        <form method="post" action="{{ route('invoice.save_cost') }}"
                            id="formInvoice">
                            @csrf
                            <input type="hidden" name="id" id="id" value="" />
                            <input type="hidden" name="t_booking_id" id="t_booking_id" value="{{ $booking->id }}" />
                            <input type="hidden" name="activity" value="{{ $booking->activity }}">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Invoice Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>Create or Merge exisiting Invoice</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control select2bs44" name="create_type" id="create_type">
                                                <option value="0">New Invoice</option>
                                                <option disabled="disabled">----</option>
                                                @foreach ($list_invoice as $inv)
                                                    <option value="{{ $inv->id }}">{{ $inv->invoice_no }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row show_new">
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Paid To</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" id="paid_to_name" class="form-control" value="{{ $companies->client_name }}" disabled>
                                                    <input type="hidden" id="client_id" name="client_id" value="{{ $paid_to_id }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Address <font color="#f00">*</font></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control select2bs44" name="client_addr_id" id="client_addr_id">
                                                        <option value="">Select Address</option>
                                                        @foreach($addresses as $address)
                                                            <option value="{{ $address->id }}">
                                                                {{ $address->address }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>PIC <font color="#f00">*</font></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control select2bs44" name="client_pic_id" id="client_pic_id">
                                                        <option value="">Select PIC</option>
                                                        @foreach($pics as $pic)
                                                            <option value="{{ $pic->id }}">
                                                                {{ $pic->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Invoice No <font color="#f00">*</font></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="invoice_no"
                                                    id="invoice_no">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Invoice Type</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="radio" name="invoice_type"
                                                        id="invoice_type_reg" value="REG" onchange="loadSellCost({{ $booking->id }})" checked> Reguler<br>
                                                    <input type="radio" name="invoice_type"
                                                        id="invoice_type_reimbursment" value="REM" onchange="loadSellCost({{ $booking->id }})"> Reimbursment<br>
                                                    <input type="radio" name="invoice_type"
                                                        id="invoice_type_debit_note" value="DN" onchange="loadSellCost({{ $booking->id }})"> Debit Note<br>
                                                    <input type="radio" name="invoice_type"
                                                        id="invoice_type_credit_note" value="CN" onchange="loadSellCost({{ $booking->id }})"> Credit Note<br>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Tax</label>
                                                </div>
                                                <div class="col-md-8">
                                                    @foreach ($taxes as $tax)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="{{ $tax->code }}" value="{{ $tax->value }}" onchange="checkedTax(`{{ $tax->code }}`, `{{ $tax->name }}`, {{ $tax->value }})">
                                                            <label class="form-check-label" for="{{ $tax->code }}">{{ "$tax->name ($tax->value %)" }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>MB/L</label>
                                                </div>
                                                <div class="col-md-8">
                                                    : {{ $booking->mbl_shipper }}
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Container</label>
                                                </div>
                                                <div class="col-md-8">
                                                    :
                                                    <ul class="list-item-inv">
                                                        @foreach($containers as $container)
                                                            <li>{{ $container->container_no."/".$container->size."'" }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Goods</label>
                                                </div>
                                                <div class="col-md-8">
                                                    :
                                                    <ul class="list-item-inv">
                                                        @foreach($goods as $good)
                                                            <li>{{ number_format($good->qty_comm,0)." ".$good->code_c." OF ".$good->desc."'" }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Issued Date</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group date" id="reservationdate"
                                                        data-target-input="nearest">
                                                        <input type="text" name="invoice_date"
                                                            id="invoice_date"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#reservationdate" />
                                                        <div class="input-group-append" data-target="#reservationdate"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>TOP</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="number" name="top" id="top">
                                                </div>
                                                <div class="col-md-4">
                                                    Days
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Currency <font color="#f00">*</font></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control select2bs44" name="currency" id="currency">
                                                        <option value="" selected>-- Select Valuta --</option>
                                                        @foreach($currency as $item)
                                                            <option value="{{ $item->id }}" @if ($booking->
                                                                valuta_payment == $item->id) selected @endif>
                                                                {{ '('.$item->code.') '.$item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>MB/L NO.</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="mbl_shipper"
                                                        id="mbl_shipper" value="{{ $booking->mbl_no }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>HB/L</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="hbl_shipper"
                                                        id="hbl_shipper" value="{{ $booking->hbl_shipper }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>VESSEL</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="vessel" id="vessel" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>M. VESSEL</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="m_vessel"
                                                        id="m_vessel" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Loading</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="pol_name"
                                                        id="pol_name" value="{{ $booking->port1 }}" readonly>
                                                    <input class="form-control" type="hidden" name="pol_id" id="pol_id"
                                                        value="{{ $booking->pol_id }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Destination</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="pod_name"
                                                        id="pod_name" value="{{ $booking->port3 }}" readonly>
                                                    <input class="form-control" type="hidden" name="pod_id" id="pod_id"
                                                        value="{{ $booking->pod_id }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>On Board Date</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group date" id="reservationdatex"
                                                        data-target-input="nearest">
                                                        <input type="text" name="onboard_date" id="onboard_date"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#reservationdate" />
                                                        <div class="input-group-append" data-target="#reservationdatex"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
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
                                    <h5 class="card-title">Detail</h5>
                                    {{-- <a href="{{ route('invoice.create') }}"
                                    class="btn btn-success float-right"><i class="fas fa-check"></i> Create Invoice
                                    Selected</a> --}}
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-bordered table-striped" id="myTable2" style="width: 150%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Service/Fee</th>
                                                <th>Description</th>
                                                <th>Reimbursment</th>
                                                <th>Unit</th>
                                                <th>Currency</th>
                                                <th>rate/unit</th>
                                                <th>Total</th>
                                                <th>ROE</th>
                                                {{-- <th>Vat</th> --}}
                                                <th>Amount</th>
                                                <th>Note</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="tblCost">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary" id="saveData">Save</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('after-scripts')
    <script>
        $('#create_type').on('change', function() {
            if($('#create_type').val() == 0){
                $('.show_new').show('slow');
            }else{
                $.ajax({
                    url: "{{ route('invoice.getInvoiceHeader') }}",
                    type: "POST",
                    data: {
                        id: $('#create_type').val(),
                    },
                    dataType:'json',
                    success: function(result) {
                        console.log(result.status);
                        if(result.status == 'sukses'){
                            if(result.data.total_vat>0){
                                $('#ppn').prop('checked',true).trigger('change');
                            }else{
                                $('#ppn').prop('checked',false).trigger('change');
                            }
                            if(result.data.pph23>0){
                                $('#pph23').prop('checked',true).trigger('change');
                            }else{
                                $('#pph23').prop('checked',false).trigger('change');
                            }
                            $('.show_new').hide('slow');
                        }else{
                            alert(result.message);
                        }
                    }
                });
            }
        });

        $("#saveData").click(function(){
            if($('#create_type').val() == 0){
                const rbs = document.querySelectorAll('input[name="loaded"]');
                let selectedLoaded;
                for (const rb of rbs) {
                    if (rb.checked) {
                        selectedLoaded = rb.value;
                        break;
                    }
                }

                if($.trim($("#invoice_no").val()) == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input Nomor Invoice',
                        icon: 'error'
                    })
                }else if($.trim($("#invoice_date").val()) == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input Issue Date',
                        icon: 'error'
                    })
                }else if($.trim($("#top").val()) == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input Top',
                        icon: 'error'
                    })
                }else if($.trim($("#currency").val()) == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Select Currency',
                        icon: 'error'
                    })
                }else if($.trim($("#onboard_date").val()) == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input On Board Date',
                        icon: 'error'
                    })
                }else{
                    $(this).prop('disabled', true).text('Please Wait ...');
                    $('#formInvoice').submit();
                }
            }else{
                $(this).prop('disabled', true).text('Please Wait ...');
                $('#formInvoice').submit();
            }
        });

        function client_detail(val) {
            if (val != '') {

                let client_addr = $('#client_addr_id').val();
                let client_pic = $('#client_pic_id').val();

                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: {
                        id: val,
                        pic_id: client_pic,
                        addr_id: client_addr
                    },
                    dataType: "html",
                    success: function (result) {
                        var final = JSON.parse(result);
                        let legal = final[2].legal_doc_flag;

                        $("#client_addr_id").html(final[0]);
                        $("#client_pic_id").html(final[1]);

                        // if(legal == 1){
                        //     $('#legalDoc').prop('checked', true);
                        // }else{
                        //     $('#legalDoc').prop('checked', false);
                        // }
                    }
                });
            }
        }

            function checkedTax(code, name, value) {
                if ($('#'+code).is(':checked')) {
                    $('#row_'+code).show();
                    $('#lbl_'+code).text(name + ' (' + value + ' %)');
                    $('#value_'+code).val(value);
                } else {
                    $('#row_'+code).hide();
                    $('#value_'+code).val(0);
                }

                calculateTotal();
            }

            function calculateTotal() {
                let total_before_vat = $('#total_before_vat');
                let total_invoice = $('#total_invoice');
                let ppn = $('#value_ppn');
                let pph23 = $('#value_pph23');
                let total_ppn = $('#input_ppn');
                let total_pph23 = $('#input_pph23');

                let total_before_vat_val = Number(total_before_vat.val().toString().replace(/\,/g, ""));
                let ppn_val = Number(ppn.val().toString().replace(/\,/g, ""));
                let pph23_val = Number(pph23.val().toString().replace(/\,/g, ""));
                let total_ppn_val = total_before_vat_val * (ppn_val / 100);
                let total_pph23_val = total_before_vat_val * (pph23_val / 100);

                let result;
                result = total_before_vat_val + total_ppn_val - total_pph23_val;

                total_ppn.val(total_ppn_val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                total_pph23.val(total_pph23_val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                total_invoice.val(result.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }

        /** Load Schedule **/
        function loadSellCost(id) {
            if (id != null) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('invoice.loadSellCost') }}",
                    data: {
                        id: id,
                        chrg_dtl_id: @json($chrg_dtl_id),
                        invoice_type: $('input[name="invoice_type"]:checked').val(),
                        tipe_inv: '{{$tipe_inv}}'
                    },
                    dataType: "html",
                    success: function (result) {
                        var tabel = JSON.parse(result);
                        $('#tblCost').html(tabel[0]);
                        // $('#tblProfit').html(tabel[2]);
                    }
                })
            }
        }

        function showErrorMsg(msg) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '{!! $errorMsg !!}',
            })
        }

        $(function () {
            if ({{ $error }} == 1) showErrorMsg('{{ $errorMsg }}');
            loadSellCost({{ $booking->id }})
        });

    </script>
@endpush
@endsection
