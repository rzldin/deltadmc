@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Invoice List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Invoice List</li>
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
                <div class="card-header">
                    {{-- <a class="btn btn-primary btn-sm" href="{{ route('quotation.list') }}"><i class="fa fa-plus"></i> Create Booking</a> --}}
                </div>
                <div class="flash-data" data-flashdata="{{ session('status') }}">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Invoice No.</th>
                                <th>Date</th>
                                <th>Jenis</th>
                                <th>Booking Number</th>
                                <th>Booking Date</th>
                                <th>Shipper</th>
                                <th>Consignee</th>
                                <th>Client</th>
                                <th>Activity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 14px">
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                <td><?=($invoice->tipe_inv==0)?'Piutang':'Hutang';?></td>
                                <td>{{ $invoice->booking_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->booking_date)->format('d/m/Y') }}</td>
                                <td>{{ $invoice->company_d }}</td>
                                <td>{{ $invoice->company_c }}</td>
                                <td>{{ $invoice->company_b }}</td>
                                <td>{{ $invoice->activity }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('invoice.view', ['id' => $invoice->id]) }}" ><i class="fa fa-file-alt"></i>  &nbsp;View &nbsp; &nbsp; &nbsp;</a>
                                    @if ($invoice->proforma_invoice_id == 0 && $invoice->tipe_inv == 0)
                                        <a class="btn btn-info btn-sm" href="{{ route('proforma_invoice.create', ['invoiceId' => $invoice->id]) }}"><i class="fa fa-paper-plane"></i> Pro. Inv. </a>
                                    @endif
                                    @if ($invoice->journal_id == 0)
                                        <a class="btn btn-secondary btn-sm" href="{{ route('journal.add') }}?reference_no={{ $invoice->invoice_no }}&reference_id={{ $invoice->id }}&client_id={{ $invoice->client_id }}&source=invoice">
                                                <i class="fa fa-book"></i> Journal
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('after-scripts')
    <script>
    </script>
@endpush
