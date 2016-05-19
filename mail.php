<?php

    $to = $_POST["sendto"];
    $from = $_POST["sendfrom"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $agree = $_POST["agree"];

    if(isset($_POST["sendfrom"]) && isset($_POST["sendto"]) && isset($_POST["subject"]) && isset($_POST["message"]) && isset($_POST["agree"]))
    {
        if($agree == "true")
        {
            mail($to, $subject, $message, "From: " . $from);
            echo "Mailed";
        }
        else
        {
            echo "You Must Agree To Terms";
        }
    }
    else
    {
        echo "<script>window.location.reload();</script>";
    }
?>