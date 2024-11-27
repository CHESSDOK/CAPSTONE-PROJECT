<?php
include 'conn_db.php';

// Fetch all news items
$sql = "SELECT id, title, image, description FROM news ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        h1 {
            text-align: center;
            color: #007bff;
        }
        .news-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .news-item img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .news-item h3 {
            margin: 10px 0;
            color: #007bff;
        }
        .news-item p {
            margin: 10px 0;
            color: #555;
        }
        .news-actions {
            margin-top: 15px;
        }
        .news-actions button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
            margin-right: 10px;
            font-size: 14px;
        }
        .news-actions .btn-edit {
            background-color: #007bff;
        }
        .news-actions .btn-edit:hover {
            background-color: #0056b3;
        }
        .news-actions .btn-delete {
            background-color: #dc3545;
        }
        .news-actions .btn-delete:hover {
            background-color: #a71d2a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage News</h1>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="news-item">
                    <img src="html/adminpage/<?= htmlspecialchars($row['image']); ?>" alt="News Image">
                    <h3><?= htmlspecialchars($row['title']); ?></h3>
                    <p><?= htmlspecialchars($row['description']); ?></p>
                    <div class="news-actions">
                        <form action="update_news.php" method="GET" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                            <button type="submit" class="btn-edit">Edit</button>
                        </form>
                        <form action="delete_news.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this news?')">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No news available to manage.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
