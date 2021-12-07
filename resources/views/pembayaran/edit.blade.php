@extends('layouts.master')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Pembayaran Hutang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pembayaran.index') }}">List Pembayaran Hutang</a></li>
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
                          <div class="input-group date" id="date_id" data-target-input="nearest">
                              <input type="text" name="tanggal" class="form-control datetimepicker-input" id="tanggal_dt" data-target="#date_id" placeholder="Tanggal ..." value="{{ $header->tanggal }}" />
                              <div class="input-group-append" data-target="#date_id" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label>Akun Kas<font color="red">*</font></label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2bs44" style="width: 100%;" name="akun_kas" id="akun_kas">
                                <option value="">Silahkan Pilih Bank ...</option>
                                <?php 
                                    foreach($bank as $v){
                                        echo '<option value="'.$v->id.'" '.(($v->id==$header['id_kas'])?'selected':'').'>'.$v->account_name.'</option>';
                                    }
                                ?>
                            </select>
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
                            <textarea class="form-control" rows="5" name="keterangan" placeholder="Keterangan ...">{{ $header->keterangan }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Nomor Pembayaran</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="no_pembayaran" id="no_pembayaran" placeholder="Nomor Pembayaran ..." value="{{ $header->no_pembayaran }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="giro_checkbox" name="giro_checkbox" <?=($header->flag_giro==1)?'checked':'';?>>
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
                            <input type="text" class="form-control" name="no_giro" id="no_giro" placeholder="Nomor Giro ..." value="{{ $header->no_giro }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Tanggal</label>
                        </div>
                        <div class="col-md-8">
                          <div class="input-group date" id="date_jt" data-target-input="nearest">
                              <input type="text" name="tanggal_giro" class="form-control datetimepicker-input" id="tanggal_jt" data-target="#date_jt" placeholder="Tanggal ..." value="{{ $header->tgl_jatuh_tempo }}" />
                              <div class="input-group-append" data-target="#date_jt" data-toggle="datetimepicker">
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
                            <input type="text" class="form-control" name="no_rekening" id="no_rekening" placeholder="Nomor Rekening ..." value="{{ $header->no_rekening }}">
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <table id="load_sj" class="table table-bordered">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Nomor</td>
                  <td>No DO</td>
                  <td>Tanggal</td>
                  <td>Nama Supplier</td>
                  <td>No Polisi</td>
                  <td>Jam Masuk</td>
                  <td>Jam Keluar</td>
                  <td>Action</td>
                </tr>
              </thead>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<div class="modal fade" id="SJModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">&nbsp;</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger display-hide" id="alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span id="message">&nbsp;</span>
                        </div>
                    </div>
                </div>
                <form class="eventInsForm" method="post" target="_self" name="frmInv" 
                    id="frmInv">
                    <input type="hidden" id="id_modal_sj" name="id_modal_sj">
                    <input type="hidden" id="id_supplier" name="id_supplier">
                    <div class="row">
                        <div class="col-md-5">
                            No. Tiket
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="no_tiket" name="no_tiket" class="form-control myline" style="margin-bottom:5px" readonly="readonly">
                            <input type="hidden" id="id_timbang" name="id_timbang">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            Nilai
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="nominal_sj" name="nominal_sj" class="form-control myline" style="margin-bottom:5px" readonly="readonly">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:5px">
                        <div class="col-md-5">
                            Tanggal Bayar<font color="#f00">*</font>
                        </div>
                        <div class="col-md-7">
                          <div class="input-group date" id="date_id" data-target-input="nearest">
                              <input type="text" name="tanggal" class="form-control datetimepicker-input" id="tanggal_dt" data-target="#date_id" placeholder="Tanggal ..."/>
                              <div class="input-group-append" data-target="#date_id" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            Deposit Saat Ini
                        </div>
                        <div class="col-md-7">
                          <input type="text" class="form-control" name="deposit" id="deposit" readonly>
                        </div>
                    </div>
                    <div class="separator_hr">Pembayaran</div>
                    <div class="row mb-2">
                        <div class="col-md-5">
                            Cash
                        </div>
                        <div class="col-md-7">
                          <input type="text" class="form-control" name="pmb_cash" id="pmb_cash" value="0" onkeyup="getComa(this.value, this.id); hitungSubTotalSJ();" placeholder="Pembayaran Cash ...">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-5">
                            Deposit
                        </div>
                        <div class="col-md-7">
                          <input type="text" class="form-control" name="pmb_deposit" id="pmb_deposit" value="0" onkeyup="getComa(this.value, this.id); hitungSubTotalSJ();" placeholder="Pembayaran Deposit ...">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-5">
                            Transfer
                        </div>
                        <div class="col-md-7">
                          <input type="text" class="form-control" name="pmb_transfer" id="pmb_transfer" value="0" placeholder="Pembayaran Transfer ..." readonly>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">                        
                <button type="button" class="btn btn-primary" id="tambah_sj"><i class="fa fa-plus"></i> <span id="tambah_sj_txt">Tambah</span></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('after-scripts')

<script>
$(document).ready(function() {
  $('#load_sj').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax":{
        "url":"{{ route('pembayaran.list_hutang') }}",
        "type":"post",
        "data":function (data) {
            data.id_supplier = {{$header->id_companye}};
        }
      },
      "columnDefs":[
        {
          "targets":'_all',
          "className":'p-1'
        },
        {
          "targets":[3,4],
          "className":'text-right'
        }
      ]
  });
});

