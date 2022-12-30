<html>
<head>
	<title>HBL</title>
    <style>
        html, body{
            margin-left: 16;
            margin-top : 20;
            margin-right: 19;
            margin-bottom: 0;
            padding: 0;
        }

        table tr td,
		table tr th{
			font-size: 7pt;
		}

        tr.noBorder td {
            border: 0;
        }

        .pabs {
            position: absolute;
        }

        #myTable{
            font-size: 7pt !important;
            text-align: center;
        }

        .border-noleft{
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            border-right: 1px solid #000;
        }

        .border-left{
            border-left: 1px solid #000;
        }

        .border-bottom{
            border-bottom: 1px solid #000;
        }

        .border-top{
            border-top: 1px solid #000;
        }

        .font-normal {
            padding-left: 3px;
            font-size: 8pt;
            vertical-align:top;
        }

        .font-normall {
            font-size: 8pt;
            padding-left:2px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<?php for($i = 0; $i < $origin; $i++){?>
    <table border="0" cellpadding="0" width="100%" height="100%" cellspacing="0" style="font-family:Helvetica;">
        <tr>
            <td colspan="2" class="border-noleft">
                <table border="0" cellpadding="0" width="100%" cellspacing="0" style="font-family:Helvetica;">
                    <tr>
                        <td colspan="2" class="font-normall" style="vertical-align: top; height: 12%;">
                            <b>Shipper/Exporter</b><br>
                            <span style="font-size: 10pt;">
                                <?php
                                    $hbl_shipper = preg_split('/\r\n|\r|\n/', $booking->hbl_shipper);
                                    $hbl_shipper_count = count($hbl_shipper);
                                    $loop = array_slice($hbl_shipper, 0, 5, true);
                                    if($hbl_shipper_count>5){
                                        foreach ($loop as $key => $value) {
                                            echo $value;
                                            if ($key != array_key_last($loop)) {
                                                echo '<br>';
                                            }
                                        }
                                        echo ' SH >';
                                    }else{
                                        echo nl2br($booking->hbl_shipper);
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="font-normal" style="height: 12%; border-top: 1px solid #000;">
                            <b>Consignee</b><br>
                            <span style="font-size: 10pt;">
                                <?php
                                    $hbl_consignee = preg_split('/\r\n|\r|\n/', $booking->hbl_consignee);
                                    $hbl_consignee_count = count($hbl_consignee);
                                    $loop = array_slice($hbl_consignee, 0, 5, true);
                                    if($hbl_consignee_count>5){
                                        foreach ($loop as $key => $value) {
                                            echo $value;
                                            if ($key != array_key_last($loop)) {
                                                echo '<br>';
                                            }
                                        }
                                        echo ' CN >';
                                    }else{
                                        echo nl2br($booking->hbl_consignee);
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="font-normal" style="height: 12%; border-top: 1px solid #000;">
                            <b>Notify Party</b><br>
                            <span style="font-size: 10pt;">
                                <?php
                                    $hbl_not_party = preg_split('/\r\n|\r|\n/', $booking->hbl_not_party);
                                    $hbl_not_party_count = count($hbl_not_party);
                                    $loop = array_slice($hbl_not_party, 0, 5, true);
                                    if($hbl_not_party_count>5){
                                        foreach ($loop as $key => $value) {
                                            echo $value;
                                            if ($key != array_key_last($loop)) {
                                                echo '<br>';
                                            }
                                        }
                                        echo ' NP1 >';
                                    }else{
                                        echo nl2br($booking->hbl_not_party);
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-normal border-top" width="50%" style="height: 5%">
                            <b style="font-size: 6pt;">PRE-CARRIAGE BY</b><br>
                            <?php if($op2 == 1) {
                                echo strtoupper($booking->name_carrier.' '.$booking->flight_number);
                            }elseif($op2 == 2){
                                echo strtoupper($booking->name_carrier_2.' '.$booking->flight_number_2);
                            }elseif($op2 == 3){
                                echo strtoupper($booking->name_carrier_3.' '.$booking->flight_number_3);
                            }?>
                        </td>
                        <td class="font-normal border-left border-top" width="50%" style="height: 5%">
                            <b style="font-size: 6pt;">PLACE OF RECEIPT</b><br>
                            <span><?=strtoupper($booking->place_origin);?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-normal border-top" width="50%" style="height: 5%">
                            <b style="font-size: 6pt;">OCEAN VESSEL VOYAGE NO.</b><br>
                            <span>
                            <?php if($op3 == 1) {
                                echo strtoupper($booking->name_carrier.' '.$booking->flight_number);
                            }elseif($op3 == 2){
                                echo strtoupper($booking->name_carrier_2.' '.$booking->flight_number_2);
                            }elseif($op3 == 3){
                                echo strtoupper($booking->name_carrier_3.' '.$booking->flight_number_3);
                            }?>
                            </span>
                        </td>
                        <td class="font-normal border-left border-top" width="50%" style="height: 5%">
                            <b style="font-size: 6pt;">PORT OF LOADING</b><br>
                            <span><?=strtoupper($booking->pol_custom_desc);?></span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top;">
                <div style="padding-left: 10px;">
                    <table width="100%">
                        <tr>
                            <td style="background-image: url('{{ public_path('img/logo.png') }}');background-repeat:no-repeat;background-size:cover; background-position: top; height: 120px; vertical-align: top;">
                                {{-- <img src="{{ public_path('img/logo.png') }}" width="100" style="margin-left: 15px;"> --}}
                                <div style="text-align: center; float: right;">
                                    <div style="border: 1px solid #000; width: 200px; text-align: center;">
                                        <p style="text-align: left; margin-left: 1rem;">Bill of Lading No.</p>
                                        <p><strong>{{ ucwords($booking->hbl_no) }}</strong></p>
                                    </div>
                                    <h1 style="color: powderblue; font-weight: 900; ">ORIGINAL</h1>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin-top: -20px;">
                                    <h2>COMBINED TRANSPORT BILL OF LADING</h2>
                                    <h1>BILL OF LADING</h1>
                                    <p>RECEIVED by the Carrier the Goods as specified above in apparent good order and condition 
                                    unless, otherwise stated, to be transported to such place as agreed, authorized or permitted 
                                    herein and subject to all the terms and conditions appearing on the front and reverse of this Bill 
                                    of Lading to which the Merchant agrees be accepting this Bill of Lading, any local privileges and 
                                    customs notwithstanding. </p>
                                    <p>The particulars given above as stated be this shipper and the weight, measure, quantity, 
                                    condition, contents and value of the Goods are unknown to the Carrier.</p>
                                    <p>In WITNESS whereof one (1) original Bill of Lading has been signed of not otherwise stated above. 
                                    the same being accomplished other other(s), if any, to be void. If required by the Carrier one (1) 
                                    original Bill of Lading must be surrendered duly endorsed in exchange for the Goods or delivery 
                                    order.</p> 
                                    <p>Where applicable law requires and not otherwise, one original BILL OF LADING must be 
                                    surrendered, duly endorsed, in exchange for the GOODS or CONTAINER(S) or other 
                                    PACKAGE(S), the others to stand void. If a "Non-Negotiable" BILL OF LADING is issued, neither 
                                    an original nor a copy need be surrendered in exchange for delivery unless applicable law so requires.</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <table border="0" cellpadding="0" width="100%" cellspacing="0" style="font-family:Helvetica;">
                    <tr>
                        <td class="font-normall border-top" style="vertical-align: top; height: 5%;">
                            <b>Also Notify Party</b><br>
                            <span style="font-size: 10pt;">
                                <?php
                                    $hbl_also_notify_party = preg_split('/\r\n|\r|\n/', $booking->hbl_also_notify_party);
                                    $hbl_also_notify_party_count = count($hbl_also_notify_party);
                                    $loop = array_slice($hbl_also_notify_party, 0, 4, true);
                                    if($hbl_also_notify_party_count>4){
                                        foreach ($loop as $key => $value) {
                                            echo $value;
                                            if ($key != array_key_last($loop)) {
                                                echo '<br>';
                                            }
                                        }
                                        echo ' NP2 >';
                                    }else{
                                        echo nl2br($booking->hbl_also_notify_party);
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="font-normal border-noleft" width="25%">
                <b style="font-size: 6pt;">PORT OF DISCHARGE</b><br>
                <span><?=strtoupper($booking->pod_custom_desc);?></span>
            </td>
            <td class="font-normal border-noleft" width="25%">
                <b style="font-size: 6pt;">PLACE OF DELIVERY</b><br>
                <span><?=strtoupper($booking->place_destination);?></span>
            </td>
            <td class="font-normal border-noleft" width="50%">
                <b style="font-size: 6pt;">Final destination (for the Merchant's reference)</b><br>
                <span>{{ $booking->loaded_type }} &nbsp; &nbsp; {{ $booking->loadedc_type }}</span>
            </td>
        </tr>
    </table>
    <div style="margin-top: 10px;"></div>
    <table border="0" cellpadding="0" width="100%" cellspacing="0">
            <tr>
                <td class="font-normal border-noleft" style="padding: 3px; width: 27%;">MKS & NOS/CONTAINER NOS.</td>
                <td class="font-normal border-noleft" style="padding: 3px; width: 10%;">NO.OF PKGS</td>
                <td class="font-normal border-noleft" style="padding: 3px; width: 38%;">DESCRIPTION OF PACKAGES AND GOODS</td>
                <td class="font-normal border-noleft" style="padding: 3px; width: 15%;">GROSS WEIGHT</td>
                <td class="font-normal border-noleft" style="padding: 3px; width: 10%;">MEASUREMENT</td>
            </tr>
            @php $no = 0; $qty = 0; $weight = 0; $volume = 0; $netto = 0; $volume_code = ''; @endphp
            @foreach ($container as $item)
            @php $no++; 
                $qty+= $item->qty; 
                $weight+= $item->weight; 
                $volume+= $item->volume; 
                $netto+= $item->netto; 
                if(isset($item->volume_code)){
                    $volume_code = $item->volume_code;
                }
            @endphp
            <tr>
                <td class="font-normal" style="@if($no==1) height: 25px; @else height: 15px; @endif">
                    <div class="pabs"> 
                    @if($no==1)
                        @if($booking->loaded_type == 'LCL')
                            {!! 'CONTAINER/SEAL NO<br>' !!}
                        @else
                            {!! 'CONTAINER/SEAL NO/QTY/GW/MEAS<br>' !!}
                        @endif
                    @endif
                    @if($booking->loaded_type == 'LCL')
                        {!! $item->container_no.' / '.$item->seal_no !!}
                    @else
                        {!! $item->container_no.' / '.$item->seal_no.' / '.$item->qty.' '.$item->code_qty.' / '.$item->weight.' '.$item->code_weight.' / '.$item->volume.' '.$item->volume_code.' / '.$item->container_type !!}
                    @endif
                    </div>
                </td>
                <td class="font-normal border-left">
                </td>
                <td class="font-normal border-left">
                </td>
                <td class="font-normal border-left">
                </td>
                <td class="font-normal border-left">
                </td>
            </tr>
            @endforeach
            <tr class="text-left" style="border-top: 1px dashed #000;">
                <td class="font-normal" style="text-overflow: ellipsis">
                    <?php
                        $no_check = ($no - 16) * -1;
                        $hbl_marks_nos = preg_split('/\r\n|\r|\n/', $booking->hbl_marks_nos);
                        $hbl_marks_nos_count = count($hbl_marks_nos);
                        if($hbl_marks_nos_count>$no_check){
                            foreach (array_slice($hbl_marks_nos, 0, $no_check, true) as $key => $value) {
                                echo $value.'<br>';
                            }
                            echo 'MN ><br>';
                        }else{
                            echo nl2br($booking->hbl_marks_nos);
                        }
                    ?>
                </td>
                <td class="font-normal border-left">
                    {{ $qty.' '.$item->code_qty }}
                </td>
                <td class="font-normal border-left">
                    <?php
                        $hbl_attach = 0;
                        $hbl_desc = preg_split('/\r\n|\r|\n/', $booking->hbl_desc);
                        $hbl_desc_count = count($hbl_desc);
                        if($hbl_desc_count>$no_check){
                            echo "SHIPPER'S PACK LOAD COUNT & SEAL<br>";
                            foreach (array_slice($hbl_desc, 0, $no_check, true) as $key => $value) {
                                echo $value.'<br>';
                            }
                            $hbl_attach = 1;
                            echo '** TO BE CONTINUED ON ATTACHED LIST **';
                        }else{
                            echo "SHIPPER'S PACK LOAD COUNT & SEAL<br>";
                            echo nl2br($booking->hbl_desc);
                        }
                        echo '<br>';
                        if($hbl_attach == 0){
                            if($hbl_shipper_count>5){
                                echo 'SHIPPER : ';
                                foreach (array_slice($hbl_shipper, 4, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            if($hbl_consignee_count>5){
                                echo 'CONSIGNEE : ';
                                foreach (array_slice($hbl_consignee, 4, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            if($hbl_not_party_count>5){
                                echo 'NOTIFY PARTY : ';
                                foreach (array_slice($hbl_not_party, 4, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            if($hbl_also_notify_party_count>4){
                                echo 'ALSO NOTIFY PARTY : ';
                                foreach (array_slice($hbl_also_notify_party, 3, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                        }
                    ?>
                </td>
                <td class="font-normal border-left">
                    @if($booking->loaded_type == 'LCL')
                        {!! $weight.' '.$item->code_weight.'<br>'.$netto.' '.$item->code_weight !!}
                    @else
                        {!! $weight.' '.$item->code_weight !!}
                    @endif
                </td>
                <td class="font-normal border-left">
                    {{ $volume.' '.$volume_code }}
                </td>
            </tr>
            <tr>
                <td class="font-normal border-bottom">
                    
                </td>
                <td class="font-normal border-bottom border-left">
                    
                </td>
                <td class="font-normal border-bottom border-left">
                    @php
                        if($hbl_attach == 0){
                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                            echo 'TOTAL :'. strtoupper($f->format($no)).' ('.$no.') CONTAINERS ONLY';
                        }
                    @endphp
                </td>
                <td class="font-normal border-bottom border-left">

                </td>
                <td class="font-normal border-bottom border-left">

                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <p>Declare Value $ __________________________ If Merchants enters actual value of Goods and pays the applicable ad valorem tariff rate, Carrier's package limitation shall not apply</p>
                </td>
            </tr>
    </table>
    <table border="0" cellpadding="0" width="100%" cellspacing="0">
        <tr>
            <td width="26%" class="border-top font-normal">Freight and charoes</td>
            <td width="12%" class="border-top border-left font-normal">Prepaid</td>
            <td width="12%" class="border-top border-left font-normal">Collect</td>
            <td width="50%" class="border-top border-left font-normal">FOR DELIVERY OF GOODS PLEASE APPLY TO:</td>
        </tr>
        <tr style="min-height: 50px;">
            <td>
                <div style="border: 1px solid #000; padding: 5px; text-align: center; margin-bottom: 5px;"> 
                    {{ $booking->charge_name }}
                </div>
            </td>
            <td class="font-normal border-left"></td>
            <td class="font-normal border-left"></td>
            <td class="font-normal border-left" style="padding-top: 5px;">
                <?php
                    $delivery_agent_detail_attach = 0;
                    $delivery_agent_detail = preg_split('/\r\n|\r|\n/', $booking->delivery_agent_detail);
                    $delivery_agent_detail_count = count($delivery_agent_detail);
                    if($delivery_agent_detail_count>5){
                        foreach (array_slice($delivery_agent_detail, 0, 5, true) as $key => $value) {
                            echo $value.'<br>';
                        }
                        echo 'DLV ><br>';
                        $delivery_agent_detail_attach = 1;
                    }else{
                        echo nl2br($booking->delivery_agent_detail);
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td class="border-top"><strong>GRAND TOTAL</strong></td>
            <td class="border-left border-top"></td>
            <td class="border-left border-top"></td>
            <td class="border-left border-top font-normal">PLACE AND DATE OF ISSUE JAKARTA - {{ \Carbon\Carbon::parse($booking->etd_date)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="font-normal border-top">
                Number of Original B/L (s)
            </td>
            <td colspan="2" class="font-normal border-top border-left">Shipper Reference</td>
            <td class="border-top border-left"></td>
        </tr>
        <tr>
            <td class="font-normal">
                <div style="border: 1px solid #000; padding: 5px; text-align: center; margin-bottom: 5px;"> 
                    {{ $booking->hbl_issued_desc }}
                </div>
            </td>
            <td colspan="2" class="border-left"></td>
            <td class="border-left"></td>
        </tr>
        <tr>
            <td colspan="3" class="border-top" style="font: 5pt">
                JURISDICTION: THE CONTRACT EVIDENCED BY OR CONTAINED IN THIS BILL OF LADING IS GOVERNED BY THE LAW OF INDONESIA AND ANY CLAIM OR DISPUTE ARISING HEREUNDER OR IN CONNECTION HEREWITH SHALL BE DETERMINED BY COURTS OF INDONESIA AND NO OTHER COURTS.<br>
                TERMS CONTINUED ONBACK HEREOF.
            </td>
            <td class="font-normal" style="padding-left: 50px; padding-right: 25px;">
                __________________________________________________________________<br>
                AS AGENTS FOR THE CARRIER
            </td>
        </tr>
    </table>
    <div class="page-break"></div>

    <h4 style="text-align: center; margin-top: -1rem;">== ATTACHMENT ==</h4>
    <div style="float: right; margin-top: -2.5rem;">
        <h5 style="font-size: 9px;">ATTACHED LIST PAGE: 1 OF 1</h5>
        <h5 style="font-size: 12px; text-align: center;">{{ ucwords($booking->hbl_no) }}</h5>
    </div>
    <table border="0" cellpadding="0" width="100%" cellspacing="0" style="margin-top: 1.5rem;">
            <tr>
                <td class="font-normal border-noleft" style="width: 27%;">MKS & NOS/CONTAINER NOS.</td>
                <td class="font-normal border-noleft" style="width: 10%;">NO.OF PKGS</td>
                <td class="font-normal border-noleft" style="width: 38%;">DESCRIPTION OF PACKAGES AND GOODS</td>
                <td class="font-normal border-noleft" style="width: 15%;">GROSS WEIGHT</td>
                <td class="font-normal border-noleft" style="width: 10%;">MEASUREMENT</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <?php
                        if($hbl_desc_count>$no_check){
                            foreach (array_slice($hbl_desc, $no_check, 100, true) as $key => $value) {
                                echo $value.'<br>';
                            }
                        }
                        echo '<br>';
                        if($hbl_attach == 1){
                            if($hbl_shipper_count>5){
                                echo 'SH > ';
                                foreach (array_slice($hbl_shipper, 5, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            if($hbl_consignee_count>5){
                                echo 'CN > ';
                                foreach (array_slice($hbl_consignee, 5, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            if($hbl_not_party_count>5){
                                echo 'NP1 > ';
                                foreach (array_slice($hbl_not_party, 5, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            if($hbl_also_notify_party_count>5){
                                echo 'NP2 > ';
                                foreach (array_slice($hbl_also_notify_party, 5, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            echo '<br>';
                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                            echo 'TOTAL :'. strtoupper($f->format($no)).' ('.$no.') CONTAINERS ONLY';
                        }
                        echo '<br><br>';
                        if($delivery_agent_detail_attach==1){
                            $delivery_agent_detail = preg_split('/\r\n|\r|\n/', $booking->delivery_agent_detail);
                            $delivery_agent_detail_count = count($delivery_agent_detail);
                            if($delivery_agent_detail_count>5){
                                echo 'DN > ';
                                foreach (array_slice($delivery_agent_detail, 5, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                        }
                    ?>
                </td>
                <td></td>
                <td></td>
            </tr>
    </table>
<?php }?>
    <div class="page-break"></div>

<?php for($i = 0; $i < $copy; $i++){?>
    
    <table border="0" cellpadding="0" width="100%" height="100%" cellspacing="0" style="font-family:Helvetica;">
        <tr>
            <td colspan="2" class="border-noleft">
                <table border="0" cellpadding="0" width="100%" cellspacing="0" style="font-family:Helvetica;">
                    <tr>
                        <td colspan="2" class="font-normall" style="vertical-align: top; height: 12%;">
                            <b>Shipper/Exporter</b><br>
                            <span style="font-size: 10pt;">
                                <?php
                                    $hbl_shipper = preg_split('/\r\n|\r|\n/', $booking->hbl_shipper);
                                    $hbl_shipper_count = count($hbl_shipper);
                                    $loop = array_slice($hbl_shipper, 0, 5, true);
                                    if($hbl_shipper_count>5){
                                        foreach ($loop as $key => $value) {
                                            echo $value;
                                            if ($key != array_key_last($loop)) {
                                                echo '<br>';
                                            }
                                        }
                                        echo ' SH >';
                                    }else{
                                        echo nl2br($booking->hbl_shipper);
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="font-normal" style="height: 12%; border-top: 1px solid #000;">
                            <b>Consignee</b><br>
                            <span style="font-size: 10pt;">
                                <?php
                                    $hbl_consignee = preg_split('/\r\n|\r|\n/', $booking->hbl_consignee);
                                    $hbl_consignee_count = count($hbl_consignee);
                                    $loop = array_slice($hbl_consignee, 0, 5, true);
                                    if($hbl_consignee_count>5){
                                        foreach ($loop as $key => $value) {
                                            echo $value;
                                            if ($key != array_key_last($loop)) {
                                                echo '<br>';
                                            }
                                        }
                                        echo ' CN >';
                                    }else{
                                        echo nl2br($booking->hbl_consignee);
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="font-normal" style="height: 12%; border-top: 1px solid #000;">
                            <b>Notify Party</b><br>
                            <span style="font-size: 10pt;">
                                <?php
                                    $hbl_not_party = preg_split('/\r\n|\r|\n/', $booking->hbl_not_party);
                                    $hbl_not_party_count = count($hbl_not_party);
                                    $loop = array_slice($hbl_not_party, 0, 5, true);
                                    if($hbl_not_party_count>5){
                                        foreach ($loop as $key => $value) {
                                            echo $value;
                                            if ($key != array_key_last($loop)) {
                                                echo '<br>';
                                            }
                                        }
                                        echo ' NP1 >';
                                    }else{
                                        echo nl2br($booking->hbl_not_party);
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-normal border-top" width="50%" style="height: 5%">
                            <b style="font-size: 6pt;">PRE-CARRIAGE BY</b><br>
                            <?php if($op2 == 1) {
                                echo strtoupper($booking->name_carrier.' '.$booking->flight_number);
                            }elseif($op2 == 2){
                                echo strtoupper($booking->name_carrier_2.' '.$booking->flight_number_2);
                            }elseif($op2 == 3){
                                echo strtoupper($booking->name_carrier_3.' '.$booking->flight_number_3);
                            }?>
                        </td>
                        <td class="font-normal border-left border-top" width="50%" style="height: 5%">
                            <b style="font-size: 6pt;">PLACE OF RECEIPT</b><br>
                            <span><?=strtoupper($booking->place_origin);?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-normal border-top" width="50%" style="height: 5%">
                            <b style="font-size: 6pt;">OCEAN VESSEL VOYAGE NO.</b><br>
                            <span>
                            <?php if($op3 == 1) {
                                echo strtoupper($booking->name_carrier.' '.$booking->flight_number);
                            }elseif($op3 == 2){
                                echo strtoupper($booking->name_carrier_2.' '.$booking->flight_number_2);
                            }elseif($op3 == 3){
                                echo strtoupper($booking->name_carrier_3.' '.$booking->flight_number_3);
                            }?>
                            </span>
                        </td>
                        <td class="font-normal border-left border-top" width="50%" style="height: 5%">
                            <b style="font-size: 6pt;">PORT OF LOADING</b><br>
                            <span><?=strtoupper($booking->pol_custom_desc);?></span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top;">
                <div style="padding-left: 10px;">
                    <table width="100%">
                        <tr>
                            <td style="background-image: url('{{ public_path('img/logo.png') }}');background-repeat:no-repeat;background-size:cover; background-position: top; height: 120px; vertical-align: top;">
                                {{-- <img src="{{ public_path('img/logo.png') }}" width="100" style="margin-left: 15px;"> --}}
                                <div style="text-align: center; float: right;">
                                    <div style="border: 1px solid #000; width: 200px; text-align: center;">
                                        <p style="text-align: left; margin-left: 1rem;">Bill of Lading No.</p>
                                        <p><strong>{{ ucwords($booking->hbl_no) }}</strong></p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin-top: -20px;">
                                    <h2>COMBINED TRANSPORT BILL OF LADING</h2>
                                    <h1>COPY NON-NEGOTIABLE</h1>
                                    <p>RECEIVED by the Carrier the Goods as specified above in apparent good order and condition 
                                    unless, otherwise stated, to be transported to such place as agreed, authorized or permitted 
                                    herein and subject to all the terms and conditions appearing on the front and reverse of this Bill 
                                    of Lading to which the Merchant agrees be accepting this Bill of Lading, any local privileges and 
                                    customs notwithstanding. </p>
                                    <p>The particulars given above as stated be this shipper and the weight, measure, quantity, 
                                    condition, contents and value of the Goods are unknown to the Carrier.</p>
                                    <p>In WITNESS whereof one (1) original Bill of Lading has been signed of not otherwise stated above. 
                                    the same being accomplished other other(s), if any, to be void. If required by the Carrier one (1) 
                                    original Bill of Lading must be surrendered duly endorsed in exchange for the Goods or delivery 
                                    order.</p> 
                                    <p>Where applicable law requires and not otherwise, one original BILL OF LADING must be 
                                    surrendered, duly endorsed, in exchange for the GOODS or CONTAINER(S) or other 
                                    PACKAGE(S), the others to stand void. If a "Non-Negotiable" BILL OF LADING is issued, neither 
                                    an original nor a copy need be surrendered in exchange for delivery unless applicable law so requires.</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <table border="0" cellpadding="0" width="100%" cellspacing="0" style="font-family:Helvetica;">
                    <tr>
                        <td class="font-normall border-top" style="vertical-align: top; height: 5%;">
                            <b>Also Notify Party</b><br>
                            <span style="font-size: 10pt;">
                                <?php
                                    $hbl_also_notify_party = preg_split('/\r\n|\r|\n/', $booking->hbl_also_notify_party);
                                    $hbl_also_notify_party_count = count($hbl_also_notify_party);
                                    $loop = array_slice($hbl_also_notify_party, 0, 4, true);
                                    if($hbl_also_notify_party_count>4){
                                        foreach ($loop as $key => $value) {
                                            echo $value;
                                            if ($key != array_key_last($loop)) {
                                                echo '<br>';
                                            }
                                        }
                                        echo ' NP2 >';
                                    }else{
                                        echo nl2br($booking->hbl_also_notify_party);
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="font-normal border-noleft" width="25%">
                <b style="font-size: 6pt;">PORT OF DISCHARGE</b><br>
                <span><?=strtoupper($booking->pod_custom_desc);?></span>
            </td>
            <td class="font-normal border-noleft" width="25%">
                <b style="font-size: 6pt;">PLACE OF DELIVERY</b><br>
                <span><?=strtoupper($booking->place_destination);?></span>
            </td>
            <td class="font-normal border-noleft" width="50%">
                <b style="font-size: 6pt;">Final destination (for the Merchant's reference)</b><br>
                <span>{{ $booking->loaded_type }} &nbsp; &nbsp; {{ $booking->loadedc_type }}</span>
            </td>
        </tr>
    </table>
    <div style="margin-top: 10px;"></div>
    <table border="0" cellpadding="0" width="100%" cellspacing="0">
            <tr>
                <td class="font-normal border-noleft" style="padding: 3px; width: 27%;">MKS & NOS/CONTAINER NOS.</td>
                <td class="font-normal border-noleft" style="padding: 3px; width: 10%;">NO.OF PKGS</td>
                <td class="font-normal border-noleft" style="padding: 3px; width: 38%;">DESCRIPTION OF PACKAGES AND GOODS</td>
                <td class="font-normal border-noleft" style="padding: 3px; width: 15%;">GROSS WEIGHT</td>
                <td class="font-normal border-noleft" style="padding: 3px; width: 10%;">MEASUREMENT</td>
            </tr>
            @php $no = 0; $qty = 0; $weight = 0; $volume = 0; $netto = 0; $volume_code = ''; @endphp
            @foreach ($container as $item)
            @php $no++; 
                $qty+= $item->qty; 
                $weight+= $item->weight; 
                $volume+= $item->volume; 
                $netto+= $item->netto; 
                if(isset($item->volume_code)){
                    $volume_code = $item->volume_code;
                }
            @endphp
            <tr>
                <td class="font-normal" style="@if($no==1) height: 25px; @else height: 15px; @endif">
                    <div class="pabs"> 
                    @if($no==1)
                        @if($booking->loaded_type == 'LCL')
                            {!! 'CONTAINER/SEAL NO<br>' !!}
                        @else
                            {!! 'CONTAINER/SEAL NO/QTY/GW/MEAS<br>' !!}
                        @endif
                    @endif
                    @if($booking->loaded_type == 'LCL')
                        {!! $item->container_no.' / '.$item->seal_no !!}
                    @else
                        {!! $item->container_no.' / '.$item->seal_no.' / '.$item->qty.' '.$item->code_qty.' / '.$item->weight.' '.$item->code_weight.' / '.$item->volume.' '.$item->volume_code.' / '.$item->container_type !!}
                    @endif
                    </div>
                </td>
                <td class="font-normal border-left">
                </td>
                <td class="font-normal border-left">
                </td>
                <td class="font-normal border-left">
                </td>
                <td class="font-normal border-left">
                </td>
            </tr>
            @endforeach
            <tr class="text-left" style="border-top: 1px dashed #000;">
                <td class="font-normal" style="text-overflow: ellipsis">
                    <?php
                        $no_check = ($no - 16) * -1;
                        $hbl_marks_nos = preg_split('/\r\n|\r|\n/', $booking->hbl_marks_nos);
                        $hbl_marks_nos_count = count($hbl_marks_nos);
                        if($hbl_marks_nos_count>$no_check){
                            foreach (array_slice($hbl_marks_nos, 0, $no_check, true) as $key => $value) {
                                echo $value.'<br>';
                            }
                            echo 'MN ><br>';
                        }else{
                            echo nl2br($booking->hbl_marks_nos);
                        }
                    ?>
                </td>
                <td class="font-normal border-left">
                    {{ $qty.' '.$item->code_qty }}
                </td>
                <td class="font-normal border-left">
                    <?php
                        $hbl_attach = 0;
                        $hbl_desc = preg_split('/\r\n|\r|\n/', $booking->hbl_desc);
                        $hbl_desc_count = count($hbl_desc);
                        if($hbl_desc_count>$no_check){
                            echo "SHIPPER'S PACK LOAD COUNT & SEAL<br>";
                            foreach (array_slice($hbl_desc, 0, $no_check, true) as $key => $value) {
                                echo $value.'<br>';
                            }
                            $hbl_attach = 1;
                            echo '** TO BE CONTINUED ON ATTACHED LIST **';
                        }else{
                            echo "SHIPPER'S PACK LOAD COUNT & SEAL<br>";
                            echo nl2br($booking->hbl_desc);
                        }
                        echo '<br>';
                        if($hbl_attach == 0){
                            if($hbl_shipper_count>5){
                                echo 'SHIPPER : ';
                                foreach (array_slice($hbl_shipper, 4, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            if($hbl_consignee_count>5){
                                echo 'CONSIGNEE : ';
                                foreach (array_slice($hbl_consignee, 4, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            if($hbl_not_party_count>5){
                                echo 'NOTIFY PARTY : ';
                                foreach (array_slice($hbl_not_party, 4, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            if($hbl_also_notify_party_count>4){
                                echo 'ALSO NOTIFY PARTY : ';
                                foreach (array_slice($hbl_also_notify_party, 3, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                        }
                    ?>
                </td>
                <td class="font-normal border-left">
                    @if($booking->loaded_type == 'LCL')
                        {!! $weight.' '.$item->code_weight.'<br>'.$netto.' '.$item->code_weight !!}
                    @else
                        {!! $weight.' '.$item->code_weight !!}
                    @endif
                </td>
                <td class="font-normal border-left">
                    {{ $volume.' '.$volume_code }}
                </td>
            </tr>
            <tr>
                <td class="font-normal border-bottom">
                    
                </td>
                <td class="font-normal border-bottom border-left">
                    
                </td>
                <td class="font-normal border-bottom border-left">
                    @php
                        if($hbl_attach == 0){
                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                            echo 'TOTAL :'. strtoupper($f->format($no)).' ('.$no.') CONTAINERS ONLY';
                        }
                    @endphp
                </td>
                <td class="font-normal border-bottom border-left">

                </td>
                <td class="font-normal border-bottom border-left">

                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <p>Declare Value $ __________________________ If Merchants enters actual value of Goods and pays the applicable ad valorem tariff rate, Carrier's package limitation shall not apply</p>
                </td>
            </tr>
    </table>
    <table border="0" cellpadding="0" width="100%" cellspacing="0">
        <tr>
            <td width="26%" class="border-top font-normal">Freight and charoes</td>
            <td width="12%" class="border-top border-left font-normal">Prepaid</td>
            <td width="12%" class="border-top border-left font-normal">Collect</td>
            <td width="50%" class="border-top border-left font-normal">FOR DELIVERY OF GOODS PLEASE APPLY TO:</td>
        </tr>
        <tr style="min-height: 50px;">
            <td>
                <div style="border: 1px solid #000; padding: 5px; text-align: center; margin-bottom: 5px;"> 
                    {{ $booking->charge_name }}
                </div>
            </td>
            <td class="font-normal border-left"></td>
            <td class="font-normal border-left"></td>
            <td class="font-normal border-left" style="padding-top: 5px;">
                <?php
                    $delivery_agent_detail_attach = 0;
                    $delivery_agent_detail = preg_split('/\r\n|\r|\n/', $booking->delivery_agent_detail);
                    $delivery_agent_detail_count = count($delivery_agent_detail);
                    if($delivery_agent_detail_count>5){
                        foreach (array_slice($delivery_agent_detail, 0, 5, true) as $key => $value) {
                            echo $value.'<br>';
                        }
                        echo 'DLV ><br>';
                        $delivery_agent_detail_attach = 1;
                    }else{
                        echo nl2br($booking->delivery_agent_detail);
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td class="border-top"><strong>GRAND TOTAL</strong></td>
            <td class="border-left border-top"></td>
            <td class="border-left border-top"></td>
            <td class="border-left border-top font-normal">PLACE AND DATE OF ISSUE JAKARTA - {{ \Carbon\Carbon::parse($booking->etd_date)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="font-normal border-top">
                Number of Original B/L (s)
            </td>
            <td colspan="2" class="font-normal border-top border-left">Shipper Reference</td>
            <td class="border-top border-left"></td>
        </tr>
        <tr>
            <td class="font-normal">
                <div style="border: 1px solid #000; padding: 5px; text-align: center; margin-bottom: 5px;"> 
                    {{ $booking->hbl_issued_desc }}
                </div>
            </td>
            <td colspan="2" class="border-left"></td>
            <td class="border-left"></td>
        </tr>
        <tr>
            <td colspan="3" class="border-top" style="font: 5pt">
                JURISDICTION: THE CONTRACT EVIDENCED BY OR CONTAINED IN THIS BILL OF LADING IS GOVERNED BY THE LAW OF INDONESIA AND ANY CLAIM OR DISPUTE ARISING HEREUNDER OR IN CONNECTION HEREWITH SHALL BE DETERMINED BY COURTS OF INDONESIA AND NO OTHER COURTS.<br>
                TERMS CONTINUED ONBACK HEREOF.
            </td>
            <td class="font-normal" style="padding-left: 50px; padding-right: 25px;">
                __________________________________________________________________<br>
                AS AGENTS FOR THE CARRIER
            </td>
        </tr>
    </table>
    <div class="page-break"></div>

    <h4 style="text-align: center; margin-top: -1rem;">== ATTACHMENT ==</h4>
    <div style="float: right; margin-top: -2.5rem;">
        <h5 style="font-size: 9px;">ATTACHED LIST PAGE: 1 OF 1</h5>
        <h5 style="font-size: 12px; text-align: center;">{{ ucwords($booking->hbl_no) }}</h5>
    </div>
    <table border="0" cellpadding="0" width="100%" cellspacing="0" style="margin-top: 1.5rem;">
            <tr>
                <td class="font-normal border-noleft" style="width: 27%;">MKS & NOS/CONTAINER NOS.</td>
                <td class="font-normal border-noleft" style="width: 10%;">NO.OF PKGS</td>
                <td class="font-normal border-noleft" style="width: 38%;">DESCRIPTION OF PACKAGES AND GOODS</td>
                <td class="font-normal border-noleft" style="width: 15%;">GROSS WEIGHT</td>
                <td class="font-normal border-noleft" style="width: 10%;">MEASUREMENT</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <?php
                        if($hbl_desc_count>$no_check){
                            foreach (array_slice($hbl_desc, $no_check, 100, true) as $key => $value) {
                                echo $value.'<br>';
                            }
                        }
                        echo '<br>';
                        if($hbl_attach == 1){
                            if($hbl_shipper_count>5){
                                echo 'SH > ';
                                foreach (array_slice($hbl_shipper, 5, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            if($hbl_consignee_count>5){
                                echo 'CN > ';
                                foreach (array_slice($hbl_consignee, 5, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            if($hbl_not_party_count>5){
                                echo 'NP1 > ';
                                foreach (array_slice($hbl_not_party, 5, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            if($hbl_also_notify_party_count>5){
                                echo 'NP2 > ';
                                foreach (array_slice($hbl_also_notify_party, 5, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                            echo '<br>';
                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                            echo 'TOTAL :'. strtoupper($f->format($no)).' ('.$no.') CONTAINERS ONLY';
                        }
                        echo '<br><br>';
                        if($delivery_agent_detail_attach==1){
                            $delivery_agent_detail = preg_split('/\r\n|\r|\n/', $booking->delivery_agent_detail);
                            $delivery_agent_detail_count = count($delivery_agent_detail);
                            if($delivery_agent_detail_count>5){
                                echo 'DN > ';
                                foreach (array_slice($delivery_agent_detail, 5, 100, true) as $key => $value) {
                                    echo $value.'<br>';
                                }
                            }
                        }
                    ?>
                </td>
                <td></td>
                <td></td>
            </tr>
    </table>
<?php }?>
</body>
</html>