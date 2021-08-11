@extends('layouts.master')


@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Quotation</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('quotation.list') }}">List Quote</a></li>
                    <li class="breadcrumb-item active">Add Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <!-- left column -->
            <div class="col-md-12">
          <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form</h3>
                </div>
                @if(count($errors)>0)
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>  		
                    @endforeach
                @endif
            <!-- /.card-header -->
            <!-- form start -->
            @if ($version == '')
              <?php $v = 1; ?>
            @else
              <?php $v = $version + 1; ?>
            @endif
                <form action="{{ route('quotation.quote_doAdd') }}" class="eventInsForm" method="post" target="_self" name="formku" id="formku" action=""> 
                {{ csrf_field() }}   
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Quote Number</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="quote_no" id="quote_no" placeholder="Quote No ...">
                                </div>
                            </div>
                            <div class="row mb-3 mt-3">
                                <div class="col-md-4">
                                    <label>Version</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="version" id="version" placeholder="Version ..." value="{{ $v }}" onkeyup="numberOnly(this);" readonly>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <input type="checkbox" name="final" id="final" style="margin-right: 5px"><label> FINAL</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Date</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="date" id="datex" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                                <div class="col-md-6">
                                    <select class="form-control select2bs44" style="width: 100%;" name="customer" id="customer" onchange="get_pic(this.value)">
                                        {{-- <option value="" selected>-- Select Customer --</option>
                                        @foreach ($company as $c)
                                        <option value="{{ $c->id }}">{{ $c->client_name }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-md-2 mt-1">
                                    <a href="{{ url('master/company_add') }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Activity</label>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control select2bs44" style="width: 100%;margin-bottom:5px;" name="activity" id="activity">
                                        <option value="" selected>-- Select Activity --</option>
                                        <option value="export">EXPORT</option>
                                        <option value="import">IMPORT</option>
                                        <option value="domestic">DOMESTIC</option>
                                    </select>
                                </div>
                                <div class="col-md-4" style="padding: 10px">
                                    @foreach ($loaded as $l)
                                    <input type="radio" name="loaded" id="loaded" value="{{ $l->id }}">
                                    <label>{{ $l->loaded_type }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>From</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" list="fromx" class="form-control" name="from" id="from" placeholder="From ...">
                                    <datalist id="fromx">
                                    </datalist>
                                    <input type="hidden" name="from_id" id="from_id">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Commodity</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="commodity" id="commodity" placeholder="Commodity ...">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>PIC</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control select2bs44" name="pic" id="pic" style="width: 100%;">
                                    <option>-- Select Customer First --</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-1">
                                <a href="{{ url('master/company_add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Shipment By</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control select2bs44" name="shipment" id="shipment" style="width: 100%;" onchange="get_fromto(this.value)">
                                    <option selected>-- Select Shipment --</option>
                                    <option value="SEA">SEA</option>
                                    <option value="AIR">AIR</option>
                                    <option value="LAND">LAND</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Terms</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control select2bs44" name="terms" id="terms" style="width: 100%;">
                                    <option selected>-- Select Incoterms --</option>
                                    @foreach ($inco as $i)
                                    <option value="{{ $i->id }}">{{ $i->incoterns_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>To</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" list="tox" class="form-control" name="to" id="to" placeholder="To ...">
                                <datalist id="tox">
                                </datalist>
                                <input type="hidden" name="to_id" id="to_id">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Pieces</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="pieces" id="pieces" onkeyup="numberOnly(this);" placeholder="Pieces ...">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Weight</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="weight" id="weight" onkeyup="numberOnly(this);" placeholder="Weight ...">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control select2bs44" name="uom_weight" id="uom_weight" style="width: 100%;">
                                    <option selected>-- Select UOM --</option>
                                @foreach ($uom as $u)
                                    <option value="{{ $u->id }}">{{ $u->uom_code }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Volume</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="volume" id="volume" onkeyup="numberOnly(this);" placeholder="Volume ...">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control select2bs44" name="uom_volume" id="uom_volume" style="width: 100%;">
                                    <option selected>-- Select UOM --</option>
                                @foreach ($uom as $u)
                                    <option value="{{ $u->id }}">{{ $u->uom_code }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="hazard">
                                    <label for="customCheckbox1" class="custom-control-label">Is Hazardous</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="hazard_txt" placeholder="Material Information .....">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="">Additional Information</label>
                            </div>
                            <div class="col-md 10">
                                <textarea class="form-control" rows="5" name="additional" placeholder="Additional Information ..."></textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="customCheckbox2" name="delivery">
                                    <label for="customCheckbox2" class="custom-control-label">Need Pickup/ Delivery</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="customCheckbox3" name="custom">
                                    <label for="customCheckbox3" class="custom-control-label">Need Custom Clearance</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="customCheckbox4" name="fumigation">
                                    <label for="customCheckbox4" class="custom-control-label">Fumigation Required</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="customCheckbox5" name="goods">
                                    <label for="customCheckbox5" class="custom-control-label">Goods are Stackable</label>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" class="btn btn-primary float-right" id="saveData"><i class="fa fa-paper-plane"></i> Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
  @push('after-scripts')

  <script>

    //Refresh Otomatis
    $(document).ready(() => {
        get_customer();

    });


    function get_pic(val){
        if(val!= ''){
            $.ajax({
                url: "{{ route('get.pic') }}",
                type: "POST",
                data: "id="+val,
                dataType: "html",
                success: function(result) {
                    var final = JSON.parse(result);
                    
                    $("#pic").html(final);
                }
            });
        }
    }

    function get_customer()
    {
        $.ajax({
            url: "{{ route('get.customer') }}",
            type: "GET",
            dataType: "html",
            success: function(result) {
                var final = JSON.parse(result);
                $("#customer").html(final)
            }
        })
    }


    $(function() {
      $('input[name=from]').on('input',function() {
        var selectedOption = $('option[value="'+$(this).val()+'"]');
        console.log(selectedOption.length ? selectedOption.attr('id') : 'This option is not in the list!');
        var id = selectedOption.attr('id');
        $('#from_id').val(id)
      });
    });

    $(function() {
      $('input[name=to]').on('input',function() {
        var selectedOption = $('option[value="'+$(this).val()+'"]');
        console.log(selectedOption.length ? selectedOption.attr('id') : 'This option is not in the list!');
        var id = selectedOption.attr('id');
        $('#to_id').val(id)
      });
    });

    function numberOnly(root){
        var reet = root.value;    
        var arr1=reet.length;      
        var ruut = reet.charAt(arr1-1);   
            if (reet.length > 0){   
                    var regex = /[0-9]|\./;   
                if (!ruut.match(regex)){   
                    var reet = reet.slice(0, -1);   
                    $(root).val(reet);   
                }   
            }  
    }

    function get_fromto(val)
    {
        if(val!= ''){
            $.ajax({
                url: "{{ route('get.port') }}",
                type: "POST",
                data: "type="+val,
                dataType: "html",
                success: function(result) {
                    var port = JSON.parse(result);
                    $("#fromx").html(port);
                    $("#tox").html(port);
                }
            });
        }
    }

    $("#saveData").click(function(){
        if($.trim($("#quote_no").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Quote Number',
                icon: 'error'
            })
        }else if($.trim($("#datex").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Date',
                icon: 'error'
            })
        }else if($.trim($("#customer").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Customer',
                icon: 'error'
            })
        }else if($.trim($("#activity").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Select Activity',
                icon: 'error'
            })
        }else if($.trim($("#loaded").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Choose One Loaded Type',
                icon: 'error'
            })
        }else if($.trim($("#from").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input From',
                icon: 'error'
            })
        }else if($.trim($("#commodity").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Commodity',
                icon: 'error'
            })
        }else if($.trim($("#pic").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select PIC',
                icon: 'error'
            })
        }else if($.trim($("#pic").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select PIC',
                icon: 'error'
            })
        }else if($.trim($("#shipment").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Shipment',
                icon: 'error'
            })
        }else if($.trim($("#terms").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select Incoterms',
                icon: 'error'
            })
        }else if($.trim($("#to").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please Input To',
                icon: 'error'
            })
        }else if($.trim($("#pieces").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Pieces',
                icon: 'error'
            })
        }else if($.trim($("#weight").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Weight',
                icon: 'error'
            })
        }else if($.trim($("#uom_weight").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select UOM Weight',
                icon: 'error'
            })
        }else if($.trim($("#volume").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please input Volume',
                icon: 'error'
            })
        }else if($.trim($("#uom_volume").val()) == ""){
            Swal.fire({
                title: 'Error!',
                text: 'Please select UOM Volume',
                icon: 'error'
            })
        }else{
            $(this).prop('disabled', true).text('Please Wait ...');
            $('#formku').submit();
        }
    });
  </script>
      
  @endpush    
@endsection


