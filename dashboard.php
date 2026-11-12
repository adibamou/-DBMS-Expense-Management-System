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
   ABOUT PROJECT PAGE
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

    padding:40px;

    border-radius:15px;

    margin-bottom:25px;

    box-shadow:
        0 6px 20px rgba(0,0,0,.08);
}

.project-hero h1{
    font-size:32px;
    margin-bottom:12px;
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

    margin-bottom:25px;

    box-shadow:
        0 4px 15px rgba(0,0,0,.04);
}

.about-card h2{
    color:#0b465f;

    font-size:21px;

    margin-bottom:15px;
}

.about-card p{
    color:#5f6b72;

    font-size:14px;

    line-height:1.8;

    margin-bottom:10px;
}

/* OBJECTIVES */

.objectives{
    display:grid;

    grid-template-columns:
        repeat(2,1fr);

    gap:15px;

    margin-top:20px;
}

.objective{
    background:#f5f8fa;

    border:1px solid #e4e9ec;

    border-radius:10px;

    padding:18px;
}

.objective strong{
    color:#0b465f;

    display:block;

    margin-bottom:7px;

    font-size:14px;
}

.objective span{
    color:#777;

    font-size:13px;

    line-height:1.5;
}

/* PROJECT DETAILS */

.project-details{
    display:grid;

    grid-template-columns:
        repeat(2,1fr);

    gap:20px;
}

.detail-box{
    background:white;

    border:1px solid #e4e9ec;

    border-radius:14px;

    padding:25px;
}

.detail-box h3{
    color:#0b465f;

    margin-bottom:15px;

    font-size:18px;
}

.detail-box ul{
    padding-left:20px;

    color:#666;

    line-height:2;

    font-size:14px;
}

/* RESPONSIVE */

@media(max-width:800px){

    .project-details{
        grid-template-columns:1fr;
    }

    .objectives{
        grid-template-columns:1fr;
    }

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


<!-- PROJECT DETAILS -->

<div class="project-details">


<!-- OBJECTIVE -->

<div class="detail-box">

<h3>
🎯 Project Objectives
</h3>

<ul>

<li>
Manage income and expense records.
</li>

<li>
Organize transactions using categories.
</li>

<li>
Create and manage budgets.
</li>

<li>
Track financial goals.
</li>

<li>
Search financial records easily.
</li>

<li>
Generate financial reports.
</li>

</ul>

</div>


<!-- SYSTEM FEATURES -->

<div class="detail-box">

<h3>
⚙️ System Features
</h3>

<ul>

<li>
User Management
</li>

<li>
Category Management
</li>

<li>
Transaction Management
</li>

<li>
Budget Management
</li>

<li>
Goal Management
</li>

<li>
Search & Monthly Report
</li>

</ul>

</div>


</div>


<!-- DATABASE -->

<div class="about-card"
     style="margin-top:25px;">

<h2>
🗄️ Database Structure
</h2>

<p>
The system uses MySQL database named
<strong>ep</strong>.
</p>

<div class="objectives">


<div class="objective">

<strong>👤 USERS</strong>

<span>
Stores user information such as name,
email, phone and registration details.
</span>

</div>


<div class="objective">

<strong>🏷️ CATEGORY</strong>

<span>
Stores income and expense categories.
</span>

</div>


<div class="objective">

<strong>💳 TRANSACTION</strong>

<span>
Stores income and expense transaction
information.
</span>

</div>


<div class="objective">

<strong>📊 BUDGET</strong>

<span>
Stores budget limits and date information.
</span>

</div>


<div class="objective">

<strong>🎯 GOAL</strong>

<span>
Stores financial and savings goals.
</span>

</div>


</div>

</div>


<!-- DEVELOPED BY -->

<div class="about-card">

<h2>
👩‍💻 Project Information
</h2>

<p>
<strong>Project Name:</strong>
Expense Management System
</p>

<p>
<strong>Database:</strong>
MySQL
</p>

<p>
<strong>Technology:</strong>
HTML, CSS, PHP and MySQL
</p>

<p>
<strong>Developed By:</strong>
Adiba Rahman
</p>

<p>
<strong>ID:</strong>
25103013
</p>

</div>


</div>

</div>


<?php require "footer.php"; ?>


</body>

</html>