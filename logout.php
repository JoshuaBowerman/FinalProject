<?php
session_start();
unset($_SESSION["username"]);
header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/login.php');
die();

?>