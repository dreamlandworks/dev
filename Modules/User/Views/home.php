<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="All Services at your Finger Tips">
    <meta name="keywords" content="Repair, Electrician, Plumber, Developer, Designer">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php $this->renderSection('title') ?></title>
    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/sweetalert2.bootstrap-4.min.css" type="text/css">

    <?php $this->renderSection('styles') ?>

</head>

<body>
    <?php session_start();
    $_SESSION["id"] = "";
    $_SESSION["name"] = "";

    // $_SESSION["id"] = 1;
    // $_SESSION["name"] = "Phaneendra Kumar Patnala";

    ?>

    <!-- Body Section Starts         -->
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="padding:15px;">
                <div class="modal-header">
                    
                        <h3>Login</h3>
                </div>
                <form action="index.php" method="post" class="form-container">        
                <div class="modal-body">
                    <div class="form-group">
                        <label for="mobile"><b>Mobile Number</b></label>
                        <input type="text" class="form-control" aria-describedby="Mobile Number help" placeholder="Enter Your Mobile Number" name="mobile" required>
                    </div>

                    <div class="form-group">
                        <label for="password"><b>Password</b></label>
                        <input type="password" class="form-control" aria-describedby="Password help" placeholder="Enter Your Password" name="password" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" >Login</button>
                    <button class="btn btn-danger" type="submit" onclick="closeForm()">Close</button>
                   
                </div>
                </form>

            </div>


        </div>
    </div>


    <!-- Login Form Ends -->


    <script src="<?php echo base_url(); ?>/public/assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/js/sweetalert2-1.min.js"></script>

    <?php $this->renderSection('script') ?>
    <script>
        // Login Form Script
        $('#register').click(function() {
            Swal.fire("Hey! Hey! Boyyyyyy");
        });
    </script>

</body>

</html>