<?php

require "config.php";

if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    $sql = "DELETE FROM orders WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);
}

header("Location: order.php");
exit;
?>