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
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>SI Number</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="nomor_si" id="nomor_si" placeholder="SI Number ...">
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
                        <label>Shipment By</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="shipment_by" id="shipment_by" value="{{ $quote->shipment_by }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Activity</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="activity" id="activity" value="{{ $quote->activity }}" readonly>
                    </div>
                    <div class="col-md-4" style="padding: 10px">
                        @foreach ($loaded as $l)
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="loaded_{{ $l->id }}" name="loaded" value="{{ $l->id }}"  @if ($l->id == $quote->t_mloaded_type_id)
                                checked
                            @endif disabled>
                            <label for="loaded_{{ $l->id }}">
                                {{ $l->loaded_type }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
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
                        <label>ETD<font color="red">*</font></label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdatex" data-target-input="nearest">
                            <input type="text" name="etd_date" id="etd_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                            <input type="text" name="eta_date" id="eta_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
{{-- <div class="card card-primary">
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
                        <input type="text" class="form-control" name="total_commo" id="total_commo" placeholder="Total Commodity ...">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Total Package</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="total_package" id="total_package" placeholder="Total Package ...">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Total Container</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="total_container" id="total_container" placeholder="Total Container ...">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="row">
    <div class="col-md-2">
        <label>Remarks</label>
    </div>
    <div class="col-md-10">
        <textarea name="remarks" id="remarks" class="form-control" rows="6"></textarea>
    </div>
</div> 