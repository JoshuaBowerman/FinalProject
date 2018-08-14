<?php
include_once 'login.php';
if($_SESSION['level'] < 1){ //is this person not a librarian or higher
    //they are not, redirect to index
    header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/index.php');
    die();
}
include_once 'nav.php';

echo <<<_END
<h1>Reports</h1>

<h2>Books that have been out the longest.</h2>
_END;




echo <<<_END


<h2>Users who owe the most.</h2>

<h2>users that borrow the most items</h2>


_END;
