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
                        {{-- <a class="btn btn-primary btn-sm" href="{{ route('journal.add') }}"><i
                                class="fa fa-plus"></i>
                            Add General Ledger</a> --}}
                    </div>
                    <div class="flash-data" data-flashdata="{{ session('status') }}">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="accordion" id="accordionExample">
                                        <div class="row">
                                            <div class="col">
                                                <h5>Account</h5>
                                            </div>
                                            <div class="col" align="right">
                                                <h5>Debit</h5>
                                            </div>
                                            <div class="col" align="right">
                                                <h5>Credit</h5>
                                            </div>
                                            <div class="col" align="right">
                                                <h5>Balance</h5>
                                            </div>
                                        </div>
                                        @php
                                            $grand_total_debit = 0;
                                            $grand_total_credit = 0;
                                            $grand_total_balance = 0;
                                        @endphp
                                        @foreach ($accounts as $key => $account)
                                        <div class="card">
                                            <div class="card-header" id="heading_{{ $key }}">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left" type="button"
                                                        data-toggle="collapse" data-target="#collapse_{{ $key }}"
                                                        aria-expanded="true" aria-controls="collapse_{{ $key }}"
                                                        onclick="loadDetail({{ $key }}, {{ $account->id }})">
                                                        <div class="row">
                                                            <div class="col">
                                                                {{ $account->account_number.' '.$account->account_name }}
                                                            </div>
                                                            <div class="col" align="right">
                                                                {{ number_format($account->total_debit, 2, ',', '.') }}
                                                            </div>
                                                            <div class="col" align="right">
                                                                {{ number_format($account->total_credit, 2, ',', '.') }}
                                                            </div>
                                                            <div class="col" align="right">
                                                                {{ number_format($account->total_balance, 2, ',', '.') }}
                                                            </div>
                                                        </div>
                                                    </button>
                                                    @php
                                                        $grand_total_debit += $account->total_debit;
                                                        $grand_total_credit += $account->total_credit;
                                                        $grand_total_balance += $account->total_balance;
                                                    @endphp
                                                </h2>
                                            </div>

                                            <div id="collapse_{{ $key }}" class="collapse"
                                                aria-labelledby="heading_{{ $key }}" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <table id="" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Date</th>
                                                                <th>Journal No.</th>
                                                                <th style="text-align: right;">Debit</th>
                                                                <th style="text-align: right;">Credit</th>
                                                                <th style="text-align: right;">Balance</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody_{{ $key }}" style="font-size: 14px">
                                                            <div
                                                                class="align-items-center bg-white justify-content-center spinner_load" id="spinner_{{ $key }}">
                                                                <div class="spinner-border" role="status">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                            </div>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="row">
                                            <div class="col">
                                                &nbsp;
                                            </div>
                                            <div class="col" align="right">
                                                {{ number_format($grand_total_debit, 2, ',', '.') }}
                                            </div>
                                            <div class="col" align="right">
                                                {{ number_format($grand_total_credit, 2, ',', '.') }}
                                            </div>
                                            <div class="col" align="right">
                                                {{ number_format($grand_total_balance, 2, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
</section>
@endsection

@push('after-scripts')
<script>
    function loadDetail(key, accountId) {
        $('#spinner_'+key).show();
        $.ajax({
            type: 'post',
            url: `{{ route('general_ledger.loadDetail') }}`,
            data: {
                account_id: accountId,
            },
            success: function(result) {
                console.log(result);
                $('#spinner_'+key).hide();
                $('#tbody_'+key).html(result);
            }
        });
    }
</script>
@endpush
