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

    $query = "Update users set PasswordHash = '$new_hash',IsTemporary=false where email = '$email'";
    mrQuery($query);

    include_once "nav.php";
    echo <<<_END
    <h1>Password changed Successfully</h1>
_END;



}
include_once "nav.php";
if($_GET["old"]){
    echo "<h2>Old Password is Incorrect!</h2>";
}
if($_GET["old"]){
    echo "<h2>Passwords Do Not Match!</h2>";
}

echo <<<_END
    <h1>Change Password</h1>
    <form action="pass.php" method="post">
    <label for="old">Old Password</label>
    <input type="password" name="old" required>
    <label for="new1">New Password</label>
    <input type="password" name="new1" required>
    <label for="new2">New Password</label>
    <input type="password" name="new2" required>
    <button type="submit">Change Password</button>
</form>
_END;
