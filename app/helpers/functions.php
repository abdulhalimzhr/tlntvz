<?php

function env($key, $default = null)
{
    return Env::get($key, $default);
}

function currencyFormat($number)
{
    return number_format($number, 2, ',', '.');
}

function formatDate($date)
{
    return date('l, j F Y h:i:s A', strtotime($date));
}
