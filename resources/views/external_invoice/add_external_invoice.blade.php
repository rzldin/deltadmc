@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus"></i>
                    External Invoice
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">External Invoice</li>
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
                            <strong>{{ ucwords($proforma_invoice_header->activity) }}</strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('external_invoice.save') }}"
                            id="formInvoice">
                            @csrf
                            <input type="hidden" name="id" value="0">
                            <input type="hidden" name="total_invoice" value="{{ $proforma_invoice_header->total_invoice }}">
                            <input type="hidden" name="t_proforma_invoice_id" id="t_proforma_invoice_id" value="{{ $proforma_invoice_header->id }}" />
                            <input type="hidden" name="activity" value="{{ $proforma_invoice_header->activity }}">
                            <input type="hidden" name="t_booking_id" value="{{ $proforma_invoice_header->t_booking_id }}">
                            <input type="hidden" name="rate" value="{{ $proforma_invoice_header->rate }}">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Invoice Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Bill To</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="client_id" id="client_id"
                                                        onchange="client_detail(this.value)">
                                                        <option value="">Select Company</option>
                                                        @foreach($companies as $company)
                                                            <option value="{{ $company->id }}"
                                                                <?= $company->id == $proforma_invoice_header['client_id'] ? 'selected' : '' ?>>
                                                                {{ $company->client_code }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Address</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="client_addr_id"
                                                        id="client_addr_id">
                                                        <option value="">Select Address</option>
                                                        @foreach($addresses as $address)
                                                            <option value="{{ $address->id }}"
                                                                <?= $company->id == $proforma_invoice_header['client_addr_id'] ? 'selected' : '' ?>>
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
                                                    <select class="form-control" name="client_pic_id"
                                                        id="client_pic_id">
                                                        <option value="">Select PIC</option>
                                                        @foreach($pics as $pic)
                                                            <option value="{{ $pic->id }}"
                                                                <?= $company->id == $proforma_invoice_header['client_pic_id'] ? 'selected' : '' ?>>
                                                                {{ $pic->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>External Invoice No</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="external_invoice_no"
                                                    id="external_invoice_no" value="">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Truck No</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="truck_no"
                                                    id="truck_no" value="{{ $proforma_invoice_header->truck_no }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Invoice Type</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="radio" name="invoice_type"
                                                        id="invoice_type_reg" value="REG" <?= (($proforma_invoice_header->reimburse_flag == '0' && $proforma_invoice_header->debit_note_flag == '0' && $proforma_invoice_header->credit_note_flag == '0') ? 'checked' : '') ?>> Reguler<br>
                                                    <input type="radio" name="invoice_type"
                                                        id="invoice_type_reimbursment" value="REM" <?= (($proforma_invoice_header->reimburse_flag == '1') ? 'checked' : '') ?>> Reimbursment<br>
                                                    <input type="radio" name="invoice_type"
                                                        id="invoice_type_debit_note" value="DN" <?= (($proforma_invoice_header->debit_note_flag == '1') ? 'checked' : '') ?>> Debit Note<br>
                                                    <input type="radio" name="invoice_type"
                                                        id="invoice_type_credit_note" value="CN" <?= (($proforma_invoice_header->credit_note_flag == '1') ? 'checked' : '') ?>> Credit Note<br>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>MB/L</label>
                                                </div>
                                                <div class="col-md-8">
                                                    : {{ $proforma_invoice_header->mbl_shipper }}
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
                                                    <div class="input-group date" id="external_invoice_date_picker"
                                                        data-target-input="nearest">
                                                        <input type="text" name="external_invoice_date"
                                                            id="external_invoice_date"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#external_invoice_date_picker" value="{{ date('d/m/Y') }}" />
                                                        <div class="input-group-append" data-target="#external_invoice_date_picker"
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
                                                    <input class="form-control" type="number" name="top" id="top" value="{{ $proforma_invoice_header->top }}">
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
                                                    <select class="form-control" name="currency" id="currency">
                                                        <option value="" selected>-- Select Valuta --</option>
                                                        @foreach($currency as $item)
                                                            <option value="{{ $item->id }}" @if ($proforma_invoice_header->
                                                                currency == $item->id) selected @endif>
                                                                {{ $item->code }}</option>
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
                                                        id="mbl_shipper" value="{{ $proforma_invoice_header->mbl_no }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>HB/L</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="hbl_shipper"
                                                        id="hbl_shipper" value="{{ $proforma_invoice_header->hbl_shipper }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>VESSEL</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="vessel" id="vessel" value="{{ $proforma_invoice_header->vessel }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>M. VESSEL</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="m_vessel"
                                                        id="m_vessel" value="{{ $proforma_invoice_header->m_vessel }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Loading</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="pol_name"
                                                        id="pol_name" value="{{ $proforma_invoice_header->pol_name }}" readonly>
                                                    <input class="form-control" type="hidden" name="pol_id" id="pol_id"
                                                        value="{{ $proforma_invoice_header->pol_id }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Destination</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="pod_name"
                                                        id="pod_name" value="{{ $proforma_invoice_header->pod_name }}" readonly>
                                                    <input class="form-control" type="hidden" name="pod_id" id="pod_id"
                                                        value="{{ $proforma_invoice_header->pod_id }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>On Board Date</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group date" id="onboard_date_picker"
                                                        data-target-input="nearest">
                                                        <input type="text" name="onboard_date" id="onboard_date"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#onboard_date_picker" value="{{ date('d/m/Y', strtotime($proforma_invoice_header->onboard_date)) }}" />
                                                        <div class="input-group-append" data-target="#onboard_date_picker"
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
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-bordered table-striped" id="" style="width: 150%">
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
                                                <th>Total</th>
                                                <th>ROE</th>
                                                <th>Vat</th>
                                                <th>Amount</th>
                                                <th>Note</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="tblSell">
                                            @foreach ($proforma_invoice_details as $key => $proforma_invoice_detail)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $proforma_invoice_detail->charge_name }}</td>
                                                <td>{{ $proforma_invoice_detail->desc }}</td>
                                                <td align="center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs" <?= ($proforma_invoice_header->reimburse_flag == 1 ? 'checked' : '') ?> onclick="return false;" /></td>
                                                <td>{{ $proforma_invoice_detail->qty }}</td>
                                                <td>{{ $proforma_invoice_detail->currency_code }}</td>
                                                <td>{{ number_format($proforma_invoice_detail->sell_val, 2, ',', '.') }}</td>
                                                <td>{{ number_format($proforma_invoice_detail->subtotal, 2, ',', '.') }}</td>
                                                <td>{{ number_format($proforma_invoice_detail->rate, 2, ',', '.') }}</td>
                                                <td>{{ number_format($proforma_invoice_detail->vat, 2, ',', '.') }}</td>
                                                <td>{{ number_format((($proforma_invoice_detail->subtotal * $proforma_invoice_detail->rate) + $proforma_invoice_detail->vat), 2, ',', '.') }}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align: right">

                                    <button type="submit" class="btn btn-primary" onclick="saveInvoice()">Save</button>
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

        $(function() {
            $('#external_invoice_date_picker').datetimepicker({
                format: 'L'
            });
            $('#onboard_date_picker').datetimepicker({
                format: 'L'
            });
        });
    </script>
@endpush
@endsection
