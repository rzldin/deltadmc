<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body class="margin-left:40px;">
        <table border="0" cellpadding="0" width="100%" cellspacing="0" style="font-family:Microsoft Sans Serif">
            <tr>
                <td width="44%">
                    <h4>Cost</h4>
                    <table width="100%" cellspacing="0" border="1" style="font-size: 7px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Service</th>
                                <th>Desc</th>
                                <th>Reimbursment</th>
                                <th>Unit</th>
                                <th>Currency</th>
                                <th>Rate/Unit</th>
                                <th>Total</th>
                                <th>Roe</th>
                                <th>Vat</th>
                                <th>Amount</th>
                                <th>Paid To</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shipping as $shp)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if ($quote->shipment_by == 'LAND')
                                <td>{{ $shp->truck_size }}</td>
                                @else
                                <td>{{ $shp->name_carrier }}</td> 
                                @endif
                                <td>{{ 'Notes '. $shp->notes.' | Routing: '.$shp->routing.' | Transit time : '.$shp->transit_time }}</td>
                                <td></td>
                                <td>{{ $shp->qty }}</td>
                                <td>{{ $shp->code_currency }}</td>
                                <td>{{ number_format($shp->cost_val,2,',','.') }}</td>
                                <td>{{ number_format(($shp->qty * $shp->cost_val),2,',','.') }}</td>
                                <td>{{ number_format($shp->rate,2,',','.') }}</td>
                                <td>{{ number_format($shp->vat,2,',','.') }}</td>
                                <td>{{ number_format((($shp->qty * $shp->cost_val) * $shp->rate) + $shp->vat,2,',','.') }}</td>
                                <td></td>
                            </tr>    
                            @endforeach
                            <?php $no = 2; ?>
                            @foreach ($sell_cost as $row)
                            <?php $total = ($row->qty * $row->cost_val); ?>
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->charge_name }}</td>
                                <td>{{ $row->desc.' | Routing: '.$row->routing.' | Transit time : '.$row->transit_time }}</td>
                                <td>
                                    <input type="checkbox" @if ($row->reimburse_flag == 1)
                                        checked
                                    @endif>
                                </td>
                                <td>{{ $row->qty }}</td>
                                <td>{{ $row->code_cur }}</td>
                                <td>{{ number_format($row->cost_val,2,',','.') }}</td>
                                <td>{{ number_format(($row->qty * $row->cost_val),2,',','.') }}</td>
                                <td>{{ number_format($row->rate,2,',','.') }}</td>
                                <td>{{ number_format($row->vat,2,',','.') }}</td>
                                <td>{{ number_format(($total * $row->rate) + $row->vat,2,',','.') }}</td>
                                <td>{{ $row->paid_to }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td width="2%"></td>
                <td width="44%">
                    <h4>Sell</h4>
                    <table width="100%" cellspacing="0" cellpading="0" border="1" style="font-size: 7px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Service</th>
                                <th>Desc</th>
                                <th>Reimbursment</th>
                                <th>Unit</th>
                                <th>Currency</th>
                                <th>Rate/Unit</th>
                                <th>Total</th>
                                <th>Roe</th>
                                <th>Vat</th>
                                <th>Amount</th>
                                <th>Bill To</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shipping as $shp)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if ($quote->shipment_by == 'LAND')
                                <td>{{ $shp->truck_size }}</td>
                                @else
                                <td>{{ $shp->name_carrier }}</td> 
                                @endif
                                <td>{{ 'Notes '. $shp->notes.' | Routing: '.$shp->routing.' | Transit time : '.$shp->transit_time }}</td>
                                <td></td>
                                <td>{{ $shp->qty }}</td>
                                <td>{{ $shp->code_currency }}</td>
                                <td>{{ number_format($shp->sell_val,2,',','.') }}</td>
                                <td>{{ number_format(($shp->qty * $shp->sell_val),2,',','.') }}</td>
                                <td>{{ number_format($shp->rate,2,',','.') }}</td>
                                <td>{{ number_format($shp->vat,2,',','.') }}</td>
                                <td>{{ number_format((($shp->qty * $shp->sell_val) * $shp->rate) + $shp->vat,2,',','.') }}</td>
                                <td></td>
                            </tr>    
                            @endforeach
                            <?php $no = 2; ?>
                            @foreach ($sell_cost as $row)
                            <?php $total = ($row->qty * $row->sell_val); ?>
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->charge_name }}</td>
                                <td>{{ $row->desc.' | Routing: '.$row->routing.' | Transit time : '.$row->transit_time }}</td>
                                <td>
                                    <input type="checkbox" @if ($row->reimburse_flag == 1)
                                        checked
                                    @endif>
                                </td>
                                <td>{{ $row->qty }}</td>
                                <td>{{ $row->code_cur }}</td>
                                <td>{{ number_format($row->sell_val,2,',','.') }}</td>
                                <td>{{ number_format(($row->qty * $row->sell_val),2,',','.') }}</td>
                                <td>{{ number_format($row->rate,2,',','.') }}</td>
                                <td>{{ number_format($row->vat,2,',','.') }}</td>
                                <td>{{ number_format(($total * $row->rate) + $row->vat,2,',','.') }}</td>
                                <td>{{ $row->bill_to }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        
        <p>&nbsp;</p>
	<body onLoad="window.print()">
    </body>
</html>
        