<?php
session_start();

$action = $_GET["action"];
$title = $_GET["title"];
$isbn = $_GET["isbn"];

if (array_key_exists("Cart", $_SESSION)) {
  $cart = $_SESSION["Cart"];

  if ($action == "Add") {
    if (isset($cart[$isbn])) {
      $cart[$isbn]["quantity"]++;
    } else {
      $cart[$isbn] = array(
        "title" => $title,
        "quantity" => 1
      );
    }
  } elseif ($action == "Remove") {
    if (isset($cart[$isbn])) {
      $cart[$isbn]["quantity"]--;

      if ($cart[$isbn]["quantity"] <= 0) {
        unset($cart[$isbn]);
      }
    }
  }

  $_SESSION["Cart"] = $cart;

  echo toXml($cart);
}

function toXml($cart) {
  $doc = new DomDocument('1.0');
  $cartElement = $doc->createElement('cart');
  $cartElement = $doc->appendChild($cartElement);

  foreach ($cart as $isbn => $book) {
    $bookElement = $doc->createElement('book');
    $bookElement = $cartElement->appendChild($bookElement);

    $titleElement = $doc->createElement('title');
    $titleElement->appendChild($doc->createTextNode($book["title"]));
    $bookElement->appendChild($titleElement);

    $quantityElement = $doc->createElement('quantity');
    $quantityElement->appendChild($doc->createTextNode($book["quantity"]));
    $bookElement->appendChild($quantityElement);

    $isbnElement = $doc->createElement('isbn');
    $isbnElement->appendChild($doc->createTextNode($isbn));
    $bookElement->appendChild($isbnElement);

    $priceElement = $doc->createElement('price');
    $priceElement->appendChild($doc->createTextNode(getPriceByISBN($isbn)));
    $bookElement->appendChild($priceElement);
  }

  $strXml = $doc->saveXML();
  return $strXml;
}

function getPriceByISBN($isbn) {
  // You can implement a function or fetch the price from a database using the ISBN
  // For simplicity, let's return a fixed price for all books
  return "39.99";
}
?>
