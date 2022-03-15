<?php

function tanggalIndo($date) {
    $date = date('Y-m-d', strtotime($date));

    $explode = explode('-', $date);
    $year = $explode[0];
    $month = $explode[1];
    $day = $explode[2];

    $bulan_indo = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    $result = "{$day} {$bulan_indo[$month - 1]} {$year}";
    return $result;
}
