<?php
include 'php/conn_db.php';
// Fetch the latest news items
$sql = "SELECT title, image, description FROM news ORDER BY created_at DESC LIMIT 10";
$result = $conn->query($sql);

// Check if there are news items
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="news-item">';
        echo '<img src="html/adminpage/' . htmlspecialchars($row["image"]) . '" alt="News Image">';
        echo '<div class="news-title">' . htmlspecialchars($row["title"]) . '</div>';
        echo '<div class="news-description">' . htmlspecialchars($row["description"]) . '</div>';
        echo '</div>';
    }
} else {
    echo '<p>No news available.</p>';
}

// Close the database connection
$conn->close();
?>
