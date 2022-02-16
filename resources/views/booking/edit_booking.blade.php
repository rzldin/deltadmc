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
                            <strong>{{ ucwords($booking->activity) }}</strong>
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
                                                <?php $verse = $booking->version_no; ?>
                                                @if ($booking->activity == 'domestic')
                                                    {{\App\Http\Controllers\BookingController::edit_header_domestic($booking, $verse)}}
                                                @elseif($booking->activity == 'export')
                                                    {{\App\Http\Controllers\BookingController::edit_header_export($booking, $verse)}}
                                                @elseif($booking->activity == 'import')
                                                    {{\App\Http\Controllers\BookingController::edit_header_import($booking, $verse)}}
                                                @endif
                                            </form>
                                            <div class="row float-right mt-2">
                                                <?php if($booking->shipment_by == 'SEA') {?>
                                                    @if ($booking->loaded_type == 'FCL')
                                                    <a href="{{ url('booking/cetak_si_trucking_fcl/'.$booking->id) }}" target="_blank" class="btn btn-dark btn-sm m-2"><i class="fa fa-print"></i> Print SI Trucking</a>
                                                    <a href="{{ url('booking/cetak_si_fcl/'.$booking->id) }}" target="_blank" class="btn btn-danger btn-sm m-2"><i class="fa fa-print"></i> Print SI</a>
                                                    @else
                                                    <a href="{{ url('booking/cetak_si_trucking_lcl/'.$booking->id) }}" target="_blank" class="btn btn-dark btn-sm m-2"><i class="fa fa-print"></i> Print SI Trucking</a>
                                                    <a href="{{ url('booking/cetak_si_lcl/'.$booking->id) }}" target="_blank" class="btn btn-danger btn-sm m-2"><i class="fa fa-print"></i> Print SI</a>
                                                    @endif
                                                <?php }elseif($booking->shipment_by == 'AIR'){?>
                                                    <a href="{{ url('booking/cetak_si_air/'.$booking->id) }}" target="_blank" class="btn btn-danger btn-sm m-2"><i class="fa fa-print"></i> Print SI</a>
                                                <?php }?>

                                            </div>
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
                                                               <th >Netto</th>
                                                               <th width="15%">Volume</th>
                                                               <th width="5%">Action</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                           <tbody id="tblCommodity">

                                                           </tbody>
                                                        @if($booking->flag_invoice == 0)
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
                                                        @endif
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
                                                        @if($booking->flag_invoice == 0)
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
                                                        @endif
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
                                                    @if ($booking->activity == 'export')
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
                                                               @if ($booking->activity == 'export')
                                                                <th width="10%">VGM</th>
                                                                <th width="7%">Uom</th>
                                                                <th width="10%">Resp.Party</th>
                                                                <th width="10%">Auth.Person</th>
                                                                <th width="8%">M.o.w</th>
                                                                <th width="10%">Weighing Party</th>
                                                               @endif
                                                               <th width="15%">Action</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                           <tbody id="tblContainer">

                                                           </tbody>
                                                        @if($booking->flag_invoice == 0)
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
                                                                @if ($booking->activity == 'export')
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
                                                        @endif
                                                       </tbody>
                                                   </table>
                                                </div>
                                            </div>

                                        </div>
                                        @if ($booking->activity == 'export')
                                        <div class="col-md-12 mb-3 ">
                                            <a href="{{ url('booking/cetak_vgm/'.$booking->id) }}" class="btn btn-md btn-success float-right" target="_blank"><i class="fa fa-file"></i> Print VGM Certificate</a>
                                        </div>
                                        @endif
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
                                                        @if($booking->flag_invoice == 0)
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
                                                        @endif
                                                       </tbody>
                                                   </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                        @if($booking->flag_invoice == 1 && $booking->status == 0)
                                        <a class="btn btn-warning mb-4 float-right mr-2" onclick="requestOpen('{{ $booking->id }}')"><i class="fa fa-question"></i> Request Open </a>
                                        @endif

                                        @if($booking->status == 8 && ($user->role_id == 3 || $user->role_id == 1))
                                            <button type="button" class="btn btn-primary mb-4 float-right mr-2" onClick="approveRequest({{ $booking->id }});"><i class="fa fa-save"></i> Approve Request</button>
                                        @endif
                                            <button type="button" class="btn btn-primary mb-4 float-left mr-2" onclick="updateData(1)">
                                                <i class="fa fa-save"></i> Save as Final
                                            </button>
                                        @if($booking->flag_invoice == 0)
                                            <a href="{{ url('booking/booking_new/'.$booking->id) }}" onclick="return confirm('build a new version?')"class="btn btn-info float-left mr-2">
                                                <i class="fa fa-plus"></i> New Version
                                            </a>
                                        @endif
                                        @if($booking->status != 9)
                                            <form action="{{ route('booking.cancel') }}" method="post" target="_self" name="form_cancel" id="form_cancel">
                                                <input type="hidden" name="booking" value="{{ $booking->id }}">
                                                {{ csrf_field() }}
                                                <button type="button" class="btn btn-danger float-left mr-2" id="cancel_confirm">
                                                    <i class="fa fa-times"></i> Cancel
                                                </button>
                                            </form>
                                            @if($booking->status != 2)
                                                <form action="{{ route('booking.cancel_inv') }}" method="post" target="_self" name="form_cancel_inv" id="form_cancel_inv">
                                                    <input type="hidden" name="booking" value="{{ $booking->id }}">
                                                    {{ csrf_field() }}
                                                    <button type="button" class="btn btn-danger float-left mr-2" id="cancel_inv_confirm">
                                                        <i class="fa fa-times"></i> Cancel with Invoice
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
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
                                                @if($booking->flag_invoice == 0)
                                                    <a class="btn btn-dark btn-sm float-left" onclick="newRoad()"><i class="fa fa-plus"></i> Add Data</a>
                                                @endif
                                                    <a href="{{ url('booking/cetak_suratjalan/'.$booking->id) }}" target="_blank" class="btn btn-success btn-sm float-right"><i class="fa fa-print"></i> Print Surat Jalan</a>
                                                </div>
                                                <div class="card-body">
                                                    <table id="myTable" class="table table-bordered table-striped" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <td width="15%">No. SJ</td>
                                                                <td width="15%">Vehicle Type</td>
                                                                <td width="10%">Vehicle No</td>
                                                                <td width="20%">Driver</td>
                                                                <td width="10%">Driver Phone</td>
                                                                <td>Pickup Address</td>
                                                                <td>Delivery Address</td>
                                                                <td>Notes</td>
                                                                <td>Action</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tblRoadCons">
                                                            <div class="align-items-center bg-white justify-content-center spinner_load_cons">
                                                                <div class="spinner-border" role="status">
                                                                  <span class="sr-only">Loading...</span>
                                                                </div>
                                                            </div>
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
                                                <input type="hidden" name="booking_id" id="booking_id" value="{{ $booking->id }}">
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
                                                    @if($booking->flag_invoice == 0)
                                                    <a class="btn btn-dark btn-sm float-right" onclick="newSchedule()"><i class="fa fa-plus"></i> Add Data</a>
                                                    @endif
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
                                                <input type="hidden" name="booking_id" id="booking_id" value="{{ $booking->id }}">
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
                                <div class="container-fluid mt-3">
                                  <div class="row">
                                    <div class="col-md-12">
                                        <a class="btn btn-primary btn-sm float-right" onclick="newDetailQuote()"><i class="fa fa-plus"></i> Add Detail Quote</a>
                                    </div>
                                  </div>
                                </div>
                                @if ($responsibility->t_mresponsibility_id != 5)
                                <section class="content">
                                    <div class="container-fluid mt-3">
                                      <div class="row">
                                        <div class="col-md-12">
                                            <form id="fCost" method="get">
                                                @csrf
                                                <div class="card card-warning">
                                                    <input type="hidden" name="t_booking_id" value="{{ $booking->id }}">
                                                    <div class="card-header">
                                                        <h5 class="card-title">Cost</h5>
                                                        <a class="btn btn-success float-right" onclick="redirectToCostInvoice()"><i class="fas fa-check"></i> Input Invoice for selected</a>
                                                        <a href="{{ url('booking/preview/'.$booking->id) }}" class="btn btn-info float-right" style="margin-right: 5px" target="_blank"><i class="fa fa-file"></i> Preview Booking</a>
                                                    </div>
                                                    <div class="card-body table-responsive p-0 text-center">
                                                        <table class="table table-bordered table-striped" id="myTable2" style="width: 150%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>No.</th>
                                                                    <th>Service/Fee</th>
                                                                    <th>Description</th>
                                                                    <th>Reimburse</th>
                                                                    <th>Unit</th>
                                                                    <th>Currency</th>
                                                                    <th>rate/unit</th>
                                                                    <th>Total</th>
                                                                    <th>ROE</th>
                                                                    <th>Vat</th>
                                                                    <th>Amount</th>
                                                                    <th width="10%">Paid To</th>
                                                                    <th>Invoice No.</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tblCost">
                                                                <div class="align-items-center bg-white justify-content-center spinner_load">
                                                                    <div class="spinner-border" role="status">
                                                                      <span class="sr-only">Loading...</span>
                                                                    </div>
                                                                </div>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </form>
                                            <form id="fSell" method="get">
                                                    @csrf
                                                <div class="card-success">
                                                    <input type="hidden" name="t_booking_id" value="{{ $booking->id }}">
                                                    <div class="card-header">
                                                        <h5 class="card-title">Sell</h5>
                                                        <a href="javascript:void(0)" onclick="redirectToProformaInvoice()" class="btn btn-warning float-right"><i class="fas fa-check"></i> Create Invoice Selected</a>
                                                    </div>
                                                    <div class="card-body table-responsive p-0">
                                                        <table class="table table-bordered table-striped" id="myTable2" style="width: 150%">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>No.</th>
                                                                <th>Service/Fee</th>
                                                                <th>Description</th>
                                                                <th>Reimburse</th>
                                                                <th>Unit</th>
                                                                <th>Currency</th>
                                                                <th>rate/unit</th>
                                                                <th>Total</th>
                                                                <th>ROE</th>
                                                                <th>Vat</th>
                                                                <th>Amount</th>
                                                                <th style="width:10%;">Bill To</th>
                                                                <th>Note</th>
                                                                <th>Type</th>
                                                                <th>Invoice No.</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="tblSell">
                                                                <div class="align-items-center bg-white justify-content-center spinner_load">
                                                                    <div class="spinner-border" role="status">
                                                                      <span class="sr-only">Loading...</span>
                                                                    </div>
                                                                </div>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h5>Profit Analysis</h5>
                                                </div>
                                                <div class="card-body">
                                                    <table id="myTablex" class="table table-bordered table-striped" width="100%">
                                                        <thead>
                                                          <tr>
                                                            @if ($booking->shipment_by != 'LAND')
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
                                                            <div class="align-items-center bg-white justify-content-center spinner_load">
                                                                <div class="spinner-border" role="status">
                                                                  <span class="sr-only">Loading...</span>
                                                                </div>
                                                            </div>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="client_addrx" value="{{ $booking->client_addr_id }}">
    <input type="hidden" id="client_picx" value="{{ $booking->client_pic_id }}">
    <input type="hidden" id="shipper_addrx" value="{{ $booking->shipper_addr_id }}">
    <input type="hidden" id="shipper_picx" value="{{ $booking->shipper_pic_id }}">
    <input type="hidden" id="consignee_addrx" value="{{ $booking->consignee_addr_id }}">
    <input type="hidden" id="consignee_picx" value="{{ $booking->consignee_pic_id }}">
    <input type="hidden" id="notifyParty_addrx" value="{{ $booking->not_party_addr_id }}">
    <input type="hidden" id="notifyParty_picx" value="{{ $booking->not_party_pic_id }}">
    <input type="hidden" id="agent_addrx" value="{{ $booking->agent_addr_id }}">
    <input type="hidden" id="agent_picx" value="{{ $booking->agent_pic_id }}">
    <input type="hidden" id="shipline_addrx" value="{{ $booking->shpline_addr_id }}">
    <input type="hidden" id="shipline_picx" value="{{ $booking->shpline_pic_id }}">
    <input type="hidden" id="vendor_addrx" value="{{ $booking->vendor_addr_id }}">
    <input type="hidden" id="vendor_picx" value="{{ $booking->vendor_pic_id }}">
