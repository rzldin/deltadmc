@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>General Ledger</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">General Ledger</li>
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
                        {{-- <a class="btn btn-primary btn-sm" href="{{ route('journal.add') }}"><i class="fa fa-plus"></i>
                            Add General Ledger</a> --}}
                    </div>
                    <div class="flash-data" data-flashdata="{{ session('status') }}">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Date</th>
                                        <th>Journal No.</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 14px">

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
