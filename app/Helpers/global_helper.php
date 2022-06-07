<?php
// if (!function_exists('init')) {
//     function init()
//     {
//         $CI = &get_instance();
//         return $CI;
//     }
// }

use App\Controllers\Login;

helper('auth');
if (!function_exists('get_current_user_id')) {
    function get_current_user_id()
    {
        return (logged_in() ?  user_id() : redirect()->to('login'));
        //return $login_data->user_id;
    }
}
if (!function_exists('get_settings')) {
    function get_settings($key = '')
    {
        $db = \Config\Database::connect();
        $result = $db->query("
        SELECT content FROM settings WHERE settings.key = '$key'")->getRow();
        return $result->content;
    }
}
if (!function_exists('format_rupiah')) {
    function format_rupiah($rp)
    {
        return number_format($rp, 2, ',', '.');
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
if (!function_exists('update_settings')) {
    function update_settings($key, $new_content)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('settings');
        $builder->set('content', $new_content);
        $builder->where('key', $key);
        $builder->update();
    }
}

if (!function_exists('get_store_name')) {
    function get_store_name()
    {
        return get_settings('store_name');
    }
}


if (!function_exists('get_admin_image')) {
    function get_admin_image()
    {
        // $profile_picture = user()->profile_picture;

        // if (file_exists('assets/uploads/users/' . $profile_picture))
        //     $file = $profile_picture;
        // else
        //     $file = 'admin.png';

        return base_url('assets/uploads/users/user.jpg');
    }
}

if (!function_exists('get_admin_name')) {
    function get_admin_name()
    {
        $data = (logged_in() ?  user()->name : '');

        return $data;
    }
}

if (!function_exists('get_user_name')) {
    function get_user_name()
    {
        $data = (logged_in() ?  user()->name : '');

        return $data;
    }
}

if (!function_exists('get_user_image')) {
    function get_user_image()
    {
        $picture = user()->profile_picture;
        $file = './assets/uploads/users/' . $picture;

        if (file_exists('assets/uploads/users/' . $picture))
            $picture_name = $picture;
        else
            $picture_name = 'user.jpg';

        return base_url('assets/uploads/users/' . $picture_name);
    }
}

if (!function_exists('get_store_logo')) {
    function get_store_logo()
    {
        $file = get_settings('store_logo');
        return base_url('assets/uploads/sites/' . $file);
    }
}



if (!function_exists('create_product_sku')) {
    function create_product_sku($name, $category, $price, $stock)
    {
        $name = create_acronym($name);
        $category = create_acronym($category);
        $price = create_acronym($price);
        $stock = $stock;
        $key = substr(time(), -3);

        $sku =  $name . $category . $price . $stock . $key;
        return $sku;
    }
}

if (!function_exists('create_acronym')) {
    function create_acronym($words)
    {
        $words = explode(' ', $words);
        $acronym = '';

        foreach ($words as $word) {
            $acronym .= $word[0];
        }

        $acronym = strtoupper($acronym);

        return $acronym;
    }
}

if (!function_exists('count_percent_discount')) {
    function count_percent_discount($discount, $from, $num = 1)
    {
        $count = ($discount / $from) * 100;
        $count = number_format($count, $num);

        return $count;
    }
}

if (!function_exists('get_product_image')) {
    function get_product_image($id)
    {
        $db = \Config\Database::connect();
        // $builder = $db->table('products');
        // $builder->select('*, product.id as productid');
        // $builder->join('product_category', 'product_category.id = products.category_id');
        // $builder->where('productid',$id);
        // $query = $builder->get();
        // return $query->getResultArray();
        $data = $db->query("
            SELECT p.*, pc.name as category_name
            FROM products p
            JOIN product_category pc
                ON pc.id = p.category_id
            WHERE p.id = '$id'
        ")->getRow();

        $picture_name = $data->picture_name;

        if (!$picture_name)
            $picture_name = 'default.jpg';

        $file = './assets/uploads/products/' . $picture_name;

        return base_url('assets/uploads/products/' . $picture_name);
    }
}

if (!function_exists('get_order_status')) {
    function get_order_status($status, $payment)
    {
        if ($payment == 1) {
            // Bank
            if ($status == 1)
                return 'Menunggu pembayaran';
            else if ($status == 2)
                return 'Dalam proses';
            else if ($status == 3)
                return 'Dalam pengiriman';
            else if ($status == 4)
                return 'Selesai';
            else if ($status == 5)
                return 'Dibatalkan';
        } else if ($payment == 2) {
            //COD
            if ($status == 1)
                return 'Dalam proses';
            else if ($status == 2)
                return 'Dalam pengiriman';
            else if ($status == 3)
                return 'Selesai';
            else if ($status == 4)
                return 'Dibatalkan';
        }
    }
}

if (!function_exists('get_payment_status')) {
    function get_payment_status($status)
    {
        if ($status == 1)
            return 'Menunggu konfirmasi';
        else if ($status == 2)
            return 'Berhasil dikonfirmasi';
        else if ($status == 3)
            return 'Pembayaran tidak ditemukan';
    }
}

if (!function_exists('get_contact_status')) {
    function get_contact_status($status)
    {
        if ($status == 1)
            return 'Belum dibaca';
        else if ($status == 2)
            return 'Sudah dibaca';
        else if ($status == 3)
            return 'Sudah dibalas';
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

if (!function_exists('get_controller')) {
    function get_controller()
    {

        $router = service('router');
        $controller  = $router->controllerName();

        return $controller;
    }
}
