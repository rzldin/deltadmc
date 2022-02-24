@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-plus"></i>
                Create Booking (New Version)
            </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">New Version</li>
          </ol>
        </div>
      </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">
                            <strong>Header</strong>
                        </h3>
                        <h5 class="card-tittle float-right">
                            {{ ucwords($quote->activity) }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Header</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Road Consigment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-messages-tab" data-toggle="pill" href="#custom-content-below-messages" role="tab" aria-controls="custom-content-below-messages" aria-selected="false">Schedule</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#custom-content-below-settings" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Charges and Fee</a>
                            </li>
                        </ul>
                        @if(count($errors)>0)
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>  		
                        @endforeach
                    @endif
                        <div class="tab-content" id="custom-content-below-tabContent">
                            <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                <div class="container-fluid mt-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="{{ route('booking.doAddVersion') }}" method="post" id="formku"> 
                                            {{ csrf_field() }}
                                            <?php $verse = $versionNow+1; ?>
                                            <input type="hidden" name="new_version" value="true">
                                            <input type="hidden" name="booking_idx" value="{{ Request::segment(3) }}">
                                            @if ($quote->activity == 'domestic')
                                            {{\App\Http\Controllers\BookingController::edit_header_domestic($quote, $verse)}}
                                            @elseif($quote->activity == 'export')
                                            {{\App\Http\Controllers\BookingController::edit_header_export($quote, $verse)}}
                                            @elseif($quote->activity == 'import')
                                            {{\App\Http\Controllers\BookingController::edit_header_import($quote, $verse)}}
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Commodity</h3>
                                                </div>
                                                <div class="card-body table-responsive p-0">
                                                   <table class="table table_lowm table-bordered" id="myTable2" width="140%">
                                                       <thead>
                                                           <tr>
                                                               <th width="1%">#</th>
                                                               <th width="10%">Hs Code</th>
                                                               <th>Description</th>
                                                               <th>Origin</th>
                                                               <th width="15%">Qty Commodity</th>
                                                               <th width="15%">Qty Packages</th>
                                                               <th width="15%">Weight</th>
                                                               <th>Netto</th>
                                                               <th width="15%">Volume</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                            @foreach ($commodity as $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->hs_code }}</td>
                                                                <td>{{ $item->desc }}</td>
                                                                <td>{{ $item->origin }}</td>
                                                                <td>{{ $item->qty_comm }}</td>
                                                                <td>{{ $item->qty_packages }}</td>
                                                                <td>{{ $item->weight }}</td>
                                                                <td>{{ $item->netto }}</td>
                                                                <td>{{ $item->volume }}</td>
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
                                                    <h3 class="card-title">Packages</h3>
                                                </div>
                                                <div class="card-body table-responsive p-0">
                                                   <table class="table table_lowm table-bordered" id="myTable2" width="140%">
                                                       <thead>
                                                        <tr>
                                                            <th width="1%">#</th>
                                                            <th width="35%">Merk</th>
                                                            <th width="15%">Qty</th>
                                                            <th width="15%">Unit</th>
                                                        </tr>
                                                       </thead>
                                                       <tbody>
                                                            @foreach ($packages as $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->desc }}</td>
                                                                <td>{{ $item->qty }}</td>
                                                                <td>{{ $item->code_b }}</td>
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
                                                    <h3 class="card-title">Container</h3>
                                                </div>
                                                <div class="card-body table-responsive p-0">
                                                    @if ($quote->activity == 'export')
                                                    <table class="table table_lowm table-bordered" id="myTable3" width="200%">
                                                    @else
                                                    <table class="table table_lowm table-bordered" width="100%">
                                                    @endif
                                                       <thead>
                                                            <tr>
                                                                <th width="1%">#</th>
                                                                <th width="10%">Container Number</th>
                                                                <th width="5%">Size</th>
                                                                <th width="10%">Loaded Type</th>
                                                                <th width="10%">Container Type</th>
                                                                <th width="10%">Seal No</th>
                                                                @if ($quote->activity == 'export')
                                                                <th width="10%">VGM</th>
                                                                <th width="7%">Uom</th>
                                                                <th width="10%">Resp.Party</th>
                                                                <th width="10%">Auth.Person</th>
                                                                <th width="8%">M.o.w</th>
                                                                <th width="10%">Weighing Party</th>
                                                                @endif
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            @foreach ($container as $row)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $row->container_no }}</td>
                                                                <td>{{ $row->size }}</td>
                                                                <td>{{ $row->loaded_type }}</td>
                                                                <td>{{ $row->container_type }}</td>
                                                                <td>{{ $row->seal_no }}</td>
                                                                @if ($quote->activity == 'export')
                                                                <td>{{ $row->vgm }}</td>
                                                                <td>{{ $row->uom_code }}</td>
                                                                <td>{{ $row->responsible_party }}</td>
                                                                <td>{{ $row->authorized_person }}</td>
                                                                <td>{{ $row->method_of_weighing }}</td>
                                                                <td>{{ $row->weighing_party }}</td>
                                                                @endif
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
                                                    <h3 class="card-title">Document</h3>
                                                </div>
                                                <div class="card-body table-responsive p-0">
                                                   <table class="table table_lowm table-bordered" id="Table1">
                                                       <thead>
                                                           <tr>
                                                               <th width="1%">#</th>
                                                               <th width="35%">Document Type</th>
                                                               <th width="15%">Document Number</th>
                                                               <th width="15%">Document Date</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                           @foreach ($doc as $row)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $row->name }}</td>
                                                                <td>{{ $row->doc_no }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($row->doc_date)->format('m/d/Y') }}</td>
                                                            </tr>
                                                           @endforeach
                                                       </tbody>
                                                   </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3 mt-3">
                                            <a href="{{ url('booking/edit_booking/'.$quote->id) }}" class="btn btn-default float-left mr-2"> 
                                                <i class="fa fa-angle-left"></i> Back 
                                            </a>
                                            <button type="button" class="btn btn-primary float-right" id="saveData"><i class="fa fa-paper-plane"></i> Submit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>  
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                                <section class="content">
                                    <div class="container-fluid mt-3">
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    
                                                </div>
                                                <div class="card-body">
                                                    <table id="myTable" class="table table-bordered table-striped" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <td width="15%">No. SJ</td>
                                                                <td width="15%">Vehicle Type</th>
                                                                <td width="10%">Vehicle No</th>
                                                                <td width="20%">Driver</td>
                                                                <td width="10%">Driver Phone</td>
                                                                <td>Pickup Address</td>
                                                                <td>Delivery Address</td>
                                                                <td>Notes</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($roadCons as $row)
                                                            <tr>
                                                                <td>{{ $row->no_sj }}</td>
                                                                <td>{{ $row->type }}</td>
                                                                <td>{{ $row->vehicle_no }}</td>
                                                                <td>{{ $row->driver }}</td>
                                                                <td>{{ $row->driver_phone }}</td>
                                                                <td>{{ $row->pickup_addr }}</td>
                                                                <td>{{ $row->delivery_addr }}</td>
                                                                <td>{{ $row->notes }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>                                
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-messages" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
                                <section class="content">
                                    <div class="container-fluid mt-3">
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                   
                                                </div>
                                                <div class="card-body">
                                                    <table id="myTablex" class="table table-bordered table-striped" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <td>No.</th>
                                                                <td>Schedule</td>
                                                                <td>Description</th>
                                                                <td>Time</td>
                                                                <td>Notes</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($schedule as $row)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $row->desc }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($row->date) }}</td>
                                                                <td>{{ $row->notes }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section> 
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-settings" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
                                <section class="content">
                                    <div class="container-fluid mt-3">
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h5 class="card-title">Cost</h5>
                                                    <a href="{{ url('booking/preview/'.$quote->id) }}" class="btn btn-info float-right" target="_blank"><i class="fa fa-file"></i> Preview Booking</a>
                                                </div>
                                                <div class="card-body table-responsive p-0">
                                                    <table class="table table-bordered table-striped" id="myTable2" style="width: 150%">
                                                        <thead>
                                                            <tr>
                                                                <th width="3%">No.</th>
                                                                <th width="10%">Service/Fee</th>
                                                                <th width="10%">Description</th>
                                                                <th width="7%">Reimbursment</th>
                                                                <th width="5%">Unit</th>
                                                                <th width="5%">Currency</th>
                                                                <th width="7%">rate/unit</th>
                                                                <th width="8%">Total</th>
                                                                <th width="8%">ROE</th>
                                                                <th width="8%">Vat</th>
                                                                <th width="8%">Amount</th>
                                                                <th width="10%">Paid To</th>
                                                                <th width="7%">Note</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php    
                                                                $total = 0;
                                                                $amount = 0;
                                                            ?>
                                                            @foreach ($sellCost as $row)

                                                            <?php 
                                                                $total = ($row->qty * $row->cost_val); 
                                                                $amount = ($total * $row->rate) + $row->vat; 
                                                            ?>

                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $row->charge_name }}</td>
                                                                <td>{{ $row->desc.' | Routing: '.$row->routing.' | Transit time : '.$row->transit_time }}</td>
                                                                <td>
                                                                    <input type="checkbox" name="reimburs" style="width:50px;" id="reimburs" @if ($row->reimburse_flag == 1)
                                                                        checked
                                                                    @endif></td>
                                                                </td>
                                                                <td>{{ $row->qty }}</td>
                                                                <td>{{ $row->code_cur }}</td>
                                                                <td class="text-right">{{ number_format($row->cost_val,2,',','.') }}</td>
                                                                <td class="text-right">{{ number_format(($row->qty * $row->cost_val),2,',','.') }} </td>
                                                                <td class="text-right">{{ number_format($row->rate,2,',','.') }}</td>
                                                                <td class="text-right">{{ number_format($row->vat,2,',','.') }}</td>
                                                                <td class="text-right">{{ number_format($amount,2,',','.') }}</td>
                                                                <td>{{ $row->paid_to }}</td>
                                                                <td></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h5>Sell</h5>
                                                </div>
                                                <div class="card-body table-responsive p-0">
                                                    <table class="table table-bordered table-striped" id="myTable2" style="width: 150%">
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
                                                                <th>Vat</th>
                                                                <th>Amount</th>
                                                                <th style="width:10%;">Bill To</th>
                                                                <th>Note</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php    
                                                                $total2 = 0;
                                                                $amount2 = 0;
                                                            ?>
                                                            @foreach ($sellCost as $row)

                                                            <?php 
                                                                $total2 = ($row->qty * $row->sell_val); 
                                                                $amount2 = ($total2 * $row->rate) + $row->vat;
                                                            ?>

                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $row->charge_name }}</td>
                                                                <td>{{ $row->desc.' | Routing: '.$row->routing.' | Transit time : '.$row->transit_time }}</td>
                                                                <td>
                                                                    <input type="checkbox" name="reimburs" style="width:50px;" id="reimburs" @if ($row->reimburse_flag == 1)
                                                                        checked
                                                                    @endif></td>
                                                                </td>
                                                                <td>{{ $row->qty }}</td>
                                                                <td>{{ $row->code_cur }}</td>
                                                                <td class="text-right">{{ number_format($row->sell_val,2,',','.') }}</td>
                                                                <td class="text-right">{{ number_format($total2,2,',','.') }} </td>
                                                                <td class="text-right">{{ number_format($row->rate,2,',','.') }}</td>
                                                                <td class="text-right">{{ number_format($row->vat,2,',','.') }}</td>
                                                                <td class="text-right">{{ number_format($amount2,2,',','.') }}</td>
                                                                <td>{{ $row->bill_to }}</td>
                                                                <td></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h5>Profit Analysis</h5>
                                                </div>
                                                <div class="card-body">
                                                    <table id="myTablex" class="table table-bordered table-striped" width="100%">
                                                        <thead>
                                                          <tr>
                                                            @if ($quote->shipment_by != 'LAND')
                                                            <td class="text-center">Carrier</td>
                                                            <td class="text-center">Routing</td>
                                                            <td class="text-center">Transit Time</td>
                                                            @endif
                                                            <td>Total Cost</th>
                                                            <td>Total Sell</td>
                                                            <td>Total Profit</th>
                                                            <td>Profit PCT</td>
                                                          </tr>
                                                        </thead>
                                                        <tbody id="tblProfit">
                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="client_addrx" value="{{ $quote->client_addr_id }}">
    <input type="hidden" id="client_picx" value="{{ $quote->client_pic_id }}">
    <input type="hidden" id="shipper_addrx" value="{{ $quote->shipper_addr_id }}">
    <input type="hidden" id="shipper_picx" value="{{ $quote->shipper_pic_id }}">
    <input type="hidden" id="consignee_addrx" value="{{ $quote->consignee_addr_id }}">
    <input type="hidden" id="consignee_picx" value="{{ $quote->consignee_pic_id }}">
    <input type="hidden" id="notifyParty_addrx" value="{{ $quote->not_party_addr_id }}">
    <input type="hidden" id="notifyParty_picx" value="{{ $quote->not_party_pic_id }}">
    <input type="hidden" id="agent_addrx" value="{{ $quote->agent_addr_id }}">
    <input type="hidden" id="agent_picx" value="{{ $quote->agent_pic_id }}">
    <input type="hidden" id="shipline_addrx" value="{{ $quote->shpline_addr_id }}">
    <input type="hidden" id="shipline_picx" value="{{ $quote->shpline_pic_id }}">
    <input type="hidden" id="vendor_addrx" value="{{ $quote->vendor_addr_id }}">
    <input type="hidden" id="vendor_picx" value="{{ $quote->vendor_pic_id }}">
    <input type="hidden" id="countCom" value="{{ $countCom }}">
    <input type="hidden" id="countPack" value="{{ $countPack }}">
    <input type="hidden" id="countCon" value="{{ $countCon }}">
