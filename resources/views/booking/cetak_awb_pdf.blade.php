<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HAWB</title>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td width="50%">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="vertical-align:top;" height="80">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;" height="30">
                                        @if ($booking->hbl_shipper != null)
                                            <p style="padding-top:5px;">
                                                {!! $booking->hbl_shipper !!}
                                            </p>
                                        @else
                                            <p style="padding-top:5px;">
                                                {{ $booking->company_f }}<br>
                                                {{ $booking->address_f }}<br>
                                                {{ $booking->pic_f }}
                                            </p>
                                        @endif
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;" height="20">
                                        @if ($booking->hbl_shipper == null)
                                            <p>{{ $booking->code_company_f }}</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td height="50" colspan="2">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;" height="80">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;" height="30">
                                        @if ($booking->hbl_consignee != null)
                                            <p style="padding-top:5px;">
                                                {!! $booking->hbl_consignee !!}
                                            </p>
                                        @else
                                            <p style="padding-top:5px;">
                                                {{ $booking->company_i }}<br>
                                                {{ $booking->address_i }}<br>
                                                {{ $booking->pic_i }}
                                            </p>
                                        @endif
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;" height="20">
                                        @if ($booking->hbl_consignee == null)
                                            <p>{{ $booking->code_company_i }}</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="" height="50" colspan="2">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;" height="90">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td colspan="6" style="font-size:6pt;vertical-align:top;" height="45">
                                        Issuing Carrier's Agent Name and City
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="font-size:6pt;vertical-align:top;" height="25">
                                        Agent's IATA Code
                                    </td>
                                    <td colspan="3" style="font-size:6pt;vertical-align:top;" height="25">
                                        Account No.
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="font-size:6pt;vertical-align:top;" height="24" width="10">
                                        <p>{{ $booking->name_carrier }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:8pt;vertical-align:top;" height="24" width="10">
                                        &nbsp;
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;" height="24" width="50">
                                        By first Carrier (Routing and Destination)
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;" height="24" width="10">
                                        to
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;" height="24" width="10">
                                        by
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;" height="24" width="10">
                                        to
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;" height="24" width="10">
                                        by
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-size:6pt;vertical-align:top;" height="24">
                                        Airport Of Destination
                                    </td>
                                    <td colspan="2" style="font-size:6pt;vertical-align:top;" height="24">
                                        Flight/Date
                                    </td>
                                    <td colspan="2" style="font-size:6pt;vertical-align:top;" height="24">
                                        Flight/Date
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
                        <td style="vertical-align:top;" height="80" colspan="5">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:8pt;vertical-align:top;padding-left:5px;" height="64">
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:7pt;padding-left:5px;" height="15">
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;" height="80" colspan="5">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td height="80">
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="font-size:6pt;vertical-align:top;" height="95">
                            Accounting Information
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size:5pt;vertical-align:top;padding-left:5px;" height="24" width="5">
                            Currency
                        </td>
                        <td style="font-size:5pt;vertical-align:top;padding-left:5px;" height="24" width="5">
                            Chgs. Code
                        </td>
                        <td style="font-size:5pt;vertical-align:top;" height="24" width="40">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:5pt;vertical-align:top;padding-left:5px;">
                                        WT/VAL
                                    </td>
                                    <td style="font-size:5pt;vertical-align:top;padding-left:5px;">
                                        OTHER
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:5pt;vertical-align:top;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:1px solid #000;" height="17">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="font-size:4pt;vertical-align:top;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:1px solid #000;" height="17">
                                                    PPO
                                                </td>
                                                <td style="font-size:4pt;vertical-align:top;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:1px solid #000;" height="17">
                                                    COLL
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="font-size:5pt;vertical-align:top;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:1px solid #000;" height="17">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="font-size:4pt;vertical-align:top;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:1px solid #000;" height="17">
                                                    PPO
                                                </td>
                                                <td style="font-size:4pt;vertical-align:top;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:1px solid #000;" height="17">
                                                    COLL
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="font-size:5pt;vertical-align:top;" height="24" width="25">
                            Declared Value for Carriage
                        </td>
                        <td style="font-size:5pt;vertical-align:top;" height="24" width="25">
                            Declared Value for Customs
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-size:6pt;vertical-align:top;" height="24">
                            Ammount of Insurance
                        </td>
                        <td colspan="3" style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:1px solid #000; border-top:0px solid #000; border-right:0px solid #000;" height="24">
                            INSURANCE. - if Carrier offers Insurance, and such Insurance is requested in accordance with conditions on reverse here of indicate amount to be insured in figures in box marked "Amount of Insurance."
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size:7pt;vertical-align:top;border-left:0px solid #000; border-bottom:1px solid #000; border-top:0px solid #000; border-right:0px solid #000;" height="30" width="100%">
                Handling Information
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size:7pt;vertical-align:top;" width="100%">
                <table width="100%" cellspacing="0" cellpadding="0" height="170">
                    <thead>
                        <tr>
                            <td style="font-size:6pt;vertical-align:top;width:5%;text-align:center;">No. of Pieces RCP</td>
                            <td style="font-size:7pt;vertical-align:top;width:10%;text-align:center;">Gross <br>Weight</td>
                            <td style="font-size:7pt;vertical-align:top;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:1px solid #000;width:1%;">kg <br>lb</td>
                            <td style="font-size:7pt;vertical-align:top;width:1%;background-color:#808080;">&nbsp;</td>
                            <td style="font-size:7pt;vertical-align:top;width:10%;">
                                <table width="100%" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="2" style="padding-left: 10px;">
                                            Rate Class
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td style="width:1%;">
                                                        &nbsp;
                                                    </td>
                                                    <td style="font-size:6pt;vertical-align:top;border-left:1px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:0px solid #000;width:99%;">
                                                        Commodity Item No.
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="font-size:7pt;vertical-align:top;width:1%;background-color:#808080;">&nbsp;</td>
                            <td style="font-size:7pt;vertical-align:top;width:10%;text-align:center;">Chargeable<br>Weight</td>
                            <td style="font-size:7pt;vertical-align:top;width:1%;background-color:#808080;">&nbsp;</td>
                            <td style="font-size:7pt;vertical-align:top;width:10%;text-align:center;">Rate/Charge</td>
                            <td style="font-size:7pt;vertical-align:top;width:1%;background-color:#808080;">&nbsp;</td>
                            <td style="font-size:7pt;vertical-align:top;width:10%;text-align:center;">Total</td>
                            <td style="font-size:7pt;vertical-align:top;width:1%;background-color:#808080;">&nbsp;</td>
                            <td style="font-size:7pt;vertical-align:top;text-align:center;">Nature and Quantity of Goods <br>(Incl. Dimensions or Volume)</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;" height="170">
                                
                            </td>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;">
                                
                            </td>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;">
                                &nbsp;
                            </td>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:1px solid #000;background-color:#808080;">
                                &nbsp;
                            </td>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;">
                                <table>
                                    <tr>
                                        <td style="width: 1%;border-right:1px solid #000;height:170;">&nbsp;</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;background-color:#808080;">
                                &nbsp;
                            </td>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;">
                                
                            </td>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;background-color:#808080;">
                                &nbsp;
                            </td>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;">
                                
                            </td>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;background-color:#808080;">
                                &nbsp;
                            </td>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;">
                                
                            </td>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;background-color:#808080;">
                                &nbsp;
                            </td>
                            <td style="font-size:7pt;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;">
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td width="35%">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="vertical-align:top;border:1px solid #000;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:1px solid #000; border-top:0px solid #000; border-right:0px solid #000;text-align:center;">
                                        Prepaid
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:1px solid #000; border-bottom:1px solid #000; border-top:0px solid #000; border-right:0px solid #000;text-align:right;">
                                        Weight
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:2px;">
                                        Charge
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:1px solid #000; border-bottom:1px solid #000; border-top:0px solid #000; border-right:1px solid #000;text-align:center;">
                                        Collect
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-right:1px solid #000;height:20;" colspan="2">&nbsp;</td>
                                    <td style="border-right:0px solid #000;" colspan="2">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;border:1px solid #000;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:1px solid #000; border-top:0px solid #000; border-right:0px solid #000;text-align:center;" colspan="2">
                                        Valuation Charge
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-right:1px solid #000;height:20;">&nbsp;</td>
                                    <td style="border-right:0px solid #000;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;border:1px solid #000;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:1px solid #000; border-top:0px solid #000; border-right:0px solid #000;text-align:center;" colspan="2">
                                        Tax
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-right:1px solid #000;height:20;">&nbsp;</td>
                                    <td style="border-right:0px solid #000;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;border:1px solid #000;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:1px solid #000; border-top:0px solid #000; border-right:0px solid #000;text-align:center;" colspan="2">
                                        Total Other Charges Due Agent
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-right:1px solid #000;height:20;">&nbsp;</td>
                                    <td style="border-right:0px solid #000;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;border:1px solid #000;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="border-right:0px solid #000;height:20;background-color:#808080;">&nbsp;</td>
                                    <td style="border-right:0px solid #000;background-color:#808080;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;border:1px solid #000;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;text-align:center;width:50%;">
                                        Total Prepaid
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:1px solid #000; border-top:0px solid #000; border-right:0px solid #000;text-align:center;width:50%;">
                                        Total Collect
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-right:1px solid #000;height:20;">&nbsp;</td>
                                    <td style="border-right:0px solid #000;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;border:1px solid #000;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;text-align:center;width:50%;">
                                        Currency Conversion Rates
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:1px solid #000; border-top:0px solid #000; border-right:0px solid #000;text-align:center;width:50%;">
                                        cc Charges in Dest. Currency
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-right:1px solid #000;height:20;">&nbsp;</td>
                                    <td style="border-right:0px solid #000;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;border:1px solid #000;" height="25">
                            <table width="100%" cellspacing="0" cellpadding="0" height="25">
                                <tr>
                                    <td style="height:25;font-size:6pt;vertical-align:center;padding-left:5px;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:1px solid #000;text-align:center;width:50%;" rowspan="1">
                                        <b>For Carrier's Use Only <br> At Destination</b>
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:1px solid #000; border-top:0px solid #000; border-right:0px solid #000;text-align:center;width:50%;">
                                        Charges at destination
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="65%">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="vertical-align:top;border:1px solid #000;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:0px solid #000;text-align:left;">
                                        Other Charges
                                    </td>
                                <tr>
                                    <td style="height:20;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;border:1px solid #000;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:0px solid #000;">
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:20;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;border:1px solid #000;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:0px solid #000;text-align:center;">
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:20;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;text-align:center;" colspan="2">
                                        Shipper certifies that the particulars on the face here of are correct and that INSOFAR AS ANY PART OF THE CONSIGMENT CONTAINS DANGEROUS GOODS. SUCH PART IS PROPERTY DESCRIBED BY NAME AND IS IN PROPER CONDITION FOR CARRIAGE BY AIR ACCORDING TO THE APPLICABLE DANGEROUS GOODS REGULATIONS.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size:6pt;vertical-align:center;text-align:center;border:0px;border-top: 0px solid #000;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="border-right:0px solid #000;height:20;text-align:center;border-top: 0px solid #000;">Signature of shipper or his Agent</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top; solid #000;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:0px solid #000; border-top:1px solid #000; border-right:1px solid #000;text-align:center;width:50%;">
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-right:1px solid #000;height:20;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:bottom;font-size:6pt;text-align:center;" height="20">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:1px solid #000;text-align:center;width:50%;" colspan="5">
                                       &nbsp;
                                    </td>
                                </tr>
                                <tr style="text-align:center;">
                                    <td style="height:20;">Executed on</td>
                                    <td>(Date)</td>
                                    <td>at</td>
                                    <td>(Place)</td>
                                    <td>Signature Of issuing Carrier or its Agent</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;border:1px solid #000;" height="25">
                            <table width="100%" cellspacing="0" cellpadding="0" height="25">
                                <tr>
                                    <td style="height:25;font-size:6pt;vertical-align:center;padding-left:5px;border-left:0px solid #000; border-bottom:0px solid #000; border-top:0px solid #000; border-right:1px solid #000;text-align:center;width:50%;" rowspan="1">
                                        Total Collect Charges
                                    </td>
                                    <td style="font-size:6pt;vertical-align:top;padding-left:5px;border-left:0px solid #000; border-bottom:1px solid #000; border-top:0px solid #000; border-right:0px solid #000;text-align:center;width:50%;">
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>