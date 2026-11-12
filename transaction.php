<?php

require "config.php";

$message = "";
$error = "";


/* =====================================================
   DELETE TRANSACTION
===================================================== */

if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("
        DELETE FROM transaction_table
        WHERE Transaction_ID = ?
    ");

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: transaction.php?msg=deleted");
        exit;

    } else {

        $error = "Unable to delete transaction.";

    }
}


/* =====================================================
   MESSAGES
===================================================== */

if (isset($_GET['msg'])) {

    if ($_GET['msg'] == "added") {
        $message = "Transaction added successfully!";
    }

    if ($_GET['msg'] == "updated") {
        $message = "Transaction updated successfully!";
    }

    if ($_GET['msg'] == "deleted") {
        $message = "Transaction deleted successfully!";
    }

}


/* =====================================================
   ADD TRANSACTION
===================================================== */

if (isset($_POST['add_transaction'])) {

    $user_id = intval($_POST['user_id']);

    $category_id = intval($_POST['category_id']);

    $amount = floatval($_POST['amount']);

    $description = trim($_POST['description']);

    $transaction_date = $_POST['transaction_date'];

    $type = trim($_POST['type']);

    $payment_method = trim($_POST['payment_method']);


    if (
        $user_id <= 0 ||
        $category_id <= 0 ||
        $amount <= 0 ||
        $transaction_date == "" ||
        $type == ""
    ) {

        $error = "Please fill in all required fields.";

    } else {

        $stmt = $conn->prepare("

            INSERT INTO transaction_table

            (
                User_ID,
                Category_ID,
                Amount,
                Description,
                Transaction_Date,
                Type,
                Payment_Method
            )

            VALUES (?, ?, ?, ?, ?, ?, ?)

        ");

        $stmt->bind_param(
            "iidssss",
            $user_id,
            $category_id,
            $amount,
            $description,
            $transaction_date,
            $type,
            $payment_method
        );


        if ($stmt->execute()) {

            header(
                "Location: transaction.php?msg=added"
            );

            exit;

        } else {

            $error =
                "Error adding transaction: "
                . $conn->error;

        }

    }

}


/* =====================================================
   UPDATE TRANSACTION
===================================================== */

if (isset($_POST['update_transaction'])) {

    $id =
        intval($_POST['transaction_id']);

    $user_id =
        intval($_POST['user_id']);

    $category_id =
        intval($_POST['category_id']);

    $amount =
        floatval($_POST['amount']);

    $description =
        trim($_POST['description']);

    $transaction_date =
        $_POST['transaction_date'];

    $type =
        trim($_POST['type']);

    $payment_method =
        trim($_POST['payment_method']);


    if (
        $user_id <= 0 ||
        $category_id <= 0 ||
        $amount <= 0 ||
        $transaction_date == "" ||
        $type == ""
    ) {

        $error =
            "Please fill in all required fields.";

    } else {

        $stmt = $conn->prepare("

            UPDATE transaction_table

            SET

                User_ID = ?,
                Category_ID = ?,
                Amount = ?,
                Description = ?,
                Transaction_Date = ?,
                Type = ?,
                Payment_Method = ?

            WHERE Transaction_ID = ?

        ");

        $stmt->bind_param(
            "iidssssi",
            $user_id,
            $category_id,
            $amount,
            $description,
            $transaction_date,
            $type,
            $payment_method,
            $id
        );


        if ($stmt->execute()) {

            header(
                "Location: transaction.php?msg=updated"
            );

            exit;

        } else {

            $error =
                "Error updating transaction.";

        }

    }

}


/* =====================================================
   GET TRANSACTION FOR EDIT
===================================================== */

$editTransaction = null;

if (isset($_GET['edit'])) {

    $id =
        intval($_GET['edit']);

    $stmt = $conn->prepare("

        SELECT *

        FROM transaction_table

        WHERE Transaction_ID = ?

    ");

    $stmt->bind_param(
        "i",
        $id
    );

    $stmt->execute();

    $editTransaction =
        $stmt->get_result()->fetch_assoc();

}


/* =====================================================
   SEARCH + FILTER
===================================================== */

$search = "";

$filter_type = "";

$filter_date = "";


if (isset($_GET['search'])) {

    $search =
        trim($_GET['search']);

}

if (isset($_GET['filter_type'])) {

    $filter_type =
        trim($_GET['filter_type']);

}

if (isset($_GET['filter_date'])) {

    $filter_date =
        trim($_GET['filter_date']);

}


/* =====================================================
   TRANSACTION QUERY
===================================================== */

$sql = "

    SELECT

        t.Transaction_ID,
        t.User_ID,
        t.Category_ID,
        t.Amount,
        t.Description,
        t.Transaction_Date,
        t.Type,
        t.Payment_Method,

        u.Name,

        c.Category_Name

    FROM transaction_table t

    LEFT JOIN users u

        ON t.User_ID = u.User_ID

    LEFT JOIN category c

        ON t.Category_ID = c.Category_ID

    WHERE 1=1

";


$params = [];

$types = "";


/* SEARCH */

if ($search != "") {

    $sql .= "

        AND (

            u.Name LIKE ?
            OR c.Category_Name LIKE ?
            OR t.Description LIKE ?
            OR t.Payment_Method LIKE ?

        )

    ";

    $like =
        "%" . $search . "%";

    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;

    $types .= "ssss";

}


/* TYPE FILTER */

if ($filter_type != "") {

    $sql .= "
        AND t.Type = ?
    ";

    $params[] =
        $filter_type;

    $types .= "s";

}


/* DATE FILTER */

if ($filter_date != "") {

    $sql .= "

        AND t.Transaction_Date = ?

    ";

    $params[] =
        $filter_date;

    $types .= "s";

}


$sql .= "

    ORDER BY
        t.Transaction_ID DESC

";


$stmt =
    $conn->prepare($sql);


if (!empty($params)) {

    $stmt->bind_param(
        $types,
        ...$params
    );

}


$stmt->execute();

$transactions =
    $stmt->get_result();


/* =====================================================
   GET USERS
===================================================== */

$users =
    $conn->query("

        SELECT
            User_ID,
            Name

        FROM users

        ORDER BY Name ASC

    ");


/* =====================================================
   GET ACTIVE CATEGORIES
===================================================== */

$categories =
    $conn->query("

        SELECT

            Category_ID,
            Category_Name,
            Category_Type

        FROM category

        WHERE Status = 'Active'

        ORDER BY Category_Name ASC

    ");


/* =====================================================
   TOTALS
===================================================== */

$totalIncome = 0;

$totalExpense = 0;

$totalTransactions = 0;


$summary =
    $conn->query("

        SELECT

            Type,
            COUNT(*) AS total_count,
            COALESCE(
                SUM(Amount),0
            ) AS total_amount

        FROM transaction_table

        GROUP BY Type

    ");


if ($summary) {

    while (
        $sum =
        $summary->fetch_assoc()
    ) {

        if (
            $sum['Type']
            == 'Income'
        ) {

            $totalIncome =
                $sum['total_amount'];

        }


        if (
            $sum['Type']
            == 'Expense'
        ) {

            $totalExpense =
                $sum['total_amount'];

        }

    }

}


$countResult =
    $conn->query("

        SELECT COUNT(*) AS total

        FROM transaction_table

    ");


if ($countResult) {

    $totalTransactions =
        $countResult
        ->fetch_assoc()['total'];

}


?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
Transaction Management | Expense Management System
</title>

<link rel="stylesheet" href="style.css">

</head>

<body>


<?php require "header.php"; ?>


<div class="content">


<!-- =====================================================
     PAGE HEADING
===================================================== -->

<div class="page-heading">

    <h1>
        Transaction Management
    </h1>

    <p>
        Record, search and manage all your income and expenses.
    </p>

</div>


<!-- =====================================================
     NAVIGATION
===================================================== -->

<div class="navigation">

    <a
        href="category.php"
        class="back"
    >
        ← Category
    </a>


    <a
        href="budget.php"
        class="back"
    >
        Budget →
    </a>

</div>


<!-- =====================================================
     MESSAGE
===================================================== -->

<?php if ($message != "") { ?>

<div class="message">

    <?php

    echo htmlspecialchars(
        $message
    );

    ?>

</div>

<?php } ?>


<?php if ($error != "") { ?>

<div class="message error">

    <?php

    echo htmlspecialchars(
        $error
    );

    ?>

</div>

<?php } ?>


<!-- =====================================================
     SUMMARY
===================================================== -->

<div class="stats">


<div class="stat">

    <div class="stat-title">
        Total Transactions
    </div>

    <div class="stat-value">

        <?php

        echo $totalTransactions;

        ?>

    </div>

</div>


<div class="stat">

    <div class="stat-title">
        Total Income
    </div>

    <div
        class="stat-value"
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


<div class="stat">

    <div class="stat-title">
        Total Expense
    </div>

    <div
        class="stat-value"
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


<div class="stat">

    <div class="stat-title">
        Balance
    </div>

    <div class="stat-value">

        ৳

        <?php

        echo number_format(
            $totalIncome - $totalExpense,
            2
        );

        ?>

    </div>

</div>


</div>


<!-- =====================================================
     ADD / UPDATE FORM
===================================================== -->

<div class="card">


<?php if ($editTransaction) { ?>

<h2>
    Update Transaction
</h2>

<?php } else { ?>

<h2>
    Add New Transaction
</h2>

<?php } ?>


<form method="POST">


<?php if ($editTransaction) { ?>

<input
    type="hidden"
    name="transaction_id"
    value="<?php
        echo $editTransaction['Transaction_ID'];
    ?>"
>

<?php } ?>


<div class="form-grid">


<!-- USER -->

<div class="form-group">

<label>
    User *
</label>

<select
    name="user_id"
    required
>

<option value="">
    Select User
</option>


<?php

if ($users) {

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
        ($editTransaction['User_ID'] ?? '')
        == $user['User_ID']
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


<!-- CATEGORY -->

<div class="form-group">

<label>
    Category *
</label>

<select
    name="category_id"
    required
>

<option value="">
    Select Category
</option>


<?php

if ($categories) {

    while (
        $cat =
        $categories->fetch_assoc()
    ) {

?>


<option
    value="<?php
        echo $cat['Category_ID'];
    ?>"

    <?php

    if (
        ($editTransaction['Category_ID'] ?? '')
        == $cat['Category_ID']
    ) {

        echo "selected";

    }

    ?>

>

<?php

echo htmlspecialchars(
    $cat['Category_Name']
);

?>

-

<?php

echo $cat['Category_Type'];

?>

</option>


<?php

    }

}

?>

</select>

</div>


<!-- AMOUNT -->

<div class="form-group">

<label>
    Amount *
</label>

<input
    type="number"
    step="0.01"
    min="0.01"
    name="amount"
    value="<?php
        echo $editTransaction['Amount'] ?? '';
    ?>"
    placeholder="Enter amount"
    required
>

</div>


<!-- TYPE -->

<div class="form-group">

<label>
    Transaction Type *
</label>

<select
    name="type"
    required
>

<option value="">
    Select Type
</option>


<option
    value="Income"

    <?php

    if (
        ($editTransaction['Type'] ?? '')
        == 'Income'
    ) {

        echo "selected";

    }

    ?>

>

Income

</option>


<option
    value="Expense"

    <?php

    if (
        ($editTransaction['Type'] ?? '')
        == 'Expense'
    ) {

        echo "selected";

    }

    ?>

>

Expense

</option>

</select>

</div>


<!-- DATE -->

<div class="form-group">

<label>
    Transaction Date *
</label>

<input
    type="date"
    name="transaction_date"
    value="<?php

        echo
        $editTransaction['Transaction_Date']
        ?? date('Y-m-d');

    ?>"
    required
>

</div>


<!-- PAYMENT -->

<div class="form-group">

<label>
    Payment Method
</label>

<select
    name="payment_method"
>

<option value="">
    Select Payment Method
</option>


<option
    value="Cash"

    <?php

    if (
        ($editTransaction['Payment_Method'] ?? '')
        == 'Cash'
    ) {

        echo "selected";

    }

    ?>

>

Cash

</option>


<option
    value="Bank"

    <?php

    if (
        ($editTransaction['Payment_Method'] ?? '')
        == 'Bank'
    ) {

        echo "selected";

    }

    ?>

>

Bank

</option>


<option
    value="Card"

    <?php

    if (
        ($editTransaction['Payment_Method'] ?? '')
        == 'Card'
    ) {

        echo "selected";

    }

    ?>

>

Card

</option>


<option
    value="Mobile Banking"

    <?php

    if (
        ($editTransaction['Payment_Method'] ?? '')
        == 'Mobile Banking'
    ) {

        echo "selected";

    }

    ?>

>

Mobile Banking

</option>

</select>

</div>


<!-- DESCRIPTION -->

<div class="form-group full">

<label>
    Description
</label>

<textarea
    name="description"
    placeholder="Write transaction details..."
><?php

echo htmlspecialchars(
    $editTransaction['Description']
    ?? ''
);

?></textarea>

</div>


<!-- BUTTON -->

<div class="form-group full">


<?php if ($editTransaction) { ?>


<button
    type="submit"
    name="update_transaction"
    class="btn btn-warning"
>

    Update Transaction

</button>


<a
    href="transaction.php"
    class="btn"
    style="margin-left:8px;"
>

    Cancel

</a>


<?php } else { ?>


<button
    type="submit"
    name="add_transaction"
    class="btn btn-success"
>

    + Add Transaction

</button>


<?php } ?>


</div>


</div>

</form>

</div>


<!-- =====================================================
     SEARCH & FILTER
===================================================== -->

<div class="card">

<h2>
    Search & Filter Transactions
</h2>


<form
    method="GET"
>


<div
    class="form-grid"
    style="margin-bottom:18px;"
>


<div class="form-group">

<label>
    Search
</label>

<input
    type="text"
    name="search"
    value="<?php
        echo htmlspecialchars(
            $search
        );
    ?>"
    placeholder="
        Category, user, description...
    "
>

</div>


<div class="form-group">

<label>
    Transaction Type
</label>

<select
    name="filter_type"
>

<option value="">
    All Types
</option>


<option
    value="Income"

    <?php

    if (
        $filter_type
        == 'Income'
    ) {

        echo "selected";

    }

    ?>

>

Income

</option>


<option
    value="Expense"

    <?php

    if (
        $filter_type
        == 'Expense'
    ) {

        echo "selected";

    }

    ?>

>

Expense

</option>

</select>

</div>


<div class="form-group">

<label>
    Transaction Date
</label>

<input
    type="date"
    name="filter_date"
    value="<?php
        echo htmlspecialchars(
            $filter_date
        );
    ?>"
>

</div>


<div
    class="form-group"
    style="
        justify-content:end;
        flex-direction:row;
        align-items:end;
        gap:8px;
    "
>

<button
    type="submit"
    class="btn"
>

    🔎 Search

</button>


<a
    href="transaction.php"
    class="btn"
>

    Clear

</a>

</div>


</div>

</form>

</div>


<!-- =====================================================
     TRANSACTION TABLE
===================================================== -->

<div class="card">


<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:18px;
">

<h2 style="margin:0;">

    All Transactions

</h2>


<span
    style="
        color:#888;
        font-size:13px;
    "
>

<?php

echo $transactions->num_rows;

?>

records found

</span>

</div>


<div class="table-wrapper">

<table>


<thead>

<tr>

<th>
    ID
</th>

<th>
    User
</th>

<th>
    Category
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
    Payment
</th>

<th>
    Description
</th>

<th>
    Action
</th>

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


<!-- ID -->

<td>

<?php

echo $row['Transaction_ID'];

?>

</td>


<!-- USER -->

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


<!-- CATEGORY -->

<td>

<?php

echo htmlspecialchars(
    $row['Category_Name']
    ?? 'Uncategorized'
);

?>

</td>


<!-- AMOUNT -->

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


<!-- TYPE -->

<td>


<?php

if (
    $row['Type']
    == 'Income'
) {

?>


<span
    class="income"
>

    + Income

</span>


<?php

} else {

?>


<span
    class="expense"
>

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
        $row['Transaction_Date']
    )
);

?>

</td>


<!-- PAYMENT -->

<td>

<?php

echo htmlspecialchars(
    $row['Payment_Method']
    ?? '-'
);

?>

</td>


<!-- DESCRIPTION -->

<td>

<?php

$desc =
    $row['Description']
    ?? '-';

if (
    strlen($desc) > 30
) {

    echo htmlspecialchars(
        substr($desc,0,30)
    ) . "...";

} else {

    echo htmlspecialchars(
        $desc
    );

}

?>

</td>


<!-- ACTION -->

<td>


<a
    href="transaction.php?edit=<?php
        echo $row['Transaction_ID'];
    ?>"
    class="btn btn-warning"
    style="
        padding:7px 10px;
    "
>

Edit

</a>


<a
    href="transaction.php?delete=<?php
        echo $row['Transaction_ID'];
    ?>"
    class="btn btn-danger"
    style="
        padding:7px 10px;
    "
    onclick="
        return confirm(
            'Are you sure you want to delete this transaction?'
        );
    "
>

Delete

</a>


</td>


</tr>


<?php

}

} else {

?>


<tr>

<td
    colspan="9"
    style="
        text-align:center;
        padding:40px;
        color:#999;
    "
>

No transactions found.

<br>

<small>

Try adding a new transaction
or changing your search/filter.

</small>

</td>

</tr>


<?php

}

?>


</tbody>

</table>

</div>

</div>


<!-- =====================================================
     BOTTOM NAVIGATION
===================================================== -->

<div class="navigation">


<a
    href="category.php"
    class="back"
>

← Previous: Category

</a>


<a
    href="budget.php"
    class="back"
>

Next: Budget →

</a>


</div>


</div>


<?php require "footer.php"; ?>