@extends('layouts.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pembayaran Piutang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Invoice Sell List</li>
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
                            <a class="btn btn-primary btn-sm" href="{{ route('pembayaran.add_piutang') }}"><i class="fa fa-plus"></i> Create Pembayaran Piutang</a>
                        </div>
                        <div class="flash-data" data-flashdata="{{ session('status') }}">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No Pembayaran</th>
                                            <th>Date</th>
                                            <th>Nilai PMB</th>
                                            <th>Jumlah Invoice</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px">
                                        @foreach ($pembayaran as $pmb)
                                            <tr>
                                                <td>{{ $pmb->no_pembayaran }}</td>
                                                <td>{{ \Carbon\Carbon::parse($pmb->tanggal)->format('d/m/Y') }}</td>
                                                <td>{{ number_format($pmb->nilai_pmb, 2, ',', '.') }}</td>
                                                <td>{{ $pmb->jumlah }}</td>
                                                {{-- <td> --}}
                                                {{-- <a class="btn btn-primary btn-sm" href="{{ route('pembayaran.view', ['id' => $pmb->id]) }}" ><i class="fa fa-file-alt"></i>  &nbsp;View &nbsp; &nbsp; &nbsp;</a> --}}
                                                {{-- </td> --}}
                                                @if ($pmb->status == 0)
                                                    <td class="bg-secondary text-center">Draft</td>
                                                @elseif($pmb->status == 1)
                                                    <td class="bg-success text-center">Approved</td>
                                                @endif
                                                <td>
                                                    @if ($pmb->status == 1)
                                                        <a class="btn btn-primary btn-sm" href="{{ route('pembayaran.view', ['id' => $pmb->id]) }}"><i class="fa fa-file-alt"></i> View </a>
                                                    @else
                                                        <a class="btn btn-info btn-sm" href="{{ route('pembayaran.edit', ['id' => $pmb->id]) }}"><i class="fa fa-edit"></i> Edit </a>
                                                        @if($pmb->jumlah==0)
                                                            <a class="btn btn-danger btn-sm" href="javascript:;"  onclick="deleteInvoice({{ $pmb->id }})"><i class="fa fa-trash"></i> Delete </a>
                                                        @endif
                                                    @endif
                                                    @if ($pmb->journal_id == 0)
                                                        <a class="btn btn-secondary btn-sm"
                                                            href="{{ route('journal.add') }}?reference_no={{ $pmb->no_pembayaran }}&reference_id={{ $pmb->id }}&client_id={{ $pmb->id_company }}&source=pembayaran">
                                                            <i class="fa fa-book"></i> Journal
                                                        </a>
                                                    @endif
                                                    @if ($pmb->status == 1)
                                                        <a class="btn btn-success btn-sm" onclick="openPMB({{ $pmb->id }});"><i class="fa fa-undo"></i> Open PMB </a>
                                                    @endif
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
    <form action="{{ route('pembayaran.openPMB') }}" class="eventInsForm" method="post" target="_self" name="formku" id="formku" style="display: none;">
        {{ csrf_field() }}
        <input type="hidden" name="id_pmb" id="id_pmb">
        <input type="hidden" name="jenis_pmb" id="jenis_pmb">
    </form>
@endsection

@push('after-scripts')
<script>
    function openPMB(id) {
        if (confirm('Anda yakin ingin membuka pembayaran ini kembali ?')) {
            $('#id_pmb').val(id);
            $('#jenis_pmb').val(0);
            $('#formku').submit();
        }
    }

    function deleteInvoice(id) {
        let url = `{{ route('pembayaran.delete', ':id') }}`;
        url = url.replace(':id', id);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }
</script>
@endpush
