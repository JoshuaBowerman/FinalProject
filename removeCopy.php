<?php
include_once 'login.php';
if($_SESSION['level'] < 1){ //is this person not a librarian or higher
    //they are not, redirect to index
    header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/index.php');
    die();
}
include_once "nav.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cid = escape($_POST["CopyID"]);
    mrQuery("Delete from Assets where CopyID='$cid'");
    mrQuery("Delete from Records where CopyID='$cid'");
    echo "<h2>Removed Copy $cid";
    }

    echo <<<_END
    <h1>Remove a Copy From Circulation</h1>
    <p>Before Removing a copy that is taken out check the copy in to ensure proper fines.</p>
    <form action ="removeCopy.php" method="post">
    <label for="CopyID">Copy ID</label>
    <input type="number" name="CopyID" required>
    <button type="submit">Remove Copy</button>
</form>
_END;
