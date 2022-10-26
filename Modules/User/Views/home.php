<!DOCTYPE html>
<html amp lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>
        <?php $this->renderSection("title") ?>
    </title>
    <link rel="canonical" href="https://www.squill.in/index.php">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <style amp-boilerplate>
        body {
            -webkit-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
            -moz-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
            -ms-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
            animation: -amp-start 8s steps(1, end) 0s 1 normal both
        }

        @-webkit-keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

        @-moz-keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

        @-ms-keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

        @-o-keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

        @keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }
    </style>
    <noscript>
        <style amp-boilerplate>
            body {
                -webkit-animation: none;
                -moz-animation: none;
                -ms-animation: none;
                animation: none
            }
        </style>

    </noscript>
    <script async src="https://cdn.ampproject.org/v0.js"></script>

    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>/assets/img/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>/assets/img/icons//apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>/assets/img/icons//apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>/assets/img/icons//apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>/assets/img/icons//apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>/assets/img/icons//apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>/assets/img/icons//apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>/assets/img/icons//apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>/assets/img/icons//apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo base_url(); ?>/assets/img/icons//android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>/assets/img/icons//favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>/assets/img/icons//favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>/assets/img/icons//favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url(); ?>/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">



    <!-- Google Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> -->

    <!-- Vendor CSS Files -->
    <!-- <link href="<?php echo base_url(); ?>/assets/css/combine.min.css" rel="stylesheet"> -->
    <link href="<?php echo base_url(); ?>/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/vendor/font-awesome/css/all.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/vendor/sweetalert/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/carousel/css/animate.css">


    <!-- Template Main CSS File -->
    <link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">

    <!-- Each Page CSS files comes here -->
    <?php $this->renderSection("styles") ?>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center header-scrolled">
        <div class="container d-flex align-items-center justify-content-between">

            <div class="logo">
                <!-- <h1><a href="index.html"><span>SQUILL</span></a></h1> -->
                <!-- Uncomment below if you prefer to use an image logo -->
                <a href="index.html">
                    <amp-img src="<?php echo base_url(); ?>/assets/img/logo.avif" style="width:100%" alt="" class="img-fluid" width="160" height="80"></amp-img>
                </a>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto" href="<?php echo base_url(); ?>#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="<?php echo base_url(); ?>#about">About</a></li>
                    <li><a class="nav-link scrollto" href="<?php echo base_url(); ?>#features">Features</a></li>

                    <li class="dropdown"><a href="#"><span>More</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <!-- <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li> -->
                            <li><a href="<?php echo base_url(); ?>#details">Why Us</a></li>
                            <li><a href="<?php echo base_url(); ?>#testimonials">Testimonials</a></li>
                            <li><a href="<?php echo base_url(); ?>#categories">Our Services</a></li>
                            <li><a href="<?php echo base_url(); ?>#pricing">Pricing</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-link scrollto" href="<?php echo base_url(); ?>#contact">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <?php $this->renderSection("content") ?>



    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-4 col-md-6">
                        <div class="footer-info">
                            <!-- <h3>SQUILL</h3> -->
                            <a href="index.html">
                                <amp-img src="<?php echo base_url(); ?>/assets/img/logo.avif" style="width:50%" alt="" class="img-fluid" width="200" height="100"></amp-img>
                            </a>
                            <p class="pb-3"><em>A product by Satrango Pvt Ltd</em>
                            </p>
                            <p>
                                Bharathi Nagar 14th Line <br>
                                Vijayawada, Andhra Pradesh <br>
                                IN 520008<br><br>
                                <strong>Phone:</strong> +91 81-0038-0039<br>
                                <strong>Email:</strong> support@satrango.com<br>
                            </p>
                            <!-- <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div> -->
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>/#hero">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>/#about">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>/#details">Why Us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>/#categories">Our Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>/#testimonials">Testimonials</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>/#pricing">Pricing</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>/#contact">Contact Us</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Imp Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>/spfaq">FAQs - Providers</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>/userfaq">FAQs - Users</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>/terms">Terms & Conditions</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>/privacy">Privacy Policy</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo base_url(); ?>/disclaimer">Disclaimer</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>Want to Know More?</h4>
                        <p>Drop you mobile Number below, one of our team will contact you soon</p>
                        <form id="subs" action="<?php echo base_url(); ?>/subs" method="post">
                            <input type="phone" name="mobile" id="mobile">
                            <input type="submit" class="button" value="Submit">
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Satrango Pvt Ltd</span></strong>. All Rights Reserved
            </div>
            <!-- <div class="credits"> -->
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/bootslander-free-bootstrap-landing-page-template/ -->
            <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
            <!-- </div> -->
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/purecounter/purecounter.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/aos/aos.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/php-email-form/validate.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/sweetalert/sweetalert2.all.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/carousel/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/carousel/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/carousel/js/main.js"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <?php $this->renderSection('script') ?>

    <script>
        // Subscription Form Script Here 
        $("form#subs").submit(function() {
            mobile = $("#mobile").val();
            url = "<?php echo base_url() . '/subs'; ?>";

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . '/subs' ?>",
                data: {
                    mobile: mobile
                },
                dataType: 'json',
                encode: true
            }).done(function(data) {
                console.log(data);
            });
            event.preventDefault();

            $('#mobile').val("");

            Swal.fire(
                'Thank You!',
                'You will hear from us Soon!',
                'success'
            )
        });
    </script>



        <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-224110753-1">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-224110753-1');
</script>

<!-- Fresh works Chat Widget Start -->
<!-- <script
src='//in.fw-cdn.com/30543745/300064.js'
chat='true'>
</script> -->

<!-- Fresh works Chat Widget Ends -->

<!-- ZOHO Integrations -->

<script type="text/javascript" id="zsiqchat">
var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode: "08bbfb051657252500f5e3edbb4a4c3e0f626342fb548edc158b525443e73a60394c0367f9a145a40269b2398862ec7e", values:{},ready:function(){}};
var d=document;s=d.createElement("script");
s.type="text/javascript";
s.id="zsiqscript";
s.defer=true;s.src="https://salesiq.zoho.in/widget";
t=d.getElementsByTagName("script")[0];
t.parentNode.insertBefore(s,t);
</script>

</body>

</html>