<?php
include_once "login.php";
include_once "nav.php";

if(isset($_GET["ID"])){
 //place it on hold
    $id = escape($_GET["ID"]);
    $email = escape($_SESSION["username"]);
    $query = "INSERT into Holds (ISBN,email,DateHeld) VALUES ($id,$email,CURRENT_TIMESTAMP )";
    mrQuery($query); //multirow can return 0 rows
    echo "<h1>Hold Placed</h1>";
}