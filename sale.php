<?php
require "config.php";

$stmt = $conn->prepare("SELECT * FROM sale ORDER BY id DESC");
$stmt->execute();
$sale = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sales Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Sales Page</h1>

<nav>
  <a href="dashboard.php">Dashboard</a>
    <a href="customer.php">Customers</a>
    <a href="order.php">Orders</a>
    <a href="sale.php">Sales</a>
    <a href="credits.php">Credits</a>
    <a href="logout.php">Logout</a>
</nav>

<p>Sales records here.</p>
<style>
body{
    font-family: Arial;
    margin: 0;
    padding: 20px;
}

nav{
    background: black;
    padding: 15px;
}

nav a{
    color: white;
    text-decoration: none;
    margin-right: 20px;
    font-size: 18px;
}

nav a:hover{
    color: orange;
}

/* HEADER */
header{
    background:#0f172a;
    color:white;
    padding:15px;
    text-align:center;
}

/* CONTAINER */
.container{
    width:90%;
    margin:20px auto;
}

/* FORM */
form{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
    margin-bottom:20px;
}

input{
    padding:10px;
    margin:8px;
    width:200px;
}

button{
    padding:10px 15px;
    background:#0f172a;
    color:white;
    border:none;
    cursor:pointer;
    border-radius:5px;
}

button:hover{
    background:#1e293b;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

th, td{
    padding:12px;
    border:1px solid #ddd;
    text-align:left;
}

th{
    background:#0f172a;
    color:white;
}

/* TOTAL BOX */
.total-box{
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:10px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
    font-size:20px;
    font-weight:bold;
}

.delete-btn{
    background:red;
    padding:5px 10px;
    border:none;
    color:white;
    border-radius:4px;
    cursor:pointer;
}
</style>
</head>

<body>

<header>
    <?php require "auth.php"; ?>
    <h1>Sales Management System</h1>
</header>

<div class="container">

    <!-- TOTAL SALES -->
    <div class="total-box">
        Total Sales: Ksh <span id="totalSales">0</span>
    </div>

    <!-- SALES FORM -->
    <form action="add_sale.php" method="POST">

        <input type="text" name="customer" placeholder="Customer Name" required>

        <input type="text" name="product" placeholder="Product Name" required>

        <input type="number" name="price" placeholder="Price" step="0.01" required>

        <input type="number" name="quantity" placeholder="Quantity" required>

        <button type="submit">Add Sale</button>

    </form>

    <!-- SALES TABLE -->
    <table>

        <thead>
            <tr>
                <th>Customer</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="salesTable">
            <?php foreach ($sale as $sale): ?>
                <tr>
                    <td><?= $sale['customer'] ?></td>
                    <td><?= $sale['product'] ?></td>
                    <td><?= $sale['price'] ?></td>
                    <td><?= $sale['quantity'] ?></td>
                    <td><?= $sale['total'] ?></td>
                    <td><button class="delete-btn" onclick="deleteSale(<?= $sale['id'] ?>)">Delete</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</div>

<script>
// DELETE SALE
function deleteSale(saleId){
    if(confirm("Are you sure you want to delete this sale?")){
        window.location.href = "delete_sale.php?id=" + saleId;
    }
}
</script>

</body>
</html>