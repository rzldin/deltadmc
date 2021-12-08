@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus"></i>
                    Cash In
                </h1>
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
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-right">
                            <strong></strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('kas.masuk.save') }}"
                            id="formKasMasuk">
                            @csrf
                            <input type="hidden" name="id">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Cash In</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Date</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group date" id="kas_masuk_date_picker"
                                                        data-target-input="nearest">
                                                        <input type="text" name="kas_masuk_date"
                                                            id="kas_masuk_date"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#kas_masuk_date_picker" value="{{ date('d/m/Y') }}" />
                                                        <div class="input-group-append" data-target="#kas_masuk_date_picker"
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
                                                    <select class="form-control" name="account_id" id="account_id">
                                                        <option value="" selected>Select Account</option>
                                                        @foreach ($kas_accounts as $kas_account)
                                                            <option value="{{ $kas_account->id }}">{{ $kas_account->account_number.' - '.$kas_account->account_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Client</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="client_id" id="client_id">
                                                        <option value="" selected>Select Client</option>
                                                        @foreach ($companies as $company)
                                                            <option value="{{ $company->id }}">{{ $company->client_name }}</option>
                                                        @endforeach
                                                    </select>
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
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Transacton No.</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" name="transaction_no" id="transaction_no" class="form-control">
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
                                                            data-target="#transaction_date_picker" value="" />
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
                                                    <input type="text" id="total_txt" class="form-control" value="0" readonly>
                                                    <input type="hidden" name="total" id="total" class="form-control" value="0" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <input type="checkbox" name="giro" id="giro" onchange="checkGiro()"> Giro
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Giro No.</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" name="no_giro" id="no_giro" disabled/>
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
                                                                        data-target="#due_date_picker" value="" />
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
                                                                <input type="text" class="form-control" name="bank" id="bank" disabled/>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label>Bank Account</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" name="bank_account" id="bank_account" disabled/>
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
                                    <table class="table table-bordered table-striped" id="myTable2" style="width: 150%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Account No.</th>
                                                <th>Account Name</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblDtl">

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>#</td>
                                                <td>
                                                    <select class="form-control select2" id="dtl_account_id" onchange="getDetailAccount(this.value)">
                                                        <option value=""></option>
                                                        @foreach ($accounts as $account)
                                                            <option value="{{ $account->id }}">{{ $account->account_number.' || '.$account->account_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="hidden" id="dtl_account_number">
                                                    <input type="text" id="dtl_account_name" class="form-control" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" id="dtl_amount" class="form-control" value="0">
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" class="btn btn-xs btn-success" onclick="saveDetailKasMasuk()">
                                                        <i class="fa fa-save"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
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
        function checkGiro() {
            let no_giro = $('#no_giro');
            let due_date = $('#due_date');
            let bank = $('#bank');
            let bank_account = $('#bank_account');
            if ($('#giro').is(':checked')) {
                no_giro.attr('disabled', false);
                due_date.attr('disabled', false);
                bank.attr('disabled', false);
                bank_account.attr('disabled', false);
            } else {
                no_giro.attr('disabled', true);
                due_date.attr('disabled', true);
                bank.attr('disabled', true);
                bank_account.attr('disabled', true);
            }
        }

        function getDetailAccount(id) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: `{{ route('master.account_get') }}`,
                data: {
                    id: id,
                },
                success: function(result) {
                    $('#dtl_account_number').val(result['account_number']);
                    $('#dtl_account_name').val(result['account_name']);
                }
            });
        }

        function loadDetailKasMasuk() {
            $.ajax({
                type: 'post',
                url: `{{ route('kas.masuk.loadDetail') }}`,
                success: function(result) {
                    $('#tblDtl').html(result);
                    calculateTotal();
                }
            });
        }

        function saveDetailKasMasuk() {
            let account_id = $('#dtl_account_id');
            let account_number = $('#dtl_account_number');
            let account_name = $('#dtl_account_name');
            let amount = $('#dtl_amount');

            if (account_number.val() == '') {
                showToast('warning', 'Please select account number!');
            } else {
                $.ajax({
                    type: 'post',
                    url: `{{ route('kas.masuk.saveDetail') }}`,
                    data: {
                        account_id: account_id.val(),
                        account_number: account_number.val(),
                        account_name: account_name.val(),
                        amount: amount.val(),
                    },
                    success: function() {
                        loadDetailKasMasuk();
                        account_id.val('');
                        account_id.select2();
                        account_number.val('');
                        account_name.val('');
                        amount.val(0);
                        showToast('success', 'Detail saved!');
                    }
                });
            }

        }

        function deleteDetailKasMasuk(key) {
            $.ajax({
                type: 'post',
                url: `{{ route('kas.masuk.deleteDetail') }}`,
                data: {
                    key: key,
                },
                success: function() {
                    loadDetailKasMasuk();
                    showToast('success', 'Detail deleted!');
                }
            });
        }

        function calculateTotal() {
            let subtotal = $('#subtotal').val();
            let subtotal_txt = $('#subtotal_txt').val();
            $('#total_txt').val(subtotal_txt);
            $('#total').val(subtotal);
        }

        function showToast(type, message) {
            Toast.fire({
                icon: type,
                title: message
            });
        }

        $(function() {
            $('.select2').select2();
            loadDetailKasMasuk();
            $('#kas_masuk_date_picker').datetimepicker({
                format: 'L'
            });
            $('#transaction_date_picker').datetimepicker({
                format: 'L'
            });
            $('#due_date_picker').datetimepicker({
                format: 'L'
            });
            checkGiro();
        });
    </script>
@endpush
@endsection
