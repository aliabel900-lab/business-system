<?php

require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customer = trim($_POST['customer']);
    $product = trim($_POST['product']);
    $price = (float)$_POST['price'];
    $quantity = (int)$_POST['quantity'];
    $total = $price * $quantity;

    if (!empty($customer) && !empty($product)) {

        $sql = "INSERT INTO sale (customer, product, price, quantity, total)
                VALUES (:customer, :product, :price, :quantity, :total)";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':customer' => $customer,
            ':product' => $product,
            ':price' => $price,
            ':quantity' => $quantity,
            ':total' => $total
        ]);
    }
}

header("Location: sale.php");
exit;

?>