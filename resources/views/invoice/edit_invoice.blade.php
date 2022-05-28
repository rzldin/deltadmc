@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus"></i>
                    Internal Invoice (Piutang)
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
                        <form method="post" id="formInvoice">
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
                                                    <input type="radio" disabled name="invoice_type"
                                                        id="invoice_type_reg" value="REG" <?= (($header->reimburse_flag == 0 && $header->debit_note_flag == 0 && $header->credit_note_flag == 0) ? 'checked' : '') ?>> Reguler<br>
                                                    <input type="radio" disabled name="invoice_type"
                                                        id="invoice_type_reimbursment" value="REM" <?= (($header->reimburse_flag == 1) ? 'checked' : '') ?>> Reimbursment<br>
                                                    <input type="radio" disabled name="invoice_type"
                                                        id="invoice_type_debit_note" value="DN" <?= (($header->debit_note_flag == 1) ? 'checked' : '') ?>> Debit Note<br>
                                                    <input type="radio" disabled name="invoice_type"
                                                        id="invoice_type_credit_note" value="CN" <?= (($header->credit_note_flag == 1) ? 'checked' : '') ?>> Credit Note<br>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label>Tax</label>
                                                </div>
                                                <div class="col-md-8">
                                                    @foreach ($taxes as $tax)
                                                        @php
                                                            $checked = '';
                                                            if($tax->code=='ppn'){
                                                                if($header->total_vat>0){
                                                                    $checked = 'checked';
                                                                }
                                                            }elseif($tax->code=='pph23'){
                                                                if($header->pph23>0){
                                                                    $checked = 'checked';
                                                                }
                                                            }
                                                        @endphp
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input taxcheck" type="checkbox" {{ $checked }} disabled>
                                                            <label class="form-check-label" for="{{ $tax->code }}">{{ "$tax->name ($tax->value %)" }}</label>
                                                        </div>
                                                    @endforeach
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
                                <div class="row card-header">
                                    <div class="col-6">
                                        <h5 class="card-title">Detail</h5>
                                    </div>
                                    <div class="col-6">
                                        <div class="row" style="padding-bottom: 5px;">
                                            <div class="col" style="text-align: right">
{{--                                                 <button type="button" onclick="syncInvoice()"
                                                class="btn btn-success" {{ $header->flag_bayar_real > 0 ? 'disabled' : '' }}><i class="fas fa-redo"></i> Sync Detail</button> --}}

                                                <button type="button" onclick="syncInvoice()"
                                                class="btn btn-success"><i class="fas fa-redo"></i> Sync Detail</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-bordered table-striped" id="" style="width: 150%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Service/Fee</th>
                                                <th>Description</th>
                                                <th>Reimbursment</th>
                                                <th>Unit</th>
                                                <th>Currency</th>
                                                <th>rate/unit</th>
                                                <th>ROE</th>
                                                <th>Total</th>
                                                <th>PPN</th>
                                                <th>PPH23</th>
                                                <th>Amount</th>
                                                {{-- <th>Note</th> --}}
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblSell">
                                            @php
                                                $total_ppn = 0;
                                                $total_pph23 = 0;
                                                $total_ppn1 = 0;
                                                $total_before_vat = 0;
                                                $total_invoice = 0;
                                            @endphp
                                            @foreach ($details as $key => $detail)
                                                @php
                                                    $total_ppn += $detail->vat;
                                                    $total_pph23 += $detail->pph23;
                                                    $total_ppn1 += $detail->ppn1;
                                                    $total_before_vat += $detail->sell_val;
                                                    $total_invoice += $detail->subtotal;
                                                @endphp
                                                <tr>
                                                    <td align="center">{{ $key + 1 }}</td>
                                                    <td>{{ $detail->charge_name }}</td>
                                                    <td>{{ $detail->desc }}</td>
                                                    <td align="center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs" <?= ($header->reimburse_flag == 1 ? 'checked' : '') ?> onclick="return false;" /></td>
                                                    <td>{{ $detail->qty }}</td>
                                                    <td>{{ $detail->currency_code }}</td>
                                                    <td align="right">{{ number_format($detail->sell, 2, ',', '.') }}</td>
                                                    <td align="right">{{ number_format($detail->rate, 2, ',', '.') }}</td>
                                                    <td align="right">{{ number_format($detail->sell_val, 2, ',', '.') }}</td>
                                                    <td align="right">{{ number_format($detail->vat, 2, ',', '.') }}</td>
                                                    <td align="right">{{ number_format($detail->pph23, 2, ',', '.') }}</td>
                                                    <td align="right">{{ number_format($detail->ppn1, 2, ',', '.') }}</td>
                                                    <td align="right">{{ number_format($detail->subtotal, 2, ',', '.') }}</td>
                                                    <td>
                                                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="deleteInvoice({{ $detail->id }})" ><i class="fa fa-trash"></i>  &nbsp;Delete &nbsp; &nbsp; &nbsp;</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @php
                                            $total_ppn = number_format($total_ppn, 2, '.', ',');
                                            $total_pph23 = number_format($total_pph23, 2, '.', ',');
                                            $total_ppn1 = number_format($total_ppn1, 2, '.', ',');
                                            $total_before_vat = number_format($total_before_vat, 2, '.', ',');
                                            $total_invoice = number_format($total_invoice, 2, '.', ',');
                                            @endphp
                                            <tr id='row_total_before_vat'>
                                                <td colspan='8' class='text-right'><span id='lbl_total_before_vat'>Total</span></td>
                                                <td class='text-right'>
                                                    <input type='text' class='form-control' name='total_before_vat' id='total_before_vat' value="{{ $total_before_vat }}" readonly/>
                                                </td>
                                                <td class='text-right'>
                                                    <input type='text' class='form-control' name='input_ppn' id='input_ppn' value="{{ $total_ppn }}" readonly/>
                                                </td>
                                                <td class='text-right'>
                                                    <input type='text' class='form-control' name='input_pph23' id='input_pph23' value="{{ $total_pph23 }}" readonly/>
                                                </td>
                                                <td class='text-right'>
                                                    <input type='text' class='form-control' name='input_pph23' id='input_pph23' value="{{ $total_ppn1 }}" readonly/>
                                                </td>
                                                <td class='text-right'>
                                                    <input type='text' class='form-control' name='total_invoice' id='total_invoice' value="{{ $total_invoice }}" readonly/>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                  <a href="{{ url()->previous() }}" class="btn btn-default float-left mr-2">
                                    <i class="fa fa-angle-left"></i> Kembali
                                  </a>
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
        let is_ppn = 0;
        let is_pph23 = 0;

        if (@json($header->total_vat) > 0) {
            is_ppn = 1;
        }
        if (@json($header->pph23) > 0) {
            is_pph23 = 1;
        }
        $.ajax({
            type: 'get',
            url: `{{ route('invoice.syncInvoiceDetail') }}`,
            data: {
                t_booking_id : @json($header->t_booking_id),
                invoice_id : @json($header->id),
                type_invoice : 'sell',
                is_ppn : is_ppn,
                is_pph23 : is_pph23,
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
</script>
@endpush
