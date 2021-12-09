@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus"></i>
                    Cash Transfer
                </h1>
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
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-right">
                            <strong></strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('kas.transfer.save') }}"
                            id="formKasTransfer">
                            @csrf
                            <input type="hidden" name="id">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Cash Transfer</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Date</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group date" id="transfer_date_picker"
                                                        data-target-input="nearest">
                                                        <input type="text" name="transfer_date"
                                                            id="transfer_date"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#transfer_date_picker" value="{{ date('d/m/Y') }}" />
                                                        <div class="input-group-append" data-target="#transfer_date_picker"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>From Account</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control select2" name="from_account_id" id="from_account_id">
                                                        <option value="" selected>Select Account</option>
                                                        @foreach ($accounts as $account)
                                                            <option value="{{ $account->id }}">{{ $account->account_number.' - '.$account->account_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>To Account</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control select2" name="to_account_id" id="to_account_id">
                                                        <option value="" selected>Select Account</option>
                                                        @foreach ($accounts as $account)
                                                            <option value="{{ $account->id }}">{{ $account->account_number.' - '.$account->account_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Reference</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="reference" id="reference">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Amount</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="number" class="form-control" name="amount" id="amount" value="0">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Memo</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" name="memo" id="memo" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align: right">
                                    <a href="{{ url()->previous() }}" class="btn btn-danger" >Back</a>
                                    <button type="submit" class="btn btn-primary">Save</button>
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
        $(function() {
            $('.select2').select2();
            $('#transfer_date_picker').datetimepicker({
                format: 'L'
            });
        });
    </script>
@endpush
@endsection
