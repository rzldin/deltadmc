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
        <form action="{{ route('pembayaran.update') }}" class="eventInsForm" method="post" target="_self" name="formku" id="formku" action="">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $header->id }}">
        <input type="hidden" name="jenis_pmb" value="{{ $header->jenis_pmb }}">
          <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Tanggal <font color="red">*</font></label>
                        </div>
                        <div class="col-md-8">
                          <div class="input-group date" id="reservationdate" data-target-input="nearest">
                              <input type="text" name="tanggal" id="tanggal_dt" value="@if($header->tanggal != null){{ \Carbon\Carbon::parse($header->tanggal)->format('m/d/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                            <select class="form-control select2bs44" style="width: 100%;" id="akun_kas" disabled>
                                <option value="">Silahkan Pilih Bank ...</option>
                                <?php
                                    foreach($bank as $v){
                                        echo '<option value="'.$v->id.'" '.(($v->id==$header['id_kas'])?'selected':'').'>'.$v->account_name.'</option>';
                                    }
                                ?>
                            </select>
                            <input type="hidden" name="akun_kas" value="{{ $header->id_kas }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label>Currency <font color="red">*</font></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="{{ $header->code }}" disabled>
                            <input type="hidden" id="currency_id_header" value="{{ $header->currency_id }}">
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
                            <label>Nama Bank</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nama_bank" id="nama_bank" placeholder="Nama Bank ..." value="{{ $header->bank }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Tanggal Giro</label>
                        </div>
                        <div class="col-md-8">
                          <div class="input-group date" id="reservationdatex" data-target-input="nearest">
                              <input type="text" name="tgl_jatuh_tempo" id="tgl_jatuh_tempo" value="@if($header->tgl_jatuh_tempo != null){{ \Carbon\Carbon::parse($header->tgl_jatuh_tempo)->format('m/d/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdatex"/>
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
                            <input type="text" class="form-control" name="no_rekening" id="no_rekening" placeholder="Nomor Rekening ..." value="{{ $header->no_rekening }}">
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
                  <td>Action</td>
                </tr>
              </thead>
              <tbody id="tblDetail">
              </tbody>
            </table>
            <br>
            <div class="separator_hr">List Hutang</div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Nomor</td>
                  <td>Tanggal</td>
                  <td>Nilai</td>
                  <td>Action</td>
                </tr>
              </thead>
              <tbody id="tblInvoice">
                <div class="align-items-center bg-white justify-content-center spinner_load">
                    <div class="spinner-border" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                </div>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
              <a href="{{ route('pembayaran.index') }}" class="btn btn-default float-left mr-2">
                <i class="fa fa-angle-left"></i> Kembali
              </a>
              <button type="submit" class="btn btn-primary float-sm-right"><i class="fa fa-save"></i> Approve</button>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </form>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<div class="modal fade" id="INVModal" tabindex="-1" role="basic" aria-hidden="true">
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
                    <input type="hidden" id="id_modal_inv" name="id_modal_inv">
                    <div class="row">
                        <div class="col-md-5">
                            No. Invoice
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="invoice_no" name="invoice_no" class="form-control myline" style="margin-bottom:5px" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            Currency
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="currency" class="form-control myline" style="margin-bottom:5px" readonly="readonly">
                            <input type="hidden" name="currency_id" id="currency_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            Nilai
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="total_invoice" name="total_invoice" class="form-control myline" style="margin-bottom:5px" readonly="readonly">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:5px">
                        <div class="col-md-5">
                            Tanggal Invoice<font color="#f00">*</font>
                        </div>
                        <div class="col-md-7">
                          <div class="input-group date" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#invoice_date" placeholder="Tanggal ..." id="invoice_date" disabled/>
                              <div class="input-group-append" data-target="#invoice_date" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            Nilai Sudah di Bayar
                        </div>
                        <div class="col-md-7">
                          <input type="text" class="form-control" name="invoice_bayar" id="invoice_bayar" readonly>
                        </div>
                    </div>
                    <div id="deposit_blok">
                        <div class="separator_hr">Deposit</div>
                        <div class="row mb-2">
                            <div class="col-md-5">
                                Saldo
                            </div>
                            <div class="col-md-7">
                                <div class="row form-group">
                                    <input type="hidden" name="deposit_id" id="deposit_id" value="0">
                                    <input type="hidden" id="is_deposit" value="0">
                                    <input type="text" class="form-control" name="balance" id="balance" value="" readonly>
                                </div>
                                {{-- <div class="row form-group">
                                    <a href="javascript:void(0);" onclick="useDepositBalance()" class="btn btn-primary" style="width: 100%"><span class="fa fa-chevron-circle-down"></span> Bayar dengan saldo deposit</a>
                                </div> --}}
                            </div>
                        </div>
                        <div id="boxListDeposit"></div>
                    </div>
                    <div class="separator_hr">Pembayaran</div>
                    <div class="row mb-2">
                        <div class="col-md-5">
                            Bayar
                        </div>
                        <div class="col-md-7">
                          <input type="text" class="form-control" name="nilai_bayar" id="nilai_bayar" value="0" onkeyup="getComa(this.value, this.id); hitungSubTotalSJ();" placeholder="Pembayaran Cash ...">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-5">
                            Nilai Sisa
                        </div>
                        <div class="col-md-7">
                          <input type="text" class="form-control" name="nilai_sisa" id="nilai_sisa" value="0" onkeyup="getComa(this.value, this.id); hitungSubTotalSJ();" placeholder="Pembayaran Deposit ...">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="tambah_inv"><i class="fa fa-plus"></i> <span id="tambah_inv_txt">Tambah</span></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('after-scripts')

<script>
$('#giro_checkbox').change(function() {
  if(this.checked) {
      $('#show_giro').show();
      $('#hide_giro').hide();
  }else{
      $('#show_giro').hide();
      $('#hide_giro').show();
  }
});

function loadDetail(){
    $.ajax({
        type:"POST",
        url:"{{ route('pembayaran.list_detail') }}",
        data:{
            id : {{ $header->id }},
        },
        dataType:"html",
        success:function(result){
            var tabel = JSON.parse(result);
            $('#tblDetail').html(tabel);
        }
    });
}

function loadInvoice(){
    $('.spinner_load').show();
    $.ajax({
        type:"POST",
        url:"{{ route('pembayaran.list_hutang') }}",
        data:{
            id : {{ $header->id_company }},
            id_pmb : {{ $header->id }},
        },
        dataType:"html",
        success:function(result){
            var tabel = JSON.parse(result);
            $('.spinner_load').hide();
            $('#tblInvoice').html(tabel);
        }
    });
}

function checkAmountDeposit(journal_id) {
    let amount = $('#amount_'+journal_id);
    let max_amount = $('#max_amount_'+journal_id);

    let amount_val = amount.val().toString().replace(/\,/g, "");

    if (Number(amount_val) > Number(max_amount.val())) {
        alert('Nilai deposit yang dimasukkan melebihi nilai deposit pada system');
        amount.val(numberWithCommas(max_amount.val()));
    }
}

function useDeposit(journal_id) {
    // console.log(journal_id);
    let nilai_bayar = $('#nilai_bayar');
    let nilai_deposit = $('#amount_'+journal_id);
    let journal_id_check = $('#check_'+journal_id);

    let nilai_bayar_val = nilai_bayar.val().toString().replace(/\,/g, "");
    let nilai_deposit_val = nilai_deposit.val().toString().replace(/\,/g, "");

    let result = 0;
    if (journal_id_check.is(':checked')) {
        result = Number(nilai_bayar_val) + Number(nilai_deposit_val);
        nilai_bayar.val(numberWithCommas(result));
        nilai_deposit.prop('readonly', 'true');
        // console.log('checked');
    } else {
        result = Number(nilai_bayar_val) - Number(nilai_deposit_val);
        nilai_bayar.val(numberWithCommas(result));
        nilai_deposit.removeAttr('readonly');
        // console.log(journal_id_check.val());
        // console.log('unchecked');
    }

    hitungSubTotalSJ();

}

function useDepositBalance() {
    let total_invoice = $('#total_invoice');
    let invoice_bayar = $('#invoice_bayar');
    let nilai_bayar = $('#nilai_bayar');
    let balance = $('#balance');
    let is_deposit = $('#is_deposit');

    let total_invoice_val = total_invoice.val().toString().replace(/\,/g, "")
    let invoice_bayar_val = invoice_bayar.val().toString().replace(/\,/g, "")
    let nilai_bayar_val = nilai_bayar.val().toString().replace(/\,/g, "");
    let balance_val = balance.val().toString().replace(/\,/g, "");

    let sisa_bayar = total_invoice_val - invoice_bayar_val;
    // console.log(balance.val().toString().replace(/\,/g, ""));
    // console.log(balance.val().toString().replace(/\,/g, ""));

    if (balance_val >= sisa_bayar) {
        nilai_bayar_val = sisa_bayar;
        nilai_bayar.val(sisa_bayar.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    } else {
        nilai_bayar_val = balance_val;
        nilai_bayar.val((balance_val).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }

    nilai_bayar.attr('readonly', true);
    balance.val((balance_val - nilai_bayar_val).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    is_deposit.val(1);

    hitungSubTotalSJ();
}

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
    total_invoice = $('#total_invoice').val().toString().replace(/\,/g, "");
    n1 = $('#invoice_bayar').val().toString().replace(/\,/g, "");
    n2 = $('#nilai_bayar').val().toString().replace(/\,/g, "");
    total_harga = formatter.format(Number(total_invoice) - (Number(n1) + Number(n2)));
    // console.log(nominal_sj, n1, n2, total_harga);
    // console.log(nominal_sj+' | '+n3+' | '+total_harga);
    $('#nilai_sisa').val(total_harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}

function input_bayar(id){
  $.ajax({
    url: "{{ route('pembayaran.getDataInv') }}",
    type: "POST",
    data: {
        id:id
    },
    dataType: "json",
    success: function(result){
      // console.log(result);
      $("#INVModal").find('.modal-title').text('Input Pembayaran');
      $("#INVModal").modal('show',{backdrop: 'true'});
      $("#tambah_inv").show();
      $("#alert-danger").hide();
      if ($('#akun_kas').val() == 263) {
            getDepositBalance(result['currency']);
            getListDeposit(result['currency']);
            $('#nilai_bayar').attr('readonly', true);
            $('#deposit_blok').show();
            $('#is_deposit').val(1);
        } else {
            $('#nilai_bayar').attr('readonly', false);
            $('#deposit_blok').hide();
            $('#is_deposit').val(0);

      }

      $("#id_modal_inv").val(result['id']);
      $("#invoice_no").val(result['invoice_no']);
      $("#invoice_date").val(result['invoice_date']);
      $('#nilai_bayar').val(0);
      $('#currency').val(result['code']);
      $('#currency_id').val(result['currency']);
      $("#total_invoice").val(numberWithCommas(result['total_invoice']));
      $("#invoice_bayar").val(numberWithCommas(result['invoice_bayar']));
      hitungSubTotalSJ();
    }
  });
}

function getDepositBalance(currency) {
    $.ajax({
        type: 'post',
        url: `{{ route('deposit.getDepositCompany') }}`,
        data: {
            company_id: @json($header->id_company),
            currency_id: currency,
        },
        success: function(result) {
            $('#deposit_id').val(result['id']);
            $('#balance').val(numberWithCommas(result['balance']));
        }
    });
}

function getListDeposit(currency) {
    $.ajax({
        type: 'post',
        url: `{{ route('deposit.getListDeposit') }}`,
        data: {
            company_id: @json($header->id_company),
            currency_id: currency,
        },
        success: function(result) {
            // console.log(result);
            $('#boxListDeposit').html(result);
        }
    });
}

function updateDepositBalance(pembayaran_id = 0) {
    let deposit_journal_id = $('input[name="deposit[journal_id]"]').map(function(){
        return $(this).val();
    }).get();
    // console.log(deposit_journal_id);
    let deposit_amount = $('input[name="deposit[amount]"]').map(function(){
        return Number($(this).val().toString().replace(/\,/g, "")) * Number(-1);
    }).get();
    // console.log(deposit_amount);

    $.ajax({
        type: 'post',
        url: `{{ route('deposit.processSavePembayaranDeposit') }}`,
        data: {
            id: $('#deposit_id').val(),
            pembayaran_id: pembayaran_id,
            company_id: @json($header->id_company),
            amount: deposit_amount,
            currency_id: $('#currency_id').val(),
            journal_id: deposit_journal_id,
            deposit_date: $('#tanggal_dt').val(),
            invoice_id: $('#id_modal_inv').val(),
        },
        success: function(response) {
            let obj = JSON.parse(response);
            // let result = JSON.parse(response);
            if (obj.status == 'success') {
                // console.log(response['data']['deposit_detail']['id']);
                // proceed_bayar(response['data']['deposit_detail']['id']);
                alert('Transaksi Berhasil di Bayar');
                $("#INVModal").modal('hide');
            } else {
                alert(obj.message);
                $("#INVModal").modal('hide');
            }
        }
    });

    /**
     * Old method
     *
     * //
    // console.log($('#nilai_bayar').val().toString().replace(/\,/g, "") * -1);
    // $.ajax({
    //     type: 'post',
    //     url: `{{ route('deposit.processSave') }}`,
    //     data: {
    //         id: $('#deposit_id').val(),
    //         company_id: @json($header->id_company),
    //         amount: ($('#nilai_bayar').val().toString().replace(/\,/g, "") * -1),
    //         deposit_date: $('#tanggal_dt').val(),
    //         invoice_id: $('#id_modal_inv').val(),
    //     },
    //     success: function(response) {
    //         console.log(response);
    //         // let result = JSON.parse(response);
    //         if (response['status'] == 'success') {
    //             // console.log(response['data']['deposit_detail']['id']);
    //             proceed_bayar(response['data']['deposit_detail']['id']);
    //         }
    //     }
    // });
    */
}

$('#tambah_inv').click(function(event) {
    event.preventDefault(); /*  Stops default form submit on click */

    let nilai_bayar = Number($('#nilai_bayar').val().replace(/,/g, ''));
    let total_invoice = Number($('#total_invoice').val().replace(/,/g, ''));
    if(nilai_bayar > total_invoice){
        Toast.fire({
          icon: 'error',
          title: ' Nilai bayar tidak dapat lebih besar dari nilai invoice'
        });
    }else if(nilai_bayar <= 0){
        Toast.fire({
          icon: 'error',
          title: ' Nilai bayar tidak boleh 0'
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
  $('#tambah_inv_txt').text('Please Wait ...');
  $.ajax({// Run getUnlockedCall() and return values to form
      url: "{{ route('pembayaran.saveDetailPembayaran') }}",
      data:{
         id_pmb:'{{ $header->id }}',
         jenis_pmb:'{{ $header->jenis_pmb }}',
         id_invoice:$('#id_modal_inv').val(),
         currency_id: $('#currency_id').val(),
         total_invoice:$('#total_invoice').val(),
         nilai_bayar:$('#nilai_bayar').val(),
         nilai_sisa:$('#nilai_sisa').val(),
         tanggal_bayar:$('#tanggal_dt').val()
      },
      type: "POST",
      dataType: "json",
      success: function(result){
        if (result['status'] == 'sukses') {
            if ($('#is_deposit').val() == 1) {
                updateDepositBalance(@json($header->id));
            } else {
                alert('Transaksi Berhasil di Bayar');
                $("#INVModal").modal('hide');
            }
        } else {
          alert(result['message']);
          $("#INVModal").modal('hide');
        }
        loadDetail();
        loadInvoice();
        $('#load_sj').DataTable().ajax.reload();
        $('#tambah_inv').prop('disabled', false);
        $('#tambah_inv_txt').text('Tambah');
        $('#id_modal_inv').val('');
        $("#invoice_no").val('');
        $("#invoice_date").val('');
        $("#total_invoice").val('');
        $("#invoice_bayar").val('');
        $("#nilai_sisa").val('');
        $('#currency').val('');
        $('#currency_id').val('');
        $('#is_deposit').val(0);
      }
  });
}

function delete_detail(id){
  $.ajax({
    url: "{{ route('pembayaran.deleteDetailPembayaran') }}",
    type: "POST",
    data: {
        id:id,
        company_id: @json($header->id_company),
        currency_id: $('#currency_id_header').val(),
    },
    dataType: "json",
    success: function(result){
      if (result['status'] == 'sukses') {
        alert('Transaksi Berhasil di hapus');
      } else {
        alert(result['message']);
      }
      loadDetail();
      loadInvoice();
    }
  });
}

$(function() {
  loadDetail();
  loadInvoice();
});
</script>
  @endpush
@endsection
