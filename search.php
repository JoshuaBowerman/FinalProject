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
    $q = escape($_GET["q"]);
    $query = "Select Title,Author,Description,YearOfPublication,fType,ISBN from Title where Title like '%$q%' or Author like '%$q%' or Description like '%$q%' LIMIT 25";
    $books = mrQuery($query);
    for ($i = 0; $i < count($books); ++$i) {
        $img = "./pics/". $books[$i][5] . "." .$books[$i][4];
        $title = $books[$i][0];
        $author = $books[$i][1];
        $year = $books[$i][3];
        $desc = $books[$i][2];
        $ISBN = $books[$i][5];
        echo <<<_END
        <div class="grid-item">
            <img src="$img">
            <h2>$title</h2>
            <h3>$author - $year</h3>
            <p>$desc</p>
            <a href="./hold.php?q=$ISBN">Place Hold</a>
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