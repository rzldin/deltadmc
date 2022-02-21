@extends('layouts.master')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Pembayaran Piutang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pembayaran.piutang') }}">List Pembayaran Piutang</a></li>
                    <li class="breadcrumb-item active">Add Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <!-- left column -->
            <div class="col-md-12">
          <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Pembayaran Piutang</h3>
                </div>
                @if(count($errors)>0)
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                    @endforeach
                @endif
            <!-- /.card-header -->
            <!-- form start -->
                <form action="{{ route('pembayaran.save') }}" class="eventInsForm" method="post" target="_self" name="formku" id="formku" action="">
                {{ csrf_field() }}
                <input type="hidden" name="jenis_pmb" value="0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Tanggal <font color="red">*</font></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="tanggal" id="tanggal" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3" id="hide_giro">
                                <div class="col-md-4">
                                    <label>Akun Kas<font color="red">*</font></label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control select2bs44" style="width: 100%;" name="akun_kas" id="akun_kas">
                                        <option value="">Silahkan Pilih Bank ...</option>
                                        <?php
                                            foreach($bank as $v){
                                                echo '<option value="'.$v->id.'">'.$v->account_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Currency <font color="red">*</font></label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control select2bs44" name="currency_id" id="currency_id">
                                        <option value="" selected>-- Select Valuta --</option>
                                        @foreach ($currency as $item)
                                            <option value="{{ $item->id }}">{{ $item->code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Customer <font color="red">*</font></label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control select2bs44" style="width: 100%;" name="customer" id="customer">
                                        <option value="">Silahkan Pilih Customer ...</option>
                                        <?php
                                            foreach($company as $item){
                                                echo '<option value="'.$item->id.'">('.$item->client_code.') '.$item->client_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="">Memo</label>
                                </div>
                                <div class="col-md 8">
                                    <textarea class="form-control" rows="5" name="keterangan" placeholder="Keterangan ..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Nomor Pembayaran</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="no_pembayaran" id="no_pembayaran" placeholder="Nomor Pembayaran ...">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="giro_checkbox" name="giro_checkbox">
                                        <label for="giro_checkbox" class="custom-control-label">Giro</label>
                                    </div>
                                </div>
                            </div>
                            <div id="show_giro" style="display: none;">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Nomor Giro</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="no_giro" id="no_giro" placeholder="Nomor Giro ...">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Nama Bank</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="nama_bank" id="nama_bank" placeholder="Nama Bank ...">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Tanggal Giro</label>
                                </div>
                                <div class="col-md-8">
                                  <div class="input-group date" id="date_jt" data-target-input="nearest">
                                      <input type="text" name="tanggal_giro" class="form-control datetimepicker-input" id="tanggal_jt" data-target="#date_jt" placeholder="Tanggal ..."/>
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
                                    <input type="text" class="form-control" name="no_rekening" id="no_rekening" placeholder="Nomor Rekening ...">
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" class="btn btn-primary float-right" id="saveData"><i class="fa fa-paper-plane"></i> Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
  @push('after-scripts')

  <script>

    $(function() {
        $('input[name=from]').on('input',function() {
            var selectedOption = $('option[value="'+$(this).val()+'"]');
            console.log(selectedOption.length ? selectedOption.attr('id') : 'This option is not in the list!');
            var id = selectedOption.attr('id');
            $('#from_id').val(id)
        });

        $('#giro_checkbox').change(function() {
            if(this.checked) {
                $('#show_giro').show();
                $('#hide_giro').hide();
            }else{
                $('#show_giro').hide();
                $('#hide_giro').show();
            }
        });
    });

    $("#saveData").click(function(){
        if($.trim($("#tanggal").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Tanggal',
                icon: 'error'
            })
        }else if($.trim($("#customer").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Customer',
                icon: 'error'
            })
        }else if($.trim($("#no_pembayaran").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Input Nomor Pembayaran',
                icon: 'error'
            })
        }else{
            $(this).prop('disabled', true).text('Please Wait ...');
            $('#formku').submit();
        }
    });

  </script>

  @endpush
@endsection


