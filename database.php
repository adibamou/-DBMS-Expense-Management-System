<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require "config.php";


/* =========================
   SEARCH
========================= */

$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

$like = "%" . $search . "%";


/* =========================
   COUNTS
========================= */

$userCount = 0;
$categoryCount = 0;
$transactionCount = 0;
$budgetCount = 0;
$goalCount = 0;


/* USERS */

$result = $conn->query("
    SELECT COUNT(*) AS total
    FROM users
");

if ($result) {
    $userCount = $result->fetch_assoc()['total'];
}


/* CATEGORY */

$result = $conn->query("
    SELECT COUNT(*) AS total
    FROM category
");

if ($result) {
    $categoryCount = $result->fetch_assoc()['total'];
}


/* TRANSACTIONS */

$result = $conn->query("
    SELECT COUNT(*) AS total
    FROM transaction_table
");

if ($result) {
    $transactionCount = $result->fetch_assoc()['total'];
}


/* BUDGET */

$result = $conn->query("
    SELECT COUNT(*) AS total
    FROM budget
");

if ($result) {
    $budgetCount = $result->fetch_assoc()['total'];
}


/* GOAL */

$result = $conn->query("
    SELECT COUNT(*) AS total
    FROM goal
");

if ($result) {
    $goalCount = $result->fetch_assoc()['total'];
}


/* =========================
   USERS
========================= */

if ($search != "") {

    $stmt = $conn->prepare("
        SELECT
            User_ID,
            Name,
            Email,
            Phone,
            Gender,
            Registration_Date
        FROM users
        WHERE
            Name LIKE ?
            OR Email LIKE ?
            OR Phone LIKE ?
            OR Gender LIKE ?
        ORDER BY User_ID DESC
    ");

    $stmt->bind_param(
        "ssss",
        $like,
        $like,
        $like,
        $like
    );

    $stmt->execute();

    $users = $stmt->get_result();

} else {

    $users = $conn->query("
        SELECT
            User_ID,
            Name,
            Email,
            Phone,
            Gender,
            Registration_Date
        FROM users
        ORDER BY User_ID DESC
    ");

}


/* =========================
   CATEGORY
========================= */

if ($search != "") {

    $stmt = $conn->prepare("
        SELECT *
        FROM category
        WHERE
            Category_Name LIKE ?
            OR Category_Type LIKE ?
            OR Description LIKE ?
            OR Status LIKE ?
        ORDER BY Category_ID DESC
    ");

    $stmt->bind_param(
        "ssss",
        $like,
        $like,
        $like,
        $like
    );

    $stmt->execute();

    $categories = $stmt->get_result();

} else {

    $categories = $conn->query("
        SELECT *
        FROM category
        ORDER BY Category_ID DESC
    ");

}


/* =========================
   TRANSACTIONS
========================= */

if ($search != "") {

    $stmt = $conn->prepare("
        SELECT
            t.*,
            u.Name,
            c.Category_Name
        FROM transaction_table t

        LEFT JOIN users u
            ON t.User_ID = u.User_ID

        LEFT JOIN category c
            ON t.Category_ID = c.Category_ID

        WHERE
            t.Description LIKE ?
            OR t.Type LIKE ?
            OR t.Payment_Method LIKE ?
            OR t.Reference_No LIKE ?
            OR u.Name LIKE ?
            OR c.Category_Name LIKE ?

        ORDER BY t.Transaction_ID DESC
    ");

    $stmt->bind_param(
        "ssssss",
        $like,
        $like,
        $like,
        $like,
        $like,
        $like
    );

    $stmt->execute();

    $transactions = $stmt->get_result();

} else {

    $transactions = $conn->query("
        SELECT
            t.*,
            u.Name,
            c.Category_Name
        FROM transaction_table t

        LEFT JOIN users u
            ON t.User_ID = u.User_ID

        LEFT JOIN category c
            ON t.Category_ID = c.Category_ID

        ORDER BY t.Transaction_ID DESC
    ");

}


/* =========================
   BUDGET
========================= */

if ($search != "") {

    $stmt = $conn->prepare("
        SELECT
            b.*,
            u.Name
        FROM budget b

        LEFT JOIN users u
            ON b.User_ID = u.User_ID

        WHERE
            b.Budget_Name LIKE ?
            OR b.Description LIKE ?
            OR u.Name LIKE ?

        ORDER BY b.Budget_ID DESC
    ");

    $stmt->bind_param(
        "sss",
        $like,
        $like,
        $like
    );

    $stmt->execute();

    $budgets = $stmt->get_result();

} else {

    $budgets = $conn->query("
        SELECT
            b.*,
            u.Name
        FROM budget b

        LEFT JOIN users u
            ON b.User_ID = u.User_ID

        ORDER BY b.Budget_ID DESC
    ");

}


/* =========================
   GOALS
========================= */

if ($search != "") {

    $stmt = $conn->prepare("
        SELECT
            g.*,
            u.Name
        FROM goal g

        LEFT JOIN users u
            ON g.User_ID = u.User_ID

        WHERE
            g.Goal_Name LIKE ?
            OR g.Description LIKE ?
            OR g.Status LIKE ?
            OR u.Name LIKE ?

        ORDER BY g.Goal_ID DESC
    ");

    $stmt->bind_param(
        "ssss",
        $like,
        $like,
        $like,
        $like
    );

    $stmt->execute();

    $goals = $stmt->get_result();

} else {

    $goals = $conn->query("
        SELECT
            g.*,
            u.Name
        FROM goal g

        LEFT JOIN users u
            ON g.User_ID = u.User_ID

        ORDER BY g.Goal_ID DESC
    ");

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>
Database Management | Expense Management System
</title>

<link rel="stylesheet"
      href="style.css">

<style>

.db-hero{
    background:linear-gradient(
        135deg,
        #0b465f,
        #176985
    );

    color:white;

    padding:35px;

    border-radius:15px;

    margin-bottom:25px;
}

.db-hero h1{
    margin-bottom:8px;
}

.db-hero p{
    opacity:.9;
}

.db-search{
    display:flex;
    gap:10px;
    margin-top:20px;
}

.db-search input{
    flex:1;
    border:none;
}

.db-stats{
    display:grid;
    grid-template-columns:
        repeat(5,1fr);

    gap:15px;

    margin-bottom:25px;
}

.db-stat{
    background:white;

    border:1px solid #e4e9ec;

    border-radius:12px;

    padding:20px;

    text-align:center;
}

.db-stat-number{
    font-size:28px;

    font-weight:bold;

    color:#0b465f;

    margin-top:8px;
}

.db-stat-label{
    color:#87939a;

    font-size:13px;
}

.section-title{
    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;
}

.section-title h2{
    margin:0;
}

.section-title span{
    color:#888;

    font-size:13px;
}

@media(max-width:1000px){

    .db-stats{
        grid-template-columns:
            repeat(2,1fr);
    }

}

@media(max-width:600px){

    .db-stats{
        grid-template-columns:1fr;
    }

    .db-search{
        flex-direction:column;
    }

}

</style>

</head>


<body>


<?php require "header.php"; ?>


<div class="content">


<!-- =========================
     HERO
========================= -->

<div class="db-hero">

<h1>
🗄️ Database Management
</h1>

<p>
View and search all records of the
Expense Management System.
</p>


<form
    method="GET"
    class="db-search"
>

<input
    type="text"
    name="search"
    value="<?php
        echo htmlspecialchars($search);
    ?>"
    placeholder="Search users, categories, transactions, budgets or goals..."
>


<button
    type="submit"
    class="btn"
>

🔎 Search

</button>


<a
    href="database.php"
    class="btn"
>

Clear

</a>

</form>

</div>


<!-- =========================
     STATISTICS
========================= -->

<div class="db-stats">


<div class="db-stat">

<div class="db-stat-label">
Users
</div>

<div class="db-stat-number">
<?php echo $userCount; ?>
</div>

</div>


<div class="db-stat">

<div class="db-stat-label">
Categories
</div>

<div class="db-stat-number">
<?php echo $categoryCount; ?>
</div>

</div>


<div class="db-stat">

<div class="db-stat-label">
Transactions
</div>

<div class="db-stat-number">
<?php echo $transactionCount; ?>
</div>

</div>


<div class="db-stat">

<div class="db-stat-label">
Budgets
</div>

<div class="db-stat-number">
<?php echo $budgetCount; ?>
</div>

</div>


<div class="db-stat">

<div class="db-stat-label">
Goals
</div>

<div class="db-stat-number">
<?php echo $goalCount; ?>
</div>

</div>


</div>


<!-- =========================
     USERS
========================= -->

<div class="card">

<div class="section-title">

<h2>
👤 Users
</h2>

<span>
<?php echo $users->num_rows; ?> records
</span>

</div>


<div class="table-wrapper">

<table>

<thead>

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Gender</th>
<th>Registration Date</th>

</tr>

</thead>


<tbody>

<?php

if($users && $users->num_rows > 0){

while($row = $users->fetch_assoc()){

?>

<tr>

<td>
<?php echo $row['User_ID']; ?>
</td>

<td>
<strong>
<?php
echo htmlspecialchars($row['Name']);
?>
</strong>
</td>

<td>
<?php
echo htmlspecialchars($row['Email']);
?>
</td>

<td>
<?php
echo htmlspecialchars(
    $row['Phone'] ?? '-'
);
?>
</td>

<td>
<?php
echo htmlspecialchars(
    $row['Gender'] ?? '-'
);
?>
</td>

<td>
<?php
echo date(
    "d M Y",
    strtotime($row['Registration_Date'])
);
?>
</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="6"
    style="text-align:center;padding:30px;">

No users found.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>


<!-- =========================
     CATEGORIES
========================= -->

<div class="card">

<div class="section-title">

<h2>
🏷️ Categories
</h2>

<span>
<?php echo $categories->num_rows; ?> records
</span>

</div>


<div class="table-wrapper">

<table>

<thead>

<tr>

<th>ID</th>
<th>Category Name</th>
<th>Type</th>
<th>Description</th>
<th>Day</th>
<th>Status</th>

</tr>

</thead>


<tbody>

<?php

if($categories && $categories->num_rows > 0){

while($row = $categories->fetch_assoc()){

?>

<tr>

<td>
<?php echo $row['Category_ID']; ?>
</td>

<td>
<strong>
<?php
echo htmlspecialchars(
    $row['Category_Name']
);
?>
</strong>
</td>

<td>
<?php
echo htmlspecialchars(
    $row['Category_Type']
);
?>
</td>

<td>
<?php
echo htmlspecialchars(
    $row['Description'] ?? '-'
);
?>
</td>

<td>
<?php
echo $row['Day'] ?? '-';
?>
</td>

<td>
<?php
echo htmlspecialchars(
    $row['Status'] ?? '-'
);
?>
</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="6"
    style="text-align:center;padding:30px;">

No categories found.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>


<!-- =========================
     TRANSACTIONS
========================= -->

<div class="card">

<div class="section-title">

<h2>
💳 Transactions
</h2>

<span>
<?php echo $transactions->num_rows; ?> records
</span>

</div>


<div class="table-wrapper">

<table>

<thead>

<tr>

<th>ID</th>
<th>User</th>
<th>Category</th>
<th>Amount</th>
<th>Type</th>
<th>Date</th>
<th>Payment</th>

</tr>

</thead>


<tbody>

<?php

if(
    $transactions &&
    $transactions->num_rows > 0
){

while($row = $transactions->fetch_assoc()){

?>

<tr>

<td>
<?php
echo $row['Transaction_ID'];
?>
</td>

<td>
<?php
echo htmlspecialchars(
    $row['Name'] ?? 'Unknown'
);
?>
</td>

<td>
<?php
echo htmlspecialchars(
    $row['Category_Name']
    ?? 'Unknown'
);
?>
</td>

<td>

<strong>
৳ <?php
echo number_format(
    $row['Amount'],
    2
);
?>
</strong>

</td>

<td>

<?php

if(
    strtolower($row['Type'])
    == 'income'
){

?>

<span class="income">
+ Income
</span>

<?php

}else{

?>

<span class="expense">
- Expense
</span>

<?php

}

?>

</td>

<td>

<?php

echo date(
    "d M Y",
    strtotime(
        $row['Transaction_Date']
    )
);

?>

</td>

<td>

<?php
echo htmlspecialchars(
    $row['Payment_Method']
    ?? '-'
);
?>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="7"
    style="text-align:center;padding:30px;">

No transactions found.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>


<!-- =========================
     BUDGETS
========================= -->

<div class="card">

<div class="section-title">

<h2>
💰 Budgets
</h2>

<span>
<?php echo $budgets->num_rows; ?> records
</span>

</div>


<div class="table-wrapper">

<table>

<thead>

<tr>

<th>ID</th>
<th>User</th>
<th>Budget Name</th>
<th>Limit</th>
<th>Start</th>
<th>End</th>

</tr>

</thead>


<tbody>

<?php

if(
    $budgets &&
    $budgets->num_rows > 0
){

while($row = $budgets->fetch_assoc()){

?>

<tr>

<td>
<?php echo $row['Budget_ID']; ?>
</td>

<td>
<?php
echo htmlspecialchars(
    $row['Name'] ?? 'Unknown'
);
?>
</td>

<td>
<strong>
<?php
echo htmlspecialchars(
    $row['Budget_Name']
);
?>
</strong>
</td>

<td>
৳ <?php
echo number_format(
    $row['Amount_Limit'],
    2
);
?>
</td>

<td>
<?php
echo date(
    "d M Y",
    strtotime(
        $row['Start_Date']
    )
);
?>
</td>

<td>
<?php
echo date(
    "d M Y",
    strtotime(
        $row['End_Date']
    )
);
?>
</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="6"
    style="text-align:center;padding:30px;">

No budgets found.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>


<!-- =========================
     GOALS
========================= -->

<div class="card">

<div class="section-title">

<h2>
🎯 Goals
</h2>

<span>
<?php echo $goals->num_rows; ?> records
</span>

</div>


<div class="table-wrapper">

<table>

<thead>

<tr>

<th>ID</th>
<th>User</th>
<th>Goal Name</th>
<th>Target</th>
<th>Current</th>
<th>Target Date</th>
<th>Status</th>

</tr>

</thead>


<tbody>

<?php

if(
    $goals &&
    $goals->num_rows > 0
){

while($row = $goals->fetch_assoc()){

?>

<tr>

<td>
<?php echo $row['Goal_ID']; ?>
</td>

<td>
<?php
echo htmlspecialchars(
    $row['Name'] ?? 'Unknown'
);
?>
</td>

<td>
<strong>
<?php
echo htmlspecialchars(
    $row['Goal_Name']
);
?>
</strong>
</td>

<td>
৳ <?php
echo number_format(
    $row['Target_Amount'],
    2
);
?>
</td>

<td>
৳ <?php
echo number_format(
    $row['Current_Amount'],
    2
);
?>
</td>

<td>

<?php

if(!empty($row['Target_Date'])){

echo date(
    "d M Y",
    strtotime(
        $row['Target_Date']
    )
);

}else{

echo "-";

}

?>

</td>

<td>
<?php
echo htmlspecialchars(
    $row['Status'] ?? '-'
);
?>
</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="7"
    style="text-align:center;padding:30px;">

No goals found.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>


<!-- NAVIGATION -->

<div class="navigation">

<a href="search.php"
   class="back">

← Previous: Search

</a>


<a href="index.php"
   class="back">

Next: Dashboard →

</a>

</div>


</div>


<?php require "footer.php"; ?>


</body>

</html>