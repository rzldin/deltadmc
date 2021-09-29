<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VGM Certification</title>
    <style>
        .text-bottom {
            margin: 0;
            color: grey;
        }

        .mandatory{
            background-color: #C7EA46;
            font-size: 10pt;
            font-family: Calibri; 
        }
    </style>
</head>
<body>
    <h3 style="text-align: center"><b>Verified Gross Mass Weight Certification</b></h3>
    <br>
    <table width="100%" cellspacing="0" cellpadding="0" border="1">
        <thead>
            <tr style="text-align: center">
                <td colspan="6" style="background-color: #C7EA46">Mandatory</td>
                <td colspan="2">Optional</td>
            </tr>
            <tr style="text-align: center">
                <td class="mandatory">Booking No. <p class="text-bottom">(e.g. 11111111111)</p></td>
                <td class="mandatory">Container No. <p class="text-bottom">(e.g. EISU1234567)</p></td>
                <td class="mandatory">Verified Gross Mass <p class="text-bottom">(e.g. 21500)</p></td>
                <td class="mandatory">Unit Of Measurement <p class="text-bottom">(e.g. KG or LB)</p></td>
                <td class="mandatory">Responsible Party <p class="text-bottom">(e.g. XXX COMPANY)</p></td>
                <td class="mandatory">Authorized Person <p class="text-bottom">(e.g. JACKSON WU)</p></td>
                <td style="font-size: 10pt;">Method Of Weighing<p class="text-bottom">(e.g. 1 or 2)</p></td>
                <td style="font-size: 10pt;">Weighing Party<p class="text-bottom">(e.g. ABC COMPANY)</p></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr style="text-align: center; font-size:10pt;">
                <td>{{ $row->booking_no }}</td>
                <td>{{ $row->container_no }}</td>
                <td>{{ $row->vgm }}</td>
                <td>{{ $row->uom_code }}</td>
                <td>{{ $row->responsible_party }}</td>
                <td>{{ $row->authorized_person }}</td>
                <td>{{ $row->method_of_weighing }}</td>
                <td>{{ $row->weighing_party }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>