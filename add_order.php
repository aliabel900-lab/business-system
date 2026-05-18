<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customer = $_POST['customer'];
    $product = $_POST['product'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("
        INSERT INTO orders (customer, product, status)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([$customer, $product, $status]);

    header("Location: order.php");
    exit();
}
?>