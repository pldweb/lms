<?php

if (!function_exists('formInput')) {
    function formInput($type, $name, $attributes = [])
    {
        $value = old($name);
        $attrString = '';
        foreach ($attributes as $key => $val) {
            $attrString .= "$key=\"$val\" ";
        }
        return "<input type=\"$type\" name=\"$name\" value=\"$value\" class=\"form-control\" $attrString>";
    }
}

if (!function_exists('formSubmit')) {
    function formSubmit($text = 'Submit', $attributes = [])
    {
        $attrString = '';
        foreach ($attributes as $key => $val) {
            $attrString .= "$key=\"$val\" ";
        }
        return "<button type=\"submit\" class=\"btn btn-primary\" $attrString>$text</button>";
    }
}

if(!function_exists('alert_success')){
    function alert_success($msg = null){
        $html = "<div class='alert alert-success alert-dismissible'>$msg</div>";
        return $html;
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($angka, $prefix = 'Rp')
    {
        return $prefix . ' ' . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('successAlert')) {
    function successAlert($msg = null, $load = null, $elem = '#masterData', $redirect = ''){
        $loadData = json_encode($load);
        $elem = json_encode($elem);
        $html ="<div class='alert alert-success'>$msg</div>";
        $url = json_encode($redirect);
        $script = "<script>
                setTimeout(function () {
                    hideModal();
                    loadData({$loadData}, {$elem})
                    window.location.href = {$url};
                }, 1500)
                </script>";
        return $html . $script;

    }
}

if (!function_exists('errorAlert')) {
    function errorAlert($msg = null){
        return "<div class='alert alert-danger'>$msg</div>
                <script>
                setTimeout(function () {
                    hideModal()
                }, 1500)
                </script>";
    }
}

if (!function_exists('dateDisplay')) {
    function dateDisplay($time){
        \Carbon\Carbon::setLocale('id');
        $time = Carbon\Carbon::parse($time)->translatedFormat('l, d F Y');
        return $time;
    }
}

if (!function_exists('dateTimeDisplay')) {
    function dateTimeDisplay($time){
        \Carbon\Carbon::setLocale('id');
        $time = Carbon\Carbon::parse($time)->translatedFormat('l, d F Y H:i');
        return $time;
    }
}

if (!function_exists('getNameProvinsi')) {
    function getNameProvinsi($id)
    {
        if (!$id) return '-';
        $provinsiList = \App\Helper\LokasiHelper::getProvinsi()['data'];
        foreach ($provinsiList as $provinsi) {
            if ($provinsi['kode'] == $id) {
                return $provinsi['nama'];
            }
        }
        return '-';
    }
}

if (!function_exists('getNameKota')) {
    function getNameKota($id)
    {
        if (!$id) return '-';
        $kotaList = \App\Helper\LokasiHelper::getKota($id)['data'];
        foreach ($kotaList as $kota) {
            if ($kota['kode'] == $id) {
                return $kota['nama'];
            }
        }
        return '-';
    }
}

if (!function_exists('getNameKecamatan')) {
    function getNameKecamatan($id)
    {
        if (!$id) return '-';
        $kecamatanList = \App\Helper\LokasiHelper::getKecamatan($id)['data'];
        foreach ($kecamatanList as $kecamatan) {
            if ($kecamatan['kode'] == $id) {
                return $kecamatan['nama'];
            }
        }
        return '-';
    }
}

if (!function_exists('getNameKelurahan')) {
    function getNameKelurahan($id)
    {
        if (!$id) return '-';
        $kelurahanList = \App\Helper\LokasiHelper::getKelurahan($id)['data'];
        foreach ($kelurahanList as $kelurahan) {
            if ($kelurahan['kode'] == $id) {
                return $kelurahan['nama'];
            }
        }
        return '-';
    }
}

