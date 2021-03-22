<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
        if($active) {
    ?>
        <title>Q&A - Practice</title>
    <?php
        }
    ?>

    <?php
        if(!$active) {
    ?>
        <title>Q&A - Examination</title>
    <?php
        }
    ?>
    
    <meta name="robots" content="noindex">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="apple-touch-icon" href="<?=base_url("assets/img/flat-icons/alarm-1.png")?>">
    <link rel="icon" href="<?=base_url("assets/img/flat-icons/alarm-1.png")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("assets/css/preloader.css")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("assets/css/app.css")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("assets/css/custom.css?v=10")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("assets/css/sweetalert2.min.css")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("assets/vendors/material-icons/material-icons.css")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("assets/vendors/font-awesome/css/font-awesome.min.css")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("assets/vendors/material-icons/material-icons.css")?>">
<?php
if(isset($styles)) 
{
    foreach($styles as $style) 
    { ?>
        <link rel="stylesheet" type="text/css" href="<?=base_url("assets/$style")?>">
        <?php
    }
}
?>
    <script src="<?=base_url("assets/js/detector.js")?>"></script>
    <script src="<?=base_url("assets/js/sweetalert2.all.min.js")?>"></script>
    <script src="<?=base_url("assets/js/jquery-1.11.3.min.js")?>"></script>
    <script src="<?=base_url("assets/js/bootstrap.min.js")?>"></script>

    <!-- With Image PopUp -->
    <!-- <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script> -->

    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="<?=base_url("assets/fancybox/lib/jquery.mousewheel.pack.js")?>"></script>

    <!-- Add fancyBox -->
    <link rel="stylesheet" href="<?=base_url("assets/fancybox/source/jquery.fancybox.css")?>" type="text/css" media="screen" />
    <script type="text/javascript" src="<?=base_url("assets/fancybox/source/jquery.fancybox.pack.js")?>"></script>
    <script>
        var SITE_URL = "<?=site_url()?>"; 
        var TIME_ALLOWED = 0.5 * 60 * 60 * 1000;
    </script>
</head>

<body class="layout-sticky-subnav layout-default">
    <div class="preloader" style="display: none;">
        <div class="sk-double-bounce">
            <div class="sk-child sk-double-bounce1"></div>
            <div class="sk-child sk-double-bounce2"></div>
        </div>
    </div>
    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout" data-domfactory-upgraded="mdk-header-layout">
        <!-- Header -->
        
        <div id="header" class="mdk-header js-mdk-header mb-0" data-fixed="" data-effects="" data-retarget-mouse-scroll="" data-domfactory-upgraded="mdk-header" style="padding-top: 64px;">
            <div class="mdk-header__bg">
                <div class="mdk-header__bg-front"></div>
                <div class="mdk-header__bg-rear"></div>
            </div>
            <div class="mdk-header__content">
                <div class="navbar navbar-expand navbar-dark-dodger-blue navbar-shadow mdk-header--fixed" id="default-navbar" data-primary="data-primary">
                    <a href="<?=site_url()?>" class="navbar-brand mr-16pt">
                        <img src="<?=base_url('assets/img/logo.png')?>" alt="logo" class="img-fluid logo-img">
                    </a>

                    <ul class="nav navbar-nav d-none d-sm-flex flex justify-content-start ml-8pt">
                        <?php
                            if($active) {
                        ?>
                            <li class="nav-item active"><a href="<?=site_url('student/practice')?>" class="nav-link">Practice</a></li>
                            <li class="nav-item"><a href="<?=site_url('student/exam')?>" class="nav-link">Examination</a></li>
                        <?php
                            }
                        ?>

                        <?php
                            if(!$active) {
                        ?>
                            <li class="nav-item"><a href="<?=site_url('student/practice')?>" class="nav-link">Practice</a></li>
                            <li class="nav-item active"><a href="<?=site_url('student/exam')?>" class="nav-link">Examination</a></li>
                        <?php
                            }
                        ?>
                    </ul>

                    <div class="flex"></div>
                    <div class="nav navbar-nav flex-nowrap d-flex mr-16pt">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown" data-caret="false">

                                <span class="avatar avatar-sm mr-8pt2">

                                    <span class="avatar-title rounded-circle bg-primary"><i class="material-icons">account_box</i></span>

                                </span>

                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?=site_url("student/changeAccount")?>"><i class="material-icons">face</i>My Account</a>
                                <a class="dropdown-item" href="<?=site_url("student/changePassword")?>"><i class="material-icons">fingerprint</i>Change Password</a>
                                <a class="dropdown-item" href="<?=site_url("logout")?>"><i class="material-icons">lock_outline</i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mdk-header-layout__content page-content " style="padding-top: 64px;">
