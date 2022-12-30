<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SHIPPING INTRUCTION LCL</title>
    <style>
        .text-container{
            padding-left: 20px;
            margin-top: 10px;
        }

        .text-container p {
            margin: 0px;
        }

        .nama-pt {
            font-size: 14px;
        }

        .alamat {
            font-size: 10px;
        }

        .isi{
            height: 80px;
        }

        .isi-SI {
            height : 120px;
        }

        .isi-booking {
            height : 75px;
        }

        .isi-notify{
            height: 60px;
        }

        .isi-place {
            height : 25px;
        }

        .isi-voy {
            height: 40px;
        }

    </style>
</head>
<body style="border: 1 solid #000">
    <table width="100%">
        <tr>
            <td width="50%">
                <img src="{{ public_path('admin/dist/img/DMC.jpg') }}" width="60" height="50" style="margin-left: 90px;">
            </td>
            <td width="50%">
                <div class="text-container">
                    <p class="nama-pt">PT. DELTA MARINE CONTINENTS</p>
                    <p class="alamat">RUKAN SENTRA NIAGA BLOK B NO. 3 </p>
                    <p class="alamat">JL. GREEN LAKE CITY BOULEVARD</p>
                    <p class="alamat">DURI KOSAMBI, JAKARTA BARAT 11750</p>
                    <p class="alamat">TEL : +62 21 5437-6387 FAX: +62 21 5437-6387</p>
                    <p class="alamat">Website : www.delta-dmc.com </p>
                </div>
            </td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td width="45%" style="border-top: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;" height="15"></td>
            <td width="35%" style="border-top: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;background-color: #a9a9a9a9;text-align:center;font-size:10px;">SHIPPING INTRUCTION</td>
            <td width="20%" style="border-top: 1px solid #000;border-bottom: 1px solid #000;color:red;text-align:center;font-size:12px;"> @if ($data->final_flag == 1)
                FINAL SI    
            @endif
            </td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td width="50%" style="border-right: 1px solid #000">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="font-size: 8pt;vertical-align:top;padding-left:2px;border-bottom:1px solid #000;">
                            <b>SHIPPER</b>
                            <div class="isi">
                                {{-- @if ($data->hbl_shipper !== null) --}}
                                @if($data->si_data>0)
                                    <?=nl2br($data->hbl_shipper);?>
                                @else
                                    <?=nl2br($data->mbl_shipper);?>
                                @endif
                                {{-- @else
                                    {{ $data->company_f }}<br>
                                    {{ $data->address_f }}<br>
                                    {{ $data->pic_f }}
                                @endif --}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 8pt;vertical-align:top;padding-left:2px;border-bottom:1px solid #000;">
                            <b>CONSIGNEE (NAME & ADDRESS)</b>
                            <div class="isi">
                                @if($data->si_data>0)
                                    <?=nl2br($data->hbl_consignee);?>
                                @else
                                    <?=nl2br($data->mbl_consignee);?>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 8pt;vertical-align:top;padding-left:2px;border-bottom:1px solid #000;">
                            <b>NOTIFY (NAME & ADDRESS)</b>
                            <div class="isi-notify">
                                @if($data->si_data>0)
                                    <?=nl2br($data->hbl_not_party);?>
                                @else
                                    <?=nl2br($data->mbl_not_party);?>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="60%" style="font-size: 8pt;border-bottom:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;">
    
                                    </td>
                                    <td width="40%" style="font-size: 7pt;border-bottom:1px solid #000;text-align:center;border-top:1px solid #000;">
                                        <b>PLACE OF RECEIPT OF GOODS*<br>(IF CONTRACTED FOR)</b>
                                        <br>
                                        <br>
                                        <div class="isi-place" style="font-size:9pt;">
                                            
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="60%" style="font-size: 8pt;border-bottom:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="60%" style="font-size: 7pt;text-align:center;">
                                                    <b>LOADING VESSEL*</b>
                                                </td>
                                                <td width="40%" style="font-size: 7pt;text-align:center;">
                                                    <b>VOY</b>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="40%" style="font-size: 7pt;border-bottom:1px solid #000;text-align:center;border-top:1px solid #000;">
                                        <b>PORT OF LOADING</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="60%" style="font-size: 8pt;border-bottom:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;" height="20">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="60%" style="font-size: 7pt;text-align:center;">
                                                   <b>
                                                    @php
                                                    if($op2==1){
                                                        echo $data->name_carrier;
                                                    }elseif($op2==2){
                                                        echo $data->name_carrier_2;
                                                    }elseif ($op2==3) {
                                                        echo $data->name_carrier_3;
                                                    }
                                                    @endphp
                                                   </b>
                                                </td>
                                                <td width="40%" style="font-size: 7pt;text-align:center;">
                                                    <b>
                                                    @php
                                                    if($op2==1){
                                                        echo $data->flight_number;
                                                    }elseif($op2==2){
                                                        echo $data->flight_number_2;
                                                    }elseif ($op2==3) {
                                                        echo $data->flight_number_3;
                                                    }
                                                    @endphp
                                                    </b>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="40%" style="font-size: 8pt;border-bottom:1px solid #000;text-align:center;border-top:1px solid #000;">
                                        <b>{{ $data->port1 }}</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="60%" style="font-size: 8pt;border-bottom:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="60%" style="font-size: 7pt;text-align:center;">
                                                    <b>OCEAN VESSEL*</b>
                                                </td>
                                                <td width="40%" style="font-size: 7pt;text-align:center;">
                                                    <b>VOY</b>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="40%" style="font-size: 7pt;border-bottom:1px solid #000;text-align:center;border-top:1px solid #000;">
                                        <b>PORT OF DISCHARGE</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="60%" style="font-size: 8pt;border-bottom:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;" height="20">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="60%" style="font-size: 7pt;text-align:center;">
                                                   <b></b>
                                                </td>
                                                <td width="40%" style="font-size: 7pt;text-align:center;">
                                                    <b></b>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="40%" style="font-size: 8pt;border-bottom:1px solid #000;text-align:center;border-top:1px solid #000;">
                                        <b>{{ $data->port3 }}</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="60%" style="font-size: 7pt;border-bottom:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;text-align:center;">
                                        <b>PLACE OF DELIVERY</b>
                                    </td>
                                    <td width="40%" style="font-size: 7pt;border-bottom:1px solid #000;text-align:center;border-top:1px solid #000;">
                                        <b>FINAL DESTINATION</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="60%" style="font-size: 8pt;border-bottom:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;" height="20">
                                        <b>{{ $data->place_origin }}</b>
                                    </td>
                                    <td width="40%" style="font-size: 8pt;border-bottom:1px solid #000;text-align:center;border-top:1px solid #000;">
                                        <b>{{ $data->place_destination }}</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="font-size: 8pt;vertical-align:top;padding-left:2px;border-bottom:1px solid #000;">
                            <div class="isi-SI">
                                <b>SI NO :</b>   <br/><br/>
                                <b>DATE :</b>      <br/><br/>
                                <b>TO :</b>      {{ $data->company_o }}  <br/><br/>
                                <b>ATTN :</b>    {{ $data->pic_o }}  <br/><br/>
                                <b>FROM :</b>   {{ $data->updated_by }}     <br/><br/>
                                
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 8pt;vertical-align:top;padding-left:2px;border-bottom:1px solid #000;">
                            <div class="isi-booking">
                                <b>BOOKING NO :</b> 
                                    {{-- @if ($data->final_flag == 1) --}}
                                    {{ $data->booking_no }}
                                    {{-- @endif --}}
                                <br/><br/>
                                <b>PEB No. :</b> {{ $data->custom_doc_no }} <br/><br/>
                                <b>PEB Date :</b> {{ $data->custom_doc_date }} <br/><br/>                                
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 8pt;vertical-align:top;padding-left:2px;border-bottom:1px solid #000;">
                            <b>ALSO NOTIFY PARTY (NAME & ADDRESS)</b>
                            <div class="isi-notify">
                                    @if($op1==0)
                                        <?=nl2br($data->mbl_also_notify_party);?>
                                    @else
                                        <?=nl2br($data->hbl_also_notify_party);?>
                                    @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom:1px solid #000;text-align:center;" height="53">
                            <div class="isi-place" style="font-size:9pt;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" style="font-size: 7pt;border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">
                                        <b>DEPARTURE DATE</b>
                                    </td>
                                    <td width="50%" style="font-size: 7pt;border-bottom:1px solid #000;text-align:center;">
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" style="font-size: 9pt;border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;" height="20.5">
                                        <b>{{ \Carbon\Carbon::parse($data->etd_date)->format('d-M-Y') }}</b>
                                    </td>
                                    <td width="50%" style="font-size: 7pt;border-bottom:1px solid #000;text-align:center;">
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" style="font-size: 7pt;border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">
                                        
                                    </td>
                                    <td width="50%" style="font-size: 7pt;border-bottom:1px solid #000;text-align:center;">
                                        <b>ETA</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" style="font-size: 7pt;border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;" height="20.5">
                                        
                                    </td>
                                    <td width="50%" style="font-size: 9pt;border-bottom:1px solid #000;text-align:center;">
                                        <b>{{ \Carbon\Carbon::parse($data->eta_date)->format('d-M-Y') }}</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size: 7pt;border-bottom:1px solid #000;text-align:center;">
                                        &nbsp;
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <tr>
                                <td width="50%" style="font-size: 7pt;border-bottom:1px solid #000;text-align:center;" height="15">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" style="font-size: 7pt;border-bottom:1px solid #000;text-align:center;" height="14.5">
                                    
                                </td>
                            </tr>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td width="30%" style="border-right: 1px solid #000;border-bottom: 1px solid #000; font-size:7pt;text-align:center;">
                <b>MARKS & NOS/ CONT.NOS</b>
            </td>
            <td width="40%" style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size:7pt;text-align:center;">
                <b>DESCRIPTION OF GOODS</b>
            </td>
            <td width="15%" style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size:7pt;text-align:center;">
                <b>WEIGHT</b>
            </td>
            <td width="15%" style="border-bottom: 1px solid #000;font-size:7pt;text-align:center;">
                <b>MEASUREMENT</b>
            </td>
        </tr>
        <tr>
            <td width="30%" style="border-right: 1px solid #000;font-size:7pt;text-align:center;" height="100">
                {{ $data->mbl_marks_nos }}
            </td>
            <td width="40%" style="border-right: 1px solid #000;font-size:9pt;padding-left:2px;vertical-align:top;">
                {!! $comm[0]->desc !!}
            </td>
            <td width="15%" style="border-right: 1px solid #000;font-size:7pt;text-align:center;" height="100">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="border-bottom: 1px solid #000;font-size:7pt;text-align:center;" height="30"></td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #000;font-size:7pt;text-align:center;" height="20">
                            <b>NW : {{ $comm[0]->netto.' '.$comm[0]->code_d}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #000;font-size:7pt;text-align:center;" height="50">
                            
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #000;font-size:7pt;text-align:center;" height="20">
                            <b>GW : {{ $comm[0]->weight.' '.$comm[0]->code_d }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size:7pt;text-align:center;" height="20">
                            <b></b>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="15%" style="font-size:7pt;text-align:center;">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="border-bottom: 1px solid #000;font-size:7pt;text-align:center;" height="100.2"></td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #000;font-size:7pt;text-align:center;" height="20">
                            <b>MEAS : {{ $comm[0]->volume.' '.$comm[0]->code_e }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size:7pt;text-align:center;" height="20">
                            <b></b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="70%" colspan="2" style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size:7pt;vertical-align:top;margin-left:2px;" height="60">
                <b><u>CONTAINER/SEAL/GW/NO.OF PACKAGE (BREAKDOWN)</u></b><br>
                {{-- @if ($data->final_flag == 1) --}}
                @foreach($cont as $ct)
                <p style="font-size: 10px;padding-left:3px;color: blue">{{ $ct->container_no.' / '.$ct->seal_no.' / '.$ct->weight.' '.$ct->code_weight.' / '.$ct->qty.' '.$ct->code_qty.' / '.$ct->volume.' '.$ct->volume_code.' / '.$ct->container_type }}</p><br>
                @endforeach
                {{-- @endif --}}
            </td>
            <td width="15%" style="border-right: 1px solid #000;border-bottom: 1px solid #000;font-size:7pt;padding-left:2px;" height="40">
                <b></b>
            </td>
            <td width="15%" style="border-bottom: 1px solid #000;font-size:7pt;padding-left:2px;" height="40">
                <b></b>
            </td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td style="border-bottom: 1px solid #000;font-size:7pt;padding-left:2px;" height="50">
                <b>STUFFING DATE :</b> {{ \Carbon\Carbon::parse($data->stuffing_date)->format('d-M-Y') }} <br><br>
                <b>FREIGHT :</b> {{ $data->charge_name }}
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="font-size: 7pt;margin-left:2px;">
                <b>NOTE :</b>
            </td>
        </tr>
        <tr>
            <td style="font-size: 14pt;margin-left:2px;">
               {!! $data->remarks !!}
            </td>
        </tr>
    </table>
</body>
</html>