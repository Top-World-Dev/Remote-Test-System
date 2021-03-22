<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="robots" content="noindex">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="apple-touch-icon" href="<?=base_url("assets/img/flat-icons/alarm-1.png")?>">
    <link rel="icon" href="<?=base_url("assets/img/flat-icons/alarm-1.png")?>">
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

    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="<?=base_url("assets/fancybox/lib/jquery.mousewheel.pack.js")?>"></script>

    <!-- Add fancyBox -->
    <link rel="stylesheet" href="<?=base_url("assets/fancybox/source/jquery.fancybox.css")?>" type="text/css" media="screen" />
    <script type="text/javascript" src="<?=base_url("assets/fancybox/source/jquery.fancybox.pack.js")?>"></script>
    <script>
        var API_KEY = "<?=$apikey?>"; 
        var SITE_URL = "<?=site_url()?>";
        var AUTH_TOKEN = "Basic <?=$authToken?>";
        var TIME_ALLOWED =  <?=$allowed['value']?>;
    </script>
</head>

<body class="layout-sticky-subnav layout-default">
