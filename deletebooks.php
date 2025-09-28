<?php
require_once "../classes/addproduct.php";
$bookObj = new Books ();



    if($_SERVER["REQUEST_METHOD"] === "GET") {
        if(isset($_GET["id"])) {
            $pid = trim(htmlspecialchars($_GET["id"]));
            $bookObj->deleteBook($pid);
        } else {
            echo "<a href='viewbooks.php'>View Books</a>";
            exit("book not found"); 
        }
    }



    header("Location: viewbooks.php");





?>