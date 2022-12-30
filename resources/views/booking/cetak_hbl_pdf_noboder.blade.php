<html>
<head>
	<title>HBL</title>
    <style>
        html, body, body div{
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

        #myTable{
            font-size: 7pt !important;
            text-align: center;
        }
        
        #tblData{
            height:300px;
        }

    </style>
</head>
<?php for($i = 0; $i < $origin; $i++){?>


<body>
    <table border="0" cellpadding="0" width="100%" cellspacing="0" style="font-family:Microsoft Sans Serif">
        <tr>
            <td width="50%">
                <table width="100%" cellspacing="0">
                    <tr>
                        <td colspan="2" style="vertical-align:top;" height="80">
                            @if ($booking->mbl_shipper != null)
                                <p style="padding-top:5px;">{!! $booking->mbl_shipper !!}</p>
                            @else
                                <p style="padding-top:5px;">{{ $booking->company_f }}<br>
                                {{ $booking->address_f }}<br>
                                {{ $booking->pic_f }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top" height="80">
                            @if ($booking->mbl_consignee != null)
                                <p style="padding-top:6px;">{!! $booking->mbl_consignee !!}</p>
                            @else
                                <p style="padding-top:6px;">{{ $booking->company_i }}<br>
                                {{ $booking->address_i }}<br>
                                {{ $booking->pic_i }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top;" height="70">
                            @if ($booking->mbl_not_party != null)
                                <p style="padding-top:6px;">{!! $booking->mbl_not_party !!}</p>
                            @else
                                <p style="padding-top:6px;">{{ $booking->company_l }}<br>
                                {{ $booking->address_l }}<br>
                                {{ $booking->pic_l }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;" height="30" width="50%">
                            <p style="font-size:6pt;padding-top:6px;">{{ ucwords($booking->place_destination) }}</p>
                        </td>
                        <td style="vertical-align:top;" width="50%">
                            <p style="font-size:6pt;padding-top:6px;">{{ ucwords($booking->port1) }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top;" height="20">
                            <p style="font-size:6pt;">{{ ucwords($booking->flight_number) }}</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="5%"></td>
            <td width="45%">
                <table width="100%" cellspacing="0">
                    <tr>
                        <td colspan="2" style="vertical-align:top;" height="80">
                            <p style="font-size:9pt;margin-left:160px;"><strong>{{ ucwords($booking->booking_no) }}</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top" height="80">
                           
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top;" height="70">
                          
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;" height="30">
                        </td>
                        <td style="vertical-align:top;">
                            
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top;" height="20">
                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%" cellpadding="1" cellspacing="0">
        <tr>
            <td width="25%" height="20" style="vertical-align: top">
                <p style="font-size:6pt;"><strong>{{ ucwords($booking->port3) }}</strong></p>
            </td>
            <td width="25%" height="20" style="vertical-align: top">
                <p style="font-size:6pt;margin-left:10px;"><strong>{{ ucwords($booking->port2) }}</strong></p>
            </td>
            <td width="50%" height="20" style="vertical-align: top;">
                <p style="font-size:6pt;margin-left:13px;">{{ $booking->company_c }}, Address : {{ $booking->address_c }}, PIC : {{ $booking->pic_c }}</p>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <div id="tblData">
        <table width="100%" cellpadding="0" cellspacing="0" id="myTable">
            <thead>
                <tr>
                    <td width="20%">
                        &nbsp;
                    </td>
                    <td width="10%">
                        &nbsp;
                    </td>
                    <td width="40%">
                        &nbsp;
                    </td>
                    <td width="15%">
                        &nbsp;
                    </td>
                    <td width="15%">
                        &nbsp;
                    </td>
                </tr>
            </thead>
            <tbody>
                 @foreach ($packages as $item)
                <tr class="">
                    <td>
                       {{ $loop->iteration }} .
                    </td>
                    <td>
                        {{ $item->position_no }}
                    </td>
                    <td style="text-align:center;">
                        {!! $item->desc !!}
                    </td>
                    <td style="text-align:right;">
                        {{ $item->qty }}
                    </td>
                    <td style="text-align:right;">
                        {{ $item->code }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div height="20">
        
    </div>

    <table width="100%" cellpadding="1" cellspacing="0">
        <tr>
            <td width="20%" height="30" style="vertical-align: top;">
                <p style="font-size:6pt;padding-top:15px;margin-left:5px;"><strong>{{ ucwords($booking->charge_name) }}</strong></p>
            </td>
            <td width="15%" height="30" style="vertical-align: top;">
                <p style="font-size:6pt;padding-top:15px;margin-left:70px;"><strong>{{ number_format($booking->value_prepaid,2,',','.') }}</strong></p>
            </td>
            <td width="15%" height="30" style="vertical-align: top;">
                <p style="font-size:6pt;padding-top:15px;margin-left:60px;"><strong>{{ number_format($booking->value_collect,2,',','.') }}</strong></p>
            </td>
            <td width="50%" height="30" style="vertical-align: top;">
                <p style="margin:0;padding-top:10px;font-size: 6pt"></p>
            </td>
        </tr>
        <tr>
            <td width="20%" height="10" style="vertical-align: top;">
                &nbsp;
            </td>
            <td width="15%" height="10" style="vertical-align: top;">
                <p style="font-size:6pt;padding-top:65px;margin-left:70px;"><strong>{{ number_format($booking->value_prepaid,2,',','.') }}</strong></p>
            </td>
            <td width="15%" height="10" style="vertical-align: top;">
                <p style="font-size:6pt;padding-top:65px;margin-left:60px;"><strong>{{ number_format($booking->value_collect,2,',','.') }}</strong></p>
            </td>
            <td width="50%" height="10" style="vertical-align: bottom;">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td width="20%" height="15" style="vertical-align: top;">
                <p style="font-size:6pt;padding-top:10px;margin-left:10px;"><strong>{{ $booking->mbl_no }}</strong></p>
            </td>
            <td colspan="2" height="15" style="vertical-align: top;">
            </td>
            <td colspan="2" height="15" style="vertical-align: top;">
                &nbsp;
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%" height="30">
            </td>
            <td width="5%"></td>
            <td width="45%" height="30">
                <h4 style="margin-left: 50px">RORONOA ZORO</h4>
            </td>
        </tr>
    </table>
</body>
<?php }?>

<!-- Copy Non-Negotable -->
<?php for($i = 0; $i < $copy; $i++){?>
    <body>
    <table border="0" cellpadding="0" width="100%" cellspacing="0" style="font-family:Microsoft Sans Serif">
        <tr>
            <td width="50%">
                <table width="100%" cellspacing="0">
                    <tr>
                        <td colspan="2" style="vertical-align:top;" height="80">
                            @if ($booking->mbl_shipper != null)
                                <p style="padding-top:5px;">{!! $booking->mbl_shipper !!}</p>
                            @else
                                <p style="padding-top:5px;">{{ $booking->company_f }}<br>
                                {{ $booking->address_f }}<br>
                                {{ $booking->pic_f }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top" height="80">
                            @if ($booking->mbl_consignee != null)
                                <p style="padding-top:6px;">{!! $booking->mbl_consignee !!}</p>
                            @else
                                <p style="padding-top:6px;">{{ $booking->company_i }}<br>
                                {{ $booking->address_i }}<br>
                                {{ $booking->pic_i }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top;" height="70">
                            @if ($booking->mbl_not_party != null)
                                <p style="padding-top:6px;">{!! $booking->mbl_not_party !!}</p>
                            @else
                                <p style="padding-top:6px;">{{ $booking->company_l }}<br>
                                {{ $booking->address_l }}<br>
                                {{ $booking->pic_l }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;" height="30" width="50%">
                            <p style="font-size:6pt;padding-top:6px;">{{ ucwords($booking->place_destination) }}</p>
                        </td>
                        <td style="vertical-align:top;" width="50%">
                            <p style="font-size:6pt;padding-top:6px;">{{ ucwords($booking->port1) }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top;" height="20">
                            <p style="font-size:6pt;">{{ ucwords($booking->flight_number) }}</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="5%"></td>
            <td width="45%">
                <table width="100%" cellspacing="0">
                    <tr>
                        <td colspan="2" style="vertical-align:top;" height="80">
                            <p style="font-size:9pt;margin-left:160px;"><strong>{{ ucwords($booking->booking_no) }}</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top" height="80">
                           
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top;" height="70">
                          
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;" height="30">
                        </td>
                        <td style="vertical-align:top;">
                            
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top;" height="20">
                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%" cellpadding="1" cellspacing="0">
        <tr>
            <td width="25%" height="20" style="vertical-align: top">
                <p style="font-size:6pt;"><strong>{{ ucwords($booking->port3) }}</strong></p>
            </td>
            <td width="25%" height="20" style="vertical-align: top">
                <p style="font-size:6pt;margin-left:10px;"><strong>{{ ucwords($booking->port2) }}</strong></p>
            </td>
            <td width="50%" height="20" style="vertical-align: top;">
                <p style="font-size:6pt;margin-left:13px;">{{ $booking->company_c }}, Address : {{ $booking->address_c }}, PIC : {{ $booking->pic_c }}</p>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <div id="tblData">
        <table width="100%" cellpadding="0" cellspacing="0" id="myTable">
            <thead>
                <tr>
                    <td width="20%">
                        &nbsp;
                    </td>
                    <td width="10%">
                        &nbsp;
                    </td>
                    <td width="40%">
                        &nbsp;
                    </td>
                    <td width="15%">
                        &nbsp;
                    </td>
                    <td width="15%">
                        &nbsp;
                    </td>
                </tr>
            </thead>
            <tbody>
                 @foreach ($packages as $item)
                <tr class="">
                    <td>
                       {{ $loop->iteration }} .
                    </td>
                    <td>
                        {{ $item->position_no }}
                    </td>
                    <td style="text-align:center;">
                        {!! $item->desc !!}
                    </td>
                    <td style="text-align:right;">
                        {{ $item->qty }}
                    </td>
                    <td style="text-align:right;">
                        {{ $item->code }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div height="20">
        
    </div>

    <table width="100%" cellpadding="1" cellspacing="0">
        <tr>
            <td width="20%" height="30" style="vertical-align: top;">
                <p style="font-size:6pt;padding-top:15px;margin-left:5px;"><strong>{{ ucwords($booking->charge_name) }}</strong></p>
            </td>
            <td width="15%" height="30" style="vertical-align: top;">
                <p style="font-size:6pt;padding-top:15px;margin-left:70px;"><strong>{{ number_format($booking->value_prepaid,2,',','.') }}</strong></p>
            </td>
            <td width="15%" height="30" style="vertical-align: top;">
                <p style="font-size:6pt;padding-top:15px;margin-left:60px;"><strong>{{ number_format($booking->value_collect,2,',','.') }}</strong></p>
            </td>
            <td width="50%" height="30" style="vertical-align: top;">
                <p style="margin:0;padding-top:10px;font-size: 6pt"></p>
            </td>
        </tr>
        <tr>
            <td width="20%" height="10" style="vertical-align: top;">
                &nbsp;
            </td>
            <td width="15%" height="10" style="vertical-align: top;">
                <p style="font-size:6pt;padding-top:65px;margin-left:70px;"><strong>{{ number_format($booking->value_prepaid,2,',','.') }}</strong></p>
            </td>
            <td width="15%" height="10" style="vertical-align: top;">
                <p style="font-size:6pt;padding-top:65px;margin-left:60px;"><strong>{{ number_format($booking->value_collect,2,',','.') }}</strong></p>
            </td>
            <td width="50%" height="10" style="vertical-align: bottom;">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td width="20%" height="15" style="vertical-align: top;">
                <p style="font-size:6pt;padding-top:10px;margin-left:10px;"><strong>{{ $booking->mbl_no }}</strong></p>
            </td>
            <td colspan="2" height="15" style="vertical-align: top;">
            </td>
            <td colspan="2" height="15" style="vertical-align: top;">
                &nbsp;
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%" height="30">
            </td>
            <td width="5%"></td>
            <td width="45%" height="30">
                <h4 style="margin-left: 50px">RORONOA ZORO</h4>
            </td>
        </tr>
    </table>
</body>
<?php }?>
</html>