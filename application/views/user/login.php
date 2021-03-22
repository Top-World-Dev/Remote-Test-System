<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <!-- favicons -->
    <link rel="apple-touch-icon" href="<?=base_url("assets/img/flat-icons/alarm-1.png")?>">
    <link rel="icon" href="<?=base_url("assets/img/flat-icons/alarm-1.png")?>">
    <title>Login</title>
    <!-- CSS -->
    <link href="<?=base_url("assets/vendors/material-icons/material-icons.css")?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url("assets/vendors/mono-social-icons/monosocialiconsfont.css")?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url("assets/css/sweetalert2.min.css")?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url("assets/css/perfect-scrollbar.min.css")?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet" type="text/css">
    <link href="<?=base_url("assets/css/font-awesome.min.css")?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url("assets/css/style.css")?>" rel="stylesheet" type="text/css">
</head>
<body class="body-bg-full profile-page" style="background-image: url(<?=base_url("assets/demo/carousel/carousel-1.jpg")?>)">
    <div id="wrapper" class="row wrapper">
        <div class="col-10 offset-1 offset-sm-3 col-sm-6 col-md-4 offset-md-4 login-center">
            <div class="navbar-header text-center my-3">
                <a href="<?=site_url()?>">
                    <img style="margin-bottom: 15px;" alt="" src="<?=base_url("assets/img/user-logo.png")?>">
                </a>
            </div>
        <?php
            $attributes = array("id" => "loginform", "name" => "login", "class" => "form-horizontal form-material");
            echo form_open("login", $attributes);
            $msg = $this->session->flashdata('lmsg');
            if ($msg) 
            { 
        ?>
                <div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
                    <i class="material-icons list-icon">warning</i>
                    <span><?=$msg?></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        <?php
            } 
        ?>
                <div class="form-group">
                    <input type="email" placeholder="Email Address" class="form-control form-control-line" name="uemail" id="uemail" value="<?=set_value("uemail")?>">
                    <label for="uemail">Email</label>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" class="form-control form-control-line" name="upwd" value="<?=set_value("upwd")?>">
                    <label>Password</label>
                </div>
                <div class="form-group">
                    <button class="btn btn-block btn-lg btn-color-scheme ripple" type="submit">Login</button>
                </div>
                <div class="form-group no-gutters mb-0">
                    <div class="col-md-12 d-flex">
                        <div class="checkbox checkbox-info mr-auto">
                        </div>
                        <!--<a href="javascript:void(0)" id="to-recover" class="text-dark my-auto pb-2"><i class="fa fa-lock mr-1"></i>Forgot Password?</a>-->
                    </div>
                    <!-- /.col-md-12 -->
                </div>
                <!-- /.form-group -->
        <?php
            echo form_close(); 
        ?>
            <!-- /.form-horizontal -->
            <!-- /.btn-list -->
            <footer class="col-sm-12 text-center">
                <hr>
                <p>Don't have an account? <a href="<?=site_url("user/signup")?>" class="text-primary m-l-5"><b>Sign Up</b></a>
                </p>
            </footer>
        </div>
        <!-- /.login-center -->
    </div>
    <!-- /.body-container -->
    <!-- Scripts -->
    <script src="<?=base_url("assets/js/jquery.min.js")?>"></script>
    <script src="<?=base_url("assets/js/tether.min.js")?>"></script>
    <script src="<?=base_url("assets/js/bootstrap.min.js")?>"></script>
    <script src="<?=base_url("assets/js/material-design.js")?>"></script>
</body>
</html>