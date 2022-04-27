<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body class="margin-left:40px;">
        <p>&nbsp;</p>
        <table border="0" cellpadding="2" cellspacing="0" width="900px" style="font-family:Microsoft Sans Serif">
            <tr>
                <td width="50%">
                    <h1>DELTA DMC</h1>
                </td>
                <td>&nbsp;</td>
                <td width="50%">
                    <table border="0" cellpadding="2" cellspacing="1" width="100%">
                        <tr>
                            <td>PT. DELTA MARINE CONTINENTS</td>
                        </tr>
                        <tr>
                            <td>RUKAN SENTRA NIAGA BLOK B NO.3</td>
                        </tr>
                        <tr>
                            <td>JL. GREEN LAKE CITY BOULEVARD</td>
                        </tr>
                        <tr>
                            <td>DURI KOSAMBI, JAKARTA BARAT 11750</td>
                        </tr>
                        <tr>
                            <td>TEL: +62 21 5437 6387 FAX: +62 21 5437 6387</td>
                        </tr>
                        <tr>
                            <td>Website: www.delta-dmc.com</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr>
        <table border="0" cellpadding="2" cellspacing="0" width="900px">
            <tr>
                <td colspan="2" style="text-align: center;"><h3>INVOICE</h3></td>
            </tr>
            <tr>
                <td width="50%">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td>BILL TO :</td>
                        </tr>
                        <tr>
                            <td>{{ $header->client_name }}</td>
                        </tr>
                        <tr>
                            <td>{{ $header->address }}</td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td>JOB NO. </td>
                            <td>:</td>
                            <td>BLABLABLA</td>
                        </tr>
                        <tr>
                            <td>TOP </td>
                            <td>:</td>
                            <td>{{ $header->top }}</td>
                        </tr>
                        <tr>
                            <td>ISSUE DATE</td>
                            <td>:</td>
                            <td>{{ date('d/m/Y', strtotime($header->invoice_date)) }}</td>
                        </tr>
                        <tr>
                            <td>INVOICE NO. </td>
                            <td>:</td>
                            <td>{{ $header->invoice_no }}</td>
                        </tr>
                        <tr>
                            <td>MB/L NO. </td>
                            <td>:</td>
                            <td>{{ $header->mbl_no }}</td>
                        </tr>
                        <tr>
                            <td>VESSEL NO. </td>
                            <td>:</td>
                            <td>{{ $header->vessel }}</td>
                        </tr>
                        <tr>
                            <td>M.VESSEL NO. </td>
                            <td>:</td>
                            <td>{{ $header->m_vessel }}</td>
                        </tr>
                        <tr>
                            <td>LOADING </td>
                            <td>:</td>
                            <td>{{ $header->pol_name }}</td>
                        </tr>
                        <tr>
                            <td>DESTINATION </td>
                            <td>:</td>
                            <td>{{ $header->pod_name }}</td>
                        </tr>
                        <tr>
                            <td>ON BOARD DATE </td>
                            <td>:</td>
                            <td>{{ date('d/m/Y', strtotime($header->onboard_date)) }}</td>
                        </tr>
                        <tr>
                            <td>SI NO. </td>
                            <td>:</td>
                            <td>BLABLABLA</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td>MB/L :</td>
                            <td>{{ $header->mbl_no }}</td>
                        </tr>
                        <tr>
                            <td>CONTAINER :</td>
                            <td>BLABLABLA</td>
                        </tr>
                        <tr>
                            <td>GOODS :</td>
                            <td></td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
            </tr>
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
                            <td style="text-align:center; border:1px solid #000" width="20%"><strong>AMOUNT</strong></td>
                        </tr>
                        <?php
                            $total_amount = 0;
                            $total_amount_idr = 0;
                            foreach ($details as $row){
                                $total_idr = $row->qty * $row->sell * $row->rate;
                                $subtotal = $row->qty * $row->sell;
                        ?>
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000;"><?=$row->charge_name;?></td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000;"><?='TERM';?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000;"><?=$row->qty;?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000;">IDR </td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000;"><?=number_format($row->sell,2,',','.');?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000;"><?=number_format($row->sell_val,2,',','.');?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000;"><?=number_format($row->rate,2,',','.');?></td>
                            <td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;"><?=number_format($subtotal,2,',', '.');?></td>
                        </tr>
                        <?php
                            $total_amount_idr += $total_idr;
                            $total_amount += $subtotal;
                            }
                        ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="50%">TOTAL AMOUNT</td>
                <td width="50%" style="text-align: right; padding-right: 5%;"><strong><?=number_format($total_amount,2,',','.');?></strong></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td width="20%">SAY</td>
                            <td width="5%">{{ ($header->currency_code == 'IDR')? "USD" : $header->currency_code }}</td>
                            <td width="75%">{{ ($header->currency_code == 'IDR')? '':Terbilang::make($total_amount) }}</td>
                        </tr>
                        <tr>
                            <td width="20%"></td>
                            <td width="5%">IDR</td>
                            <td width="75%">{{ Terbilang::make($total_amount_idr) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="height: 100px;"></td>
            </tr>
            <tr>
                <td>PLEASE TRANSFER PAYMENT IN FULL AMOUNT TO:</td>
                <td style="text-align: right; padding-right: 8%;">SINCERELY</td>
            </tr>
            <tr>
                <td colspan="2">PT. DELTA MARINE CONTINENTS</td>
            </tr>
            <tr>
                <td colspan="2">BANK BCA.</td>
            </tr>
            <tr>
                <td colspan="2">KCU PURI INDAH</td>
            </tr>
            <tr>
                <td colspan="2">JAKARTA BARAT- INDONESIA</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">A/C USD : 288-388-0081</td>
            </tr>
            <tr>
                <td>A/C IDR : 288-388-0005</td>
                <td style="text-align: right;"><u>DELTA MARINE CONTINENTS</u></td>
            </tr>
            <tr>
                <td>SWIFT CODE : CENAIDJA</td>
                <td style="text-align: right; padding-right: 5%;">Authorized Signature</td>
            </tr>
        </table>
        <p>&nbsp;</p>
    <body onLoad="window.print()">
    </body>
</html>
        