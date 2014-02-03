<?php
session_start();
// see if user is already logged in and move along if they are
if(isset($_SESSION['username'])) {
    header('Location: ' . "already_logged_in.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Amazing Pages</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <meta name="viewport" content="width=device-width, user-scalable=yes" />
        <link rel="stylesheet" href="../css/login.css" media="screen">
        <link rel="stylesheet" href="../css/mCombine.css" media="screen">
        <script type="text/javascript" src="../js/min.js"></script>
        <script type="text/javascript" src="../js/session.js"></script>
        <script type="text/javascript" src="../js/mCombine.js"></script>
    </head>
    <body>
        <div id="passcodeUserAdd">
            <div id="addUserMsg">Please Enter Login Information</div>
            <div>
                <span class="leftText">Login Name:</span><input class="userNameInput validate" id="username" name="userName" type="text" value="Keegan">&nbsp;<sup>*</sup>
            </div>
            <div>
                <span class="name error hidden">Please enter a value</span>
            </div>
            <div>
                <span class="leftText">Password</span><input class="userPassInput validate" id="password" name="passWord" type="password" value="pass">&nbsp;<sup>*</sup>
            </div>
            <div>
                <span class="pass error hidden">Please enter a value</span>
            </div>
            <div>
                <span class="leftText">Redirect</span><input class="userURLInput validate" id="redirect" name="redirect" type="text" value=""><br>
            </div>
            <div>
                <span class="pass error hidden">Please enter a value</span>
            </div>
            <input id="newUserSubmit" type="button" value="Submit" onclick="getUserAccess();" >
            <div id="successContainer">
                <span class="thanksText">Thank you, Continuing Happily</span>
            </div>
        </div>
        <script>
            initLoginPage();
        </script>
    </body>
</html>

