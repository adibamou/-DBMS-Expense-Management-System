<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require "config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Expense Management System</title>

<link rel="stylesheet" href="style.css">

<style>

/* =========================
   ABOUT PROJECT
========================= */

.about-wrapper{
    max-width:1100px;
    margin:0 auto;
}

/* HERO */

.project-hero{

    background:linear-gradient(
        135deg,
        #0b465f,
        #176985
    );

    color:white;

    padding:45px;

    border-radius:15px;

    margin-bottom:25px;

    box-shadow:
        0 6px 20px rgba(0,0,0,.08);
}

.project-hero h1{

    font-size:32px;

    margin-bottom:15px;
}

.project-hero p{

    font-size:15px;

    line-height:1.8;

    color:#e5eef2;

}


/* ABOUT CARD */

.about-card{

    background:white;

    border:1px solid #e4e9ec;

    border-radius:14px;

    padding:30px;

    box-shadow:
        0 4px 15px rgba(0,0,0,.04);
}

.about-card h2{

    color:#0b465f;

    font-size:21px;

    margin-bottom:18px;
}

.about-card p{

    color:#5f6b72;

    font-size:14px;

    line-height:1.9;

    margin-bottom:12px;
}


/* RESPONSIVE */

@media(max-width:800px){

    .project-hero{
        padding:28px;
    }

    .project-hero h1{
        font-size:26px;
    }

}

</style>

</head>


<body>


<?php require "header.php"; ?>


<!-- =========================
     DASHBOARD CONTENT
========================= -->

<div class="content">

<div class="about-wrapper">


<!-- PROJECT HERO -->

<div class="project-hero">

<h1>
💰 Expense Management System
</h1>

<p>
A simple and user-friendly web-based system designed
to manage income, expenses, categories, budgets and
financial goals in one organized platform.
</p>

</div>


<!-- ABOUT THE PROJECT -->

<div class="about-card">

<h2>
📌 About the Project
</h2>

<p>

The <strong>Expense Management System</strong> is a
web-based application developed to help users
manage their financial activities efficiently.

</p>

<p>

The system allows users to record their income and
expenses, organize transactions into categories,
set budgets and track financial goals.

</p>

<p>

All important financial information is stored in a
structured MySQL database, making it easier to
manage, search and view financial records.

</p>

</div>


</div>

</div>


<?php require "footer.php"; ?>


</body>

</html>