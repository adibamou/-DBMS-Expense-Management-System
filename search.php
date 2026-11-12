<?php

require "config.php";

$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}


/* =========================
   SEARCH RESULTS
========================= */

$transactions = null;
$budgets = null;
$goals = null;
$categories = null;
$users = null;


/* =========================
   USERS
========================= */

if ($search != "") {

    $like = "%" . $search . "%";

    $stmt = $conn->prepare("
        SELECT
            User_ID,
            Name,
            Email,
            Phone,
            Gender
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


    /* =========================
       CATEGORIES
    ========================= */

    $stmt = $conn->prepare("
        SELECT
            Category_ID,
            Category_Name,
            Category_Type,
            Description,
            Day,
            Status
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


    /* =========================
       TRANSACTIONS
    ========================= */

    $stmt = $conn->prepare("
        SELECT
            t.Transaction_ID,
            t.User_ID,
            t.Category_ID,
            t.Amount,
            t.Description,
            t.Transaction_Date,
            t.Type,
            t.Payment_Method,
            t.Reference_No,
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

        ORDER BY
            t.Transaction_ID DESC
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


    /* =========================
       BUDGET
    ========================= */

    $stmt = $conn->prepare("
        SELECT
            b.Budget_ID,
            b.User_ID,
            b.Budget_Name,
            b.Amount_Limit,
            b.Description,
            b.Start_Date,
            b.End_Date,
            b.Created_At,
            u.Name

        FROM budget b

        LEFT JOIN users u
            ON b.User_ID = u.User_ID

        WHERE
            b.Budget_Name LIKE ?
            OR b.Description LIKE ?
            OR u.Name LIKE ?

        ORDER BY
            b.Budget_ID DESC
    ");

    $stmt->bind_param(
        "sss",
        $like,
        $like,
        $like
    );

    $stmt->execute();

    $budgets = $stmt->get_result();


    /* =========================
       GOALS
    ========================= */

    $stmt = $conn->prepare("
        SELECT
            g.Goal_ID,
            g.User_ID,
            g.Goal_Name,
            g.Target_Amount,
            g.Current_Amount,
            g.Target_Date,
            g.Description,
            g.Status,
            u.Name

        FROM goal g

        LEFT JOIN users u
            ON g.User_ID = u.User_ID

        WHERE
            g.Goal_Name LIKE ?
            OR g.Description LIKE ?
            OR g.Status LIKE ?
            OR u.Name LIKE ?

        ORDER BY
            g.Goal_ID DESC
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

}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
Search | Expense Management System
</title>

<link
    rel="stylesheet"
    href="style.css"
>

<style>

.search-hero {

    background: linear-gradient(
        135deg,
        #667eea,
        #764ba2
    );

    padding: 45px;

    border-radius: 20px;

    color: white;

    text-align: center;

    margin-bottom: 25px;

}

.search-hero h1 {

    margin: 0 0 10px 0;

    font-size: 32px;

}

.search-hero p {

    margin: 0;

    opacity: .9;

}


.big-search {

    max-width: 800px;

    margin: 25px auto 0;

    display: flex;

    gap: 10px;

}


.big-search input {

    flex: 1;

    padding: 15px 18px;

    border: none;

    border-radius: 10px;

    font-size: 15px;

    outline: none;

}


.big-search button {

    border: none;

    cursor: pointer;

}


.result-title {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 15px;

}


.no-result {

    text-align: center;

    padding: 35px;

    color: #888;

}


.progress-container {

    width: 100%;

    background: #eee;

    height: 8px;

    border-radius: 10px;

    overflow: hidden;

}


.progress-bar {

    height: 100%;

    background: #198754;

}


</style>

</head>


<body>


<?php require "header.php"; ?>


<div class="content">


<!-- =========================
     SEARCH HERO
========================= -->

<div class="search-hero">

<h1>
🔎 Search Expense Management System
</h1>

<p>
Find users, transactions, categories, budgets and financial goals instantly.
</p>


<form
    method="GET"
    class="big-search"
>


<input
    type="text"
    name="search"
    value="<?php
        echo htmlspecialchars($search);
    ?>"
    placeholder="Search anything..."
    autofocus
>


<button
    type="submit"
    class="btn"
>

Search

</button>


</form>

</div>


<?php if ($search == "") { ?>


<div class="card">

<div class="no-result">

<h2>
Start Searching
</h2>

<p>
Enter a name, category, transaction,
budget or goal above.
</p>

</div>

</div>


<?php } else { ?>


<!-- =========================
     USERS
========================= -->

<div class="card">


<div class="result-title">

<h2>
👤 Users
</h2>

<span>

<?php
echo $users->num_rows;
?>

found

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

</tr>

</thead>


<tbody>


<?php

if (
    $users
    &&
    $users->num_rows > 0
) {

while (
    $row =
    $users->fetch_assoc()
) {

?>


<tr>

<td>
<?php
echo $row['User_ID'];
?>
</td>

<td>
<strong>
<?php
echo htmlspecialchars(
    $row['Name']
);
?>
</strong>
</td>

<td>
<?php
echo htmlspecialchars(
    $row['Email']
);
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

</tr>


<?php

}

} else {

?>

<tr>

<td
    colspan="5"
    class="no-result"
>

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


<div class="result-title">

<h2>
🏷️ Categories
</h2>

<span>

<?php
echo $categories->num_rows;
?>

found

</span>

</div>


<div class="table-wrapper">

<table>

<thead>

<tr>

<th>ID</th>

<th>Category</th>

<th>Type</th>

<th>Description</th>

<th>Day</th>

<th>Status</th>

</tr>

</thead>


<tbody>


<?php

if (
    $categories
    &&
    $categories->num_rows > 0
) {

while (
    $row =
    $categories->fetch_assoc()
) {

?>


<tr>

<td>
<?php
echo $row['Category_ID'];
?>
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
    $row['Description']
    ?? '-'
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

if (
    $row['Status'] == 'Active'
) {

?>

<span style="
color:#198754;
font-weight:bold;
">

● Active

</span>

<?php

} else {

?>

<span style="
color:#dc3545;
font-weight:bold;
">

● <?php
echo htmlspecialchars(
    $row['Status']
);
?>

</span>

<?php

}

?>

</td>

</tr>


<?php

}

} else {

?>

<tr>

<td
    colspan="6"
    class="no-result"
>

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


<div class="result-title">

<h2>
💳 Transactions
</h2>

<span>

<?php
echo $transactions->num_rows;
?>

found

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

<th>Description</th>

</tr>

</thead>


<tbody>


<?php

if (
    $transactions
    &&
    $transactions->num_rows > 0
) {

while (
    $row =
    $transactions->fetch_assoc()
) {

?>


<tr>

<td>

<?php
echo $row['Transaction_ID'];
?>

</td>


<td>

<strong>

<?php
echo htmlspecialchars(
    $row['Name']
    ?? 'Unknown'
);
?>

</strong>

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

৳

<?php
echo number_format(
    $row['Amount'],
    2
);
?>

</strong>

</td>


<td>

<?php

if (
    strtolower(
        $row['Type']
    )
    ==
    'income'
) {

?>

<span style="
color:#198754;
font-weight:bold;
">

+ Income

</span>

<?php

} else {

?>

<span style="
color:#dc3545;
font-weight:bold;
">

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


<td>

<?php

echo htmlspecialchars(
    $row['Description']
    ?? '-'
);

?>

</td>

</tr>


<?php

}

} else {

?>

<tr>

<td
    colspan="8"
    class="no-result"
>

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


<div class="result-title">

<h2>
💰 Budgets
</h2>

<span>

<?php
echo $budgets->num_rows;
?>

found

</span>

</div>


<div class="table-wrapper">

<table>

<thead>

<tr>

<th>ID</th>

<th>User</th>

<th>Budget Name</th>

<th>Amount Limit</th>

<th>Start Date</th>

<th>End Date</th>

<th>Description</th>

</tr>

</thead>


<tbody>


<?php

if (
    $budgets
    &&
    $budgets->num_rows > 0
) {

while (
    $row =
    $budgets->fetch_assoc()
) {

?>


<tr>

<td>

<?php
echo $row['Budget_ID'];
?>

</td>


<td>

<strong>

<?php
echo htmlspecialchars(
    $row['Name']
    ?? 'Unknown'
);
?>

</strong>

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

৳

<?php

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


<td>

<?php

echo htmlspecialchars(
    $row['Description']
    ?? '-'
);

?>

</td>

</tr>


<?php

}

} else {

?>

<tr>

<td
    colspan="7"
    class="no-result"
>

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


<div class="result-title">

<h2>
🎯 Goals
</h2>

<span>

<?php
echo $goals->num_rows;
?>

found

</span>

</div>


<div class="table-wrapper">

<table>

<thead>

<tr>

<th>ID</th>

<th>User</th>

<th>Goal</th>

<th>Target</th>

<th>Current</th>

<th>Progress</th>

<th>Target Date</th>

<th>Status</th>

</tr>

</thead>


<tbody>


<?php

if (
    $goals
    &&
    $goals->num_rows > 0
) {

while (
    $row =
    $goals->fetch_assoc()
) {


$target =
    floatval(
        $row['Target_Amount']
    );

$current =
    floatval(
        $row['Current_Amount']
    );


$progress = 0;


if (
    $target > 0
) {

    $progress =
        ($current / $target) * 100;

}


if (
    $progress > 100
) {

    $progress = 100;

}

?>


<tr>


<td>

<?php
echo $row['Goal_ID'];
?>

</td>


<td>

<strong>

<?php
echo htmlspecialchars(
    $row['Name']
    ?? 'Unknown'
);
?>

</strong>

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

৳

<?php

echo number_format(
    $target,
    2
);

?>

</td>


<td>

৳

<?php

echo number_format(
    $current,
    2
);

?>

</td>


<td style="min-width:120px;">


<div class="progress-container">

<div
    class="progress-bar"
    style="
        width:<?php
            echo $progress;
        ?>%;
    "
>
</div>

</div>


<small>

<?php

echo number_format(
    $progress,
    1
);

?>%

</small>


</td>


<td>

<?php

if (
    !empty(
        $row['Target_Date']
    )
) {

echo date(
    "d M Y",
    strtotime(
        $row['Target_Date']
    )
);

} else {

echo "-";

}

?>

</td>


<td>

<?php
echo htmlspecialchars(
    $row['Status']
);
?>

</td>


</tr>


<?php

}

} else {

?>

<tr>

<td
    colspan="8"
    class="no-result"
>

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


<!-- =========================
     NAVIGATION
========================= -->

<div class="navigation">


<a
    href="goal.php"
    class="back"
>

← Previous: Goals

</a>


<a
    href="dashboard.php"
    class="back"
>

Next: Dashboard →

</a>


</div>


<?php } ?>


</div>


<?php require "footer.php"; ?>


</body>

</html>