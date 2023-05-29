<?php
session_start();

$newitem = $_GET["book"];
$action = $_GET["action"];
$isbn = $_GET["isbn"];
$price = $_GET["price"];

if (array_key_exists("Cart", $_SESSION)) {
    $cart = $_SESSION["Cart"];

    if ($action == "Add") {
        if (isset($cart[$newitem])) {
            $value = $cart[$newitem]["quantity"] + 1;
            $cart[$newitem] = array(
                "quantity" => $value,
                "isbn" => $isbn,
                "price" => $price
            );
        } else {
            $cart[$newitem] = array(
                "quantity" => "1",
                "isbn" => $isbn,
                "price" => $price
            );
        }
    } else {
        if (isset($cart[$newitem])) {
            unset($cart[$newitem]);
        }
    }
} else {
    $cart[$newitem] = array(
        "quantity" => "1",
        "isbn" => $isbn,
        "price" => $price
    );
}

$_SESSION["Cart"] = $cart;

$totalCost = 0.0;

foreach ($cart as $item) {
    $totalCost += floatval($item["price"]) * intval($item["quantity"]);
}

$response = array(
    "cart" => $cart,
    "totalCost" => $totalCost
);

echo json_encode($response, JSON_PRETTY_PRINT);
?>