<?php
require "config.php";

$stmt = $conn->prepare("SELECT * FROM orders ORDER BY id DESC");
$stmt->execute();
$order = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Orders</title>

<link rel="stylesheet" href="style.css">

<style>

body{
    font-family:Arial, sans-serif;
    margin:0;
    background:#f4f6f9;
}

header{
    background:#0f172a;
    color:white;
    padding:15px;
    text-align:left;
}

nav{
    background:#1e293b;
    padding:10px;
    text-align:left;
}

nav a{
    color:white;
    margin:0 10px;
    text-decoration:none;
}

.container{
    width:90%;
    margin:20px auto;
}

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(200px,1fr));
    gap:15px;
    margin-bottom:20px;
}

.card{
    background:white;
    padding:20px;
    border-radius:10px;
}

.value{
    font-size:24px;
    font-weight:bold;
}

form{
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
}

input, select{
    padding:10px;
    margin:8px;
    width:200px;
}

button{
    padding:10px 15px;
    background:#0f172a;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th, td{
    padding:12px;
    border:1px solid #ddd;
}

th{
    background:#0f172a;
    color:white;
}

.delete-btn{
    background:red;
}

</style>

</head>

<body>

<header>
    <?php require "auth.php"; ?>
    <h1>Orders Management System</h1>
</header>

<nav>
  <a href="dashboard.php">Dashboard</a>
    <a href="customer.php">Customers</a>
    <a href="order.php">Orders</a>
    <a href="sale.php">Sales</a>
    <a href="credits.php">Credits</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="container">

<div class="cards">

    <div class="card">
        <h3>Total Orders</h3>
        <div class="value" id="totalOrders">0</div>
    </div>

    <div class="card">
        <h3>Pending Orders</h3>
        <div class="value" id="pendingOrders">0</div>
    </div>

    <div class="card">
        <h3>Completed Orders</h3>
        <div class="value" id="completedOrders">0</div>
    </div>

</div>

<form action="add_order.php" method="POST">

    <input type="text" name="customer" placeholder="Customer Name" required>

    <input type="text" name="product" placeholder="Product Name" required>

    <select name="status" required>
        <option value="">Select Status</option>
        <option value="Pending">Pending</option>
        <option value="Completed">Completed</option>
    </select>

    <button type="submit">Add Order</button>

</form>

<table>

<thead>
<tr>
    <th>Customer</th>
    <th>Product</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody id="ordersTable">

<?php foreach ($order as $row): ?>

<tr>
    <td><?= htmlspecialchars($row['customer']) ?></td>
<td><?= htmlspecialchars($row['product']) ?></td>
<td><?= htmlspecialchars($row['status']) ?></td>

    <td>
        <button class="delete-btn"
            onclick="deleteOrders(<?= $row['id'] ?>)">
            Delete
        </button>
    </td>
</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<script>

window.addEventListener('DOMContentLoaded', function() {

    let total = 0;
    let pending = 0;
    let completed = 0;

    const rows = document.querySelectorAll('#ordersTable tr');

    rows.forEach(row => {

        total++;

        const status = row.cells[2].innerText;

        if(status === "Pending"){
            pending++;
        }

        if(status === "Completed"){
            completed++;
        }
    });

    document.getElementById('totalOrders').innerText = total;
    document.getElementById('pendingOrders').innerText = pending;
    document.getElementById('completedOrders').innerText = completed;

});

function deleteOrders(id){

    if(confirm("Delete this order?")){

        window.location.href = "delete_order.php?id=" + id;
    }
}

</script>

</body>
</html>