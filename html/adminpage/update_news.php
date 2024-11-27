<?php
include 'conn_db.php';

// Get the news ID from the query parameter
$id = $_GET['id'];

// Fetch the news item details
$sql = "SELECT * FROM news WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $news = $result->fetch_assoc();
} else {
    echo "News item not found.";
    exit;
}

// Check if the form is submitted for updating
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    // File upload handling
    if (!empty($image)) {
        $target_dir = "html/adminpage/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $image = $news['image']; // Retain existing image if not updated
    }

    // Update the news item
    $update_sql = "UPDATE news SET title = '$title', description = '$description', image = '$image' WHERE id = $id";
    if ($conn->query($update_sql) === TRUE) {
        header("Location: manage_news.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News</title>
</head>
<body>
    <h1>Edit News</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($news['title']); ?>" required>
        <br><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($news['description']); ?></textarea>
        <br><br>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image">
        <br><br>
        <img src="html/adminpage/<?= htmlspecialchars($news['image']); ?>" alt="Current Image" width="100">
        <br><br>
        <button type="submit">Update News</button>
    </form>
</body>
</html>

<?php $conn->close(); ?>
