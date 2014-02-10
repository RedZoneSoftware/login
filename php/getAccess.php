<?php

session_start();
$user_ip = $_SERVER["REMOTE_ADDR"];
$login_time = date('l jS \of F Y h:i:s A');
date_default_timezone_set('America/Denver');

// student class, default constructor makes a non validated student with just
// the log in name submitted and non-validated status.  we change the student
// to validated as required if we find a valid student to log in.
class Student {

    function __construct($username) {
        $this->username = $username;
        $this->validated = false;
        $this->redirect = "";
        $this->roles = [];
    }

}

// set up the session vars we need
function createSessionVars($student) {
    global $user_ip, $login_time;

    $_SESSION['username'] = $student->username;
    $_SESSION['roles'] = $student->roles;
    $_SESSION['login_date_time'] = $login_time;
    $_SESSION['ip_address'] = $user_ip;
    $_SESSION['redirect'] = $student->redirect;
}

// create the session if we need one
// return the user information and let
// the ajax return handle the result
function create_signin($student) {
    global $user_ip, $login_time;
    // create the session and student info
    // we need for a validated login
    if ($student->validated) {
        createSessionVars($student);
        $student->session = session_id();
        $student->ip_addy = $user_ip;
        $student->date_now = $login_time;
        return json_encode($student);
    // for non-validated logins, just return 
    // enough info to not log in the user
    } else {
        return json_encode($student);
    }
}

// get our json user list and see if the user validates
function validate_user($username, $redirect) {
    $student = new Student($username);
    $student_list = json_decode(file_get_contents("../users.json"), true);
    foreach ($student_list as $students => $student_object) {
        if ($student_object['username'] === $username) {
            $student->roles = $student_object['roles'];
            $student->redirect = $redirect;
            $student->validated = true;
        }
    }
    echo create_signin($student);
}

// Get the user access data
$username = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$userredi = filter_input(INPUT_POST, 'redi', FILTER_SANITIZE_SPECIAL_CHARS);

// validate the user
$validNameBool = validate_user($username, $userredi);

