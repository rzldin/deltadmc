<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
        <style>
            .price{
                text-align: right;
            }
        </style>
    </head>
    <body class="margin-left:40px;">
        <h2 style="text-align: center">Quotation Detail</h2>
        <h4>A. Shipping Detail</h4>
        <table width="100%" cellpadding="1" cellspacing="0" border="1" style="font-size: 12px;">
            <thead>
                <tr>
                    <th width="2%">No.</th>
                    @if ($quote->shipment_by == 'LAND')
                    <th width="15%">Truck Size</th>
                    @else
                    <th width="15%">Carrier</th>
                    <th width="10%">Routing</th>
                    <th width="5%">Transit time(days)</th>
                    @endif
                    <th width="10%">Currency</th>
                    <th width="15%">Sell</th>
                    <th width="5%">Qty</th>
                    <th width="15%">Sell Value</th>
                    <th width="10%">Vat</th>
                    <th width="10%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shipping as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    @if ($quote->shipment_by == 'LAND')
                    <td>{{ $item->truck_size }}</td>
                    @else
                    <td>{{ $item->name_carrier }}</td>
                    <td>{{ $item->routing }}</td>
                    <td style="text-align: center">{{ $item->transit_time }}</td>
                    @endif
                    <td style="text-align: center">{{ $item->code_currency }}</td>
                    <td class="price">{{ number_format($item->sell,2,',','.') }}</td>
                    <td style="text-align: center">{{ $item->qty }}</td>
                    <td class="price">{{ number_format($item->sell_val,2,',','.') }}</td>
                    <td class="price">{{ number_format($item->vat,2,',','.') }}</td>
                    <td class="price">{{ number_format($item->subtotal,2,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br/>
        <h4>B. Detail Quote</h4>
        <table width="100%" cellpadding="1" cellspacing="0" border="1" style="font-size: 12px;">
            <thead>
                <tr>
                    <th width="2%">No.</th>
                    <th width="10%">Service/Fee</th>
                    <th width="15%">Sell</th>
                    <th width="5%">Qty</th>
                    <th width="15%">Sell Value</th>
                    <th width="10%">Vat</th>
                    <th width="10%">Total</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $refund = 0;
                    $quote_sell = 0;
                    $quote_val = 0;
                    $quote_vat = 0;
                    $quote_total = 0;
                @endphp
                @foreach ($detail_quote as $item)
                @php 
                    if($item->t_mcharge_code_id!=33){//refund tidak di tunjukkan
                        $quote_sell += $item->sell;
                        $quote_val += $item->sell_val;
                        $quote_vat += $item->vat;
                        $quote_total += $item->subtotal;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="text-align: center">{{ $item->name_charge }}</td>
                    <td class="price">{{ number_format($item->sell,2,',','.') }}</td>
                    <td style="text-align: center">{{ $item->qty }}</td>
                    <td class="price">{{ number_format($item->sell_val,2,',','.') }}</td>
                    <td class="price">{{ number_format($item->vat,2,',','.') }}</td>
                    <td class="price">{{ number_format($item->subtotal,2,',','.') }}</td>
                </tr>
                @php 
                    }else{
                        $refund += $item->subtotal;
                    }
                @endphp
                @endforeach
                <tr>
                    <td style="text-align: right;" colspan="2">Total</td>
                    <td style="text-align: right;">{{ number_format($quote_sell,2,',','.')}}</td>
                    <td></td>
                    <td style="text-align: right;">{{ number_format($quote_val,2,',','.')}}</td>
                    <td style="text-align: right;">{{ number_format($quote_vat,2,',','.')}}</td>
                    <td style="text-align: right;">{{ number_format($quote_total,2,',','.')}}</td>
                </tr>
            </tbody>
        </table>
        <br/>
        <h4>C. Total</h4>
        <table width="100%" cellpadding="1" cellspacing="0" border="1" style="font-size: 12px;">
            <thead>
                <tr>
                    <th width="10%">Carrier</th>
                    <th width="15%">Roting</th>
                    <th width="5%">Transit Time</th>
                    <th width="15%">Sell</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profit as $item)
                <tr>
                    <td style="text-align: left">{{ $item->carrier_code }}</td>
                    <td style="text-align: left">{{ $item->routing }}</td>
                    <td style="text-align: center">{{ $item->transit_time }}</td>
                    <td class="price">{{ number_format($item->total_sell-$refund,2,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
	<body onLoad="document.title = 'Detail_Quotation';window.print()">
    </body>
</html>
