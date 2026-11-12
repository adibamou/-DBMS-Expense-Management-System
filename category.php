<?php

require "config.php";

$message = "";
$error = "";


/* =========================
   DELETE CATEGORY
========================= */

if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("
        DELETE FROM category
        WHERE Category_ID = ?
    ");

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: category.php?msg=deleted");
        exit;

    } else {

        $error = "Unable to delete category.";

    }
}


/* =========================
   MESSAGES
========================= */

if (isset($_GET['msg'])) {

    if ($_GET['msg'] == "added") {
        $message = "Category added successfully!";
    }

    if ($_GET['msg'] == "updated") {
        $message = "Category updated successfully!";
    }

    if ($_GET['msg'] == "deleted") {
        $message = "Category deleted successfully!";
    }

}


/* =========================
   ADD CATEGORY
========================= */

if (isset($_POST['add_category'])) {

    $name =
        trim($_POST['category_name']);

    $type =
        trim($_POST['category_type']);

    $description =
        trim($_POST['description']);

    if ($name == "" || $type == "") {

        $error =
            "Category Name and Type are required.";

    } else {

        /* Check duplicate */

        $check = $conn->prepare("

            SELECT Category_ID

            FROM category

            WHERE Category_Name = ?
            AND Category_Type = ?

        ");

        $check->bind_param(
            "ss",
            $name,
            $type
        );

        $check->execute();

        $result =
            $check->get_result();

        if ($result->num_rows > 0) {

            $error =
                "This category already exists.";

        } else {

            $stmt = $conn->prepare("

                INSERT INTO category

                (
                    Category_Name,
                    Category_Type,
                    Description,
                    Status
                )

                VALUES (?, ?, ?, 'Active')

            ");

            $stmt->bind_param(
                "sss",
                $name,
                $type,
                $description
            );

            if ($stmt->execute()) {

                header(
                    "Location: category.php?msg=added"
                );

                exit;

            } else {

                $error =
                    "Error adding category.";

            }

        }

    }

}


/* =========================
   UPDATE CATEGORY
========================= */

if (isset($_POST['update_category'])) {

    $id =
        intval($_POST['category_id']);

    $name =
        trim($_POST['category_name']);

    $type =
        trim($_POST['category_type']);

    $description =
        trim($_POST['description']);

    $status =
        trim($_POST['status']);


    if ($name == "" || $type == "") {

        $error =
            "Category Name and Type are required.";

    } else {

        $stmt = $conn->prepare("

            UPDATE category

            SET

                Category_Name = ?,
                Category_Type = ?,
                Description = ?,
                Status = ?

            WHERE Category_ID = ?

        ");

        $stmt->bind_param(
            "ssssi",
            $name,
            $type,
            $description,
            $status,
            $id
        );

        if ($stmt->execute()) {

            header(
                "Location: category.php?msg=updated"
            );

            exit;

        } else {

            $error =
                "Error updating category.";

        }

    }

}


/* =========================
   GET EDIT CATEGORY
========================= */

$editCategory = null;

if (isset($_GET['edit'])) {

    $id =
        intval($_GET['edit']);

    $stmt = $conn->prepare("

        SELECT *

        FROM category

        WHERE Category_ID = ?

    ");

    $stmt->bind_param(
        "i",
        $id
    );

    $stmt->execute();

    $editCategory =
        $stmt->get_result()->fetch_assoc();

}


/* =========================
   SEARCH
========================= */

$search = "";

if (isset($_GET['search'])) {

    $search =
        trim($_GET['search']);

}


if ($search != "") {

    $like =
        "%" . $search . "%";

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

    $categories =
        $stmt->get_result();

} else {

    $categories =
        $conn->query("

            SELECT *

            FROM category

            ORDER BY Category_ID DESC

        ");

}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
Category Management | Expense Management System
</title>

<link rel="stylesheet" href="style.css">

</head>

<body>


<?php require "header.php"; ?>


<div class="content">


<!-- =========================
     PAGE HEADING
========================= -->

<div class="page-heading">

    <h1>
        Category Management
    </h1>

    <p>
        Create and manage income and expense categories.
    </p>

</div>


<!-- =========================
     NAVIGATION
========================= -->

<div class="navigation">

    <a
        href="users.php"
        class="back"
    >
        ← Users
    </a>


    <a
        href="transaction.php"
        class="back"
    >
        Transactions →
    </a>

</div>


<!-- =========================
     MESSAGE
========================= -->

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


<!-- =========================
     ADD / UPDATE FORM
========================= -->

<div class="card">


<?php if ($editCategory) { ?>

<h2>
    Update Category
</h2>

<?php } else { ?>

<h2>
    Add New Category
</h2>

<?php } ?>


<form method="POST">


<?php if ($editCategory) { ?>

<input
    type="hidden"
    name="category_id"
    value="<?php
        echo $editCategory['Category_ID'];
    ?>"
>

<?php } ?>


<div class="form-grid">


<!-- CATEGORY NAME -->

<div class="form-group">

<label>
    Category Name *
</label>

<input
    type="text"
    name="category_name"
    value="<?php

        echo htmlspecialchars(
            $editCategory['Category_Name']
            ?? ''
        );

    ?>"
    placeholder="Example: Food"
    required
>

</div>


<!-- CATEGORY TYPE -->

<div class="form-group">

<label>
    Category Type *
</label>

<select
    name="category_type"
    required
>

<option value="">
    Select Type
</option>


<option
    value="Income"

    <?php

    if (
        ($editCategory['Category_Type'] ?? '')
        == 'Income'
    ) {

        echo 'selected';

    }

    ?>

>

    Income

</option>


<option
    value="Expense"

    <?php

    if (
        ($editCategory['Category_Type'] ?? '')
        == 'Expense'
    ) {

        echo 'selected';

    }

    ?>

>

    Expense

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
    placeholder="Write a short description..."
><?php

echo htmlspecialchars(
    $editCategory['Description']
    ?? ''
);

?></textarea>

</div>


<?php if ($editCategory) { ?>


<!-- STATUS -->

<div class="form-group">

<label>
    Status
</label>

<select
    name="status"
>

<option
    value="Active"

    <?php

    if (
        ($editCategory['Status'] ?? '')
        == 'Active'
    ) {

        echo 'selected';

    }

    ?>

>

Active

</option>


<option
    value="Inactive"

    <?php

    if (
        ($editCategory['Status'] ?? '')
        == 'Inactive'
    ) {

        echo 'selected';

    }

    ?>

>

Inactive

</option>

</select>

</div>


<?php } ?>


<!-- BUTTON -->

<div class="form-group full">


<?php if ($editCategory) { ?>


<button
    type="submit"
    name="update_category"
    class="btn btn-warning"
>

    Update Category

</button>


<a
    href="category.php"
    class="btn"
    style="margin-left:8px;"
>

    Cancel

</a>


<?php } else { ?>


<button
    type="submit"
    name="add_category"
    class="btn btn-success"
>

    + Add Category

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
    Search Categories
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
        Search category name, type or description...
    "
>


<button
    type="submit"
    class="btn"
>

    🔎 Search

</button>


<a
    href="category.php"
    class="btn"
>

    Clear

</a>


</form>

</div>


<!-- =========================
     CATEGORY TABLE
========================= -->

<div class="card">


<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:18px;
">

<h2 style="margin:0;">

    All Categories

</h2>


<span
    style="
        color:#888;
        font-size:13px;
    "
>

<?php

echo $categories->num_rows;

?>

categories found

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
    Category Name
</th>

<th>
    Type
</th>

<th>
    Description
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


<!-- ID -->

<td>

<?php

echo $row['Category_ID'];

?>

</td>


<!-- NAME -->

<td>

<strong>

<?php

echo htmlspecialchars(
    $row['Category_Name']
);

?>

</strong>

</td>


<!-- TYPE -->

<td>

<?php

if (
    $row['Category_Type']
    == 'Income'
) {

?>

<span
    style="
        color:#198754;
        font-weight:bold;
    "
>

    ↗ Income

</span>

<?php

} else {

?>

<span
    style="
        color:#c74747;
        font-weight:bold;
    "
>

    ↘ Expense

</span>

<?php

}

?>

</td>


<!-- DESCRIPTION -->

<td>

<?php

echo htmlspecialchars(
    $row['Description']
    ?? '-'
);

?>

</td>


<!-- STATUS -->

<td>

<?php

if (
    $row['Status']
    == 'Active'
) {

?>

<span
    style="
        color:#198754;
        font-weight:bold;
    "
>

Active

</span>

<?php

} else {

?>

<span
    style="
        color:#c74747;
        font-weight:bold;
    "
>

Inactive

</span>

<?php

}

?>

</td>


<!-- ACTION -->

<td>


<a
    href="category.php?edit=<?php
        echo $row['Category_ID'];
    ?>"
    class="btn btn-warning"
    style="
        padding:7px 10px;
    "
>

Edit

</a>


<a
    href="category.php?delete=<?php
        echo $row['Category_ID'];
    ?>"
    class="btn btn-danger"
    style="
        padding:7px 10px;
    "
    onclick="
        return confirm(
            'Are you sure you want to delete this category?'
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
    colspan="6"
    style="
        text-align:center;
        padding:35px;
        color:#999;
    "
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
     BOTTOM NAVIGATION
========================= -->

<div class="navigation">


<a
    href="users.php"
    class="back"
>

← Previous: Users

</a>


<a
    href="transaction.php"
    class="back"
>

Next: Transactions →

</a>


</div>


</div>


<?php require "footer.php"; ?>