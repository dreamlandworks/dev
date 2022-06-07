<?php $this->extend('Modules\User\Views\home') ?>


<?php $this->section('title') ?>

FAQs (User)

<?php $this->endsection() ?>


<?php $this->section('styles') ?>
<!-- Styles will go here -->

<?php $this->endsection() ?>



<?php $this->section('content') ?>

<main id="main">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>FAQs (User)</h2>
                <ol>
                    <li><a href="<?php echo base_url(); ?>#hero">Home</a></li>
                    <li>FAQ-Users</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs Section -->

    <section id="faq" class="faq section-bg">
        <div class="container">

            <div class="section-title" data-aos="fade-up">
                <h2>F.A.Q</h2>
                <p>Frequently Asked Questions</p>
            </div>

            <div class="faq-list">
                <ul>
                    <?php
                    $i = 1;
                    foreach ($res as $r) {

                    ?>

                        <li data-aos="fade-up" <?php echo ($i == 1 ? "" : "data-aos-delay='100'"); ?>>
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="<?php echo ($i == 1 ? "collapse" : "collapsed"); ?>" data-bs-target="#faq-list-<?php echo $i; ?>">
                                <?php echo $r['question']; ?>
                                <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-<?php echo $i; ?>" class="<?php echo ($i == 1 ? "collapse show" : "collapse"); ?>" data-bs-parent=" .faq-list">
                                <p>
                                    <?php echo $r['answer']; ?>
                                </p>
                            </div>
                        </li>

                    <?php
                        $i++;
                    }

                    ?>

                </ul>
            </div>

        </div>
    </section>

</main>
<!-- End #main -->

<?php $this->endsection() ?>


<?php $this->section('script') ?>


<?php $this->endsection() ?>