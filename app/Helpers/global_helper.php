<?php

use App\Controllers\Login;


if (!function_exists('count_barang_in_ruangan')) {
    function count_barang_in_ruangan($id)
    {
        $db = \Config\Database::connect();
        return $db->table('tb_ruangan r')->select('r.*, r.id_user as Penambah')->join('tb_barang b', 'b.id_ruangan = r.id_ruangan')->where('r.id_ruangan', $id)->countAllResults();
    }
}
if (!function_exists('ruangan_data')) {
    function ruangan_data($id)
    {
        $db = \Config\Database::connect();
        $orders = $db->query("
            SELECT r.*, r.id_user as Penambah, g.nama_gedung,u.nama
            FROM tb_ruangan r
            JOIN tb_gedung g
	            ON g.id_gedung = r.id_gedung
         JOIN tb_user u
	            ON u.id_user = r.id_user
            WHERE r.id_ruangan = '$id'")->getRow();

        return $orders->nama_gedung;
    }
}
if (!function_exists('format_rupiah')) {
    function format_rupiah($rp)
    {
        return number_format($rp, 2, ',', '.');
    }
}
if (!function_exists('count_ruangan_in_gedung')) {
    function count_ruangan_in_gedung($id)
    {
        $db = \Config\Database::connect();
        return $db->table('tb_ruangan r')->select('r.*, r.id_user as Penambah, g.nama_gedung')->join('tb_gedung g', 'g.id_gedung = r.id_gedung')->where('r.id_gedung', $id)->countAllResults();
    }
}
if (!function_exists('ruangan_in_gedung')) {
    function ruangan_in_gedung($id)
    {
        $db = \Config\Database::connect();
        return $db->table('tb_ruangan r')->select('r.*, r.id_user as Penambah, g.nama_gedung')->join('tb_gedung g', 'g.id_gedung = r.id_gedung')->where('r.id_gedung', $id)->orderBy('nama_ruangan', 'ASC')->get()->getResult();
    }
}
if (!function_exists('barang_in_ruangan')) {
    function barang_in_ruangan($id)
    {
        $db = \Config\Database::connect();
        return $db->table('tb_menyimpan s')->select('s.*,b.nama_barang,b.merek,b.jenis')->join('tb_barang b', 'b.id_barang = s.id_barang')->where('s.id_ruangan', $id)->orderBy('nama_barang', 'ASC')->get()->getResult();
    }
}
if (!function_exists('barang_masuk')) {
    function barang_masuk($id)
    {
        $db = \Config\Database::connect();
        return $db->table('tb_pbarangmasuk')->select('tb_pbarangmasuk.*,s.nama_toko, b.nama_barang')
            ->join('tb_barang b', 'b.id_barang = tb_pbarangmasuk.id_barang')
            ->join('tb_supplier s', 'tb_pbarangmasuk.id_supplier = s.id_supplier')->orderBy('b.nama_barang', 'ASC')->where('tb_pbarangmasuk.id_barang', $id)->get()->getResult();
    }
}
function get_formatted_date($source_date)
{
    $d = strtotime($source_date);

    $year = date('Y', $d);
    $month = date('n', $d);
    $day = date('d', $d);
    $day_name = date('D', $d);

    $day_names = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jum\'at',
        'Sat' => 'Sabtu'
    );
    $month_names = array(
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September',
        '10' => 'November',
        '11' => 'Oktober',
        '12' => 'Desember'
    );
    $day_name = $day_names[$day_name];
    $month_name = $month_names[$month];

    $date = "$day_name, $day $month_name $year";

    return $date;
}


if (!function_exists('get_admin_image')) {
    function get_admin_image()
    {
        return base_url('assets/uploads/users/user.jpg');
    }
}



if (!function_exists('get_month')) {
    function get_month($mo)
    {
        $months = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );

        return $months[$mo];
    }
}
