@extends('layouts.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-plus"></i>
                Edit Booking
            </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Booking</li>
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
                        <h3 class="card-title float-right">
                            <strong>{{ $quote->shipment_by }}</strong>
                        </h3>
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
                        <div class="tab-content" id="custom-content-below-tabContent">
                            <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                <div class="container-fluid mt-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="{{ route('booking.doUpdate') }}" class="eventInsForm" method="post" target="_self" name="formku" id="formku" action=""> 
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status_final" id="status_final">
                                                @if(count($errors)>0)
                                                @foreach($errors->all() as $error)
                                                <div class="alert alert-danger" role="alert">
                                                    {{ $error }}
                                                </div>  		
                                                @endforeach
                                            @endif
                                                @if ($quote->activity == 'domestic')
                                                {{\App\Http\Controllers\BookingController::edit_header_domestic($quote)}}
                                                @elseif($quote->activity == 'export')
                                                {{\App\Http\Controllers\BookingController::edit_header_export($quote)}}
                                                @elseif($quote->activity == 'import')
                                                {{\App\Http\Controllers\BookingController::edit_header_import($quote)}}
                                                @endif
                                            </form>
                                            <div class="row float-right mt-2">
                                                <a href="" class="btn btn-dark btn-sm m-2"><i class="fa fa-print"></i> Print SI Trucking</a>
                                                <a href="" class="btn btn-danger btn-sm m-2"><i class="fa fa-print"></i> Print SI</a>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Commodity</h3>
                                                </div>
                                                <div class="card-body table-responsive p-0">
                                                   <table class="table table_lowm table-bordered" id="Table1">
                                                       <thead>
                                                           <tr>
                                                               <th width="1%">#</th>
                                                               <th width="15%">Hs Code</th>
                                                               <th>Description</th>
                                                               <th>Origin</th>
                                                               <th width="15%">Qty Commodity</th>
                                                               <th width="15%">Qty Packages</th>
                                                               <th width="15%">Weight</th>
                                                               <th >Netto</th>
                                                               <th width="15%">Volume</th>
                                                               <th width="8%">Action</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                           <tbody id="tblCommodity">
                            
                                                           </tbody>
                                                           <tr>
                                                                <td>
                                                                    <i class="fa fa-plus"></i>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="hs_code" id="hs_code_1" placeholder="Hs Code ...">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="desc" id="desc_1" placeholder="Description ...">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="origin" id="origin_1" placeholder="Origin...">
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <input type="text" class="form-control" name="qty_com" id="qty_com_1" placeholder="Qty Commodity...">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <select class="form-control select2bs44" name="qty_uom" id="qty_uom_1">
                                                                                <option value="">--Select Uom--</option>
                                                                                @foreach ($uom as $item)
                                                                                <option value="{{ $item->id }}">{{ $item->uom_code }}</option>                                                
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <input type="text" class="form-control" name="qty_packages" id="qty_packages_1" placeholder="Qty Packages ..." >
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <select class="form-control select2bs44" name="qty_pckg_uom" id="qty_pckg_uom_1">
                                                                                <option value="">--Select Uom--</option>
                                                                                @foreach ($uom as $item)
                                                                                <option value="{{ $item->id }}">{{ $item->uom_code }}</option>                                                
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                               </td>
                                                               <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <input type="text" class="form-control" name="weight" id="weight_1" placeholder="Weight ..." >
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <select class="form-control select2bs44" name="weight_uom" id="weight_uom_1">
                                                                                <option value="">--Select Uom--</option>
                                                                                @foreach ($uom as $item)
                                                                                <option value="{{ $item->id }}">{{ $item->uom_code }}</option>                                                
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                               <td>
                                                                    <input type="text" class="form-control" name="netto" id="netto_1" placeholder="Netto ..." onkeyup="numberOnly(this)">
                                                               </td>
                                                               <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <input type="text" class="form-control" name="volume" id="volume_1" placeholder="Volume ..." >
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <select class="form-control select2bs44" name="volume_uom" id="volume_uom_1">
                                                                                <option value="">--Select Uom--</option>
                                                                                @foreach ($uom as $item)
                                                                                <option value="{{ $item->id }}">{{ $item->uom_code }}</option>                                                
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-outline-success btn-xs" onclick="saveDetailCom(1)"><i class="fa fa-plus"></i> Add</button>
                                                                </td>
                                                           </tr>
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
                                                   <table class="table table_lowm table-bordered" id="Table1">
                                                       <thead>
                                                           <tr>
                                                               <th width="1%">#</th>
                                                               <th width="35%">Merk</th>
                                                               <th width="15%">Qty</th>
                                                               <th width="15%">Unit</th>
                                                               <th width="10%">Action</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                           <tbody id="tblPackages">
                            
                                                           </tbody>
                                                           <tr>
                                                                <td>
                                                                    <i class="fa fa-plus"></i>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="merk" id="merk_1" placeholder="Merk ...">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="qtyx" id="qtyx_1" placeholder="Qty ...">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select2bs44" name="unit" id="unit_1">
                                                                        <option value="">--Select Uom--</option>
                                                                        @foreach ($uom as $item)
                                                                        <option value="{{ $item->id }}">{{ $item->uom_code }}</option>                                                
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-outline-success btn-xs" onclick="saveDetailPckg(1)"><i class="fa fa-plus"></i> Add</button>
                                                                </td>
                                                           </tr>
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
                                                   <table class="table table_lowm table-bordered" id="Table1">
                                                       <thead>
                                                           <tr>
                                                               <th width="1%">#</th>
                                                               <th width="20%">Container Number</th>
                                                               <th width="15%">Size</th>
                                                               <th width="15%">Loaded Type</th>
                                                               <th width="15%">Container Type</th>
                                                               <th>Seal No</th>
                                                               @if ($quote->activity == 'export')
                                                                <th>VGM</th>
                                                                <th>Uom</th>
                                                                <th>Resp.Party</th>
                                                                <th>Auth.Person</th>
                                                                <th>M.o.w</th>
                                                                <th width="15%">Weighing Party</th>
                                                               @endif
                                                               <th width="10%">Action</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                           <tbody id="tblContainer">
                            
                                                           </tbody>
                                                           <tr>
                                                                <td>
                                                                    <i class="fa fa-plus"></i>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="con_numb" id="con_numb_1" placeholder="Container Number ...">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="size" id="size_1" placeholder="Size ...">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select2bs44" name="loaded" id="loaded_1">
                                                                        <option value="">--Select Container--</option>
                                                                        @foreach ($loaded as $item)
                                                                        <option value="{{ $item->id }}">{{ $item->loaded_type }}</option>                                                
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select2bs44" name="container" id="container_1">
                                                                        <option value="">--Select Container--</option>
                                                                        @foreach ($container as $item)
                                                                        <option value="{{ $item->id }}">{{ $item->container_type }}</option>                                                
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="seal_no" id="seal_no_1" placeholder="Seal No ...">
                                                                </td>
                                                                @if ($quote->activity == 'export')
                                                                <td>
                                                                    <input type="text" class="form-control" name="vgm" id="vgm_1" placeholder="VGM ...">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select2bs44" name="vgm_uom" id="vgm_uom_1">
                                                                        <option value="">--Select Uom--</option>
                                                                        @foreach ($uom as $item)
                                                                        <option value="{{ $item->id }}">{{ $item->uom_code }}</option>                                                
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="resp_party" id="resp_party_1" placeholder="Resp Party ...">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="auth_person" id="auth_person_1" placeholder="Auth Person ...">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="mow" id="mow_1" placeholder="M.O.W ...">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="w_party" id="w_party_1" placeholder="W.Party ...">
                                                                </td>
                                                                @endif
                                                                <td>
                                                                    <button class="btn btn-block btn-outline-success btn-xs" onclick="saveDetailCon(1)"><i class="fa fa-plus"></i> Add</button>
                                                                </td>
                                                           </tr>
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
                                                               <th width="10%">Action</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                           <tbody id="tblDoc">
                            
                                                           </tbody>
                                                           <tr>
                                                                <td>
                                                                    <i class="fa fa-plus"></i>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select2bs44" name="docx" id="docx_1">
                                                                        <option value="">--Select Doctype--</option>
                                                                        @foreach ($doc as $item)
                                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>                                                
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="doc_number" id="doc_number_1" placeholder="Doc Number ...">
                                                                </td>
                                                                <td>
                                                                    <div class="input-group date" id="reservationdatec" data-target-input="nearest">
                                                                        <input type="date" name="doc_date" id="doc_date_1" class="form-control"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-outline-success btn-xs" onclick="saveDetailDoc(1)"><i class="fa fa-plus"></i> Add</button>
                                                                </td>
                                                           </tr>
                                                       </tbody>
                                                   </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary mb-4 float-left mr-2" onclick="updateData(1)">
                                                <i class="fa fa-save"></i> Save as Final
                                            </button>
                                            <a href="{{ url('booking/booking_new/'.$quote->id) }}" class="btn btn-info float-left mr-2"> 
                                                <i class="fa fa-plus"></i> New Version 
                                            </a>
                                            <a href="{{ route('booking.list') }}" class="btn btn-danger float-left mr-2"> 
                                                <i class="fa fa-times"></i> Cancel
                                            </a>
                                            <a href="javascript::" class="btn btn-primary float-left mr-2" onclick="updateData(0)"> 
                                                <i class="fa fa-save"></i> Save 
                                            </a>
                                        </div>
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
                                                    <a class="btn btn-dark btn-sm float-right" onclick="newRoad()"><i class="fa fa-plus"></i> Add Data</a>
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
                                                                <td>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tblRoadCons">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>                                
                            </div>
                            <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                                            <h4 class="modal-title">&nbsp;</h4>
                                        </div>
                                        <br>
                                        <div class="modal-body">
                                            <form class="eventInsForm" method="post" target="_self" name="formku" 
                                                  id="formRoad" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="booking_id" id="booking_id" value="{{ $quote->id }}">
                                                <div class="row mb-2">
                                                    <div class="col-md-4 col-xs-4">
                                                        No. SJ <font color="#f00">*</font>
                                                    </div>
                                                    <div class="col-md-8 col-xs-8">
                                                        <input type="text" id="no_sj" name="no_sj" 
                                                            class="form-control myline" style="margin-bottom:5px" placeholder="No Surat Jalan ....">
                                                        <input type="hidden" id="id" name="id">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4 col-xs-4">
                                                        Vehicle Type<font color="#f00">*</font>
                                                    </div>                                
                                                    <div class="col-md-8 col-xs-8">
                                                        <select class="form-control select2bs4" style="width: 100%;margin-bottom:5px;" name="vehicle_type" id="vehicle_type">
                                                            <option value="" disabled selected>--Pilih--</option>
                                                            @foreach ($vehicle_type as $row)
                                                                <option value="{{ $row->id }}">{{ $row->type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4 col-xs-4">
                                                        Vehicle<font color="#f00">*</font>
                                                    </div>                                
                                                    <div class="col-md-8 col-xs-8">
                                                        <select class="form-control select2bs4" style="width: 100%;margin-bottom:5px;" name="vehicle_no" id="vehicle_no">
                                                            <option value="" disabled selected>--Pilih--</option>
                                                            @foreach ($vehicle as $row)
                                                                <option value="{{ $row->id }}">{{ $row->vehicle_no }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4 col-xs-4">
                                                        Driver<font color="#f00">*</font>
                                                    </div>                                
                                                    <div class="col-md-8 col-xs-8">
                                                        <input type="text" id="driver" name="driver" 
                                                            class="form-control myline" style="margin-bottom:5px">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4 col-xs-4">
                                                        Driver Phone<font color="#f00">*</font>
                                                    </div>
                                                    <div class="col-md-8 col-xs-8">
                                                        <input type="text" id="driver_ph" name="driver_ph" class="form-control" placeholder="driver phone ...">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4 col-xs-4">
                                                        Pickup Address<font color="#f00">*</font>
                                                    </div>
                                                    <div class="col-md-8 col-xs-8">
                                                        <input type="text" id="pickup_addr" name="pickup_addr" class="form-control" placeholder="Pickup Address ...">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4 col-xs-4">
                                                        Delivery Address<font color="#f00">*</font>
                                                    </div>
                                                    <div class="col-md-8 col-xs-8">
                                                        <input type="text" id="deliv_addr" name="deliv_addr" class="form-control" placeholder="Delivery Address ...">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4 col-xs-4">
                                                       Notes<font color="#f00">*</font>
                                                    </div>
                                                    <div class="col-md-8 col-xs-8">
                                                        <input type="text" id="notes" name="notes" class="form-control" placeholder="Notes ...">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">                        
                                            <button type="button" class="btn btn-primary" onClick="simpandataRoad();"><i class="fa fa-save"></i> Save</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-messages" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
                                <section class="content">
                                    <div class="container-fluid mt-3">
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <a class="btn btn-dark btn-sm float-right" onclick="newSchedule()"><i class="fa fa-plus"></i> Add Data</a>
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
                                                            <td>Action</td>
                                                          </tr>
                                                        </thead>
                                                        <tbody id="tblSchedule">
                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section> 
                            </div>
                            <div class="modal fade" id="myModalx" tabindex="-1" role="basic" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                                            <h4 class="modal-title">&nbsp;</h4>
                                        </div>
                                        <br>
                                        <div class="modal-body">
                                            <form class="eventInsForm" method="post" target="_self" name="formku" 
                                                  id="formRoad" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="booking_id" id="booking_id" value="{{ $quote->id }}">
                                                <div class="row mb-2">
                                                    <div class="col-md-4 col-xs-4">
                                                        Schedule<font color="#f00">*</font>
                                                    </div>                                
                                                    <div class="col-md-8 col-xs-8">
                                                        <select class="form-control select2bs4k" style="width: 100%;margin-bottom:5px;" name="schedulex" id="schedulex">
                                                            <option value="" selected>--Pilih--</option>
                                                            @foreach ($schedule as $row)
                                                                <option value="{{ $row->id }}">{{ $row->schedule_type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4 col-xs-4">
                                                        Description<font color="#f00">*</font>
                                                    </div>                                
                                                    <div class="col-md-8 col-xs-8">
                                                        <input type="text" id="description_s" name="description_s" 
                                                            class="form-control myline" style="margin-bottom:5px" placeholder="Description .. ">
                                                        <input type="hidden" name="id_s" id="id_s">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4 col-xs-4">
                                                        Date<font color="#f00">*</font>
                                                    </div>
                                                    <div class="col-md-8 col-xs-8">
                                                        {{-- <input type="datetime-local" id="date_s" name="date_s" class="form-control"> --}}
                                                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                                            <input type="text" name="date_s" id="date_s" class="form-control datetimepicker-input" data-target="#reservationdatetime"/>
                                                            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id="date_old" name="date_old">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4 col-xs-4">
                                                       Notes<font color="#f00">*</font>
                                                    </div>
                                                    <div class="col-md-8 col-xs-8">
                                                        <input type="text" id="notesx" name="notesx" class="form-control" placeholder="Notes ...">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">                        
                                            <button type="button" class="btn btn-primary" onClick="simpandataSch();"><i class="fa fa-save"></i> Save</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-settings" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
                                Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('after-scripts')
    <script>

        var dsState;

        function client_detail(val){
            if(val!= ''){
                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: "id="+val,
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
                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: "id="+val,
                    dataType: "html",
                    success: function(result) {
                        var final = JSON.parse(result);
                        $("#shipper_addr").html(final[0]);
                        $("#shipper_pic").html(final[1]);
                    }
                });
            }
        }


        function consignee_detail(val)
        {
            if(val!= ''){
                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: "id="+val,
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
                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: "id="+val,
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
                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: "id="+val,
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
                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: "id="+val,
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
                $.ajax({
                    url: "{{ route('booking.detail') }}",
                    type: "POST",
                    data: "id="+val,
                    dataType: "html",
                    success: function(result) {
                        var final = JSON.parse(result);
                        $("#vendor_addr").html(final[0]);
                        $("#vendor_pic").html(final[1]);
                    }
                });
            }
        }

        function newRoad(){
            $('#id').val('');
            $('#no_sj').val('');
            $('#vehicle_type').val('').trigger('change');
            $('#vehicle_no').val('').trigger('change');
            $('#driver').val('');
            $('#driver_ph').val('');
            $('#pickup_addr').val('');
            $('#deliv_addr').val('');
            $('#notes').val('');

            dsState = "Input";
            
            $("#myModal").find('.modal-title').text('Add Data');
            $("#myModal").modal('show',{backdrop: 'true'}); 
        }

        function simpandataRoad(){
            if($.trim($("#no_sj").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter No. Surat Jalan',
                    icon: 'error'
                })
            }else if($.trim($("#vehicle_type").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select Vehicle Type',
                    icon: 'error'
                })
            }else if($.trim($("#vehicle_no").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select Vehicle',
                    icon: 'error'
                })
            }else if($.trim($("#driver").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please input driver',
                    icon: 'error'
                })
            }else if($.trim($("#driver_ph").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please input Driver Phone',
                    icon: 'error'
                })
            }else if($.trim($("#pickup_addr").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please input Pickup Address',
                    icon: 'error'
                })
            }else if($.trim($("#deliv_addr").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please input Delivery Address',
                    icon: 'error'
                })
            }else{
                if(dsState=="Input"){
                    $.ajax({
                        type: "POST",
                        url: "{{ route('booking.roadCons_doAdd') }}",
                        dataType: 'json',
                        data : {
                            booking_id:$('#booking_id').val(),
                            no_sj : $('#no_sj').val(),
                            vehicle_type : $('#vehicle_type').val(),
                            vehicle_no : $('#vehicle_no').val(),
                            driver : $('#driver').val(),
                            driver_ph : $('#driver_ph').val(),
                            pickup_addr : $('#pickup_addr').val(),
                            deliv_addr : $('#deliv_addr').val(),
                            notes : $('#notes').val()
                        },
                        success: function (result){
                            $("#myModal").modal('hide'); 
                            loadRoadCons({{ Request::segment(3) }}); 
                            Toast.fire({
                                icon: 'success',
                                title: 'Sukses Add Data!'
                            });
                        }
                    });              
                }else{
                    $.ajax({
                        type: "POST",
                        url: "{{ route('booking.roadCons_doUpdate') }}",
                        dataType: 'json',
                        data : {
                            id : $('#id').val(),
                            no_sj : $('#no_sj').val(),
                            vehicle_type : $('#vehicle_type').val(),
                            vehicle_no : $('#vehicle_no').val(),
                            driver : $('#driver').val(),
                            driver_ph : $('#driver_ph').val(),
                            pickup_addr : $('#pickup_addr').val(),
                            deliv_addr : $('#deliv_addr').val(),
                            notes : $('#notes').val()
                        },
                        success: function (result){
                            $("#myModal").modal('hide'); 
                            loadRoadCons({{ Request::segment(3) }}); 
                            Toast.fire({
                                icon: 'success',
                                title: 'Sukses Update!'
                            });
                        }
                    }); 
                }
            }
            
        };


        function editDetailRoad(id){
            dsState = "Edit";
            $.ajax({
                type: "POST",
                url: "{{ route('booking.getRoadCons') }}",
                dataType: 'json',
                data : {id: id},
                success: function (result){
                    $('#id').val(result.id);
                    $('#no_sj').val(result.no_sj);
                    $('#vehicle_type').val(result.t_mvehicle_type_id).trigger("change");
                    $('#vehicle_no').val(result.t_mvehicle_id).trigger("change");
                    $('#driver').val(result.driver);
                    $('#driver_ph').val(result.driver_phone);
                    $('#pickup_addr').val(result.pickup_addr);
                    $('#deliv_addr').val(result.delivery_addr);
                    $('#notes').val(result.notes);
                    $("#myModal").find('.modal-title').text('Edit Data');
                    $("#myModal").modal('show',{backdrop: 'true'});           
                }
            });
        };

        function newSchedule(){
            $('#id_s').val('');
            $('#date_s').val('');
            $('#description_s').val('');
            $('#schedulex').val('').trigger('change');
            $('#notesx').val('');

            dsState = "Input";
            
            $("#myModalx").find('.modal-title').text('Add Data');
            $("#myModalx").modal('show',{backdrop: 'true'}); 
        }

        function simpandataSch(){
            if($.trim($("#schedulex").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select Schedule',
                    icon: 'error'
                })
            }else if($.trim($("#description_s").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Description',
                    icon: 'error'
                })
            }else if($.trim($("#date_s").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter Date',
                    icon: 'error'
                })
            }else if($.trim($("#notesx").val()) == ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please input Note',
                    icon: 'error'
                })
            }else{
                if(dsState=="Input"){
                    $.ajax({
                        type: "POST",
                        url: "{{ route('booking.schedule_doAdd') }}",
                        dataType: 'json',
                        data : {
                            booking_id:$('#booking_id').val(),
                            schedule : $('#schedulex').val(),
                            desc : $('#description_s').val(),
                            date : $('#date_s').val(),
                            notes : $('#notesx').val()
                        },
                        success: function (result){
                            $("#myModalx").modal('hide'); 
                            loadSchedule({{ Request::segment(3) }}); 
                            Toast.fire({
                                icon: 'success',
                                title: 'Sukses Add Data!'
                            });
                        }
                    });              
                }else{
                    $.ajax({
                        type: "POST",
                        url: "{{ route('booking.schedule_doUpdate') }}",
                        dataType: 'json',
                        data : {
                            id : $('#id_s').val(),
                            schedule : $('#schedulex').val(),
                            desc : $('#description_s').val(),
                            date : $('#date_s').val(),
                            date_old : $('#date_old').val(),
                            notes : $('#notesx').val()
                        },
                        success: function (result){
                            $("#myModalx").modal('hide'); 
                            loadSchedule({{ Request::segment(3) }}); 
                            Toast.fire({
                                icon: 'success',
                                title: 'Sukses Update!'
                            });
                        }
                    }); 
                }
            }
            
        };

        function editDetailSch(id){
            dsState = "Edit";
            var dateControl = document.querySelector('input[type="datetime-local"]');
            $.ajax({
                type: "POST",
                url: "{{ route('booking.getSchedule') }}",
                dataType: 'json',
                data : {id: id},
                success: function (result){
                    //var d = moment(result.date).format('Y-m-dTH:i');
                    var d = new Date(result.date)

                    $('#id_s').val(result.id);
                    $('#schedulex').val(result.t_mschedule_type_id).trigger("change");
                    $('#description_s').val(result.desc);
                    $('#date_s').val(result.date);
                    $('#notesx').val(result.notes);
                    $("#myModalx").find('.modal-title').text('Edit Data');
                    $("#myModalx").modal('show',{backdrop: 'true'});           
                }
            });
        };

        /** Load Road Cons **/
        function loadRoadCons(id){
            $.ajax({
                type:"POST",
                url:"{{ route('booking.loadRoadCons') }}",
                data:"id="+id,
                dataType:"html",
                success:function(result){
                    var tabel = JSON.parse(result);
                    $('#tblRoadCons').html(tabel);
                }
            })
        }

        /** Load Schedule **/
        function loadSchedule(id){
            $.ajax({
                type:"POST",
                url:"{{ route('booking.loadSchedule') }}",
                data:"id="+id,
                dataType:"html",
                success:function(result){
                    var tabel = JSON.parse(result);
                    $('#tblSchedule').html(tabel);
                }
            })
        }

        /** Hapus Detail Road **/
        function hapusDetailRoad(id){
            var r=confirm("Anda yakin menghapus data ini?");
            if (r==true){
                $.ajax({
                    type:"POST",
                    url:"{{ route('booking.deleteRoadCons') }}",
                    data:"id="+ id,
                    success:function(result){
                        loadRoadCons({{ Request::segment(3) }});
                        Toast.fire({
                            icon: 'success',
                            title: 'Deleted!'
                        });   
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Menghapus data!');
                    }, 
                });
            }
        }

        /** Hapus Detail Road **/
        function hapusDetailSch(id){
            var r=confirm("Anda yakin menghapus data ini?");
            if (r==true){
                $.ajax({
                    type:"POST",
                    url:"{{ route('booking.deleteSchedule') }}",
                    data:"id="+ id,
                    success:function(result){
                        loadSchedule({{ Request::segment(3) }});
                        Toast.fire({
                            icon: 'success',
                            title: 'Deleted!'
                        });   
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Menghapus data!');
                    }, 
                });
            }
        }

        /** Load Commodity **/
        function loadCommodity(id){
            $.ajax({
                type:"POST",
                url:"{{ route('booking.loadCommodity') }}",
                data:"id="+id,
                dataType:"html",
                success:function(result){
                    var tabel = JSON.parse(result);
                    $('#tblCommodity').html(tabel);
                }
            })
        }

        /** Load Packages **/
        function loadPackages(id){
            $.ajax({
                type:"POST",
                url:"{{ route('booking.loadPackages') }}",
                data:"id="+id,
                dataType:"html",
                success:function(result){
                    var tabel = JSON.parse(result);
                    $('#tblPackages').html(tabel);
                }
            })
        }

        /** Load Container **/
        function loadContainer(id){
            $.ajax({
                type:"POST",
                url:"{{ route('booking.loadContainer') }}",
                data:"id="+id,
                dataType:"html",
                success:function(result){
                    var tabel = JSON.parse(result);
                    $('#tblContainer').html(tabel);
                }
            })
        }

        /** Load Document **/
        function loadDoc(id){
            $.ajax({
                type:"POST",
                url:"{{ route('booking.loadDoc') }}",
                data:"id="+id,
                dataType:"html",
                success:function(result){
                    var tabel = JSON.parse(result);
                    $('#tblDoc').html(tabel);
                }
            })
        }


        /*** Hapus Commodity **/
        function hapusDetailCom(id){
            var r=confirm("Anda yakin menghapus data ini?");
            if (r==true){
                $.ajax({
                    type:"POST",
                    url:"{{ route('booking.deleteCommodity') }}",
                    data:"id="+ id,
                    success:function(result){
                        loadCommodity({{ Request::segment(3) }});
                        Toast.fire({
                            icon: 'success',
                            title: 'Deleted!'
                        });   
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Menghapus Dimension!');
                    }, 
                });
            }
        }

        function hapusDetailPckg(id){
            var r=confirm("Anda yakin menghapus data ini?");
            if (r==true){
                $.ajax({
                    type:"POST",
                    url:"{{ route('booking.deletePackages') }}",
                    data:"id="+ id,
                    success:function(result){
                        loadPackages({{ Request::segment(3) }});
                        Toast.fire({
                            icon: 'success',
                            title: 'Deleted!'
                        });   
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Menghapus Packages!');
                    }, 
                });
            }
        }

        function hapusDetailCon(id){
            var r=confirm("Anda yakin menghapus data ini?");
            if (r==true){
                $.ajax({
                    type:"POST",
                    url:"{{ route('booking.deleteContainer') }}",
                    data:"id="+ id,
                    success:function(result){
                        loadContainer({{ Request::segment(3) }});
                        Toast.fire({
                            icon: 'success',
                            title: 'Deleted!'
                        });   
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Menghapus data!');
                    }, 
                });
            }
        }

        function hapusDetailDoc(id){
            var r=confirm("Anda yakin menghapus data ini?");
            if (r==true){
                $.ajax({
                    type:"POST",
                    url:"{{ route('booking.deleteDoc') }}",
                    data:"id="+ id,
                    success:function(result){
                        loadDoc({{ Request::segment(3) }});
                        Toast.fire({
                            icon: 'success',
                            title: 'Deleted!'
                        });   
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Menghapus data!');
                    }, 
                });
            }
        }


        /*** Edit Dimension **/
        function editDetailCom(uom_com, uom_packages, weight_uom, volume_uom, id){
            let style   = '';
            let style2  = '';
            let style3  = '';
            let style4  = '';
            let html    = '';
            let html2   = '';
            let html3   = '';
            let html4   = '';
            $.ajax({
                url: "{{ route('quotation.quote_getAll') }}",
                type: "POST",
                dataType: "json",
                success: function(result) {
                    
                    $.each(result, function(i,data){
                        if(uom_com == data.id){
                            style = 'selected';
                        }else{
                            style = '';
                        }

                        /** Dropdown UOM Commodity **/
                        html += `<option value="${data.id}" ${style}>${data.uom_code}</option>`;

                        if(uom_packages == data.id){
                            style2 = 'selected';
                        }else{
                            style2 = '';
                        }

                        /** Dropdown UOM Packages **/
                        html2 += `<option value="${data.id}" ${style2}>${data.uom_code}</option>`;

                        if(weight_uom == data.id){
                            style3 = 'selected';
                        }else{
                            style3 = '';
                        }

                        /** Dropdown UOM Weight **/
                        html3 += `<option value="${data.id}" ${style3}>${data.uom_code}</option>`;

                        if(volume_uom == data.id){
                            style4 = 'selected';
                        }else{
                            style4 = '';
                        }

                        /** Dropdown UOM Packages **/
                        html4 += `<option value="${data.id}" ${style4}>${data.uom_code}</option>`;
                    })


                    $('#btnEditCom_'+id).hide();
                    $('#lbl_hs_code_'+id).hide();
                    $('#lbl_desc_'+id).hide();
                    $('#lbl_origin_'+id).hide();
                    $('#lbl_qty_com_'+id).hide();
                    $('#lbl_qty_uom_'+id).hide();
                    $('#lbl_qty_packages_'+id).hide();
                    $('#lbl_qty_pckg_uom_'+id).hide();
                    $('#lbl_weight_'+id).hide();
                    $('#lbl_weight_uom_'+id).hide();
                    $('#lbl_netto_'+id).hide();
                    $('#lbl_volume_'+id).hide();
                    $('#lbl_volume_uom_'+id).hide();

                    $("#qty_uom_"+id).show();
                    $("#qty_uom_"+id).html(html);
                    $("#qty_uom_"+id).select2({
                        theme: 'bootstrap4'
                    });
                    
                    $('#qty_pckg_uom_'+id).show();
                    $('#qty_pckg_uom_'+id).html(html2);
                    $("#qty_pckg_uom_"+id).select2({
                        theme: 'bootstrap4'
                    });

                    $('#weight_uom_'+id).show();
                    $('#weight_uom_'+id).html(html3);
                    $("#weight_uom_"+id).select2({
                        theme: 'bootstrap4'
                    });

                    $('#volume_uom_'+id).show();
                    $('#volume_uom_'+id).html(html4);
                    $("#volume_uom_"+id).select2({
                        theme: 'bootstrap4'
                    });

                    $('#hs_code_'+id).show();
                    $('#desc_'+id).show();
                    $('#origin_'+id).show();
                    $('#qty_com_'+id).show();
                    $('#qty_packages_'+id).show();
                    $('#weight_'+id).show();
                    $('#netto_'+id).show();
                    $('#volume_'+id).show();
                    $('#btnUpdateCom_'+id).show();
                }
            });
        }

        /*** Edit Packages **/
        function editDetailPckg(uom, id){
            let style   = '';
            let html    = '';
            $.ajax({
                url: "{{ route('quotation.quote_getAll') }}",
                type: "POST",
                dataType: "json",
                success: function(result) {
                    
                    $.each(result, function(i,data){
                        if(uom == data.id){
                            style = 'selected';
                        }else{
                            style = '';
                        }

                        /** Dropdown UOM Unit **/
                        html += `<option value="${data.id}" ${style}>${data.uom_code}</option>`;

                    })


                    $('#btnEditPckg_'+id).hide();
                    $('#lbl_merk_'+id).hide();
                    $('#lbl_qtyx_'+id).hide();
                    $('#lbl_unit_'+id).hide();

                    $("#unit_"+id).show();
                    $("#unit_"+id).html(html);
                    $("#unit_"+id).select2({
                        theme: 'bootstrap4'
                    });
                    
                    $('#merk_'+id).show();
                    $('#qtyx_'+id).show();
                    $('#btnUpdatePckg_'+id).show();
                }
            });
        }

        /*** Edit Container **/
        function editDetailCon(loaded_type, container_type, id){
            let style   = '';
            let style2  = '';
            let style3  = '';
            let html    = '';
            let html2   = '';
            let html3   = '';
            $.ajax({
                url: "{{ route('booking.getAll') }}",
                type: "POST",
                dataType: "json",
                success: function(result) {
                    $.each(result[0], function(i,data){
                        if(loaded_type == data.id){
                            style = 'selected';
                        }else{
                            style = '';
                        }

                        /** Dropdown UOM Unit **/
                        html += `<option value="${data.id}" ${style}>${data.loaded_type}</option>`;

                    });

                    $.each(result[1], function(i,data){
                        if(container_type == data.id){
                            style2 = 'selected';
                        }else{
                            style2 = '';
                        }

                        /** Dropdown UOM Unit **/
                        html2 += `<option value="${data.id}" ${style}>${data.container_type}</option>`;

                    });

                    $.each(result[2], function(i,data){
                        html3 += `<option value="${data.id}" ${style}>${data.uom_code}</option>`;
                    })



                    $('#btnEditCon_'+id).hide();
                    $('#lbl_con_numb_'+id).hide();
                    $('#lbl_size_'+id).hide();
                    $('#lbl_loaded_'+id).hide();
                    $('#lbl_container_'+id).hide();
                    $('#lbl_seal_no_'+id).hide();
                    $('#lbl_vgm_'+id).hide();
                    $('#lbl_resp_'+id).hide();
                    $('#lbl_auth_'+id).hide();
                    $('#lbl_mow_'+id).hide();
                    $('#lbl_wparty_'+id).hide();

                    $("#loaded_"+id).show();
                    $("#loaded_"+id).html(html);
                    $("#loaded_"+id).select2({
                        theme: 'bootstrap4'
                    });

                    $("#container_"+id).show();
                    $("#container_"+id).html(html2);
                    $("#container_"+id).select2({
                        theme: 'bootstrap4'
                    });

                    if($("#activityx").val() == 'export')
                    {

                        $('#vgm_'+id).show();
                        $('#resp_party_'+id).show();
                        $('#auth_person_'+id).show();
                        $('#mow_'+id).show();
                        $('#w_party_'+id).show();

                        $("#vgm_uom_"+id).show();
                        $("#vgm_uom_"+id).html(html3);
                        $("#vgm_uom_"+id).select2({
                            theme: 'bootstrap4'
                        });
                    }

                    $('#con_numb_'+id).show();
                    $('#size_'+id).show();
                    $('#seal_no_'+id).show();
                    $('#btnUpdateCon_'+id).show();
                }
            });
        }

        /*** Edit Packages **/
        function editDetailDoc(type_doc, id){
            let style   = '';
            let html    = '';
            $.ajax({
                url: "{{ route('booking.getDoc') }}",
                type: "POST",
                dataType: "json",
                success: function(result) {
                    
                    $.each(result, function(i,data){
                        if(type_doc == data.id){
                            style = 'selected';
                        }else{
                            style = '';
                        }

                        /** Dropdown UOM Unit **/
                        html += `<option value="${data.id}" ${style}>${data.name}</option>`;

                    })


                    $('#btnEditDoc_'+id).hide();
                    $('#lbl_docx_'+id).hide();
                    $('#lbl_doc_number_'+id).hide();
                    $('#lbl_doc_date_'+id).hide();

                    $("#docx_"+id).show();
                    $("#docx_"+id).html(html);
                    $("#docx_"+id).select2({
                        theme: 'bootstrap4'
                    });
                    
                    $('#doc_date_'+id).show();
                    $('#doc_number_'+id).show();
                    $('#btnUpdateDoc_'+id).show();
                }
            });
        }


        /** Update Commodity **/
        function updateDetailCom(id_detail, id)
        {
            if($.trim($("#hs_code_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Hs Code!'
                })
            }else if($.trim($("#desc_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Desc!'
                });
            }else if($.trim($("#origin_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Origin!'
                });
            }else if($.trim($("#qty_com_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Qty Commodity!'
                });
            }else if($.trim($("#qty_uom_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Qty Uom!'
                });
            }else if($.trim($("#qty_packages_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Qty Packages!'
                });
            }else if($.trim($("#qty_pckg_uom_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Qty Packages Uom!'
                });
            }else if($.trim($("#weight_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please enter weight!'
                });
            }else if($.trim($("#weight_uom_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Weight Uom!'
                });
            }else if($.trim($("#netto_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please enter Netto!'
                });
            }else if($.trim($("#volume_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please enter Volume!'
                });
            }else if($.trim($("#volume_uom_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Volume Uom!'
                });
            }else{
                $.ajax({
                    type:"POST",
                    url:"{{ route('booking.updateCommodity') }}",
                    data:{
                        id:id_detail,
                        hs_code:$('#hs_code_'+id).val(),
                        desc:$('#desc_'+id).val(),
                        origin:$('#origin_'+id).val(),
                        qty_com:$('#qty_com_'+id).val(),
                        qty_uom:$('#qty_uom_'+id).val(),
                        qty_packages:$('#qty_packages_'+id).val(),
                        qty_pckg_uom:$('#qty_pckg_uom_'+id).val(),
                        weight:$('#weight_'+id).val(),
                        weight_uom:$('#weight_uom_'+id).val(),
                        netto:$('#netto_'+id).val(),
                        volume:$('#volume_'+id).val(),
                        volume_uom:$('#volume_uom_'+id).val()
                    },
                    success:function(result){
                        loadCommodity({{ Request::segment(3) }}); 
                        Toast.fire({
                            icon: 'success',
                            title: 'Sukses Update Data!'
                        });
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Mengupdate Commodity!');
                    },          
                });
            }
        }

        /** Update Package **/
        function updateDetailPckg(id_detail, id)
        {
            if($.trim($("#merk_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Merk!'
                })
            }else if($.trim($("#qtyx_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Qty!'
                });
            }else if($.trim($("#unit_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Unit!'
                });
            }else{
                $.ajax({
                    type:"POST",
                    url:"{{ route('booking.updatePackages') }}",
                    data:{
                        id:id_detail,
                        merk:$('#merk_'+id).val(),
                        qty:$('#qtyx_'+id).val(),
                        unit:$('#unit_'+id).val()
                    },
                    success:function(result){
                        loadPackages({{ Request::segment(3) }}); 
                        Toast.fire({
                            icon: 'success',
                            title: 'Sukses Update Data!'
                        });
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Mengupdate Commodity!');
                    },          
                });
            }
        }

        /** Update COntainer **/
        function updateDetailCon(id_detail, id)
        {
            if($.trim($("#con_numb_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Container Number!'
                })
            }else if($.trim($("#size_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Size!'
                });
            }else if($.trim($("#container_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Container!'
                });
            }else if($.trim($("#seal_no_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Seal no!'
                });
            }else{
                $.ajax({
                    type:"POST",
                    url:"{{ route('booking.updateContainer') }}",
                    data:{
                        id:id_detail,
                        con_numb:$('#con_numb_'+id).val(),
                        size:$('#size_'+id).val(),
                        container:$('#container_'+id).val(),
                        loaded:$('#loaded_'+id).val(),
                        seal_no:$('#seal_no_'+id).val(),
                        vgm:$('#vgm_'+id).val(),
                        vgm_uom:$('#vgm_uom_'+id).val(),
                        resp_party:$('#resp_party_'+id).val(),
                        auth_person:$('#auth_person_'+id).val(),
                        mow:$('#mow_'+id).val(),
                        w_party:$('#w_party_'+id).val(),
                    },
                    success:function(result){
                        loadContainer({{ Request::segment(3) }}); 
                        Toast.fire({
                            icon: 'success',
                            title: 'Sukses Update Data!'
                        });
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Mengupdate Container!');
                    },          
                });
            }
        }

        /** Update Doc **/
        function updateDetailDoc(id_detail, id)
        {
            if($.trim($("#docx_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Doctype!'
                })
            }else if($.trim($("#doc_number_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Doc Number!'
                });
            }else if($.trim($("#doc_date_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Date!'
                });
            }else{
                $.ajax({
                    type:"POST",
                    url:"{{ route('booking.updateDoc') }}",
                    data:{
                        id:id_detail,
                        doc:$('#docx_'+id).val(),
                        number:$('#doc_number_'+id).val(),
                        date:$('#doc_date_'+id).val()
                    },
                    success:function(result){
                        loadDoc({{ Request::segment(3) }}); 
                        Toast.fire({
                            icon: 'success',
                            title: 'Sukses Update Data!'
                        });
                    },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal Mengupdate Commodity!');
                    },          
                });
            }
        }

        /** Save Detail Commodity **/
        function saveDetailCom(id){
            if($.trim($("#hs_code_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Hs Code!'
                })
            }else if($.trim($("#desc_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Desc!'
                });
            }else if($.trim($("#origin_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Origin!'
                });
            }else if($.trim($("#qty_com_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Qty Commodity!'
                });
            }else if($.trim($("#qty_uom_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Qty Uom!'
                });
            }else if($.trim($("#qty_packages_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Qty Packages!'
                });
            }else if($.trim($("#qty_pckg_uom_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Qty Packages Uom!'
                });
            }else if($.trim($("#weight_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please enter weight!'
                });
            }else if($.trim($("#weight_uom_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Weight Uom!'
                });
            }else if($.trim($("#netto_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please enter Netto!'
                });
            }else if($.trim($("#volume_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please enter Volume!'
                });
            }else if($.trim($("#volume_uom_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Volume Uom!'
                });
            }else{
                $.ajax({
                type:"POST",
                url:"{{ route('booking.addCommodity') }}",
                data:{
                    booking:{{ $quote->id }},
                    hs_code:$('#hs_code_'+id).val(),
                    desc:$('#desc_'+id).val(),
                    origin:$('#origin_'+id).val(),
                    qty_com:$('#qty_com_'+id).val(),
                    qty_uom:$('#qty_uom_'+id).val(),
                    qty_packages:$('#qty_packages_'+id).val(),
                    qty_pckg_uom:$('#qty_pckg_uom_'+id).val(),
                    weight:$('#weight_'+id).val(),
                    weight_uom:$('#weight_uom_'+id).val(),
                    netto:$('#netto_'+id).val(),
                    volume:$('#volume_'+id).val(),
                    volume_uom:$('#volume_uom_'+id).val()
                },
                success:function(result){
                    $('#hs_code_'+id).val('');
                    $('#desc_'+id).val('');
                    $('#origin_'+id).val('');
                    $('#qty_com_'+id).val('');
                    $('#qty_uom_'+id).val('').trigger('change');
                    $('#qty_packages_'+id).val('');
                    $('#qty_pckg_uom_'+id).val('').trigger('change');
                    $('#weight_'+id).val('');
                    $('#weight_uom_'+id).val('').trigger('change');
                    $('#netto_'+id).val('');
                    $('#volume_'+id).val('');
                    $('#volume_uom_'+id).val('').trigger('change');
                    loadCommodity({{ Request::segment(3) }});
                    Toast.fire({
                        icon: 'success',
                        title: 'Sukses Add Data!'
                    });
                },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal menambahkan item!');
                    },  
                });
            }
        }

        /** Save Detail Packages **/
        function saveDetailPckg(id){
            if($.trim($("#merk_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Merk!'
                })
            }else if($.trim($("#qtyx_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Qty!'
                });
            }else if($.trim($("#unit_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Unit!'
                });
            }else{
                $.ajax({
                type:"POST",
                url:"{{ route('booking.addPackages') }}",
                data:{
                    booking:{{ $quote->id }},
                    merk:$('#merk_'+id).val(),
                    qty:$('#qtyx_'+id).val(),
                    unit:$('#unit_'+id).val()
                },
                success:function(result){
                    $('#merk_'+id).val('');
                    $('#qtyx_'+id).val('');
                    $('#unit_'+id).val('').trigger('change');
                    loadPackages({{ Request::segment(3) }});
                    Toast.fire({
                        icon: 'success',
                        title: 'Sukses Add Data!'
                    });
                },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal menambahkan item!');
                    },  
                });
            }
        }

        /** Save Detail Container **/
        function saveDetailCon(id){
            if($.trim($("#con_numb_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Container Number!'
                })
            }else if($.trim($("#size_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Size!'
                });
            }else if($.trim($("#container_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Container!'
                });
            }else if($.trim($("#seal_no_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Seal no!'
                });
            }else{
                $.ajax({
                type:"POST",
                url:"{{ route('booking.addContainer') }}",
                data:{
                    booking:{{ $quote->id }},
                    con_numb:$('#con_numb_'+id).val(),
                    size:$('#size_'+id).val(),
                    container:$('#container_'+id).val(),
                    loaded:$('#loaded_'+id).val(),
                    seal_no:$('#seal_no_'+id).val(),
                    vgm:$('#vgm_'+id).val(),
                    vgm_uom:$('#vgm_uom_'+id).val(),
                    resp_party:$('#resp_party_'+id).val(),
                    auth_person:$('#auth_person_'+id).val(),
                    mow:$('#mow_'+id).val(),
                    w_party:$('#w_party_'+id).val(),
                },
                success:function(result){
                    $('#con_numb_'+id).val('');
                    $('#size_'+id).val('');
                    $('#container_'+id).val('').trigger('change');
                    $('#loaded_'+id).val('').trigger('change');
                    $('#seal_no_'+id).val('');
                    $('#vgm_'+id).val('');
                    $('#vgm_uom_'+id).val('').trigger('change');
                    $('#resp_party_'+id).val('');
                    $('#auth_person_'+id).val('');
                    $('#mow_'+id).val('');
                    $('#w_party_'+id).val('');
                    loadContainer({{ Request::segment(3) }});
                    Toast.fire({
                        icon: 'success',
                        title: 'Sukses Add Data!'
                    });
                },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal menambahkan item!');
                    },  
                });
            }
        }

        /** Save Detail Packages **/
        function saveDetailDoc(id){
            if($.trim($("#docx_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Doctype!'
                })
            }else if($.trim($("#doc_number_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Doc Number!'
                });
            }else if($.trim($("#doc_date_"+id).val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Enter Date!'
                });
            }else{
                $.ajax({
                type:"POST",
                url:"{{ route('booking.addDoc') }}",
                data:{
                    booking:{{ $quote->id }},
                    doc:$('#docx_'+id).val(),
                    number:$('#doc_number_'+id).val(),
                    date:$('#doc_date_'+id).val()
                },
                success:function(result){
                    $('#docx_'+id).val('').trigger('change');
                    $('#doc_number_'+id).val('');
                    $('#doc_date_'+id).val('');
                    loadDoc({{ Request::segment(3) }});
                    Toast.fire({
                        icon: 'success',
                        title: 'Sukses Add Data!'
                    });
                },error: function (xhr, ajaxOptions, thrownError) {           
                        alert('Gagal menambahkan item!');
                    },  
                });
            }
        }

        function updateData(status)
        {
            let s = '';
            if(status == 1){
                s = 'simpan final';
            }else{
                s = 'mengupdate';
            }

            var r=confirm(`Anda yakin ingin ${s} data ini?`);
            if(r == true){
                $("#status_final").val(status);
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
                }else if($.trim($("#customer").val()) == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Select Customer',
                        icon: 'error'
                    })
                }else if($.trim($("#shipper").val()) == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Select Shipper',
                        icon: 'error'
                    })
                }else if($.trim($("#consignee").val()) == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Select Consignee',
                        icon: 'error'
                    })
                }else if($.trim($("#notify_party").val()) == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please select Notify Party',
                        icon: 'error'
                    })
                }else if($.trim($("#agent").val()) == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input Agent',
                        icon: 'error'
                    })
                }else if($.trim($("#shipping_line").val()) == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please select Shipping Line',
                        icon: 'error'
                    })
                }else{
                    $(this).prop('disabled', false).text('Please Wait ...');
                    $('#formku').submit();
                }
            }
            
        }

        $(function() {
            loadCommodity({{ Request::segment(3) }});
            loadPackages({{ Request::segment(3) }});
            loadContainer({{ Request::segment(3) }});
            loadDoc({{ Request::segment(3) }}); 
            loadRoadCons({{ Request::segment(3) }});
            loadSchedule({{ Request::segment(3) }});
        });
    </script>
@endpush
@endsection