@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Piutang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Piutang</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="flash-data" data-flashdata="{{ session('status') }}">
                        </div>
                        <form action="{{ route('piutang.index') }}" method="get" id="formSearch">
                            <div class="row">
                                <div class="col-5">
                                    <div class="row form-group">
                                        <div class="col-4">
                                            Customer
                                        </div>
                                        <div class="col-8">
                                            <select class="form-control" name="client_id" id="client_id" onchange="$('#formSearch').submit()">
                                                <option value="">All</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}" <?= ($company->id == $search['client_id'] ? 'selected' : '') ?>>
                                                        {{ $company->client_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-4">
                                            Booking No.
                                        </div>
                                        <div class="col-8">
                                            <select class="form-control" name="booking_id" id="booking_id" onchange="$('#formSearch').submit()">
                                                <option value="">All</option>
                                                @foreach ($bookings as $booking)
                                                    <option value="{{ $booking->id }}" <?= ($booking->id == $search['booking_id'] ? 'selected' : '') ?>>
                                                        {{ $booking->booking_no }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1"></div>
                                <div class="col-6">
                                    <div class="row form-group">
                                        <div class="col-4">
                                            Type
                                        </div>
                                        <div class="col-8">
                                            <select class="form-control" name="invoice_type" id="invoice_type" onchange="$('#formSearch').submit()">
                                                <option value="">All</option>
                                                <option value="REG" <?= ("REG" == $search['invoice_type'] ? 'selected' : '') ?>>Reguler</option>
                                                <option value="REM" <?= ("REM" == $search['invoice_type'] ? 'selected' : '') ?>>Reimbursement</option>
                                                <option value="DN" <?= ("DN" == $search['invoice_type'] ? 'selected' : '') ?>>Debit Note</option>
                                                <option value="CN" <?= ("CN" == $search['invoice_type'] ? 'selected' : '') ?>>Credit Note</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        {{-- <div class="col-4">
                                            Charging Type
                                        </div>
                                        <div class="col-8">
                                            <select class="form-control" name="charge_code_id" id="charge_code_id">
                                                <option value="">All</option>
                                            </select>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <a class="btn btn-primary btn-sm" href="{{ route('kas.keluar.add') }}"><i
                                class="fa fa-plus"></i> Add Transaction</a> --}}
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Bill To</th>
                                    <th>Booking No.</th>
                                    <th>Invoice No.</th>
                                    <th>Proforma No.</th>
                                    <th>Invoice outgoing No.</th>
                                    <th>Date</th>
                                    <th>Saldo</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody style="font-size: 14px">
                                @foreach ($acc_receivables as $key => $ar)
                                    <tr>
                                        <td align="center">{{ ($key + 1) }}</td>
                                        <td>{{ $ar->client_code }}</td>
                                        <td>{{ $ar->booking_no }}</td>
                                        <td>{{ $ar->invoice_no }}</td>
                                        <td>{{ $ar->proforma_invoice_no }}</td>
                                        <td>{{ $ar->external_invoice_no }}</td>
                                        <td>{{ date('d/m/Y', strtotime($ar->external_invoice_date)) }}</td>
                                        <td align="right">{{ number_format(($ar->total_invoice - $ar->invoice_bayar), 2, ',', '.') }}</td>
                                        {{-- <td></td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
</section>
@endsection

@push('after-scripts')
<script>
</script>
@endpush
