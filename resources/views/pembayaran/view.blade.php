@extends('layouts.master')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Pembayaran <?=($header['jenis_pmb']==1)? 'Hutang':'Piutang';?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pembayaran.index') }}">List Pembayaran <?=($header['jenis_pmb']==1)? 'Hutang':'Piutang';?></a></li>
                    <li class="breadcrumb-item active">Edit Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        @if(count($errors)>0)
            @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>      
            @endforeach
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Edit Pembayaran</h3>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Tanggal <font color="red">*</font></label>
                        </div>
                        <div class="col-md-8">
                          <div class="input-group date" id="reservationdate" data-target-input="nearest">
                              <input type="text" name="tanggal" id="tanggal_dt" value="@if($header->tanggal != null){{ \Carbon\Carbon::parse($header->tanggal)->format('m/d/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate" disabled/>
                              <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="row mt-3" id="hide_giro" <?=($header->flag_giro==1)?'style="display: none;"':'';?>>
                        <div class="col-md-4">
                            <label>Akun Kas<font color="red">*</font></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="id_kas" id="id_kas" placeholder="Nomor Pembayaran ..." value="{{ $header->account_name }}" disabled>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label>Customer <font color="red">*</font></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="id_company" id="id_company" placeholder="Nomor Pembayaran ..." value="{{ $header->client_name }}" disabled>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="">Memo</label>
                        </div>
                        <div class="col-md 8">
                            <textarea class="form-control" rows="5" name="keterangan" placeholder="Keterangan ..." readonly>{{ $header->keterangan }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Nomor Pembayaran</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="no_pembayaran" id="no_pembayaran" placeholder="Nomor Pembayaran ..." value="{{ $header->no_pembayaran }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="giro_checkbox" name="giro_checkbox" <?=($header->flag_giro==1)?'checked':'';?> readonly>
                                <label for="giro_checkbox" class="custom-control-label">Giro</label>
                            </div>
                        </div>
                    </div>
                    <div id="show_giro" <?=($header->flag_giro==0)?'style="display: none;"':'';?>>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Nomor Giro</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="no_giro" id="no_giro" placeholder="Nomor Giro ..." value="{{ $header->no_giro }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Nama Bank</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nama_bank" id="nama_bank" placeholder="Nama Bank ..." value="{{ $header->bank }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Tanggal Giro</label>
                        </div>
                        <div class="col-md-8">
                          <div class="input-group date" id="reservationdatex" data-target-input="nearest">
                              <input type="text" name="tgl_jatuh_tempo" id="tgl_jatuh_tempo" value="@if($header->tgl_jatuh_tempo != null){{ \Carbon\Carbon::parse($header->tgl_jatuh_tempo)->format('m/d/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdatex" readonly/>
                              <div class="input-group-append" data-target="#reservationdatex" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Nomor Rekening</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="no_rekening" id="no_rekening" placeholder="Nomor Rekening ..." value="{{ $header->no_rekening }}" readonly>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="separator_hr">List Pembayaran Detail</div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Nomor</td>
                  <td>Tanggal</td>
                  <td>Nilai</td>
                </tr>
              </thead>
              <tbody>
                @php
                $no = 0;
                foreach($detail as $v)
                {
                    $no++;
                    // Cost
                    echo '<tr>';
                    // echo '<td><input type="checkbox" name="cek_cost[]" value="'.$v->id.'"  id="cekx_'.$no.'"></td>';
                    echo '<td>'.$no.'</td>';
                    echo '<td class="text-left">'.$v->invoice_no.'</td>';
                    echo '<td class="text-left">'.$v->invoice_date.'</td>';
                    echo '<td class="text-right">'.number_format($v->nilai,2,',','.').'</td>';
                    echo '</tr>';
                }
                @endphp
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    @if($header->jenis_pmb==1)
    <a href="{{ route('pembayaran.index') }}" class="btn btn-default float-left mr-2">
      <i class="fa fa-angle-left"></i> Kembali
    </a>
    @else
    <a href="{{ route('pembayaran.piutang') }}" class="btn btn-default float-left mr-2">
      <i class="fa fa-angle-left"></i> Kembali
    </a>
    @endif
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
@endsection