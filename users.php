<?php
    include_once "login.php";
    include_once "nav.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $q = escape($_POST["email"]);
    $fname = escape($_POST["fname"]);
    $lname = escape($_POST["lname"]);
    $balance = escape($_POST["balance"]);
    if($_POST["password"] != ""){
        $phash = password_hash(escape($_POST["password"],PASSWORD_DEFAULT));
        $query = "UPDATE users set firstname='$fname',lastname='$lname',Balance='$balance',PasswordHash='$phash',IsTemporary=true where email='$q'";
        mrQuery($query);
    }else{
        $query = "UPDATE users set firstname='$fname',lastname='$lname',Balance='$balance' where email='$q'";
        mrQuery($query);
    }
}

    echo <<<_END
        <h1>User Management</h1>
        <h2>Create a New User</h2>
        <a href="./AddUser.php">Create a User</a>
        <h2>Edit an Existing User</h2>
        <form action="users.php" method="get">
        <input type="text" name="q" placeholder="User Email" required>
        <button type="submit">Submit</button>
</form>
_END;
    if(isset($_GET["q"])){
        $q = escape($_GET["q"]);
        $row = srQuery("Select (firstname,lastname,Balance) from users where email = '$q'");
        $fname = $row[0];
        $lname = $row[1];
        $balance = $row[2];
        echo <<<_END
        <form action ="users.php" method="post">
            <input type="text" name="email" value="$q" style="display: none">
            <input type="text" name="fname" value="$fname" required>
            <input type="text" name="lname" value="$lname" required>
            <input type="number" name="balance" value="$balance" required>
            <input type="text" name="password" placeholder="Temporary Password">
            <button type="Submit">Change</button>
        </form>
_END;
    }
