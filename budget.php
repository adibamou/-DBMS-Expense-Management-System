<?php

require "config.php";

$message = "";
$error = "";


/* =========================
   DELETE BUDGET
========================= */

if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("
        DELETE FROM budget
        WHERE Budget_ID = ?
    ");

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: budget.php?msg=deleted");
        exit;

    } else {

        $error = "Unable to delete budget.";

    }
}


/* =========================
   MESSAGES
========================= */

if (isset($_GET['msg'])) {

    if ($_GET['msg'] == "added") {
        $message = "Budget added successfully!";
    }

    if ($_GET['msg'] == "updated") {
        $message = "Budget updated successfully!";
    }

    if ($_GET['msg'] == "deleted") {
        $message = "Budget deleted successfully!";
    }
}


/* =========================
   ADD BUDGET
========================= */

if (isset($_POST['add_budget'])) {

    $user_id = intval($_POST['user_id']);

    $budget_name = trim($_POST['budget_name']);

    $amount_limit = floatval($_POST['amount_limit']);

    $description = trim($_POST['description']);

    $start_date = $_POST['start_date'];

    $end_date = $_POST['end_date'];


    if (
        $user_id <= 0 ||
        $budget_name == "" ||
        $amount_limit <= 0 ||
        $start_date == "" ||
        $end_date == ""
    ) {

        $error = "Please fill all required fields.";

    } else {

        $stmt = $conn->prepare("

            INSERT INTO budget
            (
                User_ID,
                Budget_Name,
                Amount_Limit,
                Description,
                Start_Date,
                End_Date
            )

            VALUES (?, ?, ?, ?, ?, ?)

        ");

        $stmt->bind_param(
            "isdsss",
            $user_id,
            $budget_name,
            $amount_limit,
            $description,
            $start_date,
            $end_date
        );


        if ($stmt->execute()) {

            header("Location: budget.php?msg=added");
            exit;

        } else {

            $error =
                "Error adding budget: "
                . $conn->error;

        }

    }
}


/* =========================
   UPDATE BUDGET
========================= */

if (isset($_POST['update_budget'])) {

    $id = intval($_POST['budget_id']);

    $user_id = intval($_POST['user_id']);

    $budget_name = trim($_POST['budget_name']);

    $amount_limit = floatval($_POST['amount_limit']);

    $description = trim($_POST['description']);

    $start_date = $_POST['start_date'];

    $end_date = $_POST['end_date'];


    if (
        $user_id <= 0 ||
        $budget_name == "" ||
        $amount_limit <= 0 ||
        $start_date == "" ||
        $end_date == ""
    ) {

        $error = "Please fill all required fields.";

    } else {

        $stmt = $conn->prepare("

            UPDATE budget

            SET
                User_ID = ?,
                Budget_Name = ?,
                Amount_Limit = ?,
                Description = ?,
                Start_Date = ?,
                End_Date = ?

            WHERE Budget_ID = ?

        ");

        $stmt->bind_param(
            "isdsssi",
            $user_id,
            $budget_name,
            $amount_limit,
            $description,
            $start_date,
            $end_date,
            $id
        );


        if ($stmt->execute()) {

            header("Location: budget.php?msg=updated");
            exit;

        } else {

            $error =
                "Error updating budget: "
                . $conn->error;

        }

    }
}


/* =========================
   EDIT BUDGET
========================= */

$editBudget = null;

if (isset($_GET['edit'])) {

    $id = intval($_GET['edit']);

    $stmt = $conn->prepare("

        SELECT *

        FROM budget

        WHERE Budget_ID = ?

    ");

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $editBudget =
        $stmt->get_result()->fetch_assoc();
}


/* =========================
   SEARCH
========================= */

$search = "";

if (isset($_GET['search'])) {

    $search = trim($_GET['search']);

}


if ($search != "") {

    $like = "%" . $search . "%";


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

    $budgets =
        $stmt->get_result();


} else {


    $budgets = $conn->query("

        SELECT

            b.*,

            u.Name

        FROM budget b

        LEFT JOIN users u

            ON b.User_ID = u.User_ID

        ORDER BY
            b.Budget_ID DESC

    ");

}


/* =========================
   GET USERS
========================= */

$users = $conn->query("

    SELECT

        User_ID,
        Name

    FROM users

    ORDER BY Name ASC

");


/* =========================
   BUDGET SUMMARY
========================= */

$totalBudgets = 0;

$totalLimit = 0;


$summary = $conn->query("

    SELECT

        COUNT(*) AS total_budgets,

        COALESCE(
            SUM(Amount_Limit),
            0
        ) AS total_limit

    FROM budget

");


if ($summary) {

    $data =
        $summary->fetch_assoc();

    $totalBudgets =
        $data['total_budgets'];

    $totalLimit =
        $data['total_limit'];
}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
Budget Management | Expense Management System
</title>

<link
    rel="stylesheet"
    href="style.css"
>

</head>


<body>


<?php require "header.php"; ?>


<div class="content">


<!-- =========================
     PAGE HEADING
========================= -->

<div class="page-heading">

<h1>
Budget Management
</h1>

<p>
Plan and control your spending with smart budgets.
</p>

</div>


<!-- =========================
     NAVIGATION
========================= -->

<div class="navigation">

<a
    href="transaction.php"
    class="back"
>
← Transactions
</a>


<a
    href="goal.php"
    class="back"
>
Goals →
</a>

</div>


<!-- =========================
     MESSAGE
========================= -->

<?php if ($message != "") { ?>

<div class="message">

<?php
echo htmlspecialchars($message);
?>

</div>

<?php } ?>


<?php if ($error != "") { ?>

<div class="message error">

<?php
echo htmlspecialchars($error);
?>

</div>

<?php } ?>


<!-- =========================
     SUMMARY
========================= -->

<div class="stats">


<div class="stat">

<div class="stat-title">
Total Budgets
</div>

<div class="stat-value">

<?php
echo $totalBudgets;
?>

</div>

</div>


<div class="stat">

<div class="stat-title">
Total Budget Limit
</div>

<div class="stat-value">

৳

<?php

echo number_format(
    $totalLimit,
    2
);

?>

</div>

</div>


<div class="stat">

<div class="stat-title">
Average Budget
</div>

<div class="stat-value">

৳

<?php

if ($totalBudgets > 0) {

    echo number_format(
        $totalLimit / $totalBudgets,
        2
    );

} else {

    echo "0.00";

}

?>

</div>

</div>


</div>


<!-- =========================
     ADD / UPDATE FORM
========================= -->

<div class="card">


<?php if ($editBudget) { ?>

<h2>
Update Budget
</h2>

<?php } else { ?>

<h2>
Create New Budget
</h2>

<?php } ?>


<form method="POST">


<?php if ($editBudget) { ?>

<input
    type="hidden"
    name="budget_id"
    value="<?php
        echo $editBudget['Budget_ID'];
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
    ($editBudget['User_ID'] ?? '')
    ==
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


<!-- BUDGET NAME -->

<div class="form-group">

<label>
Budget Name *
</label>

<input
    type="text"
    name="budget_name"
    value="<?php

        echo htmlspecialchars(
            $editBudget['Budget_Name']
            ?? ''
        );

    ?>"
    placeholder="Example: Monthly Food Budget"
    required
>

</div>


<!-- AMOUNT -->

<div class="form-group">

<label>
Budget Amount *
</label>

<input
    type="number"
    step="0.01"
    min="0.01"
    name="amount_limit"
    value="<?php

        echo $editBudget['Amount_Limit']
        ?? '';

    ?>"
    placeholder="Enter budget amount"
    required
>

</div>


<!-- START DATE -->

<div class="form-group">

<label>
Start Date *
</label>

<input
    type="date"
    name="start_date"
    value="<?php

        echo $editBudget['Start_Date']
        ?? date('Y-m-d');

    ?>"
    required
>

</div>


<!-- END DATE -->

<div class="form-group">

<label>
End Date *
</label>

<input
    type="date"
    name="end_date"
    value="<?php

        echo $editBudget['End_Date']
        ?? date('Y-m-d');

    ?>"
    required
>

</div>


<!-- DESCRIPTION -->

<div class="form-group full">

<label>
Description
</label>

<textarea
    name="description"
    placeholder="Enter budget details..."
><?php

echo htmlspecialchars(
    $editBudget['Description']
    ?? ''
);

?></textarea>

</div>


<!-- BUTTON -->

<div class="form-group full">


<?php if ($editBudget) { ?>


<button
    type="submit"
    name="update_budget"
    class="btn btn-warning"
>

Update Budget

</button>


<a
    href="budget.php"
    class="btn"
    style="margin-left:8px;"
>

Cancel

</a>


<?php } else { ?>


<button
    type="submit"
    name="add_budget"
    class="btn btn-success"
>

+ Create Budget

</button>


<?php } ?>


</div>


</div>

</form>

</div>


<!-- =========================
     SEARCH
========================= -->

<div class="card">

<h2>
Search Budgets
</h2>


<form
    method="GET"
    class="search-box"
>


<input
    type="text"
    name="search"
    value="<?php
        echo htmlspecialchars(
            $search
        );
    ?>"
    placeholder="
        Search budget name, user or description...
    "
>


<button
    type="submit"
    class="btn"
>

🔎 Search

</button>


<a
    href="budget.php"
    class="btn"
>

Clear

</a>


</form>

</div>


<!-- =========================
     BUDGET TABLE
========================= -->

<div class="card">


<div style="
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:18px;
">

<h2 style="margin:0;">
All Budgets
</h2>


<span
    style="
        color:#888;
        font-size:13px;
    "
>

<?php

echo $budgets->num_rows;

?>

budgets found

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
Budget Name
</th>

<th>
Amount Limit
</th>

<th>
Start Date
</th>

<th>
End Date
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


<!-- ID -->

<td>

<?php

echo $row['Budget_ID'];

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


<!-- BUDGET NAME -->

<td>

<strong>

<?php

echo htmlspecialchars(
    $row['Budget_Name']
);

?>

</strong>

</td>


<!-- AMOUNT -->

<td>

<strong>

৳

<?php

echo number_format(
    $row['Amount_Limit'],
    2
);

?>

</strong>

</td>


<!-- START -->

<td>

<?php

if (
    !empty(
        $row['Start_Date']
    )
) {

echo date(
    "d M Y",
    strtotime(
        $row['Start_Date']
    )
);

} else {

echo "-";

}

?>

</td>


<!-- END -->

<td>

<?php

if (
    !empty(
        $row['End_Date']
    )
) {

echo date(
    "d M Y",
    strtotime(
        $row['End_Date']
    )
);

} else {

echo "-";

}

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
    substr(
        $desc,
        0,
        30
    )
)
. "...";


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
    href="budget.php?edit=<?php
        echo $row['Budget_ID'];
    ?>"
    class="btn btn-warning"
    style="
        padding:7px 10px;
    "
>

Edit

</a>


<a
    href="budget.php?delete=<?php
        echo $row['Budget_ID'];
    ?>"
    class="btn btn-danger"
    style="
        padding:7px 10px;
    "
    onclick="
        return confirm(
            'Are you sure you want to delete this budget?'
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
    colspan="8"
    style="
        text-align:center;
        padding:40px;
        color:#999;
    "
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
     BOTTOM NAVIGATION
========================= -->

<div class="navigation">

<a
    href="transaction.php"
    class="back"
>

← Previous: Transactions

</a>


<a
    href="goal.php"
    class="back"
>

Next: Goals →

</a>

</div>


</div>


<?php require "footer.php"; ?>


</body>

</html>