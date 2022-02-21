@extends('layouts.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Report</li>
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
                                    {{-- <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick="addTax()"><i class="fa fa-plus"></i> Add Tax</a> --}}
                                </div>
                                <div class="p-2 bd-highlight">

                                </div>
                            </div>
                        </div>
                        <div class="flash-data" data-flashdata="{{ session('status') }}">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="get" action="{{ route('report.print') }}" target="_blank">
                                    <div class="form-group row">
                                        <label for="report_code" class="col-sm-2 col-form-label">Report</label>
                                        <div class="col-sm-10">
                                            <select name="report_code" id="report_code" class="form-control">
                                                <option value="income_statement" {{ old('report_code') == 'income_statement' ? 'selected' : '' }} >Income Statement</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="currency_id" class="col-sm-2 col-form-label">Currency</label>
                                        <div class="col-sm-10">
                                            <select class="form-control select2bs44" name="currency_id" id="currency_id">
                                                <option value="" selected>-- Select Valuta --</option>
                                                @foreach ($currency as $item)
                                                    <option value="{{ $item->id }}" {{ old('currency_id') == $item->id ? 'selected' : '' }} >{{ $item->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Date</label>
                                        <div class="col-sm-5">
                                            <div class="input-group date" id="start_date_picker" data-target-input="nearest">
                                                <input type="text" name="start_date" id="start_date" class="form-control datetimepicker-input" data-target="#start_date_picker" placeholder="From" value="{{ old('start_date') }}" />
                                                <div class="input-group-append" data-target="#start_date_picker" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="input-group date" id="end_date_picker" data-target-input="nearest">
                                                <input type="text" name="end_date" id="end_date" class="form-control datetimepicker-input" data-target="#end_date_picker" placeholder="To" value="{{ old('end_date') }}" />
                                                <div class="input-group-append" data-target="#end_date_picker" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
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
        function clearFields() {
            $('#id').val(0);
            $('#code').val('');
            $('#code').removeAttr('readonly');
            $('#name').val('');
            $('#value').val(0);
        }

        function addTax() {
            clearFields();
            $('#modal-title').text('Add Tax');
            $('#modal-tax').modal('show');
        }

        function editTax(id, code, name, value) {
            $('#id').val(id);
            $('#code').val(code);
            $('#code').attr('readonly', 'true');
            $('#name').val(name);
            $('#value').val(value);

            $('#modal-title').text('Edit Tax');
            $('#modal-tax').modal('show');
        }

        $(function() {
            $('#start_date_picker').datetimepicker({
                format: 'L'
            });
            $('#end_date_picker').datetimepicker({
                format: 'L'
            });
        });
    </script>
@endpush
