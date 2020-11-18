<?php

function GetCart()
{
    if (isset($_SESSION["cart"])) {//controleren of winkelmandje al bestaat
        $cart = $_SESSION["cart"];
    } else {
        $cart = array();
    }
    return $cart;
}

function AddProductToCart($stockItemID)
{
    $cart = GetCart();
    if (array_key_exists($stockItemID, $cart)) { //controleren of product al in winkelmandje voorkomt
        $cart[$stockItemID] += 1;
    } else {
        $cart[$stockItemID] = 1;
    }
    SaveCart($cart);
}

function SaveCart($cart)
{
    $_SESSION["cart"] = $cart;
}