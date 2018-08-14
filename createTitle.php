<?php

include_once "login.php";
if($_SESSION['level'] < 1){ //is this person a librarian or higher
    //they are not, redirect to index
    header('Location: http://bowermaj.myweb.cs.uwindsor.ca/60334/project/index.php');
    die();
}
include_once "nav.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ext = explode('.',basename($_FILES["Cover"]["name"]))[1];
    $file_target = "./pics/".$_POST["ISBN"]. "." .$ext;



            if (file_exists($file_target)) {
                //delete file
                unlink($file_target);

            }
            if (move_uploaded_file($_FILES["Cover"]["tmp_name"], $file_target)) {
                //file uploaded sucessfully
                //remove previous record from db
                $ISBN = escape($_POST["ISBN"]);
                mrQuery("DELETE from Title where ISBN = '$ISBN'");
                //create new record
                $title = escape($_POST["Title"]);
                $author = escape($_POST["Author"]);
                $yop = escape($_POST["yop"]);
                $desc = escape($_POST["Description"]);
                $query = "Insert into Title (ISBN, Title, Author, Description, YearOfPublication, fType) VALUES ($ISBN,'$title','$author','$desc',$yop,'$ext')";
                mrQuery($query);

            } else {
                echo "error";
               die("Error Uploading File");
            }


}

echo <<<_END
    <h1>Title Creation and Editing</h1>
    
    <form action="createTitle.php" method="post" enctype="multipart/form-data" >
        <label for="ISBN">ISBN</label>
        <input type="number" name="ISBN" required>
        <label for="Title">Title</label>
        <input type="text" name="Title" required autocapitalize="words">
        <label for="Author">Author</label>
        <input type="text" name="Author" required autocapitalize="words">
        <label for="yop">Year of Publication</label>
        <input type="number" name="yop" required>
        <label for="Description">Description</label>
        <input type="text" name="Description" required autocapitalize="sentences">
        <label for="Cover">Cover Image</label>
        <input type="file" name="Cover" id="Cover" required>
        <button type="submit">Create/Modify Title</button>
    </form>


_END;

