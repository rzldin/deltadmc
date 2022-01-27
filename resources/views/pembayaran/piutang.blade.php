@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Pembayaran Piutang</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Invoice Sell List</li>
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
                    <a class="btn btn-primary btn-sm" href="{{ route('pembayaran.add_piutang') }}"><i class="fa fa-plus"></i> Create Pembayaran Piutang</a>
                </div>
                <div class="flash-data" data-flashdata="{{ session('status') }}">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No Pembayaran</th>
                                <th>Date</th>
                                <th>Nilai PMB</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 14px">
                            @foreach ($pembayaran as $pmb)
                            <tr>
                                <td>{{ $pmb->no_pembayaran }}</td>
                                <td>{{ \Carbon\Carbon::parse($pmb->pmb_date)->format('d/m/Y') }}</td>
                                <td>{{ number_format($pmb->nilai_pmb,2,',','.') }}</td>
                                {{-- <td> --}}
                                    {{-- <a class="btn btn-primary btn-sm" href="{{ route('pembayaran.view', ['id' => $pmb->id]) }}" ><i class="fa fa-file-alt"></i>  &nbsp;View &nbsp; &nbsp; &nbsp;</a> --}}
                                {{-- </td> --}}
                                <td>
                                    <a class="btn btn-danger btn-sm" href="{{ route('pembayaran.cancel', $pmb->id) }}" ><i class="fa fa-undo"></i>  Cancel</a>
                                    @if ($pmb->journal_id == 0)
                                        <a class="btn btn-secondary btn-sm" href="{{ route('journal.add') }}?reference_no={{ $pmb->no_pembayaran }}&reference_id={{ $pmb->id }}&client_id={{ $pmb->id_company }}&source=pembayaran">
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
