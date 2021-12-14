@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Journal</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Journal</li>
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
                        <a class="btn btn-primary btn-sm" href="{{ route('journal.add') }}"><i class="fa fa-plus"></i>
                            Add Journal</a>
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
                                        <th>Currency</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 14px">
                                    @foreach ($journals as $key => $journal)
                                    <tr>
                                        <td>{{ ($key + 1) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($journal->journal_date)) }}</td>
                                        <td>{{ $journal->journal_no }}</td>
                                        <td>{{ $journal->currency_code }}</td>
                                        <td>{{ number_format($journal->amount, 2, ',', '.') }}</td>
                                        <td>
                                            @if ($journal->flag_post == 0)
                                            <span class="badge bg-warning">Draft</span>
                                            @else
                                            <span class="badge bg-success">Post</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($journal->flag_post == 0)
                                            <a class="btn btn-info btn-sm" href="{{ route('journal.edit', ['id' => $journal->id]) }}" >
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            @endif
                                            <a class="btn btn-primary btn-sm" href="{{ route('journal.view', ['id' => $journal->id]) }}" >
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
