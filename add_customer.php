<?php

require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name  = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if (!empty($name)) {

        $sql = "INSERT INTO customer (name, phone, email)
                VALUES (:name, :phone, :email)";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':name' => $name,
            ':phone' => $phone,
            ':email' => $email
        ]);
    }
}

header("Location: customer.php");
exit;

?>