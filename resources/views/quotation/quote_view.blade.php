@extends('layouts.master')


@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Quotation</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('quotation.list') }}">List Quote</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Header</h3>
                    </div>
                    <!-- /.card-header -->
                    @if(count($errors)>0)
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>  		
                        @endforeach
                    @endif
                    <!-- form start -->
                    <form action="" class="eventInsForm" method="post" target="_self" name="formku" id="formku" action=""> 
                    {{ csrf_field() }}   
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Quote Number</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="quote_no" id="quote_no" placeholder="Quote No ..." value="{{ $quote->quote_no }}" disabled>
                                        <input type="hidden" name="id_quote" name="id_quote" value="{{ $quote->id }}">
                                    </div>
                                </div>
                                <div class="row mb-3 mt-3">
                                    <div class="col-md-4">
                                        <label>Version</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="version" id="version" placeholder="Version ..." value="{{ $quote->version_no }}" onkeyup="numberOnly(this);" readonly>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <input type="checkbox" name="final" id="final" style="margin-right: 5px" disabled @if ($quote->final_flag == 1)
                                            checked
                                        @endif><label> FINAL</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="date" id="datex" value="{{ \Carbon\Carbon::parse($quote->quote_date)->format('m/d/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate" disabled/>
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Customer</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $quote->client_name }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Activity</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" value="{{ $quote->activity }}" disabled>
                                    </div>
                                    <div class="col-md-4" style="padding: 10px">
                                        @foreach ($loaded as $l)
                                        <input type="radio" name="loaded" id="loaded" value="{{ $l->id }}" disabled @if ($l->id == $quote->t_mloaded_type_id)
                                            checked
                                        @endif>
                                        <label>{{ $l->loaded_type }}</label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>From</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" list="fromx" class="form-control" name="from" id="from" placeholder="From ..." value="{{ $quote->from_text }}" disabled>
                                        <input type="hidden" name="from_id" id="from_id">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Commodity</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="commodity" id="commodity" placeholder="Commodity ..." value="{{ $quote->commodity }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>PIC</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $quote->name_pic }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Shipment By</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" name="shipment" id="shipment" style="width: 100%;" disabled>
                                            <option selected>-- Select Shipment --</option>
                                            <option value="SEA" @if ($quote->shipment_by == "SEA")
                                                selected
                                            @endif>SEA</option>
                                            <option value="AIR" @if ($quote->shipment_by == "AIR")
                                                selected
                                            @endif>AIR</option>
                                            <option value="LAND" @if ($quote->shipment_by == "LAND")
                                                selected
                                            @endif>LAND</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Terms</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $quote->incoterns_code }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>To</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" list="tox" class="form-control" name="to" id="to" placeholder="To ..." value="{{ $quote->to_text }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Pieces</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="pieces" id="pieces" onkeyup="numberOnly(this);" placeholder="Pieces ..." value="{{ $quote->pieces }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Weight</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="weight" id="weight" onkeyup="numberOnly(this);" placeholder="Weight ..." value="{{ $quote->weight }}" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control select2bs44" name="uom_weight" id="uom_weight" style="width: 100%;" disabled>
                                            <option selected>-- Select UOM --</option>
                                        @foreach ($uom as $u)
                                            <option value="{{ $u->id }}" @if ($quote->weight_uom_id == $u->id)
                                                selected
                                            @endif>{{ $u->uom_code }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Volume</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="volume" id="volume" onkeyup="numberOnly(this);" placeholder="Volume ..." value="{{ $quote->volume }}" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control select2bs44" name="uom_volume" id="uom_volume" style="width: 100%;" disabled>
                                            <option selected>-- Select UOM --</option>
                                        @foreach ($uom as $u)
                                            <option value="{{ $u->id }}" @if ($quote->volume_uom_id == $u->id)
                                                selected
                                            @endif>{{ $u->uom_code }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="hazard" disabled @if ($quote->hazardous_flag == 1)
                                                checked
                                            @endif>
                                            <label for="customCheckbox1" class="custom-control-label">Is Hazardous</label>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="hazard_txt" placeholder="Material Information ....." value="{{ $quote->hazardous_info }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="">Additional Information</label>
                                    </div>
                                    <div class="col-md 10">
                                        <textarea class="form-control" rows="5" name="additional" placeholder="Additional Information ..." disabled>{{ $quote->additional_info }}</textarea>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox2" name="delivery" @if ($quote->pickup_delivery_flag == 1)
                                            checked
                                            @endif disabled>
                                            <label for="customCheckbox2" class="custom-control-label">Need Pickup/ Delivery</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox3" name="custom" @if ($quote->custom_flag == 1)
                                            checked
                                            @endif disabled>
                                            <label for="customCheckbox3" class="custom-control-label">Need Custom Clearance</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox4" name="fumigation" @if ($quote->fumigation_flag == 1)
                                            checked
                                            @endif disabled>
                                            <label for="customCheckbox4" class="custom-control-label">Fumigation Required</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="customCheckbox5" name="goods" @if ($quote->stackable_flag == 1)
                                            checked
                                            @endif disabled>
                                            <label for="customCheckbox5" class="custom-control-label">Goods are Stackable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- /.card-body -->
                </form>
                </div>
                 <!-- /.card -->
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dimension Info</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table_lowm table-bordered">
                           <thead>
                               <tr>
                                   <th width="1%">No</th>
                                   <th width="10%">Length</th>
                                   <th width="10%">Width</th>
                                   <th width="10%">Height</th>
                                   <th width="15%">UOM</th>
                                   <th width="10%">Pieces</th>
                                   <th width="9%">Wight</th>
                                   <th width="15%">UOM</th>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach ($dimension as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->le_dimen }}</td>
                                    <td>{{ $row->width }}</td>
                                    <td>{{ $row->height }}</td>
                                    <td>{{ $row->uom_code }}</td>
                                    <td>{{ $row->pieces }}</td>
                                    <td>{{ $row->wight }}</td>
                                    <td>{{ $row->uom_code }}</td>
                                </tr>
                               @endforeach
                           </tbody>
                       </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Shipping Detail</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table_lowm table-bordered" id="Table1">
                           <thead>
                               <tr>
                                   <th width="2%">No</th>
                                   @if ($quote->shipment_by == 'LAND')
                                   <th width="15%">Truck Size</th>
                                   @else
                                   <th width="15%">Carrier</th>
                                   <th width="10%">Routing</th>
                                   <th width="5%" style="font-size: 12px">Transit time(days)</th>
                                   @endif
                                   <th>Rate</th>
                                   <th>Cost</th>
                                   <th>Sell</th>
                                   <th width="5%">Qty</th>
                                   <th>Cost Value</th>
                                   <th>Sell Value</th>
                                   <th width="5%">Vat</th>
                                   <th width="10%">Total</th>
                                   <th width="10%">Note</th>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach ($shipping as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if ($quote->shipment_by == 'LAND')
                                    <td>{{ $row->truck_size }}</td>
                                    @else
                                    <td>{{ $row->name_carrier }}</td>
                                    <td>{{ $row->routing }}</td>
                                    <td>{{ $row->transit_time }}</td>
                                    @endif
                                    <td>{{ number_format($row->rate,2,',','.') }}</td>
                                    <td>{{ number_format($row->cost,2,',','.') }}</td>
                                    <td>{{ number_format($row->sell,2,',','.') }}</td>
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ number_format($row->cost_val,2,',','.') }}</td>
                                    <td>{{ number_format($row->sell_val,2,',','.') }}</td>
                                    <td>{{ number_format($row->vat,2,',','.') }}</td>
                                    <td>{{ number_format($row->subtotal,2,',','.') }}</td>
                                    <td>{{ $row->notes }}</td>
                                </tr>
                               @endforeach
                           </tbody>
                       </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail quote</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table_lowm table-bordered" id="Table2">
                           <thead>
                               <tr>
                                   <th>No</th>
                                   <th>Service/Fee</th>
                                   <th>Description</th>
                                   <th>Reimbursment</th>
                                   <th>Currency</th>
                                   <th>Rate</th>
                                   <th>Cost</th>
                                   <th>Sell</th>
                                   <th>Qty</th>
                                   <th>Cost Value</th>
                                   <th>Sell Value</th>
                                   <th>Vat</th>
                                   <th>Total</th>
                                   <th>Note</th>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach ($quoteDtl as $row)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->name_charge }}</td>
                                        <td>{{ $row->desc }}</td>
                                        <td><input type="checkbox"  @if ($row->reimburse_flag == 1)checked @endif></td>
                                        <td>{{ $row->code_currency }}</td>
                                        <td>{{ number_format($row->rate,2,',','.') }}</td>
                                        <td>{{ number_format($row->cost,2,',','.') }}</td>
                                        <td>{{ number_format($row->sell,2,',','.') }}</td>
                                        <td>{{ $row->qty }}</td>
                                        <td>{{ number_format($row->cost_val,2,',','.') }}</td>
                                        <td>{{ number_format($row->sell_val,2,',','.') }}</td>
                                        <td>{{ number_format($row->vat,2,',','.') }}</td>
                                        <td>{{ number_format($row->subtotal,2,',','.') }}</td>
                                        <td>{{ $row->notes }}</td> 
                                   </tr>
                               @endforeach
                           </tbody>
                       </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Profit Analysis</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                       <table class="table table_lowm table-bordered">
                           <thead>
                               <tr>
                                   <td class="text-center">Carrier</td>
                                   <td class="text-center">Routing</td>
                                   <td class="text-center">Transit Time</td>
                                   <td class="text-center">Total Cost</td>
                                   <td class="text-center">Total Sell</td>
                                   <td class="text-center">Total Profit</td>
                                   <td class="text-center">Profil PCT</td>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach ($profit as $row)
                                <tr class="text-center">
                                    <td>{{ $row->carrier_code }}</td>
                                    <td>{{ $row->routing }}</td>
                                    <td>{{ $row->transit_time }}</td> 
{{--                                     <td>{{ $row->code_currency .' '. number_format($row->total_cost,2,',','.') }}</td>
                                    <td>{{ $row->code_currency.' '. number_format($row->total_sell,2,',','.') }}</td>
                                    <td>{{ $row->code_currency.' '. number_format($row->total_profit,2,',','.') }}</td> --}}
                                    <td>{{ number_format($row->total_cost,2,',','.') }}</td>
                                    <td>{{ number_format($row->total_sell,2,',','.') }}</td>
                                    <td>{{ number_format($row->total_profit,2,',','.') }}</td>
                                    <td>{{ $row->profit_pct }}%</td>
                                </tr>                                   
                               @endforeach
                           </tbody>
                       </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3 mb-3">
                @if ($quote->status == 0 && $quote->final_flag == 1)
                    @if ($role_user == 'Administrator' || $role_user == 'Sales Manager')
                        <a href="javascript:;" class="btn btn-success float-right" onclick="approve('{{ $quote->id }}')"><i class="fa fa-check"></i> Approve</a>
                    @endif
                @endif
                <a href="{{ route('quotation.list') }}" class="btn btn-secondary float-left"><i class="fa fa-angle-left"></i> Back</a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('after-scripts')
    <script>
        function approve(id)
        {
            Swal.fire({
                title: 'Konfirmasi Approved!',
                text: 'Apakah anda yakin ingin meng Approve data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
                confirmButtonText: "Approved",
		        cancelButtonText: "cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('quotation.quoteApprove') }}",
                        data: {id:id},
                        dataType: 'json',
                        cache: false,
                        success: function (response) {
                            location.replace("{{ route('quotation.list') }}");
                        },
                    });
                }
            });
        }   
    </script>
@endpush