const formatter = new Intl.NumberFormat('en-US', {
   minimumFractionDigits: 2,      
   maximumFractionDigits: 2,
});

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); 
}

function getComa(value, id){
    angka = value.toString().replace(/\,/g, "");
    $('#'+id).val(angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}

function hitungSubTotalSJ(){
    nominal_sj = $('#nominal_sj').val().toString().replace(/\,/g, "");
    n1 = $('#pmb_cash').val().toString().replace(/\,/g, "");
    n2 = $('#pmb_deposit').val().toString().replace(/\,/g, "");
    total_harga = formatter.format(Number(nominal_sj) - (Number(n1) + Number(n2)));
    // console.log(nominal_sj, n1, n2, total_harga);
    // console.log(nominal_sj+' | '+n3+' | '+total_harga);
    $('#pmb_transfer').val(total_harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}

function input_bayar(id){
  $.ajax({
    url: "",
    type: "POST",
    data: {
        id:id
    },
    dataType: "json",
    success: function(result){
      // console.log(result);
      $("#SJModal").find('.modal-title').text('Input Pembayaran');
      $("#SJModal").modal('show',{backdrop: 'true'});
      $("#tambah_sj").show();
      $("#alert-danger").hide();
      
      $("#id_supplier").val(result['id_supplier']);
      $("#no_tiket").val(result['no_tiket']);
      $("#id_timbang").val(result['id']);
      $("#nominal_sj").val(numberWithCommas(result['total_harga']));
      // $("#nominal_sdh_bayar").val(numberWithCommas(result['nilai_total_bayar']));
      $("#pmb_transfer").val(numberWithCommas(result['nilai_sisa']));
      $("#deposit").val(numberWithCommas(result['nilai_deposit']));
      $("#pmb_deposit").val(0);
      $("#pmb_cash").val(0);
      $("#sisa_sj").val(0);
    }
  });
}

$('#tambah_sj').click(function(event) {
    event.preventDefault(); /*  Stops default form submit on click */

    let nominal_deposit = Number($('#pmb_deposit').val().replace(/,/g, ''));
    let deposit = Number($('#deposit').val().replace(/,/g, ''));
    let nominal_transfer = Number($('#pmb_transfer').val().replace(/,/g, ''));
    if($.trim($("#tanggal_dt").val()) == ''){
        Toast.fire({
          icon: 'error',
          title: ' Tanggal Bayar harus diisi'
        });
    }else if(nominal_deposit > deposit){
        Toast.fire({
          icon: 'error',
          title: ' Nilai bayar Deposit tidak dapat lebih besar dari nilai deposit'
        });
    }else if(nominal_transfer < 0){
        Toast.fire({
          icon: 'error',
          title: ' Pembayaran tidak dapat melebihi nilai'
        });
    }else{
        var r=confirm("Anda yakin meng-approve Pembayaran ini?");
        if (r==true){
          $(this).prop('disabled', true);
          proceed_bayar();/// LANJUT BAYAR
        }
    }
});

function proceed_bayar(){
  $('#tambah_sj_txt').text('Please Wait ...');
  $.ajax({// Run getUnlockedCall() and return values to form
      url: "",
      data:{
         id_supplier:$('#id_supplier').val(),
         id_timbang:$('#id_timbang').val(),
         tanggal:$('#tanggal_dt').val(),
         nominal_sj:$('#nominal_sj').val(),
         deposit:$('#deposit').val(),
         pmb_cash:$('#pmb_cash').val(),
         pmb_deposit:$('#pmb_deposit').val(),
         pmb_transfer:$('#pmb_transfer').val()
      },
      type: "POST",
      success: function(result){
        if (result['message_type'] == 'sukses') {
          alert('Transaksi Berhasil di Bayar');
          $("#SJModal").modal('hide');
        } else {
          alert(result['message']);
          $("#SJModal").modal('hide'); 
        }
        $('#load_sj').DataTable().ajax.reload();
        $('#tambah_sj').prop('disabled', false);
        $('#tambah_sj_txt').text('Tambah');
        $('#id_supplier').val('');
        $("#no_tiket").val('');
        $("#id_timbang").val('');
        $("#nominal_sj").val('');
      }
  });
}
</script>
  @endpush    
@endsection