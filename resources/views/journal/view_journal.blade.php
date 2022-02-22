@extends('layouts.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-plus"></i>
                        Journal
                    </h1>
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
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title float-right">
                                <strong></strong>
                            </h3>
                        </div>
                        <form method="post" action="{{ route('journal.post') }}" id="formJournal">
                            <div class="card-body">
                                @csrf
                                <input type="hidden" name="id" value="{{ $header->id }}">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Journal</h3>
                                        @if ($header->flag_post == 1)
                                            <span class="float-right badge bg-danger">Post</span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Date</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="input-group date" id="journal_date_picker" data-target-input="nearest">
                                                            <input type="text" name="journal_date" id="journal_date" class="form-control datetimepicker-input" data-target="#journal_date_picker"
                                                                value="{{ date('d/m/Y', strtotime($header->journal_date)) }}" readonly />
                                                            <div class="input-group-append" data-target="#journal_date_picker" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Journal Type</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="journal_type" id="journal_type" value="{{ $header->journal_type }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Company</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="client_name" id="client_name" value="{{ $header->client_name }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Invoice</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="invoice_no_deposit" id="invoice_no_deposit" value="{{ $header->invoice_no_deposit }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="col-md-5">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Journal No.</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="journal_no" id="journal_no" value="{{ $header->journal_no }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label>Currency</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select class="form-control" name="currency_id" id="currency_id" disabled>
                                                            <option value="">Select Currency</option>
                                                            @foreach ($currency as $curr)
                                                                <option value="{{ $curr->id }}" <?= $curr->id == $header->currency_id ? 'selected' : '' ?>>{{ $curr->code }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Detail</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-bordered table-striped" id="myTable2" style="width: 150%">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Account No.</th>
                                                            <th>Account Name</th>
                                                            <th>Debit</th>
                                                            <th>Kredit</th>
                                                            <th>Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tblDtl">
                                                        @foreach ($details as $key => $detail)
                                                            <tr>
                                                                <td align="center">{{ $key + 1 }}</td>
                                                                <td>{{ $detail->account_number }}</td>
                                                                <td>{{ $detail->account_name }}</td>
                                                                <td align="right">{{ number_format($detail->debit, 2, '.', ',') }}</td>
                                                                <td align="right">{{ number_format($detail->credit, 2, '.', ',') }}</td>
                                                                <td>{{ $detail->memo }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12" style="text-align: right">
                                                @if ($header->flag_post == 0)
                                                    <a class="btn btn-primary" href="javascript:void(0)" onclick="$('#formJournal').submit()">
                                                        <i class="fa fa-paper-plane"></i> Post
                                                    </a>
                                                @endif
                                                <a href="{{ route('journal.index') }}" class="btn btn-danger">Back</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    @push('after-scripts')
        <script>
        </script>
    @endpush
@endsection
