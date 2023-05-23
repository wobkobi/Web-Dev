<?php

session_start();

$newitem = $_GET["book"];
$action = $_GET["action"];

		if (array_key_exists("Cart", $_SESSION))
        {
            $cart = $_SESSION["Cart"];
            if ($action == "Add")
            {
                if ($cart[$newitem] != "")
                {  
                    $value = $cart[$newitem] + 1;
                    $cart[$newitem] = $value;
                }
                else
                {
                    $cart[$newitem] = "1";
                }
            }
            else
            {
                $cart[$newitem]= "";
            }
        }
        else
        {
            $cart[$newitem] = "1";
        }

        $_SESSION["Cart"] = $cart;

        

        if ($cart[$newitem] != "") 
			echo json_encode($cart, JSON_PRETTY_PRINT);
		
		// echo json_encode($cart, JSON_PRETTY_PRINT);
		
?>
