@extends('layouts.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tax</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Tax</li>
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
                                    <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick="addTax()"><i class="fa fa-plus"></i> Add Tax</a>
                                </div>
                                <div class="p-2 bd-highlight">

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
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Value (%)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px">
                                        @foreach ($taxes as $tax)
                                            <tr>
                                                <td align="center">{{ $loop->iteration }}</td>
                                                <td>{{ $tax->code }}</td>
                                                <td>{{ $tax->name }}</td>
                                                <td align="right">{{ number_format($tax->value, 2, ',', '.') }}</td>
                                                <td>
                                                    <a class="btn btn-info btn-sm" href="javascript:void(0);" onclick="editTax({{ $tax->id }}, `{{ $tax->code }}`, `{{ $tax->name }}`, {{ $tax->value }})">
                                                        <i class="fa fa-edit"></i> Edit
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
    <form method="post" action="{{ route('master.tax.save') }}">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="modal fade modal-tax" id="modal-tax" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-md-4">
                                Code
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="code" id="code" class="form-control" placeholder="Tax code">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Name
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Tax Name">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Value (%)
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="value" id="value" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
            $('#deposit_date_picker').datetimepicker({
                format: 'L'
            });
        });
    </script>
@endpush
