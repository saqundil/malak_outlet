<?php

namespace App\Helpers;

class CartHelper
{
    /**
     * Get cart count from cookies
     */
    public static function getCartCount(): int
    {
        $cartJson = request()->cookie('shopping_cart', '[]');
        $cart = json_decode($cartJson, true) ?: [];
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Get cart items from cookies
     */
    public static function getCartItems(): array
    {
        $cartJson = request()->cookie('shopping_cart', '[]');
        return json_decode($cartJson, true) ?: [];
    }
}
