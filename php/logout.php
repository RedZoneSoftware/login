<?php
session_start();
// resets the session data for the rest of the runtime
$_SESSION = array();
// no idea what this does
session_destroy();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Logging Out</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <meta name="viewport" content="width=device-width, user-scalable=yes" />
        <meta http-equiv="refresh" content="2; url=index.php">
        <link rel="stylesheet" href="../css/login.css" media="screen">
        <script type="text/javascript" src="../js/min.js"></script>
        <script type="text/javascript" src="../js/session.js"></script>
    </head>
    <body>
        <div id="passcodeUserAdd"  style="text-align: center;">
            <h1 id="thanks">Thanks for visiting!&nbsp;&nbsp;<span id="timer">2</span></h1>
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

