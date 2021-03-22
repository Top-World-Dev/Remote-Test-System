<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>Sign Up</title>
    <!-- favicons -->
    <link rel="apple-touch-icon" href="<?=base_url("assets/img/flat-icons/alarm-1.png")?>">
    <link rel="icon" href="<?=base_url("assets/img/flat-icons/alarm-1.png")?>">
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
<?php
    if (isset($confirm) && $confirm) { ?>
        <div class="col-10 offset-1 offset-sm-3 col-sm-6 col-md-4 offset-md-4 login-center login-center-mini">
            <div class="navbar-header text-center">
                <a href="<?=site_url()?>">
                    <img style="margin-bottom: 15px; margin-top: 15px;" alt="" src="<?=base_url("assets/img/user-logo.png")?>">
                </a>
            </div>
            <!-- /.navbar-header -->
            <div class="text-center mr-b-20">
                <img src="<?=base_url("assets/demo/users/default-avatar.jpg")?>" class="img-circle img-thumbnail thumb-lg" alt="">
            </div>
            <p class="text-center text-muted">Congratulations!  You have been successfully registered for your account.</p>
            <a href="<?=site_url("login")?>" class="btn btn-block btn-primary ripple mr-tb-30">Login Now!</a>
        </div>
        <?php
    } else { ?>
        <div class="col-10 offset-2 offset-sm-3 col-sm-6 col-md-4 offset-md-4 login-center">
            <div class="navbar-header text-center">
                <a href="<?=site_url()?>">
                    <img style="margin-bottom: 15px; margin-top: 15px;" alt="" src="<?=base_url("assets/img/user-logo.png")?>">
                </a>
            </div>
            <!-- /.navbar-header -->
        <?php
            $attributes = array("id" => "loginform", "name" => "signup");
            echo form_open("user/signup", $attributes);
            $msg = $this->session->flashdata('msg');
            if ($msg) { ?>
                <div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
                    <i class="material-icons list-icon">warning</i>
                    <span><?=$msg?></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            } ?>
                <h6 class="text-uppercase">Register Now</h6>
                <p class="text-muted">Create your account for free and enjoy.</p>
                <div class="form-group <?=(form_error('uname') ? 'has-error has-danger':'')?>">
                    <label class="form-control-label">Name</label>
                    <input type="hidden" id="ref" name="ref" value="" />
                    <input class="form-control" type="text" name="uname" required="" placeholder="Name" value="<?=set_value('uname')?>">
                    <div class="help-block form-control-feedback with-errors" data-bv-for="uname">
                        <ul class="list-unstyled"><li><?=form_error('uname')?></li></ul>
                    </div>
                </div>
                <div class="form-group <?=(form_error('uemail') ? 'has-error has-danger':'')?>">
                    <label>Email Address</label>
                    <input class="form-control" type="text" name="uemail" required="" placeholder="Email Address" value="<?=set_value('uemail')?>" >
                    <div class="help-block form-control-feedback with-errors" data-bv-for="uemail">
                        <ul class="list-unstyled"><li><?=form_error('uemail')?></li></ul>
                    </div>
                </div>
                <div class="form-group <?=(form_error('upwd') ? 'has-error has-danger':'')?>">
                    <label>Password</label>
                    <input class="form-control" type="password" name="upwd" required="" placeholder="Password" value="<?=set_value('upwd')?>">
                    <div class="help-block form-control-feedback with-errors" data-bv-for="upwd">
                        <ul class="list-unstyled"><li><?=form_error('upwd')?></li></ul>
                    </div>
                </div>
                <div class="form-group <?=(form_error('urpwd') ? 'has-error has-danger':'')?>">
                    <label class="form-control-label">Confirm Password</label>
                    <input class="form-control" type="password" name="urpwd" required="" placeholder="Confirm Password" value="<?=set_value('urpwd')?>">
                    <div class="help-block form-control-feedback with-errors" data-bv-for="urpwd">
                        <ul class="list-unstyled"><li><?=form_error('urpwd')?></li></ul>
                    </div>
                </div>
                <!-- /.form-group -->
                <div class="form-group text-center no-gutters mb-5">
                    <button class="btn btn-info btn-lg btn-block text-uppercase ripple" type="submit">Sign Up</button>
                </div>
                <?php
            echo form_close(); 
        ?>
            <!-- /.form-horzontal -->
            <footer class="col-sm-12 text-center">
                <hr>
                <p>Already have an account? <a href="<?=site_url("login")?>" class="text-primary m-l-5"><b>Log In</b></a></p>
            </footer>
        </div>
        <!-- /.login-center -->
        <?php
    }
?>
    </div>
    <!-- /.body-container -->
    <!-- Scripts -->
    <script src="<?=base_url("assets/js/jquery.min.js")?>"></script>
    <script src="<?=base_url("assets/js/tether.min.js")?>"></script>
    <script src="<?=base_url("assets/js/bootstrap.min.js")?>"></script>
    <script src="<?=base_url("assets/js/material-design.js")?>"></script>
    <script>
        var ref = localStorage.getItem("ref");
        if (ref)
            $('#ref').val(ref);
    </script>
</body>
</html>