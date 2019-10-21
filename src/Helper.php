<?php
if (!function_exists('__t')) {
    function __t($key)
    {
        $item = \AporteWeb\Dashboard\Models\Translation::where('key', $key)->first();
        if ($item) {
            return $item->translation;
        } else {
            return $key;
        }
    }
}
if (!function_exists('__active')) {
    function __active($var, $active)
    {
        if ($var == $active) {
            return 'active';
        }
        return '';
    }
}
if (!function_exists('display_price')) {
    function display_price($price)
    {
        if ($price!="") {
            return number_format($price, 2, ',', '.');
        }
         return number_format(0, 2, ',', '.');
    }
}
if (!function_exists('__meta')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function __meta($section, $key)
    {
        $meta = Cache::remember('seo', 60, function () {
            return AporteWeb\Dashboard\Models\Seo::get();
        });
        if ($meta) {
            $meta = $meta->where('section', $section)->first();
            if ($meta && $meta->{$key} != '') {
                return $meta->{$key};
            }
        }
        return null;
    }
}

if (!function_exists('__config_var')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function __config_var($key)
    {
        $var = Cache::remember('config_var', 60, function () {
            return AporteWeb\Dashboard\Models\ConfigVar::get()->pluck('config_value', 'config_key');
        })->toArray();

        if (is_array($var) && array_key_exists($key, $var)) {
            return $var[$key];
        }

        return null;
    }
}

?>