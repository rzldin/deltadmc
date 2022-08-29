@extends('layouts.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Deposit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Deposit</li>
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
                            <div class="d-flex justify-content-between bd-highlight mb-3">
                                <div class="p-2 bd-highlight">
                                    <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick="addDeposit()"><i class="fa fa-plus"></i> Add Transaction</a>
                                </div>
                                <div class="p-2 bd-highlight">
                                    <h3>Saldo : {{ number_format($saldo->saldo, 2, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="flash-data" data-flashdata="{{ session('status') }}">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Jenis</th>
                                            <th>Company</th>
                                            <th>Currency</th>
                                            <th>Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px">
                                        @forelse ($deposits as $deposit)
                                            <tr>
                                                <td align="center">{{ $loop->iteration }}</td>
                                                @if($deposit->jenis_trx==0)
                                                    <td style="background-color: green; color: #fff">Pemasukan</td>
                                                @else
                                                    <td style="background-color: red; color: #fff">Pengeluaran</td>
                                                @endif
                                                <td>{{ $deposit->client_name }}</td>
                                                <td>{{ $deposit->code }}</td>
                                                <td align="right">{{ number_format($deposit->balance, 2, ',', '.') }}</td>
                                                <td></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" align="center">No data available!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
        <div class="modal fade modal-deposit" id="modal-deposit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form method="post" action="{{ route('deposit.save') }}">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-md-4">
                                Date
                            </div>
                            <div class="col-md-8">
                                <div class="input-group date" id="deposit_date_picker" data-target-input="nearest">
                                    <input type="text" name="deposit_date" id="deposit_date" class="form-control datetimepicker-input" data-target="#deposit_date_picker" value="" />
                                    <div class="input-group-append" data-target="#deposit_date_picker" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Company
                            </div>
                            <div class="col-md-8">
                                <select class="form-control" name="company_id" id="company_id" onchange="getCurrency(this.value)">
                                    <option value="" selected>Select Client</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Currency <font color="red">*</font></label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control select2bs44" name="currency_id" id="currency_id">
                                    <option value="" selected>-- Select Valuta --</option>
                                    @foreach ($currency as $item)
                                        <option value="{{ $item->id }}">{{ $item->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Amount
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="amount" id="amount" class="form-control" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
@endsection

@push('after-scripts')
    <script>
        function clearFields() {
            $('#id').val(0);
            $('#currency_id').val('');
            $('#company_id').val('');
            $('#amount').val(0);
        }

        function addDeposit() {
            clearFields();
            $('#modal-title').text('Add deposit');
            $('#modal-deposit').modal('show');
        }

        function getCurrency(id) {
            $.ajax({
                type: 'post',
                url: `{{ route('master.company_get') }}`,
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(result) {
                    $('#currency_id').val(result['main_currency']).change();
                }
            });
        }

        $(function() {
            $('#deposit_date_picker').datetimepicker({
                format: 'L'
            });
        });
    </script>
@endpush
