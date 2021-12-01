@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus"></i>
                    View Pro Forma Invoice
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
                            <strong>{{ ucwords($header->activity) }}</strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('proformainvoice.update') }}"
                            id="formProforma">
                            @csrf
                            <input readonly type="hidden" name="id" id="id" value="{{ $header->id }}" />
                            <input readonly type="hidden" name="t_booking_id" id="t_booking_id" value="{{ $header->t_booking_id }}" />
                            <input readonly type="hidden" name="activity" value="{{ $header->activity }}">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Pro Forma Invoice Information</h3>
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
                                                                <?= $company->id == $header['client_addr_id'] ? 'selected' : '' ?>>
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
                                                                <?= $company->id == $header['client_pic_id'] ? 'selected' : '' ?>>
                                                                {{ $pic->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Pro Forma Invoice No</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="proforma_invoice_no"
                                                    id="proforma_invoice_no" value="{{ $header->proforma_invoice_no }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Invoice Type</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input disabled type="radio" name="invoice_type"
                                                        id="invoice_type_reg" value="REG" <?= (($header->invoice_type == 'REG') ? 'checked' : '') ?>> Reguler<br>
                                                    <input disabled type="radio" name="invoice_type"
                                                        id="invoice_type_reimbursment" value="REM" <?= (($header->invoice_type == 'REM') ? 'checked' : '') ?>> Reimbursment<br>
                                                    <input disabled type="radio" name="invoice_type"
                                                        id="invoice_type_debit_note" value="DN" <?= (($header->invoice_type == 'DN') ? 'checked' : '') ?>> Debit Note<br>
                                                    <input disabled type="radio" name="invoice_type"
                                                        id="invoice_type_credit_note" value="CN" <?= (($header->invoice_type == 'CN') ? 'checked' : '') ?>> Credit Note<br>
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
                                                    <div class="input readonly-group date" id="reservationdate" data-target-input readonly="nearest">
                                                        <input readonly type="text" name="proforma_invoice_date" id="proforma_invoice_date" value="{{ \Carbon\Carbon::parse($header->proforma_invoice_date)->format('d/m/Y') }}" class="form-control datetimepicker-input readonly" data-target="#reservationdate" readonly/>
                                                        {{-- <div class="input readonly-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                            <div class="input readonly-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div> --}}
                                                    </div>
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
                                                    <input readonly class="form-control" type="text" name="mbl_shipper"
                                                        id="mbl_shipper" value="{{ $header->mbl_no }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>HB/L</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="hbl_shipper"
                                                        id="hbl_shipper" value="{{ $header->hbl_shipper }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>VESSEL</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="vessel" id="vessel" value="{{ $header->vessel }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>M. VESSEL</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="m_vessel"
                                                        id="m_vessel" value="{{ $header->m_vessel }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Loading</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="pol_name"
                                                        id="pol_name" value="{{ $header->pol_name }}">
                                                    <input readonly class="form-control" type="hidden" name="pol_id" id="pol_id"
                                                        value="{{ $header->pol_id }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Destination</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="pod_name"
                                                        id="pod_name" value="{{ $header->pod_name }}">
                                                    <input readonly class="form-control" type="hidden" name="pod_id" id="pod_id"
                                                        value="{{ $header->pod_id }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>On Board Date</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input readonly-group date" id="reservationdatex" data-target-input readonly="nearest">
                                                        <input readonly type="text" name="onboard_date" id="onboard_date" value="{{ \Carbon\Carbon::parse($header->onboard_date)->format('d/m/Y') }}" class="form-control datetimepicker-input readonly" data-target="#reservationdatex" readonly/>
                                                        {{-- <div class="input readonly-group-append" data-target="#reservationdatex" data-toggle="datetimepicker">
                                                            <div class="input readonly-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div> --}}
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
                                    {{-- <a href="{{ route('proformainvoice.create') }}"
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
                                                <th>Vat</th>
                                                <th>Amount</th>
                                                <th>Note</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="tblSell">
                                            @foreach ($details as $key => $detail)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $detail->charge_name }}</td>
                                                    <td>{{ $detail->desc }}</td>
                                                    <td>{{ $header->reimburse_flag }}</td>
                                                    <td>{{ $detail->qty }}</td>
                                                    <td>{{ $detail->currency_code }}</td>
                                                    <td>{{ number_format($detail->sell_val, 2, ',', '.') }}</td>
                                                    <td>{{ number_format($detail->subtotal, 2, ',', '.') }}</td>
                                                    <td>{{ number_format($detail->rate, 2, ',', '.') }}</td>
                                                    <td>{{ number_format($detail->vat, 2, ',', '.') }}</td>
                                                    <td>{{ number_format((($detail->subtotal * $detail->rate) + $detail->vat), 2, ',', '.') }}</td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align: right">
                                    <a href="{{ url()->previous() }}" class="btn btn-info">Back</a>
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

    </script>
@endpush
@endsection
