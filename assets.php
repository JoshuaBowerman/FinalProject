<?php
include_once "login.php";

include_once "nav.php";

echo <<<_END
    <div class="assets">
    <h1>Asset Management</h1>
    
    <a href="createTitle.php">Add/Edit Title</a><br>
    <a href="createCopy.php">Create Copy</a><br>
    <a href="removeCopy.php">Remove Copy From Circulation</a><br>
    </div>
_END;
