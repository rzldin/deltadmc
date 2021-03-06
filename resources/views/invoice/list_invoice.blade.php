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
                                <th>Client</th>
                                <th>Shipper</th>
                                <th>Consignee</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Activity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 14px">
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td style="text-align: right;">{{ $invoice->invoice_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                <td><?=($invoice->tipe_inv==0)?'Piutang':'Hutang';?></td>
                                <td>{{ $invoice->booking_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->booking_date)->format('d/m/Y') }}</td>
                                <td>{{ $invoice->company_b }}</td>
                                <td>{{ $invoice->company_d }}</td>
                                <td>{{ $invoice->company_c }}</td>
                                <td style="text-align: right;">{{ number_format($invoice->total_invoice,2,',','.') }}</td>
                                @if($invoice->tipe_inv == 1)<!-- Hutang -->
                                    @if ($invoice->flag_bayar == 0)
                                        <td class="bg-secondary text-center">Draft</td>
                                    @elseif($invoice->flag_bayar == 2)
                                        <td class="bg-success text-center">Partially Paid</td>
                                    @else
                                        <td class="bg-success text-center">Paid</td>
                                    @endif
                                @else<!-- Piutang -->
                                    @if($invoice->proforma_invoice_id == 0)
                                        <td class="bg-secondary text-center">Draft</td>
                                    @else
                                        <td class="bg-success text-center">Proforma Created</td>
                                    @endif
                                @endif
                                <td>{{ $invoice->activity }}</td>
                                <td>
                                    <a class="mb-1 btn btn-primary btn-xs" href="{{ route('invoice.view', ['id' => $invoice->id]) }}" ><i class="fa fa-file-alt"></i>  &nbsp;View &nbsp; &nbsp; &nbsp;</a>
                                    @if($invoice->tipe_inv == 0)
                                        @if ($invoice->proforma_invoice_id == 0)
                                            <a class="mb-1 btn btn-info btn-xs" href="{{ route('proforma_invoice.create', ['invoiceId' => $invoice->id]) }}"><i class="fa fa-paper-plane"></i> Pro. Inv. </a>
                                        @endif
                                        @if ($invoice->journal_id == 0)
                                            <a class="mb-1 btn btn-secondary btn-xs" href="{{ route('journal.add') }}?reference_no={{ $invoice->invoice_no }}&reference_id={{ $invoice->id }}&client_id={{ $invoice->client_id }}&source=invoice">
                                                    <i class="fa fa-book"></i> Journal
                                            </a>
                                        @else
                                            <a class="btn btn-primary btn-xs" href="{{ route('journal.view', ['id' => $invoice->journal_id]) }}">
                                                <i class="fa fa-file-alt"></i> View Journal
                                            </a>
                                        @endif
                                        @if($invoice->flag_bayar_external == 0 && $invoice->journal_id == 0)
                                            <a class="mb-1 btn btn-success btn-xs" href="{{ route('invoice.edit', ['id' => $invoice->id]) }}" ><i class="fa fa-edit"></i>  &nbsp;Edit &nbsp; &nbsp; &nbsp;</a>
                                            @if($invoice->proforma_invoice_id==0)
                                            <a class="mb-1 btn btn-danger btn-xs" href="javascript:void(0);" onclick="deleteInvoice({{ $invoice->id }})" ><i class="fa fa-trash"></i>  &nbsp;Delete &nbsp; &nbsp; &nbsp;</a>
                                            @endif
                                        @endif
                                    @else
                                        @if ($invoice->journal_id == 0)
                                            <a class="mb-1 btn btn-secondary btn-xs" href="{{ route('journal.add') }}?reference_no={{ $invoice->invoice_no }}&reference_id={{ $invoice->id }}&client_id={{ $invoice->client_id }}&source=invoice">
                                                    <i class="fa fa-book"></i> Journal
                                            </a>
                                        @else
                                            <a class="btn btn-primary btn-xs" href="{{ route('journal.view', ['id' => $invoice->journal_id]) }}">
                                                <i class="fa fa-file-alt"></i> View Journal
                                            </a>
                                        @endif
                                        @if($invoice->flag_bayar==0 && $invoice->journal_id == 0)
                                            <a class="mb-1 btn btn-success btn-xs" href="{{ route('invoice.edit', ['id' => $invoice->id]) }}" ><i class="fa fa-edit"></i>  &nbsp;Edit &nbsp; &nbsp; &nbsp;</a>
                                            <a class="mb-1 btn btn-danger btn-xs" href="javascript:void(0);" onclick="deleteInvoice({{ $invoice->id }})" ><i class="fa fa-trash"></i>  &nbsp;Delete </a>
                                        @endif
                                        @if($invoice->currency!=65)
                                            <a class="mb-1 btn btn-info btn-xs" href="{{ route('invoice.view_selisih', ['id' => $invoice->id]) }}"><i class="fas fa-chart-bar"></i> Selisih</a>
                                        @endif
                                    @endif
                                            <a class="mb-1 btn btn-default btn-xs" href="{{ route('invoice.print', ['id' => $invoice->id]) }}" target="_blank"><i class="fa fa-print"></i>  &nbsp;Print </a>
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
            let url = `{{ route('invoice.delete', ':id') }}`;
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
