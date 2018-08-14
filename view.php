<?php // view.php
    require_once 'login.php'; //authentication
    require_once 'nav.php';   //navbar and header
    if(!isset($_GET['isbn']))
    {
        $isbn = $_GET['isbn'];
        $_isbn = mysqli_real_escape_string($conn,$isbn);
        $query = "SELECT ISBN,Title,Author,Description,YearOfPublication,fType From Title Where ISBN='$_isbn'";
        $result = $conn->query($query);
        if($result->num_rows != 1){
            header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/index.php');
            die();
        }
        $row = $result->fetch_array(MYSQLI_NUM);
        $title = $row[1];
        $author = $row[2];
        $desc = $row[3];
        $year = $row[4];
        $query = "SELECT COUNT(ISBN) FROM Assets where ISBN='$_isbn'";
        $result = $conn->query($query);
        if($result->num_rows != 1){
            header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/index.php');
            die();
        }
        $row = $result->fetch_array(MYSQLI_NUM);
        $copies = $row[0];
        $query = "SELECT COUNT(ISBN) FROM Assets join Title on Assets.CopyID = Title.CopyID where ISBN='$_isbn'";
        $result = $conn->query($query);
        if($result->num_rows != 1){
            header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/index.php');
            die();
        }
        $row = $result->fetch_array(MYSQLI_NUM);
        $available = $copies - $row[0];
        $hold = "TODO";
        echo <<<_END
        <h1>$title - $year</h1>
        <h2>$author</h2>
        
        <img src="./img/book/$isbn.$type"alt="Book Cover">
        <p>$desc</p>
        <h3>Copies: $copies</h3>
        <h3>Available: $available</h3>
        <h3>On Hold: $hold</h3>
        <a href="./hold.php?q=$isbn">Put on Hold</a>

_END;


    }else{
        header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/login.php');
        die();
    }
?>
