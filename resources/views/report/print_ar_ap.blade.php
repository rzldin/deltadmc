@extends('layouts.report')

@section('content')
    @php
    header('Content-Type:   application/vnd.ms-excel;');
    header('Content-Disposition: attachment; filename='. $title . ' per ' . tanggalIndo($end_date) . '.xls');

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
                <th>Rincian {{ $title }}</th>
            </tr>
            <tr>
                <th>PER {{ strtoupper(tanggalIndo($end_date)) }}</th>
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
                                <th>No</th>
                                <th>Akun</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Customer</th>
                                <th>Currency</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_acc_balance = 0;
                                $grand_total = 0;
                                $no = 1;
                            @endphp
                            @foreach ($trx as $key => $row)
                                @if ($key == 0)
                                    <tr>
                                        <td align="center">{{ $no }}</td>
                                        <td>&nbsp;{{ $row->account_number }}</td>
                                        <td></td>
                                        <td>Saldo Awal</td>
                                        <td>{{ $row->client_name }}</td>
                                        <td align="center">{{ $row->currency_code }}</td>
                                        <td align="right">{{ textnumber($row->starting_balance) }}</td>
                                    </tr>
                                    @php
                                        $total_acc_balance += $row->starting_balance;
                                        $no++;
                                    @endphp
                                @elseif ($key > 0 && $trx[$key - 1]->account_number != $trx[$key]->account_number)
                                    @php
                                        $no = 1;
                                    @endphp
                                    <tr>
                                        <td colspan="6"></td>
                                        <td align="right" style="font-weight: bold;">{{ textnumber($total_acc_balance) }}</td>
                                    </tr>
                                    <tr>
                                        <td align="center">{{ $no }}</td>
                                        <td>&nbsp;{{ $row->account_number }}</td>
                                        <td></td>
                                        <td>Saldo Awal</td>
                                        <td>{{ $row->client_name }}</td>
                                        <td align="center">{{ $row->currency_code }}</td>
                                        <td align="right">{{ textnumber($row->starting_balance) }}</td>
                                    </tr>
                                    @php
                                        $total_acc_balance += $row->starting_balance;
                                        $no++;
                                    @endphp
                                @endif
                                @php
                                    if ($key == 0) {
                                        // continue;
                                    } elseif ($key > 0 && $trx[$key - 1]->account_number != $trx[$key]->account_number) {
                                        $total_acc_balance = 0;
                                    }
                                    $total_acc_balance += $row->amount;
                                    $grand_total += $row->amount;
                                @endphp

                                <tr>
                                    <td align="center">{{ $no }}</td>
                                    <td>&nbsp;{{ $row->account_number }}</td>
                                    <td>{{ date('d/m/Y', strtotime($row->gl_date)) }}</td>
                                    <td>{{ $row->account_name }}</td>
                                    <td>{{ $row->client_name }}</td>
                                    <td align="center">{{ $row->currency_code }}</td>
                                    <td align="right">{{ textnumber($row->amount) }}</td>
                                </tr>
                                @php
                                    $no++;
                                @endphp
                            @endforeach
                            <tr>
                                <td colspan="6"></td>
                                <td align="right" style="font-weight: bold;">{{ textnumber($total_acc_balance) }}</td>
                            </tr>
                            <tr>
                                <td align="center" style="font-weight: bold;" colspan="6">Grand Total</td>
                                <td align="right" style="font-weight: bold;">{{ textnumber($grand_total) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
