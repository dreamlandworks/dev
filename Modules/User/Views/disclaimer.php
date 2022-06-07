<?php $this->extend('Modules\User\Views\home') ?>


<?php $this->section('title') ?>

Disclaimer

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
                <h2>Disclaimer</h2>
                <ol>
                    <li><a href="<?php echo base_url(); ?>#hero">Home</a></li>
                    <li>Disclaimer</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page">

        <div class="container">

            <p class="p-text-justify">The information contained in this website is for general information purposes only. The information is provided by Squill.in,
                Squill Android App and Squill IOS App, a property of Satrango Private Limited. While we endeavor to keep the information up to date and correct,
                we make no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability or availability
                with respect to the website or the information, products, services, or related graphics contained on the website for any purpose. Any reliance you place
                on such information is therefore strictly at your own risk.</p>
            <p class="p-text-justify">In no event will we be liable for any loss or damage including without limitation, indirect or consequential loss or damage, or any loss or
                damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this website. Through this website you are able to link
                to other websites which are not under the control of Satrango Pvt Ltd. We have no control over the nature, content and availability of those sites. The inclusion
                of any links does not necessarily imply a recommendation or endorse the views expressed within them. Every effort is made to keep the website up and running smoothly.
                However, Satrango Pvt Ltd takes no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control.
            </p>

        </div>
    </section>

</main>
<!-- End #main -->

<?php $this->endsection() ?>


<?php $this->section('script') ?>


<?php $this->endsection() ?>