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
    header('Content-Disposition: attachment; filename=laporan neraca '.tanggalIndo($start_date).' s.d '.tanggalIndo($end_date).'.xls');
    @endphp
    <table width="100%">
        <thead>
            <tr>
                <th>PT. DELTA MARINE CONTINENTS</th>
            </tr>
            <tr>
                <th>LAPORAN NERACA</th>
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
                                $total_kas = 0;
                                $total_bank = 0;
                                $total_persediaan = 0;
                                $total_uang_muka_pajak = 0;
                                $total_biaya_dibayar_dimuka = 0;
                                $total_aset_lancar_lain = 0;

                                $total_kas_dan_bank = 0;
                                $total_piutang_usaha = 0;
                                $total_aset_lancar_lainnya = 0;
                                // $total_nilai_buku = 0;
                                // $total_akumulasi_penyusutan = 0;
                                $total_hutang_usaha = 0;
                                $total_hutang_pajak = 0;
                                $total_hutang_jangka_panjang = 0;

                                $total_aset_lancar = 0;
                                $total_aset_tetap = 0;
                                $total_aset_lainnya = 0;
                                $total_hutang = 0;
                                $tota_modal = 0;

                                $total_aset = 0;
                                $total_hutang_dan_modal = 0;
                            @endphp

                            <tr>
                                <td style="text-decoration: underline; font-weight: bold;"></td>
                                <td style="font-weight: bold; border-left: 1px solid; border-right: 1px solid;">ASET (AKTIVA)</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="text-decoration: underline; font-weight: bold;"></td>
                                <td style="text-decoration: underline; font-weight: bold; border-left: 1px solid; border-right: 1px solid;">ASET LANCAR</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style=""></td>
                                <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                <td></td>
                            </tr>

                            @foreach ($parent_account_aset_lancar as $parent)
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

                                        $parent_balance += $child_balance;
                                    @endphp
                                    <tr>
                                        <td>&nbsp;{{ $child->account_number }}</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">{{ $child->account_name }}</td>
                                        <td style="text-align: right;">{{ $text_child_balance }}</td>
                                    </tr>
                                @endforeach
                                @php
                                    if (substr($parent->account_number, 0, 3) == '1-1') {
                                        $total_kas += $parent_balance;
                                    } else if (substr($parent->account_number, 0, 4) == '1-11') {
                                        $total_bank += $parent_balance;
                                    } else if (substr($parent->account_number, 0, 4) == '1-12') {
                                        $total_piutang_usaha += $parent_balance;
                                    } else if (substr($parent->account_number, 0, 4) == '1-13') {
                                        $total_persediaan += $parent_balance;
                                    } else if (substr($parent->account_number, 0, 4) == '1-14') {
                                        $total_uang_muka_pajak += $parent_balance;
                                    } else if (substr($parent->account_number, 0, 4) == '1-15') {
                                        $total_biaya_dibayar_dimuka += $parent_balance;
                                    } else if (substr($parent->account_number, 0, 4) == '1-20') {
                                        $total_aset_lancar_lain += $parent_balance;
                                    }
                                @endphp
                                {{-- <tr>
                                    <td></td>
                                    <td style="font-weight: bold; border-left: 1px solid; border-right: 1px solid;"><b>TOTAL {{ $parent->account_name }}</b></td>
                                    <td style="text-align: right; font-weight: bold;">{{ number_format($parent_balance, 2, '.', ',') }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr> --}}


                                @if ($parent->account_number == '1-1100')
                                    @php
                                        $total_kas_dan_bank = $total_kas + $total_bank;
                                    @endphp
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL KAS DAN BANK</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_kas_dan_bank, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif

                                @if ($parent->account_number == '1-1200')
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL PIUTANG USAHA</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_piutang_usaha, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif

                                @if ($parent->account_number == '1-2000')
                                    @php
                                        $total_aset_lancar_lainnya = $total_persediaan + $total_uang_muka_pajak + $total_biaya_dibayar_dimuka + $total_aset_lancar_lain;
                                        $total_aset_lancar = $total_kas_dan_bank + $total_piutang_usaha + $total_aset_lancar_lainnya;
                                    @endphp
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL ASET LANCAR LAINNYA</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_aset_lancar_lainnya, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL ASET LANCAR</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_aset_lancar, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif

                            @endforeach

                            <tr>
                                <td style="text-decoration: underline; font-weight: bold;"></td>
                                <td style="text-decoration: underline; font-weight: bold; border-left: 1px solid; border-right: 1px solid;">ASET TETAP</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style=""></td>
                                <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                <td></td>
                            </tr>

                            @foreach ($parent_account_aset_tetap as $parent)
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
                                        if (($child->account_number == '1-3100-1' || $child->account_number = '1-3200-1') && $child->flag_pengeluaran == 1) {
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
                                @php
                                    if (substr($parent->account_number, 0, 3) == '1-3') {
                                        $total_aset_tetap += $parent_balance;
                                    } else if (substr($parent->account_number, 0, 4) == '1-40') {
                                        $total_aset_lainnya += $parent_balance;
                                    }
                                @endphp
                                {{-- <tr>
                                    <td></td>
                                    <td style="font-weight: bold; border-left: 1px solid; border-right: 1px solid;"><b>TOTAL {{ $parent->account_name }}</b></td>
                                    <td style="text-align: right; font-weight: bold;">{{ number_format($parent_balance, 2, '.', ',') }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr> --}}


                                @if ($parent->account_number == '1-3000')
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL ASET TETAP</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_aset_tetap, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif

                                @if ($parent->account_number == '1-4000')
                                    @php
                                        $total_aset = $total_aset_lancar + $total_aset_tetap + $total_aset_lainnya;
                                    @endphp
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL ASET LAINNYA</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_aset_lainnya, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL ASET</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_aset, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif

                            @endforeach

                            <tr>
                                <td style="text-decoration: underline; font-weight: bold;"></td>
                                <td style="text-decoration: underline; font-weight: bold; border-left: 1px solid; border-right: 1px solid;">HUTANG DAN MODAL (PASIVA)</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style=""></td>
                                <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                <td></td>
                            </tr>

                            @foreach ($parent_account_passiva as $parent)
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
                                        if ($child->flag_pengeluaran == 1) {
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
                                @php
                                    if (substr($parent->account_number, 0, 4) == '2-10') {
                                        $total_hutang_usaha += $parent_balance;
                                    } else if (substr($parent->account_number, 0, 4) == '2-12') {
                                        $total_hutang_pajak += $parent_balance;
                                    } else if (substr($parent->account_number, 0, 4) == '2-21') {
                                        $total_hutang_jangka_panjang += $parent_balance;
                                    } else if (substr($parent->account_number, 0, 4) == '3-10') {
                                        $tota_modal += $parent_balance;
                                    }
                                @endphp
                                {{-- <tr>
                                    <td></td>
                                    <td style="font-weight: bold; border-left: 1px solid; border-right: 1px solid;"><b>TOTAL {{ $parent->account_name }}</b></td>
                                    <td style="text-align: right; font-weight: bold;">{{ number_format($parent_balance, 2, '.', ',') }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr> --}}


                                @if ($parent->account_number == '2-1000')
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL HUTANG USAHA</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_hutang_usaha, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif

                                @if ($parent->account_number == '2-1200')
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL HUTANG PAJAK</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_hutang_pajak, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif

                                @if ($parent->account_number == '2-2100')
                                    @php
                                        $total_hutang = $total_hutang_usaha + $total_hutang_pajak + $total_hutang_jangka_panjang;
                                    @endphp
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL HUTANG JANGKA PANJANG</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_hutang_jangka_panjang, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL HUTANG</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_hutang, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif

                                @if ($parent->account_number == '3-1000')
                                    @php
                                        $total_hutang_dan_modal = $total_hutang + $tota_modal;
                                    @endphp
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL MODAL</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_hutang_jangka_panjang, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center; text-decoration: underline; font-style: italic; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">TOTAL HUTANG DAN MODAL</td>
                                        <td style="text-align: right; text-decoration: underline; font-weight: bold; border: 1px solid; border-bottom: 2px solid;">{{ number_format($total_hutang_dan_modal, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endif

                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
