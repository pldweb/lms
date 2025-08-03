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
