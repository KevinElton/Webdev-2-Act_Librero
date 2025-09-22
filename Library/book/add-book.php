<?php
require_once "../classes/book.php";    

$bookData = ["title" => "", "author" => "", "genre" => "", "publication_year" => ""];
$errors = ["title" => "", "author" => "", "genre" => "", "publication_year" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookData["title"] = trim(htmlspecialchars($_POST["title"] ?? ""));
    $bookData["author"] = trim(htmlspecialchars($_POST["author"] ?? ""));
    $bookData["genre"] = trim(htmlspecialchars($_POST["genre"] ?? ""));
    $bookData["publication_year"] = trim(htmlspecialchars($_POST["publication_year"] ?? ""));

    $isValid = true;

    if (empty($bookData["title"])) {
        $errors["title"] = "Title is required";
        $isValid = false;
    }

    if (empty($bookData["author"])) {
        $errors["author"] = "Author is required";
        $isValid = false;
    }

    if (empty($bookData["genre"])) {
        $errors["genre"] = "Genre is required";
        $isValid = false;
    }

    if (empty($bookData["publication_year"])) {
        $errors["publication_year"] = "Publication year is required";
        $isValid = false;
    } elseif ((int)$bookData["publication_year"] > (int)date("Y")) {
        $errors["publication_year"] = "Publication year cannot be in the future";
        $isValid = false;
    } elseif ((int)$bookData["publication_year"] < 1500) {
        $errors["publication_year"] = "Publication year must be 1500 or later";
        $isValid = false;
    }

    if ($isValid) {
        $book = new Book();  
        $book->title = $bookData["title"];
        $book->author = $bookData["author"];
        $book->genre = $bookData["genre"];
        $book->publication_year = $bookData["publication_year"];

        if ($book->addBook()) {
            header("Location: /LIBRARY/book/view-books.php?success=1");
            exit;
        } else {
            echo "<p style='color:red;'>Failed to add book.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Book</title>
</head>
<body>
    <h1>Add Book</h1>
    <label>Fields with <span style="color:red">*</span> are required</label>
    <form action="" method="post">
        <label for="title">Book Name *</label><br>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($bookData["title"]) ?>"><br>
        <span style="color:red;"><?= $errors["title"] ?></span><br><br>

        <label for="author">Author *</label><br>
        <input type="text" name="author" id="author" value="<?= htmlspecialchars($bookData["author"]) ?>"><br>
        <span style="color:red;"><?= $errors["author"] ?></span><br><br>

        <label for="genre">Genre *</label><br>
        <select name="genre" id="genre">
            <option value="">--SELECT--</option>
            <option value="History" <?= ($bookData["genre"] == "History") ? "selected" : "" ?>>History</option>
            <option value="Science" <?= ($bookData["genre"] == "Science") ? "selected" : "" ?>>Science</option>
            <option value="Fiction" <?= ($bookData["genre"] == "Fiction") ? "selected" : "" ?>>Fiction</option>
        </select><br>
        <span style="color:red;"><?= $errors["genre"] ?></span><br><br>

        <label for="publication_year">Publication Year *</label><br>
        <input type="number" name="publication_year" id="publication_year"
               min="1500" max="<?= date("Y") ?>"
               value="<?= htmlspecialchars($bookData["publication_year"]) ?>"><br>
        <span style="color:red;"><?= $errors["publication_year"] ?></span><br><br>

        <input type="submit" value="Add Book">
    </form>

    <br>
    <a href="/LIBRARY/book/view-books.php">Back to Book List</a>
</body>
</html>
