<?php
require "config.php";

$stmt = $conn->prepare("SELECT * FROM customer ORDER BY id DESC");
$stmt->execute();
$customer = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Customer Page</h1>

<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="customer.php">Customers</a>
    <a href="order.php">Orders</a>
    <a href="sale.php">Sales</a>
    <a href="credits.php">Credits</a>
    <a href="logout.php">Logout</a>
    </nav>

<p>Customer records here.</p>
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
    padding:15px;
    border-radius:10px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
    margin-bottom:20px;
}

input{
    padding:10px;
    margin:5px;
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

.delete-btn{
    background:red;
    padding:5px 10px;
    border:none;
    color:white;
    cursor:pointer;
    border-radius:4px;
}
</style>
</head>

<body>

<header>
<?php require "auth.php"; ?>
    <h1>Customer Management System</h1>
</header>

<div class="container">

    <!-- ADD CUSTOMER FORM -->
    <form method="POST" action="add_customer.php">
        <input type="text" name="name" placeholder="Customer Name" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="text" name="email" placeholder="Email" required>
        <button type="submit">Add Customer</button>
    </form>

    <!-- CUSTOMER TABLE -->
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="customerTable">
            <?php foreach ($customer as $cust): ?>
                <tr>
                    <td><?= $cust['name'] ?></td>
                    <td><?= $cust['phone'] ?></td>
                    <td><?= $cust['email'] ?></td>
                    <td><button class="delete-btn" onclick="deleteCustomer(<?= $cust['id'] ?>)">Delete</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
// DELETE CUSTOMER
function deleteCustomer(customerId){
    if(confirm("Are you sure you want to delete this customer?")){
        window.location.href = "delete_customer.php?id=" + customerId;
    }
}
</script>

</body>
</html>