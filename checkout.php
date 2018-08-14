<?php
include_once 'login.php';
if($_SESSION['level'] < 1){ //is this person a librarian or higher
    //they are not, redirect to index
    header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/index.php');
    die();
}
include_once 'nav.php';
include_once 'nav.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $cids = explode(',',$_POST["CID List"]);
    $email = escape($_POST["email"]);
    for($i = 1; $i < count($cids); ++$i){
        $cid = escape($cids[i]);

        //Take out book
        $query = "Insert Into Records (BorrowerEMAIL, CopyID, DateBorrowed, DateReturned) VALUES ($email,$cid,CURRENT_TIME,NULL)";
        $conn->query($query);
    }

}
echo <<<_END
<h1> Checkin Assets</h1>
<form action="#">
<h2>Items</h2>
<p id="list">

</p>
_END;
if($_GET["email"]){
    echo "<h2>No Account Associated With Provided Email Address</h2>";
}
echo <<<_END
<input type="text" name="email" placeholder="Borrower Email" required autofocus>
<input type="text" name="CID List" style="display: none;"id="actual">
<input type="number" class="input-CID" id="target" placeholder="Copy ID">
<button class="button button-checkout" id="Add" type="button" >Add</button>
<button class="button button-checkout" type="submit">Checkin</button>
</form>

<script type="application/javascript" src="./js/multi.js"></script>
_END;
