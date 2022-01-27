<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Booking Information</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Booking Number <font color="red">*</font></label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="booking_no" id="booking_no" placeholder="Booking No ...">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Booking Date</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="booking_date" id="booking_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                        <input type="text" class="form-control" name="version_no" id="version_no" placeholder="Version No ..." value="1" readonly>
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
                        <input type="hidden" name="id_quote" id="id_quote" value="{{ $quote->id }}">
                        <input type="hidden" name="activity" value="{{ $quote->activity }}">
                    </div>
                </div>
                <div class="row mb-3">
                    @if ($quote->nomination_flag == 0)
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
                            <option value="" selected>-- Select Document --</option>
                            @foreach ($doc as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Document Number</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="doc_no" id="doc_no" placeholder="Doc No ...">
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Document Date</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdateDOC" data-target-input="nearest">
                            <input type="text" name="doc_date" id="doc_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdateDOC" data-toggle="datetimepicker">
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
                        <label>Client <font color="red">*</font></label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="customer_add" id="customer_add" onchange="get_pic(this.value)">
                                        
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
                        <div class="icheck-primary d-inline" id="legalDoc">
                            
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
                                <option>-- Select Client Address --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addAddress('client')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Client PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" name="customer_pic" id="customer_pic" style="width: 100%;">
                                <option>-- Select Customer First --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addPic('client')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                <div class="shipper-detail" style="display: none">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Shipper Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="shipper_addr" id="shipper_addr">
                                <option value="" selected>-- Select Shipper Address --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addAddress('shipper')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Shipper PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="shipper_pic" id="shipper_pic">
                                <option value="" selected>-- Select Shipper PIC --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addPic('shipper')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                <div class="consignee-detail" style="display: none">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Consignee Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="consignee_addr" id="consignee_addr">
                                <option value="" selected>-- Select consignee Address --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addAddress('consignee')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Consignee PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="consignee_pic" id="consignee_pic">
                                <option value="" selected>-- Select consignee PIC --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addPic('consignee')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                <div class="not-detail" style="display: none">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Notify Party Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="not_addr" id="not_addr">
                                <option value="" selected>-- Select consignee Address --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addAddress('notifyParty')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Notify Party PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="not_pic" id="not_pic">
                                <option value="" selected>-- Select consignee PIC --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addPic('notifyParty')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                <div class="agent-detail" style="display: none">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Agent Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="agent_addr" id="agent_addr">
                                <option value="" selected>-- Select agent Address --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addAddress('agent')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Agent PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="agent_pic" id="agent_pic">
                                <option value="" selected>-- Select consignee PIC --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addPic('agent')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                <div class="shipline-detail" style="display: none">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Shipping Line Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="shipline_addr" id="shipline_addr">
                                <option value="" selected>-- Select consignee Address --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addAddress('shipline')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Shipping Line PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="shipline_pic" id="shipline_pic">
                                <option value="" selected>-- Select consignee PIC --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addPic('shipline')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Place of Origin</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="pfo" id="pfo" class="form-control" value="{{ $quote->from_text }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Place of Destination</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="pod" id="pod" class="form-control" value="{{ $quote->to_text }}">
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
                <div class="vendor-detail" style="display: none">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Vendor Address</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="vendor_addr" id="vendor_addr">
                                <option value="" selected>-- Select Vendor Address --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addAddress('vendor')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Vendor PIC</label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2bs44" style="width: 100%;" name="vendor_pic" id="vendor_pic">
                                <option value="" selected>-- Select Vendor PIC --</option>
                            </select>
                        </div>
                        <div class="col-md-1 mt-1">
                            <a href="javascript:;" onclick="addPic('vendor')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Carrier</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="carrier" id="carrier">

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
                        <input type="text" name="voyage" id="voyage" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>ETD</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdatex" data-target-input="nearest">
                            <input type="text" name="etd" id="etd" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                            <input type="text" name="eta" id="eta" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                        <select class="form-control select-ajax-port" style="width: 100%;" name="pol" id="pol">

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
                        <input type="text" name="pol_desc" id="pol_desc" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Port Of Transit</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select-ajax-port" style="width: 100%;" name="pot" id="pot">
                            
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
                        <select class="form-control select-ajax-port" style="width: 100%;" name="podisc" id="podisc">
                        
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
                        <input type="text" name="pod_desc" id="pod_desc" class="form-control">
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
                                            <option value="" selected>-- Select Port Of Freight Charges --</option>
                                            @foreach ($freight as $item)
                                            <option value="{{ $item->id }}">{{ $item->freight_charge }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Place Of Payment</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="pop" id="pop" class="form-control" placeholder="Enter Place Of Payment">
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
                                            <option value="{{ $item->id }}">{{ $item->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Value Of Prepaid</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="vop" id="vop" class="form-control" placeholder="Enter Value of prepaid">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Value Of Collect</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="voc" id="voc" class="form-control" placeholder="Enter Value of Collect">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Freetime Of Detention (Days)</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="fod" id="fod" class="form-control" placeholder="Enter Free time of detention">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Stuffing Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Stuffing Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-group date" id="reservationdatexx" data-target-input="nearest">
                                            <input type="text" name="stuf_date" id="stuf_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                                        <textarea name="posx" id="posx" cols="70" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="">Delivery Of Goods</label>
                                    </div>
                                    <div class="col-md-8">
                                        <textarea name="dogs" id="dogs" cols="70" rows="3" class="form-control"></textarea>
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
                                <textarea name="shipper_mbl" id="shipper_mbl" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Consignee</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="cons_mbl" id="cons_mbl" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Notify Party</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="notify_mbl" id="notify_mbl" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>MBL Number</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="mbl_number" id="mbl_number" placeholder="Enter MBL Number ...">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>MBL Date</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group date" id="reservationdateMBL" data-target-input="nearest">
                                    <input type="text" name="mbl_date" id="mbl_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                                    <option value="{{ $item->id }}">{{ $item->code }}</option>
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
                                <textarea name="shipper_hbl" id="shipper_hbl" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Consignee</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="cons_hbl" id="cons_hbl" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Notify Party</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="notify_hbl" id="notify_hbl" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>BL/AWB Number</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="hbl_number" id="hbl_number" placeholder="Enter BL/AWB Number ...">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>BL/AWB Date</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group date" id="reservationdateAWB" data-target-input="nearest">
                                    <input type="text" name="hbl_date" id="awb_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                                    <option value="{{ $item->id }}">{{ $item->code }}</option>
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
<div class="row">
    <div class="col-md-6">
        <div class="row mb-3">
            <div class="col-md-4">
                <label>B/L Issued</label>
            </div>
            <div class="col-md-8">
                <select class="form-control select2bs44" style="width: 100%;" name="mbl_issued" id="mbl_issued">
                    <option value="" selected>-- Select B/L Issued --</option>
                    @foreach ($mbl_issued as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        {{-- <a class="btn btn-md btn-danger"><i class="fa fa-trash"></i></a>
        <a class="btn btn-md btn-dark" target="_blank"><i class="fa fa-print"></i> Print HBL</a>
        <a class="btn btn-md btn-dark" target="_blank"><i class="fa fa-print"></i> Print HAWB</a> --}}
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
                        <label>Fumigation</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control select2bs44" style="width: 100%;" name="fumigation" id="fumigation">
                            <option value="1" @if ($quote->fumigation_flag == 1)
                                selected
                            @endif>YES</option>
                            <option value="0" @if ($quote->fumigation_flag == 0)
                                selected
                            @endif>NO</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Insurance</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control select2bs44" style="width: 100%;" name="insurance" id="insurance">
                            <option selected>-- Select --</option>
                            <option value="1">YES</option>
                            <option value="0">NO</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Incoterms</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control select2bs44" style="width: 100%;" name="incoterms" id="incoterms">
                            @foreach ($inco as $row)
                            <option value="{{ $row->id }}" @if ($row->id == $quote->terms)
                                selected
                            @endif>{{ $row->incoterns_code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <label>Remarks</label>
    </div>
    <div class="col-md-10">
        <textarea name="remarks" id="remarks" class="form-control" rows="6"></textarea>
    </div>
</div> 