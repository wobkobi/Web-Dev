<!DOCTYPE html>
<html>

<head>
    <meta http-equiv=content-type content=text/html; charset=utf-8 />
    <meta name="description" content="web Development :: Lab 3" />
    <meta name="keywords" content="web,development" />
    <title>Using string functions</title>
</head>

<body>
    <h1>Web Development – Lab 3</h1>
    <?php
    //check if set
    if (isset($_POST['input']) && !empty($_POST['input'])) {
    //obtain the form data
        $str = $_POST['input'];
        //set regular expression including space
        $pattern = "/^[a-zA-Z ]+$/";
        //check if $str with regular expression
        if (preg_match($pattern, $str)) {
            //initialise variable for the answer
            $answer = "";
            //obtain length
            $length = strlen($str);
            //cheacks all chars in $str
            for ($i = 0; $i < $length; $i++) {
                ////extract 1 char using substr
                $char = substr($str, $i, 1);
                //check using strops, is_numeric is used as strops returns a number
                //(position) if found, and false otherwise
                if (!is_numeric(strpos("aeiouAEIOU", $char))) {
                    $answer = $answer . $char;
                }
            }
            //generate answer after all letters are checked
            echo "The string without vowels is: $answer";
        } else {
            echo "The string contains invalid characters";
        }
    } else {
        echo "The string is not set";
    }
    ?>
</body>

</html>