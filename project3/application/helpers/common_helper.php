<?php
if (!function_exists('common_valuepost')) {

    function common_valuepost($value)
    {
        return (isset($value) && !empty($value)) ? htmlspecialchars($value) : '';
    }
}

if (!function_exists('common_showerror')) {

    function common_showerror($error)
    {
        return (isset($error) && !empty($error)) ? '<ul class ="error">'.$error.'</ul>' : '';
    }
}
