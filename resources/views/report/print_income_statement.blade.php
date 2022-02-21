@extends('layouts.report')

{{-- <style>
    .text-parent {
        font-weight: bold;
        text-decoration: underline;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

</style> --}}

@section('content')
    @php
    header('Content-Type:   application/vnd.ms-excel;');
    header('Content-Disposition: attachment; filename=laporan laba rugi '.tanggalIndo($start_date).' s.d '.tanggalIndo($end_date).'.xls');
    @endphp
    <table width="100%">
        <thead>
            <tr>
                <th>PT. DELTA MARINE CONTINENTS</th>
            </tr>
            <tr>
                <th>LAPORAN LABA RUGI</th>
            </tr>
            <tr>
                <th>{{ strtoupper(tanggalIndo($start_date)) }} S.D {{ strtoupper(tanggalIndo($end_date)) }}</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <table width="100%" style="border: 1px solid;" cellpadding="2" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="border-bottom: 1px solid;">No. Akun</th>
                                <th style="border-left: 1px solid; border-bottom: 1px solid;">Uraian</th>
                                <th style="border-left: 1px solid; border-bottom: 1px solid;">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_pendapatan = 0;
                                $total_hpp = 0;
                                $total_biaya_adm = 0;
                                $total_biaya_umum = 0;
                                $total_biaya_susut = 0;
                                $total_pendapatan_luar = 0;
                                $total_biaya_luar = 0;

                                $total_laba_kotor = 0;
                                $total_beban_operasional = 0;
                                $total_pendapatan_operasional = 0;
                                $total_laba_luar = 0;
                            @endphp
                            @foreach ($parent_account as $parent)
                                <tr>
                                    <td style="text-decoration: underline; font-weight: bold;">&nbsp;{{ $parent->account_number }}</td>
                                    <td style="text-decoration: underline; font-weight: bold; border-left: 1px solid; border-right: 1px solid;">{{ $parent->account_name }}</td>
                                    <td></td>
                                </tr>
                                @php
                                    $parent_balance = 0;
                                @endphp
                                @foreach ($parent->child_account as $child)
                                    @php
                                        $child_balance = $child->credit;
                                        if ($child->flag_pengeluaran == 1) {
                                            $child_balance = $child->debit;
                                        }

                                        $text_child_balance = number_format($child_balance, 2, '.', ',');
                                        if (substr($child->account_number, 0, 3) == '4-1' && $child->flag_pengeluaran == 1) {
                                            $text_child_balance = '(' . number_format($child_balance, 2, '.', ',') . ')';
                                        }

                                        $parent_balance += $child_balance;
                                    @endphp
                                    <tr>
                                        <td>&nbsp;{{ $child->account_number }}</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">{{ $child->account_name }}</td>
                                        <td style="text-align: right;">{{ $text_child_balance }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td style="font-weight: bold; border-left: 1px solid; border-right: 1px solid;"><b>TOTAL {{ $parent->account_name }}</b></td>
                                    <td style="text-align: right; font-weight: bold;">{{ number_format($parent_balance, 2, '.', ',') }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>

                                @php
                                    if (substr($parent->account_number, 0, 3) == '4-1') {
                                        $total_pendapatan += $parent_balance;
                                    } elseif (substr($parent->account_number, 0, 3) == '5-1') {
                                        $total_hpp += $parent_balance;
                                    } elseif (substr($parent->account_number, 0, 3) == '6-1') {
                                        $total_biaya_adm += $parent_balance;
                                    } elseif (substr($parent->account_number, 0, 3) == '6-2') {
                                        $total_biaya_umum += $parent_balance;
                                    } elseif (substr($parent->account_number, 0, 3) == '6-3') {
                                        $total_biaya_susut += $parent_balance;
                                    } elseif (substr($parent->account_number, 0, 3) == '7-1') {
                                        $total_pendapatan_luar += $parent_balance;
                                    } elseif (substr($parent->account_number, 0, 3) == '7-2') {
                                        $total_biaya_luar += $parent_balance;
                                    }
                                @endphp

                                @if ($parent->account_number == '5-1000')
                                    @php
                                        $total_laba_kotor = $total_pendapatan - $total_hpp;
                                    @endphp
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid;">LABA KOTOR</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid;">{{ number_format($total_laba_kotor, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif

                                @if ($parent->account_number == '6-3000')
                                    @php
                                        $total_beban_operasional = $total_biaya_adm + $total_biaya_umum + $total_biaya_susut;
                                        $total_pendapatan_operasional = $total_laba_kotor - $total_beban_operasional;
                                    @endphp
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid;">TOTAL BEBAN OPERASIONAL</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid;">{{ number_format($total_beban_operasional, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid;">PENDAPATAN OPERASIONAL</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid;">{{ number_format($total_pendapatan_operasional, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif

                                @if ($parent->account_number == '7-2000')
                                    @php
                                        $total_laba_luar = $total_pendapatan_luar - $total_biaya_luar;
                                    @endphp
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid;">TOTAL PENDAPATAN DILUAR USAHA</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid;">{{ number_format($total_laba_luar, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif
                            @endforeach
                            @php
                                $total_laba_bersih = $total_pendapatan_operasional + $total_laba_luar;
                            @endphp
                            <tr>
                                <td></td>
                                <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid;">LABA/RUGI BERSIH</td>
                                <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid;">{{ number_format($total_laba_bersih, 2, '.', ',') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        function loadChild() {

        }
    </script>
@endsection
