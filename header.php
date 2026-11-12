<?php

$currentPage = basename($_SERVER['PHP_SELF']);

?>

<!-- =========================
     SIDEBAR
========================= -->

<div class="sidebar">

    <div class="logo">
        Expense <span>Management</span>
    </div>


    <!-- MAIN MENU -->

    <div class="menu-title">
        Main Menu
    </div>


    <a href="index.php"
       class="<?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">
        🏠 Dashboard
    </a>


    <a href="users.php"
       class="<?php echo $currentPage == 'users.php' ? 'active' : ''; ?>">
        👤 Users
    </a>


    <a href="category.php"
       class="<?php echo $currentPage == 'category.php' ? 'active' : ''; ?>">
        🏷️ Category
    </a>


    <a href="transaction.php"
       class="<?php echo $currentPage == 'transaction.php' ? 'active' : ''; ?>">
        💳 Transactions
    </a>



    <!-- FINANCIAL -->

    <div class="menu-title">
        Financial
    </div>


    <a href="budget.php"
       class="<?php echo $currentPage == 'budget.php' ? 'active' : ''; ?>">
        📊 Budget
    </a>


    <a href="goal.php"
       class="<?php echo $currentPage == 'goal.php' ? 'active' : ''; ?>">
        🎯 Goals
    </a>


    <a href="monthly_report.php"
       class="<?php echo $currentPage == 'monthly_report.php' ? 'active' : ''; ?>">
        📅 Financial Statement
    </a>


    <a href="payment.php"
       class="<?php echo $currentPage == 'payment.php' ? 'active' : ''; ?>">
        💰 Payment
    </a>



    <!-- SYSTEM -->

    <div class="menu-title">
        System
    </div>


    <a href="search.php"
       class="<?php echo $currentPage == 'search.php' ? 'active' : ''; ?>">
        🔎 Search
    </a>


    <a href="database.php"
       class="<?php echo $currentPage == 'database.php' ? 'active' : ''; ?>">
        🗄️ Database
    </a>

</div>



<!-- =========================
     MAIN CONTENT
========================= -->

<div class="main">


    <!-- TOP HEADER -->

    <div class="topbar">


        <div class="page-title">

            Expense Management System

        </div>



        <div class="admin">


            <div class="avatar">

                A

            </div>


            <div>

                <strong>
                    Admin User
                </strong>

                <br>

                <small style="color:#888;">

                    Expense Manager

                </small>

            </div>


        </div>


    </div>