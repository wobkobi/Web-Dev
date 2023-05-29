<?php
session_start();

$newitem = $_GET["book"];
$action = $_GET["action"];

if (array_key_exists("Cart", $_SESSION)) {
    $cart = $_SESSION["Cart"];
    if ($action == "Add") {
        if (isset($cart[$newitem])) {
            $cart[$newitem]['quantity'] += 1;
        } else {
            $cart[$newitem] = array(
                'quantity' => 1,
                'ISBN' => $_GET['ISBN'],
                'price' => $_GET['price']
            );
        }
    } else if ($action == "Remove") {
        if (isset($cart[$newitem])) {
            $cart[$newitem]['quantity'] -= 1;
            if ($cart[$newitem]['quantity'] <= 0) {
                unset($cart[$newitem]);
            }
        }
    }
} else {
    $cart[$newitem] = array(
        'quantity' => 1,
        'ISBN' => $_GET['ISBN'],
        'price' => $_GET['price']
    );
}

$_SESSION["Cart"] = $cart;

if (!empty($cart)) {
    $totalCost = 0;
    foreach ($cart as $item) {
        $totalCost += $item['quantity'] * $item['price'];
    }
    echo json_encode(array('cart' => $cart, 'totalCost' => $totalCost), JSON_PRETTY_PRINT);
}
?>