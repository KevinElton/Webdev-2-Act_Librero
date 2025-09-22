\<?php
require_once "../classes/book.php";

$bookObj = new Book();

$search = isset($_GET["search"]) ? trim(htmlspecialchars($_GET["search"])) : "";
$genre = isset($_GET["genre"]) ? trim(htmlspecialchars($_GET["genre"])) : "";

$books = $bookObj->viewBooks($genre, $search);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="/project/style.css">
</head>
<body>
    <h1>View Books</h1>
    <div class="top-bar">
        <?php if (isset($_GET["success"])): ?>
            <p class="success">Book added successfully!</p>
        <?php endif; ?>
        <a href="/Library/book/add-book.php" style="padding:8px 12px; background:green; color:white; text-decoration:none; border-radius:5px;">
            Add Book
        </a>
    </div>

    <form method="get" style="margin:15px 0;">
        <label for="search">Search:</label>
        <input type="search" name="search" id="search" placeholder="Search by title..." value="<?= htmlspecialchars($search) ?>">
        <select name="genre" id="genre">
            <option value="">All Genres</option>
            <option value="Fantasy" <?= $genre=="Fantasy" ? "selected" : "" ?>>Fantasy</option>
            <option value="Romance" <?= $genre=="Romance" ? "selected" : "" ?>>Romance</option>
            <option value="Science Fiction" <?= $genre=="Science Fiction" ? "selected" : "" ?>>Science Fiction</option>
            <option value="Mystery" <?= $genre=="Mystery" ? "selected" : "" ?>>Mystery</option>
            <option value="History" <?= $genre=="History" ? "selected" : "" ?>>History</option>
        </select>
        <button type="submit">Filter</button>
    </form>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Publication Year</th>
        </tr>
        <?php if ($books): ?>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book["title"]) ?></td>
                    <td><?= htmlspecialchars($book["author"]) ?></td>
                    <td><?= htmlspecialchars($book["genre"]) ?></td>
                    <td><?= htmlspecialchars($book["publication_year"]) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">No books found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
