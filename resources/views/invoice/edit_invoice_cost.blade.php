@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus"></i>
                    Internal Invoice (Hutang)
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Internal Invoice</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="flash-data" data-flashdata="{{ session('status') }}">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-right">
                            <strong>{{ ucwords($header->activity) }}</strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" id="formInvoice" action="{{ route('invoice.update_cost') }}">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $header->id }}" />
                            <input type="hidden" name="tipe_inv" value="{{ $header->tipe_inv }}">
                            <input type="hidden" name="activity" value="{{ $header->activity }}">
                            <input type="hidden" name="t_booking_id" value="{{ $header->t_booking_id }}">
                            <input type="hidden" name="rate" value="{{ $header->rate }}">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Invoice Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Bill To</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="client_name"
                                                    id="client_name" value="{{ $header->client_name }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Address</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="address"
                                                    id="address" value="{{ $header->address }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>PIC</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="pic_name"
                                                    id="pic_name" value="{{ $header->pic_name }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Invoice No</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="invoice_no"
                                                    id="invoice_no" value="{{ $header->invoice_no }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Truck No</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="truck_no"
                                                    id="truck_no" value="{{ $header->truck_no }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Invoice Type</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="radio" name="invoice_type"
                                                        id="invoice_type_reg" value="REG" <?= (($header->reimburse_flag == 0 && $header->debit_note_flag == 0 && $header->credit_note_flag == 0) ? 'checked' : '') ?>> Reguler<br>
                                                    <input type="radio" name="invoice_type"
                                                        id="invoice_type_reimbursment" value="REM" <?= (($header->reimburse_flag == 1) ? 'checked' : '') ?>> Reimbursment<br>
                                                    <input type="radio" name="invoice_type"
                                                        id="invoice_type_debit_note" value="DN" <?= (($header->debit_note_flag == 1) ? 'checked' : '') ?>> Debit Note<br>
                                                    <input type="radio" name="invoice_type"
                                                        id="invoice_type_credit_note" value="CN" <?= (($header->credit_note_flag == 1) ? 'checked' : '') ?>> Credit Note<br>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>MB/L</label>
                                                </div>
                                                <div class="col-md-8">
                                                    : {{ $header->mbl_shipper }}
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Container</label>
                                                </div>
                                                <div class="col-md-8">
                                                    :
                                                    <ul class="list-item-inv">
                                                        @foreach($containers as $container)
                                                            <li>{{ $container->container_no."/".$container->size."'" }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Goods</label>
                                                </div>
                                                <div class="col-md-8">
                                                    :
                                                    <ul class="list-item-inv">
                                                        @foreach($goods as $good)
                                                            <li>{{ number_format($good->qty_comm,0)." ".$good->code_c." OF ".$good->desc."'" }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Tax</label>
                                                </div>
                                                <div class="col-md-8">
                                                    @foreach ($taxes as $tax)
                                                        <div class="form-check form-check-inline">
                                                            <button type="button" class="btn btn-info btn-xs" onclick="checkedTax(`{{$tax->code}}`)">{{ "$tax->name ($tax->value %)" }}</button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Issued Date</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly type="text" name="invoice_date" id="invoice_date"
                                                        class="form-control"value="{{ date('d/m/Y', strtotime($header->invoice_date)) }}" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>TOP</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input readonly class="form-control" type="number" name="top" id="top" value="{{ $header->top }}">
                                                </div>
                                                <div class="col-md-4">
                                                    Days
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Currency</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="currency_name"
                                                    id="currency_name" value="{{ '('.$header->currency_code.') '.$header->currency_name }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Kurs</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" name="kurs"
                                                        id="kurs" value="{{ number_format($header->rate,2,',','.') }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>MB/L NO.</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" value="{{ $header->mbl_no }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>HB/L</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" value="{{ $header->hbl_no }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>VESSEL</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" value="{{ $header->vessel }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>M. VESSEL</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" value="{{ $header->m_vessel }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Loading</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" value="{{ $header->pol_name }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Destination</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly class="form-control" type="text" value="{{ $header->pod_name }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>On Board Date</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input readonly type="text" name="onboard_date" id="onboard_date"
                                                        class="form-control"value="{{ date('d/m/Y', strtotime($header->onboard_date)) }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="card-title">Detail</h5>
                                    <div class="row" style="padding-bottom: 5px;">
                                        <div class="col" style="text-align: right">
                                            <button type="button" onclick="syncInvoice()"
                                            class="btn btn-success" {{ $header->flag_bayar > 0 ? 'disabled' : '' }}><i class="fas fa-redo"></i> Sync Detail</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Service/Fee</th>
                                                <th>Description</th>
                                                <th>Reimbursment</th>
                                                <th>Unit</th>
                                                <th>Currency</th>
                                                <th>rate/unit</th>
                                                <th>Total</th>
                                                <th>ROE</th>
                                                <th>Cost Adjustment</th>
                                                <th>Amount</th>
                                                <th>PPN 10%</th>
                                                <th>PPH23 (-)</th>
                                                <th>PPN 1%</th>
                                                {{-- <th>Note</th> --}}
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblCost">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                  <a href="{{ url()->previous() }}" class="btn btn-default float-left mr-2">
                                    <i class="fa fa-angle-left"></i> Kembali
                                  </a>
                                <button type="submit" class="btn btn-primary float-right" id="saveData">Save</button>    
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('after-scripts')
<script>
    function checkedTax(code) {
        $('.'+code).trigger('click');
    }

    function checkedTaxDetail(code, no, name, value) {
        if ($('#btn_'+code+no).is(':checked')) {
            $('#lbl_'+code+no).show();
        } else {
            $('#lbl_'+code+no).hide();
        }
        checkstate(code,name,value);
    }

    function checkstate(code,name,value) {
        let elems = document.getElementsByClassName(code);
        let checked = false;
        let total_value = Number(0);
        for (let i = 0; i < elems.length; i++) {
            if (elems[i].checked) {
                total_value += Number(elems[i].value);
                checked = true;
            }
        }
        $('#input_'+code).val(Number(total_value).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        if (checked) {
            $('#row_'+code).show();
            $('#lbl_total_'+code).text(name + ' (' + value + ' %)');
        } else {
            $('#row_'+code).hide();
        }
        calculateTotal();
    }

    function calculateTotal() {
        let total_before_vat = $('#total_before_vat');
        let total_invoice = $('.total_invoice');
        let total_before_vat_val = Number(total_before_vat.val().toString().replace(/\,/g, ""));
        @foreach ($taxes as $tax)
            let total_{{$tax->code}}_val = $('#input_{{$tax->code}}').val().toString().replace(/\,/g, "");
        @endforeach
        // let ppn = $('#value_ppn');
        // let pph23 = $('#value_pph23');
        // let total_ppn = $('#input_ppn');
        // let total_pph23 = $('#input_pph23');

        // let total_before_vat_val = Number(total_before_vat.val().toString().replace(/\,/g, ""));
        // let ppn_val = Number(ppn.val().toString().replace(/\,/g, ""));
        // let pph23_val = Number(pph23.val().toString().replace(/\,/g, ""));
        // let total_ppn_val = total_before_vat_val * (ppn_val / 100);
        // let total_pph23_val = total_before_vat_val * (pph23_val / 100);

        let result;
        result = Number(total_before_vat_val) + Number(total_ppn_val) - Number(total_pph23_val) + Number(total_ppn1_val);

        // total_ppn.val(total_ppn_val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        // total_pph23.val(total_pph23_val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        total_invoice.text(result.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        total_invoice.val(result.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }

    /** Load Detail **/
    function loadDetailInvoice(id) {
        if (id != null) {
            $.ajax({
                type: "POST",
                url: "{{ route('invoice.loadDetailInvoice') }}",
                data: {
                    id: id,
                    invoice_type: $('input[name="invoice_type"]:checked').val(),
                },
                dataType: "html",
                success: function (result) {
                    var tabel = JSON.parse(result);
                    $('#tblCost').html(tabel[0]);
                    $(".taxcheck").prop('checked', false);//reset biar nge checkbox ulang tax nya
                    // $('#tblProfit').html(tabel[2]);
                }
            })
        }
    }

    function deleteInvoice(id) {
        let url = `{{ route('invoice.delete_detail', ':id') }}`;
        url = url.replace(':id', id);

        Swal.fire({
            title: 'Anda yakin ingin menghapus detail invoice ini ?',
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

    function syncInvoice() {
        $.ajax({
            type: 'get',
            url: `{{ route('invoice.syncInvoiceDetail') }}`,
            data: {
                t_booking_id : @json($header->t_booking_id),
                invoice_id : @json($header->id),
                type_invoice : 'cost',
                // is_ppn : is_ppn,
                // is_pph23 : is_pph23,
            },
            success: function(result) {
                if (result.status == 'success') {
                    toast('success');
                    location.reload();
                } else {
                    fire('error', 'Oppss..', result.message);
                }
            }
        });
    }

    $(function () {
        loadDetailInvoice({{ $header->id }})
    });

</script>
@endpush