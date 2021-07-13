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
                        <input type="text" class="form-control" name="booking_no" id="booking_no" placeholder="Booking No ..." value="{{ $quote->booking_no }}" readonly>
                        <input type="hidden" name="id_booking" value="{{ $quote->id }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Booking Date</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="booking_date" id="booking_date" value="{{ \Carbon\Carbon::parse($quote->booking_date)->format('d/m/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate" readonly/>
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
                        <input type="text" class="form-control" name="version_no" id="version_no" placeholder="Version No ..." value="{{ $quote->version_no }}" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Quote Number</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="quote_no" id="quote_no" placeholder="Quote No ..." value="{{ $quote->quote_no }}" readonly>
                        <input type="hidden" name="id_quote" id="id_quote" value="{{ $quote->t_quote_id }}">
                        <input type="hidden" name="activity" id="activityx" value="{{ $quote->activity }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Quote Date</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="date" id="datex" class="form-control datetimepicker-input" value="{{ \Carbon\Carbon::parse($quote->quote_date)->format('d/m/Y') }}" data-target="#reservationdate" readonly/>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
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
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Client</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="customer" id="customer" onchange="client_detail(this.value)">
                            <option value="" selected>-- Select Customer --</option>
                            @foreach ($company as $c)
                            <option value="{{ $c->id }}" @if ($quote->client_id == $c->id)
                                selected
                            @endif>{{ $c->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                        <label>Shipper</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="shipper" id="shipper" onchange="shipper_detail(this.value)">
                            <option value="" selected>-- Select Shipper --</option>
                            @foreach ($shipper as $item)
                            <option value="{{ $item->id }}" @if ($quote->shipper_id == $item->id)
                                selected
                            @endif>{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                        <label>Consignee</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="consignee" id="consignee" onchange="consignee_detail(this.value)">
                            <option value="" selected>-- Select Consignee --</option>
                            @foreach ($ppjk as $item)
                            <option value="{{ $item->id }}" @if ($quote->consignee_id == $item->id)
                                selected
                            @endif>{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                        <label>Notify Party</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="notify_party" id="notify_party" onchange="not_detail(this.value)">
                            <option value="" selected>-- Select Notify Party --</option>
                            @foreach ($ppjk as $item)
                            <option value="{{ $item->id }}" @if ($quote->not_party_id == $item->id)
                                selected
                            @endif>{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                            <option value="">-- Select Agent --</option>
                            @foreach ($agent as $item)
                            <option value="{{ $item->id }}" @if ($quote->agent_id == $item->id)
                                selected
                            @endif>{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                            @foreach ($shipping_line as $item)
                            <option value="{{ $item->id }}" @if ($quote->shipping_line_id == $item->id)
                                selected
                            @endif>{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                                <option value="" selected>-- Select Shipping Line PIC --</option>
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
                            <option value="">-- Select Vendor --</option>
                            @foreach ($vendor as $item)
                            <option value="{{ $item->id }}" @if ($quote->vendor_id == $item->id)
                                selected
                            @endif>{{ $item->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                        <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                            <input type="text" name="etd" id="etd" value="{{ \Carbon\Carbon::parse($quote->etd_date)->format('d/m/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                            <input type="text" name="eta" id="eta" value="{{ \Carbon\Carbon::parse($quote->eta_date)->format('d/m/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdatez" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Stuffing Date</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group date" id="reservationdatexx" data-target-input="nearest">
                                    <input type="text" name="stuf_date" id="stuf_date" value="{{ \Carbon\Carbon::parse($quote->stuffing_date)->format('d/m/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                    <div class="input-group-append" data-target="#reservationdatexx" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="">Place Of Stuffing</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="pos" id="pos" cols="70" rows="3" class="form-control">{{ $quote->stuffing_place }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="">Delivery Of Goods</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="dogs" id="dogs" cols="70" rows="3" class="form-control">{{ $quote->delivery_of_goods }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <input type="text" class="form-control" name="total_commo" id="total_commo" placeholder="Total Commodity ..." value="{{ $quote->total_commodity }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Total Package</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="total_package" id="total_package" placeholder="Total Package ..." value="{{ $quote->total_package }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Total Container</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="total_container" id="total_container" placeholder="Total Container ..." value="{{ $quote->total_commodity }}">
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