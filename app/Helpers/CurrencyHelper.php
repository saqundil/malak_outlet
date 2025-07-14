<?php

if (!function_exists('format_currency')) {
    /**
     * Format price to Jordanian Dinar (JOD)
     *
     * @param float $amount
     * @return string
     */
    function format_currency($amount) {
        return number_format($amount, 2) . ' د.أ';
    }
}

if (!function_exists('get_currency_symbol')) {
    /**
     * Get the currency symbol for Jordan
     *
     * @return string
     */
    function get_currency_symbol() {
        return 'د.أ';
    }
}

if (!function_exists('get_country_code')) {
    /**
     * Get the country calling code for Jordan
     *
     * @return string
     */
    function get_country_code() {
        return '+962';
    }
}

if (!function_exists('get_country_name')) {
    /**
     * Get the country name
     *
     * @return string
     */
    function get_country_name() {
        return 'المملكة الأردنية الهاشمية';
    }
}

if (!function_exists('get_capital_city')) {
    /**
     * Get the capital city
     *
     * @return string
     */
    function get_capital_city() {
        return 'عمان';
    }
}
