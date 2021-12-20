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
                    <form method="post" action="{{ route('journal.save') }}" id="formJournal">
                        <div class="card-body">
                            @csrf
                            <input type="hidden" name="id" value="0">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Journal</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Date</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group date" id="journal_date_picker"
                                                        data-target-input="nearest">
                                                        <input type="text" name="journal_date" id="journal_date"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#journal_date_picker"
                                                            value="{{ date('d/m/Y') }}" />
                                                        <div class="input-group-append"
                                                            data-target="#journal_date_picker"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Journal No.</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="journal_no"
                                                        id="journal_no">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Currency</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="currency_id" id="currency_id">
                                                        <option value="" selected>Select Currency</option>
                                                        @foreach ($currency as $curr)
                                                        <option value="{{ $curr->id }}">{{ $curr->code }}</option>
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
                                            <table class="table table-bordered table-striped" id="myTable2"
                                                style="width: 150%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Account No.</th>
                                                        <th>Account Name</th>
                                                        <th>Debit</th>
                                                        <th>Kredit</th>
                                                        <th>Remark</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tblDtl">
                                                    <div
                                                        class="align-items-center bg-white justify-content-center spinner_load">
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td>#</td>
                                                        <td>
                                                            <select class="form-control select2" name="account_id"
                                                                id="account_id" onchange="getDetailAccount(this.value)">
                                                                <option value="" selected>Select Account</option>
                                                                @foreach ($accounts as $account)
                                                                <option value="{{ $account->id }}">{{
                                                                    $account->account_number.'
                                                                    - '.$account->account_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="account_number"
                                                                id="account_number" class="form-control" readonly>
                                                            <input type="text" name="account_name" id="account_name"
                                                                class="form-control" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="debit" id="debit"
                                                                class="form-control" value="0">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="credit" id="credit"
                                                                class="form-control" value="0">
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" name="memo" id="memo"
                                                                cols="30" rows="2"></textarea>
                                                        </td>
                                                        <td align="center">
                                                            <a href="javascript:void(0);" class="btn btn-xs btn-success"
                                                                onclick="saveDetailJournal()">
                                                                <i class="fa fa-save"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: right">
                                            <a href="{{ url()->previous() }}" class="btn btn-danger">Back</a>
                                            <button type="submit" class="btn btn-primary">Save</button>
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
    function getDetailAccount(id) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: `{{ route('master.account_get') }}`,
            data: {
                id: id,
            },
            success: function(result) {
                $('#account_number').val(result['account_number']);
                $('#account_name').val(result['account_name']);
            }
        });
    }

    function loadDetailJournal() {
        $('.spinner_load').show();
        $.ajax({
            type: 'post',
            url: `{{ route('journal.loadDetail') }}`,
            success: function(result) {
                $('.spinner_load').hide();
                $('#tblDtl').html(result);
            }
        });
    }

    function saveDetailJournal() {
        let account_id = $('#account_id');
        let account_number = $('#account_number');
        let account_name = $('#account_name');
        let debit = $('#debit');
        let credit = $('#credit');
        let memo = $('#memo');

        if (account_number.val() == '') {
            showToast('warning', 'Please select account number!');
        } else if (debit.val() == '') {
            showToast('warning', 'Please fill debit!');
        } else if (credit.val() == '') {
            showToast('warning', 'Please fill credit!');
        } else {
            $.ajax({
                type: 'post',
                url: `{{ route('journal.saveDetail') }}`,
                data: {
                    account_id: account_id.val(),
                    account_number: account_number.val(),
                    account_name: account_name.val(),
                    debit: debit.val(),
                    debit: debit.val(),
                    credit: credit.val(),
                    credit: credit.val(),
                    memo: memo.val(),
                },
                success: function() {
                    loadDetailJournal();
                    account_id.val('');
                    account_id.select2();
                    account_number.val('');
                    account_name.val('');
                    debit.val(0);
                    credit.val(0);
                    memo.val('');
                    showToast('success', 'Detail saved!');
                }
            });
        }

    }

    function deleteDetailJournal(key) {
        $.ajax({
            type: 'post',
            url: `{{ route('journal.deleteDetail') }}`,
            data: {
                key: key,
            },
            success: function() {
                showToast('success', 'Detail deleted!');
                loadDetailJournal();
            }
        });
    }

    function showToast(type, message) {
            Toast.fire({
                icon: type,
                title: message
            });
        }

    $(function() {
        loadDetailJournal();
        $('.select2').select2();
        $('#journal_date_picker').datetimepicker({
            format: 'L'
        });
    });
</script>
@endpush
@endsection