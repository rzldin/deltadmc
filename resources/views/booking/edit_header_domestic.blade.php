
<div class="col-md-12">
    <div id="accordion">
      <div class="card">
        <div class="card-header" id="header_booking_detail">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#booking_information" aria-expanded="true" aria-controls="booking_information" type="button">
              Booking Information
            </button>
          </h5>
        </div>

        <div id="booking_information" class="collapse" aria-labelledby="header_booking_detail" data-parent="#accordion">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Booking Number</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="booking_no" id="booking_no" placeholder="Booking No ..." value="{{ $quote->booking_no }}" @if ($verse > 1)
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
                                    <input type="text" name="booking_date" id="booking_date" value="@if($quote->booking_date != null){{ \Carbon\Carbon::parse($quote->booking_date)->format('d/m/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate" 
                                    @if($quote->flag_invoice == 1) disabled @endif/>
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
                                    <input type="text" name="date" id="datex" class="form-control datetimepicker-input" value="{{ \Carbon\Carbon::parse($quote->quote_date)->format('d/m/Y') }}" data-target="#reservationdate" readonly/>
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
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>SI Number</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="nomor_si" id="nomor_si" placeholder="SI Number ..." value="{{ $quote->nomor_si }}">
                            </div>
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
                        <label>Activity 2</label>
                    </div>
                    <div class="col-md-8" style="padding: 10px">
                        <select class="form-control" name="loadedc" id="loadedc">
                            <option value="">Please Select ...</option>
                        @foreach ($loadedc as $lc)
                            <option value="{{ $lc->id }}" @if ($lc->id == $quote->t_mcloaded_type_id)
                                selected
                            @endif>{{$lc->loaded_type }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Client <font color="red">*</font></label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="customer_add" id="customer_add" onchange="client_detail(this.value)">

                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        {{-- <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a> --}}
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
                        {{-- <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a> --}}
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
                        <label>Carrier 1</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="carrier" id="carrier" @if($quote->flag_invoice == 1) disabled @endif>
                            
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addCarrier()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Voyage/Flight Number 1</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="voyage" id="voyage" class="form-control" value="{{ $quote->flight_number }}" @if($quote->flag_invoice == 1) disabled @endif>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Carrier 2</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="carrier_2" id="carrier_2" @if($quote->flag_invoice == 1) disabled @endif>
                            
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addCarrier()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Voyage/Flight Number 2</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="voyage_2" id="voyage_2" class="form-control" value="{{ $quote->flight_number_2 }}" @if($quote->flag_invoice == 1) disabled @endif>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Carrier 3</label>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control select2bs44" style="width: 100%;" name="carrier_3" id="carrier_3" @if($quote->flag_invoice == 1) disabled @endif>
                            
                        </select>
                    </div>
                    <div class="col-md-1 mt-1">
                        <a href="javascript:;" onclick="addCarrier()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Voyage/Flight Number 3</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="voyage_3" id="voyage_3" class="form-control" value="{{ $quote->flight_number_3 }}" @if($quote->flag_invoice == 1) disabled @endif>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>ETD</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group date" id="reservationdatex" data-target-input="nearest">
                            <input type="text" name="etd_date" id="etd_date" value="@if($quote->etd_date != null){{ \Carbon\Carbon::parse($quote->etd_date)->format('d/m/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                            <input type="text" name="eta_date" id="eta_date" value="@if($quote->eta_date != null){{ \Carbon\Carbon::parse($quote->eta_date)->format('d/m/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                                    <input type="text" name="stuf_date" id="stuf_date" value="@if($quote->stuffing_date != null){{ \Carbon\Carbon::parse($quote->stuffing_date)->format('d/m/Y') }}@else @endif" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                                <textarea name="posx" id="posx" cols="70" rows="3" class="form-control">{{ $quote->stuffing_place }}</textarea>
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