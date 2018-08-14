<?php
include_once 'login.php';
if($_SESSION['level'] < 1){ //is this person not a librarian or higher
    //they are not, redirect to index
    header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/index.php');
    die();
}
include_once 'nav.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $password= $_POST["pword"];
    $email= $_POST["email"];
    $_email = mysqli_real_escape_string($conn,$email);
    $first= $_POST["fname"];
    $_first = mysqli_real_escape_string($conn,$first);
    $last= $_POST["lname"];
    $_last = mysqli_real_escape_string($conn,$last);
    $level= $_POST["level"];
    $_level = mysqli_real_escape_string($conn,$level);
    $phash = password_hash($password,PASSWORD_DEFAULT);
    if(level <= $_SESSION['level']) {

    $query = "Insert into Users (firstname,lastname,email,PasswordHash,UserLevel,IsTemporary) VALUES ('$_first','$_last','$_email','$phash',$_level,true)";
    $conn->query($query);
    echo "<h2> Success! Temporary Password is ".$_POST["pword"]." </h2>";
}else {
    echo "<h2> Unable to add user due to invalid user level!</h2>";
}}
echo <<<_END
<h1> Checkout </h1>
<form action="./AddUser.php" method="post" class="adduser">
<input type="email" name="email" class="sign-in-email" placeholder="Email address" required autofocus>
<input type="text" name="pword" class="sign-in-email" placeholder="Temporary Password" required>
<input type="text" name="fname" class="sign-in-email" placeholder="First Name" required>
<input type="text" name="lname" class="sign-in-email" placeholder="Last Name" required>
User Level<input type="number" name="level">
<button class="button button-checkout" type="submit">Create User</button>
</form>
_END;
