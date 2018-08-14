<?php
include_once "login.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old = $_GET["old"];
    $new1 = $_GET["new1"];
    $new2 = $_GET["new2"];

    if($new1 != $new2){
        header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/pass.php?match=true');
        die();
    }
    $email = escape($_SESSION["username"]);
    $query = "Select PasswordHash from users where email = '$email'";
    $phash = srQuery($query);
    if(!password_verify($old,$phash)){
        //wrong password
        header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/pass.php?old=true');
        die();
    }
    //update password
    $new_hash = password_hash($new1,PASSWORD_DEFAULT);

    $query = "Update users set PasswordHash = '$new_hash' where email = '$email'";
    mrQuery($query);

    include_once "nav.php";
    echo <<<_END
    <h1>Password changed Sucessfully</h1>
_END;



}