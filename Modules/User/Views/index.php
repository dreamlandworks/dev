<?php $this->extend('Modules\User\Views\home') ?>


<?php $this->section('title') ?>

Welcome to Squill

<?php $this->endsection() ?>


<?php $this->section('styles') ?>
<!-- Styles will go here -->
<style>
    .carousel-nav a {
        color: #1acc8d;
        text-transform: uppercase;
        text-decoration: none;
        letter-spacing: 0.15em;
        text-align: center;
        display: inline-block;
        padding: 15px 20px;
        position: relative;
        border-bottom: 0.5px solid #1acc8d;
    }

    .carousel-nav a:after {
        background: none repeat scroll 0 0 transparent;
        bottom: 0;
        content: "";
        display: block;
        height: 2px;
        left: 50%;
        position: absolute;
        background: #1acc8d;
        transition: width 0.3s ease 0s, left 0.3s ease 0s;
        width: 0;
    }

    .carousel-nav a.active {
        color: #fff;
        background: #1acc8d;

    }

    .carousel-nav a:hover:after {
        width: 100%;
        left: 0;
    }
</style>

<?php $this->endsection() ?>



<?php $this->section('content') ?>

<!-- ======= Hero Section ======= -->
<section id="hero">

    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-7 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
                <div data-aos="zoom-out">
                    <h1>Spend your time for things you love and let <span>SQUILL</span></h1>
                    <h2>handle all your chores</h2>
                    <div class="text-center text-lg-start">
                        <a href="https://play.google.com/store/apps/details?id=com.satrango">
                            <amp-img src="<?php echo base_url(); ?>/assets/img/icons/google-play.avif" alt="" class="img-fluid " width="180" height="60"></amp-img>
                        </a>
                        <!-- <a href="#about" class="btn-get-started scrollto">Get Started</a> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="300">
                <amp-img src="<?php echo base_url(); ?>/assets/img/hero-img.webp" class="img-fluid animated" alt="" width="450" height="600"></amp-img>
            </div>
        </div>
    </div>

    <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
        <defs>
            <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
        </defs>
        <g class="wave1">
            <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
        </g>
        <g class="wave2">
            <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
        </g>
        <g class="wave3">
            <use xlink:href="#wave-path" x="50" y="9" fill="#fff">
        </g>
    </svg>

</section><!-- End Hero -->

