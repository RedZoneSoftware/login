<?php
session_start();

$student_name = "";
$student_roles = null;
$student_role_count = 0;
$login_date_time = "";
$login_ip_address = "";

if (isset($_SESSION['username'])) {
    $student_name = $_SESSION['username'];
    $student_roles = $_SESSION['roles'];
    $student_role_count = count($student_roles);
    $login_date_time = $_SESSION['login_date_time'];
    $login_ip_address = $_SESSION['ip_address'];
} else {
    header('Location: ' . "not_authorized.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <meta name="viewport" content="width=device-width, user-scalable=yes" />
        <title>Welcome <?php echo $student_name ?> </title>
        <link rel="stylesheet" href="../css/login.css" />
        <script type="text/javascript" src="../js/min.js"></script>
        <script type="text/javascript" src="../js/fireworks.js"></script>
        <script type="text/javascript" src="../js/session.js"></script>
    </head>
    <body>
        <div  id="studentWelcome">
            <a id="logout_redirect" onclick="logout();" href="javascript:void(0);" title="Logout" class="standardLink">Logout</a>
            <div id="welcome_page">
                <div>
                    <h1>Welcome <?php echo $student_name ?>!!!</h1>
                    <h2>Roles: </h2>
                    <?php
                    for ($i = 0; $i < $student_role_count; $i++):
                        ?>
                        <h2 class="student_role"><?php echo $student_roles[$i] ?></h2>
                        <?php
                    endfor;
                    ?>
                </div>
            </div>
            <canvas id="aCanvas"></canvas>
        </div>
        <div id="pageBottom">
            <span id="login_time">Login time:&nbsp;&nbsp;<?php echo $login_date_time ?></span>
            <span id="login_ip">IP Address:&nbsp;&nbsp;<?php echo $login_ip_address ?></span>
        </div>
        <script>
            function rainbow() {
                // 30 random hues with step of 12 degrees
                var hue = Math.floor(Math.random() * 30) * 12;
                return $.Color({
                    hue: hue,
                    saturation: 0.9,
                    lightness: 0.6,
                    alpha: 1
                }).toHexString();
            }
            ;
            $('.student_role').each(function() {
                $(this).css('color', rainbow());
            });
        </script>
    </body>
</html>