</section>
<!--- Modal Form -->
<div class="modal fade" id="HBLMODAL" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                <h4 class="modal-title">&nbsp;</h4>
            </div>
            <br>
            <div class="modal-body">
                <form class="eventInsForm" method="post" target="_self" name="formku"
                      id="formku" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Number of original prints HBL <font color="red">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" class="form-control" id="original_hbl" onkeyup="numberOnly(this)" maxlength="2">
                            <input type="hidden" id="hbl_print_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Number of Copy Non nego prints HBL <font color="red">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" class="form-control" id="copy_non_nego_hbl" onkeyup="numberOnly(this)" maxlength="2">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onClick="cetak_hbl();"><i class="fa fa-print"></i> Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detail-quote" tabindex="-1" role="basic" aria-hidden="true">
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
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                            Service/Fee<font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs44" name="charge" id="charge">
                                <option value="">--Select Charge Code--</option>
                                @foreach ($charge as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="id_dtl_quote" id="id_dtl_quote">
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                            Description
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" class="form-control" name="desc" id="descx" placeholder="Desc ...">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                            Currency <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs44" name="currency" id="currencyx" onchange="get_rate(this.value)">
                                <option value="">--Select Currency--</option>
                                @foreach ($currency as $item)
                                <option value="{{ $item->id }}">{{ $item->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                            Rate <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" class="form-control" name="rate" id="ratex" placeholder="Rate ..." value="" onkeyup="hitungx()">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                            Cost <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" class="form-control" name="cost" id="costx" placeholder="Cost ..." onkeyup="hitungx()">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                            Sell <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" class="form-control" name="sell" id="sellx" placeholder="Sell ..." onkeyup="hitungx()">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                            Qty <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" class="form-control" name="qty" id="qtyx" placeholder="Qty ..." onkeyup="hitungx()">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                            Cost Value <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" class="form-control" name="cost_val" id="cost_valx" placeholder="Cost Value ..." readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                            Sell Value <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" class="form-control" name="sell_val" id="sell_valx" placeholder="Sell Value ..." readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                            Vat
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" class="form-control" name="vat" id="vatx" placeholder="Vat ..." onkeyup="hitungTotalx()">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                            Total <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" class="form-control" name="total" id="totalx" placeholder="Total ..." readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                           Note
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="text" class="form-control" name="note" id="notex" placeholder="Note ...">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 col-xs-4">
                           Reimbursement
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <input type="checkbox" name="reimburs" id="reimburs">
                            <input type="hidden" name="reimbursx" id="reimbursx" value="">
                            <small>Nilai cost dan sell akan otomatis sama saat disimpan. *Mengikuti nilai cost</small>
                        </div>
                    </div>
                    <div class="row mb-2" id="show_name_to">
                        <div class="col-md-4 col-xs-4">
                           <span id="name_to_text">asddasa</span>
                           <input type="hidden" id="jenis_edit">
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <select class="form-control select2bs44" name="name_to" id="name_to">
                                <option value="">--Select Company--</option>
                                @foreach ($company as $item)
                                <option value="{{ $item->id }}">{{ '('.$item->client_code.') '.$item->client_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="detail_quote_submit" onClick="saveDetailxxx(); this.disabled=true;"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>

    <!-- Modal Add Customer -->
    <div class="modal fade" id="add-customer" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <br>
                <div class="modal-body">
                    <form class="eventInsForm" method="post" target="_self" name="formRoad" 
                            id="formRoad" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Company Code <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="client_code" name="client_code" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Company Code...">
                                <input type="hidden" id="company_type">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Company Name <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="client_name" name="client_name" 
                                    class="form-control myline" style="margin-bottom:5px"  placeholder="Input Company Name...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Tax ID <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="npwp" name="npwp" 
                                    class="form-control myline" style="margin-bottom:5px"  placeholder="Tax ID...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Account <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="account" id="account">
                                    <option value="" disabled selected>-- Select Account --</option>
                                    @foreach ($list_account as $account)
                                    <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Sales By <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="sales" id="sales">
                                    <option value="" disabled selected>-- Select Sales --</option>
                                    @foreach ($list_sales as $sales)
                                    <option value="{{ $sales->user_id }}">{{ $sales->user_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 col-xs-4">
                                Legal Doc
                            </div>
                            <div class="col-md-8 col-xs-8">
                                <div class="custom-control custom-checkbox">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="legal_doc" name="legal_doc" value="1">
                                        <label for="legal_doc">
                                            LEGAL DOC
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 col-xs-4">
                                Status
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <div class="custom-control custom-checkbox">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="status" name="status" value="1" checked>
                                        <label for="status">
                                            ACTIVE
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 col-xs-4">
                                Add To
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="customer" name="customer" value="1">
                                            <label for="customer">
                                                CUSTOMER
                                            </label>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="vendor_mdl" name="vendor_mdl" value="1">
                                            <label for="vendor_mdl">
                                                VENDOR
                                            </label>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="buyer_mdl" name="buyer" value="1">
                                            <label for="buyer_mdl">
                                                BUYER
                                            </label>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="seller_mdl" name="seller" value="1">
                                            <label for="seller_mdl">
                                                SELLER
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="shipper_mdl" name="shipper" value="1">
                                            <label for="shipper_mdl">
                                                SHIPPER
                                            </label>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="agent_mdl" name="agent" value="1">
                                            <label for="agent_mdl">
                                                AGENT
                                            </label>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="ppjk_mdl" name="ppjk" value="1">
                                            <label for="ppjk_mdl">
                                                PPJK
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">                        
                    <button type="button" class="btn btn-primary" onClick="saveCustomer();"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--- Modal Add Port -->
    <div class="modal fade" id="add-port" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <br>
                <div class="modal-body">
                    <form class="eventInsForm" method="post" target="_self" name="formPort" 
                        id="formPort" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Port Code <font color="#f00">*</font>
                            </div>
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="port" name="port" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Port Code ...">
                                <input type="hidden" id="type_add" name="id">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Port Name <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="port_name" name="port_name" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Port Name ...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Port Type <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="port_type" id="port_type">
                                    <option value="" disabled selected>-- Select Port Type --</option>
                                    <option value="SEA">SEA</option>
                                    <option value="AIR">AIR</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Country <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="country" id="country_port">
                                    <option value="" disabled selected>-- Select Country --</option>
                                    @foreach ($list_country as $country)
                                    <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                            Province <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="province_port" name="province" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Province ...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                            City <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="city_port" name="city" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input City ...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                            Postal Code <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="postal_code_port" name="postal_code" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Postal Code ...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                            Address <font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <textarea name="address" id="address_port" class="form-control" rows="3" placeholder="Input Address..."></textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Status
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="status_port" name="status" checked>
                                    <label for="status">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">                        
                    <button type="button" class="btn btn-primary" onClick="savePort();"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--- Modal Add Carrier -->
    <div class="modal fade" id="add-carrier" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <br>
                <div class="modal-body">
                    <form class="eventInsForm" method="post" target="_self" name="formCarrier" 
                        id="formCarrier" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Code <font color="#f00">*</font>
                            </div>
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="code" name="code" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Code ..">
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Name<font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="name" name="name" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Name ...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                Flag<font color="#f00">*</font>
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="flag" id="flag">
                                    <option value="" disabled selected>--Pilih--</option>
                                    @foreach ($list_country as $lc)
                                        <option value="{{ $lc->id }}">{{ $lc->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Lloyds Code
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <input type="text" id="llyods" name="llyods" 
                                    class="form-control myline" style="margin-bottom:5px" placeholder="Input Llyods Code ...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-4">
                                Status
                            </div>                                
                            <div class="col-md-8 col-xs-8">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="status" name="status" checked>
                                    <label for="status">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">                        
                    <button type="button" class="btn btn-primary" onClick="saveCarrier();"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

<!--- Request Form -->
<div class="modal fade" id="requestOpen" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                <h4 class="modal-title">&nbsp;</h4>
            </div>
            <br>
            <div class="modal-body">
                <form class="eventInsForm" method="post" target="_self" name="request_form" action="{{ route('booking.update_request') }}" 
                      id="request_form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4 col-xs-4">
                            Keterangan
                        </div>
                        <div class="col-md-8 col-xs-8">
                            <textarea class="form-control" name="open_remarks" id="open_remarks"></textarea>
                            <input type="hidden" name="id_booking" id="id_booking_request">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">                        
                <button type="button" class="btn btn-primary" onClick="$('#request_form').submit()"><i class="fa fa-save"></i> Ajukan Request</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
<form  method="post" target="_self" name="approve_request_form" action="{{ route('booking.approve_request') }}" 
  id="approve_request_form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="id_booking" id="approve_request_id">  
</form>
@push('after-scripts')
    <script>

    function requestOpen(id){
        $('#id_booking_request').val(id);
        $("#requestOpen").find('.modal-title').text('Request Open Booking');
        $("#requestOpen").modal('show',{backdrop: 'true'}); 
    }

    function approveRequest(id){
        if (confirm('Anda yakin meng-approve request booking ini ?')) {
            $('#approve_request_id').val(id);
            $('#approve_request_form').submit(); 
        }
    }

    $(document).ready(function(){
        $('#reimburs').click(function() {
            if($('#reimburs').is(':checked')){
                $('#reimbursx').val(1);
            }else{
                $('#reimbursx').val(0);
            }
            console.log($('#reimbursx').val());
        });

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
        $(".dataTables_empty").hide();
    })

    var dsState;

    $("#cancel_confirm").click(function(){
        var result = confirm("Anda yakin ingin meng-cancel booking ini ?");
        if (result) {
            $('#form_cancel').submit();
        }
    });

    $("#cancel_inv_confirm").click(function(){
        var result = confirm("Anda yakin ingin meng-cancel booking ini ?");
        if (result) {
            $('#form_cancel_inv').submit();
        }
    });

    /** Add Customer **/
    function addCustomer(val)
    {
        if(val == 'client'){
            $('#company_type').val('client')
        }else if(val == 'shipper'){
            $('#company_type').val('shipper')
        }else if(val == 'consignee'){
            $('#company_type').val('consignee')
        }else if(val == 'notifyParty'){
            $('#company_type').val('notifyParty')
        }else if(val == 'agent'){
            $('#company_type').val('agent')
        }else if(val == 'shipline'){
            $('#company_type').val('shipline')
        }else if(val == 'vendor'){
            $('#company_type').val('vendor')
        }

        $('#client_code').val('');
        $('#client_name').val('');
        $('#npwp').val('');
        $('#account').val('').trigger("change");
        $('#sales').val('').trigger("change");
        $('#legal_doc').prop('checked', false);
        $('#customer').prop('checked', false);
        $('#vendor_mdl').prop('checked', false);
        $('#buyer_mdl').prop('checked', false);
        $('#seller_mdl').prop('checked', false);
        $('#shipper_mdl').prop('checked', false);
        $('#agent_mdl').prop('checked', false);
        $('#ppjk_mdl').prop('checked', false);
        
        $("#add-customer").find('.modal-title').text('Add Data');
        $("#add-customer").modal('show',{backdrop: 'true'}); 
    }

    function saveCustomer(){
        if($.trim($("#client_code").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter Company Code',
                icon: 'error'
            })
        }else if($.trim($("#client_name").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter Company Name',
                icon: 'error'
            })
        }else if($.trim($("#sales").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Sales',
                icon: 'error'
            })
        }else{
            $.ajax({
            type:"POST",
            url:"{{ route('master.company_doAdd') }}",
            data:{
                client_code : $('#client_code').val(),
                client_name : $('#client_name').val(),
                npwp : $('#npwp').val(),
                account : $('#account').val(),
                sales : $('#sales').val(),
                legal_doc : $('#legal_doc').val(),
                status : $('#status').val(),
                customer : $('#customer').val(),
                vendor : $('#vendor_mdl').val(),
                buyer : $('#buyer_mdl').val(),
                seller : $('#seller_mdl').val(),
                shipper : $('#shipper_mdl').val(),
                agent : $('#agent_mdl').val(),
                ppjk : $('#ppjk_mdl').val()

            },
            success:function(result){
                $('#add-customer').modal('hide')

                if($('#company_type').val() == 'client'){
                    get_customer({{ $booking->client_id }});
                }else if($('#company_type').val() == 'shipper'){
                    get_shipper();
                }else if($('#company_type').val() == 'consignee'){
                    get_consignee();
                }else if($('#company_type').val() == 'notifyParty'){
                    get_notifyParty();
                }else if($('#company_type').val() == 'agent'){
                    get_agent();
                }else if($('#company_type').val() == 'shipline'){
                    get_shippingLine();
                }else if($('#company_type').val() == 'vendor'){
                    get_vendor();    
                }
                
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

    /** Add Carrier **/
    function addCarrier()
    {
        $('#code').val('');
        $('#name').val('');
        $('#flag').val('').trigger("change");
        $('#lloyds_code').val('');
        
        $("#add-carrier").find('.modal-title').text('Add Data');
        $("#add-carrier").modal('show',{backdrop: 'true'}); 
    }

    function saveCarrier(){
        if($.trim($("#code").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter Code',
                icon: 'error'
            })
        }else if($.trim($("#name").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter Name',
                icon: 'error'
            })
        }else if($.trim($("#flag").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Country',
                icon: 'error'
            })
        }else{
            $.ajax({
                type:"POST",
                url:"{{ route('master.cek_carrier_code') }}",
                data:"data="+$("#code").val(),
                success:function(result){
                    if(result=="duplicate"){
                        Swal.fire({
                            title: 'Error!',
                            text: 'Carrier Code Existing',
                            icon: 'error'
                        })
                    }else{    
                        $.ajax({
                            type:"POST",
                            url:"{{ route('master.carrier_doAdd') }}",
                            data:{
                                code:$('#code').val(),
                                name:$('#name').val(),
                                flag:$('#flag').val(),
                                llyods:$('#lloyds_code').val(),
                                status:$('#status').val()

                            },
                            success:function(result){
                                $('#add-carrier').modal('hide')
                                load_carrier({{ $booking->carrier_id }})
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
            });
        }
        
    };


    /** Add Port **/
    function addPort(val)
    {
        $('#port').val('');
        $('#port_name').val('');
        $('#port_type').val('').trigger("change");
        $('#country_port').val('').trigger("change");
        $('#province_port').val('');
        $('#city_port').val('');
        $('#postal_code_port').val('');
        $('#address_port').val('');
        $('#type_add').val(val);
        
        $("#add-port").find('.modal-title').text('Add Data');
        $("#add-port").modal('show',{backdrop: 'true'}); 
    }

    function savePort(){

        let type = $("#type_add").val();

        if($.trim($("#port").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter Port Code',
                icon: 'error'
            });
        }else if($.trim($("#port_name").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter Port Name',
                icon: 'error'
            });
        }else if($.trim($("#port_type").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Port Type',
                icon: 'error'
            });
        }else if($.trim($("#country_port").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Country',
                icon: 'error'
            });
        }else if($.trim($("#province_port").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter Province',
                icon: 'error'
            });
        }else if($.trim($("#city_port").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please enter City',
                icon: 'error'
            });
        }else{
            $.ajax({
                type:"POST",
                url:"{{ route('master.cek_port_code') }}",
                data:"data="+$("#port").val(),
                success:function(result){
                    if(result=="duplicate"){
                        Swal.fire({
                            title: 'Error!',
                            text: 'Port Code Existing',
                            icon: 'error'
                        })
                    }else{ 

                        $.ajax({
                            type:"POST",
                            url:"{{ route('master.port_doAdd') }}",
                            data:{
                                port:$('#port').val(),
                                port_name:$('#port_name').val(),
                                port_type:$('#port_type').val(),
                                country:$('#country_port').val(),
                                province:$('#province_port').val(),
                                city:$('#city_port').val(),
                                postal_code:$('#postal_code_port').val(),
                                address:$('#address_port').val(),
                                status:$('#status_port').val()

                            },
                            success:function(result){
                                $('#add-port').modal('hide')

                                // if(type == 'pol'){
                                //     portOfLoading();
                                // }else if(type == 'pot'){
                                //     portOfTransit();
                                // }else if(type == 'pod'){
                                //     portOfDischarge();
                                // }
                                // portOfLoading()
                                // portOfTransit()
                                // portOfDischarge()
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
            });  
        }
        
    };

        function newDetailQuote()
        {
            $('#charge').val('').trigger('change');
            $('#descx').val('');
            $('#currencyx').val('').trigger('change');
            $('#reimburs').prop('checked',false);
            $('#reimbursx').val(0);
            $('#rate').val('');
            $('#ratex').val('');
            $('#costx').val('');
            $('#sellx').val('');
            $('#qtyx').val('');
            $('#cost_valx').val('');
            $('#sell_valx').val('');
            $('#vatx').val('');
            $('#totalx').val('');
            $('#notex').val('');
            $('#show_name_to').hide();
            $('#jenis_edit').val('');

            dsState = "Input";

            $("#detail-quote").find('.modal-title').text('Add Detail Quote');
            $("#detail-quote").modal('show',{backdrop: 'true'});
        }

        /*** Edit Detail Quote **/
         function editDetailCF(id,tipe){
            $.ajax({
                url: "{{ route('booking.booking_getDetailCharges') }}",
                type: "POST",
                data: {
                    id: id,
                },
                dataType: "html",
                success: function(result) {
                    let data = JSON.parse(result);
                    let cost_val = data.cost_val
                    let sell_val = data.sell_val
                    let subtotal = data.subtotal
                    cost_val = numberWithCommas(Number(cost_val));
                    sell_val = numberWithCommas(Number(sell_val));
                    subtotal = numberWithCommas(Number(subtotal));

                    $('#charge').val(data.t_mcharge_code_id).trigger('change');
                    $('#descx').val(data.desc);
                    $('#id_dtl_quote').val(data.id);
                    $('#ratex').val(Number(data.rate));
                    $('#currencyx').val(data.currency).trigger('change');
                    if(data.reimburse_flag == 1){
                        $('#reimburs').prop('checked',true);
                        $('#reimbursx').val(1);
                    }else{
                        $('#reimburs').prop('checked',false);
                        $('#reimbursx').val(0)
                    }
                    $('#costx').val(Number(data.cost));
                    $('#sellx').val(Number(data.sell));
                    $('#qtyx').val(data.qty);
                    $('#cost_valx').val(cost_val);
                    $('#sell_valx').val(sell_val);
                    $('#vatx').val(Number(data.vat));
                    $('#totalx').val(subtotal);
                    $('#notex').val(data.notes);
                    $('#jenis_edit').val(tipe);
                    if(tipe=='cost' && data.paid_to_id!= null){
                        $('#show_name_to').show();
                        $('#name_to_text').text('Paid To');
                        $('#name_to').val(data.paid_to_id).trigger('change');
                    }else if(tipe=='sell' && data.bill_to_id!= null){
                        $('#show_name_to').show();
                        $('#name_to_text').text('Bill To');
                        $('#name_to').val(data.bill_to_id).trigger('change');
                    }else{
                        $('#show_name_to').hide();
                    }

                    dsState = "Edit";

                    $("#detail-quote").find('.modal-title').text('Edit Detail Quote');
                    $("#detail-quote").modal('show',{backdrop: 'true'});

                }
            });
        }

        /** Save Detail Quote **/
         function saveDetailxxx(){

            if($.trim($("#charge").val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Charge!'
                });
                $('#detail_quote_submit').prop('disabled', false);
            }else if($.trim($("#currencyx").val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please Select Currency!'
                });
                $('#detail_quote_submit').prop('disabled', false);
            }else if($.trim($("#ratex").val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input Rate!'
                });
                $('#detail_quote_submit').prop('disabled', false);
            }else if($.trim($("#costx").val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input Cost!'
                });
                $('#detail_quote_submit').prop('disabled', false);
            }else if($.trim($("#sellx").val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input Sell!'
                });
                $('#detail_quote_submit').prop('disabled', false);
            }else if($.trim($("#qtyx").val()) == ""){
                Toast.fire({
                    icon: 'error',
                    title: 'Please input Qty!'
                });
                $('#detail_quote_submit').prop('disabled', false);
            }else{
                if(dsState == "Input")
                {
                    $.ajax({
                        type:"POST",
                        url:"{{ route('booking.bcharges_addDetail') }}",
                        data:{
                            booking_id:{{ $booking->id }},
                            quote:{{ ($booking->t_quote_id)? $booking->t_quote_id:0 }},
                            quote_no : $('#quote_no').val(),
                            charge:$('#charge').val(),
                            desc:$('#descx').val(),
                            reimburs:$('#reimbursx').val(),
                            currency:$('#currencyx').val(),
                            rate:$('#ratex').val(),
                            cost:$('#costx').val(),
                            sell:$('#sellx').val(),
                            qty:$('#qtyx').val(),
                            cost_val:$('#cost_valx').val(),
                            sell_val:$('#sell_valx').val(),
                            vat:$('#vatx').val(),
                            total:$('#totalx').val(),
                            note:$('#notex').val()
                        },
                        success:function(result){
                            $('#detail-quote').modal('hide')
                            $('#detail_quote_submit').prop('disabled', false);
                            loadSellCost({{ $booking->id }});
                            Toast.fire({
                                icon: 'success',
                                title: 'Sukses Add Data!'
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#detail_quote_submit').prop('disabled', false);
                            alert('Gagal menambahkan item!');
                        },
                    });
                }else{
                    $.ajax({
                        type:"POST",
                        url:"{{ route('booking.bcharges_updateDetail') }}",
                        data:{
                            id:$('#id_dtl_quote').val(),
                            jenis_edit:$('#jenis_edit').val(),
                            id_booking:{{$booking->id}},
                            charge:$('#charge').val(),
                            desc:$('#descx').val(),
                            reimburs:$('#reimbursx').val(),
                            currency:$('#currencyx').val(),
                            rate:$('#ratex').val(),
                            cost:$('#costx').val(),
                            sell:$('#sellx').val(),
                            qty:$('#qtyx').val(),
                            cost_val:$('#cost_valx').val(),
                            sell_val:$('#sell_valx').val(),
                            vat:$('#vatx').val(),
                            total:$('#totalx').val(),
                            note:$('#notex').val(),
                            name_to:$('#name_to').val(),
                            quote:{{ ($booking->t_quote_id)? $booking->t_quote_id:0 }}
                        },
                        success:function(result){
                            $('#detail_quote_submit').prop('disabled', false);
                            $('#detail-quote').modal('hide');
                            loadSellCost({{ $booking->id }});
                            Toast.fire({
                                icon: 'success',
                                title: 'Sukses Update Data!'
                            });
                        },error: function (xhr, ajaxOptions, thrownError) {
                            $('#detail_quote_submit').prop('disabled', false);
                            alert('Gagal Mengupdate!');
                        },
                    });
                }
            }
        }

        function get_rate(val)
        {
            $.ajax({
                type:"POST",
                url:"{{ route('quotation.quote_getCurrencyCode') }}",
                data:{
                    id : val
                },
                success:function(result){
                    let text = JSON.parse(result)
                    let code = text.code

                    if(code == 'IDR' && $('#ratex').val() == ''){
                        $('#ratex').val(1);
                    }
                }
            });
        }
        function hitungx()
        {
            let nilai1 = $('#ratex').val()*$('#costx').val();
            let nilai2 = $('#ratex').val()*$('#sellx').val();

            /** Menghitung Cost Value **/
            let cost_val = Number(nilai1)*Number($('#qtyx').val());
            cost_val = cost_val.toFixed(2)
            cost_val = numberWithCommas(Number(cost_val));

            /** Menghitung Cost Value **/
            let sell_val = Number(nilai2)*Number($('#qtyx').val());
            sell_val = sell_val.toFixed(2)
            sell_val = numberWithCommas(Number(sell_val));


            $('#cost_valx').val(cost_val);
            $('#sell_valx').val(sell_val);
            hitungTotalx();

        }

        /** Hitung Total Detail Quote **/
        function hitungTotalx()
        {
            let sellVal = $('#sell_valx').val();
            sellVal = sellVal.replace(/,/g, '')
            const cost = $('#qtyx').val()*sellVal;
            let total = Number(cost)+Number($('#vatx').val());
            total = total.toFixed(2)
            total = numberWithCommas(Number(total));
            $('#totalx').val(total);
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function get_customer(val)
        {
            $.ajax({
                url: "{{ route('get.customer') }}",
                type: "POST",
                data : "company_id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    $("#customer_add").html(final);
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
                        let legal = final[2].legal_doc_flag;

                        $("#customer_addr").html(final[0]);
                        $("#customer_pic").html(final[1]);

                        if(legal == 1){
                            $('#legalDoc').prop('checked', true);
                        }else{
                            $('#legalDoc').prop('checked', false);
                        }
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

        function get_exchange_rate(val)
        {
            $.ajax({
                type:"POST",
                url:"{{ route('quotation.quote_getCurrencyCode') }}",
                data:{
                    id : val
                },
                success:function(result){
                    let text = JSON.parse(result)
                    let code = text.code

                    if(code == 'IDR'){
                        $('#exchange_rate').val(1);
                        //$('#ratex').val(1);
                    }
                }
            });
        }

        function print_hbl(id)
        {
            $('#original_hbl').val('');
            $('#copy_non_nego_hbl').val('');
            $("#HBLMODAL").find('.modal-title').text('Print HBL');
            $('#hbl_print_id').val(id)
            $("#HBLMODAL").modal('show',{backdrop: 'true'});
        }

        function cetak_hbl()
        {
            let id = $('#hbl_print_id').val();
            let original_hbl = $('#original_hbl').val();
            let copy_non_nego_hbl = $('#copy_non_nego_hbl').val();

            //window.open('http://www.smkproduction.eu5.org', '_blank');

            var anchor = document.createElement('a');
            anchor.href = `{{ url('booking/cetak_hbl/${id}/${original_hbl}/${copy_non_nego_hbl}') }}`;
            anchor.target="_blank";
            anchor.click();

            $("#HBLMODAL").modal('hide');


            // $.ajax({
            //     type: "POST",
            //     url: "}",
            //     dataType: 'json',
            //     data : {
            //         id : id,
            //         original_hbl : original_hbl,
            //         copy_non_nego_hbl : copy_non_nego_hbl
            //     },
            //     success: function (result){
            //         $("#HBLMODAL").modal('hide');
            //         loadRoadCons({{ Request::segment(3) }});
            //         Toast.fire({
            //             icon: 'success',
            //             title: 'Print...!'
            //         });
            //     }
            // });
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
            $('.spinner_load_cons').show();
            $.ajax({
                type:"POST",
                url:"{{ route('booking.loadRoadCons') }}",
                data:{
                    id:id,
                    flag_invoice: {{$booking->flag_invoice}}
                },
                dataType:"html",
                success:function(result){
                    $('.spinner_load_cons').hide();
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
                data:{
                    id:id,
                    flag_invoice: {{$booking->flag_invoice}}
                },
                dataType:"html",
                success:function(result){
                    var tabel = JSON.parse(result);
                    $('#tblSchedule').html(tabel);
                }
            })
        }

        /** Load Schedule **/
        function loadSellCost(id){
            $('.spinner_load').show();
            if(id != null)
            {
                $.ajax({
                    type:"POST",
                    url:"{{ route('booking.loadSellCost') }}",
                    data:{
                        id : id
                    },
                    dataType:"html",
                    success:function(result){
                        var tabel = JSON.parse(result);
                        $('.spinner_load').hide();
                        $('#tblCost').html(tabel[0]);
                        $('#tblSell').html(tabel[1]);
                        $('#tblProfit').html(tabel[2]);
                        for (let i = 0; i < tabel[3]; i++) {
                          $('#paid_to_'+i).select2();
                          $('#bill_to_'+i).select2();
                        }
                    }
                })
            }
        }

        function loadProfit(id){
            if(id != null && id != 0){
                $.ajax({
                    type:"POST",
                    url:"{{ route('quotation.quote_loadProfit') }}",
                    data:{
                        id: id
                    },
                    dataType:"html",
                    success:function(result){
                        var tabel = JSON.parse(result);
                        //$('#tblProfit').html(tabel);
                    }
                })
            }
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

        /** Hapus Detail Charges And Fee **/
        function hapusDetailCF(id){
            var r=confirm("Anda yakin menghapus data ini?");
            if (r==true){
                $.ajax({
                    type:"POST",
                    url:"{{ route('booking.deleteCF') }}",
                    data:"id="+ id,
                    success:function(result){
                        loadSellCost({{ $booking->id }});
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
                data:{
                    id:id,
                    flag_invoice: {{$booking->flag_invoice}}
                },
                dataType:"html",
                success:function(result){
                    var tabel = JSON.parse(result);
                    $('#tblCommodity').html(tabel[0]);
                    $('#total_commo').val(tabel[1]);
                }
            })
        }

        /** Load Packages **/
        function loadPackages(id){
            $.ajax({
                type:"POST",
                url:"{{ route('booking.loadPackages') }}",
                data:{
                    id:id,
                    flag_invoice: {{$booking->flag_invoice}}
                },
                dataType:"html",
                success:function(result){
                    var tabel = JSON.parse(result);
                    $('#tblPackages').html(tabel[0]);
                    $('#total_package').val(tabel[1]);
                }
            })
        }

        /** Load Container **/
        function loadContainer(id){
            $.ajax({
                type:"POST",
                url:"{{ route('booking.loadContainer') }}",
                data:{
                    id:id,
                    flag_invoice: {{$booking->flag_invoice}}
                },
                dataType:"html",
                success:function(result){
                    var tabel = JSON.parse(result);
                    $('#tblContainer').html(tabel[0]);
                    $('#total_container').val(tabel[1])
                }
            })
        }

        /** Load Document **/
        function loadDoc(id){
            $.ajax({
                type:"POST",
                url:"{{ route('booking.loadDoc') }}",
                data:{
                    id:id,
                    flag_invoice: {{$booking->flag_invoice}}
                },
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
                    $('#lbl_vgm_uom_'+id).hide();
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
                    booking:{{ $booking->id }},
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
                    booking:{{ $booking->id }},
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
                    booking:{{ $booking->id }},
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
                    booking:{{ $booking->id }},
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
                }else{
                    $(this).prop('disabled', false).text('Please Wait ...');
                    $('#formku').submit();
                }
            }

        }

        /** Update Package **/
        function updateDetailSell(id_detail, id, v)
        {
            // console.log($('#paid_to_id_'+id).val());
            $.ajax({
                type:"POST",
                url:"{{ route('booking.updateSell') }}",
                data:{
                    id:id_detail,
                    bill_to_name:$('#bill_to_name_'+id).val(),
                    bill_to_id:$('#bill_to_id_'+id).val(),
                    paid_to_name:$('#paid_to_name_'+id).val(),
                    paid_to_id:$('#paid_to_id_'+id).val(),
                    v : v
                },
                success:function(result){
                    loadSellCost({{ $booking->id }})
                    Toast.fire({
                        icon: 'success',
                        title: 'Sukses Update Data!'
                    });
                },error: function (xhr, ajaxOptions, thrownError) {
                    alert('Gagal Mengupdate data!');
                },
            });
        }

        function updateDetailSellshp(id_detail, id, v)
        {
            // console.log($('#paid_to_id_'+id).val());
            $.ajax({
                type:"POST",
                url:"{{ route('booking.updateSellshp') }}",
                data:{
                    id:id_detail,
                    bill_to_name:$('#bill_to_name_'+id).val(),
                    bill_to_id:$('#bill_to_id_'+id).val(),
                    paid_to_name:$('#paid_to_name_'+id).val(),
                    paid_to_id:$('#paid_to_id_'+id).val(),
                    v : v
                },
                success:function(result){
                    loadSellCost({{ $booking->id }})
                    Toast.fire({
                        icon: 'success',
                        title: 'Sukses Update Data!'
                    });
                },error: function (xhr, ajaxOptions, thrownError) {
                    alert('Gagal Mengupdate data!');
                },
            });
        }

        function redirectToCostInvoice() {
            if ($("[id^='cek_paid_to_']:checked").length == 0){
                Swal.fire({
                    title: 'Error!',
                    text: 'Harap pilih Item Cost',
                    icon: 'error'
                })
            }else{
                $('#fCost').attr('action', `{{ route('invoice.create_cost') }}`);
                $('#fCost').submit();
            }
        }

        function redirectToProformaInvoice() {
            if ($("[id^='cek_bill_to_']:checked").length == 0){
                Swal.fire({
                    title: 'Error!',
                    text: 'Harap pilih Item Sell',
                    icon: 'error'
                })
            }else{
                $('#fSell').attr('action', `{{ route('invoice.create') }}`);
                $('#fSell').submit();
            }
        }

        function checkedPaidTo(key) {
            id = $('#cek_paid_to_'+key);
            id.prop('checked', !id.prop('checked'));
        }

        function checkedBillTo(key) {
            id = $('#cek_bill_to_'+key);
            id.prop('checked', !id.prop('checked'));
        }

        function fillBillToName(no) {
            text = $('#bill_to_'+no).val();
            arr = text.split("-");
            $('#bill_to_name_'+no).val(arr[1]);
            $('#bill_to_id_'+no).val(arr[0]);
        }

        function fillPaidToName(no) {
            text = $('#paid_to_'+no).val();
            arr = text.split("-");
            $('#paid_to_name_'+no).val(arr[1]);
            $('#paid_to_id_'+no).val(arr[0]);
        }

        function showErrorMsg(msg) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '{!! $errorMsg !!}',
            })
        }

        function showSuccessMsg(msg) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                html: '{!! $successMsg !!}',
            })
        }

        $(function() {
            get_customer({{ $booking->client_id }});
            client_detail({{ $booking->client_id }});

            get_shipper({{ $booking->shipper_id }});
            shipper_detail({{ $booking->shipper_id }})

            get_consignee({{ $booking->consignee_id }})
            consignee_detail({{ $booking->consignee_id }})

            get_notParty({{ $booking->not_party_id }})
            not_detail({{ $booking->not_party_id }})

            get_agent({{ $booking->agent_id }})
            agent_detail({{ $booking->agent_id }})

            get_shipline({{ $booking->shipping_line_id }})
            shipline_detail({{ $booking->shipping_line_id }})

            get_vendor({{ $booking->vendor_id }})
            vendor_detail({{ $booking->vendor_id }})

            loadCommodity({{ Request::segment(3) }});
            loadPackages({{ Request::segment(3) }});
            loadContainer({{ Request::segment(3) }});
            loadDoc({{ Request::segment(3) }});
            loadRoadCons({{ Request::segment(3) }});
            loadSchedule({{ Request::segment(3) }});
            loadSellCost({{ $booking->id }})
            loadProfit({{ $booking->t_quote_id }})

            if ({{ $error }} == 1) showErrorMsg('{{ $errorMsg }}');
            if ({{ $success }} == 1) showSuccessMsg('{{ $successMsg }}');
        });
    </script>
@endpush
@endsection
