<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Booking Information</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Booking Number</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="booking_no" id="booking_no" placeholder="Booking No ..." value="{{ $quote->booking_no }}" @if ($quote->booking_no != null)
                        readonly
                        @endif>
                        <input type="hidden" name="id_booking" value="{{ $quote->id }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Booking Date</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="booking_date" id="booking_date" value="@if($quote->booking_date != null){{ \Carbon\Carbon::parse($quote->booking_date)->format('m/d/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Version No</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="version_no" id="version_no" placeholder="Version No ..." value="{{ $verse }}" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <?php 
                    if($quote->nomination_flag == 1){
                        $quote_no = 'Nomination';
                    }else{
                        $quote_no = $quote->quote_no;
                    }
                ?>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Quote Number</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="quote_no" id="quote_no" placeholder="Quote No ..." value="{{ $quote_no }}" readonly>
                        <input type="hidden" name="id_quote" id="id_quote" value="{{ $quote->t_quote_id }}">
                        <input type="hidden" name="activity" id="activityx" value="{{ $quote->activity }}">
                    </div>
                </div>
                <div class="row mb-3">
                    @if ($quote->nomination_flag == 0)
                    <div class="col-md-4">
                        <label>Quote Date</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="date" id="datex" class="form-control datetimepicker-input" value="{{ \Carbon\Carbon::parse($quote->quote_date)->format('m/d/Y') }}" data-target="#reservationdate" readonly/>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    @if ($quote->copy_booking != null)
                    <div class="col-md-12 mt-3">
                        Note : Copy From <strong>{{ $quote->copy_booking }}</strong>  
                    </div>
                    @endif
                    @else
                    <div class="col-md-12">
                        Note : Jenis Quote <strong>'Nomination'</strong>  
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Customs Information</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Document Type</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control select2bs44" style="width: 100%;" name="doctype" id="doctype" >
                            <option value="">-- Select Document --</option>
                            @foreach ($doc as $d)
                            <option value="{{ $d->id }}" @if ($quote->t_mdoc_type_id == $d->id)
                                selected
                            @endif>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Document Number</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="doc_no" id="doc_no" placeholder="Doc No ..." value="{{ $quote->custom_doc_no }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Document Date</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdateDOC" data-target-input="nearest">
                            <input type="text" name="doc_date" id="doc_date" value="@if($quote->custom_doc_date != null){{ \Carbon\Carbon::parse($quote->custom_doc_date)->format('m/d/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdateDOC" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="">IGM Number</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="igm_number" id="igm_number" placeholder="Enter IMG Number ..." value="{{ $quote->igm_no }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>IGM Date</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="igmdate" data-target-input="nearest">
                            <input type="text" name="igm_date" id="igm_date" value="@if($quote->igm_date != null){{ \Carbon\Carbon::parse($quote->igm_date)->format('m/d/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#igmdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="">Pos</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="pos" id="pos" placeholder="Enter Pos ..." value="{{ $quote->custom_pos }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="">Sub Pos</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="sub_pos" id="sub_pos" placeholder="Enter Sub Pos ..." value="{{ $quote->custom_subpos }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Shipment Information</h3>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Client</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="customer" id="customer" onchange="client_detail(this.value)">
                            <option value="" selected>-- Select Client --</option>
                            @foreach ($company as $c)
                            <option value="{{ $c->id }}" @if ($quote->client_id == $c->id)
                                selected
                            @endif>{{ $c->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="client-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Client Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="customer_addr" id="customer_addr">
                                <option value="" selected>-- Select Client Address --</option>
                                @foreach ($cust_addr as $item)
                                <option value="{{ $item->id }}" @if ($quote->client_addr_id == $item->id)
                                    selected
                                @endif>{{ $item->address }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Customer PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="customer_pic" id="customer_pic">
                                <option value="" selected>-- Select Client PIC --</option>
                                @foreach ($cust_pic as $item)
                                <option value="{{ $item->id }}" @if ($quote->client_pic_id == $item->id)
                                    selected
                                @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Shipper<font color="red">*</font></label>
                    </div>
                    <div class="col-md-5">
                        <select class="form-control select2bs44" style="width: 100%;" name="shipper" id="shipper" onchange="shipper_detail(this.value)">
                            <option value="" selected>-- Select Shipper --</option>
                            @foreach ($company as $item)
                            <option value="{{ $item->id }}" @if ($quote->shipper_id == $item->id)
                                selected
                            @endif>{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="col-md-2 mt-2">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="checkboxPrimary1" name="legal_doc" @if ($quote->legal_doc_flag == 1)
                                checked
                            @endif>
                            <label for="checkboxPrimary1">
                                Legal Doc
                            </label>
                        </div>
                    </div>
                </div>
                <div class="shipper-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Shipper Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="shipper_addr" id="shipper_addr">
                                <option value="" selected>-- Select Shipper Address --</option>
                                @foreach ($cust_addr as $item)
                                <option value="{{ $item->id }}" @if ($quote->shipper_addr_id == $item->id)
                                    selected
                                @endif>{{ $item->address }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Shipper PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="shipper_pic" id="shipper_pic">
                                <option value="" selected>-- Select Shipper PIC --</option>
                                @foreach ($cust_pic as $item)
                                <option value="{{ $item->id }}" @if ($quote->shipper_pic_id == $item->id)
                                    selected
                                @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Consignee<font color="red">*</font></label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="consignee" id="consignee" onchange="consignee_detail(this.value)">
                            <option value="" selected>-- Select Consignee --</option>
                            @foreach ($company as $item)
                            <option value="{{ $item->id }}" @if ($quote->consignee_id == $item->id)
                                selected
                            @endif>{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="consignee-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Consignee Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="consignee_addr" id="consignee_addr">
                                <option value="" selected>-- Select consignee Address --</option>
                                @foreach ($cust_addr as $item)
                                <option value="{{ $item->id }}" @if ($quote->consignee_addr_id == $item->id)
                                    selected
                                @endif>{{ $item->address }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Consignee PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="consignee_pic" id="consignee_pic">
                                <option value="" selected>-- Select consignee PIC --</option>
                                @foreach ($cust_pic as $item)
                                <option value="{{ $item->id }}" @if ($quote->consignee_pic_id == $item->id)
                                    selected
                                @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Notify Party<font color="red">*</font></label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="notify_party" id="notify_party" onchange="not_detail(this.value)">
                            <option value="" selected>-- Select Notify Party --</option>
                            @foreach ($company as $item)
                            <option value="{{ $item->id }}" @if ($quote->not_party_id == $item->id)
                                selected
                            @endif>{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="not-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Notify Party Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="not_addr" id="not_addr">
                                <option value="" selected>-- Select Notify Party Address --</option>
                                @foreach ($cust_addr as $item)
                                <option value="{{ $item->id }}" @if ($quote->not_party_addr_id == $item->id)
                                    selected
                                @endif>{{ $item->address }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Notify Party PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="not_pic" id="not_pic">
                                <option value="" selected>-- Select Notify Party PIC --</option>
                                @foreach ($cust_pic as $item)
                                <option value="{{ $item->id }}" @if ($quote->not_party_pic_id == $item->id)
                                    selected
                                @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Agent</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="agent" id="agent" onchange="agent_detail(this.value)">
                            <option value="" selected>-- Select Agent --</option>
                            @foreach ($company as $item)
                            <option value="{{ $item->id }}" @if ($quote->agent_id == $item->id)
                                selected
                            @endif>{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="agent-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Agent Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="agent_addr" id="agent_addr">
                                <option value="" selected>-- Select Agent Address --</option>
                                @foreach ($cust_addr as $item)
                                <option value="{{ $item->id }}" @if ($quote->agent_addr_id == $item->id)
                                    selected
                                @endif>{{ $item->address }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Agent PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="agent_pic" id="agent_pic">
                                <option value="" selected>-- Select Agent PIC --</option>
                                @foreach ($cust_pic as $item)
                                <option value="{{ $item->id }}" @if ($quote->agent_pic_id == $item->id)
                                    selected
                                @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Shipping Line</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="shipping_line" id="shipping_line" onchange="shipline_detail(this.value)">
                            <option value="">-- Select Shipping Line --</option>
                            @foreach ($company as $item)
                            <option value="{{ $item->id }}" @if ($quote->shipping_line_id == $item->id)
                                selected
                            @endif>{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="shipline-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Shipping Line Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="shipline_addr" id="shipline_addr">
                                <option value="" selected>-- Select Shipping Line Address --</option>
                                @foreach ($cust_addr as $item)
                                <option value="{{ $item->id }}" @if ($quote->shpline_addr_id == $item->id)
                                    selected
                                @endif>{{ $item->address }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Shipping Line PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="shipline_pic" id="shipline_pic">
                                <option value="" selected>-- Select consignee PIC --</option>
                                @foreach ($cust_pic as $item)
                                <option value="{{ $item->id }}" @if ($quote->shpline_pic_id == $item->id)
                                    selected
                                @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Place of Origin</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="pfo" id="pfo" class="form-control" value="{{ $quote->place_origin }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Place of Destination</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="pod" id="pod" class="form-control" value="{{ $quote->place_destination }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Vendor</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="vendor" id="vendor" onchange="vendor_detail(this.value)">
                            <option value="" selected>-- Select Vendor --</option>
                            @foreach ($company as $item)
                            <option value="{{ $item->id }}" @if ($quote->vendor_id == $item->id)
                                selected
                            @endif>{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="vendor-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Vendor Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="vendor_addr" id="vendor_addr">
                                <option value="" selected>-- Select Vendor Address --</option>
                                @foreach ($cust_addr as $item)
                                <option value="{{ $item->id }}" @if ($quote->vendor_addr_id == $item->id)
                                    selected
                                @endif>{{ $item->address }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Vendor PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="vendor_pic" id="vendor_pic">
                                <option value="" selected>-- Select Vendor PIC --</option>
                                @foreach ($cust_pic as $item)
                                <option value="{{ $item->id }}" @if ($quote->vendor_pic_id == $item->id)
                                    selected
                                @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Carrier</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="carrier" id="carrier">
                            <option value="" selected>-- Select Carrier --</option>
                            @foreach ($carrier as $item)
                            <option value="{{ $item->id }}" @if($quote->carrier_id == $item->id)
                                selected
                            @endif>{{ $item->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/carrier') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Voyage/Flight Number</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="voyage" id="voyage" class="form-control" value="{{ $quote->flight_number }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>ETD</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdatex" data-target-input="nearest">
                            <input type="text" name="etd" id="etd" value="@if($quote->etd_date != null){{ \Carbon\Carbon::parse($quote->etd_date)->format('m/d/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdatex" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>ETA</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdatexx" data-target-input="nearest">
                            <input type="text" name="eta" id="eta" value="@if($quote->eta_date != null){{ \Carbon\Carbon::parse($quote->eta_date)->format('m/d/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdatexx" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Port Of Loading</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="pol" id="pol">
                            <option value="" selected>-- Select Port Of Loading --</option>
                            @foreach ($port as $item)
                            <option value="{{ $item->id }}" @if ($quote->pol_id == $item->id)
                                selected
                            @endif>{{ $item->port_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ route('master.port') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>POL Custom Desc</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="pol_desc" id="pol_desc" value="{{ $quote->pol_custom_desc }}" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Port Of Transit</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="pot" id="pot">
                            <option value="" selected>-- Select Port Of Transit --</option>
                            @foreach ($port as $item)
                            <option value="{{ $item->id }}" @if ($quote->pot_id == $item->id)
                                selected
                            @endif>{{ $item->port_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ route('master.port') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Port Of Discharge</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="podisc" id="podisc">
                            <option value="" selected>-- Select Port Of Discharge --</option>
                            @foreach ($port as $item)
                            <option value="{{ $item->id }}" @if ($quote->pod_id == $item->id)
                                selected
                            @endif>{{ $item->port_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ route('master.port') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>POD Custom Desc</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="pod_desc" id="pod_desc" value="{{ $quote->pod_custom_desc }}" class="form-control">
                    </div>
                </div>
            </div> --}}
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Client <font color="red">*</font></label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="customer_add" id="customer_add" onchange="client_detail(this.value)">

                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addCustomer('client')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        &nbsp;
                    </div>
                    <div class="col-md-7">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="legalDoc" name="legal_doc" disabled>
                            <label for="legalDoc">
                                Legal Doc
                            </label>
                        </div>
                    </div>
                </div>
                <div class="client-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Client Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="customer_addr" id="customer_addr">
                          
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Customer PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="customer_pic" id="customer_pic">
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Shipper <font color="red">*</font></label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="shipper" id="shipper" onchange="shipper_detail(this.value)">
     
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addCustomer('shipper')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="shipper-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Shipper Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="shipper_addr" id="shipper_addr">

                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Shipper PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="shipper_pic" id="shipper_pic">
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Consignee <font color="red">*</font></label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="consignee" id="consignee" onchange="consignee_detail(this.value)">
                           
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addCustomer('consignee')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a> 
                    </div>
                </div>
                <div class="consignee-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Consignee Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="consignee_addr" id="consignee_addr">

                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Consignee PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="consignee_pic" id="consignee_pic">
                             
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Notify Party <font color="red">*</font></label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="notify_party" id="notify_party" onchange="not_detail(this.value)">
                           
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addCustomer('notifyParty')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="not-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Notify Party Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="not_addr" id="not_addr">

                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Notify Party PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="not_pic" id="not_pic">
                  
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Agent</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="agent" id="agent" onchange="agent_detail(this.value)">
                            
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addCustomer('agent')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="agent-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Agent Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="agent_addr" id="agent_addr">
                                
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Agent PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="agent_pic" id="agent_pic">
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Shipping Line</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="shipping_line" id="shipping_line" onchange="shipline_detail(this.value)">
                            
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addCustomer('shipline')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="shipline-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Shipping Line Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="shipline_addr" id="shipline_addr">
                                
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Shipping Line PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="shipline_pic" id="shipline_pic">
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Place of Origin</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="pfo" id="pfo" class="form-control" value="{{ $quote->place_origin }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Place of Destination</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="pod" id="pod" class="form-control" value="{{ $quote->place_destination }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Vendor</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="vendor" id="vendor" onchange="vendor_detail(this.value)">
                            
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addCustomer('vendor')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="vendor-detail">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Vendor Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="vendor_addr" id="vendor_addr">
                                
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Vendor PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="vendor_pic" id="vendor_pic">
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Carrier</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="carrier" id="carrier">
                            <option value="" selected>-- Select Carrier --</option>
                            @foreach ($carrier as $item)
                            <option value="{{ $item->id }}" @if($quote->carrier_id == $item->id)
                                selected
                            @endif>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addCarrier()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Voyage/Flight Number</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="voyage" id="voyage" class="form-control" value="{{ $quote->flight_number }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>ETD</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdatex" data-target-input="nearest">
                            <input type="text" name="etd" id="etd" value="@if($quote->etd_date != null){{ \Carbon\Carbon::parse($quote->etd_date)->format('m/d/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdatex" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>ETA</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdatez" data-target-input="nearest">
                            <input type="text" name="eta" id="eta" value="@if($quote->eta_date != null){{ \Carbon\Carbon::parse($quote->eta_date)->format('m/d/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdatez" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Port Of Loading</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="pol" id="pol">
                            <option value="" selected>-- Select Port Of Loading --</option>
                            @foreach ($port as $item)
                            <option value="{{ $item->id }}" @if ($quote->pol_id == $item->id)
                                selected
                            @endif>{{ $item->port_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addPort('pol')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>POL Custom Desc</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="pol_desc" id="pol_desc" value="{{ $quote->pol_custom_desc }}" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Port Of Transit</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="pot" id="pot">
                            <option value="" selected>-- Select Port Of Transit --</option>
                            @foreach ($port as $item)
                            <option value="{{ $item->id }}" @if ($quote->pot_id == $item->id)
                                selected
                            @endif>{{ $item->port_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addPort('pot')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Port Of Discharge</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="podisc" id="podisc">
                            <option value="" selected>-- Select Port Of Discharge --</option>
                            @foreach ($port as $item)
                            <option value="{{ $item->id }}" @if ($quote->pod_id == $item->id)
                                selected
                            @endif>{{ $item->port_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addPort('pod')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>POD Custom Desc</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="pod_desc" id="pod_desc" value="{{ $quote->pod_custom_desc }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Freight & Charges</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Type Of Freight Charges</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" style="width: 100%;" name="freight_charges" id="freight_charges">
                                            <option value="" selected>-- Select Type --</option>
                                            @foreach ($freight as $item)
                                            <option value="{{ $item->id }}" @if ($quote->t_mfreight_charges_id == $item->id)
                                                selected
                                            @endif>{{ $item->freight_charge }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Place Of Payment</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="pop" id="pop" class="form-control" placeholder="Enter Place Of Payment" value="{{ number_format($quote->place_payment,2,',','.') }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Valuta Of Payment</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" style="width: 100%;" name="valuta_payment" id="valuta_payment">
                                            <option value="" selected>-- Select Valuta --</option>
                                            @foreach ($currency as $item)
                                            <option value="{{ $item->id }}" @if ($quote->valuta_payment == $item->id)
                                                selected
                                            @endif>{{ $item->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Value Of Prepaid</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="vop" id="vop" class="form-control" placeholder="Enter Value of prepaid" value="{{ number_format($quote->value_prepaid,2,',','.') }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Value Of Collect</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="voc" id="voc" class="form-control" placeholder="Enter Value of Collect" value="{{ number_format($quote->value_collect,2,',','.') }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Freetime Of Detention (Days)</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="fod" id="fod" class="form-control" placeholder="Enter Free time of detention" value="{{ $quote->freetime_detention }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Commodity Of Terms</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Incoterms</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" style="width: 100%;" name="incoterms" id="incoterms">
                                            @foreach ($inco as $row)
                                            <option value="{{ $row->id }}" @if ($row->id == $quote->t_mincoterms_id)
                                                selected
                                            @endif>{{ $row->incoterns_code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="">Value Of Commodity</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="value_commodity" id="value_commodity" placeholder="Enter Value Of Commodity ..." value="{{ number_format($quote->value_comm,2,',','.') }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Valuta Of Commodity</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" style="width: 100%;" name="valuta_com" id="valuta_com">
                                            <option value="" selected>-- Select Valuta --</option>
                                            @foreach ($currency as $item)
                                            <option value="{{ $item->id }}" @if ($quote->valuta_comm == $item->id)
                                                selected
                                            @endif>{{ $item->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Exchange Valuta</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs44" style="width: 100%;" name="exchange_valuta" id="exchange_valuta" onchange="get_exchange_rate(this.value)">
                                            <option value="" selected>-- Select Valuta --</option>
                                            @foreach ($currency as $item)
                                            <option value="{{ $item->id }}" @if ($quote->exchange_valuta_comm == $item->id)
                                                selected
                                            @endif>{{ $item->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="">Exchange Rates</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="exchange_rate" id="exchange_rate" placeholder="Enter Exchange Rate ..." value="{{ number_format($quote->rates_comm,2,',','.') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Master B/L Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Shipper</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="shipper_mbl" id="shipper_mbl" cols="30" rows="3" class="form-control">{{ $quote->mbl_shipper }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Consignee</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="cons_mbl" id="cons_mbl" cols="30" rows="3" class="form-control">{{ $quote->mbl_consignee }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Notify Party</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="notify_mbl" id="notify_mbl" cols="30" rows="3" class="form-control">{{ $quote->mbl_not_party }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>MBL Number</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="mbl_number" id="mbl_number" placeholder="Enter MBL Number ..." value="{{ $quote->mbl_no }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>MBL Date</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group date" id="reservationdateMBL" data-target-input="nearest">
                                    <input type="text" name="mbl_date" id="mbl_date" value="@if($quote->mbl_date != null){{ \Carbon\Carbon::parse($quote->mbl_date)->format('m/d/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                    <div class="input-group-append" data-target="#reservationdateMBL" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Valuta Of Payment</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control select2bs44" style="width: 100%;" name="valuta_mbl" id="valuta_mbl">
                                    <option value="" selected>-- Select Valuta --</option>
                                    @foreach ($currency as $item)
                                    <option value="{{ $item->id }}" @if ($quote->valuta_mbl == $item->id)
                                        selected
                                    @endif>{{ $item->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">House B/L/ AWB Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Shipper</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="shipper_hbl" id="shipper_hbl" cols="30" rows="3" class="form-control">{{ $quote->hbl_shipper }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Consignee</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="cons_hbl" id="cons_hbl" cols="30" rows="3" class="form-control">{{ $quote->hbl_consignee }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Notify Party</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="notify_hbl" id="notify_hbl" cols="30" rows="3" class="form-control">{{ $quote->hbl_not_party }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>BL/AWB Number</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="hbl_number" id="hbl_number" placeholder="Enter BL/AWB Number ..." value="{{ $quote->hbl_no }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>BL/AWB Date</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group date" id="reservationdateAWB" data-target-input="nearest">
                                    <input type="text" name="hbl_date" id="hbl_date" value="@if($quote->hbl_date != null){{ \Carbon\Carbon::parse($quote->hbl_date)->format('m/d/Y') }}@endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                    <div class="input-group-append" data-target="#reservationdateAWB" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Valuta Of Payment</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control select2bs44" style="width: 100%;" name="valuta_hbl" id="valuta_hbl">
                                    <option value="" selected>-- Select Valuta --</option>
                                    @foreach ($currency as $item)
                                    <option value="{{ $item->id }}" @if ($quote->valuta_hbl == $item->id)
                                        selected
                                    @endif>{{ $item->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-6">
    </div>
    <div class="col-md-6">
        <a class="btn btn-md btn-danger"><i class="fa fa-trash"></i></a>
        <a class="btn btn-md btn-dark" onclick="print_hbl({{ $quote->id }})"><i class="fa fa-print"></i> Print HBL</a>
        <a href="{{ url('booking/cetak_awb/'.$quote->id) }}" class="btn btn-md btn-dark" target="_blank"><i class="fa fa-print"></i> Print HAWB</a>
    </div>
</div>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Additional Information</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Total Commodity</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="total_commo" id="total_commo" placeholder="Total Commodity ..." readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Total Package</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="total_package" id="total_package" placeholder="Total Package ..." readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Total Container</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="total_container" id="total_container" placeholder="Total Container ..." readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <label>Remarks</label>
    </div>
    <div class="col-md-10">
        <textarea name="remarks" id="remarks" class="form-control" rows="6">{{ $quote->remarks }}</textarea>
    </div>
</div> 