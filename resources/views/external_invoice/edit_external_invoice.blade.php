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
                            <strong>{{ ucwords($header->activity) }}</strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('invoice.save') }}"
                            id="formInvoice">
                            @csrf
                            <input type="hidden" name="id" value="0">
                            <input type="hidden" name="t_proforma_invoice_id" id="t_proforma_invoice_id" value="{{ $header->id }}" />
                            <input type="hidden" name="activity" value="{{ $header->activity }}">
                            <input type="hidden" name="t_booking_id" value="{{ $header->t_booking_id }}">
                            <input type="hidden" name="rate" value="{{ $header->rate }}">
                            {{-- <input type="hidden" name="t_proforma_invoice_id" id="t_proforma_invoice_id" value="{{ $header->t_proforma_invoice_id }}" /> --}}
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
                                                    <select disabled class="form-control" name="client_id" id="client_id"
                                                        onchange="client_detail(this.value)">
                                                        <option value="">Select Company</option>
                                                        @foreach($companies as $company)
                                                            <option value="{{ $company->id }}"
                                                                <?= $company->id == $header['client_id'] ? 'selected' : '' ?>>
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
                                                    <select disabled class="form-control" name="client_addr_id"
                                                        id="client_addr_id">
                                                        <option value="">Select Address</option>
                                                        @foreach($addresses as $address)
                                                            <option value="{{ $address->id }}"
                                                                <?= $address->id == $header['client_addr_id'] ? 'selected' : '' ?>>
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
                                                    <select disabled class="form-control" name="client_pic_id"
                                                        id="client_pic_id">
                                                        <option value="">Select PIC</option>
                                                        @foreach($pics as $pic)
                                                            <option value="{{ $pic->id }}"
                                                                <?= $pic->id == $header['client_pic_id'] ? 'selected' : '' ?>>
                                                                {{ $pic->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Invoice No</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="external_invoice_no"
                                                    id="external_invoice_no" value="{{ $header->external_invoice_no }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Truck No</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="truck_no"
                                                    id="truck_no" value="{{ $header->truck_no }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Invoice Type</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input disabled type="radio" name="invoice_type"
                                                        id="invoice_type_reg" value="REG" <?= (($header->reimburse_flag == '0' && $header->debit_note_flag == '0' && $header->credit_note_flag == '0') ? 'checked' : '') ?>> Reguler<br>
                                                    <input disabled type="radio" name="invoice_type"
                                                        id="invoice_type_reimbursment" value="REM" <?= (($header->reimburse_flag == '1') ? 'checked' : '') ?>> Reimbursment<br>
                                                    <input disabled type="radio" name="invoice_type"
                                                        id="invoice_type_debit_note" value="DN" <?= (($header->debit_note_flag == '1') ? 'checked' : '') ?>> Debit Note<br>
                                                    <input disabled type="radio" name="invoice_type"
                                                        id="invoice_type_credit_note" value="CN" <?= (($header->credit_note_flag == '1') ? 'checked' : '') ?>> Credit Note<br>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>MB/L</label>
                                                </div>
                                                <div class="col-md-8">
                                                    : {{ $header->mbl_shipper }}
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
                                                    <input readonly type="text" name="external_invoice_date" id="external_invoice_date"
                                                        class="form-control"value="{{ date('d/m/Y', strtotime($header->external_invoice_date)) }}" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>TOP</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input readonly class="form-control" type="number" name="top" id="top" value="{{ $header->top }}">
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
                                                    <select disabled class="form-control" name="currency" id="currency">
                                                        <option value="" selected>-- Select Valuta --</option>
                                                        @foreach($currency as $item)
                                                            <option value="{{ $item->id }}" @if ($header->
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
                                                    <input readonly class="form-control" type="text" value="{{ $header->mbl_no }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>HB/L</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" value="{{ $header->hbl_no }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>VESSEL</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" value="{{ $header->vessel }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>M. VESSEL</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" value="{{ $header->m_vessel }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Loading</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" value="{{ $header->pol_name }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Destination</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" value="{{ $header->pod_name }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>On Board Date</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly type="text" name="onboard_date" id="onboard_date"
                                                        class="form-control"value="{{ date('d/m/Y', strtotime($header->onboard_date)) }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary">
                                <div class="row card-header">
                                    <div class="col-6">
                                        <h5 class="card-title">Detail</h5>
                                    </div>
                                    <div class="col-6">
                                        <div class="row" style="padding-bottom: 5px;">
                                            <div class="col" style="text-align: right">
                                                <button type="button" onclick="syncInvoice()"
                                                class="btn btn-success" {{ $header->flag_bayar > 0 ? 'disabled' : '' }}><i class="fas fa-redo"></i> Sync Detail</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-bordered table-striped" style="width: 150%">
                                        <thead>
                                            <tr>
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
                                            @foreach ($details as $key => $detail)
                                                <tr>
                                                    <td align="center">{{ $key + 1 }}</td>
                                                    <td>{{ $detail->charge_name }}</td>
                                                    <td>{{ $detail->desc }}</td>
                                                    <td align="center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs" <?= ($header->reimburse_flag == 1 ? 'checked' : '') ?> onclick="return false;" /></td>
                                                    <td>{{ $detail->qty }}</td>
                                                    <td>{{ $detail->currency_code }}</td>
                                                    <td align="right">{{ number_format($detail->sell, 2, '.', ',') }}</td>
                                                    <td align="right">{{ number_format($detail->rate, 2, '.', ',') }}</td>
                                                    <td align="right">{{ number_format($detail->sell_val, 2, '.', ',') }}</td>
                                                    <td align="right">{{ number_format($detail->vat, 2, '.', ',') }}</td>
                                                    <td align="right">{{ number_format($detail->pph23, 2, '.', ',') }}</td>
                                                    <td align="right">{{ number_format($detail->subtotal, 2, '.', ',') }}</td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="8" class="text-right">Total</td>
                                                <td class="text-right">{{ number_format($header->total_before_vat, 2, '.', ',') }}</td>
                                                <td class="text-right">{{ number_format($header->total_vat, 2, '.', ',') }}</td>
                                                <td class="text-right">{{ number_format($header->pph23, 2, '.', ',') }}</td>
                                                <td class="text-right">{{ number_format($header->total_invoice, 2, '.', ',') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align: right">
                                    <a href="{{ url()->previous() }}" class="btn btn-info" >Back</a>
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
        function syncInvoice() {
            $.ajax({
                type: 'get',
                url: `{{ route('external_invoice.syncExternalInvoiceDetail') }}`,
                data: {
                    proforma_invoice_id : @json($header->t_proforma_invoice_id),
                    external_invoice_id : @json($header->id),
                },
                success: function(result) {
                    console.log(result);
                    if (result.status == 'success') {
                        toast('success', result.message);
                        location.reload();
                    } else {
                        fire('error', 'Oppss..', result.message);
                    }
                }
            });
        }
    </script>
@endpush
@endsection
