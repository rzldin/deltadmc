@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus"></i>
                    Kas Keluar
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Kas Keluar</li>
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
                    <div class="card-body">
                        <form method="post" action="{{ route('kas.keluar.save') }}"
                            id="formKaskeluar">
                            @csrf
                            <input type="hidden" name="id">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Kas Keluar</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Date</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group date" id="kas_keluar_date_picker"
                                                        data-target-input="nearest">
                                                        <input type="text" name="kas_keluar_date"
                                                            id="kas_keluar_date"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#kas_keluar_date_picker" value="{{ date('d/m/Y', strtotime($header->kas_keluar_date)) }}" readonly />
                                                        <div class="input-group-append" data-target="#kas_keluar_date_picker"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Account</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="account_id" id="account_id" disabled>
                                                        <option value="" selected>Select Account</option>
                                                        @foreach ($kas_accounts as $kas_account)
                                                            <option value="{{ $kas_account->id }}" <?= ($header->account_id == $kas_account->id ? 'selected' : '') ?>>{{ $kas_account->account_number.' - '.$kas_account->account_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Client</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="client_id" id="client_id" disabled>
                                                        <option value="" selected>Select Client</option>
                                                        @foreach ($companies as $company)
                                                            <option value="{{ $company->id }}" <?= ($header->client_id == $company->id ? 'selected' : '') ?>>{{ $company->client_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Memo</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" name="memo" id="memo" cols="30" rows="5" readonly>{{ $header->memo }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Transacton No.</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" name="transaction_no" id="transaction_no" class="form-control" value="{{ $header->transaction_no }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Transaction Date</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group date" id="transaction_date_picker"
                                                        data-target-input="nearest">
                                                        <input type="text" name="transaction_date" id="transaction_date"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#transaction_date_picker" value="{{ date('d/m/Y', strtotime($header->kas_keluar_date)) }}"  readonly/>
                                                        <div class="input-group-append" data-target="#transaction_date_picker"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Total</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" id="total_txt" class="form-control" value="{{ number_format($header->total, 2, ',', '.') }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <input type="checkbox" name="giro" id="giro" <?= ($header->no_giro == '' ? '' : 'checked') ?> disabled> Giro
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Giro No.</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" name="no_giro" id="no_giro" value="{{ $header->no_giro }}" disabled/>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Due Date</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="input-group date" id="due_date_picker"
                                                                    data-target-input="nearest">
                                                                    <input type="text" name="due_date" id="due_date" disabled
                                                                        class="form-control datetimepicker-input"
                                                                        data-target="#due_date_picker" value="{{ ($header->due_date == '' ? '' : date('d/m/Y', strtotime($header->due_date))) }}" />
                                                                    <div class="input-group-append" data-target="#due_date_picker"
                                                                        data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Bank</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" name="bank" id="bank" value="{{ $header->bank }}" disabled/>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Bank Account</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" name="bank_account" id="bank_account" value="{{ $header->bank_account }}" disabled/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="card-title">Detail</h5>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-bordered table-striped" id="myTable2" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Account No.</th>
                                                <th>Account Name</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($details as $key => $detail)
                                                <tr>
                                                    <td align="center">{{ ($key + 1) }}</td>
                                                    <td>{{ $detail->account_number }}</td>
                                                    <td>{{ $detail->account_name }}</td>
                                                    <td align="right">{{ number_format($detail->amount, 2, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align: right">
                                    <a href="{{ url()->previous() }}" class="btn btn-primary" >Back</a>
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
