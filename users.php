<?php
require "config.php";

/* =========================
   DELETE USER
========================= */

if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $stmt = $conn->prepare(
        "DELETE FROM users WHERE User_ID = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: users.php");
    exit;
}


/* =========================
   ADD / UPDATE USER
========================= */

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = intval($_POST['user_id'] ?? 0);

    $name = trim($_POST['name'] ?? "");
    $first_name = trim($_POST['first_name'] ?? "");
    $last_name = trim($_POST['last_name'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $password = trim($_POST['password'] ?? "");
    $phone = trim($_POST['phone'] ?? "");
    $gender = trim($_POST['gender'] ?? "");
    $dob = $_POST['date_of_birth'] ?? "";
    $address = trim($_POST['address'] ?? "");


    if (
        $name == "" ||
        $email == "" ||
        $password == ""
    ) {

        $error = "Please fill in Name, Email and Password.";

    } else {

        if ($user_id > 0) {

            /* UPDATE */

            if ($password != "") {

                $hashedPassword = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                $stmt = $conn->prepare("
                    UPDATE users SET
                        Name = ?,
                        First_Name = ?,
                        Last_Name = ?,
                        Email = ?,
                        Password = ?,
                        Phone = ?,
                        Gender = ?,
                        Date_of_Birth = NULLIF(?, ''),
                        Address = ?
                    WHERE User_ID = ?
                ");

                $stmt->bind_param(
                    "sssssssssi",
                    $name,
                    $first_name,
                    $last_name,
                    $email,
                    $hashedPassword,
                    $phone,
                    $gender,
                    $dob,
                    $address,
                    $user_id
                );

            }

            if ($password == "") {

                $stmt = $conn->prepare("
                    UPDATE users SET
                        Name = ?,
                        First_Name = ?,
                        Last_Name = ?,
                        Email = ?,
                        Phone = ?,
                        Gender = ?,
                        Date_of_Birth = NULLIF(?, ''),
                        Address = ?
                    WHERE User_ID = ?
                ");

                $stmt->bind_param(
                    "ssssssssi",
                    $name,
                    $first_name,
                    $last_name,
                    $email,
                    $phone,
                    $gender,
                    $dob,
                    $address,
                    $user_id
                );

            }

            if ($stmt->execute()) {

                $message = "User updated successfully!";

            } else {

                $error = "Unable to update user: " . $stmt->error;

            }

        } else {

            /* ADD NEW USER */

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare("
                INSERT INTO users
                (
                    Name,
                    First_Name,
                    Last_Name,
                    Email,
                    Password,
                    Phone,
                    Gender,
                    Date_of_Birth,
                    Address
                )
                VALUES
                (
                    ?, ?, ?, ?, ?, ?, ?, NULLIF(?, ''), ?
                )
            ");

            $stmt->bind_param(
                "sssssssss",
                $name,
                $first_name,
                $last_name,
                $email,
                $hashedPassword,
                $phone,
                $gender,
                $dob,
                $address
            );

            if ($stmt->execute()) {

                $message = "New user added successfully!";

            } else {

                $error = "Unable to add user: " . $stmt->error;

            }
        }
    }
}


/* =========================
   EDIT USER
========================= */

$editUser = null;

if (isset($_GET['edit'])) {

    $id = intval($_GET['edit']);

    $stmt = $conn->prepare("
        SELECT *
        FROM users
        WHERE User_ID = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $editUser = $stmt->get_result()->fetch_assoc();
}


/* =========================
   SEARCH
========================= */

$search = trim($_GET['search'] ?? "");

if ($search != "") {

    $like = "%" . $search . "%";

    $stmt = $conn->prepare("
        SELECT
            User_ID,
            Name,
            First_Name,
            Last_Name,
            Email,
            Phone,
            Gender,
            Date_of_Birth,
            Address,
            Registration_Date
        FROM users
        WHERE
            Name LIKE ?
            OR First_Name LIKE ?
            OR Last_Name LIKE ?
            OR Email LIKE ?
            OR Phone LIKE ?
            OR Gender LIKE ?
        ORDER BY User_ID DESC
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

    $users = $stmt->get_result();

} else {

    $users = $conn->query("
        SELECT
            User_ID,
            Name,
            First_Name,
            Last_Name,
            Email,
            Phone,
            Gender,
            Date_of_Birth,
            Address,
            Registration_Date
        FROM users
        ORDER BY User_ID DESC
    ");
}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
User Management | Expense Management System
</title>

<link
    rel="stylesheet"
    href="style.css"
>

<style>

.user-hero {

    background:
        linear-gradient(
            135deg,
            #667eea,
            #764ba2
        );

    color: white;

    padding: 30px;

    border-radius: 20px;

    margin-bottom: 25px;

}

.user-hero h1 {

    margin: 0 0 8px 0;

}

.user-hero p {

    margin: 0;

    opacity: .9;

}


/* FORM */

.user-form {

    background: white;

    padding: 25px;

    border-radius: 18px;

    margin-bottom: 25px;

    box-shadow:
        0 5px 20px
        rgba(0,0,0,.07);

}

.form-grid {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 18px;

}

.form-group {

    display: flex;

    flex-direction: column;

}

.form-group label {

    font-weight: 600;

    margin-bottom: 7px;

    color: #444;

}

.form-group input,
.form-group select,
.form-group textarea {

    padding: 12px;

    border: 1px solid #ddd;

    border-radius: 9px;

    font-size: 14px;

    outline: none;

}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {

    border-color: #667eea;

}

.full {

    grid-column: 1 / -1;

}

.form-buttons {

    margin-top: 20px;

    display: flex;

    gap: 10px;

}

.form-buttons button,
.form-buttons a {

    border: none;

    padding: 12px 22px;

    border-radius: 9px;

    text-decoration: none;

    cursor: pointer;

    font-weight: 600;

}

.save-btn {

    background: #667eea;

    color: white;

}

.cancel-btn {

    background: #eee;

    color: #333;

}


/* SEARCH */

.search-box {

    background: white;

    padding: 20px;

    border-radius: 18px;

    margin-bottom: 25px;

    box-shadow:
        0 5px 20px
        rgba(0,0,0,.06);

}

.search-form {

    display: flex;

    gap: 10px;

}

.search-form input {

    flex: 1;

    padding: 13px;

    border: 1px solid #ddd;

    border-radius: 9px;

}

.search-form button {

    background: #667eea;

    color: white;

    border: none;

    padding: 12px 22px;

    border-radius: 9px;

    cursor: pointer;

}

.clear-btn {

    background: #eee;

    color: #333;

    padding: 12px 20px;

    border-radius: 9px;

    text-decoration: none;

}


/* TABLE */

.user-table {

    background: white;

    padding: 22px;

    border-radius: 18px;

    box-shadow:
        0 5px 20px
        rgba(0,0,0,.07);

    overflow-x: auto;

}

.user-table table {

    width: 100%;

    border-collapse: collapse;

}

.user-table th {

    background: #f4f5ff;

    color: #444;

}

.user-table th,
.user-table td {

    padding: 13px;

    border-bottom: 1px solid #eee;

    text-align: left;

}

.user-table tr:hover {

    background: #fafaff;

}


/* ACTION */

.action-btn {

    padding: 7px 11px;

    border-radius: 7px;

    text-decoration: none;

    font-size: 12px;

    margin-right: 4px;

}

.edit-btn {

    background: #fff3cd;

    color: #856404;

}

.delete-btn {

    background: #f8d7da;

    color: #842029;

}


/* MESSAGE */

.success-message {

    background: #d1e7dd;

    color: #0f5132;

    padding: 13px 18px;

    border-radius: 10px;

    margin-bottom: 20px;

}

.error-message {

    background: #f8d7da;

    color: #842029;

    padding: 13px 18px;

    border-radius: 10px;

    margin-bottom: 20px;

}


/* NAVIGATION */

.navigation {

    display: flex;

    justify-content: space-between;

    margin-top: 25px;

}

.navigation a {

    text-decoration: none;

    background: #667eea;

    color: white;

    padding: 12px 20px;

    border-radius: 10px;

}


@media(max-width:800px) {

    .form-grid {

        grid-template-columns: 1fr;

    }

    .full {

        grid-column: auto;

    }

}

</style>

</head>


<body>


<?php require "header.php"; ?>


<div class="content">


<!-- HERO -->

<div class="user-hero">

<h1>
👤 User Management
</h1>

<p>
Add, search, update and manage users of your Expense Management System.
</p>

</div>


<!-- MESSAGE -->

<?php if ($message != "") { ?>

<div class="success-message">

✅ <?php echo htmlspecialchars($message); ?>

</div>

<?php } ?>


<?php if ($error != "") { ?>

<div class="error-message">

❌ <?php echo htmlspecialchars($error); ?>

</div>

<?php } ?>


<!-- =========================
     ADD / EDIT FORM
========================= -->

<div class="user-form">

<h2>

<?php

if ($editUser) {

    echo "✏️ Update User";

} else {

    echo "➕ Add New User";

}

?>

</h2>


<form
    method="POST"
>


<input
    type="hidden"
    name="user_id"
    value="<?php
        echo $editUser['User_ID']
        ?? 0;
    ?>"
>


<div class="form-grid">


<div class="form-group">

<label>
Full Name *
</label>

<input
    type="text"
    name="name"
    required
    value="<?php
        echo htmlspecialchars(
            $editUser['Name']
            ?? ''
        );
    ?>"
    placeholder="Enter full name"
>

</div>


<div class="form-group">

<label>
First Name
</label>

<input
    type="text"
    name="first_name"
    value="<?php
        echo htmlspecialchars(
            $editUser['First_Name']
            ?? ''
        );
    ?>"
    placeholder="First name"
>

</div>


<div class="form-group">

<label>
Last Name
</label>

<input
    type="text"
    name="last_name"
    value="<?php
        echo htmlspecialchars(
            $editUser['Last_Name']
            ?? ''
        );
    ?>"
    placeholder="Last name"
>

</div>


<div class="form-group">

<label>
Email *
</label>

<input
    type="email"
    name="email"
    required
    value="<?php
        echo htmlspecialchars(
            $editUser['Email']
            ?? ''
        );
    ?>"
    placeholder="example@gmail.com"
>

</div>


<div class="form-group">

<label>
Password
<?php
if ($editUser) {
    echo "(leave blank to keep current)";
} else {
    echo "*";
}
?>
</label>

<input
    type="password"
    name="password"
    <?php
    if (!$editUser) {
        echo "required";
    }
    ?>
    placeholder="Enter password"
>

</div>


<div class="form-group">

<label>
Phone
</label>

<input
    type="text"
    name="phone"
    value="<?php
        echo htmlspecialchars(
            $editUser['Phone']
            ?? ''
        );
    ?>"
    placeholder="01XXXXXXXXX"
>

</div>


<div class="form-group">

<label>
Gender
</label>

<select name="gender">

<option value="">
Select Gender
</option>

<option
    value="Male"
    <?php
    if (
        ($editUser['Gender'] ?? '')
        == 'Male'
    ) echo 'selected';
    ?>
>
Male
</option>

<option
    value="Female"
    <?php
    if (
        ($editUser['Gender'] ?? '')
        == 'Female'
    ) echo 'selected';
    ?>
>
Female
</option>

<option
    value="Other"
    <?php
    if (
        ($editUser['Gender'] ?? '')
        == 'Other'
    ) echo 'selected';
    ?>
>
Other
</option>

</select>

</div>


<div class="form-group">

<label>
Date of Birth
</label>

<input
    type="date"
    name="date_of_birth"
    value="<?php
        echo $editUser['Date_of_Birth']
        ?? '';
    ?>"
>

</div>


<div class="form-group full">

<label>
Address
</label>

<textarea
    name="address"
    rows="3"
    placeholder="Enter address"
><?php
echo htmlspecialchars(
    $editUser['Address']
    ?? ''
);
?></textarea>

</div>


</div>


<div class="form-buttons">

<button
    type="submit"
    class="save-btn"
>

<?php

if ($editUser) {

    echo "💾 Update User";

} else {

    echo "➕ Add User";

}

?>

</button>


<?php if ($editUser) { ?>

<a
    href="users.php"
    class="cancel-btn"
>

Cancel

</a>

<?php } ?>

</div>


</form>

</div>


<!-- =========================
     SEARCH
========================= -->

<div class="search-box">

<h2>
🔎 Search Users
</h2>

<form
    method="GET"
    class="search-form"
>

<input
    type="text"
    name="search"
    value="<?php
        echo htmlspecialchars($search);
    ?>"
    placeholder="Search by name, email, phone..."
>

<button
    type="submit"
>

Search

</button>

<a
    href="users.php"
    class="clear-btn"
>

Clear

</a>

</form>

</div>


<!-- =========================
     USER TABLE
========================= -->

<div class="user-table">

<h2>
👥 Registered Users
</h2>


<table>

<thead>

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Phone</th>

<th>Gender</th>

<th>Date of Birth</th>

<th>Registration</th>

<th>Actions</th>

</tr>

</thead>


<tbody>

<?php

if (
    $users &&
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
    $row['Phone']
    ?? '-'
);
?>

</td>


<td>

<?php
echo htmlspecialchars(
    $row['Gender']
    ?? '-'
);
?>

</td>


<td>

<?php
echo htmlspecialchars(
    $row['Date_of_Birth']
    ?? '-'
);
?>

</td>


<td>

<?php

if (
    !empty(
        $row['Registration_Date']
    )
) {

echo date(
    "d M Y",
    strtotime(
        $row['Registration_Date']
    )
);

} else {

echo "-";

}

?>

</td>


<td>

<a
    href="users.php?edit=<?php
        echo $row['User_ID'];
    ?>"
    class="action-btn edit-btn"
>

✏️ Edit

</a>


<a
    href="users.php?delete=<?php
        echo $row['User_ID'];
    ?>"
    class="action-btn delete-btn"
    onclick="
        return confirm(
            'Are you sure you want to delete this user?'
        );
    "
>

🗑️ Delete

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
        padding:30px;
    "
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


<!-- NAVIGATION -->

<div class="navigation">

<a
    href="dashboard.php"
>

← Dashboard

</a>


<a
    href="database.php"
>

Database →

</a>

</div>


</div>


<?php require "footer.php"; ?>


</body>

</html>