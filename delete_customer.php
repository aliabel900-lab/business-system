<?php

require "config.php";

if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    $sql = "DELETE FROM customer WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);
}

header("Location: customer.php");
exit;
?>