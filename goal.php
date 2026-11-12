<?php

require "config.php";

$message = "";
$error = "";


/* =========================
   DELETE GOAL
========================= */

if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("
        DELETE FROM goal
        WHERE Goal_ID = ?
    ");

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: goal.php?msg=deleted");
        exit;

    } else {

        $error = "Unable to delete goal.";

    }
}


/* =========================
   MESSAGES
========================= */

if (isset($_GET['msg'])) {

    if ($_GET['msg'] == "added") {
        $message = "Goal added successfully!";
    }

    if ($_GET['msg'] == "updated") {
        $message = "Goal updated successfully!";
    }

    if ($_GET['msg'] == "deleted") {
        $message = "Goal deleted successfully!";
    }
}


/* =========================
   ADD GOAL
========================= */

if (isset($_POST['add_goal'])) {

    $user_id = intval($_POST['user_id']);

    $goal_name = trim($_POST['goal_name']);

    $target_amount = floatval($_POST['target_amount']);

    $current_amount = floatval($_POST['current_amount']);

    $target_date = $_POST['target_date'];

    $description = trim($_POST['description']);

    $status = $_POST['status'];


    if (
        $user_id <= 0 ||
        $goal_name == "" ||
        $target_amount <= 0
    ) {

        $error = "Please fill all required fields.";

    } else {

        $stmt = $conn->prepare("

            INSERT INTO goal
            (
                User_ID,
                Goal_Name,
                Target_Amount,
                Current_Amount,
                Target_Date,
                Description,
                Status
            )

            VALUES (?, ?, ?, ?, ?, ?, ?)

        ");

        $stmt->bind_param(
            "isddsss",
            $user_id,
            $goal_name,
            $target_amount,
            $current_amount,
            $target_date,
            $description,
            $status
        );


        if ($stmt->execute()) {

            header("Location: goal.php?msg=added");
            exit;

        } else {

            $error =
                "Error adding goal: "
                . $conn->error;

        }

    }
}


/* =========================
   UPDATE GOAL
========================= */

if (isset($_POST['update_goal'])) {

    $id = intval($_POST['goal_id']);

    $user_id = intval($_POST['user_id']);

    $goal_name = trim($_POST['goal_name']);

    $target_amount = floatval($_POST['target_amount']);

    $current_amount = floatval($_POST['current_amount']);

    $target_date = $_POST['target_date'];

    $description = trim($_POST['description']);

    $status = $_POST['status'];


    if (
        $user_id <= 0 ||
        $goal_name == "" ||
        $target_amount <= 0
    ) {

        $error = "Please fill all required fields.";

    } else {

        $stmt = $conn->prepare("

            UPDATE goal

            SET
                User_ID = ?,
                Goal_Name = ?,
                Target_Amount = ?,
                Current_Amount = ?,
                Target_Date = ?,
                Description = ?,
                Status = ?

            WHERE Goal_ID = ?

        ");

        $stmt->bind_param(
            "isddsssi",
            $user_id,
            $goal_name,
            $target_amount,
            $current_amount,
            $target_date,
            $description,
            $status,
            $id
        );


        if ($stmt->execute()) {

            header("Location: goal.php?msg=updated");
            exit;

        } else {

            $error =
                "Error updating goal: "
                . $conn->error;

        }

    }
}


/* =========================
   EDIT GOAL
========================= */

$editGoal = null;

if (isset($_GET['edit'])) {

    $id = intval($_GET['edit']);

    $stmt = $conn->prepare("

        SELECT *

        FROM goal

        WHERE Goal_ID = ?

    ");

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $editGoal =
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

    $goals =
        $stmt->get_result();


} else {


    $goals = $conn->query("

        SELECT

            g.*,

            u.Name

        FROM goal g

        LEFT JOIN users u

            ON g.User_ID = u.User_ID

        ORDER BY
            g.Goal_ID DESC

    ");

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
   SUMMARY
========================= */

$totalGoals = 0;

$totalTarget = 0;

$totalSaved = 0;


$summary = $conn->query("

    SELECT

        COUNT(*) AS total_goals,

        COALESCE(
            SUM(Target_Amount),
            0
        ) AS total_target,

        COALESCE(
            SUM(Current_Amount),
            0
        ) AS total_saved

    FROM goal

");


if ($summary) {

    $data =
        $summary->fetch_assoc();

    $totalGoals =
        $data['total_goals'];

    $totalTarget =
        $data['total_target'];

    $totalSaved =
        $data['total_saved'];

}


?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
Goal Management | Expense Management System
</title>

<link
    rel="stylesheet"
    href="style.css"
>

</head>


<body>


<?php require "header.php"; ?>


<div class="content">


<!-- PAGE HEADING -->

<div class="page-heading">

<h1>
Goal Management
</h1>

<p>
Set your financial goals and track your progress.
</p>

</div>


<!-- NAVIGATION -->

<div class="navigation">

<a
    href="budget.php"
    class="back"
>
← Budget
</a>


<a
    href="search.php"
    class="back"
>
Search →
</a>

</div>


<!-- MESSAGE -->

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


<!-- SUMMARY -->

<div class="stats">


<div class="stat">

<div class="stat-title">
Total Goals
</div>

<div class="stat-value">

<?php
echo $totalGoals;
?>

</div>

</div>


<div class="stat">

<div class="stat-title">
Total Target
</div>

<div class="stat-value">

৳

<?php

echo number_format(
    $totalTarget,
    2
);

?>

</div>

</div>


<div class="stat">

<div class="stat-title">
Current Savings
</div>

<div class="stat-value">

৳

<?php

echo number_format(
    $totalSaved,
    2
);

?>

</div>

</div>


</div>


<!-- ADD / UPDATE FORM -->

<div class="card">


<?php if ($editGoal) { ?>

<h2>
Update Goal
</h2>

<?php } else { ?>

<h2>
Create New Goal
</h2>

<?php } ?>


<form method="POST">


<?php if ($editGoal) { ?>

<input
    type="hidden"
    name="goal_id"
    value="<?php
        echo $editGoal['Goal_ID'];
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
    ($editGoal['User_ID'] ?? '')
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


<!-- GOAL NAME -->

<div class="form-group">

<label>
Goal Name *
</label>

<input
    type="text"
    name="goal_name"
    value="<?php

        echo htmlspecialchars(
            $editGoal['Goal_Name']
            ?? ''
        );

    ?>"
    placeholder="Example: Buy a Laptop"
    required
>

</div>


<!-- TARGET AMOUNT -->

<div class="form-group">

<label>
Target Amount *
</label>

<input
    type="number"
    step="0.01"
    min="0.01"
    name="target_amount"
    value="<?php

        echo $editGoal['Target_Amount']
        ?? '';

    ?>"
    placeholder="Enter target amount"
    required
>

</div>


<!-- CURRENT AMOUNT -->

<div class="form-group">

<label>
Current Amount
</label>

<input
    type="number"
    step="0.01"
    min="0"
    name="current_amount"
    value="<?php

        echo $editGoal['Current_Amount']
        ?? '0';

    ?>"
    placeholder="Enter current saved amount"
>


</div>


<!-- TARGET DATE -->

<div class="form-group">

<label>
Target Date
</label>

<input
    type="date"
    name="target_date"
    value="<?php

        echo $editGoal['Target_Date']
        ?? '';

    ?>"
>


</div>


<!-- STATUS -->

<div class="form-group">

<label>
Status
</label>

<select name="status">


<option
    value="Active"

<?php

if (
    ($editGoal['Status'] ?? 'Active')
    ==
    'Active'
) {

    echo "selected";

}

?>
>

Active

</option>


<option
    value="Completed"

<?php

if (
    ($editGoal['Status'] ?? '')
    ==
    'Completed'
) {

    echo "selected";

}

?>
>

Completed

</option>


<option
    value="Paused"

<?php

if (
    ($editGoal['Status'] ?? '')
    ==
    'Paused'
) {

    echo "selected";

}

?>
>

Paused

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
    placeholder="Describe your financial goal..."
><?php

echo htmlspecialchars(
    $editGoal['Description']
    ?? ''
);

?></textarea>

</div>


<!-- BUTTON -->

<div class="form-group full">


<?php if ($editGoal) { ?>


<button
    type="submit"
    name="update_goal"
    class="btn btn-warning"
>

Update Goal

</button>


<a
    href="goal.php"
    class="btn"
    style="margin-left:8px;"
>

Cancel

</a>


<?php } else { ?>


<button
    type="submit"
    name="add_goal"
    class="btn btn-success"
>

+ Create Goal

</button>


<?php } ?>


</div>


</div>

</form>

</div>


<!-- SEARCH -->

<div class="card">

<h2>
Search Goals
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
        Search goal name, user, status or description...
    "
>


<button
    type="submit"
    class="btn"
>

🔎 Search

</button>


<a
    href="goal.php"
    class="btn"
>

Clear

</a>


</form>

</div>


<!-- GOAL TABLE -->

<div class="card">


<div style="
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:18px;
">

<h2 style="margin:0;">
All Goals
</h2>


<span
    style="
        color:#888;
        font-size:13px;
    "
>

<?php

echo $goals->num_rows;

?>

goals found

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
Goal Name
</th>

<th>
Target
</th>

<th>
Current
</th>

<th>
Progress
</th>

<th>
Target Date
</th>

<th>
Status
</th>

<th>
Action
</th>

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


if ($target > 0) {

    $progress =
        ($current / $target) * 100;

} else {

    $progress = 0;

}


if ($progress > 100) {

    $progress = 100;

}

?>


<tr>


<!-- ID -->

<td>

<?php

echo $row['Goal_ID'];

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


<!-- GOAL -->

<td>

<strong>

<?php

echo htmlspecialchars(
    $row['Goal_Name']
);

?>

</strong>


<br>

<small style="color:#888;">

<?php

echo htmlspecialchars(
    $row['Description']
    ?? ''
);

?>

</small>

</td>


<!-- TARGET -->

<td>

<strong>

৳

<?php

echo number_format(
    $target,
    2
);

?>

</strong>

</td>


<!-- CURRENT -->

<td>

৳

<?php

echo number_format(
    $current,
    2
);

?>

</td>


<!-- PROGRESS -->

<td style="min-width:120px;">

<div style="
background:#eee;
height:8px;
border-radius:10px;
overflow:hidden;
">

<div style="
width:<?php
echo $progress;
?>%;
height:100%;
background:#198754;
border-radius:10px;
">
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


<!-- DATE -->

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


<!-- STATUS -->

<td>


<?php

if (
    $row['Status']
    ==
    'Active'
) {

?>

<span
    style="
        color:#198754;
        font-weight:bold;
    "
>

● Active

</span>

<?php

}
elseif (
    $row['Status']
    ==
    'Completed'
) {

?>

<span
    style="
        color:#0d6efd;
        font-weight:bold;
    "
>

● Completed

</span>

<?php

}
else {

?>

<span
    style="
        color:#d99a35;
        font-weight:bold;
    "
>

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


<!-- ACTION -->

<td>


<a
    href="goal.php?edit=<?php
        echo $row['Goal_ID'];
    ?>"
    class="btn btn-warning"
    style="
        padding:7px 10px;
    "
>

Edit

</a>


<a
    href="goal.php?delete=<?php
        echo $row['Goal_ID'];
    ?>"
    class="btn btn-danger"
    style="
        padding:7px 10px;
    "
    onclick="
        return confirm(
            'Are you sure you want to delete this goal?'
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


<!-- BOTTOM NAVIGATION -->

<div class="navigation">


<a
    href="budget.php"
    class="back"
>

← Previous: Budget

</a>


<a
    href="search.php"
    class="back"
>

Next: Search →

</a>


</div>


</div>


<?php require "footer.php"; ?>


</body>

</html>