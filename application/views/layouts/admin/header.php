<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Q&A - <?=$title?></title>
    <!-- favicons -->
    <link rel="apple-touch-icon" href="<?=base_url("assets/img/admin-icon.png")?>">
    <link rel="icon" href="<?=base_url("assets/img/admin-icon.png")?>">
    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&display=swap" rel="stylesheet">
    <!-- Perfect Scrollbar -->
    <link type="text/css" href="<?=base_url("assets/vendors/perfect-scrollbar.css")?>" rel="stylesheet">
    <!-- Fix Footer CSS -->
    <link type="text/css" href="<?=base_url("assets/vendors/fix-footer.css")?>" rel="stylesheet">
    <!-- Material Design Icons -->
    <link type="text/css" href="<?=base_url("assets/admin/css/material-icons.css")?>" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link type="text/css" href="<?=base_url("assets/admin/css/fontawesome.css")?>" rel="stylesheet">
    <!-- Preloader -->
    <link type="text/css" href="<?=base_url("assets/admin/css/preloader.css")?>" rel="stylesheet">
    <!-- App CSS -->
    <link type="text/css" href="<?=base_url("assets/admin/css/app.css")?>" rel="stylesheet">
    <!-- Flatpickr -->
    <link type="text/css" href="<?=base_url("assets/admin/css/flatpickr.css")?>" rel="stylesheet">
    <link type="text/css" href="<?=base_url("assets/admin/css/flatpickr-airbnb.css")?>" rel="stylesheet">
    <!-- DateRangePicker -->
    <link type="text/css" href="<?=base_url("assets/vendors/daterangepicker.css")?>" rel="stylesheet">
    <link type="text/css" href="<?=base_url("assets/admin/css/bootstrap-touchspin.css")?>" rel="stylesheet">
    <!-- Select2 -->
    <link type="text/css" href="<?=base_url("assets/admin/css/select2.css")?>" rel="stylesheet">
    <link type="text/css" href="<?=base_url("assets/vendors/select2/select2.min.css")?>" rel="stylesheet">
    <!-- SweetAlert -->
    <link href="<?=base_url("assets/css/sweetalert2.min.css")?>" rel="stylesheet" type="text/css">
    
    <!-- jQuery -->
    <!-- <script src="<?=base_url("assets/vendors/jquery.min.js")?>"></script> -->
    
    <!-- course jquery -->
    <script src="<?=base_url("assets/js/jquery.min.js")?>"></script> 

<?php
if(isset($styles)) 
{
    foreach($styles as $style) 
    {
?>
        <link rel="stylesheet" type="text/css" href="<?=base_url("assets/$style")?>">
<?php
    }
}
?>
    <link type="text/css" href="<?=base_url("assets/admin/css/custom.css?v=1")?>" rel="stylesheet">
    <script>
        var SITE_URL = "<?=site_url()?>";
    </script>
</head>
<body class="layout-sticky-subnav layout-default ">                                                                     
    <div class="preloader">
        <div class="sk-double-bounce">
            <div class="sk-child sk-double-bounce1"></div>
            <div class="sk-child sk-double-bounce2"></div>
        </div>
    </div>

    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">                                                <!-- Hide -->
    <!-- <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px"> -->               <!-- Fixed -->
        <!-- <div class="mdk-drawer-layout__content page-content"> -->                                                   <!-- Fixed -->
        <!-- Header -->
         <div id="header" class="mdk-header js-mdk-header mb-0" data-fixed data-effects="">              <!-- Hide -->
             <div class="mdk-header__content">                                                           <!-- Hide -->
                <div class="navbar navbar-expand pr-0 navbar-dark-dodger-blue navbar-shadow" id="default-navbar" data-primary>
                    <!-- Navbar toggler -->
                    <button class="navbar-toggler w-auto mr-16pt d-block rounded-0" type="button" data-toggle="sidebar">
                        <span class="material-icons">short_text</span> &nbsp;&nbsp;
                    </button>
                    <!-- Navbar Brand -->
                    <a href="<?=site_url('admin/problem')?>" class="mr-16pt">
                        <img style="width: 80px;" src="<?=base_url('assets/img/logo.png')?>" alt="logo" class="img-fluid"> 
                    </a>
                    <form class="search-form navbar-search d-none d-md-flex mr-16pt" action="#">
                        <button class="btn" type="submit"><i class="material-icons">search</i></button>
                        <input type="text" class="form-control" placeholder="Search ...">
                    </form>
                    <div class="flex"></div>
                    <div class="nav navbar-nav flex-nowrap d-flex mr-16pt">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown" data-caret="false">
                                <span class="avatar avatar-sm mr-8pt2">
                                    <span class="avatar-title rounded-circle bg-primary"><i class="material-icons">account_box</i></span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?=site_url("admin/changeAccount")?>"><i class="material-icons">face</i>My Account</a>
                                <a class="dropdown-item" href="<?=site_url("admin/changePassword")?>"><i class="material-icons">fingerprint</i>Change Password</a>
                                <a class="dropdown-item" href="<?=site_url("admin/logout")?>"><i class="material-icons">lock_outline</i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
             </div>                                                                                          <!-- Hide -->
         </div>                                                                                              <!-- Hide -->
        <!-- // END Header -->
        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content page-content ">
            <div class="pt-32pt">
                <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
                    <div class="flex d-flex flex-column flex-sm-row align-items-center">
                        <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                            <h2 class="mb-0"><?=$title?></h2>
                            <ol class="breadcrumb p-0 m-0">
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container page__container page-section" style="padding-bottom: 200px; padding-top: 15px;">