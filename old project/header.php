<?php
 include('config.php');
 include('function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                        <h1><span style="color:darkcyan;  font-family: 'Times New Roman', sans-serif;">ADY</span>CON</h1>
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="">
                            <a class="js-arrow" href="dashboard.php">
                            <i class="fas fa-solid fa-chart-line"></i>Dashboard</a>
                           
                        </li>
                        
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                            <i class="fas  fa-plus-square"></i>Masters</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="category.php">
                                    <i class="fas fa-table"></i>Expense Head</a>
                                </li>
                                <li>
                                    <a href="index2.html">Dashboard 2</a>
                                </li>
                                <li>
                                    <a href="index3.html">Dashboard 3</a>
                                </li>
                                <li>
                                    <a href="index4.html">Dashboard 4</a>
                                </li>
                            </ul>
                        </li>
                        <li>                            
                            <a href="expenses.php">
                            <i class="fas fa-rupee"></i>Expenses</a>
                        </li>
                        <li>
                            <a href="reports.php">
                            <i class="fas fa-chart-bar"></i>Reports</a>
                        </li>
                       
                        <li>
                            <a href="logout.php">
                                <i class="fa-power-off"></i>Logout</a>
                        </li>
                       
                      
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                <h1><span style="color:darkcyan;  font-family: 'Times New Roman', sans-serif;">ADY</span>CON</h1>
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="">
                            <a class="js-arrow" href="dashboard.php">
                            <i class="fas fa-solid fa-chart-line"></i>Dashboard</a>
                            
                        </li>
                        
                        <!-- <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas  fa-plus-square"></i>Masters</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                <a href="category.php">
                                <i class="fas fa-table"></i>Expense Head</a>
                                </li>
                                <li>
                                    <a href="branch.php">
                                    <i class="fas fa-sitemap"></i>Branch Master</a>
                                </li>
                                <li>
                                    <a href="index3.html">Party Master</a>
                                </li>
                                <li>
                                    <a href="index4.html">Payment Master</a>
                                </li>
                            </ul>
                        </li> -->
                       
                        <li>
                            <a href="expenses.php">
                            <i class="fas fa-rupee"></i>Expenses</a>
                        </li>
                        <li>
                            <a href="reports.php">
                            <i class="fas fa-chart-bar"></i>Reports</a>
                        </li>
                                             
                        <li>
                            <a href="logout.php">
                                <i class="fas fa-power-off"></i>Logout</a>
                        </li>
                                             
                     
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                   
                </div>
            </header>
            <!-- HEADER DESKTOP-->