<main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch" data-aos="fade-right">
                    <!-- <a href="#" class="venobox play-btn mb-4" data-vbtype="video" -->
                    <!-- data-autoplay="true"></a> -->
                </div>

                <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5" data-aos="fade-left">
                    <h3>Come-on Let's Build a Comfortable World</h3>
                    <p>We are mainly focused to get rid of the hassles involved in finding and hiring professionals online.
                        Eventhough in some situations problems
                        arise in successful completion of the tasks by the hired service professionals which is another hassle. We
                        aim to solve them by our cutting
                        edge AI based platform and serve you to your full satisfaction </p>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">
                        <div class="icon"><i class="bx bx-fingerprint"></i></div>
                        <h4 class="title"><a href="">Instant Hiring</a></h4>
                        <p class="description">You can find and hire nearby service providers instantly by identifying the best
                            using genuine reviews by users
                            who already used the services and ranking system. </p>
                    </div>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="200">
                        <div class="icon"><i class="bx bx-gift"></i></div>
                        <h4 class="title"><a href="">Get Lowest Quotes</a></h4>
                        <p class="description">Don't worry about the prices, because you can now post your requirement and get lot
                            of quotes from our verified service
                            providers out of which you can choose whom you want to hire</p>
                    </div>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="300">
                        <div class="icon"><i class="bx bx-atom"></i></div>
                        <h4 class="title"><a href="">Timely Completion</a></h4>
                        <p class="description">Our platform tracks, monitors and helps in completion of the tasks by the service
                            provider under the scheduled time. You can also monitor
                            the status in realtime by using our app</p>
                    </div>

                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
        <div class="container">

            <div class="section-title" data-aos="fade-up">
                <h2>Features</h2>
                <p>Check The Features</p>
            </div>

            <div class="row" data-aos="fade-left">
                <div class="col-lg-3 col-md-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="50">
                        <i class="ri-store-line" style="color: #ffbb2c;"></i>
                        <h3><a href="">Hire any professional Instantly</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">
                        <i class="ri-bar-chart-box-line" style="color: #5578ff;"></i>
                        <h3><a href="">No long term commitments</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="150">
                        <i class="ri-calendar-todo-line" style="color: #e80368;"></i>
                        <h3><a href="">Hassle free cancellations & Refunds</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4 mt-lg-0">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="200">
                        <i class="ri-paint-brush-line" style="color: #e361ff;"></i>
                        <h3><a href="">Insurance Coverage for every task</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="250">
                        <i class="ri-database-2-line" style="color: #47aeff;"></i>
                        <h3><a href="">Post your requirements</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="300">
                        <i class="ri-gradienter-line" style="color: #ffa76e;"></i>
                        <h3><a href="">Choose your favourite Professional</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="350">
                        <i class="ri-file-list-3-line" style="color: #11dbcf;"></i>
                        <h3><a href="">24/7 Availability</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="400">
                        <i class="ri-price-tag-2-line" style="color: #4233ff;"></i>
                        <h3><a href="">Hire Hourly/ Daily/ Project based</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="450">
                        <i class="ri-anchor-line" style="color: #b2904f;"></i>
                        <h3><a href="">Get Lowest Quotes for your work</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="500">
                        <i class="ri-disc-line" style="color: #b20969;"></i>
                        <h3><a href="">Real reviews from our users</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="550">
                        <i class="ri-base-station-line" style="color: #ff5828;"></i>
                        <h3><a href="">No Tolerance Policy</a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-4">
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="600">
                        <i class="ri-fingerprint-line" style="color: #29cc61;"></i>
                        <h3><a href="">Verified & Qualified Professionals</a></h3>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Features Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
        <div class="container">

            <div class="row" data-aos="fade-up">

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="bi bi-emoji-smile"></i>
                        <span data-purecounter-start="0" data-purecounter-end="117" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Happy Clients</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                    <div class="count-box">
                        <i class="bi bi-journal-richtext"></i>
                        <span data-purecounter-start="0" data-purecounter-end="216" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Job Posts</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="bi bi-headset"></i>
                        <span data-purecounter-start="0" data-purecounter-end="87" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Hours Of Support</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="bi bi-people"></i>
                        <span data-purecounter-start="0" data-purecounter-end="312" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Professionals</p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Counts Section -->

    <!-- ======= Details Section ======= -->
    <section id="details" class="details">
        <div class="container">

            <div class="row content">
                <div class="col-md-4" data-aos="fade-right">
                    <amp-img src="<?php echo base_url(); ?>/assets/img/details-1.avif" class="img-fluid" alt="" width="400" height="400"></amp-img>
                </div>
                <div class="col-md-8 pt-4" data-aos="fade-up">
                    <h3>Hire a professional</h3>
                    <p class="fst-italic">
                        If you are an individual looking to hire some expert professional to get your work done without any
                        hassles, we offer you
                    </p>
                    <ul>
                        <li><i class="bi bi-check"></i> Option to choose service provider based on various metrics like price,
                            rating etc., </li>
                        <li><i class="bi bi-check"></i> Hassle free hiring and tracking of work progress remotely.</li>
                        <li><i class="bi bi-check"></i> Can obtain the lowest quotation from service providers by posting a job
                            requirement.</li>
                        <li><i class="bi bi-check"></i> Can cancel, reschedule easily.</li>
                        <li><i class="bi bi-check"></i> 24x7 omnichannel customer support through your favourite app like email,
                            whatsapp, telegram, skype etc.,</li>
                    </ul>
                    <p>
                        Our platform is completely FREE . Try once to believe us.
                    </p>
                </div>
            </div>

            <div class="row content">
                <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                    <amp-img src="<?php echo base_url(); ?>/assets/img/details-2.avif" class="img-fluid" alt="" width="400" height="400"></amp-img>
                </div>
                <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
                    <h3>Want to get Hired?</h3>
                    <p class="fst-italic">
                        If you are a professional who wants to get hired instantly and earn more without hassles of long term
                        commmitments, join us to
                    </p>
                    <ul>
                        <li><i class="bi bi-check"></i> Earn more by getting hired repeatedly., </li>
                        <li><i class="bi bi-check"></i> Get Opportunity to work with big companies and projects.</li>
                        <li><i class="bi bi-check"></i> Place bids on the job posts and win the bidding.</li>
                        <li><i class="bi bi-check"></i> Have freedom to work in your available timings and choice to decide your
                            own tariff</li>
                        <li><i class="bi bi-check"></i> Get online training and improve your existing skillset and develop new
                            ones.</li>
                        <li><i class="bi bi-check"></i> Get regular bookings and track all of them easily in the app</li>
                        <li><i class="bi bi-check"></i> Work without long term commitments</li>
                    </ul>
                </div>
            </div>

            <div class="row content">
                <div class="col-md-4" data-aos="fade-right">
                    <amp-img src="<?php echo base_url(); ?>/assets/img/details-3.avif" class="img-fluid" alt="" width="250" height="400"></amp-img>
                </div>
                <div class="col-md-8 pt-5" data-aos="fade-up">
                    <h3>Pay as you need Staffing for Businesses </h3>
                    <p>If you are a business looking for staff who can work when you need them most without long term
                        commitments, join us to..</p>
                    <ul>
                        <li><i class="bi bi-check"></i> Hire expert professionals on Hourly/ Daily or Project Based </li>
                        <li><i class="bi bi-check"></i> Hire with no long term commitments like pay even though you don't need
                            them or unwanted leave, salary hikes etc.,</li>
                        <li><i class="bi bi-check"></i> get advantage of easy to adopt technology.</li>
                        <li><i class="bi bi-check"></i> go easy on pockets</li>
                        <li><i class="bi bi-check"></i> Have hassle free management remotely through app</li>
                        <li><i class="bi bi-check"></i> Monetize demand during peak times easily without extra effort on pockets
                        </li>

                    </ul>

                </div>
            </div>

    </section><!-- End Details Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
        <div class="container">

            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <amp-img src="<?php echo base_url(); ?>/assets/img/testimonials/testimonials-1.avif" class="testimonial-img" alt="" width="100" height="100"></amp-img>
                            <h3>Sukumar</h3>
                            <h4>Verified User</h4>
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                I was travelling in my car last week and it suddenly stopped in the middle of no where, I used search
                                engines and tried two other apps also for a mechanic nearby and failed.
                                Then I tried this app for the first time and miraculously found a mechanic 20 min away from my
                                location and got my car repaired in no time. Thanks guys.
                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <amp-img src="<?php echo base_url(); ?>/assets/img/testimonials/testimonials-2.avif" class="testimonial-img " alt="" width="100" height="100"></amp-img>
                            <h3>Ratna Kumar G</h3>
                            <h4>Verified User</h4>
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                I was working on a project and needed the help of React Professional to assist me on immediate basis.
                                But my budget was somewhat low to consider expensive options over the
                                the Internet. Then my friend referred this, Thank god I found a good react professional who is also
                                close by me and helped in timely completion of the project.
                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <amp-img src="<?php echo base_url(); ?>/assets/img/testimonials/testimonials-3.avif" class="testimonial-img " alt="" width="100" height="100"></amp-img>
                            <h3>K Sarada Devi</h3>
                            <h4>Verified Professional</h4>
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                I was looking to hire Packers and Movers for my house shifting, I tried calling many people from
                                Internet but their rates are too high. I have posted my requirement in this app
                                and with in two days, this app joined me with some other person who is looking for the same
                                requirement from other side and as you know we both got the best deal. God Bless you keep it up.
                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <amp-img src="<?php echo base_url(); ?>/assets/img/testimonials/testimonials-4.avif" class="testimonial-img " alt="" width="100" height="100"></amp-img>
                            <h3>Pattabhiram Pasumarthi</h3>
                            <h4>Verified Professional</h4>
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                I have recently joined in this app as a Grocery Delivery Boy and earned Rs. 12780/- last month by
                                working 3-4 hours a day in my free time. Thanks Squill.
                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <amp-img src="<?php echo base_url(); ?>/assets/img/testimonials/testimonials-5.avif" class="testimonial-img " alt="" width="100" height="100"></amp-img>
                            <h3>Raj Kumar N</h3>
                            <h4>Verified Business Owner</h4>
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                I have hired three people from this app for two days as a trial. To my shock it worked great without
                                any long term hassles.
                                Their customer support team always responded under 10 seconds. Hoping to use in future also.
                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>


    <!-- ======= Categories Section ======= -->
    <section id="categories" class="categories">

        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>CATEGORIES</h2>
                <p id="category-title">Browse Categories</p>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="margin-bottom:30px;">Single Move Category</h4>
                                <div class="chip chip-md success-color white-text  example z-depth-2 mr-0"><i class="fas fa-bolt "></i>
                                    &nbsp;&nbsp;Home Appliances Repair
                                </div>
                                <div class="chip chip-md default-color white-text example z-depth-2  mr-0"><i class="fas fa-snowflake fa-lg"></i>
                                    &nbsp;&nbsp;AC Repairs
                                </div>

                                <div class="chip chip-md secondary-color white-text example z-depth-2 mr-0"><i class="fas fa-fan fa-lg"></i>
                                    &nbsp;&nbsp;Washing Machine Repair
                                </div>

                                <!-- <div class="chip chip-md red lighten-1 white-text example z-depth-2 mr-0"><i
                  class="fas fa-gavel fa-lg"></i>
                &nbsp;&nbsp;Handyman
              </div> -->
                                <div class="chip chip-md blue lighten-1 white-text example z-depth-2 mr-0"><i class="fas fa-paint-roller fa-lg"></i>
                                    &nbsp;&nbsp;House Painting
                                </div>
                                <div class="chip chip-md indigo darken-1 white-text example z-depth-2  mr-0"><i class="fas fa-home fa-lg"></i>
                                    &nbsp;&nbsp;House Cleaning
                                </div>
                                <div class="chip chip-md purple-gradient white-text example z-depth-2 mr-0"><i class="fas fa-toilet-paper fa-lg"></i>
                                    &nbsp;&nbsp;Bathroom Cleaning
                                </div>
                                <div class="chip chip-md success-color white-text  example z-depth-2 mr-0"><i class="fas fa-spray-can "></i>
                                    &nbsp;&nbsp;Pest Control
                                </div>
                                <div class="chip chip-md default-color white-text example z-depth-2 mr-0"><i class="fas fa-fire-extinguisher fa-lg"></i>
                                    &nbsp;&nbsp;Disinfectant Spraying
                                </div>

                                <div class="chip chip-md  secondary-color white-text example z-depth-2 mr-0"><i class="fas fa-magic fa-lg"></i>
                                    &nbsp;&nbsp;Beauty Services
                                </div>

                                <div class="chip chip-md red lighten-1 white-text example z-depth-2 mr-0"><i class="fas fa-car-alt fa-lg"></i>
                                    &nbsp;&nbsp;Car Repairs
                                </div>
                                <div class="chip chip-md blue lighten-1 white-text example z-depth-2 mr-0"><i class="fas fa-motorcycle fa-lg"></i>
                                    &nbsp;&nbsp;Motor Cycle Repairs
                                </div>
                                <div class="chip chip-md indigo darken-1 white-text example z-depth-2 mr-0"><i class="fas fa-puzzle-piece fa-lg"></i>
                                    &nbsp;&nbsp;Temp Staffing
                                </div>
                                <!-- <div class="chip chip-md purple-gradient white-text example z-depth-2 mr-0"><i
                  class="fas fa-screwdriver fa-lg"></i>
                &nbsp;&nbsp;Gas Stove Repairs
              </div> -->
                                <div class="chip chip-md success-color white-text  example z-depth-2 mr-0"><i class="fas fa-tools "></i>
                                    &nbsp;&nbsp;Wooden Works
                                </div>
                                <div class="chip chip-md default-color white-text example z-depth-2 mr-0"><i class="fas fa-toolbox fa-lg"></i>
                                    &nbsp;&nbsp;Metal Works
                                </div>

                                <!-- <div class="chip chip-md  secondary-color white-text example z-depth-2 mr-0"><i
                  class="fas fa-film fa-lg"></i>
                &nbsp;&nbsp;Black Filming
              </div> -->

                                <div class="chip chip-md red lighten-1 white-text example z-depth-2 mr-0"><i class="fas fa-faucet fa-lg"></i>
                                    &nbsp;&nbsp;Plumbing
                                </div>
                                <!-- <div class="chip chip-md blue lighten-1 white-text example z-depth-2 mr-0"><i
                  class="fas fa-mitten fa-lg"></i>
                &nbsp;&nbsp;House Maid
              </div> -->
                                <div class="chip chip-md indigo darken-1 white-text example z-depth-2 mr-0"><i class="fas fa-graduation-cap fa-lg"></i>
                                    &nbsp;&nbsp;Home Tuitions
                                </div>
                                <div class="chip chip-md purple-gradient white-text example z-depth-2 mr-0"><i class="fas fa-plus-circle fa-lg"></i>
                                    &nbsp;&nbsp;Many More
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Blue Collar -->
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="margin-bottom:30px;">Blue Collar Category</h4>
                                <div class="chip chip-md success-color white-text  example z-depth-2 mr-0"><i class="fas fa-globe "></i>
                                    &nbsp;&nbsp;Web Design
                                </div>
                                <div class="chip chip-md default-color white-text example z-depth-2  mr-0"><i class="fab fa-react fa-lg"></i>
                                    &nbsp;&nbsp;React
                                </div>

                                <div class="chip chip-md secondary-color white-text example z-depth-2 mr-0"><i class="fab fa-node-js fa-lg"></i>
                                    &nbsp;&nbsp;NodeJS
                                </div>

                                <div class="chip chip-md red lighten-1 white-text example z-depth-2 mr-0"><i class="fab fa-angular fa-lg"></i>
                                    &nbsp;&nbsp;Angular
                                </div>
                                <div class="chip chip-md blue lighten-1 white-text example z-depth-2 mr-0"><i class="fab fa-android fa-lg"></i>
                                    &nbsp;&nbsp;Android App
                                </div>
                                <div class="chip chip-md indigo darken-1 white-text example z-depth-2  mr-0"><i class="fab fa-apple fa-lg"></i>
                                    &nbsp;&nbsp;IOS App
                                </div>
                                <div class="chip chip-md purple-gradient white-text example z-depth-2 mr-0"><i class="fab fa-app-store fa-lg"></i>
                                    &nbsp;&nbsp;Flutter App
                                </div>
                                <div class="chip chip-md success-color white-text  example z-depth-2 mr-0"><i class="fas fa-keyboard "></i>
                                    &nbsp;&nbsp;Data Entry
                                </div>
                                <div class="chip chip-md default-color white-text example z-depth-2 mr-0"><i class="fas fa-headset fa-lg"></i>
                                    &nbsp;&nbsp;Virtual Asst
                                </div>

                                <div class="chip chip-md  secondary-color white-text example z-depth-2 mr-0"><i class="fas fa-file-contract fa-lg"></i>
                                    &nbsp;&nbsp;Legal Advisory
                                </div>

                                <div class="chip chip-md red lighten-1 white-text example z-depth-2 mr-0"><i class="fas fa-calculator fa-lg"></i>
                                    &nbsp;&nbsp;Auditing
                                </div>
                                <div class="chip chip-md blue lighten-1 white-text example z-depth-2 mr-0"><i class="fas fa-bullhorn fa-lg"></i>
                                    &nbsp;&nbsp;Marketing
                                </div>
                                <div class="chip chip-md indigo darken-1 white-text example z-depth-2 mr-0"><i class="fas fa-pen-nib fa-lg"></i>
                                    &nbsp;&nbsp;Content Writing
                                </div>
                                <div class="chip chip-md purple-gradient white-text example z-depth-2 mr-0"><i class="fas fa-copy fa-lg"></i>
                                    &nbsp;&nbsp;Copy writing
                                </div>
                                <div class="chip chip-md success-color white-text  example z-depth-2 mr-0"><i class="fas fa-database "></i>
                                    &nbsp;&nbsp;Big data
                                </div>
                                <div class="chip chip-md default-color white-text example z-depth-2 mr-0"><i class="fab fa-aws fa-lg"></i>
                                    &nbsp;&nbsp;AWS Devops
                                </div>

                                <div class="chip chip-md  secondary-color white-text example z-depth-2 mr-0"><i class="fab fa-google fa-lg"></i>
                                    &nbsp;&nbsp;Google Cloud Devops
                                </div>

                                <div class="chip chip-md red lighten-1 white-text example z-depth-2 mr-0"><i class="fas fa-laptop-code fa-lg"></i>
                                    &nbsp;&nbsp;Software
                                </div>
                                <div class="chip chip-md blue lighten-1 white-text example z-depth-2 mr-0"><i class="fas fa-chart-line fa-lg"></i>
                                    &nbsp;&nbsp;Data Analytics
                                </div>
                                <div class="chip chip-md indigo darken-1 white-text example z-depth-2 mr-0"><i class="fas fa-drafting-compass fa-lg"></i>
                                    &nbsp;&nbsp;Poster & Logo Designing
                                </div>
                                <div class="chip chip-md purple-gradient white-text example z-depth-2 mr-0"><i class="fas fa-plus-circle fa-lg"></i>
                                    &nbsp;&nbsp;Many More
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Multi Move -->

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="margin-bottom:30px;">Multi Move Category</h4>
                                <div class="chip chip-md success-color white-text  example z-depth-2 mr-0"><i class="fas fa-birthday-cake "></i>
                                    &nbsp;&nbsp;Food Delivery
                                </div>
                                <div class="chip chip-md default-color white-text example z-depth-2  mr-0"><i class="fas fa-cart-plus fa-lg"></i>
                                    &nbsp;&nbsp;Grocery Delivery
                                </div>

                                <div class="chip chip-md secondary-color white-text example z-depth-2 mr-0"><i class="fas fa-taxi fa-lg"></i>
                                    &nbsp;&nbsp;Taxi Service
                                </div>

                                <div class="chip chip-md red lighten-1 white-text example z-depth-2 mr-0"><i class="fas fa-drumstick-bite fa-lg"></i>
                                    &nbsp;&nbsp;Chicken Delivery
                                </div>
                                <div class="chip chip-md blue lighten-1 white-text example z-depth-2 mr-0"><i class="fas fa-fish fa-lg"></i>
                                    &nbsp;&nbsp;Fish Delivery
                                </div>
                                <div class="chip chip-md indigo darken-1 white-text example z-depth-2  mr-0"><i class="fas fa-bacon fa-lg"></i>
                                    &nbsp;&nbsp;Mutton Delivery
                                </div>
                                <div class="chip chip-md purple-gradient white-text example z-depth-2 mr-0"><i class="fas fa-shipping-fast fa-lg"></i>
                                    &nbsp;&nbsp;Business Deliveries
                                </div>
                                <div class="chip chip-md success-color white-text  example z-depth-2 mr-0"><i class="fas fa-boxes "></i>
                                    &nbsp;&nbsp;Packers & Movers
                                </div>
                                <div class="chip chip-md default-color white-text example z-depth-2 mr-0"><i class="fas fa-motorcycle fa-lg"></i>
                                    &nbsp;&nbsp;Bike Courier
                                </div>

                                <div class="chip chip-md  secondary-color white-text example z-depth-2 mr-0"><i class="fas fa-hands-helping fa-lg"></i>
                                    &nbsp;&nbsp;Helper
                                </div>

                                <div class="chip chip-md purple-gradient white-text example z-depth-2 mr-0"><i class="fas fa-plus-circle fa-lg"></i>
                                    &nbsp;&nbsp;Many More
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </section>
    <!-- End Categories Section -->
    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">

        <div class="container">

            <div class="section-title" data-aos="fade-up">
                <h2>Pricing</h2>
                <p>Check our Pricing</p>
            </div>

            <div class="d-flex carousel-nav">
                <a href="#" class="col active">
                    <h5>Users</h5>
                </a>
                <a href="#" class="col">
                    <h5>Service Providers</h5>
                </a>
                <a href="#" class="col">
                    <h5>Businesses</h5>
                </a>
            </div>


            <div class="owl-carousel owl-1">

                <!-- Users Plan Nav -->
                <div class="media-29101 d-md-flex w-100" style="margin-top:30px">


                    <div class="col-lg-3 col-md-6">
                        <div class="box" data-aos="zoom-in" data-aos-delay="100">
                            <h3>Free</h3>
                            <h4><sup>₹</sup>0<span> / month</span></h4>
                            <ul>
                                <li>Unlimited Hiring</li>
                                <li>10 Posts per month</li>
                                <li>5 responses per Post</li>
                                <li>24/7 Customer Support</li>
                                <li class="na">Dedicated Monitoring</li>
                                <li class="na">Ensuring Timely Completion</li>
                                <li class="na">Dedicated Customer Support</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="https://play.google.com/store/apps/details?id=com.satrango" class="btn-buy">Download App</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" style="margin-left:50px">
                        <div class="box featured" data-aos="zoom-in" data-aos-delay="100">
                            <h3>Regular</h3>
                            <h4><sup>₹</sup>99<span> / month</span></h4>
                            <ul>
                                <li>Unlimited Hiring</li>
                                <li>25 Posts per month</li>
                                <li>15 responses per Post</li>
                                <li>24/7 Customer Support</li>
                                <li>Dedicated Monitoring</li>
                                <li>Ensuring Timely Completion</li>
                                <li class="na">Dedicated Customer Support</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="https://play.google.com/store/apps/details?id=com.satrango" class="btn-buy">Download App</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" style="margin-left:50px">
                        <div class="box" data-aos="zoom-in" data-aos-delay="100">
                            <span class="advanced">Advanced</span>
                            <h3>Value Plan</h3>
                            <h4><sup>₹</sup>149<span> / month</span></h4>
                            <ul>
                                <li>Unlimited Hiring</li>
                                <li>Unlimted Posts per month</li>
                                <li>Unlimited responses per Post</li>
                                <li>24/7 Customer Support</li>
                                <li>Dedicated Customer Support</li>
                                <li>Ensuring Timely Completion</li>
                                <li>Dedicated Monitoring</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="https://play.google.com/store/apps/details?id=com.satrango" class="btn-buy">Download App</a>
                            </div>
                        </div>
                    </div>
                </div> <!-- .item -->

                <!-- Service Providers Plan Nav -->

                <div class="media-29101 d-md-flex w-100" style="margin-top:30px">

                    <div class="col-lg-3 col-md-6">
                        <div class="box" data-aos="zoom-in" data-aos-delay="100">
                            <h3>Free</h3>
                            <h4><sup>₹</sup>0<span> / month</span></h4>
                            <ul>
                                <li>25 Bids Per Month</li>
                                <li>Individual Profile Page</li>
                                <li>Remote Monitoring</li>
                                <li>Mentoring by Professionals</li>
                                <li>24/7 Customer Support</li>
                                <li class="na">Sealed Bids</li>
                                <li class="na">Dedicated Customer Support</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="https://play.google.com/store/apps/details?id=com.satrango" class="btn-buy">Download App</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" style="margin-left:50px">
                        <div class="box featured" data-aos="zoom-in" data-aos-delay="100">
                            <h3>Regular</h3>
                            <h4><sup>₹</sup>149<span> / month</span></h4>
                            <ul>
                                <li>50 Bids Per Month</li>
                                <li>Individual Profile Page</li>
                                <li>Remote Monitoring</li>
                                <li>Mentoring by Professionals</li>
                                <li>24/7 Customer Support</li>
                                <li>Sealed Bids</li>
                                <li class="na">Dedicated Customer Support</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="https://play.google.com/store/apps/details?id=com.satrango" class="btn-buy">Download App</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" style="margin-left:50px">
                        <div class="box" data-aos="zoom-in" data-aos-delay="100">
                            <span class="advanced">Advanced</span>
                            <h3>Value Plan</h3>
                            <h4><sup>₹</sup>199<span> / month</span></h4>
                            <ul>
                                <li>Unlimited Bids Per Month</li>
                                <li>Individual Profile Page</li>
                                <li>Remote Monitoring</li>
                                <li>Mentoring by Professionals</li>
                                <li>24/7 Customer Support</li>
                                <li>Sealed Bids</li>
                                <li>Dedicated Customer Support</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="https://play.google.com/store/apps/details?id=com.satrango" class="btn-buy">Download App</a>
                            </div>
                        </div>
                    </div>
                </div> <!-- .item -->


                <!-- Service Providers Plan Nav -->

                <div class="media-29101 d-md-flex w-100" style="margin-top:30px">

                    <div class="col-lg-3 col-md-6">
                        <div class="box featured" data-aos="zoom-in" data-aos-delay="100">
                            <h3>Contact us</h3>
                            <h4><sup>₹</sup>Price<span> / month</span></h4>
                            <ul>
                                <li>Unlimited Bids Per Month</li>
                                <li>Admin Dashboard</li>
                                <li>10-100 Provider Accounts</li>
                                <li>API Support</li>
                                <li>Dedicated Monitoring 24/7</li>
                                <li>Mentoring by Professionals</li>
                                <li>Sealed Bids</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="https://play.google.com/store/apps/details?id=com.satrango" class="btn-buy">Download App</a>
                            </div>
                        </div>
                   </div>

                   <div class="col-lg-3 col-md-6" style="margin-left:50px">
                        <div class="box" data-aos="zoom-in" data-aos-delay="100">
                        <span class="advanced">Value Pack</span>
                            <h3>Bids Pack</h3>
                            <h4><sup>₹</sup>200<span> / Pack</span></h4>
                            <ul>
                                <li>100 Bids</li>
                                <li>Validity - 30 days</li>
                                <li class="na">Other Features</li>
                                <li class="na">Special Discounts</li>
                                <li class="na">Extended Support</li>
                                <li class="na">Sealed Bids</li>
                                <li class="na">Dedicated Support</li>

                            </ul>
                            <div class="btn-wrap">
                                <a href="https://play.google.com/store/apps/details?id=com.satrango" class="btn-buy">Download App</a>
                            </div>
                        </div>
                   </div>

                </div> <!-- .item -->

            </div>
        </div>
    </section>
    <!-- End Pricing Section -->


    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container">

            <div class="section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Contact Us</p>
            </div>

            <div class="row">

                <div class="col-lg-4" data-aos="fade-right" data-aos-delay="100">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Location:</h4>
                            <p>Bharathi Nagar 14th Line, Vijayawada</p>
                            <p>Andhra Pradesh, IN 520008</p>
                        </div>

                        <div class="email">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p>support@satrango.com</p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Call:</h4>
                            <p>+91 81-0038-0039</p>
                        </div>

                    </div>

                </div>

                <div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="200">

                    <form id="contact" action="<?php echo base_url(); ?>/contact" method="post" role="form" class="php-email-form">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Message" required></textarea>
                        </div>
                        <!-- <div class="my-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your message has been sent. Thank you!</div>
          </div> -->
                        <div class="text-center"><button type="submit">Send Message</button></div>
                    </form>

                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->

<?php $this->endSection() ?>



<?php $this->section('script') ?>

<!-- Contact Form Script will go here -->
<script>
    $("form#contact").submit(function() {
        name = $("#name").val();
        email = $("#email").val();
        subject = $("#subject").val();
        message = $("#message").val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/contact' ?>",
            data: {
                name: name,
                email: email,
                subject: subject,
                message: message
            },
            dataType: 'json',
            encode: true
        }).done(function(data) {
            console.log(data);
        });
        event.preventDefault();

        // clearing pre filled values
        $('#name').val("");
        $('#email').val("");
        $('#subject').val("");
        $('#message').val("");

        Swal.fire(
            'Thank You!',
            'You will hear from us Soon!',
            'success'
        )

    });
</script>

<?php $this->endSection() ?>