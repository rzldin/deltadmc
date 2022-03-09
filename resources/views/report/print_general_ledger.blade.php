@extends('layouts.report')

@section('content')
    @php
    header('Content-Type:   application/vnd.ms-excel;');
    header('Content-Disposition: attachment; filename=general ledger ' . tanggalIndo($start_date) . ' s.d ' . tanggalIndo($end_date) . '.xls');

    function textnumber($value)
    {
        $result = number_format($value, 2, '.', ',');
        return $value < 0 ? "($result)" : "$result";
    }
    @endphp

    @foreach ($header as $row)
        <table cellpading="2" cellspacing="0">
            <thead>
                <tr>
                    <th>PT. DELTA MARINE CONTINENTS</th>
                </tr>
                <tr>
                    <th>GENERAL LEDGER</th>
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
                <tr>
                    <th style="text-align: left;">ACC NO</th>
                </tr>
                <tr>
                    <th style="text-align: left;">{{ $row->account_number }}</th>
                </tr>
                <tr>
                    <th style="text-align: left;">SALDO AWAL</th>
                </tr>
                <tr>
                    <th style="text-align: left;">{{ number_format($row->start_balance, 2, '.', ',') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <table border="1" cellpading="2" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tgl</th>
                                    <th>Kode</th>
                                    <th>Doc Number</th>
                                    <th>Keterangan</th>
                                    <th>Acc No</th>
                                    <th>Nama Akun</th>
                                    <th>Currency</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_end_balance = 0;
                                @endphp
                                @foreach ($row->details as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d/m/Y', strtotime($value->gl_date)) }}</td>
                                        <td>{{ $value->journal_no }}</td>
                                        <td></td>
                                        <td>{{ $value->memo }}</td>
                                        <td>&nbsp;{{ $value->account_number }}</td>
                                        <td>{{ $value->account_name }}</td>
                                        <td style="text-align: center;">{{ $value->currency_code }}</td>
                                        <td style="text-align: right;">{{ textnumber($value->debit) }}</td>
                                        <td style="text-align: right;">{{ textnumber($value->credit) }}</td>
                                        <td style="text-align: right;">{{ textnumber($value->balance) }}</td>
                                    </tr>
                                    @php
                                        $total_end_balance += $value->balance;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="10"></td>
                                    <td style="text-align: right; font-weight: bold;">{{ textnumber($total_end_balance) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
    @endforeach
@endsection
