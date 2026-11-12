<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require "config.php";


/* =========================
   INITIAL VALUES
========================= */

$user_id = "";
$days = 30;

$totalIncome = 0;
$totalExpense = 0;

$due = 0;
$remainingBalance = 0;

$transactions = null;
$selectedUser = "";


/* =========================
   GET USER
========================= */

if (isset($_GET['user_id'])) {

    $user_id = intval($_GET['user_id']);

}


/* =========================
   GET REPORT PERIOD
========================= */

if (isset($_GET['days'])) {

    $days = intval($_GET['days']);

    if ($days != 7 && $days != 30) {

        $days = 30;

    }

}


/* =========================
   USERS
========================= */

$users = $conn->query("
    SELECT
        User_ID,
        Name
    FROM users
    ORDER BY Name ASC
");


/* =========================
   FINANCIAL STATEMENT
========================= */

if ($user_id > 0) {


    /* =========================
       USER NAME
    ========================= */

    $stmt = $conn->prepare("
        SELECT
            Name
        FROM users
        WHERE User_ID = ?
    ");

    $stmt->bind_param(
        "i",
        $user_id
    );

    $stmt->execute();

    $userResult = $stmt->get_result();


    if ($userResult->num_rows > 0) {

        $selectedUser =
            $userResult->fetch_assoc()['Name'];

    }


    /* =========================
       TOTAL INCOME
    ========================= */

    $stmt = $conn->prepare("
        SELECT
            COALESCE(SUM(Amount),0) AS total
        FROM transaction_table
        WHERE User_ID = ?
        AND Type = 'Income'
        AND Transaction_Date >=
            DATE_SUB(CURDATE(), INTERVAL ? DAY)
    ");

    $stmt->bind_param(
        "ii",
        $user_id,
        $days
    );

    $stmt->execute();

    $result = $stmt->get_result();


    if ($result) {

        $totalIncome =
            $result->fetch_assoc()['total'];

    }


    /* =========================
       TOTAL EXPENSE
    ========================= */

    $stmt = $conn->prepare("
        SELECT
            COALESCE(SUM(Amount),0) AS total
        FROM transaction_table
        WHERE User_ID = ?
        AND Type = 'Expense'
        AND Transaction_Date >=
            DATE_SUB(CURDATE(), INTERVAL ? DAY)
    ");

    $stmt->bind_param(
        "ii",
        $user_id,
        $days
    );

    $stmt->execute();

    $result = $stmt->get_result();


    if ($result) {

        $totalExpense =
            $result->fetch_assoc()['total'];

    }


    /* =========================
       DUE / REMAINING BALANCE
    ========================= */

    $balanceDifference =
        $totalIncome - $totalExpense;


    $due = 0;

    $remainingBalance = 0;


    if ($balanceDifference < 0) {

        /*
         Expense is greater
         than Income
        */

        $due =
            abs($balanceDifference);

    }


    elseif ($balanceDifference > 0) {

        /*
         Income is greater
         than Expense
        */

        $remainingBalance =
            $balanceDifference;

    }


    /* =========================
       TRANSACTIONS
    ========================= */

    $stmt = $conn->prepare("
        SELECT

            t.Transaction_ID,

            t.Amount,

            t.Description,

            t.Transaction_Date,

            t.Type,

            t.Payment_Method,

            c.Category_Name

        FROM transaction_table t

        LEFT JOIN category c

        ON t.Category_ID =
           c.Category_ID

        WHERE t.User_ID = ?

        AND t.Transaction_Date >=
            DATE_SUB(
                CURDATE(),
                INTERVAL ? DAY
            )

        ORDER BY
            t.Transaction_Date DESC,
            t.Transaction_ID DESC
    ");


    $stmt->bind_param(
        "ii",
        $user_id,
        $days
    );


    $stmt->execute();


    $transactions =
        $stmt->get_result();

}

?>


<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">


<meta name="viewport"
      content="width=device-width, initial-scale=1.0">


<title>
Financial Statement | Expense Management System
</title>


<link
    rel="stylesheet"
    href="style.css"
>


<style>


/* =========================
   REPORT SUMMARY
========================= */

.report-summary{

    display:grid;

    grid-template-columns:
    repeat(3,1fr);

    gap:18px;

    margin-bottom:25px;

}


/* =========================
   REPORT BOX
========================= */

.report-box{

    background:white;

    border:1px solid #e4e9ec;

    border-radius:12px;

    padding:22px;

}


.report-box h3{

    color:#87939a;

    font-size:13px;

    margin-bottom:10px;

}


.report-box .amount{

    font-size:24px;

    font-weight:bold;

    color:#0b465f;

}


/* =========================
   FORM
========================= */

.report-form{

    display:grid;

    grid-template-columns:
    1fr 1fr auto;

    gap:15px;

    align-items:end;

}


/* =========================
   RESPONSIVE
========================= */

@media(max-width:800px){

    .report-summary{

        grid-template-columns:1fr;

    }


    .report-form{

        grid-template-columns:1fr;

    }

}


</style>


</head>


<body>


<?php require "header.php"; ?>


<div class="content">


<!-- =========================
     PAGE HEADING
========================= -->

<div class="page-heading">


<h1>

Financial Statement 📅

</h1>


<p>

View a user's financial statement
for the last 7 or 30 days.

</p>


</div>



<!-- =========================
     SELECT USER
========================= -->

<div class="card">


<h2>

Select User & Report Period

</h2>



<form method="GET">


<div class="report-form">


<!-- USER -->

<div class="form-group">


<label>

Select User

</label>


<select
    name="user_id"
    required
>


<option value="">

-- Select User --

</option>


<?php


if (
    $users &&
    $users->num_rows > 0
) {


    while (
        $user =
        $users->fetch_assoc()
    ) {


?>


<option

value="<?php
echo $user['User_ID'];
?>"

<?php


if (
    $user_id ==
    $user['User_ID']
) {

    echo "selected";

}


?>

>


<?php

echo htmlspecialchars(
    $user['Name']
);

?>


</option>


<?php


    }

}


?>


</select>


</div>



<!-- PERIOD -->

<div class="form-group">


<label>

Report Period

</label>


<select name="days">


<option
    value="7"

<?php

echo
$days == 7
? "selected"
: "";

?>

>

Last 7 Days

</option>


<option
    value="30"

<?php

echo
$days == 30
? "selected"
: "";

?>

>

Last 30 Days

</option>


</select>


</div>



<!-- BUTTON -->

<div>


<button
    type="submit"
    class="btn"
>

🔎 Generate Statement

</button>


</div>


</div>


</form>



<?php

if ($user_id > 0) {

?>


<div style="margin-top:18px;">


<a
    href="monthly_report.php"
    class="btn"
>

Clear

</a>


</div>


<?php

}

?>


</div>



<?php

if ($user_id > 0) {

?>



<!-- =========================
     SELECTED USER
========================= -->

<div class="card">


<h2>

Financial Statement

</h2>


<p style="color:#777;">


User:

<strong>

<?php

echo htmlspecialchars(
    $selectedUser
);

?>

</strong>


&nbsp; | &nbsp;


Period:

<strong>

Last
<?php echo $days; ?>
Days

</strong>


</p>


</div>



<!-- =========================
     SUMMARY
========================= -->

<div class="report-summary">



<!-- TOTAL INCOME -->

<div class="report-box">


<h3>

Total Income

</h3>


<div
    class="amount"
    style="color:#198754;"
>


৳

<?php

echo number_format(
    $totalIncome,
    2
);

?>


</div>


</div>



<!-- TOTAL EXPENSE -->

<div class="report-box">


<h3>

Total Expense

</h3>


<div
    class="amount"
    style="color:#c74747;"
>


৳

<?php

echo number_format(
    $totalExpense,
    2
);

?>


</div>


</div>



<!-- DUE OR REMAINING -->

<?php


if ($due > 0) {


?>


<!-- DUE -->

<div class="report-box">


<h3>

Due

</h3>


<div
    class="amount"
    style="color:#c74747;"
>


৳

<?php

echo number_format(
    $due,
    2
);

?>


</div>


</div>


<?php


} else {


?>


<!-- REMAINING BALANCE -->

<div class="report-box">


<h3>

Remaining Balance

</h3>


<div
    class="amount"
    style="color:#198754;"
>


৳

<?php

echo number_format(
    $remainingBalance,
    2
);

?>


</div>


</div>


<?php

}


?>


</div>



<!-- =========================
     TRANSACTIONS
========================= -->

<div class="card">


<h2>

Financial Transactions

</h2>



<div class="table-wrapper">


<table>


<thead>


<tr>


<th>
ID
</th>


<th>
Category
</th>


<th>
Description
</th>


<th>
Amount
</th>


<th>
Type
</th>


<th>
Date
</th>


<th>
Payment Method
</th>


</tr>


</thead>



<tbody>


<?php


if (

    $transactions &&

    $transactions->num_rows > 0

) {


    while (

        $row =

        $transactions->fetch_assoc()

    ) {


?>


<tr>


<!-- ID -->

<td>


<?php

echo
$row['Transaction_ID'];

?>


</td>



<!-- CATEGORY -->

<td>


<?php


echo htmlspecialchars(

    $row['Category_Name']

    ??

    'Uncategorized'

);


?>


</td>



<!-- DESCRIPTION -->

<td>


<?php


echo htmlspecialchars(

    $row['Description']

    ??

    '-'

);


?>


</td>



<!-- AMOUNT -->

<td>


৳


<?php


echo number_format(

    $row['Amount'],

    2

);


?>


</td>



<!-- TYPE -->

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


<span class="income">


+ Income


</span>


<?php


}

else {


?>


<span class="expense">


- Expense


</span>


<?php


}


?>


</td>



<!-- DATE -->

<td>


<?php


echo date(

    "d M Y",

    strtotime(

        $row[
            'Transaction_Date'
        ]

    )

);


?>


</td>



<!-- PAYMENT -->

<td>


<?php


echo htmlspecialchars(

    $row[
        'Payment_Method'
    ]

    ??

    '-'

);


?>


</td>


</tr>


<?php


    }


}

else {


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


No transactions found
for this period.


</td>


</tr>


<?php


}


?>


</tbody>


</table>


</div>


</div>



<?php

}

?>



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
    href="payment.php"
    class="back"
>

Next: Payment →

</a>


</div>


</div>



<?php require "footer.php"; ?>


</body>

</html>