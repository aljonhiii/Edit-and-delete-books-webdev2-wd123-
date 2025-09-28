<?php
require_once "../classes/addproduct.php";
$bookObj = new Books();

$books = [];
$errors = [];


if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["id"])) {
        $pid = trim(htmlspecialchars($_GET["id"]));
        $books = $bookObj->fetchBoks($pid);

        if (!$books) {
            echo "<a href='viewbooks.php'>View Books</a>";
            exit("Books not found");
        }
    } else {
        header("Location: viewbooks.php");
        exit;
    }
}


elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pid = $_POST["id"] ?? null;


    $books["title"] = trim(htmlspecialchars($_POST["title"]));
    $books["author"] = trim(htmlspecialchars($_POST["author"]));
    $books["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $books["pub_year"] = trim(htmlspecialchars($_POST["pub_year"]));


    if (empty($books["title"])) {
        $errors["title"] = "This field *Title* is required";
    }

    if (empty($books["author"])) {
        $errors["author"] = "This field *Author* is required";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $books["author"])) {
        $errors["author"] = "Author must not contain numbers or special chars";
    }

    if (empty($books["genre"])) {
        $errors["genre"] = "Please select *Genre* (required)";
    }

    $current_year = date("Y");
    if (empty($books["pub_year"])) {
        $errors["pub_year"] = "This field *Publication Year* is required";
    } elseif ($books["pub_year"] > $current_year) {
        $errors["pub_year"] = "Publication year cannot be in the future";
    }

 
    if (empty(array_filter($errors))) {
        $bookObj->title = $books["title"];
        $bookObj->author = $books["author"];
        $bookObj->genre = $books["genre"];
        $bookObj->pub_year = $books["pub_year"];

        if ($bookObj->editBook($pid)) {
            header("Location: viewbooks.php");
            exit;
        } else {
            echo "Failed to update book";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <style>
    /* as for the css i just make it using AI
       /* Import modern font */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #1c1d1dff, #a9a9abff);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Form card */
form {
    width: 380px;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    transition: transform 0.2s ease;
}

form:hover {
    transform: translateY(-4px);
}

/* Title */
h4 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 22px;
    color: #2c3e50;
    font-weight: 600;
}

/* Labels */
label {
    font-weight: 600;
    font-size: 14px;
    margin: 8px 0 6px;
    display: block;
    color: #444;
}

/* Inputs */
input[type="text"],
select {
    width: 100%;
    padding: 12px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    outline: none;
    transition: 0.3s;
    font-family: 'Poppins', sans-serif;
}

input:focus,
select:focus {
    border-color: #3a77d2;
    box-shadow: 0 0 6px rgba(58, 119, 210, 0.3);
}

/* Error messages */
.error {
    color: #e74c3c;
    font-size: 12px;
    margin-top: -5px;
    margin-bottom: 8px;
    font-style: italic;
}

/* Submit button */
input[type="submit"] {
    width: 100%;
    padding: 12px;
    background: #3a77d2;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
    transition: background 0.3s;
    font-weight: 600;
    margin-top: 15px;
}

input[type="submit"]:hover {
    background: #2c5da8;
}

    </style>
</head>
<body>
    <form action="" method="post"> 
        <h4>EDIT BOOK</h4>

        


        <label for="title">Title <span>*</span></label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($books["title"] ?? "") ?>">
        <p class="error"><?= $errors["title"] ?? "" ?></p>

        <label for="author">Author <span>*</span></label>
        <input type="text" name="author" id="author" value="<?= htmlspecialchars($books["author"] ?? "") ?>">
        <p class="error"><?= $errors["author"] ?? "" ?></p>

        <label for="genre">Genre <span>*</span></label>
        <select name="genre" id="genre">
            <option value="">---- SELECT GENRE ----</option>
            <option value="Science" <?= (isset($books["genre"]) && $books["genre"] == 'Science') ? "selected" : "" ?>>Science</option>
            <option value="History" <?= (isset($books["genre"]) && $books["genre"] == 'History') ? "selected" : "" ?>>History</option>
            <option value="Fiction" <?= (isset($books["genre"]) && $books["genre"] == 'Fiction') ? "selected" : "" ?>>Fiction</option>
        </select>
        <p class="error"><?= $errors["genre"] ?? "" ?></p>

        <label for="pub_year">Publication Year <span>*</span></label>
        <input type="text" name="pub_year" id="pub_year" value="<?= htmlspecialchars($books["pub_year"] ?? "") ?>">
        <p class="error"><?= $errors["pub_year"] ?? "" ?></p>

        <input type="submit" value="Update Book">
    </form>
</body>
</html>
