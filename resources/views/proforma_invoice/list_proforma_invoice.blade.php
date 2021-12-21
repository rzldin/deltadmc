@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Proforma Invoice List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Proforma Invoice List</li>
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
                                <th>Proforma Invoice No.</th>
                                <th>Date</th>
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
                            @foreach ($proforma_invoices as $proforma_invoice)
                            <tr>
                                <td>{{ $proforma_invoice->proforma_invoice_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($proforma_invoice->proforma_invoice_date)->format('d/m/Y') }}</td>
                                <td>{{ $proforma_invoice->booking_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($proforma_invoice->booking_date)->format('d/m/Y') }}</td>
                                <td>{{ $proforma_invoice->company_d }}</td>
                                <td>{{ $proforma_invoice->company_c }}</td>
                                <td>{{ $proforma_invoice->company_b }}</td>
                                <td>{{ $proforma_invoice->activity }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('proforma_invoice.view', ['id' => $proforma_invoice->id]) }}" ><i class="fa fa-file-alt"></i>  &nbsp;View &nbsp; &nbsp; &nbsp;</a>
                                        @if ($proforma_invoice->t_external_invoice_id == 0)
                                    <a class="btn btn-info btn-sm" href="{{ route('proforma_invoice.edit', ['proformaInvoiceId' => $proforma_invoice->id]) }}"><i class="fa fa-edit"></i> Edit </a>
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
