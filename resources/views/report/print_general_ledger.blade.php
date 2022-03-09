@extends('layouts.report')

@section('content')
    @php
    header('Content-Type:   application/vnd.ms-excel;');
    header('Content-Disposition: attachment; filename=general ledger ' . tanggalIndo($start_date) . ' s.d ' . tanggalIndo($end_date) . '.xls');
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
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($row->details as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d/m/Y', strtotime($value->gl_date)) }}</td>
                                        <td>{{ $value->journal_no }}</td>
                                        <td></td>
                                        <td>{{ $value->memo }}</td>
                                        <td>{{ $value->account_number }}</td>
                                        <td>{{ $value->account_name }}</td>
                                        <td>{{ number_format($value->debit, 2, ',', '.') }}</td>
                                        <td>{{ number_format($value->credit, 2, ',', '.') }}</td>
                                        <td>{{ number_format($value->balance, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
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
