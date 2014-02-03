<?php
session_start();

$student_redirect = "index.php";

if (isset($_SESSION['redirect'])) {
    $student_redirect = $_SESSION['redirect'];
} else {
    // let the login page figure out what to do
    header('Location: ' . "index.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Redirecting you</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <meta name="viewport" content="width=device-width, user-scalable=yes" />
        <link rel="stylesheet" href="../css/login.css" media="screen">
        <script type="text/javascript" src="../js/min.js"></script>
        <script type="text/javascript" src="../js/session.js"></script>
    </head>
    <body>
        <div id="passcodeUserAdd"  style="text-align: center;">
            <h2 id="thanks"><span id="red_msg">You are being redirected to your requested page!</span>&nbsp;&nbsp;<span id="timer">3</span></h2>
            <img src="../img/progress-bar.gif" />
        </div>
        <script>
            // posiiton the page elements
            adjustPerPageSize();
            // do the countdown visual
            setInterval(function() {
                var count = parseInt($('#timer').html());
                count--;
                $('#timer').html(count);
            }, 1000);
            // forward if it's the first time through
            // otherwise send them to their home page
            var hasBeen = KELLY_UTILS.cookieRead('redirected');
            if (!hasBeen) {
                KELLY_UTILS.cookieCreate('redirected', true);
                $('#red_msg').text("You are being redirected to your requested page!");
                setTimeout(function() {
                    window.location = "<?php echo $student_redirect ?>";
                }, 3000);
            } else {
                KELLY_UTILS.cookieErase('redirected');
                $('#red_msg').text("Welcome back!  Sending you to your Home Page");
                setTimeout(function() {
                    window.location = "login_success.php";
                }, 3000);
            }
        </script>
    </body>
</html>

