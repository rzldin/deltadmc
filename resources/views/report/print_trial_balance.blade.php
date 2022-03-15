@extends('layouts.report')

@section('content')
    @php
    header('Content-Type:   application/vnd.ms-excel;');
    header('Content-Disposition: attachment; filename=trial balance ' . tanggalIndo($start_date) . ' s.d ' . tanggalIndo($end_date) . '.xls');

    function textnumber($value)
    {
        $result = number_format($value, 2, '.', ',');
        if ($value < 0) {
            $value *= -1;
            $result = number_format($value, 2, '.', ',');
            $result = "($result)";
        }
        return $result;
    }
    @endphp

    <table cellpadding="2" cellspacing="0">
        <thead>
            <tr>
                <th>PT. DELTA MARINE CONTINENTS</th>
            </tr>
            <tr>
                <th>TRIAL BALANCE</th>
            </tr>
            <tr>
                <th>{{ strtoupper(tanggalIndo($start_date)) }} S.D {{ strtoupper(tanggalIndo($end_date)) }}</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <table cellpadding="2" cellspacing="0" border="1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Akun</th>
                                <th>Nama Akun</th>
                                <th>Currency</th>
                                <th>Saldo Awal</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Saldo Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;

                                $total_start_balance = 0;
                                $total_debit = 0;
                                $total_credit = 0;
                                $total_end_balance = 0;
                            @endphp
                            @foreach ($parent_acc as $parent)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td style="font-weight: bold; text-decoration: underline; background-color: yellow;">&nbsp;{{ $parent->account_number }}</td>
                                    <td style="font-weight: bold; text-decoration: underline; background-color: yellow;">{{ $parent->account_name }}</td>
                                    <td style="text-align: center;">{{ $parent->currency_code }}</td>
                                    <td style="text-align: right;">{{ textnumber($parent->start_balance) }}</td>
                                    <td style="text-align: right;">{{ textnumber($parent->total_debit) }}</td>
                                    <td style="text-align: right;">{{ textnumber($parent->total_credit) }}</td>
                                    <td style="text-align: right;">{{ textnumber($parent->total_balance) }}</td>
                                </tr>
                                @foreach ($parent->child_acc as $child)
                                    @php
                                        $no++;
                                        $total_start_balance += $child->start_balance;
                                        $total_debit += $child->total_debit;
                                        $total_credit += $child->total_credit;
                                        $total_end_balance += $child->total_balance;
                                    @endphp
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>&nbsp;{{ $child->account_number }}</td>
                                        <td>{{ $child->account_name }}</td>
                                        <td style="text-align: center;">{{ $child->currency_code }}</td>
                                        <td style="text-align: right;">{{ textnumber($child->start_balance) }}</td>
                                        <td style="text-align: right;">{{ textnumber($child->total_debit) }}</td>
                                        <td style="text-align: right;">{{ textnumber($child->total_credit) }}</td>
                                        <td style="text-align: right;">{{ textnumber($child->total_balance) }}</td>
                                    </tr>
                                @endforeach
                                @php
                                    $no++;
                                    $total_start_balance += $parent->start_balance;
                                    $total_debit += $parent->total_debit;
                                    $total_credit += $parent->total_credit;
                                    $total_end_balance += $parent->total_balance;
                                @endphp
                            @endforeach
                            <tr>
                                <td colspan="4"></td>
                                <td style="font-weight: bold; text-align: right;">{{ textnumber($total_start_balance) }}</td>
                                <td style="font-weight: bold; text-align: right;">{{ textnumber($total_debit) }}</td>
                                <td style="font-weight: bold; text-align: right;">{{ textnumber($total_credit) }}</td>
                                <td style="font-weight: bold; text-align: right;">{{ textnumber($total_end_balance) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
