<?php

function GetCart()
{
    if (isset($_SESSION["cart"])) {
        $cart = $_SESSION["cart"];
    } else {
        $cart = array();
    }
    return $cart;
}

function AddProductToCart($stockItemID, $stockItemAantal)
{
    $cart = GetCart();
    if (array_key_exists($stockItemID, $cart)) {
        $cart[$stockItemID] += $stockItemAantal;
    } else {
        $cart[$stockItemID] = $stockItemAantal;
    }
    SaveCart($cart);
}

function SaveCart($cart)
{
    $_SESSION["cart"] = $cart;
}
