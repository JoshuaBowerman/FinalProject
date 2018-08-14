<?php
include_once "login.php";
if($_SESSION['level'] < 1){ //is this person a librarian or higher
    //they are not, redirect to index
    header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/index.php');
    die();
}
include_once "nav.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $cid = escape($_POST["CopyID"]);
    $isbn = escape($_POST["ISBN"]);
    mrQuery("Insert Into Assets (ISBN,CopyID,BranchID) VALUES ('$isbn',$cid,0)");
    echo "<h3>Created Copy With ID of $cid</h3>";
}

    $row = srQuery("SELECT MAX(CopyID) from Assets");
    $id = $row[0] + 1;

echo <<<_END
    <form action="./createCopy.php" method="post">
        <label for="CopyID">Copy ID</label>
        <input type="number" name="CopyID" value="$id">
        <label for="ISBN">ISBN</label>
        <input type="text" name="ISBN">
        <button type="submit">Create Copy</button>
    </form>
_END;
