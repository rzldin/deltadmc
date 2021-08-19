<!DOCTYPE html>

<html>
<head>
	<title>HBL</title>
</head>
<?php for($i = 0; $i < $origin; $i++){?>
<body>
    <style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}

        tr.noBorder td {
            border: 0;
        }

        #myTable{
            font-size: 7pt !important;
            text-align: center;
        }
	</style>
    <table border="0" cellpadding="0" width="100%" cellspacing="0" style="font-family:Microsoft Sans Serif">
        <tr>
            <td width="50%">
                <table width="100%" cellspacing="0">
                    <tr>
                        <td colspan="2" style="vertical-align:top;border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000;" height="80">
                            Shipper/Exporter
                            @if ($booking->mbl_shipper != null)
                                <h3>{!! $booking->mbl_shipper !!}</h3>
                            @else
                                <h3>{{ $booking->company_f }}</h3>
                                <h3>{{ $booking->address_f }}</h3>
                                <h3>{{ $booking->pic_f }}</h3>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top;border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000;" height="80">
                            Consignee
                            @if ($booking->mbl_consignee != null)
                                <h3>{!! $booking->mbl_consignee !!}</h3>
                            @else
                                <h3>{{ $booking->company_i }}</h3>
                                <h3>{{ $booking->address_i }}</h3>
                                <h3>{{ $booking->pic_i }}</h3>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top;border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000;" height="80">
                            Notify Party
                            @if ($booking->mbl_not_party != null)
                                <h3>{!! $booking->mbl_not_party !!}</h3>
                            @else
                                <h3>{{ $booking->company_l }}</h3>
                                <h3>{{ $booking->address_l }}</h3>
                                <h3>{{ $booking->pic_l }}</h3>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;" height="40">
                            Place of receipt
                            <p style="font-size:9pt;"><strong>{{ ucwords($booking->place_destination) }}</strong></p>
                        </td>
                        <td style="vertical-align:top;border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">
                            Port Of loading
                            <p style="font-size:9pt;"><strong>{{ ucwords($booking->port1) }}</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top;border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;" height="40">
                            Vessel/Voyage
                            <p style="font-size:9pt;"><strong>{{ ucwords($booking->flight_number) }}</strong></p>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="5%"></td>
            <td width="45%">
                <table width="100%" cellspacing="0">
                    <tr>
                        <td>
                            <img src="{{ public_path('admin/dist/img/DMC.jpg') }}" width="100" height="100">
                        </td>
                        <td width="150">
                            <table width="100%" cellspacing="0">
                                <tr height="60">
                                    <td style="vertical-align: top;border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000;" height="60">
                                        Bill of Lading No.
                                        <h3 style="text-align:center;">{{ $booking->booking_no }}</h3>
                                    </td>
                                </tr>
                                <tr height="20">  
                                    <td>
                                        <h2 style="text-align: center; color:blue;">ORIGINAL</h2>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="margin-top: 5px;">
                        <td colspan="2" style="vertical-align:top;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:0px solid #000;" height="180">
                            <h3>COMBINED TRANSPORT BILL OF LADING</h3>
                            <h1>BILL OF LADING</h1>
                            <p style="font-size: 8px;text-align:justify;">RECEIVED by the Carrier the Goods as specified above in apparent good order and condition unless, otherwise stated, to be transported to such place as agreed, authorized or permited herein and subject to all the terms and conditions appearing on the front and reverse of this Bill of Lading to which the Mercant aggress be accepting this Bill of Lading, any local privileges and customs notwithstanding.</p>
                            <p style="font-size: 8px;text-align:justify;">The particulars given above as stated be this shipper and the weight, measure, quantity, condition, contents and value of the Goods are unknown to the Carrier.</p>
                            <p style="font-size: 8px;text-align:justify;">In WITNESS whereof one (1) original Bill of Lading has been signed of not otherwise stated above. the same being accomplished other other(s), if any, to be void. If required by the Carrier one (1) original Bill of Lading must be surrendered duly endorsed in exchange for the Goods or delivery other.</p>
                            <p style="font-size: 8px;text-align:justify;">Where applicable law requires and not otherwise, one original BILL OF LADING must be surrendered, duly endorsed, in exchange for the GOODS or CONTAINER(S) or other PACKAGE(S), the others to stand void. If a "Non-Negotiable" BILL OF LADING is issued, neither an original nor a copy need be surrendered in exchange for delivery unless applicable law so requires.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%" cellpadding="1" cellspacing="0" border="1">
        <tr>
            <td width="25%" height="40" style="vertical-align: top">
                Port of Discharge
                <p style="font-size:9pt;"><strong>{{ ucwords($booking->port3) }}</strong></p>
            </td>
            <td width="25%" height="40" style="vertical-align: top">
                Place of Delivery
                <p style="font-size:9pt;"><strong>{{ ucwords($booking->port2) }}</strong></p>
            </td>
            <td width="50%" height="40" style="vertical-align: top">
                Final Destination (for the Merchant's reference)
                <p>{{ $booking->company_c }}, Address : {{ $booking->address_c }}, PIC : {{ $booking->pic_c }}</p>
            </td>
        </tr>
    </table>
    <table width="100%" cellpadding="1" cellspacing="0" border="1" id="myTable">
        <thead>
            <tr>
                <td width="20%">
                    MKS & NOS/CONTAINER NOS
                </td>
                <td width="10%">
                    NO.OF PKGS
                </td>
                <td width="40%">
                    DESCRIPTION OF PACKAGES AND GOODS
                </td>
                <td width="15%">
                    GROSS WEIGHT
                </td>
                <td width="15%">
                    MEASUREMENT
                </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $item)
            <tr class="">
                <td>
                   &nbsp;
                </td>
                <td>
                    {{ $item->position_no }}
                </td>
                <td>
                    {!! $item->desc !!}
                </td>
                <td>
                    {{ $item->qty }}
                </td>
                <td>
                    {{ $item->code }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <table width="100%" cellpadding="1" cellspacing="0" border="0">
        <tr>
            <p style="font-size: 8pt">Declare Value $............................. If Merchant enters actual value of Goods and pays the aplicable ad valorem tarif rate, Carrier's package limitation shall not apply.</p>
        </tr>
    </table>
    <table width="100%" cellpadding="1" cellspacing="0" border="1">
        <tr>
            <td width="20%" height="60" style="vertical-align: top">
                Freight and charges
                <p style="font-size:9pt;"><strong>{{ ucwords($booking->charge_name) }}</strong></p>
            </td>
            <td width="15%" height="60" style="vertical-align: top">
                Prepaid
                <p style="font-size:9pt;"><strong>{{ number_format($booking->value_prepaid,2,',','.') }}</strong></p>
            </td>
            <td width="15%" height="60" style="vertical-align: top">
                Collect
                <p style="font-size:9pt;"><strong>{{ number_format($booking->value_collect,2,',','.') }}</strong></p>
            </td>
            <td width="50%" height="60" style="vertical-align: top">
                FOR DELIVERY OF GOODS PLEASE APPLY TO :
            </td>
        </tr>
        <tr>
            <td width="20%" height="20" style="vertical-align: top">
                <h3>GRAND TOTAL</h3>
            </td>
            <td width="15%" height="20" style="vertical-align: top">
                &nbsp;
            </td>
            <td width="15%" height="20" style="vertical-align: top">
                &nbsp;
            </td>
            <td width="50%" height="20" style="vertical-align: bottom">
                PLACE AND DATE OF ISSUE
            </td>
        </tr>
        <tr>
            <td colspan="2" width="20%" height="30" style="vertical-align: top">
                Number of Original B/L (s)
                <p style="font-size:9pt;"><strong>{{ $booking->mbl_no }}</strong></p>
            </td>
            <td colspan="2" height="30" style="vertical-align: top">
                Shipper Reference
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%" height="30" style="border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:0px solid #000;">
                <p style="font-size: 8px;text-align:justify;">JURISDICTION THE CONTRACT EVIDENCED BY OR CONTAINED IN THIS BILL OF LADING IS GOVERNED BY THE LAW OF INDONESIA AND ANY CLAIM OR DISPUTE ARISING HEREUNDER OR IN CONNECTION HERE WITH SHALL BE DETERMINED BY COURTS OF INDONESIA AND NO OTHER COURTS</p>
                <p style="font-size: 8px;text-align:justify;">TERMS CONTINUED ONBACK HEREOF</p>
            </td>
            <td width="5%"></td>
            <td width="45%" height="30">
                <p style="font-size: 8px;text-align:justify;"><br><hr>AS AGENTS FOR THE CARRIER</p>
            </td>
        </tr>
    </table>
</body>
<?php }?>

