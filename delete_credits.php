<?php
require "config.php";

// Check if ID is passed
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = $_GET['id'];

    try {
        // Prepare delete query (secure)
        $stmt = $conn->prepare("DELETE FROM credits WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        // Redirect back to credit page
        header("Location: credits.php?deleted=1");
        exit();

    } catch (PDOException $e) {
        echo "Error deleting credits record: " . $e->getMessage();
    }

} else {
    echo "Invalid request. No credit ID provided.";
}
?>