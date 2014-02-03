<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Already Logged In</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <meta name="viewport" content="width=device-width, user-scalable=yes" />
        <meta http-equiv="refresh" content="3; url=login_success.php">
        <link rel="stylesheet" href="../css/login.css" media="screen">
        <script type="text/javascript" src="../js/min.js"></script>
        <script type="text/javascript" src="../js/session.js"></script>
    </head>
    <body>
        <div id="passcodeUserAdd"  style="text-align: center;">
            <h2 id="thanks">You're already logged in. On to your page!&nbsp;&nbsp;<span id="timer">3</span></h2>
            <img src="../img/progress-bar.gif" />
        </div>
        <script>
            adjustPerPageSize();
            setInterval(function(){
                var count = parseInt($('#timer').html());
                count--;
                $('#timer').html(count);
            }, 1000);
        </script>
    </body>
</html>

