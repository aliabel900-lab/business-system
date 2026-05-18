<?php
require "config.php";

$stmt = $conn->prepare("SELECT * FROM credits ORDER BY id DESC");
$stmt->execute();
$credits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Credit Management</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Credit Management</h1>

<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="customer.php">Customers</a>
    <a href="order.php">Orders</a>
    <a href="sale.php">Sales</a>
    <a href="credits.php">Credits</a>
    <a href="logout.php">Logout</a>
</nav>

<p>Credit records here.</p>
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

/* SUMMARY CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(220px,1fr));
    gap:15px;
    margin-bottom:20px;
}

.card{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

.card h3{
    margin-bottom:10px;
}

.value{
    font-size:24px;
    font-weight:bold;
}

/* FORM */
form{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
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

.paid{
    color:green;
    font-weight:bold;
}

.unpaid{
    color:red;
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
    <h1>Credit Management System</h1>
</header>

<div class="container">

    <!-- SUMMARY -->
    <div class="cards">

        <div class="card">
            <h3>Total Credit Records</h3>
            <div class="value" id="totalCredits">0</div>
        </div>

        <div class="card">
            <h3>Total Credit Amount</h3>
            <div class="value">
                Ksh <span id="creditAmount">0</span>
            </div>
        </div>

        <div class="card">
            <h3>Unpaid Credits</h3>
            <div class="value" id="unpaidCredits">0</div>
        </div>

    </div>

    <!-- FORM -->
    <form action="add_credits.php" method="POST">

         <input type="text" name="customer_name" placeholder="Customer Name">

        <input type="number" name="paid" placeholder="Paid Amount" step="0.01" required>

         <input type="number" name="unpaid" placeholder="Unpaid Amount" step="0.01" required>

        <select name="status" required>
            <option value="">Select Status</option>
            <option value="Paid">Paid</option>
            <option value="Unpaid">Unpaid</option>
        </select>

        <button type="submit">Add Credit</button>

    </form>

    <!-- TABLE -->
    <table>

        <thead>
            <tr>
                <th>Customer</th>
                <th>Paid</th>
                <th>Unpaid </th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="creditTable">
            <?php foreach ($credits as $credits): ?>
                <tr>
                    <td><?= $credits['customer_name'] ?></td>
                    <td>Ksh <?= $credits['paid'] ?></td>
                    <td class="<?= $credits['status'] === 'Paid' ? 'paid' : 'unpaid' ?>">
                        <?= $credits['status'] ?>
                    </td>
                    <td><button class="delete-btn" onclick="deleteCredit(<?= $credits['id'] ?>)">Delete</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</div>

<script>
// CALCULATE CREDIT STATS ON PAGE LOAD
window.addEventListener('DOMContentLoaded', function() {
    let totalCredits = 0;
    let totalAmount = 0;
    let unpaidCredits = 0;
    
    const creditTable = document.getElementById('creditTable');
    const rows = creditTable.getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        if (cells.length > 2) {
            totalCredits++;
            const amountText = cells[1].innerText.replace('Ksh ', '');
            const amount = parseFloat(amountText);
            if (!isNaN(amount)) {
                totalAmount += amount;
            }
            const status = cells[2].innerText;
            if (status === 'Unpaid') {
                unpaidCredits++;
            }
        }
    }
    
    document.getElementById('totalCredits').innerText = totalCredits;
    document.getElementById('creditAmount').innerText = totalAmount.toFixed(2);
    document.getElementById('unpaidCredits').innerText = unpaidCredits;
});

// DELETE CREDIT
function deleteCredit(creditId){
    if(confirm("Are you sure you want to delete this credit record?")){
        window.location.href = "delete_credits.php?id=" + creditId;
    }
}
</script>

</body>
</html>