</section>
@push('after-scripts')
    <script>
    
        function get_customer(val)
        {
            $.ajax({
                url: "{{ route('get.customer') }}",
                type: "POST",
                data : "company_id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    $("#customer_add").html(final)
                }
            })
        }

        function get_shipper(val)
        {
            $.ajax({
                url: "{{ route('get.customer') }}",
                type: "POST",
                data : "company_id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    $("#shipper").html(final)
                }
            })
        }

        function get_consignee(val)
        {
            $.ajax({
                url: "{{ route('get.customer') }}",
                type: "POST",
                data : "company_id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    $("#consignee").html(final)
                }
            })
        }

        function get_notParty(val)
        {
            $.ajax({
                url: "{{ route('get.customer') }}",
                type: "POST",
                data : "company_id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    $("#notify_party").html(final)
                }
            })
        }

        function get_agent(val)
        {
            $.ajax({
                url: "{{ route('get.customer') }}",
                type: "POST",
                data : "company_id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    $("#agent").html(final)
                }
            })
        }

        function get_shipline(val)
        {
            $.ajax({
                url: "{{ route('get.customer') }}",
                type: "POST",
                data : "company_id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    $("#shipping_line").html(final)
                }
            })
        }

        function get_vendor(val)
        {
            $.ajax({
                url: "{{ route('get.customer') }}",
                type: "POST",
                data : "company_id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    $("#vendor").html(final)
                }
            })
        }


        function client_detail(val){
            if(val!= ''){

                let client_addr     = $('#client_addrx').val();
                let client_pic      = $('#client_picx').val();
                let client_addrx    = 0;
                let client_picx     = 0;

                if(client_addr == null){
                    client_addrx = 0
                }else{
                    client_addrx = client_addr
                }

                if(client_pic == null){
                    client_picx = 0
                }else{
                    client_picx = client_pic
                }

                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: {
                        id      : val,
                        pic_id  : client_picx,
                        addr_id : client_addrx
                    },
                    dataType: "html",
                    success: function(result) {
                        var final = JSON.parse(result);

                        $("#customer_addr").html(final[0]);
                        $("#customer_pic").html(final[1]);
                    }
                });
            }
        }

        function shipper_detail(val){
            if(val!= ''){

                let shipper_addr     = $('#shipper_addrx').val();
                let shipper_pic      = $('#shipper_picx').val();
                let shipper_addrx    = 0;
                let shipper_picx     = 0;

                if(shipper_addr == null){
                    shipper_addrx = 0
                }else{
                    shipper_addrx = shipper_addr
                }

                if(shipper_pic == null){
                    shipper_picx = 0
                }else{
                    shipper_picx = shipper_pic
                }
                
                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: {
                        id      : val,
                        pic_id  : shipper_picx,
                        addr_id : shipper_addrx
                    },
                    dataType: "html",
                    success: function(result) {
                        var final = JSON.parse(result);
                        var check = final[2];
                        $("#shipper_addr").html(final[0]);
                        $("#shipper_pic").html(final[1]);
                    }
                });
            }
        }


        function consignee_detail(val)
        {
            if(val!= ''){

                let consignee_addr     = $('#consignee_addrx').val();
                let consignee_pic      = $('#consignee_picx').val();
                let consignee_addrx    = 0;
                let consignee_picx     = 0;

                if(consignee_addr == null){
                    consignee_addrx = 0
                }else{
                    consignee_addrx = consignee_addr
                }

                if(consignee_pic == null){
                    consignee_picx = 0
                }else{
                    consignee_picx = consignee_pic
                }

                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: {
                        id      : val,
                        pic_id  : consignee_picx,
                        addr_id : consignee_addrx
                    },
                    dataType: "html",
                    success: function(result) {
                        var final = JSON.parse(result);
                        $("#consignee_addr").html(final[0]);
                        $("#consignee_pic").html(final[1]);
                    }
                });
            }
        }

        function not_detail(val)
        {
            if(val!= ''){

                let notifyParty_addr     = $('#notifyParty_addrx').val();
                let notifyParty_pic      = $('#notifyParty_picx').val();
                let notifyParty_addrx    = 0;
                let notifyParty_picx     = 0;

                if(notifyParty_addr == null){
                    notifyParty_addrx = 0
                }else{
                    notifyParty_addrx = notifyParty_addr
                }

                if(notifyParty_pic == null){
                    notifyParty_picx = 0
                }else{
                    notifyParty_picx = notifyParty_pic
                }

                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: {
                        id      : val,
                        pic_id  : notifyParty_picx,
                        addr_id : notifyParty_addrx
                    },
                    dataType: "html",
                    success: function(result) {
                        var final = JSON.parse(result);
                        $("#not_addr").html(final[0]);
                        $("#not_pic").html(final[1]);
                    }
                });
            }
        }

        function agent_detail(val)
        {   
            if(val!= ''){

                let agent_addr     = $('#agent_addrx').val();
                let agent_pic      = $('#agent_picx').val();
                let agent_addrx    = 0;
                let agent_picx     = 0;

                if(agent_addr == null){
                    agent_addrx = 0
                }else{
                    agent_addrx = agent_addr
                }

                if(agent_pic == null){
                    agent_picx = 0
                }else{
                    agent_picx = agent_pic
                }

                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: {
                        id      : val,
                        pic_id  : agent_picx,
                        addr_id : agent_addrx
                    },
                    dataType: "html",
                    success: function(result) {
                        var final = JSON.parse(result);
                        $("#agent_addr").html(final[0]);
                        $("#agent_pic").html(final[1]);
                    }
                });
            }
        }

        function shipline_detail(val)
        {
            if(val!= ''){

                let shipline_addr     = $('#shipline_addrx').val();
                let shipline_pic      = $('#shipline_picx').val();
                let shipline_addrx    = 0;
                let shipline_picx     = 0;

                if(shipline_addr == null){
                    shipline_addrx = 0
                }else{
                    shipline_addrx = shipline_addr
                }

                if(shipline_pic == null){
                    shipline_picx = 0
                }else{
                    shipline_picx = shipline_pic
                }

                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: {
                        id      : val,
                        pic_id  : shipline_picx,
                        addr_id : shipline_addrx
                    },
                    dataType: "html",
                    success: function(result) {
                        var final = JSON.parse(result);
                        $("#shipline_addr").html(final[0]);
                        $("#shipline_pic").html(final[1]);
                    }
                });
            }
        }

        function vendor_detail(val)
        {
            if(val!= ''){
                
                let vendor_addr     = $('#vendor_addrx').val();
                let vendor_pic      = $('#vendor_picx').val();
                let vendor_addrx    = 0;
                let vendor_picx     = 0;

                if(vendor_addr == null){
                    vendor_addrx = 0
                }else{
                    vendor_addrx = vendor_addr
                }

                if(vendor_pic == null){
                    vendor_picx = 0
                }else{
                    vendor_picx = vendor_pic
                }

                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: {
                        id      : val,
                        pic_id  : vendor_picx,
                        addr_id : vendor_addrx
                    },
                    dataType: "html",
                    success: function(result) {
                        var final = JSON.parse(result);
                        $("#vendor_addr").html(final[0]);
                        $("#vendor_pic").html(final[1]);
                    }
                });
            }
        }

        function loadProfit(id){
            $.ajax({
                type:"POST",
                url:"{{ route('quotation.quote_loadProfit') }}",
                data:{
                    id       : id
                },
                dataType:"html",
                success:function(result){
                    var tabel = JSON.parse(result);
                    $('#tblProfit').html(tabel);
                }
            })
        }

    $("#saveData").click(function(){
        if($.trim($("#booking_no").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Booking Number',
                icon: 'error'
            })
        }else if($.trim($("#booking_date").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Booking Date',
                icon: 'error'
            })
        }else{
            $(this).prop('disabled', true).text('Please Wait ...');
            $('#formku').submit();
        }
    });

    $(function() {

        $('.select-ajax-port').select2({
          theme: "bootstrap4",
          ajax: {
            url: "{{route('booking.getPort')}}",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
              var query = {
                search: params.term,
              }

              // Query parameters will be ?search=[term]&type=public
              return query;
            },
            processResults: function(data, params) {
                console.log(data);
                return {results: data};
            },
            cache: true
          },
        });

        var pol = $('#pol');
        var pot = $('#pot');
        var podisc = $('#podisc');
        $.ajax({
            type: 'POST',
            url: "{{route('booking.getExistingPort')}}",
            data : {
                booking_id:$('#booking_id').val(),
            },
        }).then(function (data) {
            // create the option and append to Select2
            var pol_option = new Option(data.pol.text, data.pol.id, true, true);
            pol.append(pol_option).trigger('change');
            pol.trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });

            var pot_option = new Option(data.pot.text, data.pot.id, true, true);
            pot.append(pot_option).trigger('change');
            pot.trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });

            var podisc_option = new Option(data.pod.text, data.pod.id, true, true);
            podisc.append(podisc_option).trigger('change');
            podisc.trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });
        });

            get_customer({{ $quote->client_id }});
            client_detail({{ $quote->client_id }});

            get_shipper({{ $quote->shipper_id }});
            shipper_detail({{ $quote->shipper_id }})

            get_consignee({{ $quote->consignee_id }})
            consignee_detail({{ $quote->consignee_id }})

            get_notParty({{ $quote->not_party_id }})
            not_detail({{ $quote->not_party_id }})

            get_agent({{ $quote->agent_id }})
            agent_detail({{ $quote->agent_id }})

            get_shipline({{ $quote->shipping_line_id }})
            shipline_detail({{ $quote->shipping_line_id }})

            get_vendor({{ $quote->vendor_id }})
            vendor_detail({{ $quote->vendor_id }})

            loadProfit({{ $quote->t_quote_id }})

            $('#total_commo').val($('#countCom').val())
            $('#total_package').val($('#countPack').val())
            $('#total_container').val($('#countCon').val())
        });
    </script>
@endpush
@endsection