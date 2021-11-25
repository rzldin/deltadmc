@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Finance</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Finance</li>
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
                    <a class="btn btn-primary btn-sm" href="{{ url('quotation/quote_add') }}"><i class="fa fa-plus"></i> Add Data</a>
                </div>
                <div class="flash-data" data-flashdata="{{ session('status') }}">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="3%">No</th>
                                <th width="10%">Quote No</th>
                                <th width="7%">Date</th>
                                <th width="5%">Latest Version</th>
                                <th>Customer</th>
                                <th>PIC</th>
                                <th>Activity</th>
                                <th>Type</th>
                                <th>Shipment By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 14px">
                            @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->quote_no }}</td>
                                <td>{{ $row->quote_date }}</td>
                                <td class="text-center">{{ $row->version_no }}</td>
                                <td>{{ $row->client_name }}</td>
                                <td>{{ $row->name_pic }}</td>
                                <td class="text-center">{{ ucwords($row->activity) }}</td>
                                <td class="text-center">{{ $row->loaded_type }}</td>
                                <td class="text-center">{{ $row->shipment_by }}</td>
                                @if ($row->status == 1)
                                    <td class="bg-success text-center">
                                        Approved
                                    </td>
                                @else
                                    <td class="bg-secondary text-center">
                                        New
                                    </td>
                                @endif
                                <td>
                                    <a class="btn btn-primary btn-sm" onclick="viewVersion('{{ $row->quote_no }}','{{ $row->version_no }}', 'view', '{{ $row->id }}')"><i class="fa fa-file-alt"></i> View </a>
                                    <a class="btn btn-info btn-sm" onclick="viewVersion('{{ $row->quote_no }}','{{ $row->version_no }}','edit', '{{ $row->id }}')" status="edit"><i class="fa fa-edit"></i> Edit </a>
                                    {{-- @if ($row->status == 0)
                                    <a href="{{ route('quotation.deleteQuote') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete </a>                                        
                                    @endif --}}
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
@endsection

@push('after-scripts')
@endpush