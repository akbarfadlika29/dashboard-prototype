<?php

if (! function_exists('public_asset')) {

    function public_asset($path)
    {
        return asset(config('app.public_prefix') . ltrim($path, '/'));
    }

}