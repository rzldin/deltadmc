@extends('layouts.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-plus"></i>
                        Proforma Invoice
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Proforma Invoice</li>
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
                                <strong>{{ ucwords($invoice_header->activity) }}</strong>
                            </h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('proforma_invoice.save') }}" id="formInvoice">
                                @csrf
                                <input type="hidden" name="id" value="0">
                                <input type="hidden" name="total_invoice" value="{{ $invoice_header->total_invoice }}">
                                <input type="hidden" name="t_invoice_id" id="t_invoice_id" value="{{ $invoice_header->id }}" />
                                <input type="hidden" name="activity" value="{{ $invoice_header->activity }}">
                                <input type="hidden" name="t_booking_id" value="{{ $invoice_header->t_booking_id }}">
                                <input type="hidden" name="rate" value="{{ $invoice_header->rate }}">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Proforma Invoice Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Bill To</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" id="bill_to_name" class="form-control" value="{{ $companies->client_name }}" disabled>
                                                        <input type="hidden" id="client_id" name="client_id" value="{{ $companies->id }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Address</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select class="form-control select2bs44" name="client_addr_id" id="client_addr_id">
                                                            <option value="">Select Address</option>
                                                            @foreach ($addresses as $address)
                                                                <option value="{{ $address->id }}" <?= $address->id == $invoice_header['client_addr_id'] ? 'selected' : '' ?>>
                                                                    {{ $address->address }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>PIC</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select class="form-control select2bs44" name="client_pic_id" id="client_pic_id">
                                                            <option value="">Select PIC</option>
                                                            @foreach ($pics as $pic)
                                                                <option value="{{ $pic->id }}" <?= $pic->id == $invoice_header['client_pic_id'] ? 'selected' : '' ?>>
                                                                    {{ $pic->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Proforma Invoice No</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text" name="proforma_invoice_no" id="proforma_invoice_no" value="{{ $invoice_header->invoice_no }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Truck No</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text" name="truck_no" id="truck_no" value="{{ $invoice_header->truck_no }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Invoice Type</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="radio" name="invoice_type" id="invoice_type_reg" onchange="loadDetail(0, {{ $invoice_header->id }})" value="REG"
                                                            <?= $invoice_header->reimburse_flag == '0' && $invoice_header->reimburse_flag == '0' && $invoice_header->debit_note_flag == '0' && $invoice_header->credit_note_flag == '0' ? 'checked' : '' ?>>
                                                        Reguler<br>
                                                        <input type="radio" name="invoice_type" id="invoice_type_reimbursment" onchange="loadDetail(0, {{ $invoice_header->id }})" value="REM"
                                                            <?= $invoice_header->reimburse_flag == '1' ? 'checked' : '' ?>> Reimbursment<br>
                                                        <input type="radio" name="invoice_type" id="invoice_type_debit_note" onchange="loadDetail(0, {{ $invoice_header->id }})" value="DN"
                                                            <?= $invoice_header->debit_note_flag == '1' ? 'checked' : '' ?>> Debit Note<br>
                                                        <input type="radio" name="invoice_type" id="invoice_type_credit_note" onchange="loadDetail(0, {{ $invoice_header->id }})" value="CN"
                                                            <?= $invoice_header->credit_note_flag == '1' ? 'checked' : '' ?>> Credit Note<br>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>MB/L</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        : {{ $invoice_header->mbl_shipper }}
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Container</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        :
                                                        <ul class="list-item-inv">
                                                            @foreach ($containers as $container)
                                                                <li>{{ $container->container_no . '/' . $container->size . "'" }}
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
                                                            @foreach ($goods as $good)
                                                                <li>{{ number_format($good->qty_comm, 0) . ' ' . $good->code_c . ' OF ' . $good->desc . "'" }}
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
                                                        <div class="input-group date" id="proforma_invoice_date_picker" data-target-input="nearest">
                                                            <input type="text" name="proforma_invoice_date" id="proforma_invoice_date" class="form-control datetimepicker-input" data-target="#proforma_invoice_date_picker"
                                                                value="{{ date('m/d/Y', strtotime($invoice_header->invoice_date)) }}" />
                                                            <div class="input-group-append" data-target="#proforma_invoice_date_picker" data-toggle="datetimepicker">
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
                                                        <input class="form-control" type="number" name="top" id="top" value="{{ $invoice_header->top }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        Days
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Currency</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select class="form-control select2bs44" id="currency" disabled>
                                                            <option value="" selected>-- Select Valuta --</option>
                                                            @foreach ($currency as $item)
                                                                <option value="{{ $item->id }}" @if ($invoice_header->currency == $item->id) selected @endif>
                                                                    {{ $item->code }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="currency" value="{{ $invoice_header->currency }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>MB/L NO.</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input readonly class="form-control" type="text" value="{{ $invoice_header->mbl_no }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>HB/L</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input readonly class="form-control" type="text" value="{{ $invoice_header->hbl_no }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>VESSEL</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input readonly class="form-control" type="text" value="{{ $invoice_header->vessel }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>M. VESSEL</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input readonly class="form-control" type="text" value="{{ $invoice_header->m_vessel }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Loading</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input readonly class="form-control" type="text" value="{{ $invoice_header->pol_name }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Destination</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input readonly class="form-control" type="text" value="{{ $invoice_header->pod_name }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>On Board Date</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="input-group date" id="reservationdatex" data-target-input="nearest">
                                                            <input type="text" name="onboard_date" id="onboard_date" class="form-control datetimepicker-input" data-target="#reservationdate"
                                                                value="{{ date('d/m/Y', strtotime($invoice_header->onboard_date)) }}" />
                                                            <div class="input-group-append" data-target="#reservationdatex" data-toggle="datetimepicker">
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
                                        <a href="javascript:void(0);" onclick="showModalMerge()" class="btn btn-success float-right"><i class="fas fa-check"></i> Merge Detail Selected</a>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-bordered table-striped" id="myTable2" style="width: 150%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>No.</th>
                                                    <th>Service/Fee</th>
                                                    <th>Description</th>
                                                    <th>Reimbursment</th>
                                                    <th>Unit</th>
                                                    <th>Currency</th>
                                                    <th>rate/unit</th>
                                                    <th>ROE</th>
                                                    <th>Total</th>
                                                    <th>PPN</th>
                                                    <th>PPH 23</th>
                                                    <th>Amount</th>
                                                    {{-- <th>Note</th> --}}
                                                    {{-- <th>Action</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody id="tblSell">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: right">

                                        <button type="button" class="btn btn-primary" id="saveInvoice">Save</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalMerge" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Merge Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h5 class="card-title">Before</h5>
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
                                            <th>PPN</th>
                                            <th>PPH 23</th>
                                            <th>Amount</th>
                                            {{-- <th>Note</th> --}}
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="tblBefore">

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Merge to</td>
                                            <td>
                                                <input type="hidden" id="id_invoicenya" name="id_invoicenya">
                                                <select class="form-control select2bs44" name="charge" id="charge">
                                                    <option value="">--Select Charge Code--</option>
                                                    @foreach ($charges as $charge)
                                                        <option value="{{ $charge->id }}">{{ $charge->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="desc" id="desc" class="form-control">
                                            </td>
                                            <td style="text-align: center">
                                                <input type="checkbox" name="reimburse_flag" id="reimburse_flag" onclick="return false">
                                            </td>
                                            <td>
                                                <input type="text" name="qty" id="qty" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <select class="form-control" name="currency_dtl" id="currency_dtl" disabled>
                                                    <option value="" selected>-- Select Valuta --</option>
                                                    @foreach ($currency as $item)
                                                        <option value="{{ $item->id }}" @if ($invoice_header->currency == $item->id) selected @endif>
                                                            {{ $item->code }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="currency_id" id="currency_id">
                                                <input type="hidden" name="currency_code" id="currency_code">
                                            </td>
                                            <td>
                                                <input type="hidden" name="total_cost" id="total_cost" class="form-control" readonly>
                                                <input type="text" name="total_sell" id="total_sell" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="hidden" name="total_cost_val" id="total_cost_val" class="form-control" readonly>
                                                <input type="text" name="total_sell_val" id="total_sell_val" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="rate" id="rate" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="total_vat" id="total_vat" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="total_pph23" id="total_pph23" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="subtotal" id="subtotal" class="form-control" readonly>
                                                <input type="hidden" name="routing" id="routing" class="form-control">
                                                <input type="hidden" name="transit_time" id="transit_time" class="form-control">
                                            </td>
                                            {{-- <td> --}}
                                            {{-- <input type="text" name="note" id="note" class="form-control"> --}}
                                            {{-- </td> --}}
                                            {{-- <td>
                                            <a href="javascript:;" class="btn btn-xs btn-primary" onclick="saveMergeDetail()"><i class="fa fa-plus"></i></a>
                                        </td> --}}
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="saveMergeDetail()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
    @push('after-scripts')
        <script>
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
                        success: function(result) {
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

            function loadDetail(proformaInvoiceId, invoiceId) {
                url = `{{ route('proforma_invoice.loadDetail') }}`;
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        proforma_invoice_id: proformaInvoiceId,
                        invoice_id: invoiceId,
                        invoice_type: $('input[name="invoice_type"]:checked').val(),
                    },
                    success: function(result) {
                        $('#tblSell').html(result);
                    }
                });
            }

            function showModalMerge() {
                loadDetailBefore();
                // loadDetailAfter();
                var id = $.map($('input[name="detail_id"]:checked'), function(c) {
                    return c.value;
                });
                if (id == '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please select data!',
                    })
                } else if(id.length == 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please select more than 1 data!',
                    })
                } else {
                    currency = $('#currency_dtl option:selected');
                    $('#charge').val('').trigger("change");
                    $('#currency_id').val(currency.val());
                    $('#currency_code').val(currency.text());
                    $('#modalMerge').modal('show');
                }
            }

            function loadDetailBefore() {
                var id = $.map($('input[name="detail_id"]:checked'), function(c) {
                    return c.value;
                });
                var invoice_type = $('input[name="invoice_type"]:checked').val();
                url = `{{ route('proforma_invoice.loadDetailBefore') }}`;
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        id: id,
                        invoice_type: invoice_type,
                    },
                    success: function(result) {
                        $('#tblBefore').html(result);
                        if (invoice_type == 'REM') {
                            $('#reimburse_flag').prop('checked', true);
                        } else {
                            $('#reimburse_flag').prop('checked', false);
                        }
                        $('#id_invoicenya').val($('#id_invoicenya_before').val());
                        $('#qty').val($('#qty_before').val());
                        $('#total_cost').val($('#total_cost_before').val());
                        $('#total_sell').val($('#total_sell_before').val());
                        $('#total_cost_val').val($('#total_cost_val_before').val());
                        $('#total_sell_val').val($('#total_sell_val_before').val());
                        $('#rate').val($('#rate_before').val());
                        $('#total_vat').val($('#total_vat_before').val());
                        $('#total_pph23').val($('#total_pph23_before').val());
                        $('#subtotal').val($('#subtotal_before').val());
                        $('#routing').val($('#routing_before').val());
                        $('#transit_time').val($('#transit_time_before').val());
                    }
                });
            }

            function saveMergeDetail() {
                if($('#charge').val() == ''){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please select Service/Fee before merge!',
                    });
                }else{
                    var id_to_delete = $.map($('input[name="id_to_delete[]"]'), function(c) {
                        return c.value;
                    });
                    var id_invoicenya = $('#id_invoicenya');
                    var t_mcharge_code_id = $('#charge option:selected');
                    var desc = $('#desc');
                    var reimburse_flag = ($('#reimburse_flag').is(':checked') ? 1 : 0);
                    var qty = $('#qty');
                    var currency = $('#currency_dtl option:selected');
                    var currency_id = $('#currency_id');
                    var currency_code = $('#currency_code');
                    var cost = $('#total_cost');
                    var sell = $('#total_sell');
                    var cost_val = $('#total_cost_val');
                    var sell_val = $('#total_sell_val');
                    var rate = $('#rate');
                    var vat = $('#total_vat');
                    var pph23 = $('#total_pph23');
                    var subtotal = $('#subtotal');
                    var routing = $('#routing');
                    var transit_time = $('#transit_time');
                    // var note = $('#note');

                    $.ajax({
                        type: 'post',
                        url: `{{ route('proforma_invoice.saveMergeDetail') }}`,
                        data: {
                            id_to_delete: id_to_delete,
                            id_invoicenya: id_invoicenya.val(),
                            t_mcharge_code_id: t_mcharge_code_id.val(),
                            t_mcharge_code_name: t_mcharge_code_id.text(),
                            desc: desc.val(),
                            reimburse_flag: reimburse_flag,
                            qty: qty.val(),
                            currency_id: currency_id.val(),
                            currency_code: currency_code.val(),
                            cost: cost.val(),
                            sell: sell.val(),
                            cost_val: cost_val.val(),
                            sell_val: sell_val.val(),
                            rate: rate.val(),
                            vat: vat.val(),
                            pph23: pph23.val(),
                            subtotal: subtotal.val(),
                            routing: routing.val(),
                            transit_time: transit_time.val(),
                            // note : note.val(),
                        },
                        success: function(result) {
                            loadDetail(0, `{{ $invoice_header['id'] }}`);
                            clearFields();
                            $('#modalMerge').modal('hide');
                        }
                    });
                }
            }

            function clearFields() {
                $('#charge').val('');
                $('#desc').val('');
                $('#reimburse_flag').val('');
                $('#qty').val('');
                $('#currency_dtl').val('');
                $('#currency_id').val('');
                $('#currency_code').val('');
                $('#total_cost').val('');
                $('#total_sell').val('');
                $('#total_cost_val').val('');
                $('#total_sell_val').val('');
                $('#rate').val('');
                $('#total_vat').val('');
                $('#total_pph23').val('');
                $('#subtotal').val('');
                $('#routing').val('');
                $('#transit_time').val('');
                // $('#note').val('');
            }

            $('#saveInvoice').on('click', function(event) {
                if ($('#proforma_invoice_no').val() == '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please input Proforma Invoice Number!',
                    });
                } else if($('#proforma_invoice_date').val() == '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please input Proforma Invoice Date !',
                    });
                } else {
                    $(this).prop('disabled',true).text('Please Wait ...');
                    $('#formInvoice').submit();
                }
            });

            $(function() {
                loadDetail(0, `{{ $invoice_header['id'] }}`);
                $('#proforma_invoice_date_picker').datetimepicker({
                    format: 'L'
                });
            });
        </script>
    @endpush
@endsection
