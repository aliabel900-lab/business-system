<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // GET VALUES FROM FORM
    $customer_name = trim($_POST['customer_name']);
    $paid = (float)$_POST['paid'];
    $status = trim($_POST['status']);

    if (!empty($customer_name) && !empty($status)) {

        $sql = "INSERT INTO credits (customer_name, paid, status)
                VALUES (:customer_name, :paid, :status)";

        $stmt = $conn->prepare($sql);

        if ($stmt->execute([
            ':customer_name' => $customer_name,
            ':paid' => $paid,
            ':status' => $status
        ])) {

            header("Location: credits.php");
            exit;

        } else {
            die("Insert failed");
        }
    }
}
?>