<!-- Copy Non-Negotable -->
<?php for($i = 0; $i < $copy; $i++){?>
    <body>
        <style type="text/css">
            table tr td,
            table tr th{
                font-size: 9pt;
            }
    
            tr.noBorder td {
                border: 0;
            }
    
            #myTable{
                font-size: 7pt !important;
                text-align: center;
            }
        </style>
        <table border="0" cellpadding="0" width="100%" cellspacing="0" style="font-family:Microsoft Sans Serif">
            <tr>
                <td width="50%">
                    <table width="100%" cellspacing="0">
                        <tr>
                            <td colspan="2" style="vertical-align:top;border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000;" height="80">
                                Shipper/Exporter
                                @if ($booking->mbl_shipper != null)
                                    <h3>{!! $booking->mbl_shipper !!}</h3>
                                @else
                                    <h3>{{ $booking->company_f }}</h3>
                                    <h3>{{ $booking->address_f }}</h3>
                                    <h3>{{ $booking->pic_f }}</h3>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="vertical-align:top;border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000;" height="80">
                                Consignee
                                @if ($booking->mbl_consignee != null)
                                    <h3>{!! $booking->mbl_consignee !!}</h3>
                                @else
                                    <h3>{{ $booking->company_i }}</h3>
                                    <h3>{{ $booking->address_i }}</h3>
                                    <h3>{{ $booking->pic_i }}</h3>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="vertical-align:top;border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000;" height="80">
                                Notify Party
                                @if ($booking->mbl_not_party != null)
                                    <h3>{!! $booking->mbl_not_party !!}</h3>
                                @else
                                    <h3>{{ $booking->company_l }}</h3>
                                    <h3>{{ $booking->address_l }}</h3>
                                    <h3>{{ $booking->pic_l }}</h3>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top;border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;" height="40">
                                Place of receipt
                                <p style="font-size:9pt;"><strong>{{ ucwords($booking->place_destination) }}</strong></p>
                            </td>
                            <td style="vertical-align:top;border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">
                                Port Of loading
                                <p style="font-size:9pt;"><strong>{{ ucwords($booking->port1) }}</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="vertical-align:top;border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;" height="40">
                                Vessel/Voyage
                                <p style="font-size:9pt;"><strong>{{ ucwords($booking->flight_number) }}</strong></p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="5%"></td>
                <td width="45%">
                    <table width="100%" cellspacing="0">
                        <tr>
                            <td>
                                <img src="{{ public_path('admin/dist/img/DMC.jpg') }}" width="100" height="100">
                            </td>
                            <td width="150">
                                <table width="100%" cellspacing="0">
                                    <tr height="60">
                                        <td style="vertical-align: top;border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000;" height="60">
                                            Bill of Lading No.
                                            <h3 style="text-align:center;">{{ $booking->booking_no }}</h3>
                                        </td>
                                    </tr>
                                    <tr height="20">  
                                        <td>
                                            <h2 style="text-align: center; color:white;">ORIGINAL</h2>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr style="margin-top: 5px;">
                            <td colspan="2" style="vertical-align:top;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:0px solid #000;" height="180">
                                <h3>COMBINED TRANSPORT BILL OF LADING</h3>
                                <h1>COPY NON-NEGOTIABLE</h1>
                                <p style="font-size: 8px;text-align:justify;">RECEIVED by the Carrier the Goods as specified above in apparent good order and condition unless, otherwise stated, to be transported to such place as agreed, authorized or permited herein and subject to all the terms and conditions appearing on the front and reverse of this Bill of Lading to which the Mercant aggress be accepting this Bill of Lading, any local privileges and customs notwithstanding.</p>
                                <p style="font-size: 8px;text-align:justify;">The particulars given above as stated be this shipper and the weight, measure, quantity, condition, contents and value of the Goods are unknown to the Carrier.</p>
                                <p style="font-size: 8px;text-align:justify;">In WITNESS whereof one (1) original Bill of Lading has been signed of not otherwise stated above. the same being accomplished other other(s), if any, to be void. If required by the Carrier one (1) original Bill of Lading must be surrendered duly endorsed in exchange for the Goods or delivery other.</p>
                                <p style="font-size: 8px;text-align:justify;">Where applicable law requires and not otherwise, one original BILL OF LADING must be surrendered, duly endorsed, in exchange for the GOODS or CONTAINER(S) or other PACKAGE(S), the others to stand void. If a "Non-Negotiable" BILL OF LADING is issued, neither an original nor a copy need be surrendered in exchange for delivery unless applicable law so requires.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table width="100%" cellpadding="1" cellspacing="0" border="1">
            <tr>
                <td width="25%" height="40" style="vertical-align: top">
                    Port of Discharge
                    <p style="font-size:9pt;"><strong>{{ ucwords($booking->port3) }}</strong></p>
                </td>
                <td width="25%" height="40" style="vertical-align: top">
                    Place of Delivery
                    <p style="font-size:9pt;"><strong>{{ ucwords($booking->port2) }}</strong></p>
                </td>
                <td width="50%" height="40" style="vertical-align: top">
                    Final Destination (for the Merchant's reference)
                    <p>{{ $booking->company_c }}, Address : {{ $booking->address_c }}, PIC : {{ $booking->pic_c }}</p>
                </td>
            </tr>
        </table>
        <table width="100%" cellpadding="1" cellspacing="0" border="1" id="myTable">
            <thead>
                <tr>
                    <td width="20%">
                        MKS & NOS/CONTAINER NOS
                    </td>
                    <td width="10%">
                        NO.OF PKGS
                    </td>
                    <td width="40%">
                        DESCRIPTION OF PACKAGES AND GOODS
                    </td>
                    <td width="15%">
                        GROSS WEIGHT
                    </td>
                    <td width="15%">
                        MEASUREMENT
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $item)
                <tr class="">
                    <td>
                       &nbsp;
                    </td>
                    <td>
                        {{ $item->position_no }}
                    </td>
                    <td>
                        {!! $item->desc !!}
                    </td>
                    <td>
                        {{ $item->qty }}
                    </td>
                    <td>
                        {{ $item->code }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table width="100%" cellpadding="1" cellspacing="0" border="0">
            <tr>
                <p style="font-size: 8pt">Declare Value $............................. If Merchant enters actual value of Goods and pays the aplicable ad valorem tarif rate, Carrier's package limitation shall not apply.</p>
            </tr>
        </table>
        <table width="100%" cellpadding="1" cellspacing="0" border="1">
            <tr>
                <td width="20%" height="60" style="vertical-align: top">
                    Freight and charges
                    <p style="font-size:9pt;"><strong>{{ ucwords($booking->charge_name) }}</strong></p>
                </td>
                <td width="15%" height="60" style="vertical-align: top">
                    Prepaid
                    <p style="font-size:9pt;"><strong>{{ number_format($booking->value_prepaid,2,',','.') }}</strong></p>
                </td>
                <td width="15%" height="60" style="vertical-align: top">
                    Collect
                    <p style="font-size:9pt;"><strong>{{ number_format($booking->value_collect,2,',','.') }}</strong></p>
                </td>
                <td width="50%" height="60" style="vertical-align: top">
                    FOR DELIVERY OF GOODS PLEASE APPLY TO :
                </td>
            </tr>
            <tr>
                <td width="20%" height="20" style="vertical-align: top">
                    <h3>GRAND TOTAL</h3>
                </td>
                <td width="15%" height="20" style="vertical-align: top">
                    &nbsp;
                </td>
                <td width="15%" height="20" style="vertical-align: top">
                    &nbsp;
                </td>
                <td width="50%" height="20" style="vertical-align: bottom">
                    PLACE AND DATE OF ISSUE
                </td>
            </tr>
            <tr>
                <td colspan="2" width="20%" height="30" style="vertical-align: top">
                    Number of Original B/L (s)
                    <p style="font-size:9pt;"><strong>{{ $booking->mbl_no }}</strong></p>
                </td>
                <td colspan="2" height="30" style="vertical-align: top">
                    Shipper Reference
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="50%" height="30" style="border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:0px solid #000;">
                    <p style="font-size: 8px;text-align:justify;">JURISDICTION THE CONTRACT EVIDENCED BY OR CONTAINED IN THIS BILL OF LADING IS GOVERNED BY THE LAW OF INDONESIA AND ANY CLAIM OR DISPUTE ARISING HEREUNDER OR IN CONNECTION HERE WITH SHALL BE DETERMINED BY COURTS OF INDONESIA AND NO OTHER COURTS</p>
                    <p style="font-size: 8px;text-align:justify;">TERMS CONTINUED ONBACK HEREOF</p>
                </td>
                <td width="5%"></td>
                <td width="45%" height="30">
                    <p style="font-size: 8px;text-align:justify;"><br><hr>AS AGENTS FOR THE CARRIER</p>
                </td>
            </tr>
        </table>
    </body>
    <?php }?>
</html>