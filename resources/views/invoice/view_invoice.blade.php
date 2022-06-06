@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus"></i>
                    Internal Invoice
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Internal Invoice</li>
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
                            <input type="hidden" name="id" id="id" value="{{ $header->id }}" />
                            <input type="hidden" name="activity" value="{{ $header->activity }}">
                            <input type="hidden" name="t_booking_id" value="{{ $header->t_booking_id }}">
                            <input type="hidden" name="rate" value="{{ $header->rate }}">
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
                                                    <input class="form-control" type="text" name="client_name"
                                                    id="client_name" value="{{ '('.$header->client_code.') '.$header->client_name }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Address</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="address"
                                                    id="address" value="{{ $header->address }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>PIC</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="pic_name"
                                                    id="pic_name" value="{{ $header->pic_name }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Invoice No</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="invoice_no"
                                                    id="invoice_no" value="{{ $header->invoice_no }}">
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
                                                    <input readonly type="text" name="invoice_date" id="invoice_date"
                                                        class="form-control"value="{{ date('d/m/Y', strtotime($header->invoice_date)) }}" />
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
                                                    <input class="form-control" type="text" name="currency"
                                                    id="currency" value="{{ '('.$header->currency_code.') '.$header->currency_name }}" readonly>
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
                                <div class="card-header">
                                    <h5 class="card-title">List Bank</h5>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Account Number</th>
                                                <th>Account Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_bank as $list)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $list->account_number }}</td>
                                                <td>{{ $list->account_name }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                                    <table class="table table-bordered table-striped">
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
                                            @php $total_before_vat = 0;  $total_invoice = 0; @endphp
                                            @foreach ($details as $key => $detail)
                                                @php 
                                                    $total_before_vat += $detail->sell_val; 
                                                    $total_invoice += $detail->subtotal; 
                                                @endphp
                                                <tr>
                                                    <td align="center">{{ $key + 1 }}</td>
                                                    <td>{{ $detail->charge_name }}</td>
                                                    <td>{{ $detail->desc }}</td>
                                                    <td align="center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs" <?= ($header->reimburse_flag == 1 ? 'checked' : '') ?> onclick="return false;" /></td>
                                                    <td>{{ $detail->qty }}</td>
                                                    <td>{{ $detail->currency_code }}</td>
                                                    <td align="right">{{ number_format($detail->sell, 2, ',', '.') }}</td>
                                                    <td align="right">{{ number_format($detail->rate, 2, ',', '.') }}</td>
                                                    <td align="right">{{ number_format($detail->sell_val, 2, ',', '.') }}</td>
                                                    <td align="right">{{ number_format($detail->vat, 2, ',', '.') }}</td>
                                                    <td align="right">{{ number_format($detail->pph23, 2, ',', '.') }}</td>
                                                    <td align="right">{{ number_format($detail->subtotal, 2, ',', '.') }}</td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="8" class="text-right">Total</td>
                                                <td class="text-right">{{ number_format($total_before_vat, 2, ',', '.') }}</td>
                                                <td class="text-right">{{ number_format($header->total_vat, 2, ',', '.') }}</td>
                                                <td class="text-right">{{ number_format($header->pph23, 2, ',', '.') }}</td>
                                                <td class="text-right">{{ number_format($total_invoice, 2, ',', '.') }}</td>
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
    </script>
@endpush
@endsection
