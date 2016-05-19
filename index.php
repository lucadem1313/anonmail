<?php

    function error($errorMsg)
    {
        echo '<script>$("body").prepend("<div class=\'error\'>Error: '.$errorMsg.'</div>");</script>';
    }
    $server = "lucademiancom.ipagemysql.com";
    $user = "lucademiancom";
    $pass = "Sohanibani01!";
    $connection = mysql_connect($server, $user, $pass);

    if(!$connection)
    {
        error("Could not connect");
    }
    mysql_select_db("anonmail", $connection);

    $result= mysql_query("SELECT COUNT(id) FROM info");
    while($row = mysql_fetch_array($result))
    {
        $numRows = $row[0];
    }
?>


<!DOCTYPE html>

<html>
<head>
    <title>Anon Mail</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>
        function loading(){
            var counter = 0;
            $("body").append("<div id='loader'><span>100%</span></div>");
            $("#loader span").css({"float": "right", "margin-top": "5px", "margin-right": "8px", "font-family": "'Open Sans', sans-serif"});
            var loader = setInterval(function(){
                $("#loader").css("width", counter+"%");
                $("#loader span").text(Math.round(counter) + "%");
                counter+=Math.random()*1;
                if(counter > 100){
                    $("#loader").remove();
                    $("body").prepend("<div class='message'>Message sent!</div>");
                    clearInterval(loader);
                }
            }, 50+Math.random()*100);
        }
    </script>
    <style>
        body, html{
            padding: 0;
            margin: 0;
            text-align: center;
        }
        body{
            padding-bottom: 150px;
        }
        form{
            text-align: center;
            font-family: "Open Sans", sans-serif;
            margin: 100px;
        }
        .error{
            height: 60px;
            width: 100%;
            text-align: center;
            font-family: "Open Sans", sans-serif;
            font-size: 30px;
            background: #e10000;
            margin-bottom: 15px;
            padding-top: 20px;
            overflow: hidden;
            transition: all 0.4s;
        }
        .message{
            height: 60px;
            width: 100%;
            text-align: center;
            font-family: "Open Sans", sans-serif;
            font-size: 30px;
            background: #00fb3f;
            margin-bottom: 15px;
            padding-top: 20px;
            overflow: hidden;
            transition: all 0.4s;
        }
        #loader{
            position: fixed;
            bottom: 0;
            height: 30px;
            background: #48a4ff;
        }
        textarea{
            font-family: "Open Sans", sans-serif;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <form method="post" action="index.php">
        From Name (optional): <input type="text" name="name"><br><br>
        Email to send from: <input type="email" name="sendfrom" required><br><br>
        Email to send to: <input type="email" name="sendto" required><br><br>
        Subject: <input type="text" name="subject" required><br><br><br>
        Message: <br><br><textarea name="message" cols="65" rows="10"></textarea><br><br>
        Agree To <a href="terms">Terms and Conditions</a>?<br><br>Agree <input type="radio" name="agree" value="true">
        <br>Disagree <input type="radio" name="agree" value="false" checked required><br><br>
        <input type="submit" value="Submit">
    </form>
    <h1 style="font-family: 'Open Sans', sans-serif;"><span style="border-radius: 2px;border: 3px black solid; padding-left: 3px; padding-right: 3px;"><?php echo $numRows; ?></span> Emails Have Been Sent Using This Service</h1><br><br><h4 style="font-family: 'Open Sans', sans-serif;">Developed By Luca Demian<br>&copy 2016 Luca Demian</h4>
</body>
</html>


<?php
    $to = $_POST["sendto"];
    $from = $_POST["sendfrom"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $agree = $_POST["agree"];
    $name = $_POST["name"];
    $ip = $_SERVER["REMOTE_ADDR"];
    $agreeint = 0;
    if($agree == "true")
        $agreeint = 1;
    else
        $agreeint = 0;

    $query = "INSERT INTO info (`to`, `from`, `subject`, `body`, `ip`, `agree`, `name`) VALUES ('".mysql_real_escape_string($to)."', '".mysql_real_escape_string($from)."', '".mysql_real_escape_string($subject)."', '".mysql_real_escape_string($message)."', '".mysql_real_escape_string($ip)."', $agreeint, '".mysql_real_escape_string($name)."')";


    if(isset($_POST["sendfrom"]) && isset($_POST["sendto"]) && isset($_POST["subject"]) && isset($_POST["message"]) && isset($_POST["agree"]))
    {
        if($agree == "true")
        {
            if(!mysql_query($query))
            {
                error("Error Connecting");
            }
            else
            {
                mail($to, $subject, $message, "From: ".$name."<" . $from.">");
                echo "<script>loading();</script>";
            }
        }
        else
        {
            error("You haven't agreed to the terms");
        }
    }
    else
    {
        error("Missing values");
    }
?>