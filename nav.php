<?php
session_start();
$fname = $_SESSION["fname"];
$isLoggedIn = isset($_SESSION["username"]);
$level = $_SESSION["level"]; //0 being patron, 1 being librarian and 2 being admin
$conn = new mysqli('localhost','bowermaj_db','password','bowermaj_db'); // this is where the db connection is defined for the entire program.
//We need to fetch the branch details.
$query = "Select (Name) from Branch where BranchID = 0";
$row = srQuery($query);
$libraryName = $row[0];
echo <<<_END
<!DOCTYPE html>
<head>
    <script src="./js/jquery.js"></script>
    <link rel="stylesheet" href="./css/style.css"/>
</head>

<body>
    <img src="./pics/branch.png" width="15%" alt="Library Branch Logo">
    <h1 class="title">$libraryName</h1>
    <nav>
        <ul>
            <li><a href="./index.php">Home</a></li>
            <li><a href="./search.php">Search</a></li>
            <li><a href="./browse.php">Browse</a></li>
            <li class="right">
_END;
//Figuring out what belongs on the right side of the navbar.
if($isLoggedIn){
    echo <<<_END
    <div class="dropdown">
        <a class="dropbutton" href="#">$fname
            <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown">
            <li><a href="./pass.php">Change Password</a></li>
_END;
    if($level >= 1){//librarian or admin
        echo <<<_END
            <li><a href="./users.php">User Management</a></li>
            <li><a href="./assets.php">Assets</a></li>
            <li><a href="./reports.php">Reports</a></li>
_END;

    }
    if($level == 2){
        echo <<<_END
            <li><a href="./branch.php">Branch</a>
_END;

    }

    echo <<<_END
        <li><a href="./logout.php">Logout</a></li>
        </ul>
    </div>
_END;

}else{
    echo <<<_END
<a href="./login.php">Login</a>
_END;

}
echo  <<<_END
</li>
        </ul>
    </nav>    
        

_END;
//Some functions to make sql queries easier

    //this will return a single row result for the supplied query
    //Note this will die if there is no resultant row.
    function srQuery($query){
        $conn = new mysqli('localhost','bowermaj_db','password','bowermaj_db');
        $result = $conn->query($query);
        if(!$result) die("Database access failed: " . $conn->error);
        if($result->num_rows != 1){
            header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/Error.php');
            die();
        }
        $row = $result->fetch_array(MYSQLI_NUM);
        return $row;
    }

    //this function cleans a string.
    function escape($string){
        $conn = new mysqli('localhost','bowermaj_db','password','bowermaj_db');
        return mysqli_real_escape_string($conn,$string);
    }

    function mrQuery($query){
        $conn = new mysqli('localhost','bowermaj_db','password','bowermaj_db');
        $result = $conn->query($query);
        $arr =[];
        $arr;
        $rows = $result->num_rows;
        for($j = 0 ; $j < $rows; ++$j){
            $result->data_seek($j);
            $row = $result->fetch_array(MYSQLI_NUM);
            $arr[$j] = $row;
        }
        return $arr;
    }
?>