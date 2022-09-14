<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SJ TRUCKING</title>
    <style>

        .text-container p {
            margin: 0px;
        }

        .nama-pt {
            font-size: 20px;
            margin: 0px;
        }

        .alamat {
            font-size: 14px;
            margin: 0px;
        }

    </style>
</head>
<body>
    <table width="100%">
        <tr>
            <td width="40%">
                <img src="{{ public_path('admin/dist/img/DMC.jpg') }}" width="160" height="150" style="margin-left: 90px;">
            </td>
            <td width="60%">
                <p class="nama-pt">PT. DELTA MARINE CONTINENTS</p>
                <p class="alamat">RUKAN SENTRA NIAGA BLOK B NO. 3 </p>
                <p class="alamat">JL. GREEN LAKE CITY BOULEVARD,</p>
                <p class="alamat">DURI KOSAMBI, JAKARTA BARAT 11750</p>
                <p class="alamat">TEL : +62 21 5437-6387 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FAX : +62 21 5437-6387</p>
                <p class="alamat">Website : <a href="www.delta-dmc.com">www.delta-dmc.com</a> </p>
            </td>
        </tr>
    </table>
    <table width="100%" style="border-top: 1 solid #000;text-align:center;vertical-align:top;">
        <tr>
            <td style="font-size: 18px;"><b>SURAT JALAN</b></td>
        </tr>
    </table>
    <br>
    <br>
    <table width="100%">
        <tr>
            <td width="50%">
                <table width="100%" style="border: 1 solid #000;">
                    <tr>
                        <td style="vertical-align:top;" height="100">
                            <b>DARI : <br>
                            {!! ucwords(nl2br($data[0]->pickup_addr)) !!}
                            </b>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table width="100%">
                    <tr style="vertical-align: top;">
                        <td width="40%">
                           No
                        </td>
                        <td width="5%">
                            :
                        </td>
                        <td width="55%">
                            {{ $data[0]->no_sj }}
                        </td>
                    </tr>
                    <tr style="vertical-align: top;">
                        <td width="40%">
                           No. Mobil
                        </td>
                        <td width="5%">
                            :
                        </td>
                        <td width="55%">
                            {{ $data[0]->vehicle_no }}
                        </td>
                    </tr>
                    <tr style="vertical-align: top;">
                        <td width="40%">
                           Jenis Mobil
                        </td>
                        <td width="5%">
                            :
                        </td>
                        <td width="55%">
                            {{ $data[0]->type }}
                        </td>
                    </tr>
                    <tr style="vertical-align: top;">
                        <td width="40%">
                           Nama Supir
                        </td>
                        <td width="5%">
                            :
                        </td>
                        <td width="55%">
                            {{ $data[0]->driver }}
                        </td>
                    </tr>
                    <tr style="vertical-align: top;">
                        <td width="40%">
                           No Tlp
                        </td>
                        <td width="5%">
                            :
                        </td>
                        <td width="55%">
                            {{ $data[0]->driver_phone }}
                        </td>
                    </tr>
                    <tr style="vertical-align: top;">
                        <td width="40%">
                           Container/ Seal No.
                        </td>
                        <td width="5%">
                            :
                        </td>
                        <td width="55%">
                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%">
                <table width="50%" style="border: 1 solid #000;">
                    <tr>
                        <td style="vertical-align:top;" height="100">
                            <b>KEPADA : <br>
                            {!! ucwords(nl2br($data[0]->delivery_addr)) !!}
                            </b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th style="text-align: center;">
                    PKGS
                </th>
                <th style="text-align: center;">
                    PCS
                </th>
                <th style="text-align: center;">
                    NAMA BARANG
                </th>
                <th>
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tr>
                            <th colspan="2" style="text-align: center;border-bottom:1 solid #000;">
                                SATUAN
                            </th>
                        </tr>
                        <tr>
                            <th width="50%" style="text-align: center;border-right:1 solid #000">KGS</th>
                            <th width="50%" style="text-align: center;">CBM</th>
                        </tr>
                    </table>
                </th>
                <th style="text-align: center">
                    KETERANGAN
                </th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $kgs = 0;
                $cbm = 0;
            ?>
            @foreach ($barang as $item)
{{--             <?php $qty_kgs = ''; $qty_cbm = ''; if($item->qty_uom == 1){
                $qty_kgs = $item->qty;
            }else{
                $qty_cbm = $item->qty;
            }?> --}}
            <?php 
                $kgs += $item->qty;
                $cbm += $item->cbm;
            ?>
            <tr>
                <td style="text-align: center;">
                    {{ $item->pkgs }}
                </td>
                <td style="text-align: center;">
                    {{ $item->ctn }}
                </td>
                <td style="text-align: center;">
                    {{ $item->desc }}
                </td>
                <td>
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="50%" style="text-align: center;border-right:1 solid #000" height="25">{{ $item->qty }}</td>
                            <td width="50%" style="text-align: center;">{{ $item->cbm }}</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center">
                    {{ $item->keterangan }}
                </td>
            </tr>
            <?php if($item->qty_uom == 1) {
                $kgs += $item->qty; 
            }else{
                $cbm += $item->qty;
            }?>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: center;"><b>TOTAL</b></td>
                <td>
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="50%" style="text-align: center;border-right:1 solid #000" height="25">
                                @if ($kgs != 0)
                                {{ $kgs }}
                                @else

                                @endif
                            </td>
                            <td width="50%" style="text-align: center;">
                                @if ($cbm != 0)
                                {{ $cbm }}
                                @else

                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center">
                    
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td width="50%">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50%" style="border-top: 1 solid #000;border-bottom: 1 solid #000;border-top: 1 solid #000;border-left: 1 solid #000;border-right: 1 solid #000;text-align: center">PENGIRIM</td>
                        <td width="50%" style="text-align: center;border-top: 1 solid #000;border-bottom: 1 solid #000;border-top: 1 solid #000;border-right: 1 solid #000;">PENERIMA</td>
                    </tr>
                </table>
            </td>
            <td width="5%"></td>
            <td width="45%">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%" style="border-top: 1 solid #000;border-bottom: 1 solid #000;border-top: 1 solid #000;border-left: 1 solid #000;border-right: 1 solid #000;text-align: left; padding-left:2px;">CATATAN :</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td width="50%">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="50%" height="80" style="border-bottom: 1 solid #000;border-right: 1 solid #000;border-left: 1 solid #000;vertical-align:bottom;text-align:center;font-size:10pt;">NAMA JELAS</td>
                        <td width="50%" style="border-bottom: 1 solid #000;border-right: 1 solid #000;vertical-align:bottom;text-align:center;font-size:10pt;">NAMA JELAS, CAP & TGL</td>
                    </tr>
                </table>
            </td>
            <td width="5%"></td>
            <td width="45%">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="100%" height="80" style="border-bottom: 1 solid #000;border-right: 1 solid #000;vertical-align:bottom;text-align:center;border-left: 1 solid #000;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table width="100%" width="100%" cellspacing="0" cellpadding="0" style="line-height: 25px">
        <tr>
            <td width="30%" style="border-right:1 solid #000 ;border-left:1 solid #000;border-bottom:1 solid #000;border-top:1 solid #000;">
                <b>Tgl. Keberangkatan</b>
            </td>
            <td width="20%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;border-top:1 solid #000;">&nbsp;:</td>
            <td width="20%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;border-top:1 solid #000;"><b>Waktu</b></td>
            <td width="30%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;border-top:1 solid #000;">&nbsp;:</td>
        </tr>
        <tr>
            <td width="30%" style="border-right:1 solid #000 ;border-left:1 solid #000;border-bottom:1 solid #000;">
                <b>Tgl. Tiba</b>
            </td>
            <td width="20%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;">&nbsp;:</td>
            <td width="20%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;"><b>Waktu</b></td>
            <td width="30%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;">&nbsp;:</td>
        </tr>
        <tr>
            <td width="30%" style="border-right:1 solid #000 ;border-left:1 solid #000;border-bottom:1 solid #000;">
                <b>Tgl. Bongkar / Muat</b>
            </td>
            <td width="20%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;">&nbsp;:</td>
            <td width="20%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;"><b>Waktu</b></td>
            <td width="30%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;">&nbsp;:</td>
        </tr>
        <tr>
            <td width="30%" style="border-right:1 solid #000 ;border-left:1 solid #000;border-bottom:1 solid #000;">
                <b>Tgl. Selesai Bongkar / Muat</b>
            </td>
            <td width="20%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;">&nbsp;:</td>
            <td width="20%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;"><b>Waktu</b></td>
            <td width="30%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;">&nbsp;:</td>
        </tr>
        <tr>
            <td width="30%" style="border-right:1 solid #000 ;border-left:1 solid #000;border-bottom:1 solid #000;">
                <b>Tgl. Masuk / Keluar Depo</b>
            </td>
            <td width="20%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;">&nbsp;:</td>
            <td width="20%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;"><b>Waktu</b></td>
            <td width="30%" style="border-right:1 solid #000 ;border-bottom:1 solid #000;">&nbsp;:</td>
        </tr>
    </table>
</body>
</html>