@extends('layouts.report')

@section('content')
    @php
    header('Content-Type:   application/vnd.ms-excel;');
    header('Content-Disposition: attachment; filename=jurnal umum ' . tanggalIndo($start_date) . ' s.d ' . tanggalIndo($end_date) . '.xls');

    function textnumber($value)
    {
        $result = number_format($value, 2, '.', ',');
        return $value < 0 ? "($result)" : "$result";
    }
    @endphp

    <table cellpadding="2" cellspacing="0">
        <thead>
            <tr>
                <th>PT. DELTA MARINE CONTINENTS</th>
            </tr>
            <tr>
                <th>JURNAL UMUM</th>
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
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Doc No.</th>
                                <th>Keterangan</th>
                                <th>Akun</th>
                                <th>Nama Akun</th>
                                <th>Currency</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $balance = 0;
                            @endphp
                            @foreach ($cash as $row)
                                @php
                                    $balance = $balance + $row->debit - $row->credit;
                                @endphp
                                <tr>
                                    <td align="center">{{ $loop->iteration }}</td>
                                    <td>{{ date('d/m/Y', strtotime($row->trx_date)) }}</td>
                                    <td>{{ $row->transaction_no }}</td>
                                    <td>{{ $row->memo }}</td>
                                    <td>&nbsp;{{ $row->account_number }}</td>
                                    <td>{{ $row->account_name }}</td>
                                    <td align="center">{{ $row->currency_code }}</td>
                                    <td align="right">{{ textnumber($row->debit) }}</td>
                                    <td align="right">{{ textnumber($row->credit) }}</td>
                                    <td align="right">{{ textnumber($balance) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
