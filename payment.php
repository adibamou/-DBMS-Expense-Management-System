<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require "config.php";

/* =========================
   MONTH
========================= */

$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');


/* =========================
   TOTAL INCOME
========================= */

$totalIncome = 0;

$result = $conn->query("
    SELECT COALESCE(SUM(Amount),0) AS total
    FROM transaction_table
    WHERE Type = 'Income'
    AND DATE_FORMAT(Transaction_Date,'%Y-%m') = '$month'
");

if($result){
    $totalIncome = $result->fetch_assoc()['total'];
}


/* =========================
   TOTAL EXPENSE
========================= */

$totalExpense = 0;

$result = $conn->query("
    SELECT COALESCE(SUM(Amount),0) AS total
    FROM transaction_table
    WHERE Type = 'Expense'
    AND DATE_FORMAT(Transaction_Date,'%Y-%m') = '$month'
");

if($result){
    $totalExpense = $result->fetch_assoc()['total'];
}


/* =========================
   BALANCE
========================= */

$balance = $totalIncome - $totalExpense;


/* =========================
   BUDGET
========================= */

$totalBudget = 0;

$result = $conn->query("
    SELECT COALESCE(SUM(Amount_Limit),0) AS total
    FROM budget
    WHERE 
    Start_Date <= LAST_DAY('$month-01')
    AND End_Date >= '$month-01'
");

if($result){
    $totalBudget = $result->fetch_assoc()['total'];
}


/* =========================
   EXTRA SPEND
========================= */

$extraSpend = $totalExpense - $totalBudget;

if($extraSpend < 0){
    $extraSpend = 0;
}


/* =========================
   REMAINING BUDGET
========================= */

$remainingBudget = $totalBudget - $totalExpense;

if($remainingBudget < 0){
    $remainingBudget = 0;
}


/* =========================
   TRANSACTIONS
========================= */

$transactions = $conn->query("
    SELECT
        t.*,
        c.Category_Name,
        u.Name
    FROM transaction_table t

    LEFT JOIN category c
        ON t.Category_ID = c.Category_ID

    LEFT JOIN users u
        ON t.User_ID = u.User_ID

    WHERE DATE_FORMAT(
        t.Transaction_Date,
        '%Y-%m'
    ) = '$month'

    ORDER BY t.Transaction_Date DESC,
             t.Transaction_ID DESC
");

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>
Payment | Expense Management System
</title>

<link rel="stylesheet"
      href="style.css">

<style>

/* =========================
   PAYMENT PAGE
========================= */

.payment-header{

    margin-bottom:25px;

}

.payment-header h1{

    color:#0b465f;

    margin-bottom:8px;

}

.payment-header p{

    color:#87939a;

}


/* MONTH SEARCH */

.month-form{

    background:white;

    border:1px solid #e4e9ec;

    border-radius:12px;

    padding:20px;

    margin-bottom:25px;

    display:flex;

    align-items:end;

    gap:15px;

}

.month-form .form-group{

    max-width:250px;

}


/* SUMMARY */

.payment-summary{

    display:grid;

    grid-template-columns:
        repeat(5,1fr);

    gap:18px;

    margin-bottom:25px;

}

.payment-box{

    background:white;

    border:1px solid #e4e9ec;

    border-radius:12px;

    padding:22px;

}

.payment-title{

    color:#87939a;

    font-size:13px;

    margin-bottom:10px;

}

.payment-value{

    color:#0b465f;

    font-size:23px;

    font-weight:bold;

}

.extra{

    color:#c74747;

}

.remaining{

    color:#198754;

}


/* TABLE */

.payment-card{

    background:white;

    border:1px solid #e4e9ec;

    border-radius:12px;

    padding:24px;

}

.payment-card h2{

    color:#0b465f;

    margin-bottom:20px;

}


/* RESPONSIVE */

@media(max-width:1000px){

    .payment-summary{

        grid-template-columns:
            repeat(2,1fr);

    }

}

@media(max-width:700px){

    .month-form{

        flex-direction:column;

        align-items:stretch;

    }

    .month-form .form-group{

        max-width:none;

    }

    .payment-summary{

        grid-template-columns:1fr;

    }

}

</style>

</head>


<body>


<?php require "header.php"; ?>


<div class="content">


<!-- HEADER -->

<div class="payment-header">

<h1>
💳 Monthly Payment & Spending
</h1>

<p>
Check monthly income, expense, budget, extra spending and remaining amount.
</p>

</div>


<!-- MONTH SELECT -->

<form
    method="GET"
    class="month-form"
>

<div class="form-group">

<label>
Select Month
</label>

<input
    type="month"
    name="month"
    value="<?php echo htmlspecialchars($month); ?>"
>

</div>


<button
    type="submit"
    class="btn"
>

🔎 View Report

</button>

</form>


<!-- SUMMARY -->

<div class="payment-summary">


<div class="payment-box">

<div class="payment-title">
Total Income
</div>

<div class="payment-value">

৳ <?php
echo number_format(
    $totalIncome,
    2
);
?>

</div>

</div>


<div class="payment-box">

<div class="payment-title">
Total Expense
</div>

<div class="payment-value">

৳ <?php
echo number_format(
    $totalExpense,
    2
);
?>

</div>

</div>


<div class="payment-box">

<div class="payment-title">
Monthly Budget
</div>

<div class="payment-value">

৳ <?php
echo number_format(
    $totalBudget,
    2
);
?>

</div>

</div>


<div class="payment-box">

<div class="payment-title">
Extra Spend
</div>

<div class="payment-value extra">

৳ <?php
echo number_format(
    $extraSpend,
    2
);
?>

</div>

</div>


<div class="payment-box">

<div class="payment-title">
Remaining Budget
</div>

<div class="payment-value remaining">

৳ <?php
echo number_format(
    $remainingBudget,
    2
);
?>

</div>

</div>


</div>


<!-- TRANSACTIONS -->

<div class="payment-card">

<h2>
📋 Monthly Transactions
</h2>


<div class="table-wrapper">

<table>

<thead>

<tr>

<th>ID</th>

<th>User</th>

<th>Category</th>

<th>Amount</th>

<th>Type</th>

<th>Payment Method</th>

<th>Date</th>

</tr>

</thead>


<tbody>

<?php

if(
    $transactions &&
    $transactions->num_rows > 0
){

while(
    $row =
    $transactions->fetch_assoc()
){

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
    $row['Name']
    ?? 'Unknown'
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

৳ <?php

echo number_format(
    $row['Amount'],
    2
);

?>

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

echo htmlspecialchars(
    $row['Payment_Method']
    ?? '-'
);

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

</tr>

<?php

}

}else{

?>

<tr>

<td
    colspan="7"
    style="
        text-align:center;
        padding:30px;
        color:#888;
    "
>

No transactions found for this month.

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

<a
    href="goal.php"
    class="back"
>
← Previous: Goals
</a>


<a
    href="database.php"
    class="back"
>
Next: Database →
</a>

</div>


</div>


<?php require "footer.php"; ?>


</body>

</html>