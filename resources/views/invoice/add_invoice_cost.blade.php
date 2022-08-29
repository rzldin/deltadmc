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
                                            <label>Create or Merge existing Invoice</label>
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
                                                @if($is_reimburse>0)
                                                    <input type="radio" name="invoice_type" id="invoice_type_reimbursment" onchange="loadSellCost({{ $booking->id }})" value="REM" checked>
                                                    Reimbursment<br>
                                                @else
                                                    <input type="radio" name="invoice_type" id="invoice_type_reg" onchange="loadSellCost({{ $booking->id }})" value="REG" checked> Reguler<br>
                                                    <input type="radio" name="invoice_type" id="invoice_type_debit_note" onchange="loadSellCost({{ $booking->id }})" value="DN"> Debit Note<br>
                                                    <input type="radio" name="invoice_type" id="invoice_type_credit_note" onchange="loadSellCost({{ $booking->id }})" value="CN"> Credit Note<br>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Tax</label>
                                                </div>
                                                <div class="col-md-8">
                                                    @foreach ($taxes as $tax)
                                                        <div class="form-check form-check-inline">
                                                            <button type="button" class="btn btn-info btn-xs" onclick="checkedTax(`{{$tax->code}}`)">{{ "$tax->name ($tax->value %)" }}</button>
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
                                                    <select class="form-control select2bs44" name="currency" id="currency" onchange="show_kurs(this.value)">
                                                        <option value="" selected>-- Select Valuta --</option>
                                                        @foreach($currency as $item)
                                                            <option value="{{ $item->id }}" @if ($booking->
                                                                valuta_payment == $item->id) selected @endif>
                                                                {{ '('.$item->code.') '.$item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3 show_kurs" style="display: none;">
                                                <div class="col-md-4">
                                                    <label>Kurs</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="kurs"
                                                        id="kurs" value="1">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>MB/L NO.</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" value="{{ $booking->mbl_no }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>HB/L</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" value="{{ $booking->hbl_no }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>VESSEL</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>M. VESSEL</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Loading</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" value="{{ $booking->port1 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Destination</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" value="{{ $booking->port3 }}" readonly>
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
                                                            data-target="#reservationdate" value="{{ \Carbon\Carbon::parse($booking->etd_date)->format('d/m/Y') }}"/>
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
                                    <table class="table table-bordered table-striped" style="width: 100%">
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
                                                <th>Cost<br>Adj</th>
                                                <th>Amount</th>
                                                @foreach ($taxes as $tax)
                                                    <th>{{ "$tax->name ($tax->value %)" }}</th>
                                                @endforeach
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

        function show_kurs(val){
            if(val == '' || val == 65){//idr
                $('.show_kurs').hide('slow');
            }else{
                $('.show_kurs').show('slow');
            }
        }

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

            function checkedTax(code) {
                $('.'+code).trigger('click');
            }

            function checkedTaxDetail(code, no, name, value) {
                if ($('#btn_'+code+no).is(':checked')) {
                    $('#lbl_'+code+no).show();
                } else {
                    $('#lbl_'+code+no).hide();
                }
                checkstate(code,name,value);
            }

            function checkstate(code,name,value) {
                let elems = document.getElementsByClassName(code);
                let checked = false;
                let total_value = Number(0);
                for (let i = 0; i < elems.length; i++) {
                    if (elems[i].checked) {
                        total_value += Number(elems[i].value);
                        checked = true;
                    }
                }
                $('#input_'+code).val(Number(total_value).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                if (checked) {
                    $('#row_'+code).show();
                    $('#lbl_total_'+code).text(name + ' (' + value + ' %)');
                } else {
                    $('#row_'+code).hide();
                }
                calculateTotal();
            }

            function calculateTotal() {
                let total_before_vat = $('#total_before_vat');
                let total_invoice = $('.total_invoice');
                let total_before_vat_val = Number(total_before_vat.val().toString().replace(/\,/g, ""));
                @foreach ($taxes as $tax)
                    let total_{{$tax->code}}_val = $('#input_{{$tax->code}}').val().toString().replace(/\,/g, "");
                @endforeach
                let result;
                result = Number(total_before_vat_val) + Number(total_ppn_val) - Number(total_pph23_val) + Number(total_ppn1_val);

                total_invoice.text(result.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                total_invoice.val(result.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }

        /** Load Detail **/
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
                        $(".taxcheck").prop('checked', false);//reset biar nge checkbox ulang tax nya
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
