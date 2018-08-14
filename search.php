<?php
include_once "login.php";
include_once "nav.php";
if(isset($_GET["q"])) {

    echo <<<_END
        <form action="./search.php" method="get">
        <input type="text" name="q" placeholder="Title,Author or Description">
        <button type="submit">Search</button>
    </form>
    
    
    <div class="grid-container">
_END;
//get all books currently out by this user.
    $q = escape($_GET["q"]);
    $query = "Select (Title,Author,Description,YearOfPublication,fType,ISBN) from Title where Title like '$q' or Author like '$q' or Description like '$q' and (SELECT COUNT(CopyID) from Assets where Title.ISBN = Assets.ISBN) > 0 LIMIT 25";
    $books = mrQuery($query);
    for ($i = 0; $i < count($books); ++$i) {
        echo <<<_END
        <div class="grid-item">
            <img src="$books[$i][5].$books[$i][4]">
            <h2>$books[$i][0]</h2>
            <h3>$books[$i][1] - $books[$i][3]</h3>
            <p>$books[$i][2]</p>
            <a href="./hold.php?q=$books[$i][5]">Place Hold</a>
        </div>
_END;

    }
    echo <<<_END
</div>
_END;
}else{
    echo <<<_END
    <form action="./search.php" method="get">
        <input type="text" name="q" placeholder="Title,Author, or Description">
        <button type="submit">Search</button>
    </form>
_END;



}