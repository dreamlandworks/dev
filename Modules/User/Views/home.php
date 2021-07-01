<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="All Services at your Finger Tips">
    <meta name="keywords" content="Repair, Electrician, Plumber, Developer, Designer">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-signin-client_id" content="231971304981-lgbk1abt2hh56m4mt6kjfabjf5hoeocj.apps.googleusercontent.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?php $this->renderSection('title') ?></title>
    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/sweetalert2.bootstrap-4.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/nice-select.css" type="text/css">
    <?php $this->renderSection('styles') ?>

</head>

<body>
    <?php

    if (session()->get("id")) {
        $_SESSION['id'] = session()->get("id");
        $_SESSION['name'] = session()->get("name");
    } else {
        $_SESSION['id'] = "";
        $_SESSION['name'] = "";
    }

    ?>

    <!-- Body Section Starts   -->
    <!-- Header Section Begin -->
    <header class="header header--normal">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="header__logo" style="width:60%">
                        <a href="index.php">
                            <img src="<?php echo base_url() ?>/public/assets/img/logo-black.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <?php $this->renderSection('menu') ?>
                            </ul>
                        </nav>
                        <?php if ($_SESSION['id'] == Null) {
                        ?>

                            <div class="header__menu__right">
                                <a href="#" class="primary-btn" id="register"><i class="fa fa-user" style="margin-right: 5px;"></i> Register</a>
                                <a href="#" class="primary-btn" id="login" data-toggle="modal" data-target="#loginForm"><i class="fa fa-lock" style="margin-right: 5px;"></i> Login</a>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="header__menu__right">
                                <a>Welcome, <?php echo $_SESSION['name']; ?></a>
                                <div class="dropdown">
                                    <button class="dropbtn"><i class="fas fa-user-circle"></i></button>
                                    <div class="dropdown-content">
                                        <a href="#">Profile</a>
                                        <a href="#">Account</a>
                                        <a href="logout">Logout</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header Section End -->

    <?php $this->renderSection('content') ?>

    <!-- Body Section End -->

    <!-- Login Form -->
    <div class="modal fade" id="loginForm" tabindex="-1" role="dialog" aria-labelledby="loginForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="padding:15px;">
                <div class="row">
                    <div class="col-lg-6 text-center">
                        <img class="login_img img-thumbnail" src="<?php echo base_url() ?>/public/assets/img/login_img.png">
                    </div>
                    <div class="col-lg-6">
                        <div class="modal-header">
                            <h3 class="text-center"><b><i style="margin-right:20px;margin-left:10px;" class="fa fa-user"></i>Login<b></h3>
                        </div>
                        <form action="login" method="post" class="form-container">
                            <div class="modal-body">
                                <div class="borderless">
                                    <input class="borderless__input" type="text" name="mobile" id="mobile" placeholder=" " aria-describedby="enter mobile number">
                                    <label class="borderless__label" for="mobile">Mobile Number</label>
                                    <i class="login1 fas fa-mobile-alt"></i>
                                </div>

                                <div class="borderless">
                                    <input class="borderless__input" type="password" name="password" id="password" placeholder=" " aria-describedby="enter mobile number">
                                    <label class="borderless__label" for="password">Password</label>
                                    <i class="login2 fas fa-unlock-alt"></i>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <div class="container">
                                <button class="btn long-button" type="submit">Login</button>
                                <div class="g-signin2" data-width="300" data-height="200" data-longtitle="true">

                                </div>
                            </div>
                        </form>
                    </div>

                </div>



            </div>


        </div>
    </div>


    <!-- Login Form Ends -->


    <script src="<?php echo base_url(); ?>/public/assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/js/sweetalert2-1.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/js/jquery.nice-select.min.js"></script>
    <script>

    </script>

    <script src="https://apis.google.com/js/platform.js" async defer></script>


    <?php $this->renderSection('script') ?>
    <script>
        // Login Form Script
        $('#register').click(function() {
            Swal.fire("Hey! Hey! Boyyyyyy");
        });

        //Google Signin Script
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();

            var name = profile.getName();
            var image = profile.getImageUrl();
            var email = profile.getEmail();

            $.post('<?php echo base_url() ?>/login', {
                type: "google",
                username: email,
                password: ""
            }, function(data) {
                alert("Data: " + data);
            });

            console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
            console.log('Name: ' + profile.getName());
            console.log('Image URL: ' + profile.getImageUrl());
            console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
        }

        //Nice Select Script
        $(document).ready(function() {
            $('select').niceSelect();
        });
    </script>

</body>

</html>