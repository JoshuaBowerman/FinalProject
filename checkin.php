<?php
include_once 'login.php';
if($_SESSION['level'] < 1){ //is this person a librarian or higher
    //they are not, redirect to index
    header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/index.php');
    die();
}
include_once 'nav.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
   $cids = explode(',',$_POST["CID List"]);
   for($i = 1; $i < count($cids); ++$i){
       $cid = escape($cids[i]);

       //calculate late fees
       $row = srQuery("Select (DATEDIFF(day,DateBorrowed,Current_TIME),BorrowerEMAIL) from Records where DateReturned = NULL");
       $email = $row[1];
       $days= $row[0];
       $row = srQuery("Select (LateFee,BorrowPeriod) from Branch where BranchID = 0");
       $fee = ($days - $row[1]) * $row[0];
       if( $fee > 0){
           //apply fee
           $query = "UPDATE users set Balance = (Balance + $fee) where email='$email'";
           $conn->query($query);
       }
            //return book
            $query = "UPDATE Records set DateReturned = CURRENT_TIME where CopyID = $cid AND DateReturned = NULL ";
            $conn->query($query);
   }

}
echo <<<_END
<h1> Checkin Assets</h1>
<form action="#">
<h2>Items</h2>
<p id="list">

</p>

<input type="text" name="CID List" style="display: none;"id="actual">
<input type="number" class="input-CID" id="target" placeholder="Copy ID">
<button class="button button-checkout" id="Add" type="button" >Add</button>
<button class="button button-checkout" type="submit">Checkin</button>
</form>

<script type="application/javascript" src="./js/multi.js"></script>
_END;
//TODO: Write jquery to allow multiple books

