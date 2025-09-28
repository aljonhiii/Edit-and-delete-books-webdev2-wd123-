<?php
require_once "../classes/addproduct.php";
$bookObj = new Books();
$books = $bookObj->viewBook();

$results = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $results = $bookObj->searchBook($_GET['search']);
} else {
    $results = $bookObj->viewBook();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Books</title>
    <style>
      body {
    font-family: Arial, sans-serif;
    background: #5f5e5eff;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 40px;
}

.container {
    background: #2c2f33;
    color: #fff;
    padding: 40px;
    border-radius: 12px;
    width: 1000px; /* wider size */
    box-shadow: 0 6px 20px rgba(0,0,0,0.35);
}

.container h2 {
    margin-bottom: 25px;
    font-size: 28px; /* larger title */
}

.search-box {
    display: flex;
    gap: 12px;
    margin-bottom: 25px;
}

.search-box input {
    flex: 1;
    padding: 14px;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    outline: none;
}

.search-box button {
    background: #f1c40f;
    border: none;
    padding: 14px 24px;
    font-weight: bold;
    cursor: pointer;
    border-radius: 6px;
    font-size: 16px;
    color: #000;
}

.search-box button:hover {
    background: #d4ac0d;
}

a.add-btn {
    display: inline-block;
    margin-bottom: 25px;
    background: #f1c40f;
    color: #000;
    text-decoration: none;
    padding: 14px 22px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 6px;
}

a.add-btn:hover {
    background: #d4ac0d;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background: #1e2124;
    border-radius: 8px;
    overflow: hidden;
    font-size: 16px; /* bigger text */
}

table th, table td {
    padding: 16px;
    text-align: left;
}

table th {
    background: #111;
    font-size: 17px;
}

table tr:nth-child(even) {
    background: #2c2f33;
}

.btn-action {
    display: inline-block;
    padding: 10px 18px;
    border-radius: 6px;
    font-size: 15px;
    font-weight: bold;
    text-decoration: none;
    margin-right: 6px;
}

.btn-edit {
    background: #3498db;
    color: #fff;
}

.btn-edit:hover {
    background: #2980b9;
}

.btn-delete {
    background: #e74c3c;
    color: #fff;
}

.btn-delete:hover {
    background: #c0392b;
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Book Management</h2>

        <form method="GET" action="">
            <div class="search-box">
                <input type="text" name="search" placeholder="Search books..."
                       value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit">Search</button>
            </div>
        </form>

        <a href="addbooks.php" class="add-btn">+ Add New Book</a>

        <table>
            <tr>
                <th>ID</th>
                <th>TITLE</th>
                <th>AUTHOR</th>
                <th>GENRE</th>
                <th>PUB_YEAR</th>
                <th>ACTION</th>
            </tr>
            <?php foreach ($results as $row): ?>
                <?php $message = "Are you sure you want to delete the book '" . $row["title"] . "'?"; ?>
                <tr>
                    <td><?= htmlspecialchars($row["id"]) ?></td>
                    <td><?= htmlspecialchars($row["title"]) ?></td>
                    <td><?= htmlspecialchars($row["author"]) ?></td>
                    <td><?= htmlspecialchars($row["genre"]) ?></td>
                    <td><?= htmlspecialchars($row["pub_year"]) ?></td>
                    <td>
                        <a href="editproduct.php?id=<?= $row["id"] ?>" class="btn-action btn-edit">Edit</a>
                        <a href="deletebooks.php?id=<?= $row["id"] ?>" class="btn-action btn-delete" onclick="return confirm('<?= $message ?>')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
