<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body class="margin-left:40px;">
        <table border="0" cellpadding="2" cellspacing="0" width="900px">
            <tr>
                <td colspan="2">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>DESCRIPTION</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>TERM</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>UNIT</strong></td>
                            <td colspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>RATE/UNIT</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>TOTAL</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>ROE</strong></td>
                            <td style="text-align:center; border:1px solid #000"><strong>AMOUNT</strong></td>
                            <td style="text-align:center; border:1px solid #000"><strong>AMOUNT (IDR)</strong></td>
                        </tr>
                        <?php
                            $total_amount = 0;
                            $total_amount_idr = 0;
                            foreach ($details as $row){
                                $total_idr = (($row->qty * $row->cost) + $row->cost_adjustment) * $row->rate;
                                $subtotal = $row->qty * $row->cost + $row->cost_adjustment;
                        ?>
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000;"><?=$row->charge_name;?></td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000;"><?='TERM';?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000;"><?=$row->qty;?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000;">IDR </td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000;"><?=number_format($row->cost,2,',','.');?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000;"><?=number_format($row->cost_val,2,',','.');?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000;"><?=number_format($row->rate,2,',','.');?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;"><?=(($row->cost_adjustment==0)? '':'('.number_format($row->cost_adjustment,2,',','.').')').' '.number_format($subtotal,2,',', '.');?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;"><?=number_format($total_idr,2,',', '.');?></td>
                        </tr>
                        <?php
                            $total_amount_idr += $total_idr;
                            $total_amount += $subtotal;
                            }
                        ?>
                        <tr>
                            <td>TOTAL</td>
                            <td colspan="6"></td>
                            <td><?=number_format($total_amount,2,',','.');?></td>
                            <td><?=number_format($total_amount_idr,2,',','.');?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>DESCRIPTION</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>ROE</strong></td>
                            <td style="text-align:center; border:1px solid #000"><strong>AMOUNT</strong></td>
                            <td style="text-align:center; border:1px solid #000"><strong>AMOUNT (IDR)</strong></td>
                        </tr>
                        <?php
                            $pmb_amount = 0;
                            $pmb_amount_idr = 0;
                            foreach ($pembayaran as $row){
                                $pmb_idr = $row->kurs * $row->nilai;
                        ?>
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000;"></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000;"><?=number_format($row->kurs,2,',','.');?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;"><?=number_format($row->nilai,2,',', '.');?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;"><?=number_format($pmb_idr,2,',', '.');?></td>
                        </tr>
                        <?php
                            $pmb_amount_idr += $pmb_idr;
                            $pmb_amount += $row->nilai;
                            }
                        ?>
                        <tr>
                            <td>TOTAL</td>
                            <td></td>
                            <td><?=number_format($pmb_amount,2,',','.');?></td>
                            <td><?=number_format($pmb_amount_idr,2,',','.');?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>SELISIH</td>
                @php $selisih = $total_amount_idr - $pmb_amount_idr; @endphp
                <td style="text-align: right;"><?=number_format($selisih,2,',','.');?></td>
            </tr>
        </table>
        <p>&nbsp;</p>
    <body onLoad="window.print()">
    </body>
</html>
        