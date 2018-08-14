<?php
    include_once "login.php";
    include_once "nav.php";
    $email = escape($_SESSION["username"]);
    $row = srQuery("Select (Balance) from users where email = '$email'");
    $cents = $row[0] % 100;
    $dollars = ($row[0] - ($row[0] % 100))/ 100;
    $row = srQuery("Select (Count(a.ISBN)) from Holds as a where a.DateHeld < all(SELECT (b.DateHeld) from Holds as b where b.ISBN = a.ISBN ) and a.email = '$email' and 0 =  (SELECT count(CopyID) from Assets as t where ISBN = a.ISBN and not exists(Select * from Records as g where t.CopyID = g.CopyID and g.DateReturned = null ))");
    $holds = 0;
    $holds = $row[0];
    echo <<<_END
    <h1>Welcome $fname </h1>
    <h2>Your current Balance is \$$dollars.$cents.</h2>
    <h2>You have $holds holds available to be picked up.</h2>
    

    <!-- books due soon -->
    <br>
    <br>
    <h2>Items Currently Taken Out</h2>
    <div class="grid-container">
_END;
    //get all books currently out by this user.
    $books = mrQuery("Select (DateBorrowed, ISBN, Title, Author, fType) from (Title JOIN (Records join Assets on Records.CopyID = Assets.CopyID) on Title.ISBN = Assets.ISBN) where BorrowerEMAIL ='".escape($_SESSION["username"]."' AND DateReturned = NULL ORDER BY DateBorrowed ASC"));
    for($i = 0; $i < count($books); ++$i){
        echo <<<_END
        <div class="grid-item">
            <img src="$books[$i][1].$books[$i][4]">
            <h3>$books[$i][2] - $books[$i][3]</h3>
            Borrowed on: $books[$i][1]
        </div>
_END;

    }
    echo <<<_END
</div>
_END;



/**
 * Created by PhpStorm.
 * User: josh
 * Date: 13/08/18
 * Time: 6:31 PM
 */