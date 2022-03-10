@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Cash In</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Cash In</li>
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
                    <a class="btn btn-primary btn-sm" href="{{ route('kas.masuk.add') }}"><i class="fa fa-plus"></i> Add Transaction</a>
                </div>
                <div class="flash-data" data-flashdata="{{ session('status') }}">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th>Account No.</th>
                                <th>Memo</th>
                                <th>Client</th>
                                <th>Transaction No.</th>
                                <th>Transaction Date</th>
                                <th>Currency</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 14px">
                            @foreach ($kas_masuk as $key => $km)
                                <tr>
                                    <td align="center">{{ ($key + 1) }}</td>
                                    <td>{{ date('d/m/Y', strtotime($km->kas_masuk_date)) }}</td>
                                    <td>{{ $km->account_number }}</td>
                                    <td>{{ $km->memo }}</td>
                                    <td>{{ $km->client_name }}</td>
                                    <td>{{ $km->transaction_no }}</td>
                                    <td>{{ date('d/m/Y', strtotime($km->transaction_date)) }}</td>
                                    <td align="center">{{ $km->currency_code }}</td>
                                    <td align="right">{{ number_format($km->total, 2, ',', '.') }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="{{ route('kas.masuk.view', ['id' => $km->id]) }}" >
                                            <i class="fa fa-file-alt"></i> View
                                        </a>
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
