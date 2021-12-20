@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Company Detail</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master.company') }}">Company</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">
                            Headers
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="container">
                            <div class="col-md-8">
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-xs-4">
                                        Company Code <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="client_code" name="client_code"
                                            class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()" value="{{ $company->client_code }}" readonly>
                                        <input type="hidden" id="id_company" name="id_company" value="{{ $company->id }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Company Name <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="client_name" name="client_name"
                                            class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()" value="{{ $company->client_name }}" readonly>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        NPWP <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text" id="npwp" name="npwp"
                                            class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()" value="{{ $company->npwp }}" readonly>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Account Payable <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text"  class="form-control myline" style="margin-bottom:5px" value="@if ($company->ap_number != '') {{ $company->ap_number.' | '.$company->ap_name  }} @endif" readonly>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Account Receivable <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text"  class="form-control myline" style="margin-bottom:5px" value="@if ($company->ar_number != ''){{ $company->ar_number.' | '.$company->ar_name  }} @endif" readonly>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Sales By <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <input type="text"  class="form-control myline" style="margin-bottom:5px" value="{{ $company->user_name  }}" readonly>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Legal Doc
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <div class="custom-control custom-checkbox">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="legal_doc" name="legal_doc" value="1" @if ($company->legal_doc_flag == 1) checked
                                                @endif disabled>
                                                <label for="legal_doc">
                                                    LEGAL DOC
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Status
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <div class="custom-control custom-checkbox">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="status" name="status" value="1" @if ($company->active_flag == 1)
                                                    checked
                                                @endif disabled>
                                                <label for="status">
                                                    ACTIVE
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-xs-4">
                                        Add To
                                    </div>
                                    <div class="col-md-4">
                                        <!-- checkbox -->
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="customer" name="customer" value="1" @if ($company->customer_flag == 1) checked @endif disabled>
                                                    <label for="customer">
                                                        CUSTOMER
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="vendor" name="vendor" value="1" @if ($company->vendor_flag == 1) checked
                                                    @endif disabled>
                                                    <label for="vendor">
                                                        VENDOR
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="buyer" name="buyer" value="1" @if ($company->buyer_flag == 1) checked
                                                    @endif disabled>
                                                    <label for="buyer">
                                                        BUYER
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="seller" name="seller" value="1" @if ($company->seller_flag == 1) checked @endif disabled>
                                                    <label for="seller">
                                                        SELLER
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- radio -->
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="shipper" name="shipper" value="1" @if ($company->shipping_line_flag == 1) checked @endif disabled>
                                                    <label for="shipper">
                                                        SHIPPER
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="agent" name="agent" value="1" @if ($company->agent_flag == 1) checked @endif disabled>
                                                    <label for="agent">
                                                        AGENT
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="ppjk" name="ppjk" value="1" @if ($company->ppjk_flag == 1) checked @endif disabled>
                                                    <label for="ppjk">
                                                        PPJK
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tittle">
                            <i class="fa fa-map"></i> Address
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table_lowm table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Address Type</th>
                                    <th>Country</th>
                                    <th>Province</th>
                                    <th>City</th>
                                    <th>Postal Code</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($address as $s)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $s->address_type }}</td>
                                    <td>{{ $s->country_name }}</td>
                                    <td>{{ $s->province }}</td>
                                    <td>{{ $s->city }}</td>
                                    <td>{{ $s->postal_code }}</td>
                                    <td>{{ $s->address }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tittle">
                            <i class="fa fa-user-plus"></i> PIC
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table_lowm table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Name</th>
                                    <th>Phone 1</th>
                                    <th>Phone 2</th>
                                    <th>Fax</th>
                                    <th>Email</th>
                                    <th>PIC Desc</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pic as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->phone1 }}</td>
                                        <td>{{ $p->phone2 }}</td>
                                        <td>{{ $p->fax }}</td>
                                        <td>{{ $p->email }}</td>
                                        <td>{{ $p->pic_desc }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3 mb-4">
                <a href="{{ route('master.company') }}" class="btn btn-default float-left mr-2">
                    <i class="fa fa-angle-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('after-scripts')

@endpush
