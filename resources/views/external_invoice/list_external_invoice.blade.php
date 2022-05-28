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
                                            <th>Booking Number</th>
                                            <th>Booking Date</th>
                                            <th>Client</th>
                                            <th>Shipper</th>
                                            <th>Consignee</th>
                                            <th>Activity</th>
                                            <th>Status Pembayaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px">
                                        @foreach ($external_invoices as $invoice)
                                            <tr>
                                                <td>{{ $invoice->external_invoice_no }}</td>
                                                <td>{{ \Carbon\Carbon::parse($invoice->external_invoice_date)->format('d/m/Y') }}</td>
                                                <td>{{ $invoice->booking_no }}</td>
                                                <td>{{ \Carbon\Carbon::parse($invoice->booking_date)->format('d/m/Y') }}</td>
                                                <td>{{ $invoice->company_b }}</td>
                                                <td>{{ $invoice->company_d }}</td>
                                                <td>{{ $invoice->company_c }}</td>
                                                <td>{{ $invoice->activity }}</td>
                                                <td>
                                                    @if ($invoice->flag_bayar == 0)
                                                        <span class="badge bg-danger">Draft</span>
                                                    @elseif ($invoice->flag_bayar == 1)
                                                        <span class="badge bg-success">Paid</span>
                                                    @else
                                                        <span class="badge bg-warning">Partially Paid</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($invoice->flag_bayar == 0)
                                                    <a class="btn btn-info btn-sm" href="{{ route('external_invoice.edit', ['id' => $invoice->id]) }}"><i class="fa fa-edit"></i> Edit </a>
                                                    <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="deleteInvoice({{ $invoice->id }})"><i class="fa fa-trash"></i> Delete</a>
                                                    @endif
                                                    &nbsp;
                                                    <a class="btn btn-primary btn-sm" href="{{ route('external_invoice.view', ['id' => $invoice->id]) }}"><i class="fa fa-file-alt"></i> View</a>
                                                    {{-- <a class="btn btn-info btn-sm" href="{{ route('external_invoice.create', ['invoiceId' => $invoice->id]) }}"><i class="fa fa-paper-plane"></i> Ext. Inv. </a> --}}
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
        function deleteInvoice(id) {
            let url = `{{ route('external_invoice.delete', ':id') }}`;
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }
    </script>
@endpush
