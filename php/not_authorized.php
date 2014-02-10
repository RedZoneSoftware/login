<?php
session_start();
// resets the session data for the rest of the runtime
$_SESSION = array();

session_destroy();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Please Login</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="refresh" content="3; url=index.php">
        <link rel="stylesheet" href="../css/login.css" media="screen">
        <script type="text/javascript" src="../js/min.js"></script>
        <script type="text/javascript" src="../js/session.js"></script>
    </head>
    <body>
        <div id="passcodeUserAdd" style="text-align: center;">
            <h2 id="auth1">Please log in to view your page.&nbsp;&nbsp;<span id="timer">3</span></h2>
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

