@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Cash Transfer</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Cash Transfer</li>
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
                    <a class="btn btn-primary btn-sm" href="{{ route('kas.transfer.add') }}"><i class="fa fa-plus"></i> Add Transaction</a>
                </div>
                <div class="flash-data" data-flashdata="{{ session('status') }}">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th rowspan="2">No.</th>
                                <th rowspan="2">Date</th>
                                <th colspan="2" style="text-align: center;">Account No.</th>
                                <th rowspan="2">Memo</th>
                                <th rowspan="2">Reference</th>
                                <th rowspan="2">Amount</th>
                            </tr>
                            <tr>
                                <th>From</th>
                                <th>To</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 14px">
                            @foreach ($kas_transfers as $key => $kt)
                                <tr>
                                    <td>{{ ($key + 1) }}</td>
                                    <td>{{ date('d/m/Y', strtotime($kt->transfer_date)) }}</td>
                                    <td>{{ $kt->from_account_number }}</td>
                                    <td>{{ $kt->to_account_number }}</td>
                                    <td>{{ $kt->memo }}</td>
                                    <td>{{ $kt->reference }}</td>
                                    <td>{{ number_format($kt->amount, 2, ',', '.') }}</td>
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
