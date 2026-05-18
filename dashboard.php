<?php
require "config.php";

/* SECURITY CHECK */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* =========================
   GET SUMMARY DATA
========================= */

/* Customers count */
$cust = $conn->query("SELECT COUNT(*) as total FROM customer")->fetch();
$totalCustomer = $cust['total'];

/* Orders count */
$ord = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch();
$totalOrders = $ord['total'];

/* Sales total */
$sale = $conn->query("SELECT SUM(total) as total FROM sale")->fetch();
$totalSale = $sale['total'] ?? 0;

/* Credit total */
$credit = $conn->query("
    SELECT SUM(owed - paid) AS total
    FROM credits
")->fetch();

$totalCredit = $credit['total'] ?? 0;

/* =========================
   GET TABLE DATA
========================= */

$customer = $conn->query("SELECT * FROM customer ORDER BY id DESC LIMIT 5")->fetchAll();
$orders = $conn->query("SELECT * FROM orders ORDER BY id DESC LIMIT 5")->fetchAll();
$saleData = $conn->query("SELECT * FROM sale  ORDER BY id DESC LIMIT 5")->fetchAll();
$credits = $conn->query("SELECT * FROM credits ORDER BY id DESC LIMIT 5")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<style>
body {
    font-family: Arial;
    background: black;
    margin: 0;
    padding: 0;
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

.sidebar {
    width: 220px;
    height: 100vh;
    position: fixed;
    background: #111827;
    color: white;
    padding: 20px;
}

h1, h2 {
    color: white;
}

.sidebar a {
    display: block;
    color: white;
    padding: 10px;
    text-decoration: none;
    background: #1f2937;
    margin-bottom: 10px;
}

.sidebar a:hover {
    background: #1f2937;
}

.main {
    margin-left: 240px;
    padding: 20px;
}

/* Cards */
.cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}

.card {
    background: white;
    padding: 15px;
    border-radius: 8px;
}

/* Tables */
table {
    width: 100%;
    background: white;
    margin-top: 20px;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
}

th {
    background: #1e3a8a;
    color: white;
}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Business Management</h2>

    <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="customer.php">Customers</a>
    <a href="order.php">Orders</a>
    <a href="sale.php">Sales</a>
    <a href="credits.php">Credits</a>
    <a href="logout.php">Logout</a>
    </nav>
</div>

<!-- MAIN -->
<div class="main">

<h1>Dashboard</h1>

<!-- SUMMARY -->
<div class="cards">

    <div class="card">
        <h3>Customers</h3>
        <p><?= $totalCustomer ?></p>
    </div>

    <div class="card">
        <h3>Orders</h3>
        <p><?= $totalOrders ?></p>
    </div>

    <div class="card">
        <h3>Sales</h3>
        <p>$<?= $totalSale ?></p>
    </div>

    <div class="card">
        <h3>Credit</h3>
        <p>$<?= $totalCredit ?></p>
    </div>

</div>

<!-- CUSTOMERS -->
<h2>Latest Customers</h2>
<table>
<tr>
    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
</tr>

<?php foreach($customer as $c): ?>
<tr>
    <td><?= htmlspecialchars($c['name']) ?></td>
    <td><?= htmlspecialchars($c['phone']) ?></td>
    <td><?= htmlspecialchars($c['email']) ?></td>
</tr>
<?php endforeach; ?>

</table>

<!-- ORDERS -->
<h2>Latest Orders</h2>
<table>
<tr>
    <th>Customer</th>
    <th>Product</th>
    <th>Total</th>
    <th>Status</th>
</tr>

<?php foreach($orders as $o): ?>
<tr>
    <td><?= $o['customer'] ?></td>
    <td><?= $o['product'] ?></td>
    <td><?= $o['status'] ?></td>
    <td><?= $o['order_date'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<!-- SALES -->
<h2>Latest Sales</h2>
<table>
<tr>
    <th>Customer</th>
    <th>Amount</th>
    <th>Date</th>
</tr>

<?php foreach($saleData as $s): ?>
<tr>
    <td><?= $s['customer'] ?></td>
    <td>$<?= $s['total'] ?></td>
    <td><?= $s['sale_date'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<!-- CREDITS -->
<h2>Credits / Debt</h2>
<table>
<tr>
    <th>Customer</th>
    <th>unpaid</th>
    <th>Paid</th>
    <th>Balance</th>
</tr>

<?php foreach($credits as $cr): ?>
<tr>

    <td><?= htmlspecialchars($cr['customer_name']) ?></td>

    <td>$<?= number_format($cr['owed'], 2) ?></td>

    <td>$<?= number_format($cr['paid'], 2) ?></td>

    <td>
        $<?= number_format($cr['owed'] - $cr['paid'], 2) ?>
    </td>

</tr>
<?php endforeach; ?>

</table>

</div>

</body>
</html>