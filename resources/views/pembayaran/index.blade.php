@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Pembayaran Hutang</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Invoice Cost List</li>
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
                    <a class="btn btn-primary btn-sm" href="{{ route('pembayaran.add') }}"><i class="fa fa-plus"></i> Create Pembayaran</a>